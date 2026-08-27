<?php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Account Settings - Gadget Store</title>
    <link rel="stylesheet" href="style.css">
    <script src="validation.js"></script>
</head>

<body class="settings-page">

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

            <a href="myOrders.php" class="nav-item">
                <label>My Orders</label>
            </a>

            <a href="accountSettings.php" class="nav-item active">
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

            <div class="settings-card">

                <div class="settings-header">
                    <h2>Edit Profile</h2>
                    <p>Update your personal information</p>
                </div>

                <form onsubmit="return validateForm()">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name">

                        <p id="nameError" style="color: red;"></p>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" id="email" name="email" placeholder="Enter your email">

                        <p id="emailError" style="color: red;"></p>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" id="phone" name="phone" placeholder="Enter your phone number">

                        <p id="phoneError" style="color: red;"></p>
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <textarea id="address" name="address" placeholder="Enter your address"></textarea>

                        <p id="addressError" style="color: red;"></p>
                    </div>

                    <div class="button-group">

                        <button type="submit" class="save-btn">
                            Save Changes
                        </button>

                        <button type="button" class="cancel-btn">
                            Cancel
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

</body>
</html>