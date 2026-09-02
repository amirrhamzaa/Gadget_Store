<?php

session_start();

require_once("../model/DatabaseConnection.php");

$db = new DatabaseConnection();
$connection = $db->openConnection();

$userId = $_SESSION["user_id"];

$sql = "SELECT name, email, phone, address
        FROM users
        WHERE id = '$userId'";

$result = $connection->query($sql);

$user = $result->fetch_assoc();

$name = $user["name"];
$email = $user["email"];
$phone = $user["phone"];
$address = $user["address"];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Account Settings - Gadget Store</title>

    <link rel="stylesheet" href="style.css">

    <script src="validation.js?v=3"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="settings-page">

<div class="app">

    <div class="sidebar">

        <div class="logo-area">
            <div class="logo-icon">
                <i data-lucide="shopping-bag"></i>
            </div>

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

        <a href="../controller/logout.php"
           class="nav-item logout"
           onclick="return confirm('Are you sure you want to logout?');">

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

                <form action="../controller/updateProfile.php"
                      method="POST"
                      onsubmit="return validateForm()">

                    <div class="form-group">

                        <label>Name</label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="<?php echo $name; ?>"
                            placeholder="Enter your name"
                        >

                        <p id="nameError" style="color: red;"></p>

                    </div>

                    <div class="form-group">

                        <label>Email</label>

                        <input
                            type="text"
                            id="email"
                            name="email"
                            value="<?php echo $email; ?>"
                            placeholder="Enter your email"
                        >

                        <p id="emailError" style="color: red;"></p>

                    </div>

                    <div class="form-group">

                        <label>New Password</label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            value=""
                            placeholder="Enter new password"
                        >

                        <p id="passwordError" style="color: red;"></p>

                    </div>

                    <div class="form-group">

                        <label>Phone Number</label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="<?php echo $phone; ?>"
                            placeholder="Enter your phone number"
                        >

                        <p id="phoneError" style="color: red;"></p>

                    </div>

                    <div class="form-group">

                        <label>Address</label>

                        <textarea
                            id="address"
                            name="address"
                            placeholder="Enter your address"
                        ><?php echo $address; ?></textarea>

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

<script>
lucide.createIcons();
</script>

</body>
</html>