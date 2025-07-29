<script>
$(document).ready(function() {
    let users = [];
    let tasks = [];
    
    // Load initial data
    loadStats();
    loadUsers();
    loadTasks();
    
    // Tab switching
    $('#adminTabs button').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    
    // Load statistics
    function loadStats() {
        $.ajax({
            url: '/api/admin/stats',
            method: 'GET',
            success: function(stats) {
                $('#total-users').text(stats.total_users);
                $('#total-tasks').text(stats.total_tasks);
                $('#in-progress-tasks').text(stats.in_progress_tasks);
                $('#completed-tasks').text(stats.completed_tasks);
            },
            error: function() {
                console.error('Failed to load statistics');
            }
        });
    }
    
    // Load users
    function loadUsers() {
        $.ajax({
            url: '/api/admin/users',
            method: 'GET',
            success: function(data) {
                users = data;
                renderUsersTable();
                populateUserSelects();
            },
            error: function() {
                console.error('Failed to load users');
            }
        });
    }
    
    // Load tasks
    function loadTasks() {
        $.ajax({
            url: '/api/admin/tasks',
            method: 'GET',
            success: function(data) {
                tasks = data;
                renderTasksTable();
            },
            error: function() {
                console.error('Failed to load tasks');
            }
        });
    }
    
    // Render users table
    function renderUsersTable() {
        const tbody = $('#users-table tbody');
        tbody.empty();
        
        users.forEach(user => {
            const roleClass = user.role === 'admin' ? 'badge bg-warning' : 'badge bg-primary';
            const row = `
                <tr>
                    <td>${user.id}</td>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td><span class="${roleClass}">${user.role}</span></td>
                    <td>${user.firebase_uid || 'Not connected'}</td>
                    <td>${new Date(user.created_at).toLocaleDateString()}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" onclick="toggleUserRole(${user.id}, '${user.role}')">
                            ${user.role === 'admin' ? 'Make User' : 'Make Admin'}
                        </button>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    }
    
    // Render tasks table
    function renderTasksTable() {
        const tbody = $('#tasks-table tbody');
        tbody.empty();
        
        tasks.forEach(task => {
            const statusClass = {
                'pending': 'badge bg-secondary',
                'in_progress': 'badge bg-warning',
                'completed': 'badge bg-success'
            }[task.status];
            
            const userName = task.user ? task.user.name : 'Unassigned';
            
            const row = `
                <tr>
                    <td>${task.id}</td>
                    <td>${task.title}</td>
                    <td>${task.description.substring(0, 50)}...</td>
                    <td><span class="${statusClass}">${task.status.replace('_', ' ')}</span></td>
                    <td>${userName}</td>
                    <td>${new Date(task.created_at).toLocaleDateString()}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" onclick="editTask(${task.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteTask(${task.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    }
    
    // Populate user selects
    function populateUserSelects() {
        const selects = ['#task-assigned-to', '#edit-task-assigned-to'];
        selects.forEach(selectId => {
            const select = $(selectId);
            select.empty();
            users.forEach(user => {
                select.append(`<option value="${user.id}">${user.name} (${user.email})</option>`);
            });
        });
    }
    
    // Add task form submission
    $('#add-task-form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            title: $('#task-title').val(),
            description: $('#task-description').val(),
            status: $('#task-status').val(),
            assigned_to: $('#task-assigned-to').val()
        };
        
        $.ajax({
            url: '/api/admin/tasks',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#addTaskModal').modal('hide');
                    $('#add-task-form')[0].reset();
                    loadTasks();
                    loadStats();
                    alert('Task created successfully!');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                alert('Error: ' + (response.message || 'Failed to create task'));
            }
        });
    });
    
    // Edit task form submission
    $('#edit-task-form').on('submit', function(e) {
        e.preventDefault();
        
        const taskId = $('#edit-task-id').val();
        const formData = {
            title: $('#edit-task-title').val(),
            description: $('#edit-task-description').val(),
            status: $('#edit-task-status').val(),
            assigned_to: $('#edit-task-assigned-to').val()
        };
        
        $.ajax({
            url: `/api/admin/tasks/${taskId}`,
            method: 'PUT',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#editTaskModal').modal('hide');
                    loadTasks();
                    loadStats();
                    alert('Task updated successfully!');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                alert('Error: ' + (response.message || 'Failed to update task'));
            }
        });
    });
    
    // Global functions
    window.editTask = function(taskId) {
        const task = tasks.find(t => t.id === taskId);
        if (task) {
            $('#edit-task-id').val(task.id);
            $('#edit-task-title').val(task.title);
            $('#edit-task-description').val(task.description);
            $('#edit-task-status').val(task.status);
            $('#edit-task-assigned-to').val(task.assigned_to);
            $('#editTaskModal').modal('show');
        }
    };
    
    window.deleteTask = function(taskId) {
        if (confirm('Are you sure you want to delete this task?')) {
            $.ajax({
                url: `/api/admin/tasks/${taskId}`,
                method: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        loadTasks();
                        loadStats();
                        alert('Task deleted successfully!');
                    }
                },
                error: function() {
                    alert('Failed to delete task');
                }
            });
        }
    };
    
    window.toggleUserRole = function(userId, currentRole) {
        const newRole = currentRole === 'admin' ? 'user' : 'admin';
        if (confirm(`Are you sure you want to make this user an ${newRole}?`)) {
            $.ajax({
                url: `/api/admin/users/${userId}/role`,
                method: 'PUT',
                data: { role: newRole },
                success: function(response) {
                    if (response.success) {
                        loadUsers();
                        loadStats();
                        alert('User role updated successfully!');
                    }
                },
                error: function() {
                    alert('Failed to update user role');
                }
            });
        }
    };
});
</script>
