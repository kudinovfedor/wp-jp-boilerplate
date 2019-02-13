<?php

function jp_switch_theme()
{
    $options = [
        'timezone_string' => 'Europe/Kiev',
        'date_format' => 'd M Y',
        'time_format' => 'H:i',
        'uploads_use_yearmonth_folders' => '',
        'permalink_structure' => '/%postname%/',
    ];

    foreach ($options as $option => $value) {
        update_option($option, $value);
    }

    update_option('sidebars_widgets', [
        'wp_inactive_widgets' => [],
        'sidebar-left' => [],
        'sidebar-right' => [],
        'array_version' => 3
    ]);

    $post_ids = [1, 2, 3];

    foreach ($post_ids as $id) {
        wp_delete_post($id, true);
    }
}

add_action('after_switch_theme', 'jp_switch_theme');

function jp_theme_setup()
{
    load_theme_textdomain('joompress', get_template_directory() . '/languages');

    if (function_exists('add_theme_support')) {
        add_theme_support('post-formats', [
            'aside',
            'gallery',
            'link',
            'image',
            'quote',
            'status',
            'video',
            'audio',
            'chat',
        ]);

        add_theme_support('post-thumbnails');

        add_theme_support('custom-background', [
            'default-image' => '',
            'default-preset' => 'default',
            'default-position-x' => 'center',
            'default-position-y' => 'center',
            'default-size' => 'cover',
            'default-repeat' => 'no-repeat',
            'default-attachment' => 'scroll',
            'default-color' => 'ffffff',
            'wp-head-callback' => '_custom_background_cb',
            'admin-head-callback' => '',
            'admin-preview-callback' => '',
        ]);

        add_theme_support('custom-header', [
            'default-image' => '',
            'random-default' => false,
            'width' => 0,
            'height' => 0,
            'flex-height' => true,
            'flex-width' => true,
            'default-text-color' => '',
            'header-text' => true,
            'uploads' => true,
            'wp-head-callback' => '',
            'admin-head-callback' => '',
            'admin-preview-callback' => '',
            'video' => true,
            'video-active-callback' => 'is_front_page',
        ]);

        add_theme_support('automatic-feed-links');

        add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

        add_theme_support('title-tag');

        add_theme_support('custom-logo', [
            'height' => 60,
            'width' => 200,
            'flex-height' => true,
            'flex-width' => true,
        ]);

        add_theme_support('customize-selective-refresh-widgets');

        add_theme_support('starter-content', [
            'options' => [
                'blogdescription' => 'JoomPress - WordPress Boilerplate Theme',
                //'date_format' => 'd.m.Y',
                //'time_format' => 'H:i',
                'show_on_front' => 'page', // posts, page
                'page_on_front' => '{{home}}',
                'page_for_posts' => '{{blog}}',
                //'posts_per_page' => '10',
                //'posts_per_rss' => '10',
                //'permalink_structure' => '/%postname%/',
            ],

            'theme_mods' => [],

            // [text_business_info, text_about, archives, calendar, categories, meta, recent-comments, recent-posts, search]
            'widgets' => [
                'sidebar-left' => [],
                'sidebar-right' => [],
            ],

            'nav_menus' => [
                'header_menu' => [
                    'name' => 'Top Menu',
                    'items' => [
                        'page_home' => [
                            'type' => 'post_type',
                            'object' => 'page',
                            'object_id' => '{{home}}',
                            'title' => 'Home',
                        ],
                        'page_about' => [
                            'type' => 'post_type',
                            'object' => 'page',
                            'object_id' => '{{about}}',
                            'title' => 'About',
                        ],
                        'page_blog' => [
                            'type' => 'post_type',
                            'object' => 'page',
                            'object_id' => '{{blog}}',
                            'title' => 'Blog',
                        ],
                        'page_contact' => [
                            'type' => 'post_type',
                            'object' => 'page',
                            'object_id' => '{{contact}}',
                            'title' => 'Contact',
                        ],
                    ],
                ],
                'footer_menu' => [
                    'name' => 'Bottom Menu',
                    'items' => [
                        'page_home' => [
                            'type' => 'post_type',
                            'object' => 'page',
                            'object_id' => '{{home}}',
                            'title' => 'Home',
                        ],
                        'page_about' => [
                            'type' => 'post_type',
                            'object' => 'page',
                            'object_id' => '{{about}}',
                            'title' => 'About',
                        ],
                        'page_blog' => [
                            'type' => 'post_type',
                            'object' => 'page',
                            'object_id' => '{{blog}}',
                            'title' => 'Blog',
                        ],
                        'page_contact' => [
                            'type' => 'post_type',
                            'object' => 'page',
                            'object_id' => '{{contact}}',
                            'title' => 'Contact',
                        ],
                        'page_about' => [
                            'type' => 'post_type',
                            'object' => 'page',
                            'object_id' => '{{about}}',
                            'title' => 'About',
                        ],
                        'page_blog' => [
                            'type' => 'post_type',
                            'object' => 'page',
                            'object_id' => '{{blog}}',
                            'title' => 'Blog',
                        ],
                        'page_contact' => [
                            'type' => 'post_type',
                            'object' => 'page',
                            'object_id' => '{{contact}}',
                            'title' => 'Contact',
                        ],
                    ],
                ],
            ],

            // ['post_excerpt' => 'caption', 'post_content' => 'description']
            'attachments' => [
                'blog-item-1' => [
                    'post_title' => 'Blog item 1 title',
                    'post_excerpt' => '',
                    'post_content' => '',
                    'file' => 'assets/img/starter-content/blog-item-1.jpg',
                ],
                'blog-item-2' => [
                    'post_title' => 'blog-item-2',
                    'post_excerpt' => '',
                    'post_content' => '',
                    'file' => 'assets/img/starter-content/blog-item-2.jpg',
                ],
                'blog-item-3' => [
                    'post_title' => 'blog-item-3',
                    'post_excerpt' => '',
                    'post_content' => '',
                    'file' => 'assets/img/starter-content/blog-item-3.jpg',
                ],
                'blog-item-4' => [
                    'post_title' => 'blog-item-4',
                    'post_excerpt' => '',
                    'post_content' => '',
                    'file' => 'assets/img/starter-content/blog-item-4.jpg',
                ],
                'blog-item-5' => [
                    'post_title' => 'blog-item-5',
                    'post_excerpt' => '',
                    'post_content' => '',
                    'file' => 'assets/img/starter-content/blog-item-5.jpg',
                ],
            ],

            // ['post_type', 'post_name', 'post_title', 'post_excerpt', 'post_content', 'menu_order', 'comment_status', 'thumbnail', 'template']
            'posts' => [
                // Page
                'home' => [
                    'post_type' => 'page',
                    'post_name' => 'home',
                    'post_title' => 'Home',
                    'post_content' => 'Welcome to your site! This is your homepage, which is what most visitors will see when they come to your site for the first time.',
                    //'template'   => 'page-home.php',
                ],
                'about' => [
                    'post_type' => 'page',
                    'post_name' => 'about',
                    'post_title' => 'About',
                    'post-content' => 'You might be an artist who would like to introduce yourself and your work here or maybe you&rsquo;re a business with a mission to describe.',
                    //'template' => 'page-about.php',
                ],
                'contact' => [
                    'post_type' => 'page',
                    'post_name' => 'contact',
                    'post_title' => 'Contact',
                    'post_content' => 'This is a page with some basic contact information, such as an address and phone number. You might also try a plugin to add a contact form.',
                    //'template' => 'page-contact.php',
                ],
                'blog' => [
                    'post_type' => 'page',
                    'post_name' => 'blog',
                    'post_title' => 'Blog',
                    //'template' => 'page-blog.php',
                ],
                // Post
                'blog-item-1' => [
                    'post_type' => 'post',
                    'post_title' => 'Blog title 1',
                    'post_name' => 'blog-item-1',
                    'post_content' => 'You might be an artist who would like to introduce yourself and your work here or maybe you&rsquo;re a business with a mission to describe.',
                    'thumbnail' => '{{blog-item-1}}',
                ],
                'blog-item-2' => [
                    'post_type' => 'post',
                    'post_title' => 'Blog title 2',
                    'post_name' => 'blog-item-2',
                    'post_content' => 'You might be an artist who would like to introduce yourself and your work here or maybe you&rsquo;re a business with a mission to describe.',
                    'thumbnail' => '{{blog-item-2}}',
                ],
                'blog-item-3' => [
                    'post_type' => 'post',
                    'post_title' => 'Blog title 3',
                    'post_name' => 'blog-item-3',
                    'post_content' => 'You might be an artist who would like to introduce yourself and your work here or maybe you&rsquo;re a business with a mission to describe.',
                    'thumbnail' => '{{blog-item-3}}',
                ],
                'blog-item-4' => [
                    'post_type' => 'post',
                    'post_title' => 'Blog title 4',
                    'post_name' => 'blog-item-4',
                    'post_content' => 'You might be an artist who would like to introduce yourself and your work here or maybe you&rsquo;re a business with a mission to describe.',
                    'thumbnail' => '{{blog-item-4}}',
                ],
                'blog-item-5' => [
                    'post_type' => 'post',
                    'post_title' => 'Blog title 5',
                    'post_name' => 'blog-item-5',
                    'post_content' => 'You might be an artist who would like to introduce yourself and your work here or maybe you&rsquo;re a business with a mission to describe.',
                    'thumbnail' => '{{blog-item-5}}',
                ],
            ],

        ]);

        add_theme_support('editor-styles');
        add_theme_support('dark-editor-style');

        add_theme_support('align-wide');
        add_theme_support('wp-block-styles');
        add_theme_support('responsive-embeds');
        //add_theme_support('disable-custom-colors');
        //add_theme_support('disable-custom-font-sizes');

        add_theme_support('woocommerce');

        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }

    add_editor_style(JP_CSS . '/editor-style.css');


    register_nav_menus([
        'header_menu' => __('Menu in header', 'joompress'),
        'footer_menu' => __('Menu in footer', 'joompress'),
    ]);

    if (!is_admin()) {
        add_filter('comment_text', 'do_shortcode');
        add_filter('the_excerpt', 'do_shortcode');
    }

}

