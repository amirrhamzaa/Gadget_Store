<?php

require_once("DatabaseConnection.php");

class OrderModel
{
    private $connection;

    function __construct()
    {
        $db = new DatabaseConnection();

        $this->connection = $db->openConnection();
    }


    function getAllOrders()
    {
        $sql = "SELECT * FROM orders ORDER BY id DESC";

        return $this->connection->query($sql);
    }


    function updateStatus($id, $status)
    {
        $sql = "UPDATE orders
                SET status='$status'
                WHERE id='$id'";

        return $this->connection->query($sql);
    }
}

?>