function redirectToCart() {
    window.location.href = 'cart.php';
}

function incrementQuantity(productId) {
    var inputElement = document.getElementById('quantityInput' + productId);
    inputElement.value = parseInt(inputElement.value, 10) + 1;
}

function decrementQuantity(productId) {
    var inputElement = document.getElementById('quantityInput' + productId);
    var newValue = parseInt(inputElement.value, 10) - 1;
    inputElement.value = newValue >= 1 ? newValue : 1;
}