<?php

// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session and ensure admin privileges
session_start();
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    echo "Unauthorized access.";
    exit();
}

// Include database connection
include '../../../database/connect.php';

// Retrieve the table and ID from the POST request
$table = $_POST['table'] ?? null;
$id = $_POST['id'] ?? null;

// Validate input
if ($table === null || $id === null || !is_numeric($id)) {
    echo "Invalid input.";
    exit();
}

if (!$table || !$id || !is_numeric($id)) {
    echo "Invalid input";
    exit();
}

// Whitelist allowed table names to prevent SQL injection
$allowed_tables = ['users', 'palz', 'nature', 'preferences'];
if (!in_array($table, $allowed_tables)) {
    echo "Unauthorized table access.";
    exit();
}

try {
    // Prepare the delete query dynamically using the validated table name
    $sql = "DELETE FROM $table WHERE id = ?";
    $stmt = $connection->prepare($sql);

    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $connection->error);
    }

    // Bind the ID parameter and execute the query
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        // Verify if a row was actually deleted
        if ($stmt->affected_rows > 0) {
            echo "success";
        } else {
            echo "No matching entry found.";
        }
    } else {
        throw new Exception("Failed to execute delete query: " . $stmt->error);
    }

    $stmt->close();
} catch (Exception $e) {
    // Log the error message for debugging
    error_log("Error: " . $e->getMessage());

    // Return a generic error response to the client
    echo "An error occurred while deleting the entry.";
}

// Close the database connection
$connection->close();
exit();
