<?php
ob_start();
include('partials_front/menu.php');

// Check if food ID is set
if (isset($_GET['food_id'])) {
    $food_id = mysqli_real_escape_string($conn, $_GET['food_id']);
    $sql = "SELECT * FROM tbl_food WHERE id = $food_id";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $price = $row['price'];
        $image_name = $row['image_name'];
    } else {
        header('location:' . SITEURL);
        exit();
    }
} else {
    header('location:' . SITEURL);
    exit();
}

?>

<section class="food-search bg-light py-5">
    <div class="container">
        <h2 class="text-center text-dark mb-4">Fill this form to confirm your order</h2>

        <?php 
        if (isset($_SESSION['order'])) {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
        ?>

        <div class="card shadow-sm border-0 mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <form action="" method="POST" class="order">
                    <fieldset class="mb-4">
                        <legend class="h5 text-primary mb-3">Selected Food</legend>
                        <div class="text-center mb-3">
                            <?php 
                            if ($image_name == "") {
                                echo "<div class='error text-center'>Image not Available.</div>";
                            } else {
                                echo "<img src='".SITEURL."images/food/$image_name' alt='Food' class='img-fluid img-curve shadow-lg'>";
                            }
                            ?>
                        </div>
                        <div class="text-center">
                            <h4 class="display-5 text-dark"><?php echo $title; ?></h4>
                            <input type="hidden" name="food" value="<?php echo $title; ?>">
                            <p class="food-price text-primary h4">$<?php echo $price; ?></p>
                            <input type="hidden" name="price" value="<?php echo $price; ?>">
                            <label class="order-label">Quantity</label>
                            <input type="number" name="qty" class="form-control mb-3" value="1" required>
                        </div>
                    </fieldset>

                    <fieldset class="mb-4">
                        <legend class="h5 text-primary mb-3">Delivery Details</legend>
                        <label class="order-label">Full Name</label>
                        <input type="text" name="full-name" class="form-control mb-3" required>
                        <label class="order-label">Phone Number</label>
                        <input type="tel" name="contact" class="form-control mb-3" required>
                        <label class="order-label">Email</label>
                        <input type="email" name="email" class="form-control mb-3" required>
                        <label class="order-label">Address</label>
                        <textarea name="address" rows="5" class="form-control mb-3" required></textarea>

                        <label class="order-label">Coupon Code (Optional)</label>
                        <input type="text" name="coupon_code" class="form-control mb-3">

                        <label class="order-label">Payment Method</label>
                        <select name="payment_method" class="form-control mb-3" required>
                            <option value="COD">Cash on Delivery</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="PayPal">PayPal</option>
                        </select>

                        <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary btn-lg w-100 mt-4 rounded-pill">
                    </fieldset>
                </form>
            </div>
        </div>

        <?php 
        if (isset($_POST['submit'])) {
            // Retrieve form values
            $food = mysqli_real_escape_string($conn, $_POST['food']);
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $total = $price * $qty;
            $order_date = date("Y-m-d H:i:s");
            $status = "Ordered";
            $customer_name = mysqli_real_escape_string($conn, $_POST['full-name']);
            $customer_contact = mysqli_real_escape_string($conn, $_POST['contact']);
            $customer_email = mysqli_real_escape_string($conn, $_POST['email']);
            $customer_address = mysqli_real_escape_string($conn, $_POST['address']);
            $payment_method = $_POST['payment_method'];
            $coupon_code = mysqli_real_escape_string($conn, $_POST['coupon_code']);

            // Handle coupon code (optional)
            $coupon_id = "NULL";
            if (!empty($coupon_code)) {
                $coupon_query = "SELECT Coupon_ID FROM tbl_coupon WHERE Code = '$coupon_code'";
                $coupon_res = mysqli_query($conn, $coupon_query);
                if ($coupon_res && mysqli_num_rows($coupon_res) > 0) {
                    $coupon_data = mysqli_fetch_assoc($coupon_res);
                    $coupon_id = $coupon_data['Coupon_ID'];
                }
            }

            // Step 1: Insert the order into the tbl_order table
            $sql2 = "INSERT INTO tbl_order SET 
                food='$food',
                price=$price,
                qty=$qty,
                total=$total,
                order_date='$order_date',
                status='$status',
                customer_name='$customer_name',
                customer_contact='$customer_contact',
                customer_email='$customer_email',
                customer_address='$customer_address',
                coupon_id=$coupon_id";

            $res2 = mysqli_query($conn, $sql2);
            if ($res2) {
                // Get the inserted order ID
                $order_id = mysqli_insert_id($conn);

                // Step 2: Insert the payment record into tbl_payment using the order ID
                $insert_payment = "INSERT INTO tbl_payment (order_id, Payment_Method, Payment_Status)
                                   VALUES ('$order_id', '$payment_method', 'Pending')";
                mysqli_query($conn, $insert_payment);

                $_SESSION['order'] = "<div class='alert alert-success text-center'>
                        <i class='fa fa-check-circle'></i> Order Successfully Placed. Status: <strong>$status</strong>
                      </div>";

                // Redirect to payment page if PayPal or Credit Card
                if ($payment_method == 'PayPal') {
                    // PayPal redirect (example)
                    header('location: ' . $paypal_url . '?cmd=_xclick&business=' . $paypal_email . '&item_name=' . $food . '&amount=' . $total . '&currency_code=USD&return=' . SITEURL . 'payment_success.php&cancel_return=' . SITEURL . 'payment_cancel.php');
                    exit();
                } elseif ($payment_method == 'Credit Card') {
                    // Redirect to Stripe payment page
                    header('location: stripe_payment_page.php?amount=' . $total . '&currency=USD');
                    exit();
                } else {
                    // For Cash on Delivery (COD), just redirect back to home
                    header('location:' . SITEURL);
                }
            } else {
                $_SESSION['order'] = "<div class='alert alert-danger text-center'>
                    <i class='fa fa-times-circle'></i> Failed to place order.
                </div>";
                header('location:' . SITEURL);
            }
        }
        ?>
    </div>
</section>

<?php include('partials_front/footer.php'); ?>
<?php ob_end_flush(); ?>
