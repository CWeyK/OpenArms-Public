document.addEventListener('DOMContentLoaded', function () {
    var fileInput = document.getElementById('profilePic');
    var fileInfo = document.getElementById('fileInfo');
    var saveChangesButton = document.getElementById('editRestaurantPhoto');

    fileInput.addEventListener('change', function () {
        var file = fileInput.files[0];

        // Check file type
        if (!file.type.startsWith('image/') || file.type === 'image/gif') {
            fileInfo.textContent = 'Error: Only JPEG, JPG, and PNG files are allowed.';
            fileInput.value = ''; // Clear the file input
            disableSaveButton();
            return;
        }

        // Check file size
        var maxSize = 2 * 1024 * 1024; // 2 MB
        if (file.size > maxSize) {
            fileInfo.textContent = 'Error: File size exceeds the maximum limit (2 MB).';
            fileInput.value = ''; // Clear the file input
            disableSaveButton();
            return;
        }

        // Display file information
        fileInfo.textContent = 'File selected: ' + file.name + ' (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';
        enableSaveButton();
    });

    // Function to disable the "Save Changes" button
    function disableSaveButton() {
        saveChangesButton.disabled = true;
        saveChangesButton.style.backgroundColor = 'red'; // Change the button color to red
    }
    

    // Function to enable the "Save Changes" button
    function enableSaveButton() {
        saveChangesButton.disabled = false;
        saveChangesButton.style.backgroundColor = ''; // Reset the button color
    }
});
