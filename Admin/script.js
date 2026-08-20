function init() {
    lucide.createIcons();
    return false;
}

function toggleMenu() {

    const sidebar = document.getElementById("sidebar");
    const mainArea = document.getElementById("mainArea");

    if (window.innerWidth <= 768) {
        sidebar.classList.toggle("mobile-open");
    } else {
        sidebar.classList.toggle("collapsed");
        mainArea.classList.toggle("sidebar-collapsed");
    }

    return false;
}

function selectPage(button) {

    if (button.classList.contains("dots")) {
        return false;
    }

    const pageButtons = document.querySelectorAll(".page-number");

    for (let i = 0; i < pageButtons.length; i++) {
        pageButtons[i].classList.remove("active-page");
    }

    button.classList.add("active-page");

    return false;
}

function deleteProduct(button) {

    const row = button.closest("tr");
    const productName = row.dataset.name;

    const confirmed = confirm("Are you sure you want to delete " + productName + "?");

    if (confirmed) {

        row.remove();

        const remainingRows = document.querySelectorAll("#productTable tr");

        document.getElementById("productCount").innerHTML =
            "Showing 1 to " + remainingRows.length + " of " + remainingRows.length + " products";

    }

    return false;
}

function viewProduct(button) {

    const row = button.closest("tr");
    const productName = row.dataset.name;

    console.log("Viewing product:", productName);

    return false;
}

function editProduct(button) {

    const row = button.closest("tr");
    const productName = row.dataset.name;

    console.log("Editing product:", productName);

    return false;
}