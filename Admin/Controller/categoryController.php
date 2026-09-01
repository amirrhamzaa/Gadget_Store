<?php
session_start();
require_once("../Model/DatabaseConnection.php");
if (!isset($_SESSION["isLoggedIn"])) { header("Location: ../View/login.php"); exit(); }
$db = new DatabaseConnection();
$connection = $db->openConnection();
$action = $_GET["action"] ?? "list";

if ($action === "add" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $connection->real_escape_string(trim($_POST["name"] ?? ""));
    $description = $connection->real_escape_string(trim($_POST["description"] ?? ""));
    $status = $connection->real_escape_string($_POST["status"] ?? "Active");
    $connection->query("INSERT INTO categories (name,description,status) VALUES ('$name','$description','$status')");
    header("Location: ../View/categories.php"); exit();
}
if ($action === "update" && $_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)($_POST["id"] ?? 0);
    $name = $connection->real_escape_string(trim($_POST["name"] ?? ""));
    $description = $connection->real_escape_string(trim($_POST["description"] ?? ""));
    $status = $connection->real_escape_string($_POST["status"] ?? "Active");
    $connection->query("UPDATE categories SET name='$name',description='$description',status='$status' WHERE id=$id");
    header("Location: ../View/categories.php"); exit();
}
if ($action === "delete") {
    $id = (int)($_GET["id"] ?? 0);
    $connection->query("DELETE FROM categories WHERE id=$id");
    header("Location: ../View/categories.php"); exit();
}
?>
