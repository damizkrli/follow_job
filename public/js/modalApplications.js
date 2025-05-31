function closeModalOnClickOutside(event) {
  const modal = event.target;
  if (modal.classList.contains("fixed")) {
    modal.classList.add("hidden");
  }
}

function openModalCreateApplication() {
  const modal = document.getElementById("modalApplicationCreate");
  if (modal) {
    modal.classList.remove("hidden");
  }
}

function openModalEditApplication(id) {
  const modal = document.getElementById("modalApplicationEdit-" + id);
  if (modal) {
    modal.classList.remove("hidden");
  }
}

function openModalShowApplication(id) {
  const modal = document.getElementById("modalApplicationShow-" + id);
  if (modal) {
    modal.classList.remove("hidden");
  }
}

function openModalRefusedApplications() {
  const modal = document.getElementById("modalRefusedApplications");
  if (modal) {
    modal.classList.remove("hidden");
  }
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.classList.add("hidden");
  }
}

document.addEventListener("click", function (e) {
  document
    .querySelectorAll(".dropdown-menu")
    .forEach((menu) => menu.classList.add("hidden"));

  const btn = e.target.closest("[data-dropdown-button]");
  if (btn) {
    const menu = btn.nextElementSibling;
    if (menu && menu.classList.contains("dropdown-menu")) {
      menu.classList.toggle("hidden");
    }
  }
});
