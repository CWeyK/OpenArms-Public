document.addEventListener('DOMContentLoaded', function() {
    var saveChangesButton = document.getElementById('confirmButton');

    saveChangesButton.disabled = true;
    saveChangesButton.style.backgroundColor = 'red'; // Change the button color to red
});