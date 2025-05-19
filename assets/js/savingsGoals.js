document.addEventListener('DOMContentLoaded', function() {
    // Initialize Feather Icons
    if (window.feather) feather.replace();

    // Global variables
    let goals = [];

    // Load goals from localStorage
    function loadGoals() {
        const savedGoals = localStorage.getItem('savingsGoals');
        if (savedGoals) {
            goals = JSON.parse(savedGoals);
            updateGoalsGrid();
            updateStats();
            updateMilestones();
        }
    }

    // Save goals to localStorage
    function saveGoals() {
        localStorage.setItem('savingsGoals', JSON.stringify(goals));
    }

    // Update goals grid
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

    // Update stats
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

    // Update milestones
    function updateMilestones() {
        const milestonesContainer = document.getElementById('milestonesContainer');
        if (!milestonesContainer) return;

        milestonesContainer.innerHTML = '';

        // Sort goals by progress
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

    // Calculate months remaining
    function calculateMonthsRemaining(targetDate) {
        const today = new Date();
        const target = new Date(targetDate);
        const months = (target.getFullYear() - today.getFullYear()) * 12 + 
                      (target.getMonth() - today.getMonth());
        return Math.max(0, months);
    }

    // Show add goal modal
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

    // Show celebration modal
    function showCelebrationModal(goal) {
        const modal = document.getElementById('celebrationModal');
        const message = document.getElementById('celebrationMessage');
        if (modal && message) {
            message.textContent = `Congratulations! You've reached your goal of saving $${goal.targetAmount.toFixed(2)} for ${goal.name}!`;
            modal.style.display = 'flex';
        }
    }

    // Hide celebration modal
    window.hideCelebrationModal = function() {
        const modal = document.getElementById('celebrationModal');
        if (modal) {
            modal.style.display = 'none';
        }
    };

    // Add new goal
    const addGoalForm = document.getElementById('addGoalForm');
    if (addGoalForm) {
        addGoalForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const newGoal = {
                id: Date.now(),
                name: document.getElementById('goalName').value,
                targetAmount: parseFloat(document.getElementById('targetAmount').value),
                currentAmount: parseFloat(document.getElementById('currentAmount').value),
                targetDate: document.getElementById('targetDate').value,
                category: document.getElementById('category').value,
                monthlyContribution: parseFloat(document.getElementById('monthlyContribution').value)
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

    // Delete goal
    window.deleteGoal = function(goalId) {
        if (confirm('Are you sure you want to delete this goal?')) {
            goals = goals.filter(g => g.id !== goalId);
            saveGoals();
            updateGoalsGrid();
            updateStats();
            updateMilestones();
        }
    };

    // Initialize everything
    loadGoals();
});
