<?php
// Retrieve tasks from the database
require "../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $taskId = $_POST['taskId'];

        if ($_POST['action'] === 'delete') {
            // Delete the task from the tasks table
            $deleteSql = "DELETE FROM tasks WHERE id = $taskId";
            if ($conn->query($deleteSql) === TRUE) {
                echo "Task deleted successfully.";
            } else {
                echo "Error deleting task: " . $conn->error;
            }
        } elseif ($_POST['action'] === 'complete') {
            // Move the task to the completed_tasks table
            $selectTaskSql = "SELECT * FROM tasks WHERE id = $taskId";
            $result = $conn->query($selectTaskSql);

            if ($result->num_rows > 0) {
                $taskData = $result->fetch_assoc();

                // Insert the task into the completed_tasks table
                $insertCompleteSql = "INSERT INTO completed_tasks (title, completion_date, description) VALUES 
                                      ('" . $taskData['title'] . "', '" . $taskData['completion_date'] . "', '" . $taskData['description'] . "')";

                if ($conn->query($insertCompleteSql) === TRUE) {
                    echo "Task marked as complete.";
                } else {
                    echo "Error marking task as complete: " . $conn->error;
                }

                // Delete the task from the tasks table
                $deleteSql = "DELETE FROM tasks WHERE id = $taskId";
                if ($conn->query($deleteSql) === TRUE) {
                    echo "Task deleted from tasks table.";
                } else {
                    echo "Error deleting task from tasks table: " . $conn->error;
                }
            }
        }
    }
}

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
        // Tick mark and delete buttons
        echo '<div class="d-flex justify-content-end">';
        echo '<button type="button" class="btn btn-success me-2" onclick="markTaskComplete(' . $row['id'] . ')">&#10003; Mark Complete</button>';
        echo '<button type="button" class="btn btn-danger" onclick="deleteTask(' . $row['id'] . ')">&times; Delete</button>';
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
?>
