<?php
// Retrieve completed tasks from the database
require "../connect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completed Tasks</title>
    <!-- Bootstrap CSS link -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<style>
    body {
        background-image: url('bg.avif');
        background-size: cover;
    }

    .container {
        background: rgba(255, 255, 255, 0.7); /* Glass-like effect with transparency */
        padding: 20px;
        border-radius: 10px;
        margin-top: 50px;
    }

    .table {
        background: rgba(255, 255, 255, 0.5); /* Slightly transparent white background */
        border: 1px solid rgba(0, 0, 0, 0.125); /* Bootstrap table border color */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Box shadow for a subtle lift effect */
    }

    .table th, .table td {
        border: 1px solid rgba(0, 0, 0, 0.125); /* Bootstrap table cell border color */
    }

    .table-info {
        background-color: rgba(173, 216, 230, 0.8) !important; /* Table row background color with transparency */
    }

    .btn-danger {
        background-color: rgba(220, 53, 69, 0.8);
        border-color: rgba(220, 53, 69, 0.8);
    }

    .btn-danger:hover {
        background-color: rgba(185, 28, 54, 0.8);
        border-color: rgba(185, 28, 54, 0.8);
    }
</style>
<body style="background-image: url('bg.avif');background-size: cover;">
<div class="container mt-4">
    <h2 class="mb-4" style="color:white">Completed Tasks</h2>

    <?php
    $sql = "SELECT id, title, completion_date, description FROM completed_tasks";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table class="table table-bordered table-hover table-striped">';
        echo '<thead class="thead-dark">';
        echo '<tr>';
        echo '<th scope="col">Task Title</th>';
        echo '<th scope="col">Completion Date</th>';
        echo '<th scope="col">Description</th>';
        echo '<th scope="col">Actions</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr class="table-info">';
            echo '<td>' . $row['title'] . '</td>';
            echo '<td>' . $row['completion_date'] . '</td>';
            echo '<td>' . $row['description'] . '</td>';
            echo '<td>';
            // Delete button for completed tasks
            echo '<button type="button" class="btn btn-danger" onclick="deleteCompletedTask(' . $row['id'] . ')">&times; Delete</button>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p class="text-muted">No completed tasks found.</p>';
    }
    ?>
</div>

<!-- JavaScript function for deleting completed tasks -->
<script>
    function deleteCompletedTask(taskId) {
        // Send an asynchronous request to the server
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_completed_task.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Define the parameters to be sent to the server
        var params = "action=delete&taskId=" + taskId;

        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Display the response from the server
                alert(xhr.responseText);

                // Refresh the completed task list after deletion
                // You might want to implement a more efficient way to update the UI
                location.reload();
            }
        };

        // Send the request with the specified parameters
        xhr.send(params);
    }
</script>

<!-- Bootstrap JS and Popper.js scripts (required for Bootstrap components) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
