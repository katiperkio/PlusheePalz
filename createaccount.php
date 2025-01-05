<?php

$page_title = 'Create Account';
include 'inc/header_inc.php';

?>

<div class="register-wrap">
    <form action="./database/register.php" method="POST" class="register-form">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" required><br>
        <label for="username">Email (optional)</label>
        <input type="text" class="form-control" id="email" name="email"><br>
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required><br>
        <div class="py-3">
            <button type="submit" class="btn btn-success btn-block px-2 py-2 register-btn" style="width: 90px;">Join</button>
        </div>
    </form>
</div>

<?php

include 'inc/footer_inc.php';

?>