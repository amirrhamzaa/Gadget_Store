<?php
session_start();
require_once("../Model/DatabaseConnection.php");
if (!isset($_SESSION["isLoggedIn"])) { header("Location: login.php"); exit(); }
$db = new DatabaseConnection();
$connection = $db->openConnection();

$userCount = (int)$connection->query("SELECT COUNT(*) c FROM users")->fetch_assoc()["c"];
$productCount = (int)$connection->query("SELECT COUNT(*) c FROM products")->fetch_assoc()["c"];
$orderCount = (int)$connection->query("SELECT COUNT(*) c FROM orders")->fetch_assoc()["c"];
$sales = (float)($connection->query("SELECT COALESCE(SUM(total_price),0) s FROM orders WHERE status <> 'Cancelled'")->fetch_assoc()["s"] ?? 0);
$sellerCount = (int)$connection->query("SELECT COUNT(*) c FROM users WHERE role='Seller'")->fetch_assoc()["c"];
$customerCount = (int)$connection->query("SELECT COUNT(*) c FROM users WHERE role='Customer'")->fetch_assoc()["c"];
$deliveryCount = (int)$connection->query("SELECT COUNT(*) c FROM users WHERE role IN ('Delivery','Delivery Agent')")->fetch_assoc()["c"];

$users = $connection->query("SELECT * FROM users ORDER BY id DESC");
$products = $connection->query("SELECT * FROM products ORDER BY id DESC");
$categories = $connection->query("SELECT c.*, (SELECT COUNT(*) FROM products p WHERE p.category = c.name) AS product_count FROM categories c ORDER BY c.id DESC");
$orders = $connection->query("SELECT * FROM orders ORDER BY id DESC");
$categoryNames = [];
$catResult = $connection->query("SELECT name FROM categories WHERE status='Active' ORDER BY name");
while ($cat = $catResult->fetch_assoc()) { $categoryNames[] = $cat['name']; }

$currentAdminId = (int)($_SESSION["user_id"] ?? 0);
$currentAdmin = ["name" => "Admin User", "email" => "", "phone" => ""];
if ($currentAdminId > 0) {
    $stmt = $connection->prepare("SELECT name, email, phone FROM users WHERE id=?");
    $stmt->bind_param("i", $currentAdminId);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if ($row) $currentAdmin = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gadget Store - Admin</title>

    <link rel="stylesheet" href="style.css">

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body>

<div class="app">

    <!-- ================= SIDEBAR ================= -->

    <aside class="sidebar">

        <div class="logo">
            <div class="logo-icon">
                <i data-lucide="shopping-bag"></i>
            </div>

            <span>Gadget Store</span>
        </div>


        <nav class="sidebar-menu">

            <button class="nav-item active" data-page="dashboard">
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </button>


            <button class="nav-item" data-page="users">
                <i data-lucide="users"></i>
                <span>Users</span>
            </button>


            <button class="nav-item" data-page="products">
                <i data-lucide="package"></i>
                <span>Products</span>
            </button>


            <button class="nav-item" data-page="categories">
                <i data-lucide="folder"></i>
                <span>Categories</span>
            </button>


            <button class="nav-item" data-page="orders">
                <i data-lucide="shopping-cart"></i>
                <span>Orders</span>
            </button>

        </nav>


        <div class="sidebar-bottom">

            <button class="nav-item" data-page="profile-settings">
                <i data-lucide="settings"></i>
                <span>Settings</span>
            </button>


            <button class="nav-item logout" type="button">
                <i data-lucide="log-out"></i>
                <span>Logout</span>
            </button>

        </div>

    </aside>



    <!-- ================= MAIN ================= -->

    <main class="main-area">


        <!-- HEADER -->

        <header class="top-header">

            <div class="header-left">

                <button class="menu-btn" id="menuBtn">
                    <i data-lucide="menu"></i>
                </button>

                <h1 id="pageTitle">Dashboard</h1>

            </div>


            <!-- intentionally empty -->

            <div class="header-right"></div>

        </header>



        <!-- ================= CONTENT ================= -->

        <section class="content">


            <!-- =====================================================
                 DASHBOARD
            ====================================================== -->

            <div class="page active-page" id="dashboard">

                <div class="page-heading">

                    <div>
                        <h2>Dashboard</h2>
                        <p>Overview of your Gadget Store</p>
                    </div>

                </div>


                <div class="stats-grid">


                    <!-- TOTAL SALES -->

                    <div class="stat-card">

                        <div class="stat-icon purple">
                            <i data-lucide="dollar-sign"></i>
                        </div>

                        <div>
                            <p>Total Sales</p>
                            <h3>৳<?= number_format($sales,0) ?></h3>
                        </div>

                    </div>


                    <!-- TOTAL ORDERS -->

                    <div class="stat-card">

                        <div class="stat-icon blue">
                            <i data-lucide="shopping-cart"></i>
                        </div>

                        <div>
                            <p>Total Orders</p>
                            <h3><?= number_format($orderCount) ?></h3>
                        </div>

                    </div>


                    <!-- TOTAL USERS -->

                    <div class="stat-card">

                        <div class="stat-icon green">
                            <i data-lucide="users"></i>
                        </div>

                        <div>
                            <p>Total Users</p>
                            <h3 id="dashboardUserCount"><?= number_format($userCount) ?></h3>
                        </div>

                    </div>


                    <!-- TOTAL PRODUCTS -->

                    <div class="stat-card">

                        <div class="stat-icon orange">
                            <i data-lucide="package"></i>
                        </div>

                        <div>
                            <p>Total Products</p>
                            <h3 id="dashboardProductCount"><?= number_format($productCount) ?></h3>
                        </div>

                    </div>

                </div>

            </div>



            <!-- =====================================================
                 USERS
            ====================================================== -->

            <div class="page" id="users">

                <div class="page-heading">

                    <div>
                        <h2>Users</h2>
                        <p>Manage sellers, customers and delivery agents</p>
                    </div>


                    <button class="primary-btn" id="addUserBtn">

                        <i data-lucide="user-plus"></i>

                        Add New User

                    </button>

                </div>



                <!-- USER TYPE CARDS -->

                <div class="stats-grid three">


                    <div class="stat-card">

                        <div class="stat-icon purple">
                            <i data-lucide="store"></i>
                        </div>

                        <div>
                            <p>Sellers</p>
                            <h3><?= number_format($sellerCount) ?></h3>
                        </div>

                    </div>


                    <div class="stat-card">

                        <div class="stat-icon green">
                            <i data-lucide="user"></i>
                        </div>

                        <div>
                            <p>Customers</p>
                            <h3><?= number_format($customerCount) ?></h3>
                        </div>

                    </div>


                    <div class="stat-card">

                        <div class="stat-icon orange">
                            <i data-lucide="truck"></i>
                        </div>

                        <div>
                            <p>Delivery Agents</p>
                            <h3><?= number_format($deliveryCount) ?></h3>
                        </div>

                    </div>

                </div>



                <div class="panel">

                    <div class="filter-row">

                        <div class="search-box">

                            <i data-lucide="search"></i>

                            <input
                                type="text"
                                id="userSearch"
                                placeholder="Search users..."
                            >

                        </div>


                        <select id="userRoleFilter">

                            <option value="all">All Roles</option>
                            <option value="Seller">Seller</option>
                            <option value="Customer">Customer</option>
                            <option value="Delivery Agent">
                                Delivery Agent
                            </option>

                        </select>

                    </div>



                    <div class="table-wrapper">

                        <table>

                            <thead>

                                <tr>

                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Actions</th>

                                </tr>

                            </thead>


                            <tbody id="usersTable">
<?php while ($u = $users->fetch_assoc()):
    $roleUi = ($u["role"] === "Delivery") ? "Delivery Agent" : $u["role"];
    $roleClass = $roleUi === "Seller" ? "seller" : ($roleUi === "Delivery Agent" ? "delivery" : "customer");
    $avatarClass = $roleUi === "Seller" ? "purple-bg" : ($roleUi === "Delivery Agent" ? "orange-bg" : "green-bg");
?>
<tr data-id="<?= (int)$u["id"] ?>">
<td><div class="user-info"><div class="avatar <?= $avatarClass ?>"><?= htmlspecialchars(strtoupper(substr($u["name"],0,1))) ?></div><div><strong><?= htmlspecialchars($u["name"]) ?></strong><small><?= htmlspecialchars($roleUi) ?></small></div></div></td>
<td><span class="role <?= $roleClass ?>"><?= htmlspecialchars($roleUi) ?></span></td>
<td><?= htmlspecialchars($u["email"]) ?></td>
<td><?= htmlspecialchars($u["phone"]) ?></td>
<td><span class="status <?= $u["status"] === "Active" ? "delivered" : "inactive" ?>"><?= htmlspecialchars($u["status"]) ?></span></td>
<td><button class="icon-btn edit-btn"><i data-lucide="pencil"></i></button><button class="icon-btn delete delete-btn"><i data-lucide="trash-2"></i></button></td>
</tr>
<?php endwhile; ?>
</tbody>

                        </table>

                    </div>

                </div>

            </div>



            <!-- =====================================================
                 PRODUCTS
            ====================================================== -->

            <div class="page" id="products">

                <div class="page-heading">

                    <div>
                        <h2>Products</h2>
                        <p>Manage all products in your store</p>
                    </div>


                    <button class="primary-btn" id="addProductBtn">

                        <i data-lucide="plus"></i>

                        Add New Product

                    </button>

                </div>



                <div class="panel">

                    <div class="filter-row">

                        <div class="search-box">

                            <i data-lucide="search"></i>

                            <input
                                type="text"
                                id="productSearch"
                                placeholder="Search products..."
                            >

                        </div>


                        <select id="productCategoryFilter">
                            <option value="all">All Categories</option>
                            <?php foreach ($categoryNames as $catName): ?>
                            <option><?= htmlspecialchars($catName) ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>



                    <div class="table-wrapper">

                        <table>

                            <thead>

                                <tr>

                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Actions</th>

                                </tr>

                            </thead>


                            <tbody id="productsTable">
<?php while ($p = $products->fetch_assoc()): ?>
<tr data-id="<?= (int)$p["id"] ?>">
<td><div class="product-info"><div class="product-image"><?php if (!empty($p["image"]) && file_exists(__DIR__ . "/" . $p["image"])): ?><img src="<?= htmlspecialchars($p["image"]) ?>" alt="<?= htmlspecialchars($p["product_name"]) ?>" style="width:100%;height:100%;object-fit:cover;border-radius:7px"><?php else: ?><i data-lucide="package"></i><?php endif; ?></div><div><strong><?= htmlspecialchars($p["product_name"]) ?></strong><small><?= htmlspecialchars($p["description"]) ?></small></div></div></td>
<td>৳<?= number_format((float)$p["price"],0) ?></td><td><?= (int)$p["stock"] ?></td><td><?= htmlspecialchars($p["category"]) ?></td>
<td><span class="status <?= $p["status"] === "Active" ? "delivered" : "inactive" ?>"><?= htmlspecialchars($p["status"]) ?></span></td>
<td><button class="icon-btn edit-btn"><i data-lucide="pencil"></i></button><button class="icon-btn delete delete-btn"><i data-lucide="trash-2"></i></button></td>
</tr>
<?php endwhile; ?>
</tbody>

                        </table>

                    </div>

                </div>

            </div>



            <!-- =====================================================
                 CATEGORIES
            ====================================================== -->

            <div class="page" id="categories">

                <div class="page-heading">

                    <div>

                        <h2>Categories</h2>

                        <p>
                            Manage product categories
                        </p>

                    </div>


                    <button
                        class="primary-btn"
                        id="addCategoryBtn"
                    >

                        <i data-lucide="plus"></i>

                        Add New Category

                    </button>

                </div>



                <div class="panel">

                    <div class="filter-row">

                        <div class="search-box">

                            <i data-lucide="search"></i>

                            <input
                                type="text"
                                placeholder="Search categories..."
                            >

                        </div>

                    </div>



                    <div class="table-wrapper">

                        <table>

                            <thead>

                                <tr>

                                    <th>Category Name</th>
                                    <th>Description</th>
                                    <th>Products</th>
                                    <th>Status</th>
                                    <th>Actions</th>

                                </tr>

                            </thead>


                            <tbody id="categoriesTable">
<?php while ($c = $categories->fetch_assoc()): ?>
<tr data-id="<?= (int)$c["id"] ?>">
<td><strong><?= htmlspecialchars($c["name"]) ?></strong></td><td><?= htmlspecialchars($c["description"]) ?></td><td><?= (int)$c["product_count"] ?></td>
<td><span class="status <?= $c["status"] === "Active" ? "delivered" : "inactive" ?>"><?= htmlspecialchars($c["status"]) ?></span></td>
<td><button class="icon-btn edit-btn"><i data-lucide="pencil"></i></button><button class="icon-btn delete delete-btn"><i data-lucide="trash-2"></i></button></td>
</tr>
<?php endwhile; ?>
</tbody>

                        </table>

                    </div>

                </div>

            </div>



            <!-- =====================================================
                 ORDERS
            ====================================================== -->

            <div class="page" id="orders">

                <div class="page-heading">

                    <div>

                        <h2>Orders</h2>

                        <p>
                            Manage all customer orders
                        </p>

                    </div>

                </div>



                <div class="panel">

                    <div class="filter-row">

                        <div class="search-box">

                            <i data-lucide="search"></i>

                            <input
                                type="text"
                                placeholder="Search orders..."
                            >

                        </div>


                        <select>

                            <option>All Status</option>
                            <option>Pending</option>
                            <option>Shipped</option>
                            <option>Delivered</option>
                            <option>Cancelled</option>

                        </select>

                    </div>



                    <div class="table-wrapper">

                        <table>

                            <thead>

                                <tr>

                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>

                                </tr>

                            </thead>


                            <tbody>
<?php while ($o = $orders->fetch_assoc()): ?>
<tr data-id="<?= (int)$o["id"] ?>">
<td><strong>#ORD-<?= (int)$o["id"] ?></strong></td><td><?= htmlspecialchars($o["customer_name"] ?: "Guest") ?></td><td><?= htmlspecialchars($o["product_name"] ?: "") ?></td><td>৳<?= number_format((float)($o["total_price"] ?? 0),2) ?></td>
<td><span class="status <?= $o["status"] === "Delivered" ? "delivered" : ($o["status"] === "Processing" ? "shipped" : "pending") ?>"><?= htmlspecialchars($o["status"]) ?></span></td>
<td><button class="view-btn" data-order='<?= htmlspecialchars(json_encode($o), ENT_QUOTES, "UTF-8") ?>'>View</button></td>
</tr>
<?php endwhile; ?>
</tbody>

                        </table>

                    </div>

                </div>

            </div>


            <!-- ================= PROFILE SETTINGS ================= -->
            <div class="page" id="profile-settings">

                <div class="page-heading">

                    <div>
                        <h2>Profile Settings</h2>
                        <p>Update your account information</p>
                    </div>

                </div>

                <div class="profile-settings-card">

                    <div class="profile-form">

                        <!-- Full Name -->
                        <div class="input-group">
                            <label>Full Name</label>
                            <input
                                type="text"
                                id="adminName"
                                value="<?= htmlspecialchars($currentAdmin["name"] ?? "") ?>"
                                placeholder="Enter your name"
                            >
                        </div>

                        <!-- Email -->
                        <div class="input-group">
                            <label>Email Address</label>
                            <input
                                type="email"
                                id="adminEmail"
                                value="<?= htmlspecialchars($currentAdmin["email"] ?? "") ?>"
                                placeholder="Enter your email"
                            >
                        </div>

                        <!-- Phone -->
                        <div class="input-group">
                            <label>Phone Number</label>
                            <input
                                type="text"
                                id="adminPhone"
                                value="<?= htmlspecialchars($currentAdmin["phone"] ?? "") ?>"
                                placeholder="Enter your phone number"
                            >
                        </div>

                        <!-- Password -->
                        <div class="input-group">
                            <label>New Password</label>
                            <input
                                type="password"
                                id="adminPassword"
                                placeholder="Enter new password"
                            >
                        </div>

                        <!-- Confirm Password -->
                        <div class="input-group">
                            <label>Confirm Password</label>
                            <input
                                type="password"
                                id="confirmPassword"
                                placeholder="Confirm new password"
                            >
                        </div>

                        <!-- Buttons -->
                        <div class="profile-buttons">

                            <button
                                type="button"
                                class="cancel-btn"
                                id="profileCancel"
                            >
                                Cancel
                            </button>

                            <button
                                type="button"
                                class="save-btn"
                                id="saveProfile"
                            >
                                Save Changes
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>

</div>



<!-- =========================================================
     MODAL
========================================================== -->

<div class="modal-overlay" id="modalOverlay">

    <div class="modal">


        <div class="modal-header">

            <div>

                <h2 id="modalTitle">
                    Add New Product
                </h2>

                <p id="modalSubtitle">
                    Enter the information below
                </p>

            </div>


            <button
                class="close-btn"
                id="closeModal"
            >

                <i data-lucide="x"></i>

            </button>

        </div>



        <!-- FORM WILL BE CREATED BY JS -->

        <form id="dynamicForm">

            <div id="formFields"></div>


            <div class="modal-actions">

                <button
                    type="button"
                    class="cancel-btn"
                    id="cancelModal"
                >
                    Cancel
                </button>


                <button
                    type="submit"
                    class="primary-btn"
                    id="submitModal"
                >
                    Create
                </button>

            </div>

        </form>

    </div>

</div>



<!-- =========================================================
     VIEW ORDER MODAL
========================================================== -->

<div class="modal-overlay" id="orderViewOverlay">

    <div class="modal">

        <div class="modal-header">

            <div>

                <h2 id="orderViewTitle">
                    Order Details
                </h2>

                <p id="orderViewSubtitle">
                    Full order information
                </p>

            </div>


            <button
                class="close-btn"
                id="closeOrderView"
            >

                <i data-lucide="x"></i>

            </button>

        </div>



        <div style="padding:25px">

            <div class="form-grid" id="orderViewFields"></div>

            <div class="form-group full" style="margin-top:18px">

                <label>Update Status</label>

                <select id="orderViewStatus">
                    <option>Pending</option>
                    <option>Processing</option>
                    <option>Delivered</option>
                    <option>Cancelled</option>
                </select>

            </div>

            <div class="modal-actions">

                <button
                    type="button"
                    class="cancel-btn"
                    id="closeOrderViewBtn"
                >
                    Close
                </button>

                <button
                    type="button"
                    class="primary-btn"
                    id="updateOrderStatusBtn"
                >
                    Update Status
                </button>

            </div>

        </div>

    </div>

</div>



<script>
    window.GADGET_CATEGORIES = <?= json_encode($categoryNames, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
</script>

<script>
    window.GADGET_ADMIN = <?= json_encode($currentAdmin, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
</script>

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

<!-- Your JavaScript -->
<script src="script.js"></script>

</body>

</html>