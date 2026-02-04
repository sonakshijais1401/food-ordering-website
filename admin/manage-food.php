<?php
include('partials/menu.php');
include('partials/db_connect.php');  // Include the DB connection

// Fetch food details from the database
$query = "SELECT * FROM tbl_food";
$result = mysqli_query($con, $query);
?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>
        <br><br>

        <!-- Button to add food -->
        <a href="add-food.php" class="btn-primary">Add Food</a>

        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>S. No.</th>
                <th>Food Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>

            <?php
            // Loop through the results and display the food items
            $sn = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$sn}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['category_id']}</td>
                    <td>{$row['price']}</td>
                    <td><img src='../images/food/{$row['image_name']}' width='100'></td>
                    <td>
                        <a href='update-food.php?id={$row['id']}' class='btn-secondary'>Update Food</a>
                        <a href='delete-food.php?id={$row['id']}' class='btn-danger'>Delete Food</a>
                    </td>
                </tr>";
                $sn++;
            }
            ?>
        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>
