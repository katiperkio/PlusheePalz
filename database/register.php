<?php
session_start();
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Check if username exists
    $stmt = $connection->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username already exists
        $_SESSION['register_error_message'] = "Username already taken.";
        header("Location: " . BASE_URL . "/createaccount.php");
        exit;
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into database
        $stmt = $connection->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $email);

        if ($stmt->execute()) {
            /* $_SESSION['register_success_message'] = "Registration successful! You can now log in."; */
            header("Location: " . BASE_URL . "/index.php");
            exit;
        } else {
            $_SESSION['register_error_message'] = "An error occurred. Please try again.";
            header("Location: " . BASE_URL . "/createaccount.php");
            exit;
        }
    }

    $stmt->close();
}

$connection->close();