add_action('after_setup_theme', 'jp_theme_setup');

if (!isset($content_width)) {
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
    $classes = array_diff($classes, ['hentry']);

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
    $atts['class'] = $depth > 0 ? 'sub-menu-link' : 'menu-link';

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
        $query->set('post_type', []);
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
        $buttons = array_slice($mce_buttons, 0, $pos);
        $buttons[] = 'wp_page';
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
function jp_upload_types($mimes = [])
{
    $mimes['svg'] = 'image/svg+xml';

    return $mimes;
}

add_filter('upload_mimes', 'jp_upload_types');

/**
 * Remove rel="category tag" from category list
 *
 * @param $output
 *
 * @return mixed
 */
function jp_remove_category_list_rel($output)
{
    $output = str_replace('rel="category tag"', '', $output);
    return $output;
}

add_filter('the_category', 'jp_remove_category_list_rel');
add_filter('wp_list_categories', 'jp_remove_category_list_rel');

/**
 * @param $html
 *
 * @return string
 */
function jp_embed_html($html)
{
    return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
}

add_filter('video_embed_html', 'jp_embed_html');
add_filter('embed_oembed_html', 'jp_embed_html', 10, 3);

/**
 * Removed width and height attributes from image elements in WordPress
 *
 * @param $html
 *
 * @return null|string|string[]
 */
function jp_remove_width_height_attribute($html)
{
    $html = preg_replace('/(width|height)="\d*"\s/', "", $html);
    return $html;
}

add_filter('post_thumbnail_html', 'jp_remove_width_height_attribute');
add_filter('image_send_to_editor', 'jp_remove_width_height_attribute');

function jp_amp_site_icon_url($schema_img_url)
{
    if (empty($schema_img_url)) {
        $schema_img_url = get_logo_url();
    }

    return $schema_img_url;
}

add_filter('amp_site_icon_url', 'jp_amp_site_icon_url');
