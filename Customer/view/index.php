<?php

?>
<!DOCTYPE html>
<html>

<head>
    <title>Gadget Store</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="dashboard-page">

<div class="app">

<div class="sidebar">

<div class="logo-area">
<div class="logo-icon">🛍️</div>
<label>Gadget Store</label>
</div>

<div class="sidebar-nav">

<a href="index.php" class="nav-item active">
<label>Dashboard</label>
</a>

<a href="viewCart.php" class="nav-item">
<label>View Cart</label>
</a>

<a href="myOrders.php" class="nav-item">
<label>My Orders</label>
</a>

<a href="accountSettings.php" class="nav-item">
<label>Account Settings</label>
</a>

</div>

<a href="../controller/logout.php" class="nav-item logout">
<label>Logout</label>
</a>

</div>


<div class="main-area">

<div class="topbar">

<div class="search-box">

<label class="search-icon">⌕</label>

<input type="text"
placeholder="Search for products..."
id="searchInput">

</div>

</div>


<div class="content">

<div class="main-column">

<div class="section-header">

<h2>Featured Products</h2>

<button class="view-all">View All</button>

</div>


<div class="products-grid">


<div class="product-card">

<div class="product-image laptop-product">

<div class="mini-laptop">

<div class="mini-screen"></div>

<div class="mini-base"></div>

</div>

</div>


<div class="product-info">

<h3>Dell Inspiron 15</h3>

<p>
15.6” FHD, Intel i5 12th Gen,
<br>
8GB RAM, 512GB SSD
</p>

<b>৳85,039</b>


<form action="../controller/addToCart.php" method="post">

<input type="hidden"
name="product_name"
value="Dell Inspiron 15">

<button type="submit" class="add-cart">
Add to Cart
</button>

</form>

</div>

</div>



<div class="product-card">

<div class="product-image">

<div class="headphone">

<div class="headband"></div>

<div class="ear left"></div>

<div class="ear right"></div>

</div>

</div>


<div class="product-info">

<h3>Sony WH-CH520</h3>

<p>
Wireless On-Ear Headphones,
<br>
Up to 50H Battery
</p>

<b>৳7,287</b>


<form action="../controller/addToCart.php" method="post">

<input type="hidden"
name="product_name"
value="Sony WH-CH520">

<button type="submit" class="add-cart">
Add to Cart
</button>

</form>

</div>

</div>



<div class="product-card">

<div class="product-image">

<div class="smartwatch">

<div class="watch-screen">12:45</div>

<div class="watch-strap top"></div>

<div class="watch-strap bottom"></div>

</div>

</div>


<div class="product-info">

<h3>boAt Wave Flex</h3>

<p>
1.83” Display, Bluetooth Calling,
<br>
100+ Sports Modes
</p>

<b>৳3,643</b>


<form action="../controller/addToCart.php" method="post">

<input type="hidden"
name="product_name"
value="boAt Wave Flex">

<button type="submit" class="add-cart">
Add to Cart
</button>

</form>

</div>

</div>



<div class="product-card">

<div class="product-image">

<div class="earbuds">

<div class="bud bud-left"></div>

<div class="bud bud-right"></div>

<div class="case">

<div class="case-inner"></div>

</div>

</div>

</div>


<div class="product-info">

<h3>Realme Buds T300</h3>

<p>
30dB ANC, 360° Spatial Audio,
<br>
40H Total Playback
</p>

<b>৳6,073</b>


<form action="../controller/addToCart.php" method="post">

<input type="hidden"
name="product_name"
value="Realme Buds T300">

<button type="submit" class="add-cart">
Add to Cart
</button>

</form>

</div>

</div>


</div>

</div>

</div>

</div>

</div>

</body>

</html>