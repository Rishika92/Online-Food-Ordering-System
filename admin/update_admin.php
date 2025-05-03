<?php include ('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php
        $id = $_GET['id'];

        $sql = "SELECT * FROM tbl_admin WHERE id=$id";

        $res = mysqli_query($conn, $sql);

        if ($res == true) {
            $count = mysqli_num_rows($res);
            if ($count==1) {
                $row = mysqli_fetch_assoc($res);

                $full_name = $row['full_name'];
                $username = $row['username'];

            } else {
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        ?>
        <form action="" method="POST">


                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Full Name:</label>
                    <div class="col-sm-3">
                        <input required type="text" name="full_name" value="<?php echo $full_name;?>" class="form-control" id="inputEmail3" placeholder="Your Full Name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Username:</label>
                    <div class="col-sm-3">
                        <input required type="text" value="<?php echo $username;?>" name="username" placeholder="Your Username" class="form-control" id="inputEmail3" >
                    </div>
                </div>




                        <input type="hidden" name="id" value="<?php echo $id; // to get the id of user?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn btn-info">


        </form>
    </div>
</div>


<?php
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];

    $sql = "UPDATE tbl_admin SET full_name = '$full_name', username = '$username' WHERE id = '$id'";
$res = mysqli_query($conn, $sql);

if ($res == true) {
    $_SESSION['update'] = "<div class='success'> Admin Updated Successfully.</div>";
    header('location:'.SITEURL.'admin/manage-admin.php');

}else{
    $_SESSION['update'] = "<div class='error'> Admin Updated Failed.</div>";
    header('location:'.SITEURL.'admin/manage-admin.php');}
}
?>





<?php include ('partials/footer.php');?>

