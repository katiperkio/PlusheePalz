$(function() {
    // Function to sort options alphabetically
    function sortOptions(selectElement) {
        const options = $(selectElement).find('option');
        options.sort(function(a, b) {
            return a.text.localeCompare(b.text);
        });
        $(selectElement).empty().append(options); // Re-attach sorted options
    }

    // Sort options for each select element
    sortOptions('#palz_loves');
    sortOptions('#palz_hates');
    sortOptions('#palz_nature');

    // Initialize each SumoSelect independently
    $('#palz_loves').SumoSelect({
        max: 5,
        triggerChangeCombined: false
    });

    $('#palz_hates').SumoSelect({
        max: 5,
        triggerChangeCombined: false
    });

    $('#palz_nature').SumoSelect({
        max: 5,
        triggerChangeCombined: false
    });
    
    // Function to disable selected items in the opposite dropdown
    function syncSelections() {
        const selectedLoves = $('#palz_loves').val() || [];
        const selectedHates = $('#palz_hates').val() || [];

        // Disable items in #palz_hates that are selected in #palz_loves
        $('#palz_hates option').each(function() {
            $(this).prop('disabled', selectedLoves.includes($(this).val()));
        });

        // Disable items in #palz_loves that are selected in #palz_hates
        $('#palz_loves option').each(function() {
            $(this).prop('disabled', selectedHates.includes($(this).val()));
        });

        // Manually update SumoSelect displays
        $('#palz_loves')[0].sumo.reload();
        $('#palz_hates')[0].sumo.reload();
    }

    // Event listeners to trigger sync on selection change without closing the dropdown
    $('#palz_loves').on('change', syncSelections);
    $('#palz_hates').on('change', syncSelections);
});
