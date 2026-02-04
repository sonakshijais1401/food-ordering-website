<?php include('partials/menu.php'); ?> 
<?php include('partials/check-login.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
            
        <br /><br />
        <form action="add-admin.php" method="POST">

        <table class="tbl-30">
            <tr>
                <td>Full Name</td>
                <td>
                    <input type="text" name="full_name" placeholder="Enter Your Name">
                </td>
            </tr>

            <tr>
                <td>Username</td>
                <td>
                    <input type="text" name="username" placeholder="Your Username">
                </td>
            </tr>

            <tr>
                <td>Password:</td>
                <td>
                    <input type="password" name="password" placeholder="Your Password">
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                </td>
            </tr>
        </table>
        </form>
    </div>
</div>


<?php include('partials/footer.php'); ?>


<?php
    //Process the value from form and save it in Database

    //Check whether the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        //Button Click
       // echo"Button Clicked";
        
        //Get the data from the form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //Password Encryption with md 5
        
        //sql query to save the data into database
        $sql = "INSERT INTO tbl_admin SET 
            full_name='$full_name',
            username='$username',
            password='$password'
            ";
    
            

            $con = mysqli_connect('localhost:3307', 'root', '') or die(mysqli_error()); //database connection
            $db_slect = mysqli_select_db($con, 'food_order') or die(mysqli_error());
    

            //executing query and saving data into database
            $res = mysqli_query($con, $sql) or die(mysqli_error());

            //check whether the(query is excuted) data is inserted or not and display appropriate message
            if($res==TRUE)
            {
                //data inserted
                //echo "Admin Added Successfully";
                //start session
                $_SESSION['add'] = "Admin Added Successfully";
                header("Location:manage-admin.php");
                //redirect page
                
            
            }
            else{
                //Failed to insert data
                //echo "Failed to add admin";
                $_SESSION['add'] = "Failed to add admin";
                //redirect page
                header("Location:add-admin.php");
            }
    
    }
?>