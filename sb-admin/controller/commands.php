<?php include_once 'db.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $rowData = $_POST['data'];
    foreach ($rowData as $row) {
        $curMonth = $row['curMonth'];
        $nextMonth = $row['nextMonth'];
        $wwk = $row['wwk'];
        $product = $row['product'];
        $value = $row['value'];

        // Echo the values as needed
        echo "curMonth: $curMonth, nextMonth: $nextMonth, wwk: $wwk, product: $product, value: $value<br>";
    }
} else {
    echo "Invalid POST data.";
}





$mastersched_sql = "SELECT * FROM `master_schedule`";

try {
    // Prepare the SQL statement
    $stmt = $pdo->prepare($mastersched_sql);

    // Execute the statement
    $stmt->execute();

    // Fetch the results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $productData = array(); // Initialize an array to store product-specific data

    // Process the results here
    foreach ($results as $row) {
        // Store data in the productData array using the product name as the key
        $productData[$row['product_names']] = $row;
    }


    $products = array('JLP', 'FLIPPER', 'MTP', 'IONIZER', 'RCMTP', 'HIGH MAG FORCE', 'JTP', 'OLB', 'PNP I/O', 'PNP Transfer');

    // Get the current date
    $currentDate = new DateTime('first day of this month');

    // Find the first Sunday before the 1st of the current month
    while ($currentDate->format('N') != 7) {
        $currentDate->modify('+1 day');
    }

    // Calculate the end of the next month
    $endOfNextMonth = new DateTime('last day of next month');

    // Get the current month name
    $currentMonthName = $currentDate->format('F');

    // Get the next month name
    $nextMonthName = $endOfNextMonth->format('F');

    // Initialize an array to store the week numbers
    $weekNumbers = array();

    // Initialize an array to store the Sunday and Saturday dates
    $dateRanges = array();

    // Loop from the current date to the end of the next month
    while ($currentDate <= $endOfNextMonth) { // Get the week number for the current date (starting on Sunday) 
        $weekNumber = $currentDate->format('W') + 1;

        // Add the week number to the array if it's not already added
        if (!in_array($weekNumber, $weekNumbers)) {
            $weekNumbers[] = $weekNumber;
        }

        // Get the Sunday date for the current week
        $sundayDate = clone $currentDate;

        // Get the Saturday date for the current week (6 days after Sunday)
        $saturdayDate = clone $sundayDate;
        $saturdayDate->modify('+6 days');

        $dateRanges[$weekNumber]['Sunday'] = $sundayDate->format('d-M');
        $dateRanges[$weekNumber]['Saturday'] = $saturdayDate->format('d-M');

        // Move to the next Sunday (7 days)
        $currentDate->modify('+7 days');
    }

    // Sort the week numbers
    sort($weekNumbers);
} catch (PDOException $e) {
    // Handle any errors that occur during the execution
    echo "Error: " . $e->getMessage();
}
