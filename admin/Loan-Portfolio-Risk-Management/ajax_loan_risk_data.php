<?php
require_once(__DIR__ . '/../../initialize_coreT2.php');
header('Content-Type: application/json; charset=utf-8');

// --- Get Parameters with Validation ---
$page       = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit      = isset($_GET['limit']) ? max(1, min(100, intval($_GET['limit']))) : 10;
$search     = isset($_GET['search']) ? trim($_GET['search']) : '';
$status     = isset($_GET['status']) ? trim($_GET['status']) : '';
$risk       = isset($_GET['risk']) ? trim($_GET['risk']) : '';
$type       = isset($_GET['type']) ? trim($_GET['type']) : '';
$cardFilter = isset($_GET['cardFilter']) ? trim($_GET['cardFilter']) : 'all'; // NEW: Card filter
$offset     = ($page - 1) * $limit;

$response = [
    'summary' => ['total_loans' => 0, 'active_loans' => 0, 'overdue_loans' => 0, 'defaulted_loans' => 0],
    'loan_status' => ['labels' => [], 'values' => []],
    'risk_breakdown' => ['labels' => [], 'values' => []],
    'loans' => [],
    'loan_types' => [],
    'pagination' => ['current_page' => $page, 'total_pages' => 1, 'limit' => $limit, 'total_records' => 0]
];

