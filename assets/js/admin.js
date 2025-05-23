document.addEventListener('DOMContentLoaded', function() {
  // Initialize sidebar toggle
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebar-toggle');
  
  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', function() {
      sidebar.classList.toggle('active');
    });
  }
  
  // Navigation between sections
  const menuItems = document.querySelectorAll('.sidebar-menu li');
  const sections = {
    'users': document.getElementById('users-section'),
    'content': document.getElementById('content-section'),
    'settings': document.getElementById('settings-section')
  };
  const pageTitle = document.getElementById('page-title');
  
  menuItems.forEach(item => {
    item.addEventListener('click', function() {
      const page = this.getAttribute('data-page');
      
      // Skip if it's the logout item
      if (page === 'logout') return;
      
      // Update active menu item
      menuItems.forEach(i => i.classList.remove('active'));
      this.classList.add('active');
      
      // Hide all sections
      Object.values(sections).forEach(section => {
        if (section) section.style.display = 'none';
      });
      
      // Show selected section
      if (sections[page]) {
        sections[page].style.display = 'block';
        
        // Update page title
        switch(page) {
          case 'users':
            pageTitle.textContent = 'User Management';
            break;
          case 'content':
            pageTitle.textContent = 'Content Moderation';
            break;
          case 'settings':
            pageTitle.textContent = 'System Settings';
            break;
        }
      }
    });
  });
  
  // Table sorting functionality
  const tableHeaders = document.querySelectorAll('.admin-table th[data-sort]');
  tableHeaders.forEach(header => {
    header.addEventListener('click', function() {
      const sortField = this.getAttribute('data-sort');
      const sortIcon = this.querySelector('.sort-icon');
      const isAscending = this.classList.contains('asc');
      
      // Reset all headers
      tableHeaders.forEach(h => {
        h.classList.remove('asc', 'desc');
        const icon = h.querySelector('.sort-icon');
        if (icon) {
          icon.setAttribute('data-feather', 'chevron-down');
          feather.replace();
        }
      });
      
      // Set current header state
      if (isAscending) {
        this.classList.add('desc');
        if (sortIcon) {
          sortIcon.setAttribute('data-feather', 'chevron-up');
          feather.replace();
        }
      } else {
        this.classList.add('asc');
        if (sortIcon) {
          sortIcon.setAttribute('data-feather', 'chevron-down');
          feather.replace();
        }
      }
      
      // Here you would actually sort the table data
      // sortTable(sortField, isAscending ? 'asc' : 'desc');
    });
  });
  
  // Settings tabs functionality
  const settingsTabs = document.querySelectorAll('.settings-tab');
  const settingsTabContents = document.querySelectorAll('.settings-tab-content');
  
  settingsTabs.forEach(tab => {
    tab.addEventListener('click', function() {
      const tabId = this.getAttribute('data-tab');
      
      // Update active tab
      settingsTabs.forEach(t => t.classList.remove('active'));
      this.classList.add('active');
      
      // Show corresponding content
      settingsTabContents.forEach(content => {
        content.classList.remove('active');
        if (content.id === `${tabId}-tab`) {
          content.classList.add('active');
        }
      });
    });
  });
  
  // Modal functionality
  const addUserBtn = document.getElementById('add-user-btn');
  const addUserModal = document.getElementById('add-user-modal');
  const modalCloseBtns = document.querySelectorAll('.modal-close');
  
  if (addUserBtn && addUserModal) {
    addUserBtn.addEventListener('click', function() {
      addUserModal.classList.add('active');
    });
  }
  
  modalCloseBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      this.closest('.modal').classList.remove('active');
    });
  });
  
  // Close modal when clicking outside
  window.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal')) {
      e.target.classList.remove('active');
    }
  });
  
  // Bulk actions dropdown
  const bulkActionsBtn = document.getElementById('bulk-actions-btn');
  if (bulkActionsBtn) {
    bulkActionsBtn.addEventListener('click', function() {
      // This would toggle a dropdown menu with bulk actions
      alert('Bulk actions dropdown would appear here');
    });
  }
  
  // Select all checkbox
  const selectAllCheckbox = document.getElementById('select-all-users');
  if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener('change', function() {
      const checkboxes = document.querySelectorAll('.user-checkbox');
      checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
      });
    });
  }
  
  // Filter functionality
  const roleFilter = document.getElementById('role-filter');
  const statusFilter = document.getElementById('status-filter');
  
  if (roleFilter && statusFilter) {
    [roleFilter, statusFilter].forEach(filter => {
      filter.addEventListener('change', function() {
        // This would filter the table based on selected criteria
        // applyFilters();
      });
    });
  }
  
  // Search functionality
  const userSearch = document.getElementById('user-search');
  if (userSearch) {
    userSearch.addEventListener('input', function() {
      // This would search the table based on input
      // searchTable(this.value);
    });
  }
  
  // Initialize all feather icons
  feather.replace();
});