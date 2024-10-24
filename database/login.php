<?php

session_start(); //start a session for storing user information

include('connect.php'); //include database connection file which contains database connection code

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //check if the form is submitted
    $user = $_POST['username'];
    $password = $_POST['password']; // fetch the inputs from login form

    $stmt = $connection->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password']; // get the hashed password from db

        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['id'] = $row['id'];

            header('Location: /plusheepalz/index.php');
            exit;
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }

    $stmt->close();
}
