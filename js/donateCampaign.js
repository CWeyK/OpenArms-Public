document.addEventListener("DOMContentLoaded", function() {
    // Get the donation amount input and the <p> element by id
    var donationInput = document.getElementById("donationAmount");
    var donationDisplay = document.getElementById("donationAmountDisplay");
    var totalDonation = document.getElementById("donationTotalAmount");

    // Listen for the input event on the donation amount input
    donationInput.addEventListener("input", function() {
        // Update the content of the <p> element with the new donation amount
        var donationAmount = donationInput.value;
        donationDisplay.textContent = "RM" + (donationAmount ? parseFloat(donationAmount).toFixed(2) : "0.00");
        totalDonation.textContent = "RM" + (donationAmount ? parseFloat(donationAmount).toFixed(2) : "0.00");
    });
});