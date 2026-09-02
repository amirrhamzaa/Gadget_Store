/* =====================================================
   GADGET STORE ADMIN
===================================================== */


/* =====================================================
   ICONS
===================================================== */

function refreshIcons() {
    lucide.createIcons();
}


/* =====================================================
   PAGE NAVIGATION
===================================================== */

const pages = document.querySelectorAll(".page");

const navItems = document.querySelectorAll(
    ".nav-item[data-page]"
);

const pageTitle = document.getElementById("pageTitle");


const pageNames = {

    dashboard: "Dashboard",

    users: "Users",

    products: "Products",

    categories: "Categories",

    orders: "Orders",

    "profile-settings": "Profile Settings"

};


function showPage(pageName) {

    pages.forEach(page => {

        page.classList.remove("active-page");

    });


    const page = document.getElementById(pageName);

    if (page) {

        page.classList.add("active-page");

    }


    navItems.forEach(item => {

        item.classList.remove("active");

        if (item.dataset.page === pageName) {

            item.classList.add("active");

        }

    });


    pageTitle.textContent =
        pageNames[pageName] || "Dashboard";


    if (history.replaceState) {
        history.replaceState(null, null, "#" + pageName);
    } else {
        window.location.hash = pageName;
    }


    document.querySelector(".sidebar")
        .classList.remove("open");


    refreshIcons();

    window.scrollTo(0, 0);
}


navItems.forEach(item => {

    item.addEventListener("click", function () {

        showPage(this.dataset.page);

    });

});


/* Restore whichever tab was active before a reload (e.g. after
   saving a product/order), instead of always resetting to Dashboard. */
(function restoreActivePage() {

    const hash = window.location.hash.replace("#", "");

    if (hash && document.getElementById(hash) && pageNames.hasOwnProperty(hash)) {
        showPage(hash);
    }

})();


/* =====================================================
   MOBILE MENU
===================================================== */

document
    .getElementById("menuBtn")
    .addEventListener("click", function () {

        document
            .querySelector(".sidebar")
            .classList.toggle("open");

    });


/* =====================================================
   MODAL
===================================================== */

const modalOverlay =
    document.getElementById("modalOverlay");

const modalTitle =
    document.getElementById("modalTitle");

const modalSubtitle =
    document.getElementById("modalSubtitle");

const formFields =
    document.getElementById("formFields");

const dynamicForm =
    document.getElementById("dynamicForm");

const submitModal =
    document.getElementById("submitModal");


let currentType = "";

let editRow = null;


/* =====================================================
   OPEN MODAL
===================================================== */

function openModal(type, row = null) {

    currentType = type;

    editRow = row;


    modalOverlay.classList.add("show");


    if (type === "product") {

        modalTitle.textContent =
            row ? "Edit Product" : "Add New Product";

        modalSubtitle.textContent =
            "Enter product information";

        submitModal.textContent =
            row ? "Update Product" : "Create Product";

        productForm();

    }


    if (type === "user") {

        modalTitle.textContent =
            row ? "Edit User" : "Add New User";

        modalSubtitle.textContent =
            "Create a Seller, Customer or Delivery Agent";

        submitModal.textContent =
            row ? "Update User" : "Create User";

        userForm();

    }


    if (type === "category") {

        modalTitle.textContent =
            row ? "Edit Category" : "Add New Category";

        modalSubtitle.textContent =
            "Enter category information";

        submitModal.textContent =
            row ? "Update Category" : "Create Category";

        categoryForm();

    }


    refreshIcons();
}


/* =====================================================
   CLOSE MODAL
===================================================== */

function closeModal() {

    modalOverlay.classList.remove("show");

    dynamicForm.reset();

    formFields.innerHTML = "";

    editRow = null;

}


document
    .getElementById("closeModal")
    .addEventListener("click", closeModal);


document
    .getElementById("cancelModal")
    .addEventListener("click", closeModal);


/* click outside */

modalOverlay.addEventListener("click", function (event) {

    if (event.target === modalOverlay) {

        closeModal();

    }

});


/* =====================================================
   PRODUCT FORM
===================================================== */

