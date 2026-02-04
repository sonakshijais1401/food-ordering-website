<?php
include('partials/menu.php');
include('partials/db_connect.php');

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the category data from the database
    $sql = "SELECT * FROM tbl_category WHERE id=$id";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        // Get the category details
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $current_image = $row['image_name'];
        $featured = $row['featured'];
        $active = $row['active'];
    } else {
        // Redirect if the category doesn't exist
        $_SESSION['no-category-found'] = "<div class='error'>Category Not Found.</div>";
        header("Location: manage-category.php");
        die();
    }
} else {
    header("Location: manage-category.php");
    die();
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            echo "<img src='../images/category/$current_image' width='100px'>";
                        } else {
                            echo "<div class='error'>No Image Uploaded.</div>";
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php if ($featured == "Yes") echo "checked"; ?>> Yes
                        <input type="radio" name="featured" value="No" <?php if ($featured == "No") echo "checked"; ?>> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if ($active == "Yes") echo "checked"; ?>> Yes
                        <input type="radio" name="active" value="No" <?php if ($active == "No") echo "checked"; ?>> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            // Check if a new image is selected
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                $image_name = $_FILES['image']['name'];

                // Upload the new image
                $ext = end(explode('.', $image_name));
                $image_name = "Category_" . rand(000, 999) . '.' . $ext;
                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../images/category/" . $image_name;

                $upload = move_uploaded_file($source_path, $destination_path);
                if (!$upload) {
                    $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                    header("Location: manage-category.php");
                    die();
                }

                // Remove the current image if it exists
                if ($current_image != "") {
                    $remove_path = "../images/category/" . $current_image;
                    unlink($remove_path);
                }
            } else {
                $image_name = $current_image;
            }

            // Update the category in the database
            $sql = "UPDATE tbl_category SET 
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active' 
                    WHERE id=$id";

            $result = mysqli_query($con, $sql);

            if ($result) {
                $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
            }

            header("Location: manage-category.php");
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
