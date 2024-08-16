<?php 
// shortcode to display the Salah calendar and form.
function sr_display_salah_calendar() {
    ob_start();

    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;

        echo '<div id="salah-calendar">';
        echo '<form id="salah-recorder-form" method="post">';
        echo '<div class="clander-save">';
        echo '<input type="submit" value="Save">';
        echo '</div>';
        echo '<div class="clander-display">';

        // Fetch saved records
        $args = array(
            'post_type' => 'salah_record',
            'post_status' => 'publish',
            'author' => $user_id,
            'meta_key' => 'salah_prayers',
            'orderby' => 'post_date',
            'order' => 'ASC',
        );
        $query = new WP_Query($args);
        $saved_records = array();
        while ($query->have_posts()) {
            $query->the_post();
            $date = get_the_title();
            $prayers = get_post_meta(get_the_ID(), 'salah_prayers', true);
            $saved_records[$date] = $prayers;
        }
        wp_reset_postdata();

        // Display calendar
        for ($month = 1; $month <= 12; $month++) {
            for ($day = 1; $day <= 31; $day++) {
                if (checkdate($month, $day, 2024)) {
                    $date = sprintf('2024-%02d-%02d', $month, $day);
                    $checked_prayers = isset($saved_records[$date]) ? $saved_records[$date] : array();
                    echo '<div class="salah-day" data-date="' . $date . '">';
                    echo '<h3>' . date('F d, Y', mktime(0, 0, 0, $month, $day, 2024)) . '</h3>';
                    echo '<input type="checkbox" name="fajr[' . $month . '-' . $day . ']" value="1"' . (isset($checked_prayers['fajr']) ? ' checked' : '') . '> Fajr';
                    echo '<input type="checkbox" name="dhuhr[' . $month . '-' . $day . ']" value="1"' . (isset($checked_prayers['dhuhr']) ? ' checked' : '') . '> Dhuhr';
                    echo '<input type="checkbox" name="asr[' . $month . '-' . $day . ']" value="1"' . (isset($checked_prayers['asr']) ? ' checked' : '') . '> Asr';
                    echo '<input type="checkbox" name="maghrib[' . $month . '-' . $day . ']" value="1"' . (isset($checked_prayers['maghrib']) ? ' checked' : '') . '> Maghrib';
                    echo '<input type="checkbox" name="isha[' . $month . '-' . $day . ']" value="1"' . (isset($checked_prayers['isha']) ? ' checked' : '') . '> Isha';
                    echo '</div>';
                }
            }
        }
        echo '</div>';
        echo '</form>';
        echo '</div>';
        
    } else {
        echo '<p>Please log in to record your prayers.</p>';
    }

    return ob_get_clean();
}
add_shortcode('salah_calendar', 'sr_display_salah_calendar');
