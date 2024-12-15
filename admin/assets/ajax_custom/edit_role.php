<script>
    $(document).ready(function() {
        $(document).on('click', '.edit-role-btn', function(e) {
            e.preventDefault();

            var userId = $(this).data('id'); // Get the user ID
            var currentRole = $(this).data('role'); // Get the current role

            // Ask for the new role
            var newRole = prompt("Enter new role (admin/guest):", currentRole);

            // Validate the new role
            if (newRole && (newRole === 'admin' || newRole === 'guest')) {
                $.ajax({
                    url: './assets/ajax_custom/edit_role_handler.php', // Path to your backend handler
                    type: 'POST',
                    data: {
                        id: userId,
                        role: newRole
                    },
                    success: function(response) {
                        response = response.trim();
                        if (response === 'success') {
                            alert("Role updated successfully.");
                            location.reload(); // Reload to reflect the changes
                        } else {
                            alert("Failed to update role. Please try again.");
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
                alert("Invalid role. Please enter 'admin' or 'guest'.");
            }
        });
    });
</script>