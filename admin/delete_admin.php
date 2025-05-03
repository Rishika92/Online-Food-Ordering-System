<?php 
include('../configure/constants.php');
$id=$_GET['id'];
$sql="DELETE FROM tbl_admin WHERE id=$id ";
$res=mysqli_query($conn,$sql);
if($res==TRUE){
    $_SESSION ['delete']="<div class='success'>Admin Deleted Succesfully</div>";
    header('location'.SITEURL.'admin/manage_admin.php');
}else{

  $_SESSION['delete']="<div class='error'>Failed to delete Admin.Try Again Later</div>";
  header('location'.SITEURL.'admin/manage_admin.php');
}
?>