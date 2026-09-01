<?php
session_start();
require_once("../Model/DatabaseConnection.php");

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$password = $_POST["password"] ?? "";
$address = trim($_POST["address"] ?? "");

$errors = [];

if (!$name) {
    $errors[] = "Name is required";
}

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Valid email is required";
}

if (!$phone) {
    $errors[] = "Phone is required";
}

if (strlen($password) < 6) {
    $errors[] = "Password must be at least 6 characters";
}

if (!$address) {
    $errors[] = "Address is required";
}

if ($errors) {
    $_SESSION["registrationErrors"] = $errors;
    header("Location: ../View/registration.php");
    exit();
}

$db = new DatabaseConnection();
$connection = $db->openConnection();

$name = $connection->real_escape_string($name);
$email = $connection->real_escape_string($email);
$phone = $connection->real_escape_string($phone);
$address = $connection->real_escape_string($address);

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$check = $connection->query(
    "SELECT id FROM users WHERE email='$email' LIMIT 1"
);

if ($check && $check->num_rows > 0) {
    $_SESSION["registrationErrors"] = ["Email already exists"];
    header("Location: ../View/registration.php");
    exit();
}

/*
 * Every normal registered user is a Customer
 */
$sql = "INSERT INTO users 
        (name, email, phone, role, password, status, address)
        VALUES
        ('$name', '$email', '$phone', 'Customer', '$hashedPassword', 'Active', '$address')";

if ($connection->query($sql)) {
    $_SESSION["registrationSuccess"] = "Registration successful. Please login.";
    header("Location: ../View/login.php");
} else {
    $_SESSION["registrationErrors"] = ["Registration failed. Please try again."];
    header("Location: ../View/registration.php");
}

exit();
?>