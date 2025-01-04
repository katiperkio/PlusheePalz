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
$palzId = $_POST['id'] ?? null;
$newStatus = $_POST['status'] ?? null;

// Validate input
if (!$palzId || !$newStatus || !in_array($newStatus, ['published', 'draft'])) {
    echo 'error';
    exit();
}

try {
    // Prepare the update query
    $sql = "UPDATE palz SET status = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);

    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $connection->error);
    }

    $stmt->bind_param("si", $newStatus, $palzId);

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
