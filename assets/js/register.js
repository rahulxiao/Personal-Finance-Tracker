function validRegister() {
  // Get form input values
  const firstname = document.getElementById("firstname").value.trim();
  const lastname = document.getElementById("lastname").value.trim();
  const username = document.getElementById("username").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();
  const confirmPassword = document
    .getElementById("confirm-password")
    .value.trim();
  const terms = document.getElementById("terms").checked;
  const form = document.getElementById("register-form");
  let isValid = true;

  // Clear previous error states
  const inputBoxes = form.getElementsByClassName("input-box");
  const errorMessages = form.getElementsByClassName("error-message");
  for (let i = 0; i < inputBoxes.length; i++)
    inputBoxes[i].classList.remove("error");
  for (let i = 0; i < errorMessages.length; i++)
    errorMessages[i].textContent = "";

  // First name validation
  if (!firstname) {
    showError("firstname", "First name is required");
    isValid = false;
  } else if (firstname.length < 2) {
    showError("firstname", "First name must be at least 2 characters");
    isValid = false;
  }

  // Last name validation
  if (!lastname) {
    showError("lastname", "Last name is required");
    isValid = false;
  } else if (lastname.length < 2) {
    showError("lastname", "Last name must be at least 2 characters");
    isValid = false;
  }

  // Username validation
  if (!username) {
    showError("username", "Username is required");
    isValid = false;
  } else if (username.length < 3) {
    showError("username", "Username must be at least 3 characters");
    isValid = false;
  } else {
    let hasInvalidChar = false;
    for (let i = 0; i < username.length; i++) {
      const char = username[i];
      if (
        !(
          (char >= "a" && char <= "z") ||
          (char >= "A" && char <= "Z") ||
          (char >= "0" && char <= "9") ||
          char === "_"
        )
      ) {
        hasInvalidChar = true;
        break;
      }
    }
    if (hasInvalidChar) {
      showError(
        "username",
        "Username can only contain letters, numbers, and underscores"
      );
      isValid = false;
    }
  }

  // Email validation
  if (!email) {
    showError("email", "Email is required");
    isValid = false;
  } else {
    let hasAt = false;
    let hasDot = false;
    for (let i = 0; i < email.length; i++) {
      if (email[i] === "@") {
        hasAt = true;
      }
      if (email[i] === ".") {
        hasDot = true;
      }
    }
    if (!hasAt || !hasDot) {
      showError("email", "Please enter a valid email address");
      isValid = false;
    }
  }

  // Password validation
  if (!password) {
    showError("password", "Password is required");
    isValid = false;
  } else {
    let passwordErrors = [];
    if (password.length < 8) {
      passwordErrors.push("At least 8 characters");
    }
    let hasCapital = false;
    let hasNumber = false;
    let hasSpecial = false;
    for (let i = 0; i < password.length; i++) {
      const char = password[i];
      if (char >= "A" && char <= "Z") {
        hasCapital = true;
      } else if (char >= "0" && char <= "9") {
        hasNumber = true;
      } else if (
        !(char >= "a" && char <= "z") &&
        !(char >= "A" && char <= "Z") &&
        !(char >= "0" && char <= "9")
      ) {
        hasSpecial = true;
      }
    }
    if (!hasCapital) {
      passwordErrors.push("At least 1 uppercase letter");
    }
    if (!hasNumber) {
      passwordErrors.push("At least 1 number");
    }
    if (!hasSpecial) {
      passwordErrors.push("At least 1 special character");
    }
    if (passwordErrors.length > 0) {
      showError(
        "password",
        "Password must contain: " + passwordErrors.join(", ")
      );
      isValid = false;
    }
  }

  // Confirm password validation
  if (!confirmPassword) {
    showError("confirm-password", "Please confirm your password");
    isValid = false;
  } else if (confirmPassword !== password) {
    showError("confirm-password", "Passwords do not match");
    isValid = false;
  }

  // Terms checkbox validation
  if (!terms) {
    showError(
      "terms",
      "You must agree to the Terms of Service and Privacy Policy"
    );
    isValid = false;
  }

  return isValid;
}

function showError(inputId, message) {
  const inputBox = document.getElementById(inputId).parentElement;
  inputBox.classList.add("error");

  const errorDiv = document.getElementById(inputId + "-error");
  errorDiv.style.color = "red";
  errorDiv.textContent = message;
}
