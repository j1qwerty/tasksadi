<!-- Add Task Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="add-task-form">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="task-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="task-title" required>
                    </div>
                    <div class="mb-3">
                        <label for="task-description" class="form-label">Description</label>
                        <textarea class="form-control" id="task-description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="task-status" class="form-label">Status</label>
                        <select class="form-control" id="task-status" required>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="task-assigned-to" class="form-label">Assign To</label>
                        <select class="form-control" id="task-assigned-to" required>
                            <!-- Users will be loaded here -->
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="edit-task-form">
                <input type="hidden" id="edit-task-id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-task-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit-task-title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-task-description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit-task-description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit-task-status" class="form-label">Status</label>
                        <select class="form-control" id="edit-task-status" required>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-task-assigned-to" class="form-label">Assign To</label>
                        <select class="form-control" id="edit-task-assigned-to" required>
                            <!-- Users will be loaded here -->
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Task</button>
                </div>
            </form>
        </div>
    </div>
</div>
