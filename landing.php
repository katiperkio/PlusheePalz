<?php

$page_title = 'Home';
include 'inc/header_inc.php';

$sql = "SELECT id, name, description, age, image_url FROM palz WHERE status='published'";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) { // Check if the query has results
    echo '<div class="cards">'; // Wrapping all cards inside a container div
    while ($row = mysqli_fetch_assoc($result)) { // Go through each row in the results

        $palz_id = $row['id'] ?? NULL;
        $nature_sql = "SELECT nature.nature
            FROM palz_nature
            INNER JOIN palz ON palz_nature.palz_id = palz.id
            INNER JOIN nature ON palz_nature.nature_id = nature.id
            WHERE palz.id = $palz_id ORDER BY nature.nature";

        echo '<div class="card">'; // Print the values inside a card
        echo "<div class='palz_img'><img src=" . $row['image_url'] . "/></div>";
        echo "<h3>" . $row['name'] . "</h3><br>";
        echo "Millainen olen: ";
        if ($palz_id !== NULL) {
            $result_nature = mysqli_query($connection, $nature_sql);
            if (mysqli_num_rows($result_nature) > 0) {
                $natures = []; // Initialize an empty array to store the nature values
                while ($row_nature = mysqli_fetch_assoc($result_nature)) {
                    $natures[] = $row_nature['nature']; // Collect nature values
                }
                echo implode(', ', $natures); // Print nature values as a comma-separated string
            }
        }
        echo "<br>";


        /* echo "Syntymäpäiväni: " . $row['age'] . "<br>"; */
        echo "Syntymäpäiväni: " . date("j.n.Y", strtotime($row['age'])) . "<br>";
        echo '</div>';
    }
    echo '</div>'; // Closing the cards container
} else {
    echo "Ei tuloksia.";
}

mysqli_free_result($result); // Free the results

mysqli_close($connection); // Close database connection

include 'inc/footer_inc.php';
