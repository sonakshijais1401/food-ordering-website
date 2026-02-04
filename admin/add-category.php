<?php
include('partials/menu.php');
include('partials/db_connect.php');  // Ensure the database connection file is included

if (isset($_POST['submit'])) {
    // Retrieve form data
    $title = $_POST['title'];
    $featured = isset($_POST['featured']) ? $_POST['featured'] : 'No';
    $active = isset($_POST['active']) ? $_POST['active'] : 'No';

    // Check if an image is uploaded
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image_name = $_FILES['image']['name'];

        // Rename the image file to avoid duplication
        $extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_name = "Category_" . time() . "." . $extension;

        // Upload path
        $upload_path = "../images/category/" . $image_name;

        // Upload the image
        $upload_success = move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);

        // If upload fails, display an error message
        if (!$upload_success) {
            $_SESSION['add'] = "Failed to upload image.";
            header("Location: add-category.php");
            exit;
        }
    } else {
        $image_name = ""; // No image uploaded
    }

    // Insert category into the database
    $sql = "INSERT INTO tbl_category (title, image_name, featured, active) 
            VALUES ('$title', '$image_name', '$featured', '$active')";

    $result = mysqli_query($con, $sql);

    if ($result) {
        // Success message and redirection
        $_SESSION['add'] = "Category added successfully!";
        header("Location: manage-category.php");
        exit;
    } else {
        // Failure message
        $_SESSION['add'] = "Failed to add category: " . mysqli_error($con);
        header("Location: add-category.php");
        exit;
    }
}
?>

<!-- HTML form for adding categories -->
<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title</td>
                    <td><input type="text" name="title" placeholder="Category Title" required></td>
                </tr>
                <tr>
                    <td>Choose Image</td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Featured</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
include('partials/footer.php');
?>
