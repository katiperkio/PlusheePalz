<script>
    $(document).ready(function() {
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();

            var entryId = $(this).data('id');
            var table = $(this).data('table');

            console.log('Clicked delete for ID:', entryId, 'Table:', table);

            if (confirm('Are you sure you want to delete this entry?')) {
                $(this).prop('disabled', true);

                sendDeleteRequest(entryId, table, $(this));
            }
        });

        function sendDeleteRequest(id, table, buttonElement) {
            $.ajax({
                url: './assets/ajax_custom/delete_handler.php',
                type: 'POST',
                data: {
                    id: id,
                    table: table
                },
                success: function(response) {
                    response = response.trim();
                    console.log('AJAX response:', response);

                    if (response === 'success') {
                        $(`div[data-id="${id}"]`).fadeOut(300, function() {
                            $(this).remove();
                        });
                        alert("Entry deleted successfully.");
                    } else {
                        alert(response || "Failed to delete entry. Please try again.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });
                    alert("An unexpected error occurred. Please try again.");
                },
                complete: function() {
                    buttonElement.prop('disabled', false);
                }
            });
        }
    });
</script>