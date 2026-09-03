<?php

require_once("../model/DatabaseConnection.php");

if (isset($_POST["product_name"])) {

    $product_name = $_POST["product_name"];

    $db = new DatabaseConnection();
    $connection = $db->openConnection();

    $result = $db->addToCart(
        $connection,
        "cart",
        $product_name
    );

    if ($result) {

        header("Location: ../view/viewCart.php");
        exit();

    } else {

        echo "Failed to add product to cart";
    }
}

?>