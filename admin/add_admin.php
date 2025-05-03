<?php include('partials/menu.php') ?> 
<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br> <br>
        <?php 
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="user_name" placeholder="Your Username"></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td>
                
                        <input type="password" name="password" placeholder="Your paswword">

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

<?php include('partials/footer.php') ?>
<?php 
//process the value from form and save it in database.
//check whther the button is clicked or not.
if(isset($_POST["submit"])){
 
//button clikced
//1.getting the value from the form.
$full_name=$_POST["full_name"];
$username=$_POST["user_name"];
$password=md5($_POST["password"]);//password encrypted with md5.
//2.sql query to save the data into database.
$sql="INSERT INTO tbl_admin SET
    full_name='$full_name',
    username='$username',
    password='$password'    
    ";
$res=mysqli_query($conn,$sql) or die(mysqli_error($conn));
if($res==TRUE){
   $_SESSION['add']="Admin Added successfully";
   header("location:".SITEURL.'admin/manage_admin.php');
}else{
    $_SESSION['add']="Fail to Add Admin";
    header("location:".SITEURL.'admin/add_admin.php');
 
}
}


?>