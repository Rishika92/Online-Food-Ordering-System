<?php include('partials_front/menu.php') ?>

    <!-- Food Search Section -->
    <section class="food-search text-center py-5">
        <div class="container">
            <?php 
            //get the search keyword.
            $search=$_POST['search'];
            ?>
            <h2>Foods on Your Search: <a href="#" class="text-white">"<?php echo $search;?>"</a></h2>
        </div>
    </section>

    <!-- Food Menu Section -->
    <section class="food-menu py-5">
        <div class="container">
            <h2 class="text-center mb-4">Food Menu</h2>
            <?php 
        
            $sql="SELECT *FROM tbl_food WHERE title LIKE '%$search%' or description like '%$search%'";
            $res=mysqli_query($conn,$sql);
            $count=mysqli_num_rows($res);
            if($count>0){
             while($row=mysqli_fetch_assoc($res)){
                $id=$row['id'];
                $title=$row['title'];
                $price=$row['price'];
                $description=$row['description'];
                $image_name=$row['image_name'];
                ?>
               
               <div class="food-menu-box mb-4">
                <div class="food-menu-img">
                <?php 
                if($image_name==""){
                    echo "<div class='error'>Image not available.</div>";
                }else{
                    ?>
                     
                      <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name;?>" alt="Chicken Steam Momo" class="img-fluid img-curve">
              <?php  }
                ?>
                   
                </div>

                <div class="food-menu-desc">
                    <h4><?php echo $title;?></h4>
                    <p class="food-price">$<?php echo $price; ?></p>
                    <p class="food-detail">
                    <?php echo $description;?>
                    </p>
                    <a href="<?php echo SITEURL;?>order.php" class="btn btn-primary">Order Now</a>
                </div>
            </div>
                <?php
             }
            }else{
                echo "<div class='error'>Food not Found.</div>";
            }


            ?>
            
            <div class="clearfix"></div>
        </div>
    </section>
    <?php include('partials_front/footer.php') ?>