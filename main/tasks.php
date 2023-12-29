<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch the username from the session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.19.0/font/bootstrap-icons.css">
</head>
<body style="background-image: url('bg.avif');background-size: cover;">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Task Manager</a>
        <div class="navbar-nav ms-auto">
            <span class="navbar-text me-3">
                Welcome, <strong><?php echo $username; ?></strong>
            </span>
            <a class="nav-link" href="#">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 style="text-align: center; font-weight: bolder; color: white; ">Welcome to Task Manager!</h1>
            <p>Your content goes here.</p>

            <!-- Task Registration Collapse -->
            <?php include 'process_form.php'; ?>
            <?php include 'display_tasks.php'; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
