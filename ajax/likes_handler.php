<?php

include '../database/connect.php';
require_once('../database/connect.php');

$palz_id = $_POST['palz_id'] ?? null;
$user_id = $_POST['user_id'] ?? null;

if ($palz_id === null || $user_id === null) {
    echo $user_id;
    return;
}

// Check if the user has already liked this palz
$sql = "SELECT * FROM user_likes WHERE user_id = ? AND palz_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("ii", $user_id, $palz_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If the user already liked the palz, remove the like
    $sql = "DELETE FROM user_likes WHERE user_id = ? AND palz_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ii", $user_id, $palz_id);
    $stmt->execute();
    echo "like_removed";
} else {
    // If the user hasn't liked the palz, add the like
    $sql = "INSERT INTO user_likes (user_id, palz_id) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ii", $user_id, $palz_id);
    $stmt->execute();
    echo "like_added";
}

exit();
