<?php

require_once("../Model/ProductModel.php");

$productModel = new ProductModel();

$products = $productModel->getAllProducts();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Inventory - Gadget Store</title>
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

    <a href="products.php">
        Products
    </a>

    <a href="orders.php">
        Orders
    </a>

    <a href="inventory.php" class="active">
        Inventory
    </a>

    <div class="logout">
        <a href="#">
            Logout
        </a>
    </div>

</div>


<div class="main">

    <div class="topbar">
        <h1>Inventory</h1>
        <h3>John Smith</h3>
    </div>


    <div class="content">

        <p class="welcome">
            Manage product stock.
        </p>


        <div class="table-box">

            <table>

                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Current Stock</th>
                    <th>Update Stock</th>
                </tr>


                <?php

                while($product = $products->fetch_assoc())
                {

                ?>

                <tr>

                    <td>
                        <?php echo $product["product_name"]; ?>
                    </td>

                    <td>
                        <?php echo $product["category"]; ?>
                    </td>

                    <td>
                        <?php echo $product["stock"]; ?>
                    </td>

                    <td>

                        <form
                            action="../Controller/ProductController.php?action=stock"
                            method="post"
                        >

                            <input
                                type="hidden"
                                name="id"
                                value="<?php echo $product["id"]; ?>"
                            >

                            <input
                                type="number"
                                name="stock"
                                value="<?php echo $product["stock"]; ?>"
                                required
                            >

                            <button
                                type="submit"
                                class="edit-button"
                            >
                                Update
                            </button>

                        </form>

                    </td>

                </tr>

                <?php

                }

                ?>

            </table>

        </div>

    </div>

</div>

</body>

</html>