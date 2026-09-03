<?php


require_once("../Model/ProductModel.php");

$productModel = new ProductModel();

$products = $productModel->getAllProducts();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Products - Gadget Store</title>
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

        <h1>Products</h1>

        

    </div>


    <div class="content">

        <p class="welcome">
            Manage your product listings.
        </p>


        <div class="product-header">

            <h2>All Products</h2>

            <button onclick="window.location.href='addProduct.php'">
                + Add Product
            </button>

        </div>


        <input
            type="text"
            id="search"
            placeholder="Search products..."
            onkeyup="searchProduct()"
        >


        <div class="table-box">

            <table id="productTable">

                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>


                <?php

                if($products->num_rows > 0)
                {

                    while($product = $products->fetch_assoc())
                    {

                ?>

                <tr>

                    <td>

                        <strong>
                            <?php echo $product["product_name"]; ?>
                        </strong>

                        <br>

                        ID-<?php echo $product["id"]; ?>

                    </td>


                    <td>
                        <?php echo $product["category"]; ?>
                    </td>


                    <td>
                        ৳<?php echo $product["price"]; ?>
                    </td>


                    <td>
                        <?php echo $product["stock"]; ?>
                    </td>


                    <td>

                        <?php

                        if($product["status"] == "Active")
                        {

                        ?>

                        <span class="delivered">
                            Active
                        </span>

                        <?php

                        }
                        else
                        {

                        ?>

                        <span class="inactive">
                            Inactive
                        </span>

                        <?php

                        }

                        ?>

                    </td>


                    <td>

                        <button
                            class="edit-button"
                            onclick="window.location.href='editProduct.php?id=<?php echo $product["id"]; ?>'"
                        >
                            Edit
                        </button>


                        <button
                            class="delete-button"
                            onclick="deleteProduct(<?php echo $product["id"]; ?>)"
                        >
                            Delete
                        </button>

                    </td>

                </tr>

                <?php

                    }

                }
                else
                {

                ?>

                <tr>

                    <td colspan="6">
                        No products found
                    </td>

                </tr>

                <?php

                }

                ?>

            </table>

        </div>

    </div>

</div>


<script src="script.js"></script>


<script>

function deleteProduct(id)
{
    var result = confirm(
        "Are you sure you want to delete this product?"
    );

    if(result == true)
    {
        window.location.href =
        "../Controller/ProductController.php?action=delete&id=" + id;
    }
}

</script>


</body>

</html>