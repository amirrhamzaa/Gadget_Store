<!DOCTYPE html>
<html>

<head>
    <title>Add Product - Gadget Store</title>
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

    <div class="logout">
        <a href="#">
            Logout
        </a>
    </div>

</div>


<div class="main">

    <div class="topbar">
        <h1>Add Product</h1>
        <h3>John Smith</h3>
    </div>


    <div class="content">

        <div class="table-box">

            <h2>Add New Product</h2>

            <form
                action="../Controller/ProductController.php?action=add"
                method="post"
            >

                <label>Product Name</label>
                <br>

                <input
                    type="text"
                    name="product_name"
                    required
                >

                <br><br>


                <label>Description</label>
                <br>

                <textarea
                    name="description"
                    rows="4"
                    required
                ></textarea>

                <br><br>


                <label>Price</label>
                <br>

                <input
                    type="number"
                    name="price"
                    required
                >

                <br><br>


                <label>Stock</label>
                <br>

                <input
                    type="number"
                    name="stock"
                    required
                >

                <br><br>


                <label>Category</label>
                <br>

                <input
                    type="text"
                    name="category"
                    required
                >

                <br><br>


                <button
                    type="submit"
                    class="update-button"
                >
                    Add Product
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