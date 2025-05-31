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
    setTimeout(initTinyMCE, 100);
  }
}

function openModalEditApplication(id) {
  const modal = document.getElementById("modalApplicationEdit-" + id);
  if (modal) {
    modal.classList.remove("hidden");
    setTimeout(() => initTinyMCEEdit(id), 100);
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

function initTinyMCE() {
  if (typeof tinymce !== "undefined") {
    if (tinymce.editors.length > 0) {
      tinymce.editors.forEach((editor) => editor.remove());
    }
    tinymce.init({
      selector: "textarea.tinymce",
      menubar: "",
      skin: darkModeSkin(),
      content_css: darkModeContentCss(),
      height: 300,
      branding: false,
    });
  }
}

function initTinyMCEEdit(id) {
  if (typeof tinymce !== "undefined") {
    if (tinymce.editors.length > 0) {
      tinymce.editors.forEach((editor) => editor.remove());
    }
    tinymce.init({
      selector: "#note-" + id,
      menubar: "",
      skin: darkModeSkin(),
      content_css: darkModeContentCss(),
      height: 300,
      branding: false,
    });
  }
}

function darkModeSkin() {
  return document.documentElement.classList.contains("dark")
    ? "oxide-dark"
    : "oxide";
}

function darkModeContentCss() {
  return document.documentElement.classList.contains("dark")
    ? "dark"
    : "default";
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
