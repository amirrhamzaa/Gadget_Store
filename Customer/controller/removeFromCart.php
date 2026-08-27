<?php

require_once("../model/DatabaseConnection.php");

if (isset($_POST["id"])) {

    $id = $_POST["id"];

    $db = new DatabaseConnection();
    $connection = $db->openConnection();

    $db->removeFromCart($connection, "cart", $id);

    header("Location: ../view/viewCart.php");
    exit();
}

?>