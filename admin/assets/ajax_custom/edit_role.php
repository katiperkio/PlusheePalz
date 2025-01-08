<script>
    $(document).ready(function() {
        $(document).on('click', '.edit-role-btn', function(e) {
            e.preventDefault();

            var userId = $(this).data('id');
            var currentRole = $(this).data('role');

            var newRole = prompt("Enter new role (admin/guest):", currentRole);

            if (newRole && (newRole === 'admin' || newRole === 'guest')) {
                $.ajax({
                    url: './assets/ajax_custom/edit_role_handler.php',
                    type: 'POST',
                    data: {
                        id: userId,
                        role: newRole
                    },
                    success: function(response) {
                        response = response.trim();
                        if (response === 'success') {
                            alert("Role updated successfully.");
                            location.reload();
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