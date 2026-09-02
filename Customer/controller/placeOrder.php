<?php

require_once("../model/DatabaseConnection.php");

$db = new DatabaseConnection();
$connection = $db->openConnection();

$cartItems = $db->getCartItems($connection, "cart");

if ($cartItems) {

    while ($row = $cartItems->fetch_assoc()) {

        $productName = $row["product_name"];
        $quantity = $row["quantity"];

        if ($productName == "Dell Inspiron 15") {

            $price = 85039;

        } elseif ($productName == "Sony WH-CH520") {

            $price = 7287;

        } elseif ($productName == "boAt Wave Flex") {

            $price = 3643;

        } elseif ($productName == "Realme Buds T300") {

            $price = 6073;

        } else {

            $price = 0;
        }

        $db->placeOrder(
            $connection,
            $productName,
            $quantity,
            $price
        );

        $sql = "DELETE FROM cart
                WHERE id = '" . $row["id"] . "'";

        $connection->query($sql);
    }
}

header("Location: ../view/myOrders.php");
exit();

?>