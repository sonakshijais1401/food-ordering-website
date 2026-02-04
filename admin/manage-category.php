<?php
include('partials/menu.php');
include('partials/db_connect.php');

// Fetch all categories from the database
$sql = "SELECT * FROM tbl_category";
$result = mysqli_query($con, $sql);
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>
        <br><br>

        <?php
        // Display session messages if they exist
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>
        <br><br>

        <!-- Button to Add Category -->
        <a href="add-category.php" class="btn-primary">Add Category</a>
        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>S. No.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
            // Check if any categories exist in the database
            if ($result && mysqli_num_rows($result) > 0) {
                $sn = 1; // Serial number variable

                // Loop through each category and display its details
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                    ?>
                    <tr>
                        <td><?php echo $sn++; ?>.</td>
                        <td><?php echo $title; ?></td>
                        <td>
                            <?php
                            if ($image_name != "") {
                                // Display the image
                                ?>
                                <img src="../images/category/<?php echo $image_name; ?>" width="100px">
                                <?php
                            } else {
                                // Display an error message
                                echo "<div class='error'>Image Not Added</div>";
                            }
                            ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update</a>
                            <a href="delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                // No categories found
                echo "<tr><td colspan='6' class='error'>No Categories Added</td></tr>";
            }
            ?>
        </table>
    </div>
</div>

<?php
include('partials/footer.php');
?>
