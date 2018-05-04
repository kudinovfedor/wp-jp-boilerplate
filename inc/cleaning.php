<?php

/**
 * Disable the Emoji
 *
 * r@return void
 */
function jp_disable_emojis()
{
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('embed_head', 'print_emoji_detection_script');
    add_filter('emoji_svg_url', '__return_false');
    add_filter('tiny_mce_plugins', 'jp_disable_emojis_tinymce');
}

add_action('init', 'jp_disable_emojis');

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param array $plugins
 *
 * @return array Difference between the two arrays
 */
function jp_disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

/**
 * Disable head meta info
 */
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'wp_oembed_add_discovery_links');
//remove_action( 'wp_head', 'wp_resource_hints', 2);

/**
 * Remove generator field from RSS
 */
remove_action('app_head', 'the_generator');
remove_action('rss_head', 'the_generator');
remove_action('rss2_head', 'the_generator');
remove_action('atom_head', 'the_generator');
remove_action('opml_head', 'the_generator');
remove_action('rdf_header', 'the_generator');
remove_action('commentsrss2_head', 'the_generator');
remove_action('comments_atom_head', 'the_generator');

/**
 * Disable Links from User Comments
 */
remove_filter('comment_text', 'make_clickable', 9);

/**
 * Disable the admin bar
 */
//add_filter( 'show_admin_bar', '__return_false' );

/**
 * It removes a previously registered script.
 */
function jp_deregister_scripts()
{
    wp_dequeue_script('wp-embed');
}

add_action('wp_footer', 'jp_deregister_scripts');

/**
 * Remove wp version param from any enqueued scripts
 *
 * @param string $src Source path.
 *
 * @return string
 */
function jp_remove_wp_ver_css_js($src)
{
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }

    return $src;
}

add_filter('style_loader_src', 'jp_remove_wp_ver_css_js');
add_filter('script_loader_src', 'jp_remove_wp_ver_css_js');

/**
 * It removes from script and style (type='text/javascript' and type='text/css')
 *
 * @param $tag
 *
 * @return mixed
 */
function jp_remove_type_attr($tag)
{
    return preg_replace("/type=['\"]text\/(javascript|css)['\"]/", '', $tag);
}

add_filter('style_loader_tag', 'jp_remove_type_attr');
add_filter('script_loader_tag', 'jp_remove_type_attr');
