<?php
require_once("../model/DatabaseConnection.php");

$db = new DatabaseConnection();
$connection = $db->openConnection();
$cartItems = $db->getCartItems($connection, "cart");
?>

<!DOCTYPE html>
<html>
<head>
<title>View Cart - Gadget Store</title>
<link rel="stylesheet" href="style.css">
</head>

<body class="cart-page">
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

<a href="viewCart.php" class="nav-item active">
<label>View Cart</label>
</a>

<a href="myOrders.php" class="nav-item">
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
<div class="topbar"></div>

<div class="content">
<div class="cart-header">
<h2>My Cart</h2>
</div>

<div class="cart-container">
<div class="cart-items">

<?php
$subtotal = 0;

if ($cartItems) {
    while ($row = $cartItems->fetch_assoc()) {

        $productName = $row["product_name"];
        $quantity = $row["quantity"];

        if ($productName == "Dell Inspiron 15") {
            $price = 85039;
        } elseif ($productName == "Sony WH-CH520") {
            $price = 7287;
        } elseif ($productName == "boAt Wave Flex") {
            $price = 3643;
        } elseif ($productName == "Realme Buds T300") {
            $price = 6073;
        } else {
            $price = 0;
        }

        $totalPrice = $price * $quantity;
        $subtotal = $subtotal + $totalPrice;
?>

<div class="cart-item">

<div class="cart-product-info">
<h3><?php echo $productName; ?></h3>
<p>Gadget Store Product</p>
<b>৳<?php echo $price; ?></b>
</div>

<div class="quantity-section">
<label>Quantity</label>

<div class="quantity-control">
<form action="../controller/updateQuantity.php" method="POST">

<input type="hidden" name="id" value="<?php echo $row["id"]; ?>">

<button type="submit" name="action" value="minus">
-
</button>

<label><?php echo $quantity; ?></label>

<button type="submit" name="action" value="plus">
+
</button>

</form>
</div>
</div>

<form action="../controller/removeFromCart.php" method="POST">
<input type="hidden" name="id" value="<?php echo $row["id"]; ?>">

<button type="submit" class="remove-btn">
Remove
</button>
</form>

</div>

<?php
    }
} else {
?>

<p>Your cart is empty.</p>

<?php
}
?>

</div>

<div class="cart-summary">
<h2>Order Summary</h2>

<div class="summary-item">
<label>Subtotal</label>
<b>৳<?php echo $subtotal; ?></b>
</div>

<div class="summary-item">
<label>Shipping</label>
<b>৳0</b>
</div>

<div class="summary-item total">
<label>Total</label>
<b>৳<?php echo $subtotal; ?></b>
</div>

<form action="../controller/placeOrder.php" method="POST">
<button type="submit" class="checkout-btn">
Place Order
</button>
</form>

</div>
</div>
</div>
</div>

</div>
</body>
</html>