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

    orders: "Orders"

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

                    <option value="">
                        Select category
                    </option>

                    <option>Laptops</option>

                    <option>Smartphones</option>

                    <option>Accessories</option>

                    <option>Monitors</option>

                    <option>Cameras</option>

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

function saveProduct() {

    const name =
        document.getElementById("productName").value;

    const price =
        document.getElementById("productPrice").value;

    const category =
        document.getElementById("productCategory").value;

    const stock =
        document.getElementById("productStock").value;

    const description =
        document.getElementById("productDescription").value;

    const status =
        document.getElementById("productStatus").value;


    if (editRow) {

        editRow.cells[0].querySelector("strong")
            .textContent = name;

        editRow.cells[0].querySelector("small")
            .textContent = description;

        editRow.cells[1].textContent =
            "$" + price;

        editRow.cells[2].textContent =
            stock;

        editRow.cells[3].textContent =
            category;

        editRow.cells[4].innerHTML =
            `<span class="status ${
                status === "Active"
                ? "delivered"
                : "inactive"
            }">${status}</span>`;

    }

    else {

        const row =
            document.createElement("tr");


        row.innerHTML = `

            <td>

                <div class="product-info">

                    <div class="product-image">

                        <i data-lucide="package"></i>

                    </div>

                    <div>

                        <strong>
                            ${name}
                        </strong>

                        <small>
                            ${description}
                        </small>

                    </div>

                </div>

            </td>


            <td>
                $${price}
            </td>


            <td>
                ${stock}
            </td>


            <td>
                ${category}
            </td>


            <td>

                <span class="status ${
                    status === "Active"
                    ? "delivered"
                    : "inactive"
                }">

                    ${status}

                </span>

            </td>


            <td>

                <button class="icon-btn edit-btn">

                    <i data-lucide="pencil"></i>

                </button>


                <button class="icon-btn delete delete-btn">

                    <i data-lucide="trash-2"></i>

                </button>

            </td>

        `;


        document
            .getElementById("productsTable")
            .appendChild(row);


        updateProductCount();

    }


    closeModal();

    refreshIcons();

}


/* =====================================================
   SAVE USER
===================================================== */

function saveUser() {

    const name =
        document.getElementById("userName").value;

    const email =
        document.getElementById("userEmail").value;

    const phone =
        document.getElementById("userPhone").value;

    const role =
        document.getElementById("userRole").value;

    const status =
        document.getElementById("userStatus").value;


    const firstLetter =
        name.charAt(0).toUpperCase();


    let roleClass = "customer";


    if (role === "Seller") {

        roleClass = "seller";

    }

    else if (role === "Delivery Agent") {

        roleClass = "delivery";

    }


    if (editRow) {

        editRow.cells[0]
            .querySelector("strong")
            .textContent = name;

        editRow.cells[1].innerHTML =
            `<span class="role ${roleClass}">
                ${role}
            </span>`;

        editRow.cells[2].textContent =
            email;

        editRow.cells[3].textContent =
            phone;

        editRow.cells[4].innerHTML =
            `<span class="status ${
                status === "Active"
                ? "delivered"
                : "inactive"
            }">
                ${status}
            </span>`;

    }

    else {

        const row =
            document.createElement("tr");


        row.innerHTML = `

            <td>

                <div class="user-info">

                    <div class="avatar ${
                        roleClass === "seller"
                        ? "purple-bg"
                        : roleClass === "delivery"
                        ? "orange-bg"
                        : "green-bg"
                    }">

                        ${firstLetter}

                    </div>


                    <div>

                        <strong>
                            ${name}
                        </strong>

                        <small>
                            NEW USER
                        </small>

                    </div>

                </div>

            </td>


            <td>

                <span class="role ${roleClass}">

                    ${role}

                </span>

            </td>


            <td>
                ${email}
            </td>


            <td>
                ${phone}
            </td>


            <td>

                <span class="status ${
                    status === "Active"
                    ? "delivered"
                    : "inactive"
                }">

                    ${status}

                </span>

            </td>


            <td>

                <button class="icon-btn edit-btn">

                    <i data-lucide="pencil"></i>

                </button>


                <button class="icon-btn delete delete-btn">

                    <i data-lucide="trash-2"></i>

                </button>

            </td>

        `;


        document
            .getElementById("usersTable")
            .appendChild(row);


        updateUserCount();

    }


    closeModal();

    refreshIcons();

}


/* =====================================================
   SAVE CATEGORY
===================================================== */

function saveCategory() {

    const name =
        document.getElementById("categoryName").value;

    const description =
        document.getElementById("categoryDescription").value;

    const status =
        document.getElementById("categoryStatus").value;


    if (editRow) {

        editRow.cells[0]
            .querySelector("strong")
            .textContent = name;

        editRow.cells[1]
            .textContent = description;

        editRow.cells[3].innerHTML =
            `<span class="status ${
                status === "Active"
                ? "delivered"
                : "inactive"
            }">
                ${status}
            </span>`;

    }

    else {

        const row =
            document.createElement("tr");


        row.innerHTML = `

            <td>

                <strong>
                    ${name}
                </strong>

            </td>


            <td>
                ${description}
            </td>


            <td>
                0
            </td>


            <td>

                <span class="status ${
                    status === "Active"
                    ? "delivered"
                    : "inactive"
                }">

                    ${status}

                </span>

            </td>


            <td>

                <button class="icon-btn edit-btn">

                    <i data-lucide="pencil"></i>

                </button>


                <button class="icon-btn delete delete-btn">

                    <i data-lucide="trash-2"></i>

                </button>

            </td>

        `;


        document
            .getElementById("categoriesTable")
            .appendChild(row);

    }


    closeModal();

    refreshIcons();

}


/* =====================================================
   DELETE
===================================================== */

document.addEventListener("click", function (event) {

    const deleteButton =
        event.target.closest(".delete-btn");


    if (!deleteButton) {
        return;
    }


    const row =
        deleteButton.closest("tr");


    if (!row) {
        return;
    }


    const confirmed =
        confirm(
            "Are you sure you want to delete this item?"
        );


    if (confirmed) {

        row.remove();

        updateProductCount();

        updateUserCount();

    }

});


/* =====================================================
   EDIT
===================================================== */

document.addEventListener("click", function (event) {

    const editButton =
        event.target.closest(".edit-btn");


    if (!editButton) {
        return;
    }


    const row =
        editButton.closest("tr");


    if (!row) {
        return;
    }


    /* PRODUCTS */

    if (
        row.parentElement.id === "productsTable"
    ) {

        openModal("product", row);

        setTimeout(() => {

            document.getElementById("productName").value =
                row.cells[0]
                    .querySelector("strong")
                    .textContent;

            document.getElementById("productPrice").value =
                row.cells[1]
                    .textContent
                    .replace("$", "");

            document.getElementById("productStock").value =
                row.cells[2].textContent;

            document.getElementById("productCategory").value =
                row.cells[3].textContent;

            document.getElementById("productDescription").value =
                row.cells[0]
                    .querySelector("small")
                    .textContent;

        }, 50);

    }


    /* USERS */

    else if (
        row.parentElement.id === "usersTable"
    ) {

        openModal("user", row);

        setTimeout(() => {

            document.getElementById("userName").value =
                row.cells[0]
                    .querySelector("strong")
                    .textContent;

            document.getElementById("userEmail").value =
                row.cells[2].textContent;

            document.getElementById("userPhone").value =
                row.cells[3].textContent;

            document.getElementById("userRole").value =
                row.cells[1]
                    .textContent
                    .trim();

            document.getElementById("userStatus").value =
                row.cells[4]
                    .textContent
                    .trim();

        }, 50);

    }


    /* CATEGORIES */

    else if (
        row.parentElement.id === "categoriesTable"
    ) {

        openModal("category", row);

        setTimeout(() => {

            document.getElementById("categoryName").value =
                row.cells[0]
                    .querySelector("strong")
                    .textContent;

            document.getElementById("categoryDescription").value =
                row.cells[1].textContent.trim();

            document.getElementById("categoryStatus").value =
                row.cells[3]
                    .textContent
                    .trim();

        }, 50);

    }

});


/* =====================================================
   DASHBOARD COUNTS
===================================================== */

function updateProductCount() {

    const count =
        document
            .getElementById("productsTable")
            .rows.length;


    document
        .getElementById("dashboardProductCount")
        .textContent = 256 + count - 2;

}


function updateUserCount() {

    const count =
        document
            .getElementById("usersTable")
            .rows.length;


    document
        .getElementById("dashboardUserCount")
        .textContent = 160 + count;

}


/* =====================================================
   VIEW ORDER
===================================================== */

document.addEventListener("click", function (event) {

    if (
        event.target.classList.contains("view-btn")
    ) {

        alert(
            "Order details will open here."
        );

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

            alert(
                "Logout functionality will be connected with backend."
            );

        }

    });


/* =====================================================
   INITIALIZE
===================================================== */

showPage("dashboard");

refreshIcons();