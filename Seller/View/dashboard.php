<?php

require_once("../Model/DashboardModel.php");

$dashboardModel = new DashboardModel();

$totalProducts = $dashboardModel->getTotalProducts();
$pendingOrders = $dashboardModel->getPendingOrders();
$totalSales = $dashboardModel->getTotalSales();
$recentOrders = $dashboardModel->getRecentOrders();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body>

<div class="sidebar">

<div class="logo logo-area">

    <div class="logo-icon">
        <i data-lucide="shopping-bag"></i>
    </div>

    <span>Gadget Store</span>

</div>
    <a href="dashboard.php" class="active">Dashboard</a>
    <a href="products.php">Products</a>
    <a href="orders.php">Orders</a>
    <a href="inventory.php">Inventory</a>
    <a href="accountSettings.php">Account Settings</a>
<div class="logout">
    <a href="../Controller/logout.php"
       onclick="return confirm('Are you sure you want to logout?');">
        Logout
    </a>
</div>



</div>


<div class="main">

    <div class="topbar">

        <h1>Seller Dashboard</h1>

    

    </div>


    <div class="content">

        <p class="welcome">
            Welcome back . Here is your store performance.
        </p>


        <div class="cards">


            <div class="card">

                <h3>Total Products</h3>

                <h1>
                    <?php echo $totalProducts; ?>
                </h1>

                <p>Active Listings</p>

            </div>


            <div class="card">

                <h3>Pending Orders</h3>

                <h1>
                    <?php echo $pendingOrders; ?>
                </h1>

                <p>Waiting for Processing</p>

            </div>


            <div class="card">

                <h3>Total Sales</h3>

                <h1>
                    ৳<?php echo $totalSales; ?>
                </h1>

                <p>Delivered Orders</p>

            </div>


        </div>


        <div class="table-box">

            <div class="table-title">

                <h2>Recent Orders</h2>

                <a href="orders.php">View All</a>

            </div>


            <table>

                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>


                <?php

                if($recentOrders->num_rows > 0)
                {

                    while($order = $recentOrders->fetch_assoc())
                    {

                ?>

                <tr>

                    <td>
                        #<?php echo $order["id"]; ?>
                    </td>


                    <td>
                        <?php echo $order["customer_name"]; ?>
                    </td>


                    <td>
                        <?php echo $order["order_date"]; ?>
                    </td>


                    <td>
                        ৳<?php echo $order["total_price"]; ?>
                    </td>


                    <td>

                        <?php echo $order["status"]; ?>

                    </td>

                </tr>

                <?php

                    }

                }
                else
                {

                ?>

                <tr>

                    <td colspan="5">
                        No recent orders found
                    </td>

                </tr>

                <?php

                }

                ?>

            </table>

        </div>

    </div>

</div>


<script src="script.js"></script>

<script>
    lucide.createIcons();
</script>

</body>

</html>