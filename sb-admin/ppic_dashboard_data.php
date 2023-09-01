<?php include_once '../db.php';

// Create a prepared statement
$sql = "SELECT COUNT(Docu_status) AS open_sales FROM sales_order WHERE Docu_status=:status";
$stmt = $pdo->prepare($sql);

// Bind the parameter
$status = 'O';
$stmt->bindParam(':status', $status, PDO::PARAM_STR);

// Execute the prepared statement
$stmt->execute();

// Fetch the result
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Access the result using the alias "open_sales"
$openSalesCount = $result['open_sales'];
