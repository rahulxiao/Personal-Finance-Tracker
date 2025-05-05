document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("budget-goal-modal");
    const openBtn = document.querySelector(".add-budget-btn");
    const closeBtn = document.querySelector(".close-modal");
  
    openBtn.addEventListener("click", () => {
      modal.style.display = "flex";
    });
  
    closeBtn.addEventListener("click", () => {
      modal.style.display = "none";
    });
  
    window.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.style.display = "none";
      }
    });
  
    // Form elements
    const goalInput = document.getElementById("goal-name");
    const goalError = document.getElementById("goal-name-error");
  
    const targetAmountInput = document.getElementById("target-amount");
    const targetAmountError = document.getElementById("amount-error");
  
    const currentAmountInput = document.getElementById("current-amount");
    const currentAmountError = document.getElementById("current-amount-error");
  
    const targetDateInput = document.getElementById("target-date");
    const targetDateError = document.getElementById("date-error");
  
    // Goal Name Validation
    goalInput.addEventListener("input", () => {
      const value = goalInput.value.trim();
      if (value.length < 3) {
        goalError.textContent = "Goal name must be at least 3 characters long.";
        goalInput.classList.add("error");
      } else if (value.length > 20) {
        goalError.textContent = "Goal name must be less than 20 characters.";
        goalInput.classList.add("error");
      } else {
        goalError.textContent = "";
        goalInput.classList.remove("error");
      }
    });
  
    // Target Amount Validation
    targetAmountInput.addEventListener("input", () => {
      const value = parseFloat(targetAmountInput.value.trim());
      if (isNaN(value)) {
        targetAmountError.textContent = "Target amount is required.";
        targetAmountInput.classList.add("error");
      } else if (value <= 0) {
        targetAmountError.textContent = "Target amount must be greater than 0.";
        targetAmountInput.classList.add("error");
      } else {
        targetAmountError.textContent = "";
        targetAmountInput.classList.remove("error");
      }
    });
  
    // Current Amount Validation
    currentAmountInput.addEventListener("input", () => {
      const value = parseFloat(currentAmountInput.value.trim());
      if (isNaN(value)) {
        currentAmountError.textContent = "Current amount is required.";
        currentAmountInput.classList.add("error");
      } else if (value < 0) {
        currentAmountError.textContent = "Current amount must be a positive number.";
        currentAmountInput.classList.add("error");
      } else {
        currentAmountError.textContent = "";
        currentAmountInput.classList.remove("error");
      }
    });
  
    // Target Date Validation
    targetDateInput.addEventListener("input", () => {
      const value = targetDateInput.value;
      const selectedDate = new Date(value);
      const today = new Date();
      today.setHours(0, 0, 0, 0); // ignore time
  
      if (!value) {
        targetDateError.textContent = "Target date is required.";
        targetDateInput.classList.add("error");
      } else if (selectedDate <= today) {
        targetDateError.textContent = "Target date must be in the future.";
        targetDateInput.classList.add("error");
      } else {
        targetDateError.textContent = "";
        targetDateInput.classList.remove("error");
      }
    });
  });
  