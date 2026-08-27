<?php

class DatabaseConnection
{

    function openConnection()
    {
        $db_host = "localhost";
        $db_user = "root";
        $db_password = "123456";
        $db_name = "gadget_store";

        $connection = new mysqli($db_host, $db_user, $db_password, $db_name);

        if ($connection->connect_error) {
            die("Failed to connect database. " . $connection->connect_error);
        }

        return $connection;
    }


    function addToCart($connection, $tableName, $product_name)
    {
        $checkSql = "SELECT * FROM $tableName
                     WHERE product_name = '$product_name'";

        $checkResult = $connection->query($checkSql);

        if ($checkResult->num_rows > 0) {

            $sql = "UPDATE $tableName
                    SET quantity = quantity + 1
                    WHERE product_name = '$product_name'";

        } else {

            $sql = "INSERT INTO $tableName (product_name, quantity, added_at)
                    VALUES ('$product_name', 1, NOW())";
        }

        return $connection->query($sql);
    }


    function getCartItems($connection, $tableName)
    {
        $sql = "SELECT * FROM $tableName ORDER BY id DESC";

        return $connection->query($sql);
    }


    function increaseQuantity($connection, $tableName, $id)
    {
        $sql = "UPDATE $tableName
                SET quantity = quantity + 1
                WHERE id = '$id'";

        return $connection->query($sql);
    }


    function decreaseQuantity($connection, $tableName, $id)
    {
        $sql = "UPDATE $tableName
                SET quantity = quantity - 1
                WHERE id = '$id' AND quantity > 1";

        return $connection->query($sql);
    }


    function removeFromCart($connection, $tableName, $id)
    {
        $sql = "DELETE FROM $tableName
                WHERE id = '$id'";

        return $connection->query($sql);
    }


    function placeOrder($connection, $product_name, $quantity, $price)
    {
        $total_price = $quantity * $price;

        $sql = "INSERT INTO orders
                (product_name, quantity, price, total_price)
                VALUES
                ('$product_name', '$quantity', '$price', '$total_price')";

        return $connection->query($sql);
    }


    function getOrders($connection)
    {
        $sql = "SELECT * FROM orders ORDER BY id DESC";

        return $connection->query($sql);
    }

}

?>