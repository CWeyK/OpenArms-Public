var firstName = document.getElementById("firstName");
var lastName = document.getElementById("lastName");
var email = document.getElementById("email");
var contact = document.getElementById("contact");
var birthday = document.getElementById("birthday");
var address = document.getElementById("address");

var editButton = document.getElementById("editButton");
var saveContainer = document.getElementById("saveContainer");

var contactHelp = document.getElementById("contactHelp");
var emailHelp = document.getElementById("emailHelp");
var fNameHelp = document.getElementById("fNameHelp");

function enableEdit() {
    // Enable editing
    firstName.disabled = false;
    lastName.disabled = false;
    //email.disabled = false;
    contact.disabled = false;
    birthday.disabled = false;
    address.disabled = false;

    // Show save and cancel buttons, hide edit button
    editButton.style.display = "none";
    saveContainer.style.display = "inline-block";
    contactHelp.style.display = "inline-block";
    emailHelp.style.display = "inline-block";
    fNameHelp.style.display = "inline-block";
}

function cancelEdit() {
    // Disable editing
    firstName.disabled = true;
    lastName.disabled = true;
    //email.disabled = true;
    contact.disabled = true;
    birthday.disabled = true;
    address.disabled = true;

    // Show edit button, hide save and cancel buttons
    editButton.style.display = "inline-block";
    saveContainer.style.display = "none";
    contactHelp.style.display = "none";
    emailHelp.style.display = "none";
    fNameHelp.style.display = "none";
}

function validateContactFormat(input) {
    // Regex pattern
    const regexPattern = /^\+\d{7,15}$/;

    var contactInput = input.value;
    var isValid = regexPattern.test(contactInput);


    var saveButton = document.getElementById('profileSave');

    if (isValid) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        saveButton.removeAttribute('disabled');
    } else {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        saveButton.setAttribute('disabled', 'true');
    }
}

function validateEmailFormat(input) {
    // Regex pattern
    const regexPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    var emailInput = input.value;
    var isValid = regexPattern.test(emailInput);


    var saveButton = document.getElementById('profileSave');

    if (isValid) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        saveButton.removeAttribute('disabled');
    } else {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        saveButton.setAttribute('disabled', 'true');
    }
}

function validateFNameFormat(input) {
    // Regex pattern
    const regexPattern = /^[a-zA-Z\s\-]+$/;

    var nameInput = input.value;
    var isValid = regexPattern.test(nameInput);


    var saveButton = document.getElementById('profileSave');

    if (isValid) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        saveButton.removeAttribute('disabled');
    } else {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        saveButton.setAttribute('disabled', 'true');
        console.log("invalid");
    }
}


function validatePassword() {
    const newPasswordInput = document.getElementById('newPassword');
    const repeatPasswordInput = document.getElementById('repeatPassword');
    const submitBtn = document.getElementById('changePassword');

    const newPassword = newPasswordInput.value;
    const repeatPassword = repeatPasswordInput.value;

    // Password must be 8-20 characters long, contain letters and numbers,
    // and must not contain spaces, special characters, or emoji.
    const passwordRegex = /^(?=.*\d)[A-Za-z\d]{8,20}$/;


    // Validate new password
    if (!passwordRegex.test(newPassword)) {
        submitBtn.setAttribute('disabled', 'true');
        newPasswordInput.classList.add('is-invalid');
        newPasswordInput.classList.remove('is-valid');
    } else {
        submitBtn.removeAttribute('disabled');
        newPasswordInput.classList.remove('is-invalid');
        newPasswordInput.classList.add('is-valid');
    }

    // Validate repeat password
    if (repeatPassword !== newPassword || repeatPassword == "") {
        submitBtn.setAttribute('disabled', 'true');
        repeatPasswordInput.classList.add('is-invalid');
        repeatPasswordInput.classList.remove('is-valid');
    } else {
        submitBtn.removeAttribute('disabled');
        repeatPasswordInput.classList.remove('is-invalid');
        repeatPasswordInput.classList.add('is-valid');
    }
}

function copyToClipboard(text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand('copy');
    document.body.removeChild(textarea);

    // Show a tooltip or any other feedback to indicate successful copy
    const tooltipTrigger = document.querySelector('.copyBtn');
    const tooltip = new bootstrap.Tooltip(tooltipTrigger, {
        title: 'Copied!',
        placement: 'bottom'
    });
    tooltip.show();
}
