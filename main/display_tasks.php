<?php
// Display tasks
echo '<div id="eventList">';

$sql = "SELECT id, title, completion_date, description FROM tasks";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="card mb-3">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $row['title'] . '</h5>';
        echo '<p class="card-text">' . $row['description'] . '. Date: ' . $row['completion_date'] . '</p>';
        // Tick mark, edit, and delete buttons
        echo '<div class="d-flex justify-content-end">';
        echo '<button type="button" class="btn btn-success me-2" onclick="markTaskComplete(' . $row['id'] . ')">&#10003; </button>';
        echo '<button type="button" class="btn btn-warning me-2" onclick="editTask(' . $row['id'] . ')">&#x270E;</button>';
        echo '<button type="button" class="btn btn-danger" onclick="deleteTask(' . $row['id'] . ')">&times;</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p>No tasks found.</p>';
}

echo '</div>';

// JavaScript function for deleting tasks
echo '<script>
    function deleteTask(taskId) {
        // Send an asynchronous request to the server
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_task.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
        // Define the parameters to be sent to the server
        var params = "action=delete&taskId=" + taskId;
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Display the response from the server
                alert(xhr.responseText);
                
                // Refresh the task list after deletion
                // You might want to implement a more efficient way to update the UI
                location.reload();
            }
        };
        
        // Send the request with the specified parameters
        xhr.send(params);
    }
</script>';

// JavaScript function for marking tasks as complete
echo '<script>
    function markTaskComplete(taskId) {
        // Send an asynchronous request to the server
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "mark_complete.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
        // Define the parameters to be sent to the server
        var params = "action=complete&taskId=" + taskId;
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Display the response from the server
                alert(xhr.responseText);
                
                // Refresh the task list after marking as complete
                // You might want to implement a more efficient way to update the UI
                location.reload();
            }
        };
        
        // Send the request with the specified parameters
        xhr.send(params);
    }
</script>';

// Edit Task Modal
echo '<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">';
echo '<div class="modal-dialog modal-dialog-centered">';
echo '<div class="modal-content">';
echo '<div class="modal-header">';
echo '<h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>';
echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
echo '</div>';
echo '<div class="modal-body">';
// Edit Task Form
echo '<form id="editTaskForm" action="edit_task.php">';
echo '<input type="hidden" id="editTaskId" name="editTaskId">';
echo '<div class="mb-3">';
echo '<label for="editTaskTitle" class="form-label">Task Title</label>';
echo '<input type="text" class="form-control" id="editTaskTitle" name="editTaskTitle" required>';
echo '</div>';
echo '<div class="mb-3">';
echo '<label for="editCompletionDate" class="form-label">Date of Completion</label>';
echo '<input type="date" class="form-control" id="editCompletionDate" name="editCompletionDate" required>';
echo '</div>';
echo '<div class="mb-3">';
echo '<label for="editTaskDescription" class="form-label">Task Description</label>';
echo '<textarea class="form-control" id="editTaskDescription" name="editTaskDescription" rows="3" required></textarea>';
echo '</div>';
echo '<button type="button" class="btn btn-primary" onclick="saveEditedTask()">Save Changes</button>';
echo '</form>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

// JavaScript function for editing tasks
echo '<script>
    function editTask(taskId) {
        // Open the edit task modal
        $("#editTaskModal").modal("show");

        // Set the task ID in the modal form
        $("#editTaskId").val(taskId);

        // Fetch the task details using an AJAX request
        $.ajax({
            type: "POST",
            url: "edit_task.php", // Provide the correct URL for the edit_task.php file
            data: { taskId: taskId },
            success: function(response) {
                // Populate the form fields with the task details
                var taskDetails = JSON.parse(response);
                $("#editTaskTitle").val(taskDetails.title);
                $("#editCompletionDate").val(taskDetails.completion_date);
                $("#editTaskDescription").val(taskDetails.description);
            },
            error: function() {
                alert("Error fetching task details.");
            }
        });
    }

    // Function to save edited task
    function saveEditedTask() {
        // Send an AJAX request to save the edited task (you need to implement this)
        // Close the modal after saving the changes
        $("#editTaskModal").modal("hide");
    }
</script>';
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
