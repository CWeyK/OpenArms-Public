function incrementQuantity(cartid) {
    var inputElement = document.getElementById('quantityInput' + cartid);
    inputElement.value = parseInt(inputElement.value, 10) + 1;

    triggerInputEvent(inputElement);
}

function decrementQuantity(cartid) {
    var inputElement = document.getElementById('quantityInput' + cartid);
    var newValue = parseInt(inputElement.value, 10) - 1;
    inputElement.value = newValue >= 1 ? newValue : 1;

    triggerInputEvent(inputElement);
}

// Function to trigger the input event
function triggerInputEvent(element) {
    var event = new Event('input', {
        bubbles: true,
        cancelable: true,
    });
    element.dispatchEvent(event);
}

//ajax for update database
$('.productQuantityInput').on('input', function() {
    var productId = $(this).data("productid");
    var newQuantity = $(this).val();
    var cartId = $(this).data("cartid");
    // Send AJAX request to update quantity in the database
    $.ajax({
        type: "POST",
        url: "server.php", 
        data: {
            productId: productId,
            newQuantity: newQuantity,
            cartId: cartId,
            changeQuantity: 1

        },
        success: function(response) {
            try {
                // Attempt to parse the JSON response
                var jsonResponse = JSON.parse(response);
        
                // Check if updatedCartCount is present in the parsed response
                if (jsonResponse.updatedCartCount !== undefined) {
                    // Update the summary
                    updateSummary(jsonResponse.updatedCartCount, jsonResponse.updatedCartTotal);
                }
            } catch (error) {
                console.error("Error parsing JSON response: " + error);
            }
        },
        error: function(error) {
            // Handle errors if needed
            console.error(error);
        }
    });
});

function updateSummary(quantity, totalPoints) {
    // Update total quantity
    if(quantity == 1)
        $('#totalQuantity').text(quantity + ' Item');
    else
        $('#totalQuantity').text(quantity + ' Items');

    // Update total points
    $('#totalPoints').text(totalPoints + ' Points');
}

function redirectToCheckOut() {
    window.location.href = 'checkout.php';
}

function unableToCheckOut() {
    alert("You have no items in your cart!");
}