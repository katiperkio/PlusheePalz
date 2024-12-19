<?php

$page_title = 'My Profile';
include 'inc/header_inc.php';

if (!isset($_SESSION['id'])) {
    die();
}

$user_id = $_SESSION['id'];

// Query to fetch the username from the database
$sql = "SELECT username FROM users WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $user_id);  // "i" indicates that the parameter is an integer
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch username
    $row = $result->fetch_assoc();
    $username = $row['username'];
}

$stmt->close();

?>

<div class="profilewrap">
    <div class="profile">
        <div class="profilepic">
            <!-- Profile pic here -->
            <img src="https://cdn.pixabay.com/photo/2016/11/08/15/21/user-1808597_1280.png" />
        </div>
        <div class="username">
            <!-- Username here -->
            <h1><?php echo htmlspecialchars($username); ?></h1>
        </div>
        <div class="userdesc">
            <!-- User description here -->
        </div>
        <div class="friendlist">
            <!-- Friendlist here -->
        </div>
    </div>

    <?php

    include 'inc/footer_inc.php';

    ?>