<div class="card card-bordered card-full">
    <div class="card-inner">
        <div class="card-title-group">
            <div class="card-title">
                <h6 class="title"><span class="me-2">Preferences</span></h6>
            </div>
            <!--             <div class="card-tools">
                <ul class="card-tools-nav">
                </ul>
            </div> -->
        </div>
    </div>
    <div class="card-inner p-0 border-top">
        <div class="nk-tb-list nk-tb-orders">
            <div class="nk-tb-item nk-tb-head">
                <div class="nk-tb-col"><span>ID</span></div>
                <div class="nk-tb-col tb-col-sm"><span>Name</span></div>
                <div class="nk-tb-col tb-col-sm"><span>Favorites</span></div>
                <div class="nk-tb-col tb-col-sm"><span>Dislikes</span></div>
                <div class="nk-tb-col"><span>&nbsp;</span></div>
            </div>
            <?php

            $sql = "SELECT 
                        p.id AS palz_id,
                        p.name AS palz_name,
                        p.image_url AS palz_image_url,
                        GROUP_CONCAT(CASE WHEN pp.type = 'like' THEN pref.name END SEPARATOR ', ') AS likes,
                        GROUP_CONCAT(CASE WHEN pp.type = 'dislike' THEN pref.name END SEPARATOR ', ') AS dislikes
                    FROM 
                        palz p
                    LEFT JOIN 
                        palz_preferences pp 
                    ON 
                        pp.palz_id = p.id
                    LEFT JOIN 
                        preferences pref 
                    ON 
                        pp.preference_id = pref.id
                    GROUP BY 
                        p.id;";


            $stmt = $connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="nk-tb-item">
                        <div class="nk-tb-col">
                            <span class="tb-lead"><a href="#">#<?= $row['palz_id']; ?></a></span>
                        </div>

                        <div class="nk-tb-col tb-col-sm">
                            <div class="user-card">
                                <div class="user-avatar user-avatar-sm bg-purple">
                                    <?php if (!empty($row['palz_image_url'])): ?>
                                        <span><img src="<?= htmlspecialchars($row['palz_image_url']); ?>"></span>
                                    <?php else: ?>
                                        <span></span>
                                    <?php endif; ?>
                                </div>
                                <div class="user-name">
                                    <span class="tb-lead"><?= htmlspecialchars($row['palz_name']); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="nk-tb-col tb-col-md">
                            <span class="tb-sub"><?= htmlspecialchars($row['likes'] ?? 'None'); ?></span>
                        </div>

                        <div class="nk-tb-col tb-col-md">
                            <span class="tb-sub"><?= htmlspecialchars($row['dislikes'] ?? 'None'); ?></span>
                        </div>

                        <div class="nk-tb-col nk-tb-col-action">
                            <div class="dropdown">
                                <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                    <ul class="link-list-plain">
                                        <li><a href="palzprofile.php?id=<?= $row['palz_id']; ?>">View Palz</a></li>
                                        <li><a href="#">Edit Palz</a></li>
                                        <li><a href="#" class="delete-btn" data-id="<?= $row['palz_id']; ?>" data-table="palz" style="color: red;">Delete</a></li>
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