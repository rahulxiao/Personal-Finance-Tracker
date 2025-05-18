    const emailInput = document.getElementById("email");
    const emailError = document.getElementById("email-error");
    const sendBtn = document.getElementById("send-verification");
    const verifyBox = document.getElementById("verification-box");
    const verifyBtn = document.getElementById("verify-code");
    const messageBox = document.getElementById("message");
    const countdownSpan = document.getElementById("countdown");
    const resendBtn = document.getElementById("resend-code");
    const codeInputs = document.querySelectorAll(".code-digit");

    let generatedCode = "123456"; // Demo only
    let timer;
    let timeLeft = 300; // 5 minutes in seconds

    function isValidEmail(email) {
        return email.includes("@") && email.includes(".");
    }

    function startTimer() {
        clearInterval(timer);
        timeLeft = 300;
        updateTimerDisplay();

        timer = setInterval(() => {
            timeLeft--;
            updateTimerDisplay();

            if (timeLeft <= 0) {
                clearInterval(timer);
                countdownSpan.textContent = "00:00";
                messageBox.textContent = "❌ Code expired. Please resend.";
            }
        }, 1000);
    }

    function updateTimerDisplay() {
        const minutes = String(Math.floor(timeLeft / 60)).padStart(2, '0');
        const seconds = String(timeLeft % 60).padStart(2, '0');
        countdownSpan.textContent = `${minutes}:${seconds}`;
    }

    function clearCodeInputs() {
        codeInputs.forEach(input => input.value = "");
        codeInputs[0].focus();
    }

    function handleVerificationSend() {
        const email = emailInput.value.trim();
        if (!isValidEmail(email)) {
            emailError.textContent = "Enter a valid email address.";
            return;
        }

        emailError.textContent = "";
        verifyBox.style.display = "block";
        messageBox.textContent = "🔐 Demo only: Use verification code 123456";
        clearCodeInputs();
        startTimer();
    }

    // Auto-focus and move to next input
    codeInputs.forEach((input, index) => {
        input.addEventListener("input", () => {
            if (input.value && index < codeInputs.length - 1) {
                codeInputs[index + 1].focus();
            }
        });

        input.addEventListener("keydown", (e) => {
            if (e.key === "Backspace" && !input.value && index > 0) {
                codeInputs[index - 1].focus();
            }
        });
    });

    // Verification button click
    verifyBtn.addEventListener("click", () => {
        if (timeLeft <= 0) {
            messageBox.textContent = "❌ Code expired. Please resend.";
            return;
        }

        const enteredCode = Array.from(codeInputs).map(input => input.value.trim()).join("");

        if (enteredCode.length !== 6) {
            messageBox.textContent = "⚠️ Enter all 6 digits.";
            return;
        }

        if (enteredCode === generatedCode) {
            clearInterval(timer);
            messageBox.textContent = "✅ Email verified successfully!";
            setTimeout(() => {
                window.location.href = "../pages/features.html";
            }, 1500);
        } else {
            messageBox.textContent = "❌ Incorrect verification code.";
        }
    });

    // Resend code
    resendBtn.addEventListener("click", () => {
        handleVerificationSend();
    });

    // First send code button
    sendBtn.addEventListener("click", () => {
        handleVerificationSend();
    });
