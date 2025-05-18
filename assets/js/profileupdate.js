document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.querySelector('form');
    const firstnameInput = document.getElementById('fname');
    const lastnameInput = document.getElementById('lname');
    const ageInput = document.getElementById('age');
    const genderInput = document.getElementById('gender');


    loginForm.addEventListener('update', function (e) {
        let valid = true;
        let messages = [];
        clearErrors();

        if (firstnameInput.value.trim() === '') {
            valid = false;
            messages.push('First Name is required');
            showError(usernameInput, 'Firstname is required');
        }

        if (lastnameInput.value.trim() === '') {
            valid = false;
            messages.push('Last Name is required');
            showError(passwordInput, 'Last Name is required');
        } 
        
        if (ageInput.value.trim() === '') {
            valid = false;
            messages.push('Age is required');
            showError(passwordInput, 'Age is required');
        }

        if (genderInput.value.trim() === '') {
            valid = false;
            messages.push('Gender is required');
            showError(passwordInput, 'Gender is required');
        }

        if (!valid) {
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