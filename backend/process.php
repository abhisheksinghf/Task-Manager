<?php
// Assuming you already have a database connection
require "../connect.php"; // Update this with your actual connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["loginUsername"]) && isset($_POST["loginPassword"])) {
    // Get user input
    $username = $_POST['loginUsername'];
    $password = $_POST['loginPassword'];

    // Query to check if the user exists
    $checkUserSql = "SELECT id, username, password, role FROM users WHERE username = '$username'";
    $result = $conn->query($checkUserSql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables and redirect to tasks.php
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            header("Location: tasks.php");
            exit();
        } else {
            // Password is incorrect
            $errorMessage = "Invalid password";
        }
    } else {
        // User not found
        $errorMessage = "User not found";
    }

    // Close the database connection
    $conn->close();
}
?>
