document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form');
    const deleteCheckboxes = document.querySelectorAll('.delete-checkbox');
    const deleteButton = document.getElementById('delete-product-btn');

    deleteButton.disabled = true;

    deleteCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const atLeastOneChecked = Array.from(deleteCheckboxes).some(
                checkbox => checkbox.checked
            );
            deleteButton.disabled = !atLeastOneChecked;
        });
    });

    deleteButton.addEventListener('click', function () {
        const selectedProducts = Array.from(deleteCheckboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.dataset.productId);

        document.getElementById('selectedProducts').value = JSON.stringify(selectedProducts);

        form.submit();
    });
});