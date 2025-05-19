function validateLogin() {
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();
    const form = document.getElementById('login-form');
    let isValid = true;

    // Reset any previous error states
    form.querySelectorAll('.input-box').forEach(box => box.classList.remove('error'));
    form.querySelectorAll('.error-message').forEach(msg => msg.remove());

    // Username validation
    if (!username) {
        showError('username', 'Username is required');
        isValid = false;
    } else if (username.length < 3) {
        showError('username', 'Username must be at least 3 characters');
        isValid = false;
    }

    // Password validation
    if (!password) {
        showError('password', 'Password is required');
        isValid = false;
    } else if (password.length < 6) {
        showError('password', 'Password must be at least 6 characters');
        isValid = false;
    }

    return isValid; // true = allow form submission, false = block it
}

// ✅ Define showError globally (not inside validateLogin)
function showError(inputId, message) {
    const inputBox = document.getElementById(inputId).parentElement;
    inputBox.classList.add('error');

    const errorMessage = document.createElement('span');
    errorMessage.className = 'error-message';
    errorMessage.style.color = 'red';
    errorMessage.style.fontSize = '0.85rem';
    errorMessage.style.marginTop = '4px';
    errorMessage.textContent = message;
    inputBox.appendChild(errorMessage);
}
