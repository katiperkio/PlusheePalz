<script>
    $(document).ready(function() {
        $(document).on('click', '.edit-status-btn', function(e) {
            e.preventDefault();

            var palzId = $(this).data('id');
            var currentStatus = $(this).data('status');

            var newStatus = prompt("Enter new status (published/draft):", currentStatus);

            if (newStatus && (newStatus === 'published' || newStatus === 'draft')) {
                $.ajax({
                    url: './assets/ajax_custom/edit_status_handler.php',
                    type: 'POST',
                    data: {
                        id: palzId,
                        status: newStatus
                    },
                    success: function(response) {
                        response = response.trim();
                        console.log("response: ", response);
                        if (response === 'success') {
                            alert("Status updated successfully.");
                            location.reload();
                        } else {
                            alert("Failed to update status. Please try again.", response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", {
                            status: status,
                            error: error,
                            response: xhr.responseText
                        });
                        alert("An unexpected error occurred. Please try again.");
                    }
                });
            } else {
                alert("Invalid status. Please enter 'published' or 'draft'.");
            }
        });
    });
</script>