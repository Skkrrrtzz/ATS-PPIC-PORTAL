<?php
include_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        try {
            // Access form data using $_POST
            $emp_name = $_POST['emp_name'];
            $product = $_POST['product'];
            $curmonth = $_POST['curmonth'];
            $nxtmonth = $_POST['monthnxt'];

            $weeks = $_POST['week'];
            $start = $_POST['wkstart'];
            $end = $_POST['wkend'];
            $prod_build_qty = $_POST['prod_build_qty'];
            $ship_qty = $_POST['ship_qty'];

            $prod_num = isset($_POST['product_no'][0]) ? (int)$_POST['product_no'][0] : 0;
            $boh_eoh = isset($_POST['boh_eoh'][0]) ? (int)$_POST['boh_eoh'][0] : 0;

            // Prepare the SQL INSERT statement
            $Sql_Insert = "INSERT INTO master_schedule (product_names, month_names, WW, start_build_plan, end_build_date, prod_Build_Qty, product_No, ship_Qty, BOH_EOH, date_saved, updated_by)
                           VALUES (:product_names, :month_names, :WW, :start_build_plan, :end_build_date, :prod_Build_Qty, :product_No, :ship_Qty, :BOH_EOH, NOW(), :updated_by)";

            // Prepare the SQL statement for execution
            $stmt = $pdo->prepare($Sql_Insert);

            // Loop through your data and insert each record
            foreach ($weeks as $key => $week) {
                // Assign values to variables
                $prod_Build_Qty = $prod_build_qty[$key][0] ? $prod_build_qty[$key][0] : 0;
                $ship_Qty = $ship_qty[$key][0] ? $ship_qty[$key][0] : 0;

                // Bind variables to the placeholders
                $stmt->bindParam(':product_names', $product);
                $stmt->bindParam(':month_names', $curmonth);
                $stmt->bindParam(':WW', $week);
                $stmt->bindParam(':start_build_plan', $start[$key]);
                $stmt->bindParam(':end_build_date', $end[$key]);
                $stmt->bindParam(':prod_Build_Qty', $prod_Build_Qty);
                $stmt->bindParam(':product_No', $prod_num);
                $stmt->bindParam(':ship_Qty', $ship_Qty);
                $stmt->bindParam(':BOH_EOH', $boh_eoh);
                $stmt->bindParam(':updated_by', $emp_name);

                // Execute the SQL statement to insert data into the database
                $stmt->execute();

                // Calculate new values for prod_num and boh_eoh for the next iteration
                $prod_num += $prod_Build_Qty;
                $boh_eoh += $prod_Build_Qty - $ship_Qty;
            }
            echo "Data inserted successfully!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "No data submitted.";
    }
} else {
    echo "Not a POST request.";
}



// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     if (isset($_POST['submit'])) {
//         // Access form data using $_POST
//         $emp_name = $_POST['emp_name'];
//         $product = $_POST['product'];
//         $curmonth = $_POST['curmonth'];
//         $nxtmonth = $_POST['monthnxt'];

//         $weeks = $_POST['week'];
//         $start = $_POST['wkstart'];
//         $end = $_POST['wkend'];
//         $prod_build_qty = $_POST['prod_build_qty'];
//         $ship_qty = $_POST['ship_qty'];

//         $prod_num = isset($_POST['product_no'][0]) ? (int)$_POST['product_no'][0] : 0;
//         $boh_eoh = isset($_POST['boh_eoh'][0]) ? (int)$_POST['boh_eoh'][0] : 0;

//         foreach ($weeks as $key => $week) {
//             $week;
//             $week_start = $start[$key];
//             $week_end = $end[$key];
//             $build_qty = isset($prod_build_qty[$key][0]) ? $prod_build_qty[$key][0] : 0;
//             $ship_qtys = isset($ship_qty[$key][0]) ? $ship_qty[$key][0] : 0;

//             $week_start;
//             $week_end;
//             $build_qty;

//             // Calculate the new Prod No. based on the formula
//             if (is_numeric($build_qty) || is_numeric($ship_qtys)) {
//                 if ($key === 0) {
//                     // For the first iteration (index 0), use the original value
//                     $prod_num;
//                     $boh_eoh;
//                 } else {
//                     // For subsequent iterations (index > 0), apply the formula
//                     $prod_num += $build_qty;
//                     $boh_eoh += $build_qty - $ship_qtys;
//                 }
//             }

//             $prod_num;
//             $ship_qtys;
//             $boh_eoh;
//         }

//         $Sql_Insert = "INSERT INTO master_schedule (product_names,month_names,WW,start_build_plan,end_build_date, prod_Build_Qty, product_No, ship_Qty, BOH_EOH, date_saved, updated_by) VALUES (:product_names, :month_names, :WW, :start_build_plan,:end_build_date, :product_name, :prod_Build_Qty, :product_No, :ship_Qty, :BOH_EOH)";
//     } else {
//         echo "no data";
//     }
// } else {
//     echo "not POST";
// }




// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Get the entire POST request data as JSON
//     $postData = json_decode(file_get_contents("php://input"), true);

//     // Check if 'editedValues' key exists in the JSON data
//     if (isset($postData['editedValues'])) {
//         // Get the edited values from the JSON data
//         $editedValues = $postData['editedValues'];

//         // Establish your database connection
//         $host = 'localhost';
//         $dbuser = 'root';
//         $dbpassword = '';
//         $dbname = 'ats_ppic';

//         try {
//             $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpassword);
//             $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//             // Define the SQL statement with placeholders
//             $sql = "INSERT INTO master_schedule (product_names, prod_Build_Qty, product_No, ship_Qty, BOH_EOH, actual_Batch_Output, delay) VALUES (:product_name, :prod_Build_Qty, :product_No, :ship_Qty, :BOH_EOH, :actual_Batch_Output, :delay)";

//             // Prepare the SQL statement
//             $stmt = $pdo->prepare($sql);

//             // Loop through the product names and their associated values
//             foreach ($editedValues as $productName => $productData) {
//                 foreach ($productData['prod_build_qty'] as $key => $value) {
//                     $stmt->bindParam(':product_name', $productName);
//                     $stmt->bindParam(':prod_Build_Qty', $value);
//                     $stmt->bindParam(':product_No', $productData['product_no'][$key]);
//                     $stmt->bindParam(':ship_Qty', $productData['ship_qty'][$key]);
//                     $stmt->bindParam(':BOH_EOH', $productData['boh_eoh'][$key]);
//                     $stmt->bindParam(':actual_Batch_Output', $productData['act_batch_output'][$key]);
//                     $stmt->bindParam(':delay', $productData['delay'][$key]);

//                     // Insert the data into the database
//                     $stmt->execute();
//                 }
//             }

//             // Respond with a success message or status code
//             echo json_encode(['status' => 'success']);
//         } catch (PDOException $e) {
//             // Handle database errors
//             echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
//         }
//     } else {
//         // Handle the case where 'editedValues' is not found in the JSON data
//         echo json_encode(['status' => 'error', 'message' => 'Edited values not found']);
//     }
// } else {
//     // Handle invalid requests
//     echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
// }
