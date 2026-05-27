// script.js

document.addEventListener('DOMContentLoaded', () => {
    console.log('Welcome to Furniture Hub!');
});

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Sample Product List (Can be dynamic)
const productsList = [
    "Stylish Chair",
    "Modern Sofa",
    "Luxurious Table",
    "Wooden Table",
    "Cozy Sofa",
    "Elegant Chair",
    "Classic Bookshelf",
    "Comfortable Recliner",
    "Dining Set",
    "Office Desk"
];

const searchInput = document.getElementById("search-input");
const suggestionsList = document.getElementById("search-suggestions");

// Function to display search suggestions
function showSuggestions() {
    let input = searchInput.value.toLowerCase();
    suggestionsList.innerHTML = ""; // Clear previous suggestions

    if (input.trim() === "") {
        suggestionsList.style.display = "none"; // Hide suggestions if input is empty
        return;
    }

    let filteredProducts = productsList.filter(product => product.toLowerCase().includes(input));

    if (filteredProducts.length > 0) {
        suggestionsList.style.display = "block"; // Show suggestions
        filteredProducts.forEach(product => {
            let li = document.createElement("li");
            li.textContent = product;
            li.addEventListener("click", function () {
                searchInput.value = product; // Set selected product
                suggestionsList.style.display = "none"; // Hide suggestions
                searchProducts(); // Trigger search
            });
            suggestionsList.appendChild(li);
        });
    } else {
        suggestionsList.style.display = "none";
    }
}

// Function to filter product cards when searching
function searchProducts() {
    let input = searchInput.value.toLowerCase();
    let products = document.querySelectorAll(".product-card");

    products.forEach((product) => {
        let productName = product.querySelector(".product-title").innerText.toLowerCase();
        if (productName.includes(input)) {
            product.style.display = "block";
        } else {
            product.style.display = "none";
        }
    });
}

// Event Listeners
searchInput.addEventListener("input", showSuggestions);

// Hide suggestions when clicking outside
document.addEventListener("click", (event) => {
    if (!searchInput.contains(event.target) && !suggestionsList.contains(event.target)) {
        suggestionsList.style.display = "none";
    }
});

// Search when pressing Enter key
searchInput.addEventListener("keydown", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        searchProducts();
        suggestionsList.style.display = "none"; // Hide suggestions after search
    }
});
