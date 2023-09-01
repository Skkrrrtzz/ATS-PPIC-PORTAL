<?php
session_start();

// Get the user's role or department from the session
$userRole = $_SESSION['Department'];

session_unset(); // Clear all session variables
session_destroy(); // Destroy the session

if ($userRole == 'Production Main') {
    // Redirect admin users to the admin login form
    header("Location: ATSPROD_home.php");
} elseif ($userRole == 'DPIC') {
    // Redirect employee users to the employee login form
    header("Location: ATSPORTAL_login.php");
} else {
    // Redirect other users to a default login form
    header("Location: ./home.php");
}

exit();
