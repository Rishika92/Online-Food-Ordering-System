<?php include('partials/menu.php');?>
<?php ob_start(); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <br>

        <form action="" method="POST" enctype="multipart/form-data"> <!--enctype for image upload-->


            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Title:</label>
                <div class="col-sm-3">
                    <input required type="text" name="title" class="form-control" id="inputEmail3" placeholder="Category Title">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label mb-3 " for="customFile">Select Image:</label>
                <div class="col-sm-3">
                    <input type="file" name="image" class="form-control" id="customFile" />
                </div>
            </div>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"
                       data-toggle="tooltip" data-placement="left" title="If you pick 'No' the category will not display on home page, only in the category page"
                >Featured:
                </label>
                &ensp;&ensp;
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="featured" value="Yes" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                        Yes
                    </label>
                </div>
                &ensp;
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="featured" value="No" id="flexRadioDefault2" checked>
                    <label class="form-check-label" for="flexRadioDefault2">
                        No
                    </label>
                </div>
            </div>



            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label"
                       data-toggle="tooltip" data-placement="left" title="If you pick 'No' the category will not be visible in home page nor category page">Active:
                </label>
                &ensp;&ensp;
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="active" value="Yes" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1">
                        Yes
                    </label>
                </div>
                &ensp;
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="active" value="No" id="flexRadioDefault2" checked>
                    <label class="form-check-label" for="flexRadioDefault2">
                        No
                    </label>
                </div>
            </div>

            <input type="submit" name="submit" value="Add Category" class="btn btn-success">

        </form>

        <?php
        if (isset($_POST['submit'])) {
            $title = $_POST['title'];

            if (isset($_POST['featured'])) {
                $featured = $_POST['featured'];
            } else {
                $featured = "No"; // if the user did not pick => default is NO
            }

            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No"; // if the user did not pick => default is NO
            }

            //Image checking
            if (isset($_FILES['image']['name'])) {
                //upload image

                $file_type = $_FILES['image']['type']; //returns the mimetype

                $allowed = array("image/jpeg", "image/gif", "image/png");
                if(!in_array($file_type, $allowed)) {
                    $_SESSION['upload'] = "<div class='error'>Only jpg, gif, and png files are allowed.</div>";
                    header('location:' . SITEURL . 'admin/add-category.php');
                    die();//WE stop proccess cause wrong image was uploaded
                }
                $image_name=$_FILES['image']['name'];

                if ($image_name != "") {


                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/" . $image_name;

                    $upload = move_uploaded_file($source_path, $destination_path);

                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        header('location:' . SITEURL . 'admin/add-category.php');
                        die();//WE stop proccess cause wrong image was uploaded
                    }
                }
            }else{
                $image_name="";
            }






            $sql = "INSERT INTO tbl_category SET 
                    title = '$title',
                    image_name='$image_name',
                             featured = '$featured',
                             active = '$active'";

            $res = mysqli_query($conn, $sql);

            if ($res == true) {
                $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                header('location:'.SITEURL.'admin/manage_category.php');
            } else {
                //Failed to add category
                $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
                header('location:'.SITEURL.'admin/add_category.php');
            }
        }
        ?>
    </div>
</div>
<?php ob_flush(); ?>
<?php include('partials/footer.php');?>