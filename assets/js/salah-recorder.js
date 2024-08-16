jQuery(document).ready(function ($) {
    $('#salah-recorder-form').on('submit', function (e) {
        e.preventDefault();

        // Gather all the checked prayers
        var salahData = {};
        $('#salah-calendar .salah-day').each(function () {
            var date = $(this).data('date');
            var prayers = {};
            $(this).find('input:checked').each(function () {
                prayers[$(this).attr('name').split('[')[0]] = 1;
            });
            if (Object.keys(prayers).length > 0) {
                salahData[date] = prayers;
            }
        });

        $.ajax({
            url: salahRecorderAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'save_salah_record',
                salahData: salahData,
            },
            success: function (response) {
                if (response.success) {
                    alert('Salah records saved successfully.');
                } else {
                    alert('There was an error saving your Salah records.');
                }
            },
            error: function () {
                alert('There was an error saving your Salah records.');
            }
        });
    });
});
window.history.replaceState(null, null, window.location.href);
