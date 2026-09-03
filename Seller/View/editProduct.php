<?php

require_once("../Model/ProductModel.php");

$productModel = new ProductModel();

$id = $_GET["id"];

$result = $productModel->getProductById($id);

$product = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Product - Gadget Store</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="sidebar">

    <div class="logo">
        Gadget Store
    </div>

    <a href="dashboard.php">
        Dashboard
    </a>

    <a href="products.php" class="active">
        Products
    </a>

    <a href="orders.php">
        Orders
    </a>

    <a href="inventory.php">
        Inventory
    </a>

    <a href="accountSettings.php">
    Account Settings
</a>

 <div class="logout">
    <a href="../Controller/logout.php"
       onclick="return confirm('Are you sure you want to logout?');">
        Logout
    </a>
</div>

</div>


<div class="main">

    <div class="topbar">
        <h1>Edit Product</h1>
       
    </div>


    <div class="content">

        <div class="table-box">

            <h2>Edit Product</h2>

            <form
                action="../Controller/ProductController.php?action=update"
                method="post"
            >

                <input
                    type="hidden"
                    name="id"
                    value="<?php echo $product["id"]; ?>"
                >


                <label>Product Name</label>
                <br>

                <input
                    type="text"
                    name="product_name"
                    value="<?php echo $product["product_name"]; ?>"
                    required
                >

                <br><br>


                <label>Description</label>
                <br>

                <textarea
                    name="description"
                    rows="4"
                    required
                ><?php echo $product["description"]; ?></textarea>

                <br><br>


                <label>Price</label>
                <br>

                <input
                    type="number"
                    name="price"
                    value="<?php echo $product["price"]; ?>"
                    required
                >

                <br><br>


                <label>Stock</label>
                <br>

                <input
                    type="number"
                    name="stock"
                    value="<?php echo $product["stock"]; ?>"
                    required
                >

                <br><br>


                <label>Category</label>
                <br>

                <input
                    type="text"
                    name="category"
                    value="<?php echo $product["category"]; ?>"
                    required
                >

                <br><br>


                <button
                    type="submit"
                    class="update-button"
                >
                    Update Product
                </button>


                <button
                    type="button"
                    class="delete-button"
                    onclick="window.location.href='products.php'"
                >
                    Cancel
                </button>

            </form>

        </div>

    </div>

</div>

</body>

</html>