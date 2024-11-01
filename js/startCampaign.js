function showAlert(message) {
    var alertElement = document.querySelector(".successAlert");
    var alertMessage = "<div id='alertMessage' class='alert alert-danger alert-dismissible fade show'>"+message+"<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    alertElement.innerHTML = alertMessage;
}

function validateFirstPage() {
    // Check if a category is selected
    var selectedCategory = document.querySelector(
        'input[name="category"]:checked'
    );
    if (!selectedCategory) {
        showAlert("Please select a category.");
        return false;
    }

    // Check if country and state are selected
    var selectedCountry = document.getElementById("country").value;
    var selectedState = document.getElementById("state").value;
    if (selectedCountry === "" || selectedState === "") {
        showAlert("Please select both country and state.");
        return false;
    }

    return true;
}

function validateSecondPage() {
    // Get the input fields on the second page
    var campaignNameInput = document.querySelector(
        "input[name='campaignName']"
    );
    var fileInput = document.querySelector("input[type='file']");
    var descriptionTextarea = document.querySelector(
        "textarea[name='description']"
    );

    // Check if the fields are empty
    if (
        campaignNameInput.value.trim() === "" ||
        fileInput.value.trim() === "" ||
        descriptionTextarea.value.trim() === ""
    ) {
        // Display an alert or perform some action to inform the user
        showAlert("Please fill in all the required fields.");
        return false; // Prevent the form from proceeding
    }

    // If all fields are filled, proceed to the next step
    return true;
}

function validateThirdPage() {
    // Get the input fields on the second page
    var goal = document.querySelector("input[name='goal']");

    // Check if the fields are empty
    if (goal.value.trim() === "") {
        // Display an alert or perform some action to inform the user
        showAlert("Please fill in the goal.");
        return false; // Prevent the form from proceeding
    }

    // If all fields are filled, proceed to the next step
    return true;
}

function showSecondPage() {
    if (validateFirstPage()) {
        document.querySelector(".campaignFirstPage").style.transform =
            "translateX(-110%)";
        document.querySelector(".campaignSecondPage").style.transform =
            "translateX(0)";
        document.querySelector(".backButton").style.display = "block";
        document.querySelector(".nextButton").onclick = showThirdPage;
        document.querySelector(".progress-bar").style.width = "33%";
    }
}

function showThirdPage() {
    if (validateSecondPage()) {
        document.querySelector(".campaignFirstPage").style.transform =
            "translateX(-110%)";
        document.querySelector(".campaignSecondPage").style.transform =
            "translateX(-110%)";
        document.querySelector(".campaignThirdPage").style.transform =
            "translateX(0)";
        document.querySelector(".backButton").onclick = backSecondPage;
        document.querySelector(".nextButton").onclick = showFourthPage;
        document.querySelector(".progress-bar").style.width = "66%";
    }
}

function showFourthPage() {
    if (validateThirdPage()) {
        document.querySelector(".campaignFirstPage").style.transform =
            "translateX(-110%)";
        document.querySelector(".campaignSecondPage").style.transform =
            "translateX(-110%)";
        document.querySelector(".campaignThirdPage").style.transform =
            "translateX(-110%)";
        document.querySelector(".campaignFourthPage").style.transform =
            "translateX(0)";
        document.querySelector(".backButton").onclick = backThirdPage;
        document.querySelector(".progress-bar").style.width = "100%";
        document.querySelector(".nextButton").innerHTML = "Submit";
        setTimeout(function () {
            document.querySelector(".nextButton").type = "submit";
        }, 501);
    }
}

function backFirstPage() {
    document.querySelector(".campaignFirstPage").style.transform =
        "translateX(0)";
    document.querySelector(".campaignSecondPage").style.transform =
        "translateX(110%)";
    document.querySelector(".backButton").style.display = "none";
    document.querySelector(".nextButton").onclick = showSecondPage;
    document.querySelector(".progress-bar").style.width = "0%";
}

function backSecondPage() {
    document.querySelector(".campaignSecondPage").style.transform =
        "translateX(0)";
    document.querySelector(".campaignThirdPage").style.transform =
        "translateX(110%)";
    document.querySelector(".backButton").onclick = backFirstPage;
    document.querySelector(".nextButton").onclick = showThirdPage;
    document.querySelector(".progress-bar").style.width = "33%";
}

function backThirdPage() {
    document.querySelector(".campaignThirdPage").style.transform =
        "translateX(0)";
    document.querySelector(".campaignFourthPage").style.transform =
        "translateX(110%)";
    document.querySelector(".backButton").onclick = backSecondPage;
    document.querySelector(".nextButton").onclick = showFourthPage;
    document.querySelector(".nextButton").innerHTML = "Continue";
    document.querySelector(".nextButton").type = "button";
    document.querySelector(".progress-bar").style.width = "66%";
}
