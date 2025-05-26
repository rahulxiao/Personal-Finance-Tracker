<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FinanceFlow - Admin Panel</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@300;400;600;700&family=Roboto+Mono&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
  <link rel="stylesheet" href="../assets/css/admin.css" />
  <link rel="stylesheet" href="../assets/css/feature.css" />
  <style>

  </style>
</head>

<body>
  <div class="app-container">
    <nav class="sidebar" id="sidebar">
      <div class="sidebar-header">
        <h1>FinanceFlow</h1>
        <button id="sidebar-toggle" class="sidebar-toggle mobile-only">
          <i data-feather="menu"></i>
        </button>
      </div>
      <ul class="sidebar-menu">
        <li data-page="dashboard">
          <a href="#########"><i data-feather="home"></i> Dashboard</a>
        </li>
        <li class="active" data-page="users">
          <a href="#users"><i data-feather="users"></i> User Management</a>
        </li>
        <li data-page="content">
          <a href="#content"><i data-feather="edit"></i> Content Moderation</a>
        </li>
        <li data-page="logout">
          <a href="../controller/logout.php">
            <i data-feather="log-out"></i> Log Out
          </a>
        </li>
      </ul>
    </nav>

    <main class="main-content">
      <div class="page-header">
        <h1 id="page-title">User Management</h1>
        <div class="date-display" id="current-date"></div>
      </div>

      <section id="users-section" class="admin-section">
        <div class="admin-toolbar">
          <div class="search-box">
            <input type="text" placeholder="Search users..." id="user-search">
            <button class="btn btn-secondary" id="search-btn">
              <i data-feather="search"></i> Search
            </button>
          </div>


          <div class="action-buttons">
            <button class="btn btn-primar" id="add-user-btn">
              <i data-feather="plus"></i> Add User
            </button>
            <button class="btn btn-secondary" id="bulk-actions-btn">
              <i data-feather="layers"></i> Bulk Actions
            </button>
          </div>
        </div>

        <div class="filter-bar">
          <div class="filter-group">
            <label for="role-filter">Role:</label>
            <select id="role-filter" class="form-select">
              <option value="all">All Roles</option>
              <option value="admin">Administrator</option>
              <option value="moderator">Moderator</option>
              <option value="user">Regular User</option>
            </select>
          </div>
          <div class="filter-group">
            <label for="status-filter">Status:</label>
            <select id="status-filter" class="form-select">
              <option value="all">All Statuses</option>
              <option value="active">Active</option>
              <option value="suspended">Suspended</option>
              <option value="pending">Pending</option>
            </select>
          </div>
          <button class="btn btn-icon" id="export-users">
            <i data-feather="download"></i>
          </button>
        </div>

        <div class="admin-table-container">
          <table class="admin-table" id="users-table">
            <thead>
              <tr>
                <th><input type="checkbox" id="select-all-users"></th>
                <th data-sort="first_name">First Name <i data-feather="chevron-down" class="sort-icon"></i></th>
                <th data-sort="last_name">Last Name <i data-feather="chevron-down" class="sort-icon"></i></th>
                <th data-sort="email">Email <i data-feather="chevron-down" class="sort-icon"></i></th>
                <th data-sort="role">Role <i data-feather="chevron-down" class="sort-icon"></i></th>
                <th data-sort="username">Username <i data-feather="chevron-down" class="sort-icon"></i></th>
                <th data-sort="password">Password <i data-feather="chevron-down" class="sort-icon"></i></th>
                <th data-sort="status">Status <i data-feather="chevron-down" class="sort-icon"></i></th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="users-table-body">
            </tbody>
          </table>
        </div>

        <div class="pagination-controls">
          <div class="pagination-info">Showing 1-10 of 124 users</div>
          <div class="pagination-buttons">
            <button class="btn-icon" disabled><i data-feather="chevron-left"></i></button>
            <button class="btn-page active">1</button>
            <button class="btn-page">2</button>
            <button class="btn-page">3</button>
            <span>...</span>
            <button class="btn-page">13</button>
            <button class="btn-icon"><i data-feather="chevron-right"></i></button>
          </div>
        </div>
      </section>

      <section id="content-section" class="admin-section" style="display:none;">
      </section>
    </main>
  </div>

  <div class="modal" id="add-user-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Add New User</h3>
        <button class="modal-close"><i data-feather="x"></i></button>
      </div>
      <div class="modal-body">
        <form action="../controller/add-user.php" method="post" id="add-user-form">
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
          <div class="form-group">
            <label for="first-name">First Name</label>
            <input type="text" name="firstname" id="first-name" class="form-control" placeholder="Enter first name" required>
          </div>
          <div class="form-group">
            <label for="last-name">Last Name</label>
            <input type="text" name="lastname" id="last-name" class="form-control" placeholder="Enter last name" required>
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" id="cancel-add-user">Cancel</button>
            <button class="btn btn-primary" name="submit" type="submit" form="add-user-form">Save User</button>
          </div>
        </form>
      </div>

    </div>
  </div>

  <div id="notification-container" class="notification-container"></div>
  <script src="../assets/js/admin.js"></script>
  <script>
    feather.replace();

    // Set current date
    document.getElementById('current-date').textContent = new Date().toLocaleDateString('en-US', {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    });

    // Modal toggle functionality
    const addUserBtn = document.getElementById('add-user-btn');
    const addUserModal = document.getElementById('add-user-modal');
    const cancelAddUser = document.getElementById('cancel-add-user');
    const modalClose = addUserModal.querySelector('.modal-close');

    addUserBtn.addEventListener('click', () => {
      addUserModal.classList.add('active');
    });

    cancelAddUser.addEventListener('click', (e) => {
      e.preventDefault(); // Prevent default button behavior
      addUserModal.classList.remove('active');
    });

    modalClose.addEventListener('click', () => {
      addUserModal.classList.remove('active');
    });

    // Example from previous response, ensure this is in your admin.php's script tag
    document.getElementById('add-user-form').addEventListener('submit', (e) => {
      e.preventDefault(); // Prevent default form submission

      const form = e.target;
      const formData = new FormData(form); // Collect form data

      // Convert FormData to a plain object for JSON serialization
      const userData = {};
      for (let [key, value] of formData.entries()) {
        userData[key] = value;
      }

      fetch('../controller/add-user.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json' // Crucial: tell PHP to expect JSON
          },
          body: JSON.stringify(userData) // Send data as JSON string
        })
        .then(response => response.json()) // Parse the JSON response
        .then(data => {
          if (data.success) {
            alert(data.message);
            form.reset();
            addUserModal.classList.remove('active');
            fetchAndDisplayUsers(); // Refresh user list
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error adding user:', error);
          alert('An error occurred while trying to add the user. Please try again.');
        });
    });

    // --- JAVASCRIPT FOR LOADING AND INTERACTIVE SEARCH DATA ---
    document.addEventListener('DOMContentLoaded', function() {
      const usersTableBody = document.getElementById('users-table-body');
      const userSearchInput = document.getElementById('user-search');
      const searchButton = document.getElementById('search-btn');

      function fetchAndDisplayUsers(searchTerm = '') {
        let url = '../controller/fetch_users.php'; // Path to your fetch_users.php
        if (searchTerm) {
          url += `?query=${encodeURIComponent(searchTerm)}`; // Add search term as GET parameter
        }

        fetch(url)
          .then(response => {
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json(); // Parse the JSON response
          })
          .then(users => {
            usersTableBody.innerHTML = ''; // Clear existing rows
            if (users.length === 0) {
              const noResultsRow = usersTableBody.insertRow();
              noResultsRow.innerHTML = `<td colspan="9" style="text-align: center; padding: 20px; color: #b0b0b0;">No users found matching your search.</td>`;
            } else {
              users.forEach(user => {
                const row = usersTableBody.insertRow();
                // Ensure consistent data structure from PHP, add defaults if missing
                const role = user.role || 'Regular User';
                const status = user.status || 'Active';
                const passwordDisplay = '********'; // Never display actual passwords

                row.innerHTML = `
                                    <td><input type="checkbox" class="user-checkbox"></td>
                                    <td>${user.u_fname}</td>
                                    <td>${user.u_lname}</td>
                                    <td>${user.u_email}</td>
                                    <td><span class="badge badge-${role.toLowerCase().replace(' ', '-')}">${role}</span></td>
                                    <td>${user.u_username}</td>
                                    <td>${passwordDisplay}</td>
                                    <td><span class="badge badge-${status.toLowerCase()}">${status}</span></td>
                                    <td class="action-cell">
                                        <button class="btn-icon btn-edit"><i data-feather="edit-2"></i></button>
                                        <button class="btn-icon btn-delete"><i data-feather="trash-2"></i></button>
                                    </td>
                                `;
              });
            }
            feather.replace(); // Re-render feather icons after adding new elements
          })
          .catch(error => console.error('Error fetching users:', error));
      }

      // Initial load of users when the page loads
      fetchAndDisplayUsers();

      // Event listener for the search button click
      searchButton.addEventListener('click', () => {
        const searchTerm = userSearchInput.value.trim();
        fetchAndDisplayUsers(searchTerm);
      });

      // Optional: Event listener for real-time search as user types
      userSearchInput.addEventListener('keyup', (event) => {
        // You can add a debounce here for performance on large datasets
        const searchTerm = userSearchInput.value.trim();
        fetchAndDisplayUsers(searchTerm);
      });
    });
  </script>
</body>

</html>