<?php
session_start();
include('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $connection->prepare("SELECT id, username, password, role, email FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['email'] = $row['email'];

            header('Location: ' . BASE_URL . '/index.php');
            exit;
        } else {
            $_SESSION['error_message'] = "Invalid password";
        }
    } else {
        $_SESSION['error_message'] = "User not found";
    }

    $stmt->close();

    header('Location: ' . BASE_URL . '/index.php');
    exit;
}
