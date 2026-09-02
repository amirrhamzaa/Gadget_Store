<?php

require_once("../Model/OrderModel.php");

$orderModel = new OrderModel();

$orders = $orderModel->getAllOrders();

?>

<!DOCTYPE html>
<html>

<head>

    <title>Orders - Gadget Store</title>

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

    <a href="orders.php" class="active">
        Orders
    </a>

    <a href="inventory.php">
        Inventory
    </a>

    <div class="logout">
        <a href="#">Logout</a>
    </div>

</div>


<div class="main">

    <div class="topbar">

        <h1>Orders</h1>

        <h3>John Smith</h3>

    </div>


    <div class="content">

        <p class="welcome">
            Manage customer orders.
        </p>


        <div class="table-box">

            <h2>All Orders</h2>


            <table>

                <tr>

                    <th>Order ID</th>

                    <th>Customer</th>

                    <th>Product</th>

                    <th>Quantity</th>

                    <th>Total</th>

                    <th>Date</th>

                    <th>Status</th>

                </tr>


                <?php

                if($orders->num_rows > 0)
                {

                    while($order = $orders->fetch_assoc())
                    {

                ?>

                <tr>

                    <td>
                        #<?php echo $order["id"]; ?>
                    </td>


                    <td>
                        <?php echo $order["customer_name"]; ?>
                    </td>


                    <td>
                        <?php echo $order["product_name"]; ?>
                    </td>


                    <td>
                        <?php echo $order["quantity"]; ?>
                    </td>


                    <td>
                        ৳<?php echo $order["total_price"]; ?>
                    </td>


                    <td>
                        <?php echo $order["order_date"]; ?>
                    </td>


                    <td>

                        <form
                            action="../Controller/OrderController.php?action=status"
                            method="post"
                        >

                            <input
                                type="hidden"
                                name="id"
                                value="<?php echo $order["id"]; ?>"
                            >


                            <select name="status">

                                <option
                                    value="Pending"
                                    <?php
                                    if($order["status"] == "Pending")
                                    {
                                        echo "selected";
                                    }
                                    ?>
                                >
                                    Pending
                                </option>


                                <option
                                    value="Processing"
                                    <?php
                                    if($order["status"] == "Processing")
                                    {
                                        echo "selected";
                                    }
                                    ?>
                                >
                                    Processing
                                </option>


                                <option
                                    value="Shipped"
                                    <?php
                                    if($order["status"] == "Shipped")
                                    {
                                        echo "selected";
                                    }
                                    ?>
                                >
                                    Shipped
                                </option>


                                <option
                                    value="Delivered"
                                    <?php
                                    if($order["status"] == "Delivered")
                                    {
                                        echo "selected";
                                    }
                                    ?>
                                >
                                    Delivered
                                </option>

                            </select>


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

                }
                else
                {

                ?>

                <tr>

                    <td colspan="7">
                        No orders found
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