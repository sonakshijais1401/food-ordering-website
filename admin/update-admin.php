<?php include('partials/menu.php'); ?>

<?php
// Database connection
$con = mysqli_connect('localhost:3307', 'root', '', 'food_order') or die(mysqli_error());

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current details of the admin
    $sql = "SELECT * FROM tbl_admin WHERE id=$id";
    $res = mysqli_query($con, $sql);

    if ($res == TRUE && mysqli_num_rows($res) == 1) {
        // Admin found
        $row = mysqli_fetch_assoc($res);
        $full_name = $row['full_name'];
        $username = $row['username'];
    } else {
        // Admin not found
        $_SESSION['update'] = "Admin Not Found";
        header("Location: manage-admin.php");
        exit();
    }
} else {
    header("Location: manage-admin.php"); // Redirect if no ID is provided
    exit();
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="password" placeholder="Enter New Password (Leave blank to keep current)">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
// Process the form data when submitted
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = isset($_POST['password']) && $_POST['password'] != "" ? md5($_POST['password']) : null;

    // Build the SQL query
    if ($password) {
        // Update with new password
        $sql = "UPDATE tbl_admin SET 
                full_name = '$full_name',
                username = '$username',
                password = '$password'
                WHERE id = $id";
    } else {
        // Update without changing password
        $sql = "UPDATE tbl_admin SET 
                full_name = '$full_name',
                username = '$username'
                WHERE id = $id";
    }

    // Execute query
    $res = mysqli_query($con, $sql);

    if ($res == TRUE) {
        $_SESSION['update'] = "Admin Updated Successfully";
    } else {
        $_SESSION['update'] = "Failed to Update Admin";
    }

    header("Location: manage-admin.php");
    exit();
}
?>

<?php include('partials/footer.php'); ?>
