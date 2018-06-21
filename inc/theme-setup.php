<?php

function jp_theme_setup()
{
    load_theme_textdomain('joompress', get_template_directory() . '/languages');

    if (function_exists('add_theme_support')) {
        add_theme_support('post-formats', array(
            'aside',
            'gallery',
            'link',
            'image',
            'quote',
            'status',
            'video',
            'audio',
            'chat',
        ));

        add_theme_support('post-thumbnails');

        add_theme_support('custom-background', array(
            'default-image'          => '',
            'default-preset'         => 'default',
            'default-position-x'     => 'center',
            'default-position-y'     => 'center',
            'default-size'           => 'cover',
            'default-repeat'         => 'no-repeat',
            'default-attachment'     => 'scroll',
            'default-color'          => '',
            'wp-head-callback'       => '_custom_background_cb',
            'admin-head-callback'    => '',
            'admin-preview-callback' => '',
        ));

        add_theme_support('custom-header', array(
            'default-image'          => '',
            'random-default'         => false,
            'width'                  => 0,
            'height'                 => 0,
            'flex-height'            => false,
            'flex-width'             => false,
            'default-text-color'     => '',
            'header-text'            => true,
            'uploads'                => true,
            'wp-head-callback'       => '',
            'admin-head-callback'    => '',
            'admin-preview-callback' => '',
            'video'                  => true,
            'video-active-callback'  => 'is_front_page',
        ));

        add_theme_support('automatic-feed-links');

        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

        add_theme_support('title-tag');

        add_theme_support('custom-logo');

        add_theme_support('customize-selective-refresh-widgets');

        add_theme_support('starter-content', array(
            'options' => array(
                'blogdescription' => 'JoomPress - WordPress Boilerplate Theme',
                //'date_format' => 'd.m.Y',
                //'time_format' => 'H:i',
                'show_on_front'   => 'posts', // posts, page
                'page_on_front'   => '{{home}}',
                'page_for_posts'  => '{{blog}}',
                //'posts_per_page' => '10',
                //'posts_per_rss' => '10',
                //'permalink_structure' => '/%postname%/',
            ),

            'theme_mods' => array(),

            'widgets' => array(
                'sidebar-left'  => array(),
                'sidebar-right' => array(),
            ),

            'nav_menus' => array(
                'header_menu' => array(
                    'name'  => 'Top Menu',
                    'items' => array(
                        'link_home' => array(
                            'type'  => 'custom',
                            'title' => 'Home',
                            'url'   => home_url('/'),
                        ),
                    ),
                ),
                'footer_menu' => array(
                    'name'  => 'Bottom Menu',
                    'items' => array(
                        'link_home' => array(
                            'type'  => 'custom',
                            'title' => 'Home',
                            'url'   => home_url('/'),
                        ),
                    ),
                ),
            ),

            'attachments' => array(
                'blog-item-1' => array(
                    'post_title' => 'blog-item-1',
                    'file'       => 'assets/img/starter-content/blog-item-1.jpg',
                ),
                'blog-item-2' => array(
                    'post_title' => 'blog-item-2',
                    'file'       => 'assets/img/starter-content/blog-item-2.jpg',
                ),
                'blog-item-3' => array(
                    'post_title' => 'blog-item-3',
                    'file'       => 'assets/img/starter-content/blog-item-3.jpg',
                ),
                'blog-item-4' => array(
                    'post_title' => 'blog-item-4',
                    'file'       => 'assets/img/starter-content/blog-item-4.jpg',
                ),
                'blog-item-5' => array(
                    'post_title' => 'blog-item-5',
                    'file'       => 'assets/img/starter-content/blog-item-5.jpg',
                ),
            ),

            'posts' => array(
                'home'        => array(
                    'post_type'  => 'page',
                    'post_name'  => 'home',
                    'post_title' => 'Home',
                    //'template'   => '',
                ),
                'blog'        => array(
                    'post_type'  => 'page',
                    'post_name'  => 'blog',
                    'post_title' => 'Blog',
                    //'template' => 'page-blog.php',
                ),
                'blog-item-1' => array(
                    'post_type'    => 'post',
                    'post_title'   => 'Blog title 1',
                    'post_name'    => 'blog-item-1',
                    'post_content' => 'You might be an artist who would like to introduce yourself and your work here or maybe you&rsquo;re a business with a mission to describe.',
                    'thumbnail'    => '{{blog-item-1}}',
                ),
                'blog-item-2' => array(
                    'post_type'    => 'post',
                    'post_title'   => 'Blog title 2',
                    'post_name'    => 'blog-item-2',
                    'post_content' => 'You might be an artist who would like to introduce yourself and your work here or maybe you&rsquo;re a business with a mission to describe.',
                    'thumbnail'    => '{{blog-item-2}}',
                ),
                'blog-item-3' => array(
                    'post_type'    => 'post',
                    'post_title'   => 'Blog title 3',
                    'post_name'    => 'blog-item-3',
                    'post_content' => 'You might be an artist who would like to introduce yourself and your work here or maybe you&rsquo;re a business with a mission to describe.',
                    'thumbnail'    => '{{blog-item-3}}',
                ),
                'blog-item-4' => array(
                    'post_type'    => 'post',
                    'post_title'   => 'Blog title 4',
                    'post_name'    => 'blog-item-4',
                    'post_content' => 'You might be an artist who would like to introduce yourself and your work here or maybe you&rsquo;re a business with a mission to describe.',
                    'thumbnail'    => '{{blog-item-4}}',
                ),
                'blog-item-5' => array(
                    'post_type'    => 'post',
                    'post_title'   => 'Blog title 5',
                    'post_name'    => 'blog-item-5',
                    'post_content' => 'You might be an artist who would like to introduce yourself and your work here or maybe you&rsquo;re a business with a mission to describe.',
                    'thumbnail'    => '{{blog-item-5}}',
                ),
            ),

        ));
    }

    add_editor_style(JP_CSS . '/editor-style.css');

    register_nav_menus(array(
        'header_menu' => __('Menu in header', 'joompress'),
        'footer_menu' => __('Menu in footer', 'joompress'),
    ));

    if ( ! is_admin()) {
        add_filter('comment_text', 'do_shortcode');
        add_filter('the_excerpt', 'do_shortcode');
    }

}

