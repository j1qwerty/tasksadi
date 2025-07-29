@extends('layouts.app')

@section('title', 'Admin Dashboard - Task Manager')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-crown me-2 text-warning"></i>Admin Dashboard</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTaskModal">
        <i class="fas fa-plus me-2"></i>Add New Task
    </button>
</div>

<!-- Statistics Cards -->
<div class="row mb-4" id="stats-container">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Users</h6>
                        <h3 class="mb-0" id="total-users">0</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
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
                        <h6 class="card-title">Total Tasks</h6>
                        <h3 class="mb-0" id="total-tasks">0</h3>
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
                        <h6 class="card-title">In Progress</h6>
                        <h3 class="mb-0" id="in-progress-tasks">0</h3>
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
                        <h6 class="card-title">Completed</h6>
                        <h3 class="mb-0" id="completed-tasks">0</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs" id="adminTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tasks-tab" data-bs-toggle="tab" data-bs-target="#tasks" type="button" role="tab">
            <i class="fas fa-tasks me-2"></i>All Tasks
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">
            <i class="fas fa-users me-2"></i>Users Management
        </button>
    </li>
</ul>

<div class="tab-content" id="adminTabContent">
    <!-- Tasks Tab -->
    <div class="tab-pane fade show active" id="tasks" role="tabpanel">
        <div class="card mt-3">
            <div class="card-header">
                <h5><i class="fas fa-list me-2"></i>Task Management</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tasks-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Assigned To</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Tasks will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Users Tab -->
    <div class="tab-pane fade" id="users" role="tabpanel">
        <div class="card mt-3">
            <div class="card-header">
                <h5><i class="fas fa-user-cog me-2"></i>User Management</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Firebase UID</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Users will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.admin-modals')

<!-- Loading Spinner -->
<div class="loading-spinner" id="admin-loading" style="display: none;">
    <div class="text-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2">Loading admin data...</p>
    </div>
</div>
@endsection

@section('scripts')
@include('partials.admin-scripts')
@endsection
