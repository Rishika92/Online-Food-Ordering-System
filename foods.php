<?php include('partials_front/menu.php') ?>
    <!-- Food Search Section -->
<section class="food-search text-center py-5">
    <div class="container">
        <form action="food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required class="form-control mb-3">
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>

<!-- Food Menu Section -->
<section class="food-menu py-5">
    <div class="container">
        <h2 class="text-center mb-4">Food Menu</h2>
        
        <?php
            $sql = "SELECT * FROM tbl_food WHERE active='Yes'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            
            if($count > 0){
                while($row = mysqli_fetch_assoc($res)){
                    $id = $row['id'];
                    $title = $row['title'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
        ?>

        <div class="food-menu-box mb-4">
            <div class="food-menu-img">
                <?php 
                if($image_name == ""){
                    echo "<div class='error'>Image not Available.</div>";
                } else {
                    ?>
                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-fluid img-curve">
                    <?php
                }
                ?>
            </div>

            <div class="food-menu-desc">
                <h4><?php echo $title; ?></h4>
                <p class="food-price">$<?php echo $price; ?></p>
                <p class="food-detail"><?php echo $description; ?></p>
                <a href="order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
            </div>
        </div>

        <?php
                }
            } else {
                echo "<div class='error'>Food not Found.</div>";
            }
        ?>
    </div>
</section>

    <?php include('partials_front/footer.php') ?>