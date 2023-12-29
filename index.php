<?php
require "connect.php";

function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

session_start();

function processLogin($conn) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["loginUsername"]) && isset($_POST["loginPassword"])) {
        $username = $_POST['loginUsername'];
        $password = $_POST['loginPassword'];

        $checkUserSql = "SELECT id, username, password, role FROM users WHERE username = '$username'";
        $result = $conn->query($checkUserSql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username;
                header("Location: main/tasks.php");
                exit();
            } else {
                echo "<p class='text-danger'>Invalid password</p>";
            }
        } else {
            echo "<p class='text-danger'>User not found</p>";
        }
    }
}

function processSignup($conn) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signupUsername"]) && isset($_POST["signupPassword"]) && isset($_POST["signupRole"])) {
        $username = $_POST['signupUsername'];
        $password = hashPassword($_POST['signupPassword']);
        $role = $_POST['signupRole'];

        $insertUserSql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";

        if ($conn->query($insertUserSql) === TRUE) {
            echo "<p class='text-success'>Registration successful. Welcome, $username!</p>";
        } else {
            echo "<p class='text-danger'>Error: " . $conn->error . "</p>";
        }
    }
}

processLogin($conn);
processSignup($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task and Event Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<style>
    body {
        background-image: url('https://media.istockphoto.com/id/162515751/photo/moon-over-mountains.webp?b=1&s=170667a&w=0&k=20&c=wTY5u-v052kxHuDZE39aVnNcX44ZI-4BGtOrn59M8FM=');
        /* background-image: url('data:image/jpeg;base64,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'); */
        background-size: cover;
        background-position: center;
        height: 100vh;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .welcome-container {
        text-align: center;
        background: rgba(255, 255, 255, 0.2);
        padding: 20px;
        border-radius: 10px;
        backdrop-filter: blur(10px);
    }

    .glass-button {
        background: transparent;
        border: none;
        padding: 10px 20px;
        font-size: 18px;
        margin: 5px;
        cursor: pointer;
        border-radius: 5px;
        transition: background 0.3s ease-in-out;
        background: rgba(255, 255, 255, 0.2);
    }

    .glass-button:hover {
    }
</style>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 text-center">
            <!-- <img src="https://plus.unsplash.com/premium_photo-1684330691489-2eb2620db612?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="img-fluid" alt="Welcome Image" style="max-height: 300px;"> -->
            <h1 class="mt-4" style="color: white; font-weight: bolder; font-size:60px">Welcome to Task Management</h1>

            <div class="mt-5">
                <!-- Login Button -->
                <button type="button" class="btn btn-primary glass-button" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>

                <!-- Signup Button -->
                <button type="button" class="btn btn-success glass-button" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>

                <!-- Login Modal -->
                <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Login Form -->
                                <form action="index.php" method="post">
                                    <div class="mb-3">
                                        <label for="loginUsername" class="form-label" style="color: ;">Username</label>
                                        <input type="text" class="form-control" id="loginUsername" name="loginUsername" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="loginPassword" class="form-label" style="color: ;">Password</label>
                                        <input type="password" class="form-control" id="loginPassword" name="loginPassword" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Login</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Signup Modal -->
                <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="signupModalLabel">Signup</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Signup Form -->
                                <form action="" method="post">
                                    <div class="mb-3">
                                        <label for="signupUsername" class="form-label" style="color: ;">Username</label>
                                        <input type="text" class="form-control" id="signupUsername" name="signupUsername" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="signupPassword" class="form-label" style="color: ;">Password</label>
                                        <input type="password" class="form-control" id="signupPassword" name="signupPassword" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="signupRole" class="form-label" style="color: ;">Role</label>
                                        <select class="form-select" id="signupRole" name="signupRole" required>
                                            <option value="employee">Employee</option>
                                            <option value="manager">Manager</option>
                                            <option value="administrator">Administrator</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">Signup</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
