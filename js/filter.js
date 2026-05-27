function filterProducts(category) {
    const products = document.querySelectorAll(".product-card");

    products.forEach(product => {
        if (category === "all") {
            product.style.display = "block"; // Show all products
        } else {
            const productCategory = product.getAttribute("data-category");
            if (productCategory === category) {
                product.style.display = "block"; // Show matching category
            } else {
                product.style.display = "none"; // Hide other categories
            }
        }
    });
}
