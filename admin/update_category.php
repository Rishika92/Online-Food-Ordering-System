<?php
include ('partials/menu.php');
?>

<?php ob_start(); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count == 1){
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                $_SESSION['no-category-found'] = "<div class='error'>Category Not Found.</div>";
                header('location:'.SITEURL.'admin/manage_category.php');
            }
        } else {
            header('location:'.SITEURL.'admin/manage_category.php');
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Category Title -->
            <div class="form-group row mb-3">
                <label for="title" class="col-sm-2 col-form-label">Title:</label>
                <div class="col-sm-3">
                    <input required type="text" name="title" class="form-control" id="title" value="<?php echo $title; ?>">
                </div>
            </div>

            <!-- Current Image -->
            <div class="form-group row mb-3">
                <label for="current_image" class="col-sm-2 col-form-label">Current Image:</label>
                <div class="col-sm-3">
                    <?php
                    if ($current_image != "") {
                        echo "<img src='".SITEURL."images/category/$current_image' width='100px'>";
                    } else {
                        echo "<div class='error'>Image Not Added.</div>";
                    }
                    ?>
                </div>
            </div>

            <!-- New Image -->
            <div class="form-group row mb-3">
                <label for="customFile" class="col-sm-2 col-form-label">Select New Image:</label>
                <div class="col-sm-3">
                    <input type="file" name="image" class="form-control" id="customFile" />
                </div>
            </div>

            <!-- Featured Option -->
            <div class="form-group row mb-3">
                <label for="featured" class="col-sm-2 col-form-label">Featured:</label>
                <div class="col-sm-3">
                    <input type="radio" name="featured" value="Yes" <?php if($featured == "Yes") echo "checked"; ?>> Yes
                    <input type="radio" name="featured" value="No" <?php if($featured == "No") echo "checked"; ?>> No
                </div>
            </div>

            <!-- Active Option -->
            <div class="form-group row mb-3">
                <label for="active" class="col-sm-2 col-form-label">Active:</label>
                <div class="col-sm-3">
                    <input type="radio" name="active" value="Yes" <?php if($active == "Yes") echo "checked"; ?>> Yes
                    <input type="radio" name="active" value="No" <?php if($active == "No") echo "checked"; ?>> No
                </div>
            </div>

            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <!-- Submit Button -->
            <div class="form-group row mb-3">
                <div class="col-sm-3 offset-sm-2">
                    <input type="submit" name="submit" value="Update Category" class="btn btn-success w-100">
                </div>
            </div>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            if (isset($_FILES['image']['name'])) {
                $image_name = $_FILES['image']['name'];

                if ($image_name != "") {
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/" . $image_name;

                    $upload = move_uploaded_file($source_path, $destination_path);

                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        header('location:' . SITEURL . 'admin/manage_category.php');
                        die();
                    }

                    if ($current_image != "") {
                        $remove_path = "../images/category/" . $current_image;
                        $remove = unlink($remove_path);

                        if ($remove == false) {
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                            header('location:' . SITEURL . 'admin/manage_category.php');
                            die();
                        }
                    }
                } else {
                    $image_name = $current_image;
                }
            } else {
                $image_name = $current_image;
            }

            $sql2 = "UPDATE tbl_category SET
                title = '$title',
                image_name = '$image_name',
                featured = '$featured',
                active = '$active' WHERE id = $id";

            $res2 = mysqli_query($conn, $sql2);

            if ($res2 == true) {
                $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                header('location:' . SITEURL . 'admin/manage_category.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
                header('location:' . SITEURL . 'admin/manage_category.php');
            }
        }
        ?>

    </div>
</div>

<?php ob_flush(); ?>

<?php
include ('partials/footer.php');
?>
