<?php
// Define the SITEURL constant
define('SITEURL', 'http://localhost/food-order/');

// Database connection details
$host = "localhost:3307";  // Your database host (change the port if necessary)
$user = "root";            // Your database username
$password = "";            // Your database password
$database = "food_order";  // Your database name

// Establishing the database connection
$con = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
