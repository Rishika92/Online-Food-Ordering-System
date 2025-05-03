<?php include('partials_front/menu.php') ?>
<section class="categories py-5">
    <div class="container-fluid">
        <h2 class="text-center mb-5">Explore Our Categories</h2>

        <div class="row">
            <?php 
            // Fetch all categories from the database
            $sql = "SELECT * FROM tbl_category WHERE active='Yes'"; 
            $res = mysqli_query($conn, $sql);

            if(mysqli_num_rows($res) > 0){
                while($row = mysqli_fetch_assoc($res)){
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="category-foods.php?category_id=<?php echo $id; ?>" class="text-decoration-none">
                        <div class="card h-100 shadow-sm border-0">
                            <?php 
                            if($image_name == ""){
                                echo "<div class='text-danger text-center py-4'>Image not Available</div>";
                            } else {
                            ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" 
                                     alt="<?php echo $title; ?>" 
                                     class="card-img-top img-fluid rounded-top" 
                                     style="height: 200px; object-fit: cover;">
                            <?php } ?>
                            <div class="card-body text-center">
                                <h5 class="card-title text-dark"><?php echo $title; ?></h5>
                            </div>
                        </div>
                    </a>
                </div>
            <?php 
                }
            } else {
                echo "<div class='col-12 text-center text-danger'>Category not Added.</div>";
            }
            ?>
        </div>
    </div>
</section>

          
<?php include('partials_front/footer.php') ?>
