<?php
include('partials/menu.php');
include('../partials/db_connect.php');  // Include DB connection

// Fetch categories for the dropdown
$query = "SELECT * FROM tbl_category";
$result = mysqli_query($con, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get food details from the form
    $title = $_POST['title'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $image_name = $_FILES['image']['name'];

    // Upload the image
    $target_dir = "../images/food/";
    $target_file = $target_dir . basename($image_name);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    // Insert food details into the database
    $query = "INSERT INTO tbl_food (title, category_id, price, image_name) 
              VALUES ('$title', '$category', '$price', '$image_name')";
    $result = mysqli_query($con, $query);

    if ($result) {
        header('Location: manage-food.php');  // Redirect to the manage food page
    } else {
        echo "<p>Failed to add food.</p>";
    }
}
?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <label for="title">Food Name: </label>
            <input type="text" name="title" id="title" required><br><br>

            <label for="category">Category: </label>
            <select name="category" id="category">
                <?php
                // Display categories in the dropdown
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['id']}'>{$row['title']}</option>";
                }
                ?>
            </select><br><br>

            <label for="price">Price: </label>
            <input type="number" name="price" id="price" required><br><br>

            <label for="image">Image: </label>
            <input type="file" name="image" id="image" required><br><br>

            <input type="submit" name="submit" value="Add Food" class="btn-secondary">
        </form>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>
