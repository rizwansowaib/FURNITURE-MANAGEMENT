// Function to redirect to payment page with product details
function redirectToPayment(productName, productPrice) {
    const url = `payment.html?name=${encodeURIComponent(productName)}&price=${encodeURIComponent(productPrice)}`;
    window.location.href = url;
}

// Function to filter products based on selected category
function filterByCategory() {
    const selectedCategory = document.getElementById("category-select").value;
    const products = document.querySelectorAll(".product-card");

    products.forEach(product => {
        const category = product.getAttribute("data-category");

        if (selectedCategory === "all" || category === selectedCategory) {
            product.style.display = "block"; // Show the product
        } else {
            product.style.display = "none"; // Hide the product
        }
    });
}

// Ensure the script runs only after the DOM is fully loaded
document.addEventListener("DOMContentLoaded", () => {
    const categorySelect = document.getElementById("category-select");
    if (categorySelect) {
        categorySelect.addEventListener("change", filterByCategory);
    }
});
