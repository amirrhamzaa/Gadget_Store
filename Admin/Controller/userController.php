<?php
session_start();
require_once("../Model/DatabaseConnection.php");
if (!isset($_SESSION["isLoggedIn"])) { header("Location: ../View/login.php"); exit(); }
$db = new DatabaseConnection();
$connection = $db->openConnection();
$action = $_GET["action"] ?? "list";

if ($action === "update" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)($_POST["id"] ?? 0);
    $role = $connection->real_escape_string($_POST["role"] ?? "Customer");
    $status = $connection->real_escape_string($_POST["status"] ?? "Active");
    $connection->query("UPDATE users SET role='$role',status='$status' WHERE id=$id");
    header("Location: ../View/users.php"); exit();
}
if ($action === "delete") {
    $id = (int)($_GET["id"] ?? 0);
    $connection->query("DELETE FROM users WHERE id=$id");
    header("Location: ../View/users.php"); exit();
}
?>
