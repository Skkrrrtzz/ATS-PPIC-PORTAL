<?php include_once '../db.php';
session_start();
// Create a prepared statement
$sql = "SELECT 
    SUM(CASE WHEN Docu_status = 'O' THEN 1 ELSE 0 END) AS open_sales, 
    SUM(CASE WHEN Docu_status = 'C' THEN 1 ELSE 0 END) AS closed_sales,
    SUM(CASE WHEN Docu_status = 'O' AND Row_Del_date <= CURDATE() THEN 1 ELSE 0 END) AS delayed_sales,
    SUM(CASE WHEN Docu_status = 'O' THEN Unit_price ELSE 0 END) AS open_sales_price,
    SUM(CASE WHEN Docu_status = 'O' AND 
                   MONTH(Row_Del_date) = MONTH(CURDATE()) AND 
                   YEAR(Row_Del_date) = YEAR(CURDATE())
             THEN 1 ELSE 0 END) AS open_sales_this_month,
    SUM(CASE WHEN Docu_status = 'O' AND 
                   MONTH(Row_Del_date) = MONTH(CURDATE()) AND 
                   YEAR(Row_Del_date) = YEAR(CURDATE())
             THEN Open_Amt ELSE 0 END) AS open_sales_this_month_price
FROM sales_order 
WHERE Docu_status IN (?, ?);";
$stmt = $pdo->prepare($sql);

// Bind the parameters
$status1 = 'O';
$status2 = 'C';
$stmt->bindParam(1, $status1, PDO::PARAM_STR);
$stmt->bindParam(2, $status2, PDO::PARAM_STR);

// Execute the prepared statement
$stmt->execute();

// Fetch the result
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$openSalesCount = $result['open_sales'];
$closedSalesCount = $result['closed_sales'];
$delayedSalesCount = $result['delayed_sales'];
$openSalesPrice = number_format($result['open_sales_price'], 2);
$openSalesdelThisMonth = $result['open_sales_this_month'];
$openSalesdelThisMonthPrice = number_format($result['open_sales_this_month_price'], 2);
