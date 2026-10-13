document.addEventListener("DOMContentLoaded", () => {
  const btnEdit = document.getElementById("btnEdit");
  const modal = document.getElementById("editModal");
  const closeModal = document.getElementById("closeModal");
  const form = document.getElementById("editProfileForm");

  if (!form) return;

  // Abrir modal
  btnEdit.addEventListener("click", () => {
    modal.style.display = "flex";
  });

  // Cerrar modal
  closeModal.addEventListener("click", () => {
    modal.style.display = "none";
  });

  // Guardar sin recargar página
  form.addEventListener("submit", (e) => {
    e.preventDefault();

    fetch("update_profile.php", {
      method: "POST",
      body: new FormData(form),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          modal.style.display = "none";
          location.reload();
        } else {
          alert("Error al guardar los cambios");
        }
      })
      .catch(() => alert("Error de conexión"));
  });
});

// ===== DIRECCIÓN =====
const btnAddress = document.getElementById("btnAddress");
const addressModal = document.getElementById("addressModal");
const closeAddressModal = document.getElementById("closeAddressModal");
const addressForm = document.getElementById("addressForm");
const btnDeleteAddress = document.getElementById("btnDeleteAddress");

if (btnAddress) {
  btnAddress.onclick = () => (addressModal.style.display = "flex");
}

if (closeAddressModal) {
  closeAddressModal.onclick = () => (addressModal.style.display = "none");
}

if (addressForm) {
  addressForm.addEventListener("submit", (e) => {
    e.preventDefault();

    fetch("address_save.php", {
      method: "POST",
      body: new FormData(addressForm),
    })
      .then((r) => r.json())
      .then((d) => d.success && location.reload());
  });
}

if (btnDeleteAddress) {
  btnDeleteAddress.onclick = () => {
    if (!confirm("¿Eliminar dirección?")) return;

    fetch("address_delete.php")
      .then((r) => r.json())
      .then((d) => d.success && location.reload());
  };
}

document.addEventListener("DOMContentLoaded", () => {
  // PERFIL
  btnEdit?.addEventListener("click", () => editModal.classList.add("active"));
  closeModal?.addEventListener("click", () =>
    editModal.classList.remove("active")
  );

  // DIRECCIÓN
  btnAddress?.addEventListener("click", () =>
    addressModal.classList.add("active")
  );
  closeAddressModal?.addEventListener("click", () =>
    addressModal.classList.remove("active")
  );

  // TARJETA
  btnAddCard?.addEventListener("click", () => {
    cardModal.classList.add("active");
  });

  closeCardModal?.addEventListener("click", () => {
    cardModal.classList.remove("active");
  });

  // DEVOLUCIÓN
  document.querySelectorAll(".btnReturn").forEach((btn) => {
    btn.addEventListener("click", () => {
      document.getElementById("order_id").value = btn.dataset.id;
      returnModal.classList.add("active");
    });
  });

  closeReturnModal?.addEventListener("click", () => {
    returnModal.classList.remove("active");
  });
});
