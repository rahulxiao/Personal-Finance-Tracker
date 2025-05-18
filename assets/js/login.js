

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

    // If all is valid, redirect
    if (isValid) {
        window.location.href = "features.php"; // Replace with your desired page
    }

    return false; // Prevent form default submission

    function showError(inputId, message) {
    const inputBox = document.getElementById(inputId).parentElement;
    inputBox.classList.add('error');

    const errorMessage = document.createElement('span');
    errorMessage.className = 'error-message';
    errorMessage.style.color = 'red';
    errorMessage.textContent = message;
    inputBox.appendChild(errorMessage);
}

}


