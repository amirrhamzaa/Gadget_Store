<?php
session_start();
require_once("../Model/DatabaseConnection.php");
if (!isset($_SESSION["isLoggedIn"])) { header("Location: ../View/login.php"); exit(); }
$db = new DatabaseConnection();
$connection = $db->openConnection();
$action = $_GET["action"] ?? "list";

if ($action === "add") {
    $product = $connection->real_escape_string($_GET["product_name"] ?? "");
    $check = $connection->query("SELECT id,quantity FROM cart WHERE product_name='$product' LIMIT 1");
    if ($check && $check->num_rows > 0) {
        $row = $check->fetch_assoc();
        $qty = (int)$row["quantity"] + 1;
        $connection->query("UPDATE cart SET quantity=$qty WHERE id=".(int)$row["id"]);
    } else {
        $connection->query("INSERT INTO cart (product_name,quantity) VALUES ('$product',1)");
    }
    header("Location: ../View/cart.php"); exit();
}
if ($action === "delete") {
    $id = (int)($_GET["id"] ?? 0);
    $connection->query("DELETE FROM cart WHERE id=$id");
    header("Location: ../View/cart.php"); exit();
}
if ($action === "clear") {
    $connection->query("DELETE FROM cart");
    header("Location: ../View/cart.php"); exit();
}
?>