try {
    // --- SUMMARY (SECURE) ---
    $stmt = $conn->prepare("SELECT COUNT(*) AS c FROM loan_portfolio");
    $stmt->execute();
    $response['summary']['total_loans'] = (int)$stmt->get_result()->fetch_assoc()['c'];
    $stmt->close();

    $stmt = $conn->prepare("SELECT COUNT(*) AS c FROM loan_portfolio WHERE status='Active'");
    $stmt->execute();
    $response['summary']['active_loans'] = (int)$stmt->get_result()->fetch_assoc()['c'];
    $stmt->close();

    $stmt = $conn->prepare("SELECT COUNT(*) AS c FROM loan_portfolio WHERE status='Defaulted'");
    $stmt->execute();
    $response['summary']['defaulted_loans'] = (int)$stmt->get_result()->fetch_assoc()['c'];
    $stmt->close();

    $stmt = $conn->prepare("
        SELECT COUNT(DISTINCT l.loan_id) AS c
        FROM loan_portfolio l
        JOIN loan_schedule s ON s.loan_id = l.loan_id
        WHERE s.status='Overdue' OR (s.due_date<CURDATE() AND s.amount_paid < s.amount_due)
    ");
    $stmt->execute();
    $response['summary']['overdue_loans'] = (int)$stmt->get_result()->fetch_assoc()['c'];
    $stmt->close();

    // --- STATUS DISTRIBUTION (SECURE) ---
    $stmt = $conn->prepare("SELECT status, COUNT(*) AS total FROM loan_portfolio GROUP BY status");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $response['loan_status']['labels'][] = $row['status'];
        $response['loan_status']['values'][] = (int)$row['total'];
    }
    $stmt->close();

    // --- GET LOAN TYPES (SECURE) ---
    $stmt = $conn->prepare("SELECT DISTINCT loan_type FROM loan_portfolio WHERE loan_type IS NOT NULL ORDER BY loan_type");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $response['loan_types'][] = $row['loan_type'];
    }
    $stmt->close();

    // --- BUILD FILTER QUERY ---
    $where_conditions = [];
    $params = [];
    $types = '';

    // === CARD FILTER LOGIC ===
    if ($cardFilter === 'active') {
        $where_conditions[] = "l.status = 'Active'";
    } elseif ($cardFilter === 'overdue') {
        $where_conditions[] = "EXISTS (
        SELECT 1 FROM loan_schedule ls 
        WHERE ls.loan_id = l.loan_id 
        AND (ls.status = 'Overdue' 
             OR (ls.due_date < CURDATE() 
                 AND ls.amount_paid < ls.amount_due))
    )";
    } elseif ($cardFilter === 'defaulted') {
        $where_conditions[] = "l.status = 'Defaulted'";
    }

    if ($search !== '') {
        $where_conditions[] = "(l.loan_id LIKE ? OR m.full_name LIKE ? OR l.loan_type LIKE ?)";
        $search_param = "%{$search}%";
        $params[] = $search_param;
        $params[] = $search_param;
        $params[] = $search_param;
        $types .= 'sss';
    }

    if ($status !== '') {
        $where_conditions[] = "l.status = ?";
        $params[] = $status;
        $types .= 's';
    }

    if ($type !== '') {
        $where_conditions[] = "l.loan_type = ?";
        $params[] = $type;
        $types .= 's';
    }

    $where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

    // --- COUNT TOTAL FILTERED RECORDS ---
    $count_sql = "
        SELECT COUNT(*) AS total
        FROM loan_portfolio l
        LEFT JOIN members m ON m.member_id = l.member_id
        $where_clause
    ";

    if ($types) {
        $stmt = $conn->prepare($count_sql);
        $stmt->bind_param($types, ...$params);
    } else {
        $stmt = $conn->prepare($count_sql);
    }

    $stmt->execute();
    $total_filtered = (int)$stmt->get_result()->fetch_assoc()['total'];
    $stmt->close();

    $total_pages = max(1, ceil($total_filtered / $limit));
    $response['pagination']['total_pages'] = $total_pages;
    $response['pagination']['total_records'] = $total_filtered;

    // --- RISK BREAKDOWN INIT ---
    $risk_counts = ['Low' => 0, 'Medium' => 0, 'High' => 0];

    // --- FETCH LOANS WITH ALL FILTERS (SECURE) ---
    $fetch_sql = "
        SELECT l.*, COALESCE(m.full_name,'Unknown') AS member_name
        FROM loan_portfolio l
        LEFT JOIN members m ON m.member_id=l.member_id
        $where_clause
        ORDER BY l.loan_id DESC
        LIMIT ? OFFSET ?
    ";

    if ($types) {
        $stmt = $conn->prepare($fetch_sql);
        $bind_types = $types . 'ii';
        $bind_params = array_merge($params, [$limit, $offset]);
        $stmt->bind_param($bind_types, ...$bind_params);
    } else {
        $stmt = $conn->prepare($fetch_sql);
        $stmt->bind_param('ii', $limit, $offset);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    while ($loan = $result->fetch_assoc()) {
        $loan_id = (int)$loan['loan_id'];

        // --- OVERDUE COUNT (SECURE) ---
        $stmt2 = $conn->prepare("
            SELECT COUNT(*) AS overdue_count
            FROM loan_schedule
            WHERE loan_id=? AND (status='Overdue' OR (due_date<CURDATE() AND amount_paid < amount_due))
        ");
        $stmt2->bind_param("i", $loan_id);
        $stmt2->execute();
        $overdue_count = (int)$stmt2->get_result()->fetch_assoc()['overdue_count'];
        $stmt2->close();

        // --- NEXT DUE DATE (SECURE) ---
        $stmt2 = $conn->prepare("
            SELECT due_date
            FROM loan_schedule
            WHERE loan_id=? AND status<>'Paid'
            ORDER BY due_date ASC LIMIT 1
        ");
        $stmt2->bind_param("i", $loan_id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $next_due_row = $result2->fetch_assoc();
        $next_due = $next_due_row ? date('d M Y', strtotime($next_due_row['due_date'])) : '-';
        $stmt2->close();

        // --- RISK LEVEL ---
        $risk_level = 'Low';
        if ($loan['status'] === 'Defaulted' || $overdue_count >= 2) $risk_level = 'High';
        else if ($overdue_count === 1) $risk_level = 'Medium';
        $risk_counts[$risk_level]++;

        // Apply risk filter (dropdown)
        if ($risk !== '' && $risk_level !== $risk) {
            continue;
        }

        // --- FORMAT DATES ---
        $end_date = $loan['end_date'] ? date('d M Y', strtotime($loan['end_date'])) : '-';
        $start_date = $loan['start_date'] ? date('d M Y', strtotime($loan['start_date'])) : '-';

        $response['loans'][] = [
            'loan_id'          => $loan_id,
            'member_id'        => (int)$loan['member_id'],
            'member_name'      => htmlspecialchars($loan['member_name'], ENT_QUOTES, 'UTF-8'),
            'loan_type'        => htmlspecialchars($loan['loan_type'], ENT_QUOTES, 'UTF-8'),
            'principal_amount' => (float)$loan['principal_amount'],
            'interest_rate'    => (float)$loan['interest_rate'],
            'loan_term'        => (int)$loan['loan_term'],
            'start_date'       => $start_date,
            'end_date'         => $end_date,
            'status'           => $loan['status'],
            'overdue_count'    => $overdue_count,
            'risk_level'       => $risk_level,
            'next_due'         => $next_due
        ];
    }
    $stmt->close();

    $response['risk_breakdown']['labels'] = array_keys($risk_counts);
    $response['risk_breakdown']['values'] = array_values($risk_counts);

    echo json_encode($response);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred', 'message' => $e->getMessage()]);
    error_log('Loan Risk Data Error: ' . $e->getMessage());
    exit;
}

