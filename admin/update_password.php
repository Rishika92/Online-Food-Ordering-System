<?php include('partials/menu.php') ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>
        <?php if(isset($_GET['id'])){
           $id=$_GET['id'];
        }  ?>
         <form action="" method="POST">

<div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Current Password:</label>
    <div class="col-sm-3">
        <input required type="password" name="current_password" class="form-control" id="inputPassword3" placeholder="Your Current Password">
    </div>
</div>

<div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">New Password:</label>
    <div class="col-sm-3">
        <input required type="password" name="new_password" class="form-control" id="inputPassword3" placeholder="Your New Password">
    </div>
</div>

<div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Confirm Password:</label>
    <div class="col-sm-3">
        <input required type="password" name="confirm_password" class="form-control" id="inputPassword3" placeholder="Confirm Your New Password">
    </div>
</div>

<input type="hidden" name="id" value="<?php echo $id?>">
<input type="submit" name="submit" value="Change Password" class="btn btn-primary">



</form>
    </div>
</div>
<?php 
//check whther the submit button is clicked or not.
if(isset($_POST['submit'])){
    $id=$_POST['id'];
    $current_password=md5($_POST['current_password']);
    $new_password=md5($_POST['new_password']);
    $confirm_password=md5($_POST['confirm_password']);
    $sql="SELECT *FROM tbl_admin WHERE id=$id AND password='$current_password'";
    $res=mysqli_query($conn,$sql);
    if($res==true){
        $count=mysqli_num_rows($res);
        if($count==1){
          //user exists and password can be changed
          if($new_password==$confirm_password){
             $sql2="UPDATE tbl_admin SET
             password='$new_password'
             WHERE id=$id
             ";
             $res2=mysqli_query($conn,$sql);
             if($res2==true){
                $_SESSSION['change-pwd']="<div class='success'>Password changed Successfully</div>";
                header('location:'.SITEURL.'admin/manage_admin.php');
             }else{
                $_SESSSION['change-pwd']="<div class='error'>Failed to change password.</div>";
                header('location:'.SITEURL.'admin/manage_admin.php');
             }

             
          }else{
            $_SESSSION['pwd-not-match']="<div class='error'>Password didn't match.</div>";
            header('location:'.SITEURL.'admin/manage_admin.php');
          }
        }else{
            //user does not exist,set message ans direct
            $_SESSSION['user-not-found']="<div class='error'>User not Found</div>";
            header('location:'.SITEURL.'admin/manage_admin.php');
        }
    }
}
?>
<?php include('partials/footer.php') ?>