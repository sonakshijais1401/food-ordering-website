<?php

//1 get the id of admin to be deleted

//2 crete sql query to delete admin

//3 redirect to manage admin with message success or error


// Include database connection
$con = mysqli_connect('localhost:3307', 'root', '', 'food_order') or die(mysqli_error());

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    // Get the ID of the admin to be deleted
    $id = $_GET['id'];

    // SQL query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    // Execute the query
    $res = mysqli_query($con, $sql);

    // Check if the query executed successfully
    if ($res == TRUE) {
        // Admin deleted successfully
        $_SESSION['delete'] = "Admin Deleted Successfully";
    } else {
        // Failed to delete admin
        $_SESSION['delete'] = "Failed to Delete Admin";
    }

    // Redirect to manage-admin.php
    header("Location: manage-admin.php");
} else {
    // Redirect to manage-admin.php if ID is not set
    $_SESSION['delete'] = "Unauthorized Access";
    header("Location: manage-admin.php");
}
?>

