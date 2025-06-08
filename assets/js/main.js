// assets/js/main.js

// Form Validation
function validateForm(event) {
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    let valid = true;

    // Email Validation
    if (!email.value || !/\S+@\S+\.\S+/.test(email.value)) {
        emailError.textContent = 'Please enter a valid email.';
        valid = false;
    } else {
        emailError.textContent = '';
    }

    // Password Validation
    if (password.value.length < 6) {
        passwordError.textContent = 'Password must be at least 6 characters.';
        valid = false;
    } else {
        passwordError.textContent = '';
    }

    if (!valid) {
        event.preventDefault();
    }
}

// Dropdown menu for user roles (admin, customer, etc.)
function toggleDropdownMenu() {
    const dropdownMenu = document.getElementById('dropdownMenu');
    dropdownMenu.classList.toggle('show');
}

document.addEventListener('DOMContentLoaded', function () {
    // Sample event listener for form submission (e.g., login form)
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', validateForm);
    }
});
