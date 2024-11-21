<?php
include '../database/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // var_dump($_POST);
    // die();

    // Get data from the form
    $palz_name = $_POST['palz_name'];
    $palz_age = $_POST['palz_age'];
    $palz_nature = $_POST['palz_nature'] ?? []; // Traits
    $palz_loves = $_POST['palz_loves'] ?? [];   // Likes
    $palz_hates = $_POST['palz_hates'] ?? [];   // Dislikes

    // Start a transaction to ensure all inserts are successful
    $connection->begin_transaction();

    try {
        // Insert into palz table
        $sql = "INSERT INTO palz (name, age) VALUES (?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss", $palz_name, $palz_age);
        $stmt->execute();

        // Get the inserted palz_id
        $palz_id = $stmt->insert_id;

        // Insert traits into palz_nature table
        $sql_nature = "INSERT INTO palz_nature (palz_id, nature_id) VALUES (?, ?)";
        $stmt_nature = $connection->prepare($sql_nature);
        foreach ($palz_nature as $nature_id) {
            $stmt_nature->bind_param("ii", $palz_id, $nature_id);
            $stmt_nature->execute();
        }

        // Insert likes and dislikes into palz_preferences table
        $sql_preferences = "INSERT INTO palz_preferences (palz_id, preference_id, type) VALUES (?, ?, ?)";
        $stmt_preferences = $connection->prepare($sql_preferences);

        // Insert likes with type 'like'
        foreach ($palz_loves as $preference_id) {
            $type = 'like';
            $stmt_preferences->bind_param("iis", $palz_id, $preference_id, $type);
            $stmt_preferences->execute();
        }

        // Insert dislikes with type 'dislike'
        foreach ($palz_hates as $preference_id) {
            $type = 'dislike';
            $stmt_preferences->bind_param("iis", $palz_id, $preference_id, $type);
            $stmt_preferences->execute();
        }

        // Commit the transaction
        $connection->commit();

        echo "Palz added successfully!";
        header("Location: /plusheepalz/index.php");
    } catch (Exception $e) {
        // Rollback transaction on failure
        $connection->rollback();
        echo "Error adding Palz: " . $e->getMessage();
    } finally {
        // Close all statements
        $stmt->close();
        $stmt_nature->close();
        $stmt_preferences->close();
    }
}

$connection->close();
