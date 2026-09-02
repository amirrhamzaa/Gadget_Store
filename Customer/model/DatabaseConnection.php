
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
        $stockSql = "SELECT stock
                     FROM products
                     WHERE product_name = '$product_name'";

        $stockResult = $connection->query($stockSql);

        if ($stockResult->num_rows > 0) {

            $stockRow = $stockResult->fetch_assoc();
            $stock = $stockRow["stock"];

            if ($stock > 0) {

                $checkSql = "SELECT * FROM $tableName
                             WHERE product_name = '$product_name'";

                $checkResult = $connection->query($checkSql);

                if ($checkResult->num_rows > 0) {

                    $sql = "UPDATE $tableName
                            SET quantity = quantity + 1
                            WHERE product_name = '$product_name'";

                } else {

                    $sql = "INSERT INTO $tableName
                            (product_name, quantity, added_at)
                            VALUES
                            ('$product_name', 1, NOW())";
                }

                $cartResult = $connection->query($sql);

                if ($cartResult) {

                    $updateStock = "UPDATE products
                                    SET stock = stock - 1
                                    WHERE product_name = '$product_name'";

                    return $connection->query($updateStock);
                }
            }
        }

        return false;
    }


    function getCartItems($connection, $tableName)
    {
        $sql = "SELECT cart.*, products.stock, products.price
                FROM $tableName AS cart
                JOIN products
                ON cart.product_name = products.product_name
                ORDER BY cart.id DESC";

        return $connection->query($sql);
    }


    function increaseQuantity($connection, $tableName, $id)
    {
        $cartSql = "SELECT product_name
                    FROM $tableName
                    WHERE id = '$id'";

        $cartResult = $connection->query($cartSql);

        if ($cartResult->num_rows > 0) {

            $cartRow = $cartResult->fetch_assoc();
            $productName = $cartRow["product_name"];

            $stockSql = "SELECT stock
                         FROM products
                         WHERE product_name = '$productName'";

            $stockResult = $connection->query($stockSql);

            if ($stockResult->num_rows > 0) {

                $stockRow = $stockResult->fetch_assoc();
                $stock = $stockRow["stock"];

                if ($stock > 0) {

                    $updateCart = "UPDATE $tableName
                                   SET quantity = quantity + 1
                                   WHERE id = '$id'";

                    $updateStock = "UPDATE products
                                    SET stock = stock - 1
                                    WHERE product_name = '$productName'";

                    $connection->query($updateCart);
                    $connection->query($updateStock);
                }
            }
        }
    }


    function decreaseQuantity($connection, $tableName, $id)
    {
        $cartSql = "SELECT product_name
                    FROM $tableName
                    WHERE id = '$id'";

        $cartResult = $connection->query($cartSql);

        if ($cartResult->num_rows > 0) {

            $cartRow = $cartResult->fetch_assoc();
            $productName = $cartRow["product_name"];

            $sql = "UPDATE $tableName
                    SET quantity = quantity - 1
                    WHERE id = '$id' AND quantity > 1";

            $result = $connection->query($sql);

            if ($result && $connection->affected_rows > 0) {

                $updateStock = "UPDATE products
                                SET stock = stock + 1
                                WHERE product_name = '$productName'";

                $connection->query($updateStock);
            }
        }
    }


    function removeFromCart($connection, $tableName, $id)
    {
        $deleteSql = "SELECT product_name, quantity
                      FROM $tableName
                      WHERE id = '$id'";

        $deleteResult = $connection->query($deleteSql);

        if ($deleteResult->num_rows > 0) {

            $row = $deleteResult->fetch_assoc();

            $productName = $row["product_name"];
            $quantity = $row["quantity"];

            $updateStock = "UPDATE products
                            SET stock = stock + $quantity
                            WHERE product_name = '$productName'";

            $connection->query($updateStock);

            $sql = "DELETE FROM $tableName
                    WHERE id = '$id'";

            return $connection->query($sql);
        }

        return false;
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


    function searchProducts($connection, $search)
    {
        $search = $connection->real_escape_string($search);

        $sql = "SELECT *
                FROM products
                WHERE product_name LIKE '%$search%'";

        return $connection->query($sql);
    }

}

?>

