<?php

add_action('wp_enqueue_scripts', function () {

    wp_register_script('load-more-posts', get_template_directory_uri() . '/assets/js/load-more-posts.js', [], null,
        true);

    wp_localize_script('load-more-posts', 'jpAjax', [
        'action' => 'load_more_posts',
        'nonce' => wp_create_nonce('load_more_posts_action'),
        'url' => admin_url('admin-ajax.php'),
    ]);

    if (is_front_page() || is_archive()) {
        wp_enqueue_script('load-more-posts');
    }
});

if (wp_doing_ajax()) {
    add_action('wp_ajax_load_more_posts', 'jp_ajax_load_more_posts_callback');
    add_action('wp_ajax_nopriv_load_more_posts', 'jp_ajax_load_more_posts_callback');
}

function jp_ajax_load_more_posts_callback()
{
    check_ajax_referer('load_more_posts_action', 'nonce');

    $data = [];

    if (true) {
        wp_send_json_success($data, 200);
    } else {
        wp_send_json_error($data, 404);
    }

    wp_die();
}
