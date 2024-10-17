<?php

$page_title = 'Add Palz';
include 'inc/header_inc.php';
$sql = "SELECT * FROM nature";
$result = mysqli_query($connection, $sql);

?>

<form>
    <div>
        <select id="palz_nature" name="palz_nature" multiple="multiple" placeholder="What is your pal like?">
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