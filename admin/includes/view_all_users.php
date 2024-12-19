<div class="card card-bordered card-full">
    <div class="card-inner">
        <div class="card-title-group">
            <div class="card-title">
                <h6 class="title"><span class="me-2">Users</span></h6>
            </div>
            <div class="card-tools">
                <ul class="card-tools-nav">
                    <li class="<?= (isset($_GET['role']) && $_GET['role'] === 'guest') ? 'active' : ''; ?>">
                        <a href="?role=guest"><span>Guest</span></a>
                    </li>
                    <li class="<?= (isset($_GET['role']) && $_GET['role'] === 'admin') ? 'active' : ''; ?>">
                        <a href="?role=admin"><span>Admin</span></a>
                    </li>
                    <li class="<?= (!isset($_GET['role']) || $_GET['role'] === 'all') ? 'active' : ''; ?>">
                        <a href="?role=all"><span>All</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-inner p-0 border-top">
        <div class="nk-tb-list nk-tb-orders">
            <div class="nk-tb-item nk-tb-head">
                <div class="nk-tb-col"><span>ID</span></div>
                <div class="nk-tb-col tb-col-sm"><span>Username</span></div>
                <div class="nk-tb-col tb-col-sm"><span>Email</span></div>
                <div class="nk-tb-col tb-col-md"><span>Registered At</span></div>
                <div class="nk-tb-col tb-col-lg"><span>Role</span></div>
                <div class="nk-tb-col"><span>&nbsp;</span></div>
            </div>
            <?php

            // Get the selected role from the URL or set to 'all' by default
            $role = isset($_GET['role']) ? $_GET['role'] : 'all';

            // Build the SQL query dynamically based on the selected role
            if ($role === 'guest') {
                $sql = "SELECT id, username, email, created_at, role FROM users WHERE role = 'guest'";
            } elseif ($role === 'admin') {
                $sql = "SELECT id, username, email, created_at, role FROM users WHERE role = 'admin'";
            } else {
                $sql = "SELECT id, username, email, created_at, role FROM users"; // Default: show all users
            }

            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $created_at = new DateTimeImmutable($row['created_at']);
                    $formattedDate = $created_at->format("d.m.Y");
            ?>
                    <div class="nk-tb-item" data-id="<?= $row['id']; ?>">
                        <div class="nk-tb-col">
                            <span class="tb-lead"><a href="#">#<?= $row['id']; ?></a></span>
                        </div>

                        <div class="nk-tb-col tb-col-sm">
                            <div class="user-card">
                                <div class="user-avatar user-avatar-sm bg-purple">
                                    <span><?= substr($row['username'], 0, 3); ?></span>
                                </div>
                                <div class="user-name">
                                    <span class="tb-lead"><?= htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="nk-tb-col tb-col-md">
                            <span class="tb-sub"><?= $row['email']; ?></span>
                        </div>

                        <div class="nk-tb-col tb-col-sm">
                            <span class="tb-sub"><?= $formattedDate; ?></span>
                        </div>

                        <div class="nk-tb-col tb-col-sm">
                            <span class="tb-sub text-primary"><?= $row['role']; ?></span>
                        </div>

                        <div class="nk-tb-col nk-tb-col-action">
                            <div class="dropdown">
                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                    <ul class="link-list-plain">
                                        <li><a href="userprofile.php?id=<?= $row['id']; ?>">View User</a></li>
                                        <li><a href="#" class="edit-role-btn" data-id="<?= $row['id']; ?>" data-role="<?= $row['role']; ?>">Edit Role</a></li>
                                        <li><a href="#" class="delete-btn" data-id="<?= $row['id']; ?>" data-table="users" style="color: red;">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div> <!-- .nk-tb-col .nk-tb-col-action -->
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
    <div class="card-inner-sm border-top text-center d-sm-none">
        <a href="#" class="btn btn-link btn-block">See History</a>
    </div>
</div><!-- .card -->