@extends('layouts.app')

@section('title', 'User Dashboard - Task Manager')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user me-2 text-primary"></i>My Dashboard</h2>
    <div>
        <button class="btn btn-outline-primary" onclick="loadTasks()">
            <i class="fas fa-sync-alt me-2"></i>Refresh
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4" id="user-stats">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Tasks</h6>
                        <h3 class="mb-0" id="total-user-tasks">0</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-tasks fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Pending</h6>
                        <h3 class="mb-0" id="pending-user-tasks">0</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">In Progress</h6>
                        <h3 class="mb-0" id="progress-user-tasks">0</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-spinner fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Completed</h6>
                        <h3 class="mb-0" id="completed-user-tasks">0</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" id="task-search" placeholder="Search tasks...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-control" id="status-filter">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-secondary w-100" onclick="clearFilters()">
                    <i class="fas fa-times me-2"></i>Clear Filters
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Tasks List -->
<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-list me-2"></i>My Tasks</h5>
    </div>
    <div class="card-body">
        <div id="tasks-container">
            <!-- Tasks will be loaded here -->
        </div>
    </div>
</div>

<!-- Loading Spinner -->
<div class="loading-spinner" id="user-loading" style="display: none;">
    <div class="text-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2">Loading your tasks...</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let allTasks = [];
    
    // Load tasks on page load
    loadTasks();
    
    // Search functionality
    $('#task-search').on('input', function() {
        filterTasks();
    });
    
    // Status filter
    $('#status-filter').on('change', function() {
        filterTasks();
    });
    
    // Load user tasks
    function loadTasks() {
        $('#user-loading').show();
        
        $.ajax({
            url: '/api/get-tasks',
            method: 'GET',
            success: function(tasks) {
                allTasks = tasks;
                updateStats();
                renderTasks(tasks);
                $('#user-loading').hide();
            },
            error: function() {
                alert('Failed to load tasks');
                $('#user-loading').hide();
            }
        });
    }
    
    // Update statistics
    function updateStats() {
        const totalTasks = allTasks.length;
        const pendingTasks = allTasks.filter(task => task.status === 'pending').length;
        const progressTasks = allTasks.filter(task => task.status === 'in_progress').length;
        const completedTasks = allTasks.filter(task => task.status === 'completed').length;
        
        $('#total-user-tasks').text(totalTasks);
        $('#pending-user-tasks').text(pendingTasks);
        $('#progress-user-tasks').text(progressTasks);
        $('#completed-user-tasks').text(completedTasks);
    }
    
    // Render tasks
    function renderTasks(tasks) {
        const container = $('#tasks-container');
        container.empty();
        
        if (tasks.length === 0) {
            container.html(`
                <div class="text-center text-muted py-4">
                    <i class="fas fa-tasks fa-3x mb-3"></i>
                    <h5>No tasks found</h5>
                    <p>You don't have any tasks matching the current filters.</p>
                </div>
            `);
            return;
        }
        
        tasks.forEach(task => {
            const statusClass = {
                'pending': 'secondary',
                'in_progress': 'warning',
                'completed': 'success'
            }[task.status];
            
            const statusIcon = {
                'pending': 'clock',
                'in_progress': 'spinner',
                'completed': 'check-circle'
            }[task.status];
            
            const taskCard = `
                <div class="card mb-3 task-card" data-status="${task.status}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="card-title">${task.title}</h6>
                                <p class="card-text text-muted">${task.description}</p>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    Created: ${new Date(task.created_at).toLocaleDateString()}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-${statusClass} status-badge mb-2">
                                    <i class="fas fa-${statusIcon} me-1"></i>
                                    ${task.status.replace('_', ' ')}
                                </span>
                                ${task.status !== 'completed' ? `
                                    <br>
                                    <button class="btn btn-sm btn-success" onclick="markCompleted(${task.id})">
                                        <i class="fas fa-check me-1"></i>Mark Complete
                                    </button>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.append(taskCard);
        });
    }
    
    // Filter tasks
    function filterTasks() {
        const searchTerm = $('#task-search').val().toLowerCase();
        const statusFilter = $('#status-filter').val();
        
        let filteredTasks = allTasks;
        
        if (searchTerm) {
            filteredTasks = filteredTasks.filter(task => 
                task.title.toLowerCase().includes(searchTerm) ||
                task.description.toLowerCase().includes(searchTerm)
            );
        }
        
        if (statusFilter) {
            filteredTasks = filteredTasks.filter(task => task.status === statusFilter);
        }
        
        renderTasks(filteredTasks);
    }
    
    // Clear filters
    window.clearFilters = function() {
        $('#task-search').val('');
        $('#status-filter').val('');
        renderTasks(allTasks);
    };
    
    // Mark task as completed
    window.markCompleted = function(taskId) {
        if (confirm('Mark this task as completed?')) {
            $.ajax({
                url: `/api/tasks/${taskId}/complete`,
                method: 'POST',
                success: function(response) {
                    if (response.success) {
                        alert('Task marked as completed!');
                        loadTasks(); // Refresh tasks
                    }
                },
                error: function() {
                    alert('Failed to update task status');
                }
            });
        }
    };
});
</script>
@endsection
