<?php
$palz_id = $_GET['id'] ?? null;

if (!$palz_id || !is_numeric($palz_id)) {
    echo "Invalid Palz ID.";
    exit;
}

// Fetch Palz details
$sql_palz = "SELECT * FROM palz WHERE id = ?";
$stmt_palz = $connection->prepare($sql_palz);
$stmt_palz->bind_param("i", $palz_id);
$stmt_palz->execute();
$result_palz = $stmt_palz->get_result();
$palz = $result_palz->fetch_assoc();

if (!$palz) {
    echo "Palz not found.";
    exit;
}

// Fetch Palz traits (nature)
$sql_traits = "SELECT n.nature 
               FROM palz_nature pn 
               JOIN nature n ON pn.nature_id = n.id 
               WHERE pn.palz_id = ?";
$stmt_traits = $connection->prepare($sql_traits);
$stmt_traits->bind_param("i", $palz_id);
$stmt_traits->execute();
$result_traits = $stmt_traits->get_result();
$traits = [];
while ($row = $result_traits->fetch_assoc()) {
    $traits[] = $row['nature'];
}

// Fetch Palz preferences (likes and dislikes)
$sql_preferences = "SELECT pp.type, p.name 
                    FROM palz_preferences pp 
                    JOIN preferences p ON pp.preference_id = p.id 
                    WHERE pp.palz_id = ?";
$stmt_preferences = $connection->prepare($sql_preferences);
$stmt_preferences->bind_param("i", $palz_id);
$stmt_preferences->execute();
$result_preferences = $stmt_preferences->get_result();
$favorites = [];
$dislikes = [];
while ($row = $result_preferences->fetch_assoc()) {
    if ($row['type'] === 'like') {
        $favorites[] = $row['name'];
    } elseif ($row['type'] === 'dislike') {
        $dislikes[] = $row['name'];
    }
}

// Free result sets and close statements
$result_palz->free();
$result_traits->free();
$result_preferences->free();
$stmt_palz->close();
$stmt_traits->close();
$stmt_preferences->close();
?>

<div class="nk-content ">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Palz Details</h3>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="./palz.php" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                            <a href="./palz.php" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em class="icon ni ni-arrow-left"></em></a>
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
                                                <img src="<?= $row['image_url']; ?>">
                                            </div>
                                            <div class="user-info">
                                                <div class="badge bg-light rounded-pill ucap"><?= $palz['status']; ?></div>
                                                <h5><?= $palz['name']; ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner">
                                        <h6 class="lead-text mb-3">Details</h6>
                                        <div class="row g-3">
                                            <div class="col-sm-6 col-md-4 col-lg-12">
                                                <span class="sub-text">ID</span>
                                                <span><?= $palz['id']; ?></span>
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-12">
                                                <span class="sub-text">Age</span>
                                                <span><?= $palz['age']; ?></span>
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-12">
                                                <span class="sub-text">Birthday</span>
                                                <span><?= $palz['birthday']; ?></span>
                                            </div>
                                            <div class="col-sm-6 col-md-4 col-lg-12">
                                                <span class="sub-text">Likes Count</span>
                                                <span><?= $palz['likes_count']; ?></span>
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
                                        <h6 class="lead-text mb-3">Attributes</h6>
                                        <div class="row g-3">
                                            <div class="col-xl-12 col-xxl-6">
                                                <div class="card card-bordered">
                                                    <div class="card-inner">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <div class="ms-3">
                                                                    <h6 class="lead-text">Traits</h6>
                                                                    <span class="sub-text"><?= !empty($traits) ? htmlspecialchars(implode(', ', $traits)) : 'Not available'; ?></span>
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
                                                                    <h6 class="lead-text">Favorites</h6>
                                                                    <span class="sub-text"><?= !empty($favorites) ? htmlspecialchars(implode(', ', $favorites)) : 'Not available'; ?></span>
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
                                                                    <h6 class="lead-text">Dislikes</h6>
                                                                    <span class="sub-text"><?= !empty($dislikes) ? htmlspecialchars(implode(', ', $dislikes)) : 'Not available'; ?></span>
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
                                                                    <h6 class="lead-text">Options</h6>
                                                                    <div class="nk-block-actions flex-shrink-0">
                                                                        <a href="#" class="btn btn-lg btn-danger delete-btn" data-id="<?= $palz['id']; ?>" data-table="palz">Delete Palz</a>
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