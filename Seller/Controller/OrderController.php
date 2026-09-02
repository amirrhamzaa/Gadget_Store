<?php

require_once("../Model/OrderModel.php");

$orderModel = new OrderModel();

$action = $_GET["action"] ?? "";


if($action == "status")
{
    $id = $_POST["id"];
    $status = $_POST["status"];

    $orderModel->updateStatus($id, $status);

    header("Location: ../View/orders.php");
    exit();
}

?>