add_action('after_setup_theme', 'jp_theme_setup');

if ( ! isset($content_width)) {
    $content_width = 900;
}

/**
 * Remove class 'hentry' from post_class
 *
 * @param $classes
 *
 * @return mixed
 */
function jp_post_class($classes)
{
    $classes = array_diff($classes, array('hentry'));

    return $classes;
}

add_filter('post_class', 'jp_post_class');

/**
 * Custom Logo Classes
 *
 * @param $html
 *
 * @return mixed
 */
function jp_get_custom_logo($html)
{
    $html = str_replace('custom-logo-link', 'logo-link', $html);
    $html = str_replace('custom-logo', 'logo-img', $html);

    return $html;
}

add_filter('get_custom_logo', 'jp_get_custom_logo');

/**
 * WP Nav Menu Args
 *
 * @param $args
 *
 * @return mixed
 */
function jp_wp_nav_menu_args($args)
{
    $args['container'] = '';

    return $args;
}

//add_filter( 'wp_nav_menu_args', 'jp_wp_nav_menu_args' );

/**
 * Nav Menu CSS Class
 *
 * @param $classes
 * @param $item
 * @param $args
 * @param $depth
 *
 * @return mixed
 */
function jp_nav_menu_css_class($classes, $item, $args, $depth)
{
    if ($item->current) {
        foreach ($classes as $class) {
            if ($class === 'current-menu-item') {
                $classes[] = $depth > 0 ? 'sub-menu-item-current' : 'menu-item-current';
                break;
            }
        }
    }

    if ($depth > 0) {
        foreach ($classes as $key => $class) {
            if (preg_match('/^menu-item/', $class)) {
                $classes[$key] = 'sub-' . $class;
            }
        }
    }

    return $classes;
}

add_filter('nav_menu_css_class', 'jp_nav_menu_css_class', 10, 4);

/**
 * Nav Menu Link Attributes
 *
 * @param $atts
 * @param $item
 * @param $args
 * @param $depth
 *
 * @return mixed
 */
function jp_nav_menu_link_attributes($atts, $item, $args, $depth)
{
    $atts['itemprop'] = 'url';
    $atts['class']    = $depth > 0 ? 'sub-menu-link' : 'menu-link';

    return $atts;
}

add_filter('nav_menu_link_attributes', 'jp_nav_menu_link_attributes', 10, 4);

/**
 * Disabling Automatic JPEG Compression
 *
 * @return int
 */
function jp_jpeg_quality()
{
    return 100;
}

add_filter('jpeg_quality', 'jp_jpeg_quality');

/**
 * Setting the Excerpt’s Word Length
 *
 * @param $length
 *
 * @return int
 */
function jp_excerpt_length($length)
{
    $length = 55;

    return $length;
}

add_filter('excerpt_length', 'jp_excerpt_length');

/**
 * Setting the Excerpt’s more
 *
 * @param $more
 *
 * @return string
 */
function jp_excerpt_more($more)
{
    //return '[...]';
    return '...';
}

add_filter('excerpt_more', 'jp_excerpt_more');

/**
 * Redirect recording when a search query produces one result
 */
function jp_search_single_result()
{
    if (is_search()) {
        global $wp_query;
        if ($wp_query->post_count == 1) {
            wp_redirect(get_permalink($wp_query->posts['0']->ID));
        }
    }
}

add_action('template_redirect', 'jp_search_single_result');

/**
 * Integrating Custom Post Types in the WordPress Search
 *
 * @param WP_Query $query Global WP_Query instance.
 *
 * @return mixed
 */
function jp_search_all($query)
{
    if ($query->is_search) {
        $query->set('post_type', array());
    }

    return $query;
}

add_filter('the_search_query', 'jp_search_all');

/**
 * Add button page break to TyniMCE
 *
 * @param $mce_buttons
 *
 * @return array
 */
function jp_mce_page_break($mce_buttons)
{
    $pos = array_search('wp_more', $mce_buttons, true);

    if ($pos !== false) {
        $buttons     = array_slice($mce_buttons, 0, $pos);
        $buttons[]   = 'wp_page';
        $mce_buttons = array_merge($buttons, array_slice($mce_buttons, $pos));
    }

    return $mce_buttons;
}

add_filter('mce_buttons', 'jp_mce_page_break');

/**
 * Noindex, nofollow page 404
 *
 * @return void
 */
function jp_noindex_for_404()
{
    if (is_404()) {
        echo '<meta name="robots" content="noindex, follow">' . PHP_EOL;
    }
}

add_action('wp_head', 'jp_noindex_for_404');

/**
 * Posts Per Page
 *
 * @param WP_Query $query Global WP_Query instance.
 */
function jp_posts_per_page($query)
{
    $value = get_option('posts_per_page', 10);

    if (is_search()) {
        $query->set('posts_per_page', $value);
    }
}

add_action('pre_get_posts', 'jp_posts_per_page');

/**
 * Add allowed mime types
 *
 * @param array $mimes
 *
 * @return array
 */
function jp_upload_types($mimes = array())
{
    $mimes['svg'] = 'image/svg+xml';

    return $mimes;
}

add_filter('upload_mimes', 'jp_upload_types');
