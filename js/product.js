document.addEventListener("DOMContentLoaded", function () {
    let searchInput = document.getElementById("search-bar");
    let categorySelect = document.getElementById("category-select");

    if (searchInput) {
        // Search on "Enter" key
        searchInput.addEventListener("keypress", function (event) {
            if (event.key === "Enter") {
                searchProducts();
            }
        });

        // Live search
        searchInput.addEventListener("input", searchProducts);
    }

    if (categorySelect) {
        categorySelect.addEventListener("change", function () {
            filterProducts(categorySelect.value);
        });
    }
});

// Function to filter products based on category
function filterProducts(category) {
    let products = document.querySelectorAll(".product-card");

    products.forEach(product => {
        let productCategory = product.getAttribute("data-category").toLowerCase();
        let selectedCategory = category.toLowerCase();

        if (selectedCategory === "all" || productCategory === selectedCategory) {
            product.style.display = "block";
        } else {
            product.style.display = "none";
        }
    });
}

// Function to search products
function searchProducts() {
    let input = document.getElementById("search-bar").value.toLowerCase();
    let products = document.querySelectorAll(".product-card");

    products.forEach(product => {
        let titleElement = product.querySelector("h3");
        let title = titleElement ? titleElement.innerText.toLowerCase() : "";

        product.style.display = title.includes(input) ? "block" : "none";
    });
}
