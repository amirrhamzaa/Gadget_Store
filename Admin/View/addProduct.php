<?php require_once("../Model/DatabaseConnection.php");
$db = new DatabaseConnection();
$connection = $db->openConnection();
$cats = $connection->query("SELECT name FROM categories WHERE status='Active' ORDER BY name");
require("header.php"); ?>Add Product</div><?php require("footer.php"); ?><div class="formbox">
    <form method="post" action="../Controller/productController.php?action=add">
        <div class="grid2">
            <div><label>Product Name</label><input class="input" name="product_name" required></div>
            <div><label>Price</label><input class="input" type="number" name="price" required></div>
            <div><label>Stock</label><input class="input" type="number" name="stock" required></div>
            <div><label>Category</label><select class="select" name="category">
                    <option value="">Select category</option><?php while ($c = $cats->fetch_assoc()): ?><option><?= htmlspecialchars($c['name']) ?></option><?php endwhile; ?>
                </select></div>
            <div><label>Status</label><select class="select" name="status">
                    <option>Active</option>
                    <option>Inactive</option>
                </select></div>
            <div><label>Image URL</label><input class="input" name="image"></div>
        </div><label>Description</label><textarea class="textarea" name="description" required></textarea><button class="btn" type="submit">Save Product</button>
    </form>
</div>
</main>
</div>
</body>

</html>