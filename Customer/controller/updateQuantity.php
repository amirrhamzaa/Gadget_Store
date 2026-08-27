<?php

require_once("../model/DatabaseConnection.php");

if (isset($_POST["id"]) && isset($_POST["action"])) {

    $id = $_POST["id"];
    $action = $_POST["action"];

    $db = new DatabaseConnection();
    $connection = $db->openConnection();

    if ($action == "plus") {

        $db->increaseQuantity($connection, "cart", $id);

    } elseif ($action == "minus") {

        $db->decreaseQuantity($connection, "cart", $id);

    }

    header("Location: ../view/viewCart.php");
    exit();
}

?>