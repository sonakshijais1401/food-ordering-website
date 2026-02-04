<?php include('partials/menu.php'); ?>
<?php include('partials/check-login.php'); ?>
<?php
if (isset($_SESSION['no-login-message'])) {
    echo $_SESSION['no-login-message'];
    unset($_SESSION['no-login-message']);
}
?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br /><br />

        <?php
        // Display session message if set
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']); // Remove the message after displaying
        }
        ?>
        <br><br>

        <!-- Button to add admin -->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br /><br /><br />

        <table class="tbl-full">
            <tr>
                <th>S. No.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php
            // Database connection
            $con = mysqli_connect('localhost:3307', 'root', '', 'food_order') or die(mysqli_error());

            // SQL query to fetch all admin data
            $sql = "SELECT * FROM tbl_admin";
            $res = mysqli_query($con, $sql);

            if ($res == TRUE) {
                $count = mysqli_num_rows($res); // Get the number of rows
                $sn = 1; // Create a serial number

                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        // Get individual data
                        $id = $row['id'];
                        $full_name = $row['full_name'];
                        $username = $row['username'];
                        ?>

                        <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                                <a href="update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                <a href="delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                            </td>
                        </tr>

                        <?php
                    }
                } else {
                    // No data found
                    echo "<tr><td colspan='4'>No Admins Added Yet</td></tr>";
                }
            }
            ?>
        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>
