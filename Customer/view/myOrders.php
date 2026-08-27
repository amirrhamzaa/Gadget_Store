<?php
require_once("../model/DatabaseConnection.php");

$db = new DatabaseConnection();
$connection = $db->openConnection();

$orders = $db->getOrders($connection);
?>

<!DOCTYPE html>
<html>
<head>
<title>My Orders - Gadget Store</title>
<link rel="stylesheet" href="style.css">
</head>

<body class="orders-page">

<div class="app">

<div class="sidebar">

<div class="logo-area">
<div class="logo-icon">🛍️</div>
<label>Gadget Store</label>
</div>

<div class="sidebar-nav">

<a href="index.php" class="nav-item">
<label>Dashboard</label>
</a>

<a href="viewCart.php" class="nav-item">
<label>View Cart</label>
</a>

<a href="myOrders.php" class="nav-item active">
<label>My Orders</label>
</a>

<a href="accountSettings.php" class="nav-item">
<label>Account Settings</label>
</a>

</div>

<a href="logout.php" class="nav-item logout">
<label>Logout</label>
</a>

</div>


<div class="main-area">

<div class="topbar">
</div>

<div class="content">

<div class="orders-header">
<h2>My Orders</h2>
</div>

<div class="orders-container">

<?php

if ($orders && $orders->num_rows > 0) {

    while ($row = $orders->fetch_assoc()) {

        $orderId = $row["id"];
        $productName = $row["product_name"];
        $quantity = $row["quantity"];
        $price = $row["price"];
        $totalPrice = $row["total_price"];
        $orderDate = $row["order_date"];

?>

<div class="order-card">

<div class="order-top">

<div>
<h3>Order #<?php echo $orderId; ?></h3>
<p>Order Date: <?php echo date("d F Y", strtotime($orderDate)); ?></p>
</div>

<div class="order-status">
Placed
</div>

</div>


<div class="order-products">

<div class="order-product">

<div class="product-info">

<h3><?php echo $productName; ?></h3>

<p>
Quantity: <?php echo $quantity; ?>
</p>

<p>
Price: ৳<?php echo $price; ?>
</p>

</div>

</div>

</div>


<div class="order-bottom">

<div>

<label>Total Amount</label>

<b>
৳<?php echo $totalPrice; ?>
</b>

</div>

<button class="view-order-btn">
View Order
</button>

</div>

</div>

<?php

    }

} else {

?>

<p>No orders found.</p>

<?php

}

?>

</div>

</div>

</div>

</div>

</body>
</html>