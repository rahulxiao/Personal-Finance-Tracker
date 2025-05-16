document.addEventListener('DOMContentLoaded', function () {
    const loginButton = document.getElementById('login-button');
    const registerButton = document.getElementById('register-button');
    
    loginButton.addEventListener('click', function () {
        window.location.href = 'view/login.html';
    }
    );
    registerButton.addEventListener('click', function () {
        window.location.href = 'view/register.html';
    }
    );
    }
    // This code adds event listeners to the login and register buttons. When clicked, they redirect the user to the respective pages.
    // The event listeners are set up once the DOM content is fully loaded, ensuring that the buttons are available for interaction.
    );
    