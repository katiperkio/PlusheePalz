<?php include_once "../database/connect.php"; ?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}

// Check if user has the "admin" role
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Security headers
header("X-Frame-Options: SAMEORIGIN"); // Prevent clickjacking
header("X-Content-Type-Options: nosniff"); // Prevent MIME sniffing
/* header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:;"); // Restrict content sources */
header("Referrer-Policy: no-referrer"); // Control referrer information
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/dashlite.min.css" />
    <link rel="stylesheet" href="./assets/css/theme-override.css" />
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">

            <?php include "./includes/sidebar.php"; ?>
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <?php include "./includes/navbar.php"; ?>
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">