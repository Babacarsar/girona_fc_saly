(function () {
  const sidebar = document.getElementById("adminSidebar");
  const backdrop = document.getElementById("adminSidebarBackdrop");
  const toggle = document.getElementById("adminSidebarToggle");

  function closeSidebar() {
    sidebar?.classList.remove("is-open");
    backdrop?.classList.remove("is-visible");
  }

  toggle?.addEventListener("click", () => {
    sidebar?.classList.toggle("is-open");
    backdrop?.classList.toggle("is-visible");
  });

  backdrop?.addEventListener("click", closeSidebar);

  document.querySelectorAll("[data-admin-delete]").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const form = btn.closest("form");
      const modal = document.getElementById("adminDeleteModal");
      const message = document.getElementById("adminDeleteMessage");
      if (!modal || !form) return;
      message.textContent =
        btn.getAttribute("data-admin-delete") ||
        "Cette action est irréversible.";
      modal.querySelector("[data-confirm-delete]").onclick = () => form.submit();
      bootstrap.Modal.getOrCreateInstance(modal).show();
    });
  });

  document.querySelectorAll("[data-image-preview]").forEach((input) => {
    const previewId = input.getAttribute("data-image-preview");
    const preview = previewId ? document.getElementById(previewId) : null;
    input.addEventListener("change", () => {
      const file = input.files?.[0];
      if (!file || !preview) return;
      preview.src = URL.createObjectURL(file);
      preview.classList.add("is-visible");
    });
  });

  document.querySelectorAll(".toast.auto-show").forEach((el) => {
    bootstrap.Toast.getOrCreateInstance(el, { delay: 4500 }).show();
  });
})();
