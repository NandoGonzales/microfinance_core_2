<?php
try {
    // ===============================
    // 1. FETCH API DATA
    // ===============================
    $apiUrl = "https://YOUR_API_URL/loans"; // <-- CHANGE
    $apiResponse = file_get_contents($apiUrl);

    if (!$apiResponse) {
        throw new Exception("Failed to fetch API");
    }

    $apiData = json_decode($apiResponse, true);
    $allLoans = $apiData['data'] ?? [];

    // ===============================
    // 2. FILTER + TRANSFORM
    // ===============================
    $filtered = [];
    $loanTypes = [];
    $statusCounts = [];
    $riskCounts = ['Low' => 0, 'Medium' => 0, 'High' => 0];

    foreach ($allLoans as $l) {

        // ---- CARD FILTER
        if ($cardFilter === 'active' && $l['status'] !== 'approved') continue;
        if ($cardFilter === 'defaulted' && $l['status'] !== 'defaulted') continue;

        // ---- SEARCH
        if ($search !== '') {
            $hay = strtolower($l['loan_code'] . $l['loan_type'] . $l['client_id']);
            if (strpos($hay, strtolower($search)) === false) continue;
        }

        // ---- STATUS FILTER
        if ($status !== '' && strcasecmp($status, $l['status']) !== 0) continue;

        // ---- TYPE FILTER
        if ($type !== '' && $type !== $l['loan_type']) continue;

        // ---- RISK LOGIC
        $risk = 'Low';
        if ($l['loan_term'] >= 12) $risk = 'High';
        elseif ($l['loan_term'] >= 6) $risk = 'Medium';

        if ($risk !== '' && $risk !== $risk) continue;

        // ---- COUNTS
        $loanTypes[] = $l['loan_type'];
        $statusKey = ucfirst($l['status']);
        $statusCounts[$statusKey] = ($statusCounts[$statusKey] ?? 0) + 1;
        $riskCounts[$risk]++;

        // ---- BUILD LOAN
        $filtered[] = [
            'loan_id'          => $l['id'],
            'member_id'        => $l['client_id'],
            'member_name'      => 'Client #' . $l['client_id'],
            'loan_type'        => $l['loan_type'],
            'principal_amount' => (float)$l['loan_amount'],
            'interest_rate'    => (float)$l['interest_rate'],
            'loan_term'        => (int)$l['loan_term'],
            'start_date'       => $l['disbursement_date']
                ? date('d M Y', strtotime($l['disbursement_date'])) : '-',
            'end_date'         => '-',
            'status'           => ucfirst($l['status']),
            'overdue_count'    => 0,
            'risk_level'       => $risk,
            'next_due'         => '-'
        ];
    }

    // ===============================
    // 3. PAGINATION
    // ===============================
    $totalRecords = count($filtered);
    $totalPages = max(1, ceil($totalRecords / $limit));
    $pagedLoans = array_slice($filtered, $offset, $limit);

    // ===============================
    // 4. RESPONSE
    // ===============================
    $response['summary'] = [
        'total_loans'     => count($allLoans),
        'active_loans'    => $statusCounts['Approved'] ?? 0,
        'overdue_loans'   => 0,
        'defaulted_loans' => $statusCounts['Defaulted'] ?? 0
    ];

    $response['loan_status'] = [
        'labels' => array_keys($statusCounts),
        'values' => array_values($statusCounts)
    ];

    $response['risk_breakdown'] = [
        'labels' => array_keys($riskCounts),
        'values' => array_values($riskCounts)
    ];

    $response['loan_types'] = array_values(array_unique($loanTypes));
    $response['loans'] = $pagedLoans;
    $response['pagination'] = [
        'current_page' => $page,
        'total_pages' => $totalPages,
        'limit' => $limit,
        'total_records' => $totalRecords
    ];

    echo json_encode($response);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'API processing error',
        'message' => $e->getMessage()
    ]);
    exit;
}