var lengthHelpT = document.getElementById("lengthHelpT");
    var lengthHelpF = document.getElementById("lengthHelpF");
    var numberHelpT = document.getElementById("numberHelpT");
    var numberHelpF = document.getElementById("numberHelpF");
    var specialHelpT = document.getElementById("specialHelpT");
    var specialHelpF = document.getElementById("specialHelpF");
    var matchHelpT = document.getElementById("matchHelpT");
    var matchHelpF = document.getElementById("matchHelpF");
    var nameHelpT = document.getElementById("nameHelpT");
    var nameHelpF = document.getElementById("nameHelpF");

    var saveButton = document.getElementById("register");

    function validateName() {

        enableSave = false;
        const regexPatternSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;

        var firstNameInput = document.getElementById("firstName").value;
        var lastNameInput = document.getElementById("lastName").value;
        var fnameValidate = regexPatternSpecial.test(firstNameInput);
        var lnameValidate = regexPatternSpecial.test(lastNameInput);

        if (fnameValidate || lnameValidate) {
            nameHelpF.style.display = "block";
            nameHelpT.style.display = "none";
            enableSave = false;
        } else {
            nameHelpF.style.display = "none";
            nameHelpT.style.display = "block";
            enableSave = true;
        }

        if (enableSave) {
            saveButton.removeAttribute('disabled');
        } else {
            saveButton.setAttribute('disabled', 'true');
        }

    }

    function validatePassword() {
        // Length (8-20 characters)
        const regexPatternLength = /^.{8,20}$/;

        var passwordInput = document.getElementById("password").value;
        var isValidLength = regexPatternLength.test(passwordInput);

        enableSave1 = false;
        enableSave2 = false;
        enableSave3 = false;
        enableSave4 = false;
        if (isValidLength) {
            //saveButton.removeAttribute('disabled');
            lengthHelpT.style.display = "block";
            lengthHelpF.style.display = "none";
            enableSave1 = true;
        } else {
            //saveButton.setAttribute('disabled', 'true');
            lengthHelpF.style.display = "block";
            lengthHelpT.style.display = "none";
            enableSave1 = false;
        }

        //At least 1 number
        const regexPatternNumber = /\d/;
        var isValidNumber = regexPatternNumber.test(passwordInput);

        if (isValidNumber) {
            numberHelpT.style.display = "block";
            numberHelpF.style.display = "none";
            enableSave2 = true;
        } else {
            numberHelpF.style.display = "block";
            numberHelpT.style.display = "none";
            enableSave2 = false;
        }

        //No special characters
        const regexPatternSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/;
        var isValidSpecial = regexPatternSpecial.test(passwordInput);

        if (isValidSpecial) {
            specialHelpF.style.display = "block";
            specialHelpT.style.display = "none";
            enableSave3 = false;
        } else {
            specialHelpT.style.display = "block";
            specialHelpF.style.display = "none";
            enableSave3 = true;
        }

        //check repeat match
        var passwordInput2 = document.getElementById("repeatPassword").value;

        if (passwordInput == passwordInput2) {
            matchHelpT.style.display = "block";
            matchHelpF.style.display = "none";
            enableSave4 = true;
        } else {
            matchHelpF.style.display = "block";
            matchHelpT.style.display = "none";
            enableSave4 = false;
        }

        if (enableSave1 && enableSave2 && enableSave3 && enableSave4) {
            saveButton.removeAttribute('disabled');
        } else {
            saveButton.setAttribute('disabled', 'true');
        }


    }

    

    function validateEmailFormat(input) {
        // Regex pattern
        const regexPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        var emailInput = input.value;
        var isValid = regexPattern.test(emailInput);


        if (isValid) {
            emailHelpT.style.display = "block";
            emailHelpF.style.display = "none";
            saveButton.removeAttribute('disabled');
        } else {
            emailHelpF.style.display = "block";
            emailHelpT.style.display = "none";
            saveButton.setAttribute('disabled', 'true');
        }
    }