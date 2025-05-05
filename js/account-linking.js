// Initialize after DOM content is loaded
document.addEventListener("DOMContentLoaded", function () {
  // Initialize Feather icons
  feather.replace();

  // Show current date
  const currentDate = document.getElementById("current-date");
  if (currentDate) {
    const today = new Date();
    currentDate.textContent = today.toLocaleDateString("en-US", {
      year: "numeric",
      month: "long",
      day: "numeric",
    });
  }

  // Initialize form validation and submission
  initBankForm();

  // Initialize password toggle
  initPasswordToggle();
});

// Function to initialize bank form
function initBankForm() {
  const bankForm = document.getElementById("bank-connect-form");
  const bankSelect = document.getElementById("bank-select");
  const username = document.getElementById("username");
  const password = document.getElementById("password");
  const bankSelectError = document.getElementById("bank-select-error");
  const usernameError = document.getElementById("username-error");
  const passwordError = document.getElementById("password-error");

  if (!bankForm) return;

  // Bank select validation
  if (bankSelect) {
    bankSelect.addEventListener("change", function () {
      if (this.value === "") {
        bankSelectError.textContent = "Please select a bank";
      } else {
        bankSelectError.textContent = "";
      }
      validateForm();
    });
  }

  // Username validation
  if (username) {
    username.addEventListener("input", function () {
      if (this.value.trim() === "") {
        usernameError.textContent = "Username is required";
      } else if (this.value.length < 3) {
        usernameError.textContent = "Username must be at least 3 characters";
      } else {
        usernameError.textContent = "";
      }
      validateForm();
    });
  }

  // Password validation
  if (password) {
    password.addEventListener("input", function () {
      if (this.value === "") {
        passwordError.textContent = "Password is required";
      } else if (this.value.length < 6) {
        passwordError.textContent = "Password must be at least 6 characters";
      } else {
        passwordError.textContent = "";
      }
      validateForm();
    });
  }

  // Form submission
  if (bankForm) {
    bankForm.addEventListener("submit", function (e) {
      e.preventDefault();

      // Validate form again
      const isFormValid = validateForm();

      if (isFormValid) {
        // Show loading state
        const connectBtn = this.querySelector(".connect-btn");
        if (connectBtn) {
          connectBtn.disabled = true;
          connectBtn.textContent = "Connecting...";
        }

        // Simulate connection process
        setTimeout(() => {
          // Hide connection form, show bank details
          const connectionForm = document.getElementById("connection-form");
          const bankDetails = document.getElementById("bank-details");

          if (connectionForm) {
            connectionForm.style.display = "none";
          }

          if (bankDetails) {
            bankDetails.style.display = "block";

            // Update bank details with selected bank
            const bankName = document.getElementById("bank-name");
            if (bankName && bankSelect) {
              const selectedOption =
                bankSelect.options[bankSelect.selectedIndex];
              bankName.textContent = selectedOption.text;
            }

            // Set a random balance for demo
            const totalBalance = document.getElementById("total-balance");
            if (totalBalance) {
              const balance = (Math.random() * 10000).toFixed(2);
              totalBalance.textContent = "$" + balance;
            }

            // Add sample transactions for demo
            populateSampleData();
          }

          // Show success notification
          showNotification("Bank account connected successfully!", "success");

          // Reset form
          if (connectBtn) {
            connectBtn.disabled = false;
            connectBtn.textContent = "Connect";
          }

          // Reset form fields
          bankForm.reset();
        }, 2000);
      }
    });
  }

  // Add disconnect functionality
  const logoutBtn = document.querySelector(".logout-btn");
  if (logoutBtn) {
    logoutBtn.addEventListener("click", function () {
      // Hide bank details, show connection form
      const connectionForm = document.getElementById("connection-form");
      const bankDetails = document.getElementById("bank-details");

      if (connectionForm) {
        connectionForm.style.display = "block";
      }

      if (bankDetails) {
        bankDetails.style.display = "none";
      }

      // Show notification
      showNotification("Bank account disconnected", "info");
    });
  }

  // Function to validate the entire form
  function validateForm() {
    const isBankValid = bankSelect && bankSelect.value !== "";
    const isUsernameValid =
      username && username.value.trim() !== "" && username.value.length >= 3;
    const isPasswordValid =
      password && password.value !== "" && password.value.length >= 6;

    const connectBtn = bankForm.querySelector(".connect-btn");
    if (connectBtn) {
      connectBtn.disabled = !(
        isBankValid &&
        isUsernameValid &&
        isPasswordValid
      );
    }

    return isBankValid && isUsernameValid && isPasswordValid;
  }

  // Initially validate form
  validateForm();
}

