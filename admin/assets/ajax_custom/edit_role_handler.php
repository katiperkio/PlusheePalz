<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session and ensure admin privileges
session_start();
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    echo "Unauthorized access.";
    exit();
}

include '../../../database/connect.php';

$userId = $_POST['id'] ?? null;
$newRole = $_POST['role'] ?? null;

// Validate input
if (!$userId || !$newRole || !in_array($newRole, ['admin', 'guest'])) {
    echo 'error';
    exit();
}

if (!$table || !$id || !is_numeric($id)) {
    echo "Invalid input";
    exit();
}

try {
    // Prepare the update query
    $sql = "UPDATE users SET role = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);

    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $connection->error);
    }

    $stmt->bind_param("si", $newRole, $userId);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        throw new Exception("Failed to execute query: " . $stmt->error);
    }

    $stmt->close();
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo 'error';
}

$connection->close();
exit();
