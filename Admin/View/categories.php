<?php require_once("../Model/DatabaseConnection.php");
$db = new DatabaseConnection();
$connection = $db->openConnection();
$cats = $connection->query("SELECT * FROM categories ORDER BY id DESC");
require("header.php"); ?>Categories</div><?php require("footer.php"); ?><div class="tablebox">
    <div class="toolbar">
        <h2>Categories</h2><a class="btn" href="addCategory.php">Add Category</a>
    </div>
    <table class="table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr><?php while ($c = $cats->fetch_assoc()): ?><tr>
                <td><?= $c['id'] ?></td>
                <td><?= htmlspecialchars($c['name']) ?></td>
                <td><?= htmlspecialchars($c['description']) ?></td>
                <td><?= $c['status'] ?></td>
                <td><a class="btn danger" onclick="return confirm('Delete this category?')" href="../Controller/categoryController.php?action=delete&id=<?= $c['id'] ?>">Delete</a></td>
            </tr><?php endwhile; ?>
    </table>
</div>
</main>
</div>
</body>

</html>