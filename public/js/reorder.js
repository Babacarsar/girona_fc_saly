(function () {
  document.querySelectorAll("[data-reorder-body]").forEach((tbody) => {
    const form = document.getElementById(tbody.dataset.reorderForm);
    if (!form) return;

    const syncIds = () => {
      form.querySelectorAll('input[name="ids[]"]').forEach((el) => el.remove());
      tbody.querySelectorAll("tr[data-id]").forEach((row) => {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "ids[]";
        input.value = row.dataset.id;
        form.appendChild(input);
      });
    };

    form.addEventListener("submit", syncIds);

    if (window.Sortable) {
      Sortable.create(tbody, {
        handle: ".reorder-handle",
        animation: 150,
        onEnd: syncIds,
      });
    }
  });
})();
