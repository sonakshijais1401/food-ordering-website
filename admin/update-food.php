<?php
include('partials/menu.php');
include('partials/db_connect.php');  // Include DB connection

// Get the food ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch food details from the database
    $query = "SELECT * FROM tbl_food WHERE id = $id";
    $result = mysqli_query($con, $query);
    $food = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get updated food details
    $title = $_POST['title'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $image_name = $_FILES['image']['name'];

    // If new image is uploaded, update it
    if ($image_name != "") {
        $target_dir = "../images/food/";
        $target_file = $target_dir . basename($image_name);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    } else {
        $image_name = $food['image_name']; // Retain the old image name
    }

    // Update the food details in the database
    $query = "UPDATE tbl_food SET title='$title', category_id='$category', price='$price', image_name='$image_name' WHERE id=$id";
    $result = mysqli_query($con, $query);

    if ($result) {
        header('Location: manage-food.php');  // Redirect to manage food page
    } else {
        echo "<p>Failed to update food.</p>";
    }
}
?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>

        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <label for="title">Food Name: </label>
            <input type="text" name="title" id="title" value="<?php echo $food['title']; ?>" required><br><br>

            <label for="category">Category: </label>
            <select name="category" id="category">
                <?php
                // Fetch and display categories in the dropdown
                $category_query = "SELECT * FROM tbl_category";
                $category_result = mysqli_query($con, $category_query);
                while ($row = mysqli_fetch_assoc($category_result)) {
                    echo "<option value='{$row['id']}'" . ($row['id'] == $food['category_id'] ? " selected" : "") . ">{$row['title']}</option>";
                }
                ?>
            </select><br><br>

            <label for="price">Price: </label>
            <input type="number" name="price" id="price" value="<?php echo $food['price']; ?>" required><br><br>

            <label for="image">Image: </label>
            <input type="file" name="image" id="image"><br><br>

            <input type="submit" name="submit" value="Update Food" class="btn-secondary">
        </form>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>
