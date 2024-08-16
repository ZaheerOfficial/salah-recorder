<?php 
// Register the Salah custom post type.
function sr_register_salah_post_type() {
    $args = array(
        'public' => false,
        'label'  => 'Salah Records',
        'supports' => array('title', 'author'),
        'capability_type' => 'post',
        'map_meta_cap' => true,
    );
    register_post_type('salah_record', $args);
}
add_action('init', 'sr_register_salah_post_type');