<?php include('partials_front/menu.php') ?>

    <!-- Hero Section Starts Here -->
    <header class="hero bg-gradient text-dark text-center py-5">
        <div class="container">
            <h1 class="display-3 mb-3 text-center">Delicious Food</h1>
            <p class="lead mb-4">Order your favorite food and enjoy it wherever you are, whenever you want.</p>
            <a href="<?php SITEURL;?>foods.php" class="btn btn-warning btn-lg">Explore Menu</a>
        </div>
    </header>
    <!-- Hero Section Ends Here -->

    <!-- Food Search Section Starts Here -->
    <section class="food-search text-center py-5 bg-light">
        <div class="container">
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST" class="d-flex justify-content-center">
                <input type="search" name="search" placeholder="Search for Food.." class="form-control me-2" required
                    style="max-width: 400px; border-radius: 30px;">
                <button type="submit" class="btn btn-primary rounded-pill px-4">Search</button>
            </form>
        </div>
    </section>
    <!-- Food Search Section Ends Here -->
   <?php 
      if(isset($_SESSION['order'])){
        echo $_SESSION['order'];
        unset($_SESSION['order']);
      }
   ?>
    <!-- Categories Section Starts Here -->
    <section class="categories py-5">
    <div class="container-fluid">
        <h2 class="text-center mb-5">Explore Our Categories</h2>

        <div class="row">
            <?php 
            // Fetch all categories from the database
            $sql = "SELECT * FROM tbl_category WHERE active='Yes' and featured='Yes' LIMIT 4"; 
            $res = mysqli_query($conn, $sql);

            if(mysqli_num_rows($res) > 0){
                while($row = mysqli_fetch_assoc($res)){
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <a href="<?php echo SITEURL;?>category-foods.php?category_id=<?php echo $id; ?>" class="text-decoration-none">
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

            
    <!-- Categories Section Ends Here -->




    <!-- Food Menu Section Starts Here -->
    <section class="food-menu py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Food Menu</h2>
        <div class="row">
            <?php 
            $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";
            $res2 = mysqli_query($conn, $sql2);

            if(mysqli_num_rows($res2) > 0){
                while($row = mysqli_fetch_assoc($res2)){
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
            ?>
                <div class="col-md-4 mb-4">
                    <div class="food-item p-3 bg-white shadow-sm rounded-4 h-100 text-center">
                        <?php if($image_name == "") { ?>
                            <div class="text-danger py-4">Image not Available.</div>
                        <?php } else { ?>
                            <div class="image-box mb-3" style="height: 220px; width: 100%; overflow: hidden;">
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" 
                                     alt="<?php echo $title; ?>" 
                                     style="height: 100%; width: 100%; object-fit: contain;"
                                     class="img-fluid">
                            </div>
                        <?php } ?>
                        <h4 class="mt-2"><?php echo $title; ?></h4>
                        <p class="food-price text-primary fw-semibold">$<?php echo $price; ?></p>
                        <p class="food-description text-muted"><?php echo $description; ?></p>
                        <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" 
                           class="btn btn-primary btn-lg mt-2">Order Now</a>
                    </div>
                </div>
            <?php 
                }
            } else {
                echo "<div class='col-12 text-center text-danger'>Food not available.</div>";
            }
            ?>
        </div>
    </div>
    <div class="text-center mt-4">
    <a href="<?php echo SITEURL; ?>foods.php" class="btn btn-outline-primary btn-lg rounded-pill px-5">
        See All Foods
    </a>
</div>

</section>

   <?php include('partials_front/footer.php'); ?>