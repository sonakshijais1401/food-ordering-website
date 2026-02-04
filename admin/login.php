<?php
session_start();
$con = mysqli_connect('localhost:3307', 'root', '', 'food_order') or die(mysqli_error());

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Encrypt password to match stored encrypted password

    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
    $res = mysqli_query($con, $sql);

    if (mysqli_num_rows($res) == 1) {
        // Login successful
        $row = mysqli_fetch_assoc($res);
        $_SESSION['admin'] = $row['username']; // Store admin username in session
        $_SESSION['login'] = "Login Successful"; // Success message

        header("Location: manage-admin.php");
    } else {
        // Login failed
        $_SESSION['login'] = "Username or Password is Incorrect";
        header("Location: login.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="login">
        <h1 class="text-center">Admin Login</h1>
        <br><br>
        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>
        <form action="" method="POST">
            <table>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Username">
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Login" class="btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
