document.addEventListener("DOMContentLoaded", () => {
    // Get elements
    const buyNowButton = document.getElementById("buyNowBtn");
    const paymentModal = document.getElementById("payment-modal");
    const closeModalButton = document.getElementById("closeModal");
    const khaltiOption = document.getElementById("khalti-option");
    const esewaOption = document.getElementById("esewa-option");

    // Show the modal when "Buy Now" is clicked
    buyNowButton.addEventListener("click", () => {
        paymentModal.style.display = "flex"; // Display modal
    });

    // Close the modal when the close button is clicked
    closeModalButton.addEventListener("click", () => {
        paymentModal.style.display = "none"; // Hide modal
    });

    // Close the modal when clicking outside the modal content
    window.addEventListener("click", (event) => {
        if (event.target === paymentModal) {
            paymentModal.style.display = "none";
        }
    });

    // Add event listeners for payment options
    khaltiOption.addEventListener("click", () => {
        alert("Proceeding to payment with Khalti!");
        paymentModal.style.display = "none"; // Hide modal after selection
    });

    esewaOption.addEventListener("click", () => {
        alert("Proceeding to payment with eSewa!");
        paymentModal.style.display = "none"; // Hide modal after selection
    });
});
