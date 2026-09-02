<!DOCTYPE html>
<html>

<head>
    <title>Account Settings - Gadget Store</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="sidebar">

    <div class="logo">Gadget Store</div>

    <a href="dashboard.php">Dashboard</a>
    <a href="products.php">Products</a>
    <a href="orders.php">Orders</a>
    <a href="inventory.php">Inventory</a>
    <a href="accountSettings.php" class="active">Account Settings</a>

    <div class="logout">
        <a href="#">Logout</a>
    </div>

</div>


<div class="main">

    <div class="topbar">
        <h1>Account Settings</h1>
    </div>


    <div class="content">

        <p class="welcome">
            Manage your seller account information.
        </p>

        <div class="table-box">

            <h2>Edit Profile</h2>

            <br>

            <form onsubmit="return validateSettings()">

                <label>Store Name</label>
                <br>
                <input type="text" id="storeName">
                <p id="storeNameError"></p>

                <label>Seller Name</label>
                <br>
                <input type="text" id="sellerName">
                <p id="sellerNameError"></p>

                <label>Email</label>
                <br>
                <input type="text" id="email">
                <p id="emailError"></p>

                <label>Phone Number</label>
                <br>
                <input type="text" id="phone">
                <p id="phoneError"></p>

                <label>Store Address</label>
                <br>
                <textarea id="address"></textarea>
                <p id="addressError"></p>

                <button type="submit">
                    Save Changes
                </button>

                <button type="button"
                    onclick="window.location.href='dashboard.php'">
                    Cancel
                </button>

            </form>

        </div>

    </div>

</div>

<script src="script.js"></script>

</body>
</html>