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

if ($result->num_rows > 0) { // Check if the query has results
    echo '<div class="cards">'; // Wrapping all cards inside a container div
    while ($row = $result->fetch_assoc()) { // Go through each row in the results

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

        echo '<div class="card">'; // Print the values inside a card
        echo '<div class="palz_img"><img src="' . $row["image_url"] . '"/></div>';
        echo "<h3>" . htmlspecialchars($row['name']) . "</h3><br>";
        echo "I am ";
        if ($palz_id !== NULL) {
            if ($result_nature->num_rows > 0) {
                $natures = []; // Initialize an empty array to store the nature values
                while ($row_nature = $result_nature->fetch_assoc()) {
                    $natures[] = htmlspecialchars($row_nature['nature']); // Collect nature values
                }
                echo implode(', ', $natures); // Print nature values as a comma-separated string
            }
        }
        echo "<br>";

        // Assume $row contains data from the database
        $birthday = $row['birthday'];
        $staticAge = $row['age']; // Static age field in the database (optional)

        // Check if the birthday is provided
        if (!empty($birthday)) {
            // Convert the birthday to a DateTime object
            $birthdayDateTime = new DateTime($birthday);

            // Get the current date
            $today = new DateTime();

            // Calculate the age
            $age = $today->diff($birthdayDateTime)->y;

            // Display the results
            echo "My birthday is " . $birthdayDateTime->format("d.m.Y") . "<br>";
            echo "Age: $age<br>";
        } elseif (!empty($staticAge)) {
            // If no birthday, use the static age
            echo "Age: $staticAge<br>";
        } else {
            // No birthday or static age set
            echo "Age information not available.<br>";
        }

        echo '<div class="palz_likes">';

        $buttonText = $row['isLiked'] ? 'Unlike' : 'Like';
        echo '<button class="like-btn" data-palz-id="' . $palz_id . '">'
            . $buttonText . '</button>';

        echo '<span class="like-count">' . $row['like_count'] . ' Likes</span>';

        echo '</div>'; //closing likes
        echo '</div>'; //closing a card

        $result_nature->free();
        $nature_stmt->close();
    }
    echo '</div>'; // Closing the cards container
} else {
    echo "No palz yet.";
}

$result->free();
$stmt->close();

mysqli_close($connection);

?>

        <?php
        include 'inc/footer_inc.php';
        ?>