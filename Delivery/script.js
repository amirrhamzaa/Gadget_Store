
const menuItems = document.querySelectorAll(".menu-item");

menuItems.forEach(function (item) {
  item.addEventListener("click", function () {
    menuItems.forEach(function (i) {
      i.classList.remove("active");
    });
    item.classList.add("active");
  });
});


const bellBtn = document.getElementById("bellBtn");

bellBtn.addEventListener("click", function () {
  alert("You have no new notifications right now.");
});



const searchBox = document.getElementById("searchBox");
const tableRows = document.querySelectorAll("#ordersTable tbody tr");

searchBox.addEventListener("keyup", function () {
  const searchText = searchBox.value.toLowerCase();

  tableRows.forEach(function (row) {
    const rowText = row.textContent.toLowerCase();

    if (rowText.includes(searchText)) {
      row.style.display = "";        // show row
    } else {
      row.style.display = "none";    // hide row
    }
  });
});


// ---------- 4. Update Status button ----------
// Clicking the button moves the order to the next status:
// Pending -> Picked Up -> In Transit -> Completed
// It also updates the small counter numbers at the top.

const statusOrder = ["Pending", "Picked Up", "In Transit", "Completed"];

const updateButtons = document.querySelectorAll(".update-btn");

updateButtons.forEach(function (button) {
  button.addEventListener("click", function () {

    // find the status badge in the same row as this button
    const row = button.closest("tr");
    const statusBadge = row.querySelector(".status");

    const currentText = statusBadge.textContent.trim();
    const currentIndex = statusOrder.indexOf(currentText);

    // if it's already "Completed", do nothing more
    if (currentIndex === statusOrder.length - 1) {
      alert("This order is already completed!");
      return;
    }

    // move to the next status
    const nextStatus = statusOrder[currentIndex + 1];
    statusBadge.textContent = nextStatus;

    // remove old status color class, add the new one
    statusBadge.className = "status " + getStatusClass(nextStatus);

    updateCounters();
  });
});

// this function gives the correct CSS class name for a status
function getStatusClass(status) {
  if (status === "Pending") return "status-pending";
  if (status === "Picked Up") return "status-picked";
  if (status === "In Transit") return "status-transit";
  if (status === "Completed") return "status-completed";
}

// this function recalculates Pending / Completed numbers at the top
function updateCounters() {
  const allStatuses = document.querySelectorAll(".status");

  let pending = 0;
  let completed = 0;

  allStatuses.forEach(function (badge) {
    const text = badge.textContent.trim();
    if (text === "Pending") pending++;
    if (text === "Completed") completed++;
  });

  document.getElementById("pendingCount").textContent = pending;
  document.getElementById("completedCount").textContent = completed;
}
