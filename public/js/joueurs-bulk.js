(function () {
  const selectAll = document.getElementById("joueurs-select-all");
  const boxes = () => document.querySelectorAll(".joueur-select");
  const bar = document.getElementById("joueurs-bulk-bar");
  const countEl = document.getElementById("joueurs-bulk-count");
  const deleteForm = document.getElementById("joueurs-bulk-delete-form");
  const updateForm = document.getElementById("joueurs-bulk-update-form");
  const deleteBtn = document.getElementById("joueurs-bulk-delete-btn");

  if (!selectAll || !bar) return;

  const selectedIds = () =>
    Array.from(boxes())
      .filter((cb) => cb.checked)
      .map((cb) => cb.value);

  const syncHiddenIds = (form) => {
    if (!form) return;
    form.querySelectorAll('input[name="ids[]"]').forEach((el) => el.remove());
    selectedIds().forEach((id) => {
      const input = document.createElement("input");
      input.type = "hidden";
      input.name = "ids[]";
      input.value = id;
      form.appendChild(input);
    });
  };

  const refreshUi = () => {
    const ids = selectedIds();
    const n = ids.length;
    countEl.textContent = String(n);
    bar.classList.toggle("d-none", n === 0);
    bar.classList.toggle("d-flex", n > 0);

    const all = boxes();
    selectAll.indeterminate = n > 0 && n < all.length;
    selectAll.checked = all.length > 0 && n === all.length;
  };

  selectAll.addEventListener("change", () => {
    boxes().forEach((cb) => {
      cb.checked = selectAll.checked;
    });
    refreshUi();
  });

  boxes().forEach((cb) => cb.addEventListener("change", refreshUi));

  deleteBtn?.addEventListener("click", () => {
    const n = selectedIds().length;
    if (n === 0) return;
    const modal = document.getElementById("adminDeleteModal");
    const message = document.getElementById("adminDeleteMessage");
    const confirm = modal?.querySelector("[data-confirm-delete]");
    if (!modal || !deleteForm || !message || !confirm) return;
    syncHiddenIds(deleteForm);
    message.textContent = `Supprimer ${n} joueur(s) ? Cette action est irréversible.`;
    confirm.onclick = () => deleteForm.submit();
    bootstrap.Modal.getOrCreateInstance(modal).show();
  });

  updateForm?.addEventListener("submit", (e) => {
    if (selectedIds().length === 0) {
      e.preventDefault();
      return;
    }
    syncHiddenIds(updateForm);
  });

  document
    .getElementById("joueursBulkEditModal")
    ?.addEventListener("show.bs.modal", () => syncHiddenIds(updateForm));
})();
