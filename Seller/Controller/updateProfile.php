<?php

require_once("../Model/AccountModel.php");

$accountModel = new AccountModel();

$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$address = $_POST["address"];

$accountModel->updateSeller(
    $name,
    $email,
    $phone,
    $address
);

header("Location: ../View/accountSettings.php");

?>