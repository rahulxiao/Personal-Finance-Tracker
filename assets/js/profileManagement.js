document.addEventListener('DOMContentLoaded', function() {
    // Initialize Feather Icons
    if (window.feather) feather.replace();

    // Set current date
    const currentDateElement = document.getElementById("current-date");
    if (currentDateElement) {
        const now = new Date();
        const options = { year: "numeric", month: "long", day: "numeric" };
        currentDateElement.textContent = now.toLocaleDateString("en-US", options);
    }

    // Global variables for tracking totals
    window.totalIncome = 0;
    window.recurringTotalIncome = 0;
    window.sideHustleTotalIncome = 0;

    // Profile form handling
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Get form data
            const formData = new FormData(profileForm);
            const profileData = {};
            formData.forEach((value, key) => {
                profileData[key] = value;
            });

            // Store in localStorage
            localStorage.setItem('userProfile', JSON.stringify(profileData));

            // Show success message
            alert('Profile updated successfully!');
        });
    }

    // Load saved profile data
    function loadProfileData() {
        const savedProfile = localStorage.getItem('userProfile');
        if (savedProfile) {
            const profileData = JSON.parse(savedProfile);
            
            // Fill form fields
            Object.keys(profileData).forEach(key => {
                const input = document.getElementById(key);
                if (input) {
                    input.value = profileData[key];
                }
            });
        }
    }

    // Initialize profile data
    loadProfileData();

    // Avatar change handling
    const changeAvatarBtn = document.querySelector('.change-avatar-btn');
    const avatarInput = document.getElementById('avatarInput');
    
    if (changeAvatarBtn && avatarInput) {
        changeAvatarBtn.addEventListener('click', () => {
            avatarInput.click();
        });

        avatarInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const avatarImg = document.querySelector('.profile-avatar img');
                    if (avatarImg) {
                        avatarImg.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // View Profile Modal
    const viewProfileBtn = document.querySelector('.view-profile-btn');
    const profileModal = document.getElementById('profileModal');
    const closeModal = document.querySelector('.close-modal');

    if (viewProfileBtn && profileModal) {
        viewProfileBtn.addEventListener('click', () => {
            const savedProfile = localStorage.getItem('userProfile');
            if (savedProfile) {
                const profileData = JSON.parse(savedProfile);
                
                // Update modal content
                document.getElementById('modalName').textContent = `${profileData.firstName} ${profileData.lastName}`;
                document.getElementById('modalEmail').textContent = profileData.email;
                document.getElementById('modalPhone').textContent = profileData.phone;
                document.getElementById('modalCurrency').textContent = profileData.currency;
                document.getElementById('modalLanguage').textContent = profileData.language;
                document.getElementById('modalTimezone').textContent = profileData.timezone;
            }
            
            profileModal.style.display = 'flex';
        });
    }

    if (closeModal) {
        closeModal.addEventListener('click', () => {
            profileModal.style.display = 'none';
        });
    }

    // Close modal when clicking outside
    window.addEventListener('click', (event) => {
        if (event.target === profileModal) {
            profileModal.style.display = 'none';
        }
    });
}); 