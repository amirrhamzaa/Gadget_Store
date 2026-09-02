<?php

session_start();

require_once("../model/DatabaseConnection.php");

if (isset($_SESSION["user_id"])) {

    $userId = $_SESSION["user_id"];

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $address = trim($_POST["address"] ?? "");
    $password = trim($_POST["password"] ?? "");

    $db = new DatabaseConnection();
    $connection = $db->openConnection();

    $name = $connection->real_escape_string($name);
    $email = $connection->real_escape_string($email);
    $phone = $connection->real_escape_string($phone);
    $address = $connection->real_escape_string($address);

    if ($password != "") {

        $password = password_hash($password, PASSWORD_DEFAULT);
        $password = $connection->real_escape_string($password);

        $sql = "UPDATE users
                SET name='$name',
                    email='$email',
                    phone='$phone',
                    address='$address',
                    password='$password'
                WHERE id='$userId'";

    } else {

        $sql = "UPDATE users
                SET name='$name',
                    email='$email',
                    phone='$phone',
                    address='$address'
                WHERE id='$userId'";
    }

    $connection->query($sql);

    $_SESSION["username"] = $name;
    $_SESSION["loggedInUsername"] = $name;

    header("Location: ../view/accountSettings.php");
    exit();
}

header("Location: ../view/accountSettings.php");
exit();

?>