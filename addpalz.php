<?php

$page_title = 'Add Palz';
include 'inc/header_inc.php';

if (!isset($_SESSION['id'])) {
    die();
}

// Fetch nature traits
$sql_nature = "SELECT * FROM nature ORDER BY nature ASC;";
$stmt_nature = $connection->prepare($sql_nature);
$stmt_nature->execute();
$result_nature = $stmt_nature->get_result();

// Fetch preferences
$sql_preferences = "SELECT * FROM preferences ORDER BY name ASC;";
$stmt_preferences = $connection->prepare($sql_preferences);
$stmt_preferences->execute();
$result_preferences = $stmt_preferences->get_result();

?>

<div class="addpalz-wrap">
    <form action="./database/db_addpalz.php" method="POST" class="addpalz dropzone" enctype="multipart/form-data" id="submit_palz">
        <label for="palz_name">Pal's name</label>
        <input type="text" id="palz_name" name="palz_name" required>
        <label for="palz_age">Pal's age</label>
        <input type="text" id="palz_age" name="palz_age">
        <label for="palz_age">Pal's birthday (optional)</label>
        <input type="date" id="palz_birthday" name="palz_birthday">
        <br>

        <div class="select_nature">
            <label for="palz_nature">What is your pal like?</label>
            <select id="palz_nature" name="palz_nature[]" multiple="multiple" placeholder="Choose traits">
                <?php
                if ($result_nature->num_rows > 0) {
                    while ($row_nature = $result_nature->fetch_assoc()) {
                        echo "<option value='" . $row_nature['id'] . "'>" . htmlspecialchars($row_nature['nature']) . "</option>";
                    }
                }
                ?>
            </select>
            <br>
        </div>

        <div class="select_preferences">
            <label for="palz_loves">What things does your pal like?</label>
            <select id="palz_loves" name="palz_loves[]" multiple="multiple" placeholder="Choose favorites">
                <?php
                if ($result_preferences->num_rows > 0) {
                    while ($row_preferences = $result_preferences->fetch_assoc()) {
                        echo "<option value='" . $row_preferences['id'] . "'>" . htmlspecialchars($row_preferences['name']) . "</option>";
                    }
                }
                ?>
            </select>
            <br>

            <label for="palz_hates">What things does your pal dislike?</label>
            <select id="palz_hates" name="palz_hates[]" multiple="multiple" placeholder="Choose dislikes">
                <?php
                // Reset pointer and reuse the preferences for dislikes
                $result_preferences->data_seek(0);
                if ($result_preferences->num_rows > 0) {
                    while ($row_preferences = $result_preferences->fetch_assoc()) {
                        echo "<option value='" . $row_preferences['id'] . "'>" . htmlspecialchars($row_preferences['name']) . "</option>";
                    }
                }
                ?>
            </select>
            <br>
        </div>
        <div>
            <input type="file" name="file" id="dropzone" />
        </div>
        <button type="submit" class="add-btn">Add Palz</button>
    </form>
</div>

<script>
    Dropzone.autoDiscover = false;

    var myDropzone = newDropzone("#submit_palz", {
        url: "./database/db_addpalz.php",
        paramName: "file",
        maxFilesize: 10,
        acceptedFiles: "image/*",
        autoProcessQueue: false,
        maxFiles: 1,
        addRemoveLinks: true,
        init: function() {
            var dropzone = this;

            $("#submit_palz button").click(function(e) {
                e.preventDefault();

                if (dropzone.getQueuedFiles().length > 0) {
                    dropzone.processQueue();
                } else {
                    alert("Please select an image before submitting.");
                }
            });

            dropzone.on("success", function(file, response) {
                alert("Image uploaded sucessfully!");

                let formData = $("submit_palz").serialize();
                $.post("./database/db_addpalz.php", formData, function(data) {
                    alert("Pal successfully added!");
                    location.reload();
                }).fail(function() {
                    alert("Error submitting form data!");
                });
            });

            dropzone.on("error", function(file, message) {
                alert("Error uploading image: " + message);
            });
        }
    });
</script>

<?php

$result_preferences->free();
$stmt_preferences->close();

$result_nature->free();
$stmt_nature->close();

include 'inc/footer_inc.php';

?>