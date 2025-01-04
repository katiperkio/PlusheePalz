<?php

$page_title = 'Home';
include 'inc/header_inc.php';

$user_id = $_SESSION['id'] ?? null;

$sql = "SELECT palz.id, palz.name, palz.age, palz.birthday, palz.image_url, 
               COALESCE(COUNT(user_likes.palz_id), 0) AS like_count,
               MAX(user_likes.user_id = ?) AS isLiked
        FROM palz
        LEFT JOIN user_likes ON palz.id = user_likes.palz_id
        WHERE palz.status = 'published'
        GROUP BY palz.id";

$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<div class="cards">';
    while ($row = $result->fetch_assoc()) {

        $palz_id = $row['id'] ?? NULL;
        $nature_sql = "SELECT nature.nature
                       FROM palz_nature
                       INNER JOIN nature ON palz_nature.nature_id = nature.id
                       WHERE palz_nature.palz_id = ?
                       ORDER BY nature.nature";

        $nature_stmt = $connection->prepare($nature_sql);
        $nature_stmt->bind_param("i", $palz_id);
        $nature_stmt->execute();
        $result_nature = $nature_stmt->get_result();
?>

        <div class="card">
            <div class="palz_img"><img src="<?= $row["image_url"]; ?>" /></div>
            <h3 class="my-1"><?= htmlspecialchars($row['name']); ?></h3>
            <div class="card-body">
                <div>
                    <p>I am
                        <?php if ($palz_id !== NULL) {
                            if ($result_nature->num_rows > 0) {
                                $natures = [];
                                while ($row_nature = $result_nature->fetch_assoc()) {
                                    $natures[] = htmlspecialchars($row_nature['nature']);
                                }
                                echo implode(', ', $natures);
                            }
                        }
                        ?>
                    </p>
                </div>

                <?php
                $birthday = $row['birthday'];
                $staticAge = $row['age'];

                // Check if the birthday is provided
                if (!empty($birthday)) {
                    $birthdayDateTime = new DateTime($birthday);
                    $today = new DateTime();
                    $age = $today->diff($birthdayDateTime)->y;
                ?>
                    <div>
                        <p>My birthday is <?= $birthdayDateTime->format("d.m.Y") ?></p>
                    </div>
                    <div>
                        <p>Age: <?= $age; ?></p>
                    </div>
                <?php } elseif (!empty($staticAge)) {
                    // If no birthday, use the static age 
                ?>
                    <div>
                        <p>Age: <?= $staticAge; ?></p>
                    </div>
                <?php } ?>

                <div class="palz_likes">

                    <?php $buttonText = $row['isLiked'] ? 'Unlike' : 'Like'; ?>
                    <button class="like-btn" data-palz-id="<?= $palz_id; ?>">
                        <?= $buttonText; ?></button>

                    <span class="like-count"><?= $row['like_count']; ?> Likes</span>

                </div> <!-- .palz_likes -->
            </div> <!-- .card-body -->
        </div> <!-- .card -->

    <?php
        $result_nature->free();
        $nature_stmt->close();
    } ?>
    </div> <!-- Closing the cards container -->
<?php } else { ?>
    <div>
        <p>No palz yet.</p>
    </div>
<?php }

$result->free();
$stmt->close();

mysqli_close($connection);

include 'inc/footer_inc.php';
?>