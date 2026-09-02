<?php


require_once("../Model/ProductModel.php");

$productModel = new ProductModel();

$action = $_GET["action"] ?? "";


if($action == "add")
{
    $name = $_POST["product_name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $category = $_POST["category"];

    $productModel->addProduct(
        $name,
        $description,
        $price,
        $stock,
        $category
    );

    header("Location: ../View/products.php");
    exit();
}


if($action == "delete")
{
    $id = $_GET["id"];

    $productModel->deleteProduct($id);

    header("Location: ../View/products.php");
    exit();
}


if($action == "update")
{
    $id = $_POST["id"];
    $name = $_POST["product_name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $category = $_POST["category"];

    $productModel->updateProduct(
        $id,
        $name,
        $description,
        $price,
        $stock,
        $category
    );

    header("Location: ../View/products.php");
    exit();
}
if($action == "stock")
{
    $id = $_POST["id"];
    $stock = $_POST["stock"];

    $productModel->updateStock($id, $stock);

    header("Location: ../View/inventory.php");
    exit();
}

?>