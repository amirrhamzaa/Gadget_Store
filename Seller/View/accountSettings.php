<?php

require_once("../Model/AccountModel.php");

$accountModel = new AccountModel();

$seller = $accountModel->getSeller();

?>


<!DOCTYPE html>
<html>

<head>

    <title>Account Settings - Gadget Store</title>

    <link rel="stylesheet" href="style.css">

    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body>


<div class="sidebar">

<div class="logo">

<div class="logo-icon">
    <i data-lucide="shopping-bag"></i>
</div>

<span>Gadget Store</span>

</div>

    <a href="dashboard.php">
        Dashboard
    </a>

    <a href="products.php">
        Products
    </a>

    <a href="orders.php">
        Orders
    </a>

    <a href="inventory.php">
        Inventory
    </a>

    <a href="accountSettings.php" class="active">
        Account Settings
    </a>


    <div class="logout">

    <div class="logout">
    <a href="#">Logout</a>
</div>

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


            <form
                class="settings-form"
                action="../Controller/updateProfile.php"
                method="post"
                onsubmit="return validateSettings()"
            >


                <label>Seller Name</label>

                <input
                    type="text"
                    id="sellerName"
                    name="name"
                    value="<?php echo $seller["name"]; ?>"
                >

                <p id="sellerNameError"></p>



                <label>Email</label>

                <input
                    type="text"
                    id="email"
                    name="email"
                    value="<?php echo $seller["email"]; ?>"
                >

                <p id="emailError"></p>



                <label>Phone Number</label>

                <input
                    type="text"
                    id="phone"
                    name="phone"
                    value="<?php echo $seller["phone"]; ?>"
                >

                <p id="phoneError"></p>



                <label>Store Address</label>

                <textarea
                    id="address"
                    name="address"
                ><?php echo $seller["address"]; ?></textarea>

                <p id="addressError"></p>



                <button
                    type="submit"
                    class="save-button"
                >
                    Save Changes
                </button>


                <button
                    type="button"
                    class="cancel-button"
                    onclick="window.location.href='dashboard.php'"
                >
                    Cancel
                </button>


            </form>


        </div>


    </div>


</div>



<script src="script.js"></script>

<script>
    lucide.createIcons();
</script>

</body>

</html>