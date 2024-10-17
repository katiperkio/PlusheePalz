<?php

include('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username']; // get username from form
    $password = $_POST['password']; // get password from form

    $stmt = $connection->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // username already exists
        echo "Username already taken";
    } else {
        // hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // insert new user into database
        $stmt = $connection->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            echo "Success";
            header("Location: /plusheepalz/landing.php");
        } else {
            echo "Error";
        }
    }

    $stmt->close();
}

$connection->close();
