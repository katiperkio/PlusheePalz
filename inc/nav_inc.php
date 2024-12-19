<div class="navigation_top">
    <ul>
        <li class="navbtn">
            <a href="<?= BASE_URL ?>/index.php">Home</a>
        </li>
        <li class="navbtn">
            <a href="<?= BASE_URL ?>/discover.php">Discover Palz</a>
        </li>
        <!-- Show only when the user is logged in -->
        <?php if (isset($_SESSION['username'])): ?>
            <li class="navbtn">
                <a href="<?= BASE_URL ?>/friends.php">Friends</a>
            </li>
            <li class="navbtn">
                <a href="<?= BASE_URL ?>/myprofile.php">My Profile</a>
            </li>
            <li class="navbtn">
                <a href="<?= BASE_URL ?>/addpalz.php">Add Palz</a>
            </li>
        <?php else: ?>
            <!-- Show only if the user is NOT logged in -->
            <li class="navbtn">
                <a href="<?= BASE_URL ?>/createaccount.php">Join Now</a>
            </li>
        <?php endif; ?>
        <?php if (isset($_SESSION['role'])): ?>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <li class="navbtn">
                    <a href="<?= BASE_URL ?>/admin/index.php">Admin</a>
                </li>
            <?php endif; ?>
        <?php endif; ?>
    </ul>
</div>