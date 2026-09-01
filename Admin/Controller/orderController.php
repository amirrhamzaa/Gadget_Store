<?php
session_start();
require_once("../Model/DatabaseConnection.php");
if (!isset($_SESSION["isLoggedIn"])) { header("Location: ../View/login.php"); exit(); }
$db = new DatabaseConnection();
$connection = $db->openConnection();
$action = $_GET["action"] ?? "list";

if ($action === "status" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)($_POST["id"] ?? 0);
    $status = $connection->real_escape_string($_POST["status"] ?? "Pending");
    $connection->query("UPDATE orders SET status='$status' WHERE id=$id");
    header("Location: ../View/orders.php"); exit();
}
if ($action === "delete") {
    $id = (int)($_GET["id"] ?? 0);
    $connection->query("DELETE FROM orders WHERE id=$id");
    header("Location: ../View/orders.php"); exit();
}
?>
