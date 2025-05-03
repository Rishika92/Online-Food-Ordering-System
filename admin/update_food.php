<?php ob_start(); ?>
<?php include('partials/menu.php'); ?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
    $res2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($res2);

    $category_title = $row2['title'];
    $description = $row2['description'];
    $price = $row2['price'];
    $current_image = $row2['image_name'];
    $current_category = $row2['category_id'];
    $featured = $row2['featured'];
    $active = $row2['active'];
} else {
    header('location:' . SITEURL . 'admin/manage_food.php');
}
?>

<div class="main-content py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="card shadow-lg border-0">
            <div class="card-body p-5">
                <h2 class="text-center mb-4 text-primary fw-bold">Update Food</h2>

                <form action="" method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input required type="text" name="title" class="form-control" id="title" value="<?php echo $category_title; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="desc_food" class="form-label">Description:</label>
                        <textarea required name="description" cols="30" rows="5" class="form-control" id="desc_food"><?php echo $description; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="food_price" class="form-label">Price:</label>
                        <input required type="number" name="price" class="form-control" id="food_price" value="<?php echo $price; ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Current Image:</label>
                        <div>
                            <?php if ($current_image != "") { ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="120px" class="img-thumbnail">
                            <?php } else {
                                echo "<div class='text-danger'>Image Not Available.</div>";
                            } ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="customFile" class="form-label">Select New Image:</label>
                        <input type="file" name="image" class="form-control" id="customFile" />
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category:</label>
                        <select class="form-select" name="category" id="category">
                            <?php
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($res);
                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_id = $row['id'];
                                    $category_title = $row['title'];
                                    ?>
                                    <option <?php if ($current_category == $category_id) echo "selected"; ?> value="<?= $category_id; ?>"><?= $category_title; ?></option>
                                    <?php
                                }
                            } else {
                                echo "<option value='0'>No Category Found</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Featured:</label>
                        <div class="form-check form-check-inline">
                            <input id="radio1" class="form-check-input" type="radio" name="featured" value="Yes" <?php if ($featured == "Yes") echo "checked"; ?>>
                            <label class="form-check-label" for="radio1">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input id="radio2" class="form-check-input" type="radio" name="featured" value="No" <?php if ($featured == "No") echo "checked"; ?>>
                            <label class="form-check-label" for="radio2">No</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label d-block">Active:</label>
                        <div class="form-check form-check-inline">
                            <input id="active1" class="form-check-input" type="radio" name="active" value="Yes" <?php if ($active == "Yes") echo "checked"; ?>>
                            <label class="form-check-label" for="active1">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input id="active2" class="form-check-input" type="radio" name="active" value="No" <?php if ($active == "No") echo "checked"; ?>>
                            <label class="form-check-label" for="active2">No</label>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                    <div class="text-center">
                        <input type="submit" name="submit" value="Update Food" class="btn btn-primary px-4 py-2">
                    </div>
                </form>

                <?php
                if (isset($_POST['submit'])) {
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $current_image = $_POST['current_image'];
                    $category = $_POST['category'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];

                    if (isset($_FILES['image']['name'])) {
                        $image_name = $_FILES['image']['name'];
                        if ($image_name != "") {
                            $src_path = $_FILES['image']['tmp_name'];
                            $dest_path = "../images/food/" . $image_name;
                            $upload = move_uploaded_file($src_path, $dest_path);
                            if ($upload == false) {
                                $_SESSION['upload'] = "<div class='error'>Failed to Upload new Image.</div>";
                                header('location:' . SITEURL . 'admin/manage_food.php');
                                die();
                            }
                            if ($current_image != "") {
                                $remove_path = "../images/food/" . $current_image;
                                $remove = unlink($remove_path);
                                if ($remove == false) {
                                    $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";
                                    header('location:' . SITEURL . 'admin/manage_food.php');
                                    die();
                                }
                            }
                        } else {
                            $image_name = $current_image;
                        }
                    } else {
                        $image_name = $current_image;
                    }

                    $sql3 = "UPDATE tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = $category,
                        featured = '$featured',
                        active = '$active' 
                        WHERE id = $id";

                    $res3 = mysqli_query($conn, $sql3);

                    if ($res3 == true) {
                        $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                        header('location:' . SITEURL . 'admin/manage_food.php');
                    } else {
                        $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
                        header('location:' . SITEURL . 'admin/manage_food.php');
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include('partials/footer.php'); ?>
<?php ob_flush(); ?>
