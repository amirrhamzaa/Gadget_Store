<?php
session_start();
require_once("../Model/DatabaseConnection.php");

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

$hasEmailError = $hasPasswordError = false;

if (!$email) {
    $_SESSION["emailError"] = "Email is required";
    $hasEmailError = true;
} else {
    unset($_SESSION["emailError"]);
}

if (!$password) {
    $_SESSION["passwordError"] = "Password is required";
    $hasPasswordError = true;
} else {
    unset($_SESSION["passwordError"]);
}

if ($hasEmailError || $hasPasswordError) {
    header("Location: ../View/login.php");
    exit();
}

$db = new DatabaseConnection();
$connection = $db->openConnection();

$email = $connection->real_escape_string($email);
$sql = "SELECT * FROM users WHERE email='$email' AND status='Active' LIMIT 1";
$result = $connection->query($sql);

if ($result && $result->num_rows == 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password']) || $password === $user['password']) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["name"];
        $_SESSION["loggedInUsername"] = $user["name"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["isLoggedIn"] = true;
        setcookie("username", $user["name"], time() + 3600, "/");
        header("Location: ../View/dashboard.php");
        exit();
    }
}

$_SESSION["loginError"] = "Invalid email or password";
header("Location: ../View/login.php");
exit();
?>
