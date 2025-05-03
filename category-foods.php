<?php include('partials_front/menu.php') ?>
<?php 
//check whether id is passed or not.
if(isset($_GET['category_id']))
{
    $category_id=$_GET['category_id'];
    //get category title based on category ID.
    $sql="SELECT title FROM tbl_category WHERE id=$category_id";
    //execute the query
    $res=mysqli_query($conn,$sql);
    //get the value from the database.
    $row=mysqli_fetch_assoc($res);
    //get the title.
    $category_title=$row['title'];
}else{
    header('location:'.SITEURL);
}
?>
    <!-- Food Search Section -->
    <section class="food-search text-center py-5">
        <div class="container">
            <h2>Foods in <a href="#" class="text-white"> "<?php echo $category_title;?>" </a>Category</h2>
        </div>
    </section>

    <!-- Food Menu Section -->
    <section class="food-menu py-5">
        <div class="container">
            <h2 class="text-center mb-4">Food Menu</h2>
             <?php 
             //create sql query to get foods based on selected category.
             $sql2="SELECT *FROM tbl_food WHERE category_id=$category_id";
             $res2=mysqli_query($conn,$sql2);
             $count2=mysqli_num_rows($res2);
             if($count2>0){
                while($row2=mysqli_fetch_assoc($res2)){
                //Food is Available.
                $id=$row2['id'];
                $title=$row2['title'];
                $price=$row2['price'];
                $description=$row2['description'];
                $image_name=$row2['image_name'];
                ?>
              
              <div class="food-menu-box">
                <div class="food-menu-img">
                    <?php if($image_name==""){
                      echo "<div class='error'>Image not Available </div>";
                    }else{
                        ?>
                        <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title;?>" class="img-fluid img-curve">
                        <?php
                    }
                  ?>
                    
                </div>

                <div class="food-menu-desc">
                    <h4><?php echo $title; ?></h4>
                    <p class="food-price">$<?php echo $price;?></p>
                    <p class="food-detail">
                         <?php echo $description; ?>
                    </p>
                    <br>
                    <a href="order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                </div>
            </div>



              <?php
                }
             }else{
                //food is not Available.
                echo "<div class='error'>Food not Available.</div>";
             }
             
             ?>
            
            <div class="clearfix"></div>
        </div>
    </section>

    <?php include('partials_front/footer.php') ?>