<?php

require_once("DatabaseConnection.php");

class DashboardModel
{
    private $connection;

    function __construct()
    {
        $db = new DatabaseConnection();
        $this->connection = $db->openConnection();
    }


    function getTotalProducts()
    {
        $sql = "SELECT COUNT(*) AS total FROM products";

        $result = $this->connection->query($sql);
        $row = $result->fetch_assoc();

        return $row["total"];
    }


    function getPendingOrders()
    {
        $sql = "SELECT COUNT(*) AS total
                FROM orders
                WHERE status='Pending'";

        $result = $this->connection->query($sql);
        $row = $result->fetch_assoc();

        return $row["total"];
    }


    function getTotalSales()
    {
        $sql = "SELECT SUM(total_price) AS total
                FROM orders
                WHERE status='Delivered'";

        $result = $this->connection->query($sql);
        $row = $result->fetch_assoc();

        if($row["total"] == NULL)
        {
            return 0;
        }

        return $row["total"];
    }


    function getRecentOrders()
    {
        $sql = "SELECT * FROM orders
                ORDER BY id DESC
                LIMIT 5";

        return $this->connection->query($sql);
    }
}

?>