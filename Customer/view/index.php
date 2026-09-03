<?php

require_once("../model/DatabaseConnection.php");

$db = new DatabaseConnection();
$connection = $db->openConnection();

$sql = "SELECT * FROM products WHERE status = 'Active'";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Gadget Store</title>

    <link rel="stylesheet" href="style.css">

    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body class="dashboard-page">

    <div class="app">

        <div class="sidebar">

            <div class="logo-area">

                <div class="logo-icon">
                    <i data-lucide="shopping-bag"></i>
                </div>

                <label>Gadget Store</label>

            </div>


            <div class="sidebar-nav">

                <a href="index.php" class="nav-item active">
                    <label>Dashboard</label>
                </a>

                <a href="viewCart.php" class="nav-item">
                    <label>View Cart</label>
                </a>

                <a href="myOrders.php" class="nav-item">
                    <label>My Orders</label>
                </a>

                <a href="accountSettings.php" class="nav-item">
                    <label>Account Settings</label>
                </a>

            </div>


            <a href="../controller/logout.php"
               class="nav-item logout"
               onclick="return confirm('Are you sure you want to logout?');">

                <label>Logout</label>

            </a>

        </div>


        <div class="main-area">


            <div class="topbar">

                <div class="search-box">

                    <label class="search-icon">⌕</label>

                    <input
                        type="text"
                        placeholder="Search for products..."
                        id="searchInput"
                    >

                </div>

            </div>


            <div class="content">

                <div class="main-column">


                    <div class="section-header">

                        <h2 id="sectionTitle">
                            Featured Products
                        </h2>

                        <button class="view-all">
                            View All
                        </button>

                    </div>


                    <div class="products-grid" id="productResults">


                        <?php while ($product = $result->fetch_assoc()) { ?>


                            <div class="product-card">


                                <div class="product-image">


                                    <?php if (!empty($product["image"])) { ?>

                                        <img
                                            src="../../Admin/view/<?php echo $product["image"]; ?>"
                                            alt="<?php echo $product["product_name"]; ?>"
                                        >

                                    <?php } ?>


                                </div>


                                <div class="product-info">

                                    <h3>
                                        <?php echo $product["product_name"]; ?>
                                    </h3>


                                    <p>
                                        <?php echo $product["description"]; ?>
                                    </p>


                                    <b>
                                        ৳<?php echo $product["price"]; ?>
                                    </b>


                                    <form
                                        action="../controller/addToCart.php"
                                        method="post"
                                    >

                                        <input
                                            type="hidden"
                                            name="product_id"
                                            value="<?php echo $product["id"]; ?>"
                                        >


                                        <button
                                            type="submit"
                                            class="add-cart"
                                        >
                                            Add to Cart
                                        </button>

                                    </form>


                                </div>


                            </div>


                        <?php } ?>


                    </div>

                </div>

            </div>

        </div>

    </div>


    <script>

        lucide.createIcons();


        const searchInput =
            document.getElementById("searchInput");

        const productResults =
            document.getElementById("productResults");

        const sectionTitle =
            document.getElementById("sectionTitle");


        searchInput.addEventListener("input", function () {


            const search =
                searchInput.value.trim();


            if (search === "") {

                location.reload();

                return;

            }


            const xhr =
                new XMLHttpRequest();


            xhr.open(
                "GET",
                "../controller/searchProducts.php?search="
                + encodeURIComponent(search),
                true
            );


            xhr.onreadystatechange = function () {


                if (
                    xhr.readyState === 4 &&
                    xhr.status === 200
                ) {

                    productResults.innerHTML =
                        xhr.responseText;

                    sectionTitle.innerText =
                        "Search Results";

                }

            };


            xhr.send();

        });

    </script>


</body>

</html>