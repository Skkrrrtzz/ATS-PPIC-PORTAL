<?php include_once 'db.php';
session_start();

// Create a prepared statement for the sales dashboard query
$sql_dashboard = "SELECT 
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
             THEN Open_Amt ELSE 0 END) AS open_sales_this_month_price,
    SUM(CASE WHEN Docu_status = 'C' AND 
                   MONTH(Row_Del_date) = MONTH(CURDATE()) AND 
                   YEAR(Row_Del_date) = YEAR(CURDATE())
             THEN 1 ELSE 0 END) AS closed_sales_this_month,
    SUM(CASE WHEN Docu_status = 'C' AND 
                   MONTH(Row_Del_date) = MONTH(CURDATE()) AND 
                   YEAR(Row_Del_date) = YEAR(CURDATE())
             THEN Open_Amt ELSE 0 END) AS closed_sales_this_month_price         
FROM sales_order 
WHERE Docu_status IN (?, ?);";

// Create a prepared statement for "Docu_status = 'O'"
$sql_del_date_open = "SELECT 
    BP_Reference_No, 
    Posting_date, 
    Row_Del_date, 
    Customer_part_no, 
    Item_Service_description, 
    Qty, 
    Open_Qty, 
    Docu_status 
FROM sales_order 
WHERE Docu_status='O' 
      AND MONTH(Row_Del_date) = MONTH(CURDATE()) 
      AND YEAR(Row_Del_date) = YEAR(CURDATE());";

// Prepare and execute the query for "Docu_status = 'O'"
$stmt_del_date_open = $pdo->prepare($sql_del_date_open);
$stmt_del_date_open->execute();

// Create a prepared statement for "Docu_status = 'C'"
$sql_del_date_closed = "SELECT 
    BP_Reference_No, 
    Posting_date, 
    Row_Del_date, 
    Customer_part_no, 
    Item_Service_description, 
    Qty, 
    Open_Qty, 
    Docu_status 
FROM sales_order 
WHERE Docu_status='C' 
      AND MONTH(Row_Del_date) = MONTH(CURDATE()) 
      AND YEAR(Row_Del_date) = YEAR(CURDATE());";

// Prepare and execute the query for "Docu_status = 'C'"
$stmt_del_date_closed = $pdo->prepare($sql_del_date_closed);
$stmt_del_date_closed->execute();

// Prepare and execute the sales dashboard query
$stmt_dashboard = $pdo->prepare($sql_dashboard);
$status1 = 'O';
$status2 = 'C';
$stmt_dashboard->bindParam(1, $status1, PDO::PARAM_STR);
$stmt_dashboard->bindParam(2, $status2, PDO::PARAM_STR);
$stmt_dashboard->execute();

// Fetch the result for the sales dashboard
$result_dashboard = $stmt_dashboard->fetch(PDO::FETCH_ASSOC);

$openSalesCount = $result_dashboard['open_sales'];
$closedSalesCount = $result_dashboard['closed_sales'];
$delayedSalesCount = $result_dashboard['delayed_sales'];
$openSalesPrice = number_format($result_dashboard['open_sales_price'], 2);
$openSalesdelThisMonth = $result_dashboard['open_sales_this_month'];
$openSalesdelThisMonthPrice = number_format($result_dashboard['open_sales_this_month_price'], 2);
$closedSalesdelThisMonth = $result_dashboard['closed_sales_this_month'];
$closedSalesdelThisMonthPrice = number_format($result_dashboard['closed_sales_this_month_price'], 2);
