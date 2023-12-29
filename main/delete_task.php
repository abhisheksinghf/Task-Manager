<?php
require "../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $taskId = $_POST['taskId'];

        // Delete the task from the tasks table
        $deleteSql = "DELETE FROM tasks WHERE id = $taskId";
        if ($conn->query($deleteSql) === TRUE) {
            echo "Task deleted successfully.";
        } else {
            echo "Error deleting task: " . $conn->error;
        }
    }
}
?>
