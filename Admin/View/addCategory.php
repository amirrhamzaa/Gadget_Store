<?php require("header.php"); ?>Add Category</div><?php require("footer.php"); ?><div class="formbox">
    <form method="post" action="../Controller/categoryController.php?action=add"><label>Name</label><input class="input" name="name" required><label>Description</label><textarea class="textarea" name="description" required></textarea><label>Status</label><select class="select" name="status">
            <option>Active</option>
            <option>Inactive</option>
        </select><button class="btn" type="submit">Save Category</button></form>
</div>
</main>
</div>
</body>

</html>