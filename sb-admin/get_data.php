<?php include_once '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
} else {
    // Query to fetch data from sales_order table
    $sql = "SELECT * FROM sales_order";
    $stmt = $pdo->query($sql);

    // Fetch data as an associative array
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return data as JSON response
    echo json_encode($data);
}
