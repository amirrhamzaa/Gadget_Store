<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['isLoggedIn'])) { header('Location: login.php'); exit(); }
$role = $_SESSION['role'] ?? 'Customer';
$current = basename($_SERVER['PHP_SELF']);
?>
<div class="layout"><aside class="sidebar"><div class="brand">Gadget<span>Store</span></div><nav class="nav"><a class="<?= $current==='dashboard.php'?'active':'' ?>" href="dashboard.php">Dashboard</a><a class="<?= $current==='products.php'?'active':'' ?>" href="products.php">Products</a><a class="<?= $current==='categories.php'?'active':'' ?>" href="categories.php">Categories</a><a class="<?= $current==='users.php'?'active':'' ?>" href="users.php">Users</a><a class="<?= $current==='orders.php'?'active':'' ?>" href="orders.php">Orders</a><a class="<?= $current==='cart.php'?'active':'' ?>" href="cart.php">Cart</a><a href="../Controller/logout.php">Logout</a></nav></aside><main class="main"><div class="topbar"><div class="title">
