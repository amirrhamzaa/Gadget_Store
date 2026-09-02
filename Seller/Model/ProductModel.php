<?php

require_once("DatabaseConnection.php");

class ProductModel
{
    private $connection;

    function __construct()
    {
        $db = new DatabaseConnection();

        $this->connection = $db->openConnection();
    }


    function getAllProducts()
    {
        $sql = "SELECT * FROM products";

        $result = $this->connection->query($sql);

        return $result;
    }


    function addProduct($name, $description, $price, $stock, $category)
    {
        $sql = "INSERT INTO products
                (product_name, description, price, stock, category, status)
                VALUES
                ('$name', '$description', '$price', '$stock', '$category', 'Active')";

        return $this->connection->query($sql);
    }


    function deleteProduct($id)
    {
        $sql = "DELETE FROM products WHERE id='$id'";

        return $this->connection->query($sql);
    }


    function getProductById($id)
    {
        $sql = "SELECT * FROM products WHERE id='$id'";

        return $this->connection->query($sql);
    }


    function updateProduct($id, $name, $description, $price, $stock, $category)
    {
        $sql = "UPDATE products SET
                product_name='$name',
                description='$description',
                price='$price',
                stock='$stock',
                category='$category'
                WHERE id='$id'";

        return $this->connection->query($sql);
    }
    function updateStock($id, $stock)
{
    $sql = "UPDATE products
            SET stock='$stock'
            WHERE id='$id'";

    return $this->connection->query($sql);
}
}

?>