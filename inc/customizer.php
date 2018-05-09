<?php

/**
 * Customize
 *
 * @param $wp_customize WP_Customize_Manager
 */
function jp_customize_register($wp_customize)
{
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
    $wp_customize->get_setting('background_color')->transport = 'postMessage';

    $wp_customize->selective_refresh->add_partial('blogname', array(
        'selector'        => '.blog-name',
        'render_callback' => function () {
            return get_bloginfo('name', 'display');
        },
    ));

    $wp_customize->selective_refresh->add_partial('blogdescription', array(
        'selector'        => '.blog-description',
        'render_callback' => function () {
            return get_bloginfo('description', 'display');
        },
    ));

    // Panel Theme Options
    $wp_customize->add_panel('jp_theme_options', array(
        'title'       => 'Theme Options',
        'description' => 'Theme Options Customizer',
        'priority'    => 201,
    ));

    // Section Scroll Top
    $wp_customize->add_section('jp_scroll_top', array(
        'title'       => 'Scroll Top',
        'description' => 'Customizer Custom Scroll Top',
        'panel'       => 'jp_theme_options',
    ));

    $wp_customize->add_setting('jp_scroll_top_enable', array(
        'default'           => true,
        'sanitize_callback' => '',
    ));

    $wp_customize->add_setting('jp_scroll_top_width', array(
        'default'           => '55',
        'transport'         => 'postMessage',
        'sanitize_callback' => '',
    ));

    $wp_customize->add_setting('jp_scroll_top_height', array(
        'default'           => '55',
        'transport'         => 'postMessage',
        'sanitize_callback' => '',
    ));

    $wp_customize->add_setting('jp_scroll_top_shape', array(
        'default'           => 'circle',
        'transport'         => 'postMessage',
        'sanitize_callback' => '',
    ));

    $wp_customize->add_setting('jp_scroll_top_position', array(
        'default'           => 'right',
        'transport'         => 'postMessage',
        'sanitize_callback' => '',
    ));

    $wp_customize->add_setting('jp_scroll_top_offset_left_right', array(
        'default'           => '20',
        'transport'         => 'postMessage',
        'sanitize_callback' => '',
    ));

    $wp_customize->add_setting('jp_scroll_top_offset_bottom', array(
        'default'           => '20',
        'transport'         => 'postMessage',
        'sanitize_callback' => '',
    ));

    $wp_customize->add_setting('jp_scroll_top_border_width', array(
        'default'           => '1',
        'transport'         => 'postMessage',
        'sanitize_callback' => '',
    ));

    $wp_customize->add_setting('jp_scroll_top_border_color', array(
        'default'           => '#000000',
        'transport'         => 'postMessage',
        'sanitize_callback' => '',
    ));

    $wp_customize->add_setting('jp_scroll_top_background_color', array(
        'default'           => '#000000',
        'transport'         => 'postMessage',
        'sanitize_callback' => '',
    ));

    $wp_customize->add_setting('jp_scroll_top_background_color_hover', array(
        'default'           => '#000000',
        'transport'         => 'postMessage',
        'sanitize_callback' => '',
    ));

    $wp_customize->add_setting('jp_scroll_top_arrow_color', array(
        'default'           => '#ffffff',
        'transport'         => 'postMessage',
        'sanitize_callback' => '',
    ));

    $wp_customize->add_control('jp_scroll_top_enable', array(
        'label'       => 'Enable/Disable',
        'description' => 'Display Scroll Top',
        'section'     => 'jp_scroll_top',
        'settings'    => 'jp_scroll_top_enable',
        'type'        => 'checkbox',
    ));

    $wp_customize->selective_refresh->add_partial('jp_scroll_top_enable', array(
        'selector' => '.js-scroll-top',
    ));

    $wp_customize->add_control('jp_scroll_top_width', array(
        'label'    => 'Width',
        'section'  => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_width',
        'type'     => 'number',
    ));

    $wp_customize->add_control('jp_scroll_top_height', array(
        'label'    => 'Height',
        'section'  => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_height',
        'type'     => 'number',
    ));

    $wp_customize->add_control('jp_scroll_top_shape', array(
        'label'    => 'Shape',
        'section'  => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_shape',
        'type'     => 'select',
        'choices'  => array(
            'circle'  => 'Circle',
            'rounded' => 'Rounded',
            'square'  => 'Square',
        ),
    ));

    $wp_customize->add_control('jp_scroll_top_position', array(
        'label'    => 'Position',
        'section'  => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_position',
        'type'     => 'select',
        'choices'  => array(
            'right' => 'Right',
            'left'  => 'Left',
        ),
    ));

    $wp_customize->add_control('jp_scroll_top_offset_left_right', array(
        'label'    => 'Offset Left/Right',
        'section'  => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_offset_left_right',
        'type'     => 'number',
    ));

    $wp_customize->add_control('jp_scroll_top_offset_bottom', array(
        'label'    => 'Offset bottom',
        'section'  => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_offset_bottom',
        'type'     => 'number',
    ));

    $wp_customize->add_control('jp_scroll_top_border_width', array(
        'label'    => 'Border width',
        'section'  => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_border_width',
        'type'     => 'number',
    ));

    $wp_customize->add_control('jp_scroll_top_border_color', array(
        'label'    => 'Border color',
        'section'  => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_border_color',
        'type'     => 'color',
    ));

    $wp_customize->add_control('jp_scroll_top_background_color', array(
        'label'    => 'Background color',
        'section'  => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_background_color',
        'type'     => 'color',
    ));

    $wp_customize->add_control('jp_scroll_top_background_color_hover', array(
        'label'    => 'Background color hover',
        'section'  => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_background_color_hover',
        'type'     => 'color',
    ));

    $wp_customize->add_control('jp_scroll_top_arrow_color', array(
        'label'    => 'Arrow color',
        'section'  => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_arrow_color',
        'type'     => 'color',
    ));

    // Section Analytics Tracking Code
    $wp_customize->add_section('jp_analytics', array(
        'title'       => 'Analytics',
        'description' => 'Analytics Tracking Code',
        'panel'       => 'jp_theme_options',
    ));

    $wp_customize->add_setting('jp_analytics_google_placed', array('default' => 'body', 'sanitize_callback' => '',));
    $wp_customize->add_setting('jp_analytics_yandex_placed', array('default' => 'body', 'sanitize_callback' => '',));
    $wp_customize->add_setting('jp_analytics_custom_placed', array('default' => 'body', 'sanitize_callback' => '',));

    $wp_customize->add_setting('jp_analytics_google', array('sanitize_callback' => '',));
    $wp_customize->add_setting('jp_analytics_yandex', array('sanitize_callback' => '',));
    $wp_customize->add_setting('jp_analytics_custom', array('sanitize_callback' => '',));

    $wp_customize->add_control('jp_analytics_google_placed', array(
        'label'       => 'Google Analytics',
        'description' => 'Placed (head/body)',
        'section'     => 'jp_analytics',
        'settings'    => 'jp_analytics_google_placed',
        'type'        => 'select',
        'choices'     => array(
            'head' => 'Head',
            'body' => 'Body',
        ),
    ));

    $wp_customize->add_control(new WP_Customize_Code_Editor_Control($wp_customize, 'jp_analytics_google', array(
        'description' => 'Paste tracking code here &dArr;',
        'section'     => 'jp_analytics',
        'settings'    => 'jp_analytics_google',
        'code_type'   => 'text/javascript',
        'input_attrs' => array(
            'placeholder' => '',
        ),
    )));

    $wp_customize->add_control('jp_analytics_yandex_placed', array(
        'label'       => 'Yandex Metrika',
        'description' => 'Placed (head/body)',
        'section'     => 'jp_analytics',
        'settings'    => 'jp_analytics_yandex_placed',
        'type'        => 'select',
        'choices'     => array(
            'head' => 'Head',
            'body' => 'Body',
        ),
    ));

    $wp_customize->add_control(new WP_Customize_Code_Editor_Control($wp_customize, 'jp_analytics_yandex', array(
        'description' => 'Paste tracking code here &dArr;',
        'section'     => 'jp_analytics',
        'settings'    => 'jp_analytics_yandex',
        'code_type'   => 'text/javascript',
        'input_attrs' => array(
            'placeholder' => '',
        ),
    )));

    $wp_customize->add_control('jp_analytics_custom_placed', array(
        'label'       => 'Custom Analytics',
        'description' => 'Placed (head/body)',
        'section'     => 'jp_analytics',
        'settings'    => 'jp_analytics_custom_placed',
        'type'        => 'select',
        'choices'     => array(
            'head' => 'Head',
            'body' => 'Body',
        ),
    ));

    $wp_customize->add_control(new WP_Customize_Code_Editor_Control($wp_customize, 'jp_analytics_custom', array(
        'description' => 'Paste tracking code here &dArr;',
        'section'     => 'jp_analytics',
        'settings'    => 'jp_analytics_custom',
        'code_type'   => 'text/javascript',
        'input_attrs' => array(
            'placeholder' => '',
        ),
    )));

    // Section Login
    $wp_customize->add_section('jp_login', array(
        'title'       => 'Login',
        'description' => 'Customizer Custom Login logo',
        'panel'       => 'jp_theme_options',
    ));

    $wp_customize->add_setting('jp_login_logo', array(
        'default'           => JP_IMG . '/login-logo.png',
        'sanitize_callback' => '',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'jp_login_logo', array(
        'label'       => 'Logo',
        'description' => 'Image size 80x80 px',
        'section'     => 'jp_login',
        'settings'    => 'jp_login_logo',
    )));

    // Section Social
    $wp_customize->add_section('jp_social', array(
        'title'       => 'Social',
        'description' => 'Customizer Custom Social links',
        'panel'       => 'jp_theme_options',
    ));

    $wp_customize->add_setting('jp_social_vk', array('default' => '', 'sanitize_callback' => '',));
    $wp_customize->add_setting('jp_social_twitter', array('default' => '', 'sanitize_callback' => '',));
    $wp_customize->add_setting('jp_social_facebook', array('default' => '', 'sanitize_callback' => '',));
    $wp_customize->add_setting('jp_social_linkedin', array('default' => '', 'sanitize_callback' => '',));
    $wp_customize->add_setting('jp_social_instagram', array('default' => '', 'sanitize_callback' => '',));
    $wp_customize->add_setting('jp_social_odnoklassniki', array('default' => '', 'sanitize_callback' => '',));
    $wp_customize->add_setting('jp_social_google_plus', array('default' => '', 'sanitize_callback' => '',));
    $wp_customize->add_setting('jp_social_youtube', array('default' => '', 'sanitize_callback' => '',));
    $wp_customize->add_setting('jp_social_pinterest', array('default' => '', 'sanitize_callback' => '',));
    $wp_customize->add_setting('jp_social_tumblr', array('default' => '', 'sanitize_callback' => '',));
    $wp_customize->add_setting('jp_social_flickr', array('default' => '', 'sanitize_callback' => '',));
    $wp_customize->add_setting('jp_social_reddit', array('default' => '', 'sanitize_callback' => '',));
    $wp_customize->add_setting('jp_social_rss', array('default' => '', 'sanitize_callback' => '',));

    $wp_customize->selective_refresh->add_partial('jp_social_vk', array(
        'selector' => '.social',
    ));

    $wp_customize->add_control('jp_social_vk', array(
        'label'    => 'Vk',
        'section'  => 'jp_social',
        'settings' => 'jp_social_vk',
        'type'     => 'url',
    ));

    $wp_customize->add_control('jp_social_twitter', array(
        'label'    => 'Twitter',
        'section'  => 'jp_social',
        'settings' => 'jp_social_twitter',
        'type'     => 'url',
    ));

    $wp_customize->add_control('jp_social_facebook', array(
        'label'    => 'Facebook',
        'section'  => 'jp_social',
        'settings' => 'jp_social_facebook',
        'type'     => 'url',
    ));

    $wp_customize->add_control('jp_social_linkedin', array(
        'label'    => 'Linkedin',
        'section'  => 'jp_social',
        'settings' => 'jp_social_linkedin',
        'type'     => 'url',
    ));

    $wp_customize->add_control('jp_social_instagram', array(
        'label'    => 'Instagram',
        'section'  => 'jp_social',
        'settings' => 'jp_social_instagram',
        'type'     => 'url',
    ));

    $wp_customize->add_control('jp_social_odnoklassniki', array(
        'label'    => 'Odnoklassniki',
        'section'  => 'jp_social',
        'settings' => 'jp_social_odnoklassniki',
        'type'     => 'url',
    ));

    $wp_customize->add_control('jp_social_google_plus', array(
        'label'    => 'Google Plus',
        'section'  => 'jp_social',
        'settings' => 'jp_social_google_plus',
        'type'     => 'url',
    ));

    $wp_customize->add_control('jp_social_youtube', array(
        'label'    => 'YouTube',
        'section'  => 'jp_social',
        'settings' => 'jp_social_youtube',
        'type'     => 'url',
    ));

    $wp_customize->add_control('jp_social_pinterest', array(
        'label'    => 'Pinterest',
        'section'  => 'jp_social',
        'settings' => 'jp_social_pinterest',
        'type'     => 'url',
    ));

    $wp_customize->add_control('jp_social_tumblr', array(
        'label'    => 'Tumblr',
        'section'  => 'jp_social',
        'settings' => 'jp_social_tumblr',
        'type'     => 'url',
    ));

    $wp_customize->add_control('jp_social_flickr', array(
        'label'    => 'Flickr',
        'section'  => 'jp_social',
        'settings' => 'jp_social_flickr',
        'type'     => 'url',
    ));

    $wp_customize->add_control('jp_social_reddit', array(
        'label'    => 'Reddit',
        'section'  => 'jp_social',
        'settings' => 'jp_social_reddit',
        'type'     => 'url',
    ));

    $wp_customize->add_control('jp_social_rss', array(
        'label'    => 'RSS',
        'section'  => 'jp_social',
        'settings' => 'jp_social_rss',
        'type'     => 'url',
    ));

    // Section Phones
    $wp_customize->add_section('jp_phones', array(
        'title'       => 'Phones',
        'description' => 'Customizer Custom Phone numbers',
        'panel'       => 'jp_theme_options',
    ));

    $wp_customize->add_setting('jp_phone_one', array('sanitize_callback' => '',));
    $wp_customize->add_setting('jp_phone_two', array('sanitize_callback' => '',));
    $wp_customize->add_setting('jp_phone_three', array('sanitize_callback' => '',));
    $wp_customize->add_setting('jp_phone_four', array('sanitize_callback' => '',));
    $wp_customize->add_setting('jp_phone_five', array('sanitize_callback' => '',));

    $wp_customize->selective_refresh->add_partial('jp_phone_one', array(
        'selector' => '.phone',
    ));

    $wp_customize->add_control('jp_phone_one', array(
        'label'    => 'Phone 1',
        'section'  => 'jp_phones',
        'settings' => 'jp_phone_one',
        'type'     => 'tel',
    ));

    $wp_customize->add_control('jp_phone_two', array(
        'label'    => 'Phone 2',
        'section'  => 'jp_phones',
        'settings' => 'jp_phone_two',
        'type'     => 'tel',
    ));

    $wp_customize->add_control('jp_phone_three', array(
        'label'    => 'Phone 3',
        'section'  => 'jp_phones',
        'settings' => 'jp_phone_three',
        'type'     => 'tel',
    ));

    $wp_customize->add_control('jp_phone_four', array(
        'label'    => 'Phone 4',
        'section'  => 'jp_phones',
        'settings' => 'jp_phone_four',
        'type'     => 'tel',
    ));

    $wp_customize->add_control('jp_phone_five', array(
        'label'    => 'Phone 5',
        'section'  => 'jp_phones',
        'settings' => 'jp_phone_five',
        'type'     => 'tel',
    ));

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
            width: <?php theme_mod('jp_scroll_top_width', 55); ?>px;
            height: <?php theme_mod('jp_scroll_top_height', 55); ?>px;
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
    $offset   = get_theme_mod('jp_scroll_top_offset_left_right', 20);

    $output = sprintf('%s: %spx;', $position, $offset);

    echo $output;
}
