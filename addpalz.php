<?php

$page_title = 'Add Palz';
include 'inc/header_inc.php';

// Fetch nature traits
$sql_nature = "SELECT * FROM nature";
$stmt_nature = $connection->prepare($sql_nature);
$stmt_nature->execute();
$result_nature = $stmt_nature->get_result();

// Fetch preferences
$sql_preferences = "SELECT * FROM preferences";
$stmt_preferences = $connection->prepare($sql_preferences);
$stmt_preferences->execute();
$result_preferences = $stmt_preferences->get_result();

?>

<div class="addpalz-wrap">
    <form action="./database/db_addpalz.php" method="POST" class="addpalz">
        <label for="palz_name">Pal's name</label>
        <input type="text" id="palz_name" name="palz_name" required>
        <label for="palz_age">Pal's age</label>
        <input type="text" id="palz_age" name="palz_age">
        <br>

        <div class="select_nature">
            <label for="palz_nature">What traits does your pal have?</label>
            <select id="palz_nature" name="palz_nature[]" multiple="multiple" placeholder="Choose traits">
                <?php
                if ($result_nature->num_rows > 0) {
                    while ($row_nature = $result_nature->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row_nature['nature']) . "'>" . htmlspecialchars($row_nature['nature']) . "</option>";
                    }
                }
                ?>
            </select>
            <br>
        </div>

        <div class="select_preferences">
            <label for="palz_loves">What does your pal like?</label>
            <select id="palz_loves" name="palz_loves[]" multiple="multiple" placeholder="Choose likes">
                <?php
                if ($result_preferences->num_rows > 0) {
                    while ($row_preferences = $result_preferences->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row_preferences['name']) . "'>" . htmlspecialchars($row_preferences['name']) . "</option>";
                    }
                }
                ?>
            </select>
            <br>

            <label for="palz_hates">What does your pal dislike?</label>
            <select id="palz_hates" name="palz_hates[]" multiple="multiple" placeholder="Choose dislikes">
                <?php
                // Reset pointer and reuse the preferences for dislikes
                $result_preferences->data_seek(0);
                if ($result_preferences->num_rows > 0) {
                    while ($row_preferences = $result_preferences->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row_preferences['name']) . "'>" . htmlspecialchars($row_preferences['name']) . "</option>";
                    }
                }
                ?>
            </select>
            <br>
        </div>
        <button type="submit" class="add-btn">Add Palz</button>
    </form>
</div>

<?php

$result_preferences->free();
$stmt_preferences->close();

$result_nature->free();
$stmt_nature->close();

include 'inc/footer_inc.php';

?>