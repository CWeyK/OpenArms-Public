document.addEventListener("DOMContentLoaded", function () {
    const sortCheckbox = document.querySelectorAll(".sortCheckbox");
    var resetBtn = document.querySelector(".resetBtn");

    var checkboxes = document.querySelectorAll(".form-check-input");
    var topDonationSelect = document.querySelector(".topDonationSelect");
    var selectElement = document.querySelector("#country");
    var applyFilterBtn = document.querySelector(".applyFilterBtn");

    resetBtn.addEventListener("click", function () {
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = false;
        });

        selectElement.selectedIndex = 0;
        updateSelectedCount();
    });

    sortCheckbox.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            sortCheckbox.forEach(function (otherCheckbox) {
                if (otherCheckbox !== checkbox) {
                    otherCheckbox.checked = false;
                }
            });

            updateSelectedCount();
        });
    });

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            updateSelectedCount();
        });
    });

    selectElement.addEventListener("change", function () {
        updateSelectedCount();
    });

    function updateSelectedCount() {
        var checkedCheckboxes = Array.from(checkboxes).filter(
            (checkbox) => checkbox.checked
        );

        var selectedCount = checkedCheckboxes.length;

        if (selectElement.selectedIndex !== 0) {
            selectedCount += selectElement.selectedOptions.length;
        }

        // Check if the topDonation checkbox is in the checkedCheckboxes array
        var topDonationCheckbox = checkedCheckboxes.find(checkbox => checkbox.id === 'topDonation');
        if (topDonationCheckbox) {
            topDonationSelect.style.display = 'block';
        } else {
            topDonationSelect.style.display = 'none';
        }

        applyFilterBtn.textContent = `(${selectedCount} Selected) Apply`;
    }
});
