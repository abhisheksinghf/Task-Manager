<?php
require "../connect.php";

if (isset($_POST['submitTask'])) {
    $taskTitle = $_POST['taskTitle'];
    $completionDate = $_POST['completionDate'];
    $taskDescription = $_POST['taskDescription'];

    // TODO: Save the task to the database (implement your database logic here)
    $sql = "INSERT INTO tasks (title, completion_date, description)
            VALUES ('$taskTitle', '$completionDate', '$taskDescription')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Task inserted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<div class="card mb-3" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
    <div class="card-header" id="taskRegistrationHeading">
        <h2 class="mb-0">
            <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#taskRegistrationCollapse" aria-expanded="true" aria-controls="taskRegistrationCollapse">
                <p style="color:white;">Task Registration🔽</p><i class="bi bi-arrow-down"></i> 
            </button>
        </h2>
    </div>
    <div id="taskRegistrationCollapse" class="collapse show" aria-labelledby="taskRegistrationHeading" data-bs-parent="#taskRegistrationAccordion">
        <div class="card-body">
            <!-- Task Registration Form -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="mb-3">
                    <label for="taskTitle" class="form-label">Task Title</label>
                    <input type="text" class="form-control" id="taskTitle" name="taskTitle" style="background: rgba(255, 255, 255, 0.8);" required>
                </div>
                <div class="mb-3">
                    <label for="completionDate" class="form-label">Date of Completion</label>
                    <input type="date" class="form-control" id="completionDate" name="completionDate" style="background: rgba(255, 255, 255, 0.8);" required>
                </div>
                <div class="mb-3">
                    <label for="taskDescription" class="form-label">Task Description</label>
                    <textarea class="form-control" id="taskDescription" name="taskDescription" rows="3" style="background: rgba(255, 255, 255, 0.8);" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="submitTask">Add</button>
                <button type="button" class="btn btn-success" onclick="window.location.href = 'completed.php'">View Completed Tasks</button>
            </form>
        </div>
    </div>
</div>
