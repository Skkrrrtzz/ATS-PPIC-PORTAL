<?php
try {
    include_once 'db.php';
    $mastersched_sql = "SELECT * FROM `master_schedule`";
    // Prepare the SQL statement
    $stmt = $pdo->prepare($mastersched_sql);

    // Execute the statement
    $stmt->execute();

    // Fetch the results as an associative array
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $productData = array();
    // Process the results here
    foreach ($results as $row) {
        // Store data in the productData array using the product name as the key
        $productData[$row['id']] = $row;
    }
} catch (PDOException $e) {
    // Handle any errors that occur during the execution
    echo "Error: " . $e->getMessage();
}
// Function to calculate the week numbers and date ranges
function calculateWeeksAndDates($currentMonthName, $endOfNextMonth)
{
    $weekNumbers = [];
    $dateRanges = [];

    $currentDate = new DateTime('first day of this month');
    while ($currentDate->format('N') != 7) {
        $currentDate->modify('+1 day');
    }

    while ($currentDate <= $endOfNextMonth) {
        $weekNumber = $currentDate->format('W') + 1;
        if (!in_array($weekNumber, $weekNumbers)) {
            $weekNumbers[] = $weekNumber;
        }

        $sundayDate = clone $currentDate;
        $saturdayDate = clone $sundayDate;
        $saturdayDate->modify('+6 days');

        $dateRanges[$weekNumber]['Sunday'] = $sundayDate->format('d-M');
        $dateRanges[$weekNumber]['Saturday'] = $saturdayDate->format('d-M');

        $currentDate->modify('+7 days');
    }

    return [$weekNumbers, $dateRanges];
}

$products = array('JLP', 'FLIPPER', 'MTP', 'IONIZER', 'RCMTP', 'HIGH MAG FORCE', 'JTP', 'OLB', 'PNP I/O', 'PNP Transfer');
$currentDate = new DateTime('first day of this month');
$endOfNextMonth = new DateTime('last day of next month');
$currentMonthName = $currentDate->format('F');
$nextMonthName = $endOfNextMonth->format('F');

list($weekNumbers, $dateRanges) = calculateWeeksAndDates($currentMonthName, $endOfNextMonth);
$saturdaysCount = 0;
$week = 0;
foreach ($weekNumbers as $week) {
    if (date('l', strtotime($dateRanges[$week]['Saturday'])) === 'Saturday') {
        $saturdaysCount++;
    }
}
