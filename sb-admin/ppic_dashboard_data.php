<?php include_once '../db.php';

// Define the SQL query to retrieve user information by role.
$sql = "SELECT * FROM users WHERE Role = :role";

// Prepare the SQL statement.
$stmt = $pdo->prepare($sql);

// Bind the role parameter.
$role = 'ADMIN';
$stmt->bindParam(':role', $role, PDO::PARAM_STR);

// Execute the query.
if ($stmt->execute()) {
    // Fetch the user data.
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any users with the specified role (e.g., 'ADMIN').
    if (count($users) > 0) {
        // You can handle the login logic here.
        // For example, if you are checking if a user with this role exists, you can set a login flag.
        $loggedIn = true;

        // You can also access user information, e.g., username, within the $users array.
        foreach ($users as $user) {
            $_SESSION['Name'] = $user['Uname'];
            // Additional actions or checks can be performed here.
            $username = $_SESSION['Name'];
        }
    } else {
        // Role not found, handle accordingly (e.g., display an error message).
        $loggedIn = false;
        echo "Role not found!";
    }
} else {
    // Handle the query execution error.
    $loggedIn = false;
    echo "Error executing query: " . $stmt->errorInfo()[2];
}

// Close the database connection if needed.
// $pdo = null;

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
