<?php
$user_id = $_GET['id'] ?? null;

if (!$user_id || !is_numeric($user_id)) {
    echo "Invalid User ID.";
    exit;
}

// Fetch user details
$sql_user = "SELECT id, username, email, created_at, role FROM users WHERE id = ?";
$stmt_user = $connection->prepare($sql_user); // Correct variable name here
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

// Check if user exists
if ($result_user->num_rows === 0) {
    echo "User not found.";
    exit;
}

// Fetch the user data
$user = $result_user->fetch_assoc();

// Free result sets and close statements
$stmt_user->close();

?>

<div class="nk-content ">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">User Details</h3>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="./users.php" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                            <a href="./users.php" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
                        </div>
                    </div>
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-lg-4 col-xl-4 col-xxl-3">
                            <div class="card card-bordered">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="user-card user-card-s2">
                                            <div class="user-avatar lg bg-primary">
                                                <span><?= substr($user['username'], 0, 3); ?></span>
                                            </div>
                                            <div class="user-info">
                                                <div class="badge bg-light rounded-pill ucap"><?= $user['role']; ?></div>
                                                <h5><?= $user['username']; ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner">
                                        <h6 class="lead-text mb-3">Details</h6>
                                        <div class="row g-3">
                                            <div class="col-sm-6 col-md-4 col-lg-12">
                                                <span class="sub-text">ID</span>
                                                <span><?= $user['id']; ?></span>
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-12">
                                                <span class="sub-text">Email</span>
                                                <span><?= $user['email']; ?></span>
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-12">
                                                <span class="sub-text">Created At</span>
                                                <span><?= $user['created_at']; ?></span>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                </div>
                            </div>
                        </div><!-- .col -->
                        <div class="col-lg-8 col-xl-8 col-xxl-9">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="nk-block">
                                        <h6 class="lead-text mb-3">Other</h6>
                                        <div class="row g-3">
                                            <?php /* <div class="col-xl-12 col-xxl-6">
                                                <div class="card card-bordered">
                                                    <div class="card-inner">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <div class="ms-3">
                                                                    <h6 class="lead-text">Added Palz</h6>
                                                                    <span class="sub-text"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .col -->
                                            <div class="col-xl-12 col-xxl-6">
                                                <div class="card card-bordered">
                                                    <div class="card-inner">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <div class="ms-3">
                                                                    <h6 class="lead-text">Liked Palz</h6>
                                                                    <span class="sub-text"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .col --> */ ?>
                                            <div class="col-xl-12 col-xxl-6">
                                                <div class="card card-bordered">
                                                    <div class="card-inner">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <div class="ms-3">
                                                                    <h6 class="lead-text">Options</h6>
                                                                    <div class="nk-block-actions flex-shrink-0">
                                                                        <a href="#" class="btn btn-lg btn-danger delete-btn" data-id="<?= $user['id']; ?>" data-table="users">Delete User</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- .col -->
                                        </div><!-- .row -->
                                    </div>
                                </div><!-- .card -->
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>