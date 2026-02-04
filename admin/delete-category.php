<?php
include('partials/db_connect.php');

if (isset($_GET['id']) && isset($_GET['image_name'])) {
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // Remove the image if it exists
    if ($image_name != "") {
        $path = "../images/category/" . $image_name;
        if (file_exists($path)) {
            unlink($path);
        }
    }

    // Delete the category from the database
    $sql = "DELETE FROM tbl_category WHERE id=$id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Category.</div>";
    }
} else {
    $_SESSION['delete'] = "<div class='error'>Unauthorized Access.</div>";
}

header("Location: manage-category.php");
?>
