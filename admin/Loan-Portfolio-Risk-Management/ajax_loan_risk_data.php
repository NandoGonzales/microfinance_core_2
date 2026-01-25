<?php
header('Content-Type: application/json');

// =======================
// 1. FETCH API DATA
// =======================
$apiUrl = "https://your-api-url/loans"; // <-- CHANGE THIS
$response = file_get_contents($apiUrl);

if (!$response) {
    echo json_encode(["error" => "Failed to fetch API"]);
    exit;
}

$apiData = json_decode($response, true);
$loansRaw = $apiData['data'] ?? [];

// =======================
// 2. PAGINATION INPUT
// =======================
$page  = max(1, intval($_GET['page'] ?? 1));
$limit = max(1, intval($_GET['limit'] ?? 10));
$offset = ($page - 1) * $limit;

// =======================
// 3. TRANSFORM DATA
// =======================
$loans = [];
$loanTypes = [];
$statusCount = [];
$riskCount = ["Low" => 0, "Medium" => 0, "High" => 0];

foreach ($loansRaw as $l) {

    // ---- Risk logic (example only)
    if ($l['loan_term'] > 6) {
        $risk = "High";
    } elseif ($l['loan_term'] >= 3) {
        $risk = "Medium";
    } else {
        $risk = "Low";
    }

    $status = ucfirst($l['status']);

    $loans[] = [
        "loan_id" => $l['id'],
        "member_name" => "Client #" . $l['client_id'], // replace later with real join
        "loan_type" => $l['loan_type'],
        "principal_amount" => $l['loan_amount'],
        "interest_rate" => $l['interest_rate'],
        "loan_term" => $l['loan_term'],
        "start_date" => $l['disbursement_date'],
        "end_date" => null,
        "status" => $status,
        "overdue_count" => 0,
        "risk_level" => $risk,
        "next_due" => null
    ];

    $loanTypes[] = $l['loan_type'];
    $statusCount[$status] = ($statusCount[$status] ?? 0) + 1;
    $riskCount[$risk]++;
}

// =======================
// 4. PAGINATE RESULTS
// =======================
$totalRecords = count($loans);
$totalPages = ceil($totalRecords / $limit);
$loansPage = array_slice($loans, $offset, $limit);

// =======================
// 5. RESPONSE
// =======================
echo json_encode([
    "summary" => [
        "total_loans" => $totalRecords,
        "active_loans" => $statusCount['Approved'] ?? 0,
        "overdue_loans" => 0,
        "defaulted_loans" => $statusCount['Defaulted'] ?? 0
    ],
    "loan_status" => [
        "labels" => array_keys($statusCount),
        "values" => array_values($statusCount)
    ],
    "risk_breakdown" => [
        "labels" => array_keys($riskCount),
        "values" => array_values($riskCount)
    ],
    "loan_types" => array_values(array_unique($loanTypes)),
    "loans" => $loansPage,
    "pagination" => [
        "current_page" => $page,
        "total_pages" => $totalPages,
        "total_records" => $totalRecords
    ]
]);