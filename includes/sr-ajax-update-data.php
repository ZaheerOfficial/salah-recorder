<?php

// Handle AJAX request to save Salah records
function sr_save_salah_record() {
    if (!isset($_POST['salahData'])) {
        wp_send_json_error('No data received');
        return;
    }

    $salah_data = $_POST['salahData'];
    $user_id = get_current_user_id();

    // Delete previous records
    $args = array(
        'post_type' => 'salah_record',
        'post_status' => 'publish',
        'author' => $user_id,
        'meta_key' => 'salah_prayers',
        'orderby' => 'post_date',
        'order' => 'ASC',
    );
    $query = new WP_Query($args);
    while ($query->have_posts()) {
        $query->the_post();
        wp_delete_post(get_the_ID(), true);
    }
    wp_reset_postdata();

    // Insert new records
    foreach ($salah_data as $date => $prayers) {
        $post_id = wp_insert_post(array(
            'post_type' => 'salah_record',
            'post_title' => $date,
            'post_status' => 'publish',
            'post_author' => $user_id,
        ));
        
        if ($post_id) {
            update_post_meta($post_id, 'salah_prayers', $prayers);
        }
    }

    wp_send_json_success('Salah records saved');
}
add_action('wp_ajax_save_salah_record', 'sr_save_salah_record');
