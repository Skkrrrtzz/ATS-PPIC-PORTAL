<?php
include_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the entire POST request data as JSON
    $postData = json_decode(file_get_contents("php://input"), true);

    // Check if 'editedValues' key exists in the JSON data
    if (isset($postData['editedValues'])) {
        // Get the edited values from the JSON data
        $editedValues = $postData['editedValues'];

        // Establish your database connection
        $host = 'localhost';
        $dbuser = 'root';
        $dbpassword = '';
        $dbname = 'ats_ppic';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Define the SQL statement with placeholders
            $sql = "INSERT INTO master_schedule (product_names, prod_Build_Qty, product_No, ship_Qty, BOH_EOH, actual_Batch_Output, delay) VALUES (:product_name, :prod_Build_Qty, :product_No, :ship_Qty, :BOH_EOH, :actual_Batch_Output, :delay)";

            // Prepare the SQL statement
            $stmt = $pdo->prepare($sql);

            // Loop through the product names and their associated values
            foreach ($editedValues as $productName => $productData) {
                foreach ($productData['prod_build_qty'] as $key => $value) {
                    $stmt->bindParam(':product_name', $productName);
                    $stmt->bindParam(':prod_Build_Qty', $value);
                    $stmt->bindParam(':product_No', $productData['product_no'][$key]);
                    $stmt->bindParam(':ship_Qty', $productData['ship_qty'][$key]);
                    $stmt->bindParam(':BOH_EOH', $productData['boh_eoh'][$key]);
                    $stmt->bindParam(':actual_Batch_Output', $productData['act_batch_output'][$key]);
                    $stmt->bindParam(':delay', $productData['delay'][$key]);

                    // Insert the data into the database
                    $stmt->execute();
                }
            }

            // Respond with a success message or status code
            echo json_encode(['status' => 'success']);
        } catch (PDOException $e) {
            // Handle database errors
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        // Handle the case where 'editedValues' is not found in the JSON data
        echo json_encode(['status' => 'error', 'message' => 'Edited values not found']);
    }
} else {
    // Handle invalid requests
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
