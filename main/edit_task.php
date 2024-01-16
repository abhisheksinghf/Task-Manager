<?php
// Retrieve task details from the database based on the task ID
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['taskId'])) {
        $taskId = $_POST['taskId'];

        // Fetch task details from the tasks table
        $selectTaskSql = "SELECT id, title, completion_date, description FROM tasks WHERE id = $taskId";
        $result = $conn->query($selectTaskSql);

        if ($result->num_rows > 0) {
            $taskData = $result->fetch_assoc();

            // Return the task details as JSON (you need to implement this)
            echo json_encode($taskData);
        } else {
            echo "Task not found.";
        }
    }
}

// Update task details in the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editTaskId'])) {
        $editTaskId = $_POST['editTaskId'];
        $editTaskTitle = $_POST['editTaskTitle'];
        $editCompletionDate = $_POST['editCompletionDate'];
        $editTaskDescription = $_POST['editTaskDescription'];

        // Update the task details in the tasks table
        $updateTaskSql = "UPDATE tasks SET 
                          title = '$editTaskTitle', 
                          completion_date = '$editCompletionDate', 
                          description = '$editTaskDescription' 
                          WHERE id = $editTaskId";

        if ($conn->query($updateTaskSql) === TRUE) {
            echo "Task updated successfully.";
        } else {
            echo "Error updating task: " . $conn->error;
        }
    }
}
?>
