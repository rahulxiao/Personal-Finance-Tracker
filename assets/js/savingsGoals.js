document.addEventListener('DOMContentLoaded', function() {
    // Initialize Feather Icons
    if (window.feather) feather.replace();

    // Global variables
    let goals = [];

    // create error message element
    function createErrorMessage(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.style.color = 'var(--error-color)';
        errorDiv.style.fontSize = '0.8rem';
        errorDiv.style.marginTop = '4px';
        errorDiv.textContent = message;
        return errorDiv;
    }

    //show error message
    function showError(inputElement, message) {
        // Remove any existing error message
        const existingError = inputElement.parentElement.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        
        //new error message
        const errorDiv = createErrorMessage(message);
        inputElement.parentElement.appendChild(errorDiv);
        
        //error styling
        inputElement.style.borderColor = 'var(--error-color)';
    }

    // clear error message
    function clearError(inputElement) {
        const errorDiv = inputElement.parentElement.querySelector('.error-message');
        if (errorDiv) {
            errorDiv.remove();
        }
        inputElement.style.borderColor = 'var(--border-color)';
    }

    // minimum date to today
    const targetDateInput = document.getElementById('targetDate');
    if (targetDateInput) {
        const today = new Date().toISOString().split('T')[0];
        targetDateInput.min = today;

        //target date
        targetDateInput.addEventListener('input', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Reset time to start of day

            if (selectedDate < today) {
                showError(this, 'Target date cannot be in the past');
            } else {
                clearError(this);
            }
        });
    }

    // target amount and current amount error handling for invalid amounts
    const targetAmountInput = document.getElementById('targetAmount');
    const currentAmountInput = document.getElementById('currentAmount');
    const monthlyContributionInput = document.getElementById('monthlyContribution');

    if (targetAmountInput && currentAmountInput) {
        targetAmountInput.addEventListener('input', function() {
            const targetAmount = parseFloat(this.value) || 0;
            const currentAmount = parseFloat(currentAmountInput.value) || 0;
            const monthlyContribution = parseFloat(monthlyContributionInput.value) || 0;

            if (currentAmount > targetAmount) {
                showError(currentAmountInput, 'Current amount cannot be higher than target amount');
            } else {
                clearError(currentAmountInput);
            }

            if (monthlyContribution > targetAmount) {
                showError(monthlyContributionInput, 'Monthly contribution cannot be higher than target amount');
            } else {
                clearError(monthlyContributionInput);
            }
        });

        currentAmountInput.addEventListener('input', function() {
            const targetAmount = parseFloat(targetAmountInput.value) || 0;
            const currentAmount = parseFloat(this.value) || 0;
            const monthlyContribution = parseFloat(monthlyContributionInput.value) || 0;

            if (currentAmount > targetAmount) {
                showError(this, 'Current amount cannot be higher than target amount');
            } else {
                clearError(this);
            }

            if (monthlyContribution > currentAmount) {
                showError(monthlyContributionInput, 'Monthly contribution cannot be higher than current amount');
            } else {
                clearError(monthlyContributionInput);
            }
        });

        monthlyContributionInput.addEventListener('input', function() {
            const targetAmount = parseFloat(targetAmountInput.value) || 0;
            const currentAmount = parseFloat(currentAmountInput.value) || 0;
            const monthlyContribution = parseFloat(this.value) || 0;

            if (monthlyContribution > targetAmount) {
                showError(this, 'Monthly contribution cannot be higher than target amount');
            } else if (monthlyContribution > currentAmount) {
                showError(this, 'Monthly contribution cannot be higher than current amount');
            } else {
                clearError(this);
            }
        });
    }

    // loading goals from localStorage
    function loadGoals() {
        const savedGoals = localStorage.getItem('savingsGoals');
        if (savedGoals) {
            goals = JSON.parse(savedGoals);
            updateGoalsGrid();
            updateStats();
            updateMilestones();
        }
    }

    // saving goals to localStorage
    function saveGoals() {
        localStorage.setItem('savingsGoals', JSON.stringify(goals));
    }

    // updating goals grid
    function updateGoalsGrid() {
        const goalsGrid = document.getElementById('goalsGrid');
        if (!goalsGrid) return;

        goalsGrid.innerHTML = '';

        goals.forEach(goal => {
            const progress = (goal.currentAmount / goal.targetAmount) * 100;
            const remainingAmount = goal.targetAmount - goal.currentAmount;
            const monthsRemaining = calculateMonthsRemaining(goal.targetDate);

            const goalCard = document.createElement('div');
            goalCard.className = 'goal-card';
            goalCard.innerHTML = `
                <div class="goal-header">
                    <h3 class="goal-title">${goal.name}</h3>
                    <span class="goal-category">${goal.category}</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: ${progress}%"></div>
                </div>
                <div class="goal-details">
                    <div class="goal-detail">
                        <span>Current:</span> $${goal.currentAmount.toFixed(2)}
                    </div>
                    <div class="goal-detail">
                        <span>Target:</span> $${goal.targetAmount.toFixed(2)}
                    </div>
                    <div class="goal-detail">
                        <span>Remaining:</span> $${remainingAmount.toFixed(2)}
                    </div>
                    <div class="goal-detail">
                        <span>Months Left:</span> ${monthsRemaining}
                    </div>
                </div>
                <div class="goal-actions">
                    <button class="action-btn delete-btn" onclick="deleteGoal(${goal.id})">
                        <i data-feather="trash-2"></i>
                    </button>
                </div>
            `;

            goalsGrid.appendChild(goalCard);
        });

        // Reinitialize Feather icons
        if (window.feather) feather.replace();
    }

    // updating stats
    function updateStats() {
        const totalGoals = document.getElementById('totalGoals');
        const totalSaved = document.getElementById('totalSaved');
        const completedGoals = document.getElementById('completedGoals');

        if (totalGoals) {
            totalGoals.textContent = goals.length;
        }

        if (totalSaved) {
            const total = goals.reduce((sum, goal) => sum + goal.currentAmount, 0);
            totalSaved.textContent = `$${total.toFixed(2)}`;
        }

        if (completedGoals) {
            const completed = goals.filter(goal => goal.currentAmount >= goal.targetAmount).length;
            completedGoals.textContent = completed;
        }
    }

    // updating milestones
    function updateMilestones() {
        const milestonesContainer = document.getElementById('milestonesContainer');
        if (!milestonesContainer) return;

        milestonesContainer.innerHTML = '';

        // sorting goals by progress
        const sortedGoals = [...goals].sort((a, b) => {
            const progressA = a.currentAmount / a.targetAmount;
            const progressB = b.currentAmount / b.targetAmount;
            return progressB - progressA;
        });

        sortedGoals.forEach(goal => {
            const progress = (goal.currentAmount / goal.targetAmount) * 100;
            const milestoneCard = document.createElement('div');
            milestoneCard.className = 'milestone-card';
            milestoneCard.innerHTML = `
                <div class="milestone-icon">
                    <i data-feather="${progress >= 100 ? 'award' : 'target'}"></i>
                </div>
                <div class="milestone-info">
                    <div class="milestone-title">${goal.name}</div>
                    <div class="milestone-date">${progress.toFixed(1)}% Complete</div>
                </div>
            `;

            milestonesContainer.appendChild(milestoneCard);
        });

        // Reinitialize Feather icons
        if (window.feather) feather.replace();
    }

    // calculating months remaining
    function calculateMonthsRemaining(targetDate) {
        const today = new Date();
        const target = new Date(targetDate);
        const months = (target.getFullYear() - today.getFullYear()) * 12 + 
                      (target.getMonth() - today.getMonth());
        return Math.max(0, months);
    }

    // showing add goal modal
    window.showAddGoalModal = function() {
        const modal = document.getElementById('addGoalModal');
        if (modal) {
            modal.style.display = 'flex';
        }
    };

    // Hide add goal modal 
    window.hideAddGoalModal = function() {
        const modal = document.getElementById('addGoalModal');
        if (modal) {
            modal.style.display = 'none';
        }
    };

    // showing celebration modal
    function showCelebrationModal(goal) {
        const modal = document.getElementById('celebrationModal');
        const message = document.getElementById('celebrationMessage');
        if (modal && message) {
            message.textContent = `Congratulations! You've reached your goal of saving $${goal.targetAmount.toFixed(2)} for ${goal.name}!`;
            modal.style.display = 'flex';
        }
    }

    // hiding celebration modal
    window.hideCelebrationModal = function() {
        const modal = document.getElementById('celebrationModal');
        if (modal) {
            modal.style.display = 'none';
        }
    };

    // adding new goal
    const addGoalForm = document.getElementById('addGoalForm');
    if (addGoalForm) {
        addGoalForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const targetAmount = parseFloat(document.getElementById('targetAmount').value);
            const currentAmount = parseFloat(document.getElementById('currentAmount').value);
            const monthlyContribution = parseFloat(document.getElementById('monthlyContribution').value);
            const targetDate = new Date(document.getElementById('targetDate').value);
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Reset time

            if (targetDate < today) {
                showError(targetDateInput, 'Target date cannot be in the past');
                return;
            }

            // Validate current amount against target amount
            if (currentAmount > targetAmount) {
                showError(currentAmountInput, 'Current amount cannot be higher than target amount to set a goal');
                return;
            }

            // Validate monthly contribution
            if (monthlyContribution > targetAmount) {
                showError(monthlyContributionInput, 'Monthly contribution cannot be higher than target amount');
                return;
            }
            if (monthlyContribution > currentAmount) {
                showError(monthlyContributionInput, 'Monthly contribution cannot be higher than current amount');
                return;
            }

            const newGoal = {
                id: Date.now(),
                name: document.getElementById('goalName').value,
                targetAmount: targetAmount,
                currentAmount: currentAmount,
                targetDate: document.getElementById('targetDate').value,
                category: document.getElementById('category').value,
                monthlyContribution: monthlyContribution
            };

            goals.push(newGoal);
            saveGoals();
            updateGoalsGrid();
            updateStats();
            updateMilestones();

            // Check if goal is already achieved
            if (newGoal.currentAmount >= newGoal.targetAmount) {
                showCelebrationModal(newGoal);
            }

            // Reset form and hide modal
            addGoalForm.reset();
            hideAddGoalModal();
        });
    }

    // deleting goal
    window.deleteGoal = function(goalId) {
        if (confirm('Are you sure you want to delete this goal?')) {
            goals = goals.filter(g => g.id !== goalId);
            saveGoals();
            updateGoalsGrid();
            updateStats();
            updateMilestones();
        }
    };

    // initializing everything
    loadGoals();
});
