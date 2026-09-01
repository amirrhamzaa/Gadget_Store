<?php session_start();
$errors = $_SESSION['registrationErrors'] ?? [];
unset($_SESSION['registrationErrors']); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Gadget Store - Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="auth">
    <div class="authbox">
        <h1>Create Account</h1><?php foreach ($errors as $e) {
                                    echo '<div class="error">' . htmlspecialchars($e) . '</div>';
                                } ?><form method="post" action="../Controller/registrationValidation.php"><label>Name</label><input class="input" name="name"><label>Email</label><input class="input" type="email" name="email"><label>Phone</label><input class="input" name="phone"><label>Password</label><input class="input" type="password" name="password"><label>Address</label><textarea class="textarea" name="address"></textarea><button class="btn" type="submit">Register</button></form>
        <p>Already have an account? <a href="login.php" style="color:#2563eb">Login</a></p>
    </div>
</body>

</html>