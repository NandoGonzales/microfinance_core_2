<?php
require_once(__DIR__ . '/../../initialize_coreT2.php');
header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=coret2_db;charset=utf8mb4",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );

    // Get parameters
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 10;
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $statusFilter = isset($_GET['status']) ? trim($_GET['status']) : '';
    $riskFilter = isset($_GET['risk']) ? trim($_GET['risk']) : '';
    $typeFilter = isset($_GET['type']) ? trim($_GET['type']) : '';
    $cardFilter = isset($_GET['cardFilter']) ? trim($_GET['cardFilter']) : 'all';

    $offset = ($page - 1) * $limit;

    // --- SUMMARY CARDS ---
    $summary = [
        'total_loans' => (int)$pdo->query("SELECT COUNT(*) FROM loan_portfolio")->fetchColumn(),
        'active_loans' => (int)$pdo->query("SELECT COUNT(*) FROM loan_portfolio WHERE status='Active'")->fetchColumn(),
        'overdue_loans' => 0,
        'at_risk_loans' => 0
    ];

    // Calculate overdue loans
    $overdueQuery = $pdo->query("
        SELECT COUNT(DISTINCT lp.loan_id) 
        FROM loan_portfolio lp 
        INNER JOIN loan_schedule ls ON lp.loan_id = ls.loan_id 
        WHERE ls.status = 'Overdue'
    ");
    $summary['overdue_loans'] = (int)$overdueQuery->fetchColumn();

    // Calculate at-risk loans (3+ overdue payments or defaulted)
    $atRiskQuery = $pdo->query("
        SELECT COUNT(DISTINCT lp.loan_id)
        FROM loan_portfolio lp
        WHERE lp.status = 'Defaulted' OR (
            SELECT COUNT(*) 
            FROM loan_schedule ls 
            WHERE ls.loan_id = lp.loan_id AND ls.status = 'Overdue'
        ) >= 3
    ");
    $summary['at_risk_loans'] = (int)$atRiskQuery->fetchColumn();

    // --- LOAN STATUS DISTRIBUTION ---
    $statusData = ['labels' => [], 'values' => []];
    $statusQuery = $pdo->query("
        SELECT status, COUNT(*) as cnt 
        FROM loan_portfolio 
        WHERE status IS NOT NULL
        GROUP BY status
        ORDER BY 
            CASE 
                WHEN status = 'Active' THEN 1
                WHEN status = 'Pending' THEN 2
                WHEN status = 'Approved' THEN 3
                WHEN status = 'Completed' THEN 4
                WHEN status = 'Defaulted' THEN 5
                ELSE 6
            END
    ");
    foreach ($statusQuery as $row) {
        $statusData['labels'][] = $row['status'];
        $statusData['values'][] = (int)$row['cnt'];
    }

    // --- RISK BREAKDOWN ---
    $riskData = ['labels' => ['Low', 'Medium', 'High'], 'values' => [0, 0, 0]];

    // Low risk: Active/Approved loans with 0 overdue
    $lowRiskQuery = $pdo->query("
        SELECT COUNT(DISTINCT lp.loan_id)
        FROM loan_portfolio lp
        WHERE lp.status IN ('Active', 'Approved')
        AND (
            SELECT COUNT(*) 
            FROM loan_schedule ls 
            WHERE ls.loan_id = lp.loan_id AND ls.status = 'Overdue'
        ) = 0
    ");
    $riskData['values'][0] = (int)$lowRiskQuery->fetchColumn();

    // Medium risk: 1-2 overdue payments
    $mediumRiskQuery = $pdo->query("
        SELECT COUNT(DISTINCT lp.loan_id)
        FROM loan_portfolio lp
        WHERE lp.status IN ('Active', 'Approved')
        AND (
            SELECT COUNT(*) 
            FROM loan_schedule ls 
            WHERE ls.loan_id = lp.loan_id AND ls.status = 'Overdue'
        ) BETWEEN 1 AND 2
    ");
    $riskData['values'][1] = (int)$mediumRiskQuery->fetchColumn();

    // High risk: 3+ overdue or Defaulted
    $highRiskQuery = $pdo->query("
        SELECT COUNT(DISTINCT lp.loan_id)
        FROM loan_portfolio lp
        WHERE lp.status = 'Defaulted' OR (
            lp.status IN ('Active', 'Approved')
            AND (
                SELECT COUNT(*) 
                FROM loan_schedule ls 
                WHERE ls.loan_id = lp.loan_id AND ls.status = 'Overdue'
            ) >= 3
        )
    ");
    $riskData['values'][2] = (int)$highRiskQuery->fetchColumn();

    // --- GET LOAN TYPES ---
    $loanTypes = [];
    $typeQuery = $pdo->query("
        SELECT DISTINCT loan_type 
        FROM loan_portfolio 
        WHERE loan_type IS NOT NULL 
        ORDER BY loan_type
    ");
    foreach ($typeQuery as $row) {
        $loanTypes[] = $row['loan_type'];
    }

    // --- BUILD WHERE CLAUSES FOR FILTERING ---
    $whereClauses = [];
    $params = [];

    // Search filter
    if ($search !== '') {
        $whereClauses[] = "(lp.loan_id LIKE :search OR m.full_name LIKE :search OR lp.loan_type LIKE :search)";
        $params[':search'] = "%$search%";
    }

    // Status filter
    if ($statusFilter !== '') {
        $whereClauses[] = "lp.status = :status";
        $params[':status'] = $statusFilter;
    }

    // Type filter
    if ($typeFilter !== '') {
        $whereClauses[] = "lp.loan_type = :type";
        $params[':type'] = $typeFilter;
    }

    // Risk filter
    if ($riskFilter !== '') {
        if ($riskFilter === 'Low') {
            $whereClauses[] = "overdue_count = 0 AND lp.status IN ('Active', 'Approved')";
        } elseif ($riskFilter === 'Medium') {
            $whereClauses[] = "overdue_count BETWEEN 1 AND 2";
        } elseif ($riskFilter === 'High') {
            $whereClauses[] = "(overdue_count >= 3 OR lp.status = 'Defaulted')";
        }
    }

    // Card filter
    if ($cardFilter !== 'all') {
        if ($cardFilter === 'active') {
            $whereClauses[] = "lp.status = 'Active'";
        } elseif ($cardFilter === 'overdue') {
            $whereClauses[] = "overdue_count > 0";
        } elseif ($cardFilter === 'at_risk') {
            $whereClauses[] = "(overdue_count >= 3 OR lp.status = 'Defaulted')";
        }
    }

    $whereSql = '';
    if (!empty($whereClauses)) {
        $whereSql = 'WHERE ' . implode(' AND ', $whereClauses);
    }

    // --- COUNT TOTAL RECORDS ---
    $countSql = "
        SELECT COUNT(DISTINCT lp.loan_id) 
        FROM loan_portfolio lp
        LEFT JOIN members m ON lp.member_id = m.member_id
        LEFT JOIN (
            SELECT loan_id, COUNT(*) as overdue_count
            FROM loan_schedule 
            WHERE status = 'Overdue'
            GROUP BY loan_id
        ) ls ON lp.loan_id = ls.loan_id
        $whereSql
    ";
    $countStmt = $pdo->prepare($countSql);
    foreach ($params as $k => $v) {
        $countStmt->bindValue($k, $v);
    }
    $countStmt->execute();
    $totalRecords = (int)$countStmt->fetchColumn();
    $totalPages = $totalRecords > 0 ? ceil($totalRecords / $limit) : 1;

    // --- FETCH LOANS ---
    $sql = "
        SELECT 
            lp.loan_id,
            lp.member_id,
            lp.loan_type,
            lp.principal_amount,
            lp.interest_rate,
            lp.loan_term,
            lp.start_date,
            lp.end_date,
            lp.status,
            m.full_name as member_name,
            COALESCE(ls.overdue_count, 0) as overdue_count,
            CASE 
                WHEN lp.status = 'Defaulted' THEN 'High'
                WHEN COALESCE(ls.overdue_count, 0) >= 3 THEN 'High'
                WHEN COALESCE(ls.overdue_count, 0) BETWEEN 1 AND 2 THEN 'Medium'
                ELSE 'Low'
            END as risk_level,
            (
                SELECT MIN(due_date) 
                FROM loan_schedule 
                WHERE loan_id = lp.loan_id 
                AND status = 'Pending' 
                LIMIT 1
            ) as next_due
        FROM loan_portfolio lp
        LEFT JOIN members m ON lp.member_id = m.member_id
        LEFT JOIN (
            SELECT loan_id, COUNT(*) as overdue_count
            FROM loan_schedule 
            WHERE status = 'Overdue'
            GROUP BY loan_id
        ) ls ON lp.loan_id = ls.loan_id
        $whereSql
        ORDER BY lp.loan_id DESC
        LIMIT :offset, :limit
    ";

    $stmt = $pdo->prepare($sql);
    foreach ($params as $k => $v) {
        $stmt->bindValue($k, $v);
    }
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $loans = $stmt->fetchAll();

    // --- GET ALL LOANS FOR PDF EXPORT ---
    $allLoansSql = "
        SELECT 
            lp.loan_id,
            lp.member_id,
            lp.loan_type,
            lp.principal_amount,
            lp.interest_rate,
            lp.loan_term,
            lp.start_date,
            lp.end_date,
            lp.status,
            m.full_name as member_name,
            COALESCE(ls.overdue_count, 0) as overdue_count,
            CASE 
                WHEN lp.status = 'Defaulted' THEN 'High'
                WHEN COALESCE(ls.overdue_count, 0) >= 3 THEN 'High'
                WHEN COALESCE(ls.overdue_count, 0) BETWEEN 1 AND 2 THEN 'Medium'
                ELSE 'Low'
            END as risk_level
        FROM loan_portfolio lp
        LEFT JOIN members m ON lp.member_id = m.member_id
        LEFT JOIN (
            SELECT loan_id, COUNT(*) as overdue_count
            FROM loan_schedule 
            WHERE status = 'Overdue'
            GROUP BY loan_id
        ) ls ON lp.loan_id = ls.loan_id
        ORDER BY lp.loan_id DESC
    ";
    $allLoansStmt = $pdo->query($allLoansSql);
    $allLoans = $allLoansStmt->fetchAll();

    // --- RETURN JSON ---
    echo json_encode([
        'success' => true,
        'summary' => $summary,
        'loan_status' => $statusData,
        'risk_breakdown' => $riskData,
        'loan_types' => $loanTypes,
        'loans' => $loans,
        'all_loans' => $allLoans,
        'pagination' => [
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_records' => $totalRecords
        ]
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}