<?php
require_once(__DIR__ . '/../../initialize_coreT2.php');
header('Content-Type: application/json; charset=utf-8');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Fetch single loan + schedules (VIEW ONLY)
        $loan_id = isset($_GET['loan_id']) ? intval($_GET['loan_id']) : 0;
        
        if (!$loan_id) {
            throw new Exception('Loan ID required');
        }

        // Check if $conn exists (mysqli), if not use PDO
        if (isset($conn) && $conn instanceof mysqli) {
            // Using MySQLi connection
            $stmt = $conn->prepare("
                SELECT l.loan_id, l.member_id, COALESCE(m.full_name,'Unknown') AS member_name, 
                       l.loan_type, l.principal_amount, l.interest_rate, l.loan_term, 
                       DATE_FORMAT(l.start_date,'%Y-%m-%d') AS start_date,
                       DATE_FORMAT(l.end_date,'%Y-%m-%d') AS end_date, l.status
                FROM loan_portfolio l
                LEFT JOIN members m ON m.member_id = l.member_id
                WHERE l.loan_id = ?
                LIMIT 1
            ");
            
            $stmt->bind_param("i", $loan_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $loan = $result->fetch_assoc();
            $stmt->close();

            if (!$loan) {
                throw new Exception('Loan not found');
            }

            // Fetch schedules
            $schedules = [];
            $stmt = $conn->prepare("
                SELECT schedule_id, 
                       DATE_FORMAT(due_date,'%Y-%m-%d') AS due_date, 
                       amount_due, 
                       amount_paid, 
                       DATE_FORMAT(payment_date,'%Y-%m-%d') AS payment_date, 
                       status 
                FROM loan_schedule 
                WHERE loan_id = ? 
                ORDER BY due_date ASC
            ");
            
            $stmt->bind_param("i", $loan_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $schedules[] = $row;
            }
            $stmt->close();

        } else {
            // Fallback to PDO connection
            $pdo = new PDO(
                "mysql:host=localhost;dbname=core2_db;charset=utf8mb4",
                "root",
                "",
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
            );

            // Fetch loan details
            $stmt = $pdo->prepare("
                SELECT l.loan_id, l.member_id, COALESCE(m.full_name,'Unknown') AS member_name, 
                       l.loan_type, l.principal_amount, l.interest_rate, l.loan_term, 
                       DATE_FORMAT(l.start_date,'%Y-%m-%d') AS start_date,
                       DATE_FORMAT(l.end_date,'%Y-%m-%d') AS end_date, l.status
                FROM loan_portfolio l
                LEFT JOIN members m ON m.member_id = l.member_id
                WHERE l.loan_id = :loan_id
                LIMIT 1
            ");
            
            $stmt->execute([':loan_id' => $loan_id]);
            $loan = $stmt->fetch();

            if (!$loan) {
                throw new Exception('Loan not found');
            }

            // Fetch schedules
            $stmt = $pdo->prepare("
                SELECT schedule_id, 
                       DATE_FORMAT(due_date,'%Y-%m-%d') AS due_date, 
                       amount_due, 
                       amount_paid, 
                       DATE_FORMAT(payment_date,'%Y-%m-%d') AS payment_date, 
                       status 
                FROM loan_schedule 
                WHERE loan_id = :loan_id 
                ORDER BY due_date ASC
            ");
            
            $stmt->execute([':loan_id' => $loan_id]);
            $schedules = $stmt->fetchAll();
        }

        echo json_encode([
            'success' => true, 
            'loan' => $loan, 
            'schedules' => $schedules
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // POST requests disabled for view-only mode
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        http_response_code(403);
        echo json_encode([
            'success' => false, 
            'error' => 'Modification operations are disabled. View-only mode.'
        ]);
        exit;
    }

    throw new Exception('Unsupported request method');
    
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'error' => 'Database error: ' . $e->getMessage()
    ]);
    error_log('Loan CRUD MySQLi Error: ' . $e->getMessage());
    exit;
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'error' => 'Database error: ' . $e->getMessage()
    ]);
    error_log('Loan CRUD PDO Error: ' . $e->getMessage());
    exit;
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false, 
        'error' => $e->getMessage()
    ]);
    error_log('Loan CRUD Error: ' . $e->getMessage());
    exit;
}