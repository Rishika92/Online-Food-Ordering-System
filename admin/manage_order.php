<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>

        <br>
        <br>
        <br>

        <?php
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>
        <br>
        <table class="table tbl-full">
            <thead>
            <tr >
                <th>ID</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Customer Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
            </thead>


            <?php
                $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; // latest order will be on top
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            $sn = 1;

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $food = $row[ 'food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];
                    $customer_name =$row['customer_name'];
                    $customer_contact =$row['customer_contact'];
                    $customer_email =$row['customer_email'];
                    $customer_address = $row['customer_address'];

                    ?>
                        <tbody>
                        <tr>
                            <td><?php echo $sn++;?>. </td>
                            <td><?php echo $food;?></td>
                            <td>$<?php echo $price;?></td>

                            <td><?php echo $qty;?></td>

                            <td>$<?php echo $total;?></td>
                            <td><?php echo $order_date;?></td>

                            <td>
                                <?php
                                if ($status == "Ordered") {
                                    echo "<b style=''>$status</b>";
                                }else if($status == "On Delivery") {
                                    echo "<b style='color: orange;'>$status</b>";
                                }else if($status == "Delivered") {
                                    echo "<b style='color:green;'>$status</b>";
                                }else if($status == "Cancelled") {
                                    echo "<b style='color: red'>$status</b>";
                                }
                                ?>
                            </td>

                            <td><?php echo $customer_name;?></td>
                            <td><?php echo $customer_contact;?></td>
                            <td><?php echo $customer_email;?></td>
                            <td><?php echo $customer_address;?></td>
                            <td>
                                <a href="<?php echo SITEURL;?>admin/update_order.php?id=<?php  echo $id;?>"
                                   class="btn btn-info">Update Order</a>
                            </td>
                        </tr>

                    <?php
                }

            }else{
                //order not available
                echo "<tr><td class='error' colspan='12'>Orders Not Available.</td></tr>";
            }
            ?>

                        </tbody>

        </table>
    </div>
</div>
<?php include('partials/footer.php'); ?>