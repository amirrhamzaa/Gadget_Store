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
        $connection->set_charset("utf8mb4");
        return $connection;
    }
}
?>
Hello