// Function to initialize password toggle
function initPasswordToggle() {
  const togglePasswordBtn = document.querySelector(".toggle-password");
  if (togglePasswordBtn) {
    togglePasswordBtn.addEventListener("click", function () {
      const passwordInput = document.getElementById("password");
      if (passwordInput) {
        // Toggle password visibility
        const type =
          passwordInput.getAttribute("type") === "password"
            ? "text"
            : "password";
        passwordInput.setAttribute("type", type);

        // Toggle eye icon
        const icon = this.querySelector("i");
        if (icon) {
          if (type === "password") {
            icon.setAttribute("data-feather", "eye");
          } else {
            icon.setAttribute("data-feather", "eye-off");
          }
          feather.replace();
        }
      }
    });
  }
}

// Function to populate sample data for demonstration
function populateSampleData() {
  // Sample transactions
  const transactionTable = document.getElementById("transaction-table");
  if (transactionTable) {
    transactionTable.innerHTML = `
            <tr>
                <td>May 1, 2025</td>
                <td>Grocery Store</td>
                <td>-$85.42</td>
                <td>Debit</td>
            </tr>
            <tr>
                <td>Apr 30, 2025</td>
                <td>Salary Deposit</td>
                <td>+$2,500.00</td>
                <td>Credit</td>
            </tr>
            <tr>
                <td>Apr 29, 2025</td>
                <td>Restaurant</td>
                <td>-$45.80</td>
                <td>Debit</td>
            </tr>
            <tr>
                <td>Apr 28, 2025</td>
                <td>Gas Station</td>
                <td>-$32.15</td>
                <td>Debit</td>
            </tr>
            <tr>
                <td>Apr 25, 2025</td>
                <td>Online Shopping</td>
                <td>-$129.99</td>
                <td>Debit</td>
            </tr>
        `;
  }

  // Sample deposits
  const depositsList = document.getElementById("deposits-list");
  if (depositsList) {
    depositsList.innerHTML = `
            <li>Apr 30, 2025 - Salary Deposit - $2,500.00</li>
            <li>Apr 15, 2025 - Tax Refund - $750.00</li>
            <li>Apr 1, 2025 - Savings Transfer - $200.00</li>
        `;
  }

  // Sample payments
  const paymentsList = document.getElementById("payments-list");
  if (paymentsList) {
    paymentsList.innerHTML = `
            <li>Apr 29, 2025 - Electricity Bill - $75.32</li>
            <li>Apr 27, 2025 - Internet Service - $59.99</li>
            <li>Apr 25, 2025 - Rent Payment - $1,200.00</li>
        `;
  }

  // Sample statements
  const statementsList = document.getElementById("statements-list");
  if (statementsList) {
    statementsList.innerHTML = `
            <li>April 2025 Statement - <a href="#">Download PDF</a></li>
            <li>March 2025 Statement - <a href="#">Download PDF</a></li>
            <li>February 2025 Statement - <a href="#">Download PDF</a></li>
        `;
  }
}

// Function to show notifications
function showNotification(message, type = "info") {
  const container = document.getElementById("notification-container");
  if (!container) return;

  // Create notification element
  const notification = document.createElement("div");
  notification.className = `notification ${type}`;

  // Get appropriate icon based on type
  let iconName = "info";
  if (type === "success") iconName = "check-circle";
  if (type === "error") iconName = "alert-circle";
  if (type === "warning") iconName = "alert-triangle";

  // Set notification content
  notification.innerHTML = `
        <i data-feather="${iconName}"></i>
        <div class="notification-content">${message}</div>
    `;

  // Add to container
  container.appendChild(notification);

  // Initialize the icon
  feather.replace();

  // Auto-remove after 5 seconds
  setTimeout(() => {
    notification.style.opacity = "0";
    notification.style.transform = "translateY(10px)";
    setTimeout(() => {
      notification.remove();
    }, 300);
  }, 5000);
}
