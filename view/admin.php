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

      <div class="modal" id="edit-user-modal">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Edit User Details</h3>
        <button class="modal-close" id="close-edit-user-modal"><i data-feather="x"></i></button>
      </div>
      <div class="modal-body">
        <form action="../controller/update_user.php" method="post" id="edit-user-form">
          
          <input type="hidden" name="user_id" id="edit-user-id"> <div class="form-group">
            <label for="edit-first-name">First Name</label>
            <input type="text" name="firstname" id="edit-first-name" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="edit-last-name">Last Name</label>
            <input type="text" name="lastname" id="edit-last-name" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="edit-username">Username</label>
            <input type="text" name="username" id="edit-username" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="edit-email">Email</label>
            <input type="email" name="email" id="edit-email" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="edit-password">New Password (leave blank to keep current)</label>
            <input type="password" name="password" id="edit-password" class="form-control" placeholder="Enter new password (optional)">
          </div>
          <div class="form-group">
            <label for="edit-role-filter">Role:</label>
            <select name="role" id="edit-role-filter" class="form-select">
              <option value="user">Regular User</option>
              <option value="moderator">Moderator</option>
              <option value="admin">Administrator</option>
            </select>
          </div>
          <div class="form-group">
            <label for="edit-status-filter">Status:</label>
            <select name="status" id="edit-status-filter" class="form-select">
              <option value="active">Active</option>
              <option value="suspended">Suspended</option>
              <option value="pending">Pending</option>
            </select>
          </div>
          
          <div class="modal-footer">
            <button class="btn btn-secondary" id="cancel-edit-user">Cancel</button>
            <button class="btn btn-primary" type="submit" form="edit-user-form">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
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

    // Modal toggle functionality (Add User)
    const addUserBtn = document.getElementById('add-user-btn');
    const addUserModal = document.getElementById('add-user-modal');
    const cancelAddUser = document.getElementById('cancel-add-user');
    const modalCloseAdd = addUserModal.querySelector('.modal-close');

    addUserBtn.addEventListener('click', () => {
      addUserModal.classList.add('active');
    });

    cancelAddUser.addEventListener('click', (e) => {
      e.preventDefault(); // Prevent default button behavior
      addUserModal.classList.remove('active');
    });

    modalCloseAdd.addEventListener('click', () => {
      addUserModal.classList.remove('active');
    });

    // Add User Form Submission via AJAX (using XMLHttpRequest)
    document.getElementById('add-user-form').addEventListener('submit', (e) => {
      e.preventDefault(); // Prevent default form submission

      const form = e.target;
      const formData = new FormData(form);
      
      // Convert FormData to URL-encoded string
      let params = new URLSearchParams(formData).toString();

      let xhttp = new XMLHttpRequest();
      xhttp.open('POST', '../controller/add-user.php', true);
      xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded'); // Set content type for POST data
      xhttp.send(params);

      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          try {
            let data = JSON.parse(this.responseText);
            if (data.success) {
              alert(data.message);
              form.reset();
              addUserModal.classList.remove('active');
              fetchAndDisplayUsers(); // Refresh user list
            } else {
              alert('Error: ' + data.message);
            }
          } catch (error) {
            console.error('JSON parsing error:', error);
            alert('An unexpected response was received from the server.');
          }
        } else if (this.readyState == 4) {
          alert('Server error: ' + this.status);
          console.error('XHR request failed:', this.status, this.responseText);
        }
      };
    });


    // --- JAVASCRIPT FOR LOADING, INTERACTIVE SEARCH, EDIT AND DELETE DATA ---
    document.addEventListener('DOMContentLoaded', function() {
      const usersTableBody = document.getElementById('users-table-body');
      const userSearchInput = document.getElementById('user-search');
      const searchButton = document.getElementById('search-btn');

      // Edit User Modal Elements
      const editUserModal = document.getElementById('edit-user-modal');
      const closeEditUserModal = document.getElementById('close-edit-user-modal');
      const cancelEditUserBtn = document.getElementById('cancel-edit-user');
      const editUserForm = document.getElementById('edit-user-form');
      const editUserId = document.getElementById('edit-user-id');
      const editFirstName = document.getElementById('edit-first-name');
      const editLastName = document.getElementById('edit-last-name');
      const editUsername = document.getElementById('edit-username');
      const editEmail = document.getElementById('edit-email');
      const editPassword = document.getElementById('edit-password'); // This is for new password, leave blank for no change
      const editRole = document.getElementById('edit-role-filter');
      const editStatus = document.getElementById('edit-status-filter');


      // Function to fetch and display users (using XMLHttpRequest)
      function fetchAndDisplayUsers(searchTerm = '') {
        let url = '../controller/fetch_users.php'; // Path to your fetch_users.php
        if (searchTerm) {
          url += `?query=${encodeURIComponent(searchTerm)}`; // Add search term as GET parameter
        }

        let xhttp = new XMLHttpRequest();
        xhttp.open('GET', url, true);
        xhttp.send();

        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            try {
              let users = JSON.parse(this.responseText);
              usersTableBody.innerHTML = ''; // Clear existing rows
              if (users.length === 0) {
                const noResultsRow = usersTableBody.insertRow();
                noResultsRow.innerHTML = `<td colspan="9" style="text-align: center; padding: 20px; color: var(--text-muted);">No users found matching your search.</td>`;
              } else {
                users.forEach(user => {
                  const row = usersTableBody.insertRow();
                  const role = user.role || 'user';
                  const status = user.status || 'active';
                  const passwordDisplay = '********';

                  row.innerHTML = `
                                <td><input type="checkbox" class="user-checkbox"></td>
                                <td>${user.u_fname}</td>
                                <td>${user.u_lname}</td>
                                <td>${user.u_email}</td>
                                <td><span class="badge badge-${role.toLowerCase().replace(' ', '-')}">${role.charAt(0).toUpperCase() + role.slice(1)}</span></td>
                                <td>${user.u_username}</td>
                                <td>${passwordDisplay}</td>
                                <td><span class="badge badge-${status.toLowerCase()}">${status.charAt(0).toUpperCase() + status.slice(1)}</span></td>
                                <td class="action-cell">
                                    <button class="btn-icon btn-edit" data-id="${user.u_id}"><i data-feather="edit-2"></i></button>
                                    <button class="btn-icon btn-delete" data-id="${user.u_id}"><i data-feather="trash-2"></i></button>
                                </td>
                            `;
                });
              }
              feather.replace(); // Re-render feather icons after adding new elements
              attachEditDeleteListeners(); // Attach listeners to new buttons
            } catch (error) {
              console.error('JSON parsing error:', error);
              alert('An unexpected response was received from the server while fetching users.');
            }
          } else if (this.readyState == 4) {
            console.error('XHR request failed for fetching users:', this.status, this.responseText);
            // Optionally, display an error message to the user
          }
        };
      }

      // Function to attach event listeners to dynamically created edit/delete buttons
      function attachEditDeleteListeners() {
        // Edit button listeners
        document.querySelectorAll('.btn-edit').forEach(button => {
          button.addEventListener('click', function() {
            const userId = this.dataset.id;
            fetchUserDetails(userId);
          });
        });

        // Delete button listeners
        document.querySelectorAll('.btn-delete').forEach(button => {
          button.addEventListener('click', function() {
            const userId = this.dataset.id;
            if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
              deleteUser(userId);
            }
          });
        });
      }

      // Function to fetch a single user's details for editing (using XMLHttpRequest)
      function fetchUserDetails(userId) {
        let xhttp = new XMLHttpRequest();
        xhttp.open('GET', `../controller/fetch_single_user.php?id=${userId}`, true);
        xhttp.send();

        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            try {
              let user = JSON.parse(this.responseText);
              if (user.success) {
                editUserId.value = user.data.u_id;
                editFirstName.value = user.data.u_fname;
                editLastName.value = user.data.u_lname;
                editUsername.value = user.data.u_username;
                editEmail.value = user.data.u_email;
                editPassword.value = ''; // Always clear password field for security
                editRole.value = user.data.role || 'user';
                editStatus.value = user.data.status || 'active';

                editUserModal.classList.add('active'); // Show the modal
              } else {
                alert('Error fetching user details: ' + user.message);
              }
            } catch (error) {
              console.error('JSON parsing error:', error);
              alert('An unexpected response was received while fetching user details.');
            }
          } else if (this.readyState == 4) {
            alert('Server error fetching user details: ' + this.status);
            console.error('XHR request failed for fetching user details:', this.status, this.responseText);
          }
        };
      }

      // Function to handle user deletion (using XMLHttpRequest)
      function deleteUser(userId) {
        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', '../controller/delete_user.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        
        let params = `user_id=${encodeURIComponent(userId)}`; 

        xhttp.send(params);

        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            try {
              let data = JSON.parse(this.responseText);
              if (data.success) {
                alert(data.message);
                fetchAndDisplayUsers(); // Refresh the user list
              } else {
                alert('Error deleting user: ' + data.message);
              }
            } catch (error) {
              console.error('JSON parsing error:', error);
              alert('An unexpected response was received while deleting the user.');
            }
          } else if (this.readyState == 4) {
            alert('Server error deleting user: ' + this.status);
            console.error('XHR request failed for deleting user:', this.status, this.responseText);
          }
        };
      }

      // Edit User Form Submission via AJAX (using XMLHttpRequest)
      editUserForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(editUserForm);
        
        // Remove password from formData if it's empty, so it's not sent
        if (formData.get('password') === '') {
            formData.delete('password');
        }

        // Convert FormData to URL-encoded string
        let params = new URLSearchParams(formData).toString();

        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', '../controller/update_user.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send(params);

        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            try {
              let data = JSON.parse(this.responseText);
              if (data.success) {
                alert(data.message);
                editUserModal.classList.remove('active'); // Close modal
                fetchAndDisplayUsers(); // Refresh user list
              } else {
                alert('Error updating user: ' + data.message);
              }
            } catch (error) {
              console.error('JSON parsing error:', error);
              alert('An unexpected response was received while updating the user.');
            }
          } else if (this.readyState == 4) {
            alert('Server error updating user: ' + this.status);
            console.error('XHR request failed for updating user:', this.status, this.responseText);
          }
        };
      });


      // Close Edit User Modal functionality
      closeEditUserModal.addEventListener('click', () => {
        editUserModal.classList.remove('active');
      });

      cancelEditUserBtn.addEventListener('click', (e) => {
        e.preventDefault();
        editUserModal.classList.remove('active');
      });


      // Initial load of users when the page loads
      fetchAndDisplayUsers();

      // Event listener for the search button click
      searchButton.addEventListener('click', () => {
        const searchTerm = userSearchInput.value.trim();
        fetchAndDisplayUsers(searchTerm);
      });

      // Optional: Event listener for real-time search as user types
      userSearchInput.addEventListener('keyup', (event) => {
        const searchTerm = userSearchInput.value.trim();
        fetchAndDisplayUsers(searchTerm);
      });
    });
  </script>
</body>

</html>