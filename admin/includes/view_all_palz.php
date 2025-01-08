<div class="card card-bordered card-full">
    <div class="card-inner">
        <div class="card-title-group">
            <div class="card-title">
                <h6 class="title"><span class="me-2">Palz</span></h6>
            </div>
            <div class="card-tools">
                <ul class="card-tools-nav">
                    <li class="<?= (isset($_GET['status']) && $_GET['status'] === 'published') ? 'active' : ''; ?>">
                        <a href="?status=published"><span>Published</span></a>
                    </li>
                    <li class="<?= (isset($_GET['status']) && $_GET['status'] === 'draft') ? 'active' : ''; ?>">
                        <a href="?status=draft"><span>Draft</span></a>
                    </li>
                    <li class="<?= (!isset($_GET['status']) || $_GET['status'] === 'all') ? 'active' : ''; ?>">
                        <a href="?status=all"><span>All</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-inner p-0 border-top">
        <div class="nk-tb-list nk-tb-orders">
            <div class="nk-tb-item nk-tb-head">
                <div class="nk-tb-col"><span>ID</span></div>
                <div class="nk-tb-col tb-col-sm"><span>Name</span></div>
                <div class="nk-tb-col tb-col-sm"><span>Age</span></div>
                <div class="nk-tb-col tb-col-md"><span>Birthday</span></div>
                <div class="nk-tb-col tb-col-lg"><span>Likes</span></div>
                <div class="nk-tb-col tb-col-lg"><span>Status</span></div>
                <div class="nk-tb-col"><span>&nbsp;</span></div>
            </div>
            <?php

            $status = isset($_GET['status']) ? $_GET['status'] : 'all';

            if ($status === 'published') {
                $sql = "SELECT * FROM palz WHERE status = 'published'";
            } elseif ($status === 'draft') {
                $sql = "SELECT * FROM palz WHERE status = 'draft'";
            } else {
                $sql = "SELECT * FROM palz";
            }

            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $formattedDate = null;

                    if (!empty($row['birthday'])) {
                        $created_at = new DateTimeImmutable($row['birthday']);
                        $formattedDate = $created_at->format("d.m.Y");
                    }
            ?>

                    <div class="nk-tb-item" data-id="<?= $row['id']; ?>">
                        <div class="nk-tb-col">
                            <span class="tb-lead"><a href="#">#<?= $row['id']; ?></a></span>
                        </div>

                        <div class="nk-tb-col tb-col-sm">
                            <div class="user-card">
                                <div class="user-avatar user-avatar-sm bg-purple" style="background: url('<?= $row['image_url']; ?>') !important; background-position: center; background-repeat: no-repeat !important; background-size: cover !important;">
                                    <!-- <span><img src="<?= $row['image_url']; ?>"> </span> -->
                                </div>
                                <div class="user-name">
                                    <span class="tb-lead"><?= $row['name']; ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="nk-tb-col tb-col-md">
                            <span class="tb-sub"><?= $row['age']; ?></span>
                        </div>

                        <div class="nk-tb-col tb-col-sm">
                            <span class="tb-sub"><?= $formattedDate; ?></span>
                        </div>

                        <div class="nk-tb-col tb-col-sm">
                            <span class="tb-sub text-primary"><?= $row['likes_count']; ?></span>
                        </div>

                        <div class="nk-tb-col tb-col-sm">
                            <?php
                            // Determine the CSS class based on the status
                            $statusClass = '';
                            if ($row['status'] === 'published') {
                                $statusClass = 'text-success'; // Green font for published
                            } elseif ($row['status'] === 'draft') {
                                $statusClass = 'text-warning'; // Orange font for draft
                            }
                            ?>
                            <span class="tb-sub <?= $statusClass; ?>"><?= ucfirst($row['status']); ?></span>
                        </div>

                        <div class="nk-tb-col nk-tb-col-action">
                            <div class="dropdown">
                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                    <ul class="link-list-plain">
                                        <li><a href="palzprofile.php?id=<?= $row['id']; ?>">View Palz</a></li>
                                        <li><a href="#" class="edit-status-btn" data-id="<?= $row['id']; ?>" data-status="<?= $row['status']; ?>">Edit Status</a></li>
                                        <li><a href="#" class="delete-btn" data-id="<?= $row['id']; ?>" data-table="palz" style="color: red;">Delete</a></li>
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