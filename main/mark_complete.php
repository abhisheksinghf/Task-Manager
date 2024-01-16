<?php
require "../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'complete') {
        $taskId = $_POST['taskId'];

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
                
                // Delete the task from the tasks table
                $deleteSql = "DELETE FROM tasks WHERE id = $taskId";
                if ($conn->query($deleteSql) === TRUE) {
                    echo "Task deleted from tasks table.";
                } else {
                    echo "Error deleting task from tasks table: " . $conn->error;
                }
            } else {
                echo "Error marking task as complete: " . $conn->error;
            }
        }
    }
}
?>
