<?php

/**
 * Customize
 *
 * @param $wp_customize WP_Customize_Manager
 */
function jp_customize_register($wp_customize)
{
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
    $wp_customize->get_setting('background_color')->transport = 'postMessage';

    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.blog-name',
        'render_callback' => function () {
            return get_bloginfo('name', 'display');
        },
    ]);

    $wp_customize->selective_refresh->add_partial('blogdescription', [
        'selector' => '.blog-description',
        'render_callback' => function () {
            return get_bloginfo('description', 'display');
        },
    ]);

    $wp_customize->selective_refresh->add_partial('custom_logo', [
        'selector' => '.logo',
        'render_callback' => function () {
            return get_custom_logo();
        },
    ]);

    // Panel Theme Options
    $wp_customize->add_panel('jp_theme_options', [
        'title' => 'Theme Options',
        'description' => 'Theme Options Customizer',
        'priority' => 201,
    ]);

    // Section Scroll Top
    $wp_customize->add_section('jp_scroll_top', [
        'title' => 'Scroll Top',
        'description' => 'Customizer Custom Scroll Top',
        'panel' => 'jp_theme_options',
    ]);

    $wp_customize->add_setting('jp_scroll_top_enable', [
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);

    $wp_customize->add_setting('jp_scroll_top_width', [
        'default' => '50',
        'transport' => 'postMessage',
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_setting('jp_scroll_top_height', [
        'default' => '50',
        'transport' => 'postMessage',
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_setting('jp_scroll_top_shape', [
        'default' => 'circle',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_select',
    ]);

    $wp_customize->add_setting('jp_scroll_top_position', [
        'default' => 'right',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_select',
    ]);

    $wp_customize->add_setting('jp_scroll_top_offset_left_right', [
        'default' => '20',
        'transport' => 'postMessage',
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_setting('jp_scroll_top_offset_bottom', [
        'default' => '20',
        'transport' => 'postMessage',
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_setting('jp_scroll_top_border_width', [
        'default' => '1',
        'transport' => 'postMessage',
        'sanitize_callback' => 'absint',
    ]);

    $wp_customize->add_setting('jp_scroll_top_border_color', [
        'default' => '#000000',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);

    $wp_customize->add_setting('jp_scroll_top_background_color', [
        'default' => '#000000',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);

    $wp_customize->add_setting('jp_scroll_top_background_color_hover', [
        'default' => '#000000',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);

    $wp_customize->add_setting('jp_scroll_top_arrow_color', [
        'default' => '#ffffff',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);

    $wp_customize->add_control('jp_scroll_top_enable', [
        'label' => 'Enable/Disable',
        'description' => 'Display Scroll Top',
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_enable',
        'type' => 'checkbox',
    ]);

    $wp_customize->selective_refresh->add_partial('jp_scroll_top_enable', [
        'selector' => '.js-scroll-top',
    ]);

    $wp_customize->add_control('jp_scroll_top_width', [
        'label' => 'Width',
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_width',
        'type' => 'number',
    ]);

    $wp_customize->add_control('jp_scroll_top_height', [
        'label' => 'Height',
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_height',
        'type' => 'number',
    ]);

    $wp_customize->add_control('jp_scroll_top_shape', [
        'label' => 'Shape',
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_shape',
        'type' => 'select',
        'choices' => [
            'circle' => 'Circle',
            'rounded' => 'Rounded',
            'square' => 'Square',
        ],
    ]);

    $wp_customize->add_control('jp_scroll_top_position', [
        'label' => 'Position',
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_position',
        'type' => 'select',
        'choices' => [
            'right' => 'Right',
            'left' => 'Left',
        ],
    ]);

    $wp_customize->add_control('jp_scroll_top_offset_left_right', [
        'label' => 'Offset Left/Right',
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_offset_left_right',
        'type' => 'number',
    ]);

    $wp_customize->add_control('jp_scroll_top_offset_bottom', [
        'label' => 'Offset bottom',
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_offset_bottom',
        'type' => 'number',
    ]);

    $wp_customize->add_control('jp_scroll_top_border_width', [
        'label' => 'Border width',
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_border_width',
        'type' => 'number',
    ]);

    $wp_customize->add_control('jp_scroll_top_border_color', [
        'label' => 'Border color',
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_border_color',
        'type' => 'color',
    ]);

    $wp_customize->add_control('jp_scroll_top_background_color', [
        'label' => 'Background color',
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_background_color',
        'type' => 'color',
    ]);

    $wp_customize->add_control('jp_scroll_top_background_color_hover', [
        'label' => 'Background color hover',
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_background_color_hover',
        'type' => 'color',
    ]);

    $wp_customize->add_control('jp_scroll_top_arrow_color', [
        'label' => 'Arrow color',
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_arrow_color',
        'type' => 'color',
    ]);

    // Section Analytics Tracking Code
    $wp_customize->add_section('jp_analytics', [
        'title' => 'Analytics',
        'description' => 'Analytics Tracking Code',
        'panel' => 'jp_theme_options',
    ]);

    $wp_customize->add_setting('jp_analytics_google_placed', [
        'default' => 'body',
        'sanitize_callback' => 'sanitize_select',
    ]);
    $wp_customize->add_setting('jp_analytics_yandex_placed', [
        'default' => 'body',
        'sanitize_callback' => 'sanitize_select',
    ]);
    $wp_customize->add_setting('jp_analytics_custom_placed', [
        'default' => 'body',
        'sanitize_callback' => 'sanitize_select',
    ]);

    $wp_customize->add_setting('jp_analytics_google', ['sanitize_callback' => 'esc_js',]);
    $wp_customize->add_setting('jp_analytics_yandex', ['sanitize_callback' => 'esc_js',]);
    $wp_customize->add_setting('jp_analytics_custom', ['sanitize_callback' => 'esc_js',]);

    $wp_customize->add_control('jp_analytics_google_placed', [
        'label' => 'Google Analytics',
        'description' => 'Placed (head/body)',
        'section' => 'jp_analytics',
        'settings' => 'jp_analytics_google_placed',
        'type' => 'select',
        'choices' => [
            'head' => 'Head',
            'body' => 'Body',
        ],
    ]);

    $wp_customize->add_control(new WP_Customize_Code_Editor_Control($wp_customize, 'jp_analytics_google', [
        'description' => 'Paste tracking code here &dArr;',
        'section' => 'jp_analytics',
        'settings' => 'jp_analytics_google',
        'code_type' => 'text/javascript',
        'input_attrs' => [
            'placeholder' => '',
        ],
    ]));

    $wp_customize->add_control('jp_analytics_yandex_placed', [
        'label' => 'Yandex Metrika',
        'description' => 'Placed (head/body)',
        'section' => 'jp_analytics',
        'settings' => 'jp_analytics_yandex_placed',
        'type' => 'select',
        'choices' => [
            'head' => 'Head',
            'body' => 'Body',
        ],
    ]);

    $wp_customize->add_control(new WP_Customize_Code_Editor_Control($wp_customize, 'jp_analytics_yandex', [
        'description' => 'Paste tracking code here &dArr;',
        'section' => 'jp_analytics',
        'settings' => 'jp_analytics_yandex',
        'code_type' => 'text/javascript',
        'input_attrs' => [
            'placeholder' => '',
        ],
    ]));

    $wp_customize->add_control('jp_analytics_custom_placed', [
        'label' => 'Custom Analytics',
        'description' => 'Placed (head/body)',
        'section' => 'jp_analytics',
        'settings' => 'jp_analytics_custom_placed',
        'type' => 'select',
        'choices' => [
            'head' => 'Head',
            'body' => 'Body',
        ],
    ]);

    $wp_customize->add_control(new WP_Customize_Code_Editor_Control($wp_customize, 'jp_analytics_custom', [
        'description' => 'Paste tracking code here &dArr;',
        'section' => 'jp_analytics',
        'settings' => 'jp_analytics_custom',
        'code_type' => 'text/javascript',
        'input_attrs' => [
            'placeholder' => '',
        ],
    ]));

    // Section Login
    $wp_customize->add_section('jp_login', [
        'title' => 'Login',
        'description' => 'Customizer Custom Login logo',
        'panel' => 'jp_theme_options',
    ]);

    $wp_customize->add_setting('jp_login_logo', [
        'default' => JP_IMG . '/login-logo.png',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'jp_login_logo', [
        'label' => 'Logo',
        'description' => 'Image size 80x80 px',
        'section' => 'jp_login',
        'settings' => 'jp_login_logo',
    ]));

    $wp_customize->add_setting('jp_login_background_color', [
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_hex_color_no_hash',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'jp_login_background_color', [
        'label' => 'Background Color',
        'section' => 'jp_login',
    ]));

    $wp_customize->add_setting('jp_login_background_image', [
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_background_setting',
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'jp_login_background_image', [
        'label' => 'Background Image',
        'section' => 'jp_login',
    ]));

    $wp_customize->add_setting('jp_login_background_position', [
        'default' => 'left top',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_background_setting',
    ]);

    $wp_customize->add_control('jp_login_background_position', [
        'label' => 'Image Position',
        'section' => 'jp_login',
        'type' => 'select',
        'choices' => [
            'left top' => 'Top Left',
            'center top' => 'Top Center',
            'right top' => 'Top Right',
            'left center' => 'Center Left',
            'center center' => 'Center Center',
            'right center' => 'Center Right',
            'left bottom' => 'Bottom Left',
            'center bottom' => 'Bottom Center',
            'right bottom' => 'Bottom Right',
        ],
    ]);

    $wp_customize->add_setting('jp_login_background_size', [
        'default' => 'auto',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_background_setting',
    ]);

    $wp_customize->add_control('jp_login_background_size', [
        'label' => 'Image Size',
        'section' => 'jp_login',
        'type' => 'select',
        'choices' => [
            'auto' => 'Original (auto)',
            'contain' => 'Fit to Screen (contain)',
            'cover' => 'Fill Screen (cover)',
        ],
    ]);

    $wp_customize->add_setting('jp_login_background_repeat', [
        'default' => 'repeat',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_background_setting',
    ]);

    $wp_customize->add_control('jp_login_background_repeat', [
        'label' => 'Repeat Background Image',
        'section' => 'jp_login',
        'type' => 'select',
        'choices' => [
            'repeat' => 'repeat',
            'repeat-x' => 'repeat-x',
            'repeat-y' => 'repeat-y',
            'no-repeat' => 'no-repeat',
        ],
    ]);

    $wp_customize->add_setting('jp_login_background_attachment', [
        'default' => 'scroll',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_background_setting',
    ]);

    $wp_customize->add_control('jp_login_background_attachment', [
        'label' => 'Scroll with Page',
        'section' => 'jp_login',
        'type' => 'select',
        'choices' => [
            'scroll' => 'Scroll',
            'fixed' => 'Fixed',
        ],
    ]);

    // Section Messenger
    $wp_customize->add_section('jp_messenger', [
        'title' => 'Messenger',
        'description' => 'Customizer Custom Messenger links',
        'panel' => 'jp_theme_options',
    ]);

    $wp_customize->add_setting('jp_messenger_skype', ['default' => '', 'sanitize_callback' => '',]);
    $wp_customize->add_setting('jp_messenger_viber', ['default' => '', 'sanitize_callback' => '',]);
    $wp_customize->add_setting('jp_messenger_whatsapp', ['default' => '', 'sanitize_callback' => '',]);
    $wp_customize->add_setting('jp_messenger_telegram', ['default' => '', 'sanitize_callback' => '',]);

    $wp_customize->selective_refresh->add_partial('jp_messenger_skype', [
        'selector' => '.messenger',
    ]);

    $wp_customize->add_control('jp_messenger_skype', [
        'label' => 'Skype',
        'section' => 'jp_messenger',
        'settings' => 'jp_messenger_skype',
        'type' => 'tel',
    ]);

    $wp_customize->add_control('jp_messenger_viber', [
        'label' => 'Viber',
        'section' => 'jp_messenger',
        'settings' => 'jp_messenger_viber',
        'type' => 'tel',
    ]);

    $wp_customize->add_control('jp_messenger_whatsapp', [
        'label' => 'WhatsApp',
        'section' => 'jp_messenger',
        'settings' => 'jp_messenger_whatsapp',
        'type' => 'tel',
    ]);

    $wp_customize->add_control('jp_messenger_telegram', [
        'label' => 'Telegram',
        'section' => 'jp_messenger',
        'settings' => 'jp_messenger_telegram',
        'type' => 'tel',
    ]);

    // Section Social
    $wp_customize->add_section('jp_social', [
        'title' => 'Social',
        'description' => 'Customizer Custom Social links',
        'panel' => 'jp_theme_options',
    ]);

    $wp_customize->add_setting('jp_social_vk', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
    $wp_customize->add_setting('jp_social_twitter', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
    $wp_customize->add_setting('jp_social_facebook', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
    $wp_customize->add_setting('jp_social_linkedin', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
    $wp_customize->add_setting('jp_social_instagram', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
    $wp_customize->add_setting('jp_social_odnoklassniki', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
    $wp_customize->add_setting('jp_social_google_plus', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
    $wp_customize->add_setting('jp_social_youtube', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
    $wp_customize->add_setting('jp_social_pinterest', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
    $wp_customize->add_setting('jp_social_tumblr', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
    $wp_customize->add_setting('jp_social_flickr', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
    $wp_customize->add_setting('jp_social_reddit', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);
    $wp_customize->add_setting('jp_social_rss', ['default' => '', 'sanitize_callback' => 'esc_url_raw',]);

    $wp_customize->selective_refresh->add_partial('jp_social_vk', [
        'selector' => '.social',
    ]);

    $wp_customize->add_control('jp_social_vk', [
        'label' => 'Vk',
        'section' => 'jp_social',
        'settings' => 'jp_social_vk',
        'type' => 'url',
    ]);

    $wp_customize->add_control('jp_social_twitter', [
        'label' => 'Twitter',
        'section' => 'jp_social',
        'settings' => 'jp_social_twitter',
        'type' => 'url',
    ]);

    $wp_customize->add_control('jp_social_facebook', [
        'label' => 'Facebook',
        'section' => 'jp_social',
        'settings' => 'jp_social_facebook',
        'type' => 'url',
    ]);

    $wp_customize->add_control('jp_social_linkedin', [
        'label' => 'Linkedin',
        'section' => 'jp_social',
        'settings' => 'jp_social_linkedin',
        'type' => 'url',
    ]);

    $wp_customize->add_control('jp_social_instagram', [
        'label' => 'Instagram',
        'section' => 'jp_social',
        'settings' => 'jp_social_instagram',
        'type' => 'url',
    ]);

    $wp_customize->add_control('jp_social_odnoklassniki', [
        'label' => 'Odnoklassniki',
        'section' => 'jp_social',
        'settings' => 'jp_social_odnoklassniki',
        'type' => 'url',
    ]);

    $wp_customize->add_control('jp_social_google_plus', [
        'label' => 'Google Plus',
        'section' => 'jp_social',
        'settings' => 'jp_social_google_plus',
        'type' => 'url',
    ]);

    $wp_customize->add_control('jp_social_youtube', [
        'label' => 'YouTube',
        'section' => 'jp_social',
        'settings' => 'jp_social_youtube',
        'type' => 'url',
    ]);

    $wp_customize->add_control('jp_social_pinterest', [
        'label' => 'Pinterest',
        'section' => 'jp_social',
        'settings' => 'jp_social_pinterest',
        'type' => 'url',
    ]);

    $wp_customize->add_control('jp_social_tumblr', [
        'label' => 'Tumblr',
        'section' => 'jp_social',
        'settings' => 'jp_social_tumblr',
        'type' => 'url',
    ]);

    $wp_customize->add_control('jp_social_flickr', [
        'label' => 'Flickr',
        'section' => 'jp_social',
        'settings' => 'jp_social_flickr',
        'type' => 'url',
    ]);

    $wp_customize->add_control('jp_social_reddit', [
        'label' => 'Reddit',
        'section' => 'jp_social',
        'settings' => 'jp_social_reddit',
        'type' => 'url',
    ]);

    $wp_customize->add_control('jp_social_rss', [
        'label' => 'RSS',
        'section' => 'jp_social',
        'settings' => 'jp_social_rss',
        'type' => 'url',
    ]);

    // Section Phones
    $wp_customize->add_section('jp_phones', [
        'title' => 'Phones',
        'description' => 'Customizer Custom Phone numbers',
        'panel' => 'jp_theme_options',
    ]);

    $wp_customize->add_setting('jp_phone_one', ['sanitize_callback' => '',]);
    $wp_customize->add_setting('jp_phone_two', ['sanitize_callback' => '',]);
    $wp_customize->add_setting('jp_phone_three', ['sanitize_callback' => '',]);
    $wp_customize->add_setting('jp_phone_four', ['sanitize_callback' => '',]);
    $wp_customize->add_setting('jp_phone_five', ['sanitize_callback' => '',]);

    $wp_customize->selective_refresh->add_partial('jp_phone_one', [
        'selector' => '.phone',
    ]);

    $wp_customize->add_control('jp_phone_one', [
        'label' => 'Phone 1',
        'section' => 'jp_phones',
        'settings' => 'jp_phone_one',
        'type' => 'tel',
    ]);

    $wp_customize->add_control('jp_phone_two', [
        'label' => 'Phone 2',
        'section' => 'jp_phones',
        'settings' => 'jp_phone_two',
        'type' => 'tel',
    ]);

    $wp_customize->add_control('jp_phone_three', [
        'label' => 'Phone 3',
        'section' => 'jp_phones',
        'settings' => 'jp_phone_three',
        'type' => 'tel',
    ]);

    $wp_customize->add_control('jp_phone_four', [
        'label' => 'Phone 4',
        'section' => 'jp_phones',
        'settings' => 'jp_phone_four',
        'type' => 'tel',
    ]);

    $wp_customize->add_control('jp_phone_five', [
        'label' => 'Phone 5',
        'section' => 'jp_phones',
        'settings' => 'jp_phone_five',
        'type' => 'tel',
    ]);

}

add_action('customize_register', 'jp_customize_register');

/**
 * Customizer CSS
 *
 * @return void
 */
function jp_customizer_css()
{ ?>
    <style>
        .scroll-top {
            width: <?php theme_mod('jp_scroll_top_width', 50); ?>px;
            height: <?php theme_mod('jp_scroll_top_height', 50); ?>px;
            background-color: <?php theme_mod('jp_scroll_top_background_color', '#000000'); ?>;
            border-width: <?php theme_mod('jp_scroll_top_border_width', 1); ?>px;
            border-color: <?php theme_mod('jp_scroll_top_border_color', '#000000'); ?>;
            bottom: <?php theme_mod('jp_scroll_top_offset_bottom', 20); ?>px;
        <?php jp_scroll_top_position_offset(); ?>
        }

        .scroll-top:hover {
            background-color: <?php theme_mod('jp_scroll_top_background_color_hover', '#000000'); ?>;
        }

        .scroll-top--arrow {
            border-bottom-color: <?php theme_mod('jp_scroll_top_arrow_color', '#ffffff'); ?>;
        }
    </style>
    <?php
}

add_action('wp_head', 'jp_customizer_css');

/**
 * Scroll Top Position Offset
 *
 * @return void
 */
function jp_scroll_top_position_offset()
{
    $position = get_theme_mod('jp_scroll_top_position', 'right');
    $offset = get_theme_mod('jp_scroll_top_offset_left_right', 20);

    $output = sprintf('%s: %spx;', $position, $offset);

    echo $output;
}
