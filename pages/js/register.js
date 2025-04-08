document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('register-form');
    const createAccountBtn = document.querySelector('.btn-primary');

    createAccountBtn.addEventListener('click', function (e) {
        e.preventDefault();
        clearErrors();

        let valid = true;

        // Get form elements
        const firstname = document.getElementById('firstname');
        const lastname = document.getElementById('lastname');
        const username = document.getElementById('username');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm-password');
        const terms = document.getElementById('terms');

        // First name validation
        if (firstname.value.trim() === '') {
            showError('firstname-error', 'First name is required');
            valid = false;
        }

        // Last name validation
        if (lastname.value.trim() === '') {
            showError('lastname-error', 'Last name is required');
            valid = false;
        }

        // Username validation
        if (username.value.trim() === '') {
            showError('username-error', 'Username is required');
            valid = false;
        }

        // Basic email validation (no regex)
        if (email.value.trim() === '') {
            showError('email-error', 'Email is required');
            valid = false;
        } else if (!email.value.includes('@') || !email.value.includes('.')) {
            showError('email-error', 'Enter a valid email with "@" and "."');
            valid = false;
        }

        // Password validation
        const passwordValue = password.value;
        const passwordRequirements = document.getElementById('password-requirements');
        let passValid = true;

        // Show password requirements box if any condition fails
        if (passwordValue.length < 8) {
            markInvalid('length');
            passValid = false;
        }
        if (!/[A-Z]/.test(passwordValue)) {
            markInvalid('capital');
            passValid = false;
        }
        if (!/\d/.test(passwordValue)) {
            markInvalid('number');
            passValid = false;
        }
        if (!/[!@#$%^&*(),.?":{}|<>]/.test(passwordValue)) {
            markInvalid('special');
            passValid = false;
        }

        if (!passValid) {
            passwordRequirements.style.display = 'block';
            showError('password-error', 'Password does not meet all requirements');
            valid = false;
        }

        // Confirm password
        if (confirmPassword.value.trim() === '') {
            showError('confirm-password-error', 'Please confirm your password');
            valid = false;
        } else if (confirmPassword.value !== passwordValue) {
            showError('confirm-password-error', 'Passwords do not match');
            valid = false;
        }

        // Terms checkbox
        if (!terms.checked) {
            showError('terms-error', 'You must agree to the terms and privacy policy');
            valid = false;
        }

        // Final check
        if (valid) {
            window.location.href = 'mail-verification.html';
        }
    });

    function showError(id, message) {
        const element = document.getElementById(id);
        element.textContent = message;
    }

    function clearErrors() {
        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
        document.querySelectorAll('.requirement').forEach(el => el.classList.remove('invalid'));
        document.getElementById('password-requirements').style.display = 'none';
    }

    function markInvalid(id) {
        document.getElementById(id).classList.add('invalid');
    }
});
