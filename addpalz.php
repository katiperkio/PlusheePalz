<?php

$page_title = 'Add Palz';
include 'inc/header_inc.php';
$sql = "SELECT * FROM nature";
$result = mysqli_query($connection, $sql);

?>

<form action="./database/db_addpalz.php" method="POST">
    <label for="palz_name">Pal's name</label>
    <input type="text" id="palz_name" name="palz_name" required>
    <label for="palz_age">Pal's age</label>
    <input type="text" id="palz_age" name="palz_age">
    <div class="select_nature">
        <label for="palz_nature">What is your pal like?</label>
        <select id="palz_nature" name="palz_nature" multiple="multiple" placeholder="Choose traits">
            <?php
            if (mysqli_num_rows($result) > 0) { // Check if the query has results
                while ($row = mysqli_fetch_assoc($result)) { // Go through each row in the results

                    echo "<option value=" . $row["nature"] . ">" . $row["nature"] . "</option>";
                }
            }
            ?>
        </select>
    </div>
</form>


<?php

include 'inc/footer_inc.php';

?>