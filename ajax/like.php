<?php

session_start();

?>

<script>
    $(document).ready(function() {
        $('.like-btn').on('click', function() {
            var palz_id = $(this).data('palz-id'); // Get the palz_id from the button's data attribute
            var $likeBtn = $(this); // Reference to the like button
            var $likeCount = $(this).next('.like-count'); // Reference to the like count span

            // AJAX request
            $.ajax({
                url: './ajax/likes_handler.php',
                type: 'POST',
                data: {
                    "palz_id": palz_id,
                    "user_id": <?= $_SESSION['id']; ?>
                },
                success: function(response) {
                    response = response.trim();
                    console.log(response);

                    if (response === 'like_added') {
                        // Update the button text and like count when a like is added
                        $likeBtn.text('Unlike');
                        $likeCount.text(parseInt($likeCount.text()) + 1 + " Likes");
                    } else if (response === 'like_removed') {
                        // Update the button text and like count when a like is removed
                        $likeBtn.text('Like');
                        $likeCount.text(parseInt($likeCount.text()) - 1 + " Likes");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error occurred: " + error);
                }
            });
        });
    });
</script>