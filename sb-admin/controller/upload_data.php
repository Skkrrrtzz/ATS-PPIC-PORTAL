<?php
include_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        // Access form data using $_POST
        $products = $_POST['product']; // $products is now an array
        $curmonth = $_POST['monthnow'];
        $nxtmonth = $_POST['monthnxt'];
        // Initialize an empty array to store date ranges
        $dateRanges = [];

        $weeks = $_POST['week'];       // Array of week numbers
        $sundays = $_POST['wkstart'];  // Array of Sunday dates
        $saturdays = $_POST['wkend'];  // Array of Saturday dates
        var_dump($sundays);
        // Check if all arrays have the same length
        if (is_array($weeks) && is_array($sundays) && is_array($saturdays) && count($weeks) === count($sundays) && count($weeks) === count($saturdays)) {

            // Loop through the arrays to construct the $dateRanges array
            foreach ($weeks as $key => $week) {
                $sunday = $sundays[$key];
                $saturday = $saturdays[$key];

                // Convert Sunday and Saturday dates to a more standard format (e.g., "2023-09-03" and "2023-09-09")
                $sundayDate = date('Y-m-d', strtotime($sunday));
                $saturdayDate = date('Y-m-d', strtotime($saturday));

                // Store the date range in the $dateRanges array
                $dateRanges[$week] = [
                    'Sunday' => $sundayDate,
                    'Saturday' => $saturdayDate,
                ];
            }
        } else {
            // Handle the case where the arrays have different lengths or are not arrays
            echo "Invalid data in the arrays or they have different lengths.";
        }

        // Now, $dateRanges contains the date ranges with week numbers as keys
        // You can access them like $dateRanges[36]['Sunday'] or $dateRanges[36]['Saturday']

        $prod_build_qty = $_POST['prod_build_qty'];
        $prod_no = $_POST['product_no'];
        $ship_qty = $_POST['ship_qty'];
        // Process the data as needed
        foreach ($products as $key => $product) {
            echo "Product: " . $product . "<br>";
            echo "Month Now: " . $curmonth . "<br>";
            echo "Next Month: " . $nxtmonth . "<br>";

            foreach ($prod_build_qty[$product] as $value) {
                echo "Production Build Qty: " . $value . "<br>";
            }
            foreach ($prod_no[$product] as $value) {
                echo "Product No.: " . $value . "<br>";
            }
            foreach ($ship_qty[$product] as $value) {
                echo "Ship Qty: " . $value . "<br>";
            }
        }
    } else {
        echo "no data";
    }
} else {
    echo "not POST";
}




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
