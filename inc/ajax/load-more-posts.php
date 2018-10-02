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

    //var_dump($_POST);

    $data = [];

    $args = [
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => get_option('posts_per_page'),
        'order' => 'DESC',
        'orderby' => 'date',
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            global $post;

            //dd($post);

            $data[] = [
                'id' => get_the_ID(),
                'date' => get_the_date(),
                'title' => get_the_title(),
                'excerpt' => get_the_excerpt(),
                'content' => get_the_content(),
                'permalink' => get_permalink(),
                'attachment' => get_post_image_sizes(),
            ];
        }
        wp_reset_postdata();
    }

    if (true) {
        wp_send_json_success($data, 200);
    } else {
        wp_send_json_error($data, 404);
    }

    wp_die();
}

function get_post_image_sizes()
{
    $image_sizes = get_intermediate_image_sizes();

    $thumbnails = [];

    foreach ($image_sizes as $size) {

        $thumbnail_id = get_post_thumbnail_id();
        $image = wp_get_attachment_image_src($thumbnail_id, $size);

        if ($image) {
            list($src, $width, $height) = $image;
            $thumbnail = [
                'src' => $src,
                'alt' => trim(strip_tags(get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true))),
                'width' => $width,
                'height' => $height,
            ];


            $thumbnails[$size] = $thumbnail;
        }
    }

    return $thumbnails;
}

