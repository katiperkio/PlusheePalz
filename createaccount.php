<?php

$page_title = 'Create Account';
include 'inc/header_inc.php';

?>

<h1>Register</h1>
<form action="./database/register.php" method="POST" class="register-form">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" required><br>
    <label for="username">Email (optional)</label>
    <input type="text" id="email" name="email"><br>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required><br>
    <button type="submit" class="register-btn">Join</button>
</form>

<?php

include 'inc/footer_inc.php';

?>