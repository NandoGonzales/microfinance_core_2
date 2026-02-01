<?php

/**
 * Core2 — Loan API
 * Path: api/loan/loan_api.php
 * 
 * Fetches raw loan data from Core1 (Laravel),
 * maps it into the loan_portfolio table structure,
 * and syncs into core2_db.
 */

require_once(__DIR__ . '/../../initialize_coreT2.php');

// ─────────────────────────────────────────────
// CONFIG
// ─────────────────────────────────────────────
$CORE1_URL = 'https://core2.microfinancial-1.com/api/loans';
$API_TOKEN = '';  // Add Bearer token here if Core1 requires auth
// ─────────────────────────────────────────────

header('Content-Type: application/json; charset=utf-8');

$db   = new DBConnection();
$conn = $db->conn;


// ─── STEP 1: Fetch loans from Core1 ───
function fetchLoansFromCore1(string $url, string $token): array
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $headers = ['Accept: application/json'];

    if (!empty($token)) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error    = curl_error($ch);
    curl_close($ch);

    if ($error) {
        throw new Exception("cURL Error: " . $error);
    }

    if ($httpCode !== 200) {
        throw new Exception("Core1 returned HTTP {$httpCode}");
    }

    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Invalid JSON from Core1.");
    }

    return $data;
}


// ─── STEP 2: Map Core1 status → loan_portfolio status ───
//
//   Core1 raw          →  loan_portfolio
//   ─────────────────────────────────────
//   "completed"        →  "Active"
//   "approved"         →  "Active"
//   "pending"          →  "Pending"
//   anything else      →  "Pending"
//
function mapStatus(string $core1Status): string
{
    $map = [
        'completed' => 'Active',
        'approved'  => 'Active',
        'pending'   => 'Pending',
    ];

    return $map[strtolower($core1Status)] ?? 'Pending';
}


// ─── STEP 3: Calculate end_date from start_date + loan_term (months) ───
function calcEndDate(?string $startDate, int $loanTerm): ?string
{
    if (empty($startDate)) return null;

    $dt = new DateTime($startDate);
    $dt->modify("+{$loanTerm} months");
    return $dt->format('Y-m-d');
}


// ─── STEP 4: Ensure sync_logs table exists ───
function ensureSyncLogsTable(mysqli $conn): void
{
    $conn->query("
        CREATE TABLE IF NOT EXISTS loan_sync_logs (
            id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            total      INT NOT NULL,
            status     ENUM('success','error') NOT NULL,
            message    TEXT NULL,
            synced_at  DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");
}


// ─── STEP 5: Insert or update into loan_portfolio ───
//
//   Core1 field            →  loan_portfolio column
//   ──────────────────────────────────────────────────
//   id                     →  loan_id
//   client_id              →  member_id
//   loan_type              →  loan_type
//   loan_amount            →  principal_amount
//   interest_rate          →  interest_rate
//   loan_term              →  loan_term
//   disbursement_date      →  start_date
//   (calculated)           →  end_date  (start_date + loan_term months)
//   status (mapped)        →  status
//
function saveLoans(mysqli $conn, array $loans): int
{
    $stmt = $conn->prepare("
        INSERT INTO loan_portfolio (
            loan_id,
            member_id,
            loan_type,
            principal_amount,
            interest_rate,
            loan_term,
            start_date,
            end_date,
            status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            member_id        = VALUES(member_id),
            loan_type        = VALUES(loan_type),
            principal_amount = VALUES(principal_amount),
            interest_rate    = VALUES(interest_rate),
            loan_term        = VALUES(loan_term),
            start_date       = VALUES(start_date),
            end_date         = VALUES(end_date),
            status           = VALUES(status)
    ");

    // Types: loan_id(i), member_id(i), loan_type(s), principal_amount(d),
    //        interest_rate(d), loan_term(i), start_date(s), end_date(s), status(s)
    $stmt->bind_param(
        'iisddisss',
        $loan_id, $member_id, $loan_type, $principal_amount,
        $interest_rate, $loan_term, $start_date, $end_date, $status
    );

    $count = 0;

    foreach ($loans as $loan) {
        $loan_id         = (int)    $loan['id'];
        $member_id       = (int)    $loan['client_id'];
        $loan_type       = (string) $loan['loan_type'];
        $principal_amount= (float)  $loan['loan_amount'];
        $interest_rate   = (float)  $loan['interest_rate'];
        $loan_term       = (int)    $loan['loan_term'];
        $start_date      =          $loan['disbursement_date'] ?? null;
        $end_date        =          calcEndDate($start_date, $loan_term);
        $status          =          mapStatus($loan['status']);

        $stmt->execute();
        $count++;
    }

    $stmt->close();
    return $count;
}


// ─── STEP 6: Log the sync result ───
function logSyncResult(mysqli $conn, int $total, string $status, string $message): void
{
    $stmt = $conn->prepare("
        INSERT INTO loan_sync_logs (total, status, message)
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param('iss', $total, $status, $message);
    $stmt->execute();
    $stmt->close();
}


// ─────────────────────────────────────────────
// MAIN
// ─────────────────────────────────────────────
try {
    // 1. Fetch from Core1
    $loans = fetchLoansFromCore1($CORE1_URL, $API_TOKEN);

    if (empty($loans)) {
        throw new Exception("No loans returned from Core1.");
    }

    // 2. Ensure sync log table exists
    ensureSyncLogsTable($conn);

    // 3. Save into loan_portfolio
    $saved = saveLoans($conn, $loans);

    // 4. Log success
    logSyncResult($conn, $saved, 'success', "Synced {$saved} loan(s) from Core1 into loan_portfolio.");

    // 5. Response
    echo json_encode([
        'success' => true,
        'message' => "Synced {$saved} loan(s) into loan_portfolio.",
        'total'   => $saved,
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    try {
        logSyncResult($conn, 0, 'error', $e->getMessage());
    } catch (Exception $logErr) {
        // DB might not be ready
    }

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ], JSON_PRETTY_PRINT);
}