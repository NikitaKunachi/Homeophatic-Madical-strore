let cart = JSON.parse(localStorage.getItem('cart')) || [];

document.addEventListener('DOMContentLoaded', () => {
    loadCart();
    setupAddToCartButtons();
});

function addToCart(name, price) {
    console.log('Adding to cart:', name, price);

    if (!name || !price) {
        console.error('Invalid item data:', name, price);
        return;
    }

    let existingItem = cart.find(item => item.name === name);
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({ name, price, quantity: 1 });
    }

    localStorage.setItem('cart', JSON.stringify(cart));

    // Delay redirect to ensure data is stored properly
    setTimeout(() => {
        window.location.href = 'cart.html';
    }, 100);
}

function updateCartDisplay() {
    console.log('Updating cart display...');
    const cartItemsContainer = document.getElementById('cart-items');
    if (!cartItemsContainer) {
        console.log('Cart items container not found');
        return;
    }

    cartItemsContainer.innerHTML = '';
    cart.forEach(item => {
        console.log('Displaying item:', item);
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.name}</td>
            <td>$${item.price}</td>
            <td>${item.quantity}</td>
            <td>$${(item.price * item.quantity).toFixed(2)}</td>
            <td><button onclick="removeFromCart('${item.name}')">Remove</button></td>
        `;
        cartItemsContainer.appendChild(row);
    });

    // Display payment options if cart is not empty
    const paymentSection = document.getElementById('payment-options');
    if (paymentSection) {
        paymentSection.style.display = cart.length > 0 ? 'block' : 'none';
    }
}

function removeFromCart(name) {
    cart = cart.filter(item => item.name !== name);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartDisplay();
}

function loadCart() {
    console.log('Loading cart from localStorage');
    cart = JSON.parse(localStorage.getItem('cart')) || [];
    updateCartDisplay();
}

// Dynamically set event listeners for "Add to Cart" buttons
function setupAddToCartButtons() {
    document.querySelectorAll(".add-to-cart").forEach(button => {
        button.addEventListener("click", function () {
            const name = this.dataset.name;
            const price = parseFloat(this.dataset.price);
            addToCart(name, price);
        });
    });
}
