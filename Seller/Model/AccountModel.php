<?php

require_once("DatabaseConnection.php");

class AccountModel
{
    private $connection;

    public function __construct()
    {
        $db = new DatabaseConnection();

        $this->connection = $db->openConnection();
    }


    public function getSeller()
    {
        $sql = "SELECT * FROM users WHERE id='1'";

        $result = $this->connection->query($sql);

        return $result->fetch_assoc();
    }


    public function updateSeller($name, $email, $phone, $address)
    {
        $sql = "UPDATE users SET
                name='$name',
                email='$email',
                phone='$phone',
                address='$address'
                WHERE id='1'";

        return $this->connection->query($sql);
    }
}

?>