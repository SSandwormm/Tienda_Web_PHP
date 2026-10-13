// Selecciona los elementos del DOM
const userBtn = document.querySelector("#user-btn");

// Detecta para admin y para usuario normal
const accountBox =
  document.querySelector(".account-box") || document.querySelector(".user-box");

const menuBtn = document.querySelector("#menu-btn");
const navbar = document.querySelector(".navbar");

// Toggle del botón de usuario
if (userBtn && accountBox) {
  userBtn.addEventListener("click", () => {
    accountBox.classList.toggle("active");
    navbar.classList.remove("active");
  });
}

// Toggle del menú
if (menuBtn) {
  menuBtn.addEventListener("click", () => {
    navbar.classList.toggle("active");
    if (accountBox) accountBox.classList.remove("active");
  });
}

// Quitar ambos al hacer scroll
window.addEventListener("scroll", () => {
  navbar.classList.remove("active");
  if (accountBox) accountBox.classList.remove("active");
});

// ==========================
//   EVITAR ERROR AQUÍ
// ==========================

// SOLO ejecuta este código si existe el botón close-update
const closeUpdateBtn = document.getElementById("close-update");
if (closeUpdateBtn) {
  closeUpdateBtn.addEventListener("click", function () {
    document.querySelector(".edit-product-form").style.display = "none";
    document.body.classList.remove("modal-open");
    window.history.replaceState({}, document.title, "productos.php");
  });
}

// ==========================
//        MODAL USERS
// ==========================

function openUserModal(id, name, email, role) {
  document.getElementById("edit_user_id").value = id;
  document.getElementById("edit_user_name").value = name;
  document.getElementById("edit_user_email").value = email;
  document.getElementById("edit_user_type").value = role;

  document.getElementById("editUserModal").classList.add("active");
}

function closeUserModal() {
  document.getElementById("editUserModal").classList.remove("active");
}
