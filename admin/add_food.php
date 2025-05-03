<?php ob_start(); ?>
<?php include ('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <?php
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <br><br>
        <form enctype="multipart/form-data" action="" method="POST">
            <div class="form-group row">
                <label for="title_food" class="col-sm-2 col-form-label">Title: </label>
                <div class="col-sm-3">
                    <input required type="text" name="title" class="form-control" id="title_food"
                           placeholder="Food Title">
                </div>
            </div>

            <div class="form-group row">
                <label for="desc_food" class="col-sm-2 col-form-label">Description: </label>
                <div class="col-sm-3">
                    <textarea required name="description"  cols="30" rows="5" class="form-control" id="desc_food"
                              placeholder="Food Description"></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="food_price" class="col-sm-2 col-form-label">Price: </label>
                <div class="col-sm-3">
                    <input required type="number" name="price" class="form-control" id="food_price"
                           placeholder="Food Price">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label mb-3 " for="customFile">Select Image: </label>
                <div class="col-sm-3">
                    <input type="file" name="image" class="form-control" id="customFile" />
                </div>
            </div>

            <div class="form-group row">
                <label for="category" class="col-sm-2 col-form-label">Category: </label>
                <div >
                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="category" id="category">
                            <?php
                            //Displaying categories from DB
                            //Only active categories will be displayed

                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);

                            $count = mysqli_num_rows($res);

                            if ($count > 0) {

                                while ($row = mysqli_fetch_assoc($res)) {
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>
                                    <option value="<?= $id; ?>"><?= $title;?></option>
                                    <?php
                                }
                            }else{
                                ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                }
                            ?>
                    </select>
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
                       data-toggle="tooltip" data-placement="left"
                       title="If you pick 'No' the category will not be visible in home page nor category page">
                    Active:
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

            <input type="submit" name="submit" value="Add Food" class="btn btn-success">

        </form>

        <?php
        if (isset($_POST['submit'])) {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            //Featured
            if (isset($_POST['featured'])) {
                $featured = $_POST['featured'];
            } else {
                $featured = "No";//Default
            }
            //Active
            if (isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No";//Default
            }

            //Image
            if (isset($_FILES['image']['name'])) {


                $file_type = $_FILES['image']['type']; //returns the mimetype

                $allowed = array("image/jpeg", "image/gif", "image/png");
                if(!in_array($file_type, $allowed)) {
                    $_SESSION['upload'] = "<div class='error'>Only jpg, gif, and png files are allowed.</div>";
                    header('location:'.SITEURL.'admin/add_food.php');
                    die();//WE stop process cause wrong image was uploaded
                }


                $image_name = $_FILES['image']['name'];
                if ($image_name != "") {
                    $source_path = $_FILES['image']['tmp_name'];//current location of the image
                    $destination_path = "../images/food/" . $image_name;

                    $upload = move_uploaded_file($source_path, $destination_path);

                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        header('location:'.SITEURL.'admin/add_food.php');
                        die();//WE stop process cause wrong image was uploaded
                    }
                } else {
                    $image_name = "";//Default
                }
            }

                $sql2 = "INSERT INTO tbl_food SET 
                    title = '$title',
                    description ='$description',
                    price = $price,
                    image_name='$image_name',
                    category_id = $category,
                             featured = '$featured',
                             active = '$active'
                             ";

                $res22 = mysqli_query($conn, $sql2);

                if ($res22 == true) {
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage_food.php');
                } else {
                    //Failed to add category
                    $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                    header('location:'.SITEURL .'admin/manage_food.php');
                }
            }
            ?>
    </div>
</div>

<?php include ('partials/footer.php');?>
<?php ob_flush(); ?>