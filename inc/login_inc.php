<div class="user-authentication">
    <?php if (isset($_SESSION['username'])): ?>
        <!-- display this section if user is logged in -->
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <form action="./database/logout.php" method="POST" class="logout-form">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    <?php else: ?>
        <!-- display this section if user is not logged in -->
        <form action="./database/login.php" method="POST" class="login-form">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="login-btn">Log In</button>
        </form>
    <?php endif; ?>
</div>