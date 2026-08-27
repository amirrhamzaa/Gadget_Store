let orders = [
  {
    id: "#ORD-1001",
    customer: "John Doe",
    phone: "+880 1712-345678",
    address: "House 12, Road 5, Dhanmondi, Dhaka",
    product: "Dell Inspiron 15",
    price: "$699.00",
    date: "May 19, 2025 - 10:00 AM",
    status: "Picked Up"
  },
  {
    id: "#ORD-1002",
    customer: "Sarah Khan",
    phone: "+880 1687-654321",
    address: "House 45, Road 12, Banani, Dhaka",
    product: "Sony WH-CH520",
    price: "$59.99",
    date: "May 19, 2025 - 11:30 AM",
    status: "In Transit"
  },
  {
    id: "#ORD-1003",
    customer: "Ahmed Ali",
    phone: "+880 1811-223344",
    address: "Plot 21, Avenue 3, Uttara, Dhaka",
    product: "Realme Buds T300",
    price: "$49.99",
    date: "May 19, 2025 - 01:00 PM",
    status: "Pending"
  },
  {
    id: "#ORD-1004",
    customer: "Mim Akter",
    phone: "+880 1977-887766",
    address: "House 8, Road 2, Mirpur, Dhaka",
    product: "boAt Wave Flex",
    price: "$29.99",
    date: "May 19, 2025 - 03:00 PM",
    status: "Pending"
  }
];

let currentOrderIdForStatus = null;

document.addEventListener("DOMContentLoaded", () => {
  renderOrders();
  renderHistory();
  setupSidebar();
  setupTopbar();
  setupQuickActions();
  setupModals();
});

function renderOrders() {
  const dashboardBody = document.querySelector("#ordersTable tbody");
  const fullBody = document.querySelector("#ordersTableFull tbody");

  dashboardBody.innerHTML = "";
  fullBody.innerHTML = "";

  orders.forEach((order) => {
    const rowHTML = buildOrderRow(order);
    dashboardBody.insertAdjacentHTML("beforeend", rowHTML);
    fullBody.insertAdjacentHTML("beforeend", rowHTML);
  });

  updateStats();
  attachRowButtonEvents();
}

function buildOrderRow(order) {
  const badgeClass = order.status.replace(/\s+/g, "");
  return `
    <tr>
      <td><b>${order.id}</b><br><span style="color:#a6a4b8">${order.date}</span></td>
      <td>${order.customer}<br><span style="color:#a6a4b8">${order.phone}</span></td>
      <td>${order.address}</td>
      <td>${order.product}<br><span style="color:#a6a4b8">${order.price}</span></td>
      <td><span class="badge ${badgeClass}">${order.status}</span></td>
      <td>
        <div class="row-actions">
          <button class="btn-outline btn-view" data-id="${order.id}">View Details</button>
          <button class="btn-solid btn-update" data-id="${order.id}">Update Status ▾</button>
        </div>
      </td>
    </tr>
  `;
}

function updateStats() {
  const total = orders.length;
  const pending = orders.filter(o => o.status !== "Delivered").length;
  const completed = orders.filter(o => o.status === "Delivered").length;

  document.getElementById("statTotal").textContent = total;
  document.getElementById("statPending").textContent = pending;
  document.getElementById("statCompleted").textContent = completed;
}

function attachRowButtonEvents() {
  document.querySelectorAll(".btn-view").forEach((btn) => {
    btn.addEventListener("click", () => openDetailsModal(btn.dataset.id));
  });

  document.querySelectorAll(".btn-update").forEach((btn) => {
    btn.addEventListener("click", () => openStatusModal(btn.dataset.id));
  });
}

function openDetailsModal(orderId) {
  const order = orders.find(o => o.id === orderId);
  if (!order) return;

  document.getElementById("detailsBody").innerHTML = `
    <p><b>Order ID:</b> ${order.id}</p>
    <p><b>Customer:</b> ${order.customer}</p>
    <p><b>Phone:</b> ${order.phone}</p>
    <p><b>Address:</b> ${order.address}</p>
    <p><b>Product:</b> ${order.product}</p>
    <p><b>Price:</b> ${order.price}</p>
    <p><b>Date:</b> ${order.date}</p>
    <p><b>Status:</b> ${order.status}</p>
  `;

  openModal("detailsModal");
}

function openStatusModal(orderId) {
  currentOrderIdForStatus = orderId;
  document.getElementById("statusOrderLabel").textContent = `Order: ${orderId}`;
  openModal("statusModal");
}

function setupModals() {

  document.querySelectorAll(".modal-close").forEach((btn) => {
    btn.addEventListener("click", () => closeModal(btn.dataset.close));
  });

  document.querySelectorAll(".modal-overlay").forEach((overlay) => {
    overlay.addEventListener("click", (e) => {
      if (e.target === overlay) closeModal(overlay.id);
    });
  });

  document.querySelectorAll(".status-choice").forEach((btn) => {
    btn.addEventListener("click", () => {
      const newStatus = btn.dataset.status;
      const order = orders.find(o => o.id === currentOrderIdForStatus);
      if (order) {
        order.status = newStatus;
        renderOrders();
        showToast(`${order.id} status updated to "${newStatus}"`);
      }
      closeModal("statusModal");
    });
  });
}

function openModal(id) {
  document.getElementById(id).classList.add("open");
}

function closeModal(id) {
  document.getElementById(id).classList.remove("open");
}

function setupSidebar() {
  document.querySelectorAll(".nav-item").forEach((btn) => {
    btn.addEventListener("click", () => {
      goToPage(btn.dataset.page);
    });
  });

  document.querySelectorAll("[data-goto]").forEach((btn) => {
    btn.addEventListener("click", () => goToPage(btn.dataset.goto));
  });

  document.getElementById("logoutBtn").addEventListener("click", () => {
    const sure = confirm("আপনি কি সত্যিই লগ-আউট করতে চান?");
    if (sure) {
      showToast("Logged out successfully.");

    }
  });
}

function goToPage(pageName) {

  document.querySelectorAll(".page").forEach((p) => p.classList.remove("active"));
  document.getElementById(`page-${pageName}`).classList.add("active");

  document.querySelectorAll(".nav-item").forEach((btn) => {
    btn.classList.toggle("active", btn.dataset.page === pageName);
  });

  window.scrollTo({ top: 0, behavior: "smooth" });
}

function setupTopbar() {

  document.getElementById("searchInput").addEventListener("input", (e) => {
    const query = e.target.value.trim().toLowerCase();
    filterOrders(query);
  });

  document.getElementById("notifBtn").addEventListener("click", () => {
    showToast("You have no new notifications.");
  });

  document.getElementById("profileMenuBtn").addEventListener("click", () => {
    goToPage("profile");
  });
}

function filterOrders(query) {
  document.querySelectorAll("#ordersTable tbody tr, #ordersTableFull tbody tr").forEach((row) => {
    const text = row.textContent.toLowerCase();
    row.style.display = text.includes(query) ? "" : "none";
  });
}

function setupQuickActions() {

  document.getElementById("quickUpdateStatus").addEventListener("click", () => {
    const firstOrder = orders[0];
    if (firstOrder) openStatusModal(firstOrder.id);
  });

  document.getElementById("quickHelp").addEventListener("click", () => {
    showToast("Support: call 16247 or email support@gadgetstore.com");
  });
}

function renderHistory() {
  const history = [
    { id: "#ORD-0991", customer: "Rafiq Islam", product: "HP Wireless Mouse", date: "May 17, 2025", status: "Delivered" },
    { id: "#ORD-0994", customer: "Nusrat Jahan", product: "Logitech Keyboard", date: "May 18, 2025", status: "Delivered" },
    { id: "#ORD-0996", customer: "Tanvir Hasan", product: "Samsung Charger", date: "May 18, 2025", status: "Delivered" }
  ];

  const body = document.querySelector("#historyTable tbody");
  body.innerHTML = history.map(h => `
    <tr>
      <td><b>${h.id}</b></td>
      <td>${h.customer}</td>
      <td>${h.product}</td>
      <td>${h.date}</td>
      <td><span class="badge Delivered">${h.status}</span></td>
    </tr>
  `).join("");
}

let toastTimer = null;
function showToast(message) {
  const toast = document.getElementById("toast");
  toast.textContent = message;
  toast.classList.add("show");

  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => {
    toast.classList.remove("show");
  }, 2500);
}
