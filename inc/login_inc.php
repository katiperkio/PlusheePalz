<div class="user-authentication">
    <?php if (isset($_SESSION['username'])): ?>
        <!-- Display this section if user is logged in -->
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <form action="./database/logout.php" method="POST" class="logout-form">
            <button type="submit" class="btn btn-danger px-2 py-2">Logout</button>
        </form>
    <?php else: ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <p style="color: red;"><?php echo $_SESSION['error_message']; ?></p>
            <?php unset($_SESSION['error_message']);
            ?>
        <?php endif; ?>
        <!-- Display this section if user is not logged in -->
        <form action="./database/login.php" method="POST" class="login-form">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="btn btn-success px-2 py-2">Log In</button>
        </form>
    <?php endif; ?>
</div>