function productForm() {

    formFields.innerHTML = `

        <div class="form-grid">

            <div class="form-group">

                <label>
                    Product Name *
                </label>

                <input
                    type="text"
                    id="productName"
                    placeholder="Enter product name"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Price *
                </label>

                <input
                    type="number"
                    id="productPrice"
                    placeholder="699"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Category *
                </label>

                <select id="productCategory" required>

                    <option value="" disabled selected>Select category</option>
                    ${window.GADGET_CATEGORIES.map(c => `<option>${escapeHtml(c)}</option>`).join("")}

                </select>

            </div>


            <div class="form-group">

                <label>
                    Stock *
                </label>

                <input
                    type="number"
                    id="productStock"
                    placeholder="25"
                    required
                >

            </div>


            <div class="form-group full">

                <label>
                    Description *
                </label>

                <textarea
                    id="productDescription"
                    placeholder="Enter product description"
                    required
                ></textarea>

            </div>


            <div class="form-group">

                <label>
                    Product Image
                </label>

                <input
                    type="file"
                    id="productImage"
                    accept="image/*"
                >

            </div>


            <div class="form-group">

                <label>
                    Status
                </label>

                <select id="productStatus">

                    <option>Active</option>

                    <option>Inactive</option>

                </select>

            </div>

        </div>

    `;
}


/* =====================================================
   USER FORM
===================================================== */

function userForm() {

    formFields.innerHTML = `

        <div class="form-grid">

            <div class="form-group">

                <label>
                    Full Name *
                </label>

                <input
                    type="text"
                    id="userName"
                    placeholder="Enter full name"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Email Address *
                </label>

                <input
                    type="email"
                    id="userEmail"
                    placeholder="Enter email address"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Phone Number *
                </label>

                <input
                    type="text"
                    id="userPhone"
                    placeholder="Enter phone number"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    User Role *
                </label>

                <select id="userRole" required>

                    <option value="">
                        Select role
                    </option>

                    <option>Seller</option>

                    <option>Customer</option>

                    <option>Delivery Agent</option>

                </select>

            </div>


            <div class="form-group">

                <label>
                    Password *
                </label>

                <input
                    type="password"
                    id="userPassword"
                    placeholder="Enter password"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Status
                </label>

                <select id="userStatus">

                    <option>Active</option>

                    <option>Inactive</option>

                </select>

            </div>


            <div class="form-group full">

                <label>
                    Address
                </label>

                <textarea
                    id="userAddress"
                    placeholder="Enter full address"
                ></textarea>

            </div>

        </div>

    `;
}


/* =====================================================
   CATEGORY FORM
===================================================== */

function categoryForm() {

    formFields.innerHTML = `

        <div class="form-grid">

            <div class="form-group full">

                <label>
                    Category Name *
                </label>

                <input
                    type="text"
                    id="categoryName"
                    placeholder="Example: Laptops"
                    required
                >

            </div>


            <div class="form-group full">

                <label>
                    Description *
                </label>

                <textarea
                    id="categoryDescription"
                    placeholder="Enter category description"
                    required
                ></textarea>

            </div>


            <div class="form-group">

                <label>
                    Status
                </label>

                <select id="categoryStatus">

                    <option>Active</option>

                    <option>Inactive</option>

                </select>

            </div>

        </div>

    `;
}


/* =====================================================
   OPEN BUTTONS
===================================================== */

document
    .getElementById("addProductBtn")
    .addEventListener("click", function () {

        openModal("product");

    });


document
    .getElementById("addUserBtn")
    .addEventListener("click", function () {

        openModal("user");

    });


document
    .getElementById("addCategoryBtn")
    .addEventListener("click", function () {

        openModal("category");

    });


/* =====================================================
   FORM SUBMIT
===================================================== */

dynamicForm.addEventListener("submit", function (event) {

    event.preventDefault();


    if (currentType === "product") {

        saveProduct();

    }


    if (currentType === "user") {

        saveUser();

    }


    if (currentType === "category") {

        saveCategory();

    }

});


/* =====================================================
   SAVE PRODUCT
===================================================== */

async function saveProduct() {
    const form = new FormData();
    if (editRow) form.append("id", editRow.dataset.id);
    form.append("product_name", document.getElementById("productName").value.trim());
    form.append("price", document.getElementById("productPrice").value);
    form.append("category", document.getElementById("productCategory").value);
    form.append("stock", document.getElementById("productStock").value);
    form.append("description", document.getElementById("productDescription").value.trim());
    form.append("status", document.getElementById("productStatus").value);
    const image = document.getElementById("productImage");
    if (image && image.files[0]) form.append("image", image.files[0]);
    form.append("action", editRow ? "update_product" : "add_product");
    await sendAdminRequest(form);
}

/* =====================================================
   SAVE USER
===================================================== */

async function saveUser() {
    const form = new FormData();
    if (editRow) form.append("id", editRow.dataset.id);
    form.append("name", document.getElementById("userName").value.trim());
    form.append("email", document.getElementById("userEmail").value.trim());
    form.append("phone", document.getElementById("userPhone").value.trim());
    form.append("role", document.getElementById("userRole").value);
    form.append("password", document.getElementById("userPassword").value);
    form.append("status", document.getElementById("userStatus").value);
    form.append("address", document.getElementById("userAddress").value.trim());
    form.append("action", editRow ? "update_user" : "add_user");
    await sendAdminRequest(form);
}

/* =====================================================
   SAVE CATEGORY
===================================================== */

async function saveCategory() {
    const form = new FormData();
    if (editRow) form.append("id", editRow.dataset.id);
    form.append("name", document.getElementById("categoryName").value.trim());
    form.append("description", document.getElementById("categoryDescription").value.trim());
    form.append("status", document.getElementById("categoryStatus").value);
    form.append("action", editRow ? "update_category" : "add_category");
    await sendAdminRequest(form);
}

/* =====================================================
   DELETE
===================================================== */

document.addEventListener("click", async function (event) {
    const deleteButton = event.target.closest(".delete-btn");
    if (!deleteButton) return;
    const row = deleteButton.closest("tr");
    if (!row || !row.dataset.id) return;
    if (!confirm("Are you sure you want to delete this item?")) return;
    const tableId = row.parentElement.id;
    const type = tableId === "productsTable" ? "product" : tableId === "usersTable" ? "user" : "category";
    const form = new FormData();
    form.append("action", "delete_" + type);
    form.append("id", row.dataset.id);
    await sendAdminRequest(form);
});

/* =====================================================
   EDIT
===================================================== */

document.addEventListener("click", function (event) {
    const editButton = event.target.closest(".edit-btn");
    if (!editButton) return;
    const row = editButton.closest("tr");
    if (!row) return;

    if (row.parentElement.id === "productsTable") {
        openModal("product", row);
        setTimeout(() => {
            document.getElementById("productName").value = row.cells[0].querySelector("strong").textContent.trim();
            document.getElementById("productPrice").value = row.cells[1].textContent.replace(/[^0-9.]/g, "");
            document.getElementById("productStock").value = row.cells[2].textContent.trim();
            document.getElementById("productCategory").value = row.cells[3].textContent.trim();
            document.getElementById("productDescription").value = row.cells[0].querySelector("small").textContent.trim();
            document.getElementById("productStatus").value = row.cells[4].textContent.trim();
        }, 20);
    } else if (row.parentElement.id === "usersTable") {
        openModal("user", row);
        setTimeout(() => {
            document.getElementById("userName").value = row.cells[0].querySelector("strong").textContent.trim();
            document.getElementById("userEmail").value = row.cells[2].textContent.trim();
            document.getElementById("userPhone").value = row.cells[3].textContent.trim();
            document.getElementById("userRole").value = row.cells[1].textContent.trim();
            document.getElementById("userStatus").value = row.cells[4].textContent.trim();
            document.getElementById("userPassword").required = false;
            document.getElementById("userPassword").placeholder = "Leave blank to keep current password";
        }, 20);
    } else if (row.parentElement.id === "categoriesTable") {
        openModal("category", row);
        setTimeout(() => {
            document.getElementById("categoryName").value = row.cells[0].querySelector("strong").textContent.trim();
            document.getElementById("categoryDescription").value = row.cells[1].textContent.trim();
            document.getElementById("categoryStatus").value = row.cells[3].textContent.trim();
        }, 20);
    }
});

/* =====================================================
   DASHBOARD COUNTS
===================================================== */
function updateProductCount() {}
function updateUserCount() {}

/* =====================================================
   VIEW ORDER
===================================================== */

const orderViewOverlay = document.getElementById("orderViewOverlay");
const orderViewFields = document.getElementById("orderViewFields");
const orderViewStatus = document.getElementById("orderViewStatus");
let currentOrderId = null;

function openOrderView(order) {
    currentOrderId = order.id;

    const rows = [
        ["Order ID", "#ORD-" + order.id],
        ["Customer", order.customer_name || "Guest"],
        ["Product", order.product_name || ""],
        ["Quantity", order.quantity || 0],
        ["Total", "৳" + Number(order.total_price || 0).toFixed(2)],
        ["Order Date", order.order_date || ""]
    ];

    orderViewFields.innerHTML = rows.map(function (r) {
        return '<div class="form-group full"><label>' + r[0] + '</label>' +
            '<input class="input" type="text" value="' +
            String(r[1]).replace(/"/g, "&quot;") +
            '" readonly></div>';
    }).join("");

    orderViewStatus.value = order.status || "Pending";

    orderViewOverlay.classList.add("show");
}

function closeOrderView() {
    orderViewOverlay.classList.remove("show");
    currentOrderId = null;
}

document
    .getElementById("closeOrderView")
    .addEventListener("click", closeOrderView);

document
    .getElementById("closeOrderViewBtn")
    .addEventListener("click", closeOrderView);

document
    .getElementById("updateOrderStatusBtn")
    .addEventListener("click", async function () {
        if (!currentOrderId) return;
        const form = new FormData();
        form.append("action", "update_order_status");
        form.append("id", currentOrderId);
        form.append("status", orderViewStatus.value);
        await sendAdminRequest(form);
    });

orderViewOverlay.addEventListener("click", function (event) {
    if (event.target === orderViewOverlay) {
        closeOrderView();
    }
});

document.addEventListener("click", function (event) {

    if (event.target.closest(".view-btn")) {
        const btn = event.target.closest(".view-btn");
        try {
            const order = JSON.parse(btn.dataset.order);
            openOrderView(order);
        } catch (e) { alert("Unable to load order details."); }
    }

});


/* =====================================================
   LOGOUT
===================================================== */

document
    .querySelector(".logout")
    .addEventListener("click", function () {

        const confirmLogout =
            confirm(
                "Are you sure you want to logout?"
            );


        if (confirmLogout) {

            window.location.href = "../Controller/logout.php";

        }

    });


function escapeHtml(value) {
    return String(value).replace(/[&<>"']/g, ch => ({"&":"&amp;","<":"&lt;",">":"&gt;","\"":"&quot;","'":"&#039;"}[ch]));
}

async function sendAdminRequest(form) {
    try {
        const response = await fetch("../Controller/adminController.php", { method: "POST", body: form });
        const data = await response.json();
        if (!data.success) { alert(data.message || "Operation failed."); return false; }
        window.location.reload();
        return true;
    } catch (error) {
        alert("Server error. Please check XAMPP/Apache and the database connection.");
        return false;
    }
}

// Search and filter without changing the original visual design.
function filterRows(inputId, tableId) {
    const input = document.getElementById(inputId);
    if (!input) return;
    input.addEventListener("input", function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll(`#${tableId} tr`).forEach(row => { row.style.display = row.textContent.toLowerCase().includes(q) ? "" : "none"; });
    });
}
filterRows("userSearch", "usersTable");
filterRows("productSearch", "productsTable");

const productCategoryFilter = document.getElementById("productCategoryFilter");
if (productCategoryFilter) productCategoryFilter.addEventListener("change", function () {
    const value = this.value.toLowerCase();
    document.querySelectorAll("#productsTable tr").forEach(row => { row.style.display = value === "all" || row.cells[3].textContent.trim().toLowerCase() === value ? "" : "none"; });
});
const userRoleFilter = document.getElementById("userRoleFilter");
if (userRoleFilter) userRoleFilter.addEventListener("change", function () {
    const value = this.value.toLowerCase();
    document.querySelectorAll("#usersTable tr").forEach(row => {
        const role = row.cells[1].textContent.trim().toLowerCase();
        row.style.display = value === "all" || role === value ? "" : "none";
    });
});

/* =====================================================
   INITIALIZE
===================================================== */

showPage("dashboard");

refreshIcons();

/* =========================================
   PROFILE SETTINGS
========================================= */

const saveProfile = document.getElementById("saveProfile");

if (saveProfile) {

    saveProfile.addEventListener("click", async function () {

        const name =
            document.getElementById("adminName").value.trim();

        const email =
            document.getElementById("adminEmail").value.trim();

        const phone =
            document.getElementById("adminPhone").value.trim();

        const password =
            document.getElementById("adminPassword").value;

        const confirmPassword =
            document.getElementById("confirmPassword").value;

        // Name check
        if (name === "") {
            alert("Please enter your name.");
            return;
        }

        // Email check
        if (email === "") {
            alert("Please enter your email.");
            return;
        }

        // Password check
        if (password !== "" && password !== confirmPassword) {
            alert("Passwords do not match.");
            return;
        }

        if (password !== "" && password.length < 6) {
            alert("Password must be at least 6 characters.");
            return;
        }

        const form = new FormData();
        form.append("action", "update_profile");
        form.append("name", name);
        form.append("email", email);
        form.append("phone", phone);
        form.append("password", password);

        // sendAdminRequest reloads the page on success, which also
        // re-shows this same tab (see the URL-hash tab-persist logic).
        await sendAdminRequest(form);

    });

}


/* =========================================
   CANCEL BUTTON
========================================= */

const profileCancel =
    document.getElementById("profileCancel");

if (profileCancel) {

    profileCancel.addEventListener("click", function () {

        const admin = window.GADGET_ADMIN || {};

        document.getElementById("adminName").value =
            admin.name || "";

        document.getElementById("adminEmail").value =
            admin.email || "";

        document.getElementById("adminPhone").value =
            admin.phone || "";

        document.getElementById("adminPassword").value =
            "";

        document.getElementById("confirmPassword").value =
            "";

    });

}
