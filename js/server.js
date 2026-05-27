// server.js for Online Shopping Furniture Management System

const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();
const PORT = 3000;

// Middleware
app.use(bodyParser.json());
app.use(cors());

// In-memory storage for products and cart (for demonstration purposes)
let products = [
    { id: 1, name: 'Luxury Sofa', price: 499.99, description: 'A premium leather sofa.', stock: 10 },
    { id: 2, name: 'Dining Table', price: 299.99, description: 'A sturdy wooden dining table.', stock: 5 },
    { id: 3, name: 'Office Chair', price: 149.99, description: 'Ergonomic office chair.', stock: 20 }
];

let cart = [];

// Routes

// Get all products
app.get('/api/products', (req, res) => {
    res.json(products);
});

// Get product by ID
app.get('/api/products/:id', (req, res) => {
    const product = products.find(p => p.id === parseInt(req.params.id));
    if (product) {
        res.json(product);
    } else {
        res.status(404).json({ message: 'Product not found' });
    }
});

// Add to cart
app.post('/api/cart', (req, res) => {
    const { productId, quantity } = req.body;
    const product = products.find(p => p.id === productId);

    if (!product || product.stock < quantity) {
        return res.status(400).json({ message: 'Product not available or insufficient stock' });
    }

    product.stock -= quantity;
    const cartItem = cart.find(item => item.productId === productId);

    if (cartItem) {
        cartItem.quantity += quantity;
    } else {
        cart.push({ productId, quantity });
    }

    res.json({ message: 'Product added to cart', cart });
});

// Get cart items
app.get('/api/cart', (req, res) => {
    const cartDetails = cart.map(item => {
        const product = products.find(p => p.id === item.productId);
        return {
            productId: item.productId,
            name: product.name,
            price: product.price,
            quantity: item.quantity,
            total: product.price * item.quantity
        };
    });
    res.json(cartDetails);
});

// Checkout
app.post('/api/checkout', (req, res) => {
    const { paymentDetails } = req.body;

    if (!paymentDetails || !paymentDetails.cardName || !paymentDetails.cardNumber || !paymentDetails.expiryDate || !paymentDetails.cvv) {
        return res.status(400).json({ message: 'Invalid payment details' });
    }

    cart = [];
    res.json({ message: 'Checkout successful. Thank you for your purchase!' });
});

