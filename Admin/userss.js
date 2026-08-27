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

function addUser() {

    alert("Add New User clicked!");

    return false;
}

function searchUsers() {

    const input = document.getElementById("searchInput");
    const searchValue = input.value.toLowerCase();

    const rows = document.querySelectorAll("#userTable tr");

    for (let i = 0; i < rows.length; i++) {

        const userName = rows[i].dataset.name.toLowerCase();

        if (userName.includes(searchValue)) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }

    return false;
}

function viewUser(button) {

    const row = button.closest("tr");
    const userName = row.dataset.name;

    console.log("Viewing user:", userName);

    return false;
}

function editUser(button) {

    const row = button.closest("tr");
    const userName = row.dataset.name;

    console.log("Editing user:", userName);

    return false;
}

function deleteUser(button) {

    const row = button.closest("tr");
    const userName = row.dataset.name;

    const confirmed = confirm(
        "Are you sure you want to delete " + userName + "?"
    );

    if (confirmed) {

        row.remove();

        const remainingRows =
            document.querySelectorAll("#userTable tr");

        document.getElementById("userCount").innerHTML =
            "Showing 1 to " +
            remainingRows.length +
            " of " +
            remainingRows.length +
            " users";
    }

    return false;
}