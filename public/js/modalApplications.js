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

function resetFormAndClose(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    const form = modal.querySelector("form");
    if (form) {
      form.reset();
    }
    modal.classList.add("hidden");
  }
}

function copyToClipboard(text) {
  navigator.clipboard.writeText(text).then(
    function () {
      alert("Lien copié dans le presse-papier !");
    },
    function (err) {
      alert("Erreur lors de la copie : " + err);
    }
  );
}

function copyToClipboard(text) {
  navigator.clipboard.writeText(text).then(
    function () {
      showToast("Lien copié dans le presse-papier !");
    },
    function (err) {
      showToast("Erreur lors de la copie : " + err);
    }
  );
}

function showToast(message) {
  const toast = document.getElementById("toast");
  toast.textContent = message;
  toast.classList.remove("hidden");
  toast.classList.add("opacity-100");

  setTimeout(() => {
    toast.classList.add("opacity-0");
    setTimeout(() => {
      toast.classList.add("hidden");
      toast.classList.remove("opacity-100");
    }, 300); // attendre la fin de la transition
  }, 2000);
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
