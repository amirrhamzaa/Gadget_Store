<?php require_once("../Model/DatabaseConnection.php");
$db = new DatabaseConnection();
$connection = $db->openConnection();
$orders = $connection->query("SELECT * FROM orders ORDER BY id DESC");
require("header.php"); ?>Orders</div><?php require("footer.php"); ?><div class="tablebox">
    <h2>Orders</h2>
    <table class="table">
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Date</th>
        </tr><?php while ($o = $orders->fetch_assoc()): ?><tr>
                <td><?= $o['id'] ?></td>
                <td><?= htmlspecialchars($o['customer_name'] ?? 'Guest') ?></td>
                <td><?= htmlspecialchars($o['product_name'] ?? '') ?></td>
                <td><?= $o['quantity'] ?></td>
                <td>৳ <?= number_format($o['total_price'] ?? 0, 2) ?></td>
                <td><?= htmlspecialchars($o['payment_method'] ?? '-') ?></td>
                <td>
                    <form method="post" action="../Controller/orderController.php?action=status"><input type="hidden" name="id" value="<?= $o['id'] ?>"><select class="select" style="margin:0" name="status" onchange="this.form.submit()">
                            <option <?= $o['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option <?= $o['status'] === 'Processing' ? 'selected' : '' ?>>Processing</option>
                            <option <?= $o['status'] === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                            <option <?= $o['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select></form>
                </td>
                <td><?= htmlspecialchars($o['order_date']) ?></td>
            </tr><?php endwhile; ?>
    </table>
</div>
</main>
</div>
</body>

</html>