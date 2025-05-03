<?php include('partials/menu.php'); ?>

<!-- Main -->
<div class="main-content py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <h1 class="text-center fw-bold text-primary mb-5">Dashboard</h1>

        <?php
        if (isset($_SESSION['login-page'])) {
            echo "<div class='alert alert-success text-center' role='alert'>" . $_SESSION['login-page'] . "</div>";
            unset($_SESSION['login-page']);
        }

        // Categories
        $sql = "SELECT * FROM tbl_category";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        // Foods
        $sql2 = "SELECT * FROM tbl_food";
        $res2 = mysqli_query($conn, $sql2);
        $count2 = mysqli_num_rows($res2);

        // Orders
        $sql3 = "SELECT * FROM tbl_order";
        $res3 = mysqli_query($conn, $sql3);
        $count3 = mysqli_num_rows($res3);

        // Total Income from Delivered orders
        $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered'";
        $res4 = mysqli_query($conn, $sql4);
        $row4 = mysqli_fetch_assoc($res4);
        $total_income = $row4['Total'] ?? 0;
        ?>

        <div class="row g-4 justify-content-center mb-4">
            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h2 class="text-primary"><?php echo $count; ?></h2>
                        <p class="text-muted mb-0">Categories</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h2 class="text-success"><?php echo $count2; ?></h2>
                        <p class="text-muted mb-0">Foods</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h2 class="text-warning"><?php echo $count3; ?></h2>
                        <p class="text-muted mb-0">Total Orders</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h2 class="text-danger">$<?php echo $total_income; ?></h2>
                        <p class="text-muted mb-0">Total Income</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart.js Analytics -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title text-center mb-4 fw-bold text-dark">Analytics Overview</h5>
                <canvas id="analyticsChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>
<!-- Main End -->

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('analyticsChart').getContext('2d');
    const analyticsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Categories', 'Foods', 'Orders', 'Income'],
            datasets: [{
                label: 'Count / Amount',
                data: [<?php echo $count; ?>, <?php echo $count2; ?>, <?php echo $count3; ?>, <?php echo $total_income; ?>],
                backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545'],
                borderRadius: 10
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            if (context.dataIndex === 3) {
                                return '$' + context.formattedValue;
                            }
                            return context.formattedValue;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php include('partials/footer.php'); ?>
