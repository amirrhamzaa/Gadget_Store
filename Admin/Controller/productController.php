<?php
session_start();
require_once("../Model/DatabaseConnection.php");
if (!isset($_SESSION["isLoggedIn"])) { header("Location: ../View/login.php"); exit(); }

$db = new DatabaseConnection();
$connection = $db->openConnection();
$action = $_GET["action"] ?? "list";

if ($action === "add" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $connection->real_escape_string(trim($_POST["product_name"] ?? ""));
    $description = $connection->real_escape_string(trim($_POST["description"] ?? ""));
    $price = (int)($_POST["price"] ?? 0);
    $stock = (int)($_POST["stock"] ?? 0);
    $category = $connection->real_escape_string(trim($_POST["category"] ?? ""));
    $status = $connection->real_escape_string($_POST["status"] ?? "Active");
    $image = $connection->real_escape_string(trim($_POST["image"] ?? ""));
    $connection->query("INSERT INTO products (product_name,description,price,stock,category,image,status) VALUES ('$name','$description',$price,$stock,'$category','$image','$status')");
    header("Location: ../View/products.php"); exit();
}

if ($action === "update" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)($_POST["id"] ?? 0);
    $name = $connection->real_escape_string(trim($_POST["product_name"] ?? ""));
    $description = $connection->real_escape_string(trim($_POST["description"] ?? ""));
    $price = (int)($_POST["price"] ?? 0);
    $stock = (int)($_POST["stock"] ?? 0);
    $category = $connection->real_escape_string(trim($_POST["category"] ?? ""));
    $status = $connection->real_escape_string($_POST["status"] ?? "Active");
    $image = $connection->real_escape_string(trim($_POST["image"] ?? ""));
    $connection->query("UPDATE products SET product_name='$name',description='$description',price=$price,stock=$stock,category='$category',image='$image',status='$status' WHERE id=$id");
    header("Location: ../View/products.php"); exit();
}

if ($action === "delete") {
    $id = (int)($_GET["id"] ?? 0);
    $connection->query("DELETE FROM products WHERE id=$id");
    header("Location: ../View/products.php"); exit();
}
?>
