document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.querySelector('form');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');

    loginForm.addEventListener('submit', function (e) {
        let valid = true;
        let messages = [];
        clearErrors();

        if (usernameInput.value.trim() === '') {
            valid = false;
            messages.push('Username is required');
            showError(usernameInput, 'Username is required');
        }

        if (passwordInput.value.trim() === '') {
            valid = false;
            messages.push('Password is required');
            showError(passwordInput, 'Password is required');
        } else if (passwordInput.value.length < 6) {
            valid = false;
            messages.push('Password must be at least 6 characters');
            showError(passwordInput, 'Password must be at least 6 characters');
        }

        if (!valid) {
            e.preventDefault(); 
        }
        else{
            window.location.href = 'features.php'; 
            e.preventDefault(); 
        }
    });

    function showError(input, message) {
        const error = document.createElement('div');
        error.className = 'input-error';
        error.innerText = message;
        input.parentElement.appendChild(error);
    }

    function clearErrors() {
        const errors = document.querySelectorAll('.input-error');
        errors.forEach(err => err.remove());
    }
});
