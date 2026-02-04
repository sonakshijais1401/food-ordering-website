<?php
include('partials/db_connect.php');  // Include DB connection

// Get food ID from URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the food item from the database
    $query = "DELETE FROM tbl_food WHERE id = $id";
    $result = mysqli_query($con, $query);

    if ($result) {
        header('Location: manage-food.php');  // Redirect to manage-food.php after deletion
    } else {
        echo "<p>Failed to delete food.</p>";
    }
}
?>
