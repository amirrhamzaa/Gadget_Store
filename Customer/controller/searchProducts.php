<?php

require_once("../model/DatabaseConnection.php");

$db = new DatabaseConnection();
$connection = $db->openConnection();

$search = trim($_GET["search"] ?? "");

if ($search != "") {

    $result = $db->searchProducts($connection, $search);

    if ($result && $result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            echo "<div class='product-card'>";


            echo "<div class='product-image'>";

            if (!empty($row["image"])) {

                echo "<img
                        src='../" . htmlspecialchars($row["image"]) . "'
                        alt='" . htmlspecialchars($row["product_name"]) . "'>";

            }

            echo "</div>";


            echo "<div class='product-info'>";


            echo "<h3>";
            echo htmlspecialchars($row["product_name"]);
            echo "</h3>";


            echo "<p>";
            echo htmlspecialchars($row["description"]);
            echo "</p>";


            echo "<p>";
            echo "Stock: " . $row["stock"];
            echo "</p>";


            echo "<p>";
            echo "Category: " . htmlspecialchars($row["category"]);
            echo "</p>";


            echo "<b>";
            echo "৳" . $row["price"];
            echo "</b>";


            echo "<form
                    action='../controller/addToCart.php'
                    method='post'>";


            echo "<input
                    type='hidden'
                    name='product_name'
                    value='" . htmlspecialchars($row["product_name"]) . "'>";


            echo "<button
                    type='submit'
                    class='add-cart'>
                    Add to Cart
                  </button>";


            echo "</form>";


            echo "</div>";


            echo "</div>";
        }

    } else {

        echo "<p>Product not found.</p>";

    }
}

?>

