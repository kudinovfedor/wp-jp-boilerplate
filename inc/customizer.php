<?php

/**
 * Customize
 *
 * @param $customize WP_Customize_Manager
 */
function jp_customize_register($customize)
{
    $customize->get_setting('blogname')->transport = 'postMessage';
    $customize->get_setting('blogdescription')->transport = 'postMessage';
    $customize->get_setting('header_textcolor')->transport = 'postMessage';
    $customize->get_setting('background_color')->transport = 'postMessage';

    $customize->selective_refresh->add_partial('blogname', [
        'selector' => '.blog-name',
        'render_callback' => function () {
            return get_bloginfo('name', 'display');
        },
    ]);

    $customize->selective_refresh->add_partial('blogdescription', [
        'selector' => '.blog-description',
        'render_callback' => function () {
            return get_bloginfo('description', 'display');
        },
    ]);

    $customize->selective_refresh->add_partial('custom_logo', [
        'selector' => '.logo',
        'render_callback' => function () {
            return get_custom_logo();
        },
    ]);

    // Panel Theme Options
    $customize->add_panel('jp_theme_options', [
        'title' => 'Theme Options',
        'description' => 'Theme Options Customizer',
        'priority' => 201,
    ]);

    // Section Analytics Tracking Code
    $customize->add_section('jp_analytics', [
        'title' => 'Analytics',
        'description' => 'Analytics Tracking Code',
        'panel' => 'jp_theme_options',
    ]);

    $customize->add_setting('jp_analytics_google_placed', [
        'default' => 'body',
        'sanitize_callback' => 'sanitize_select',
    ]);
    $customize->add_setting('jp_analytics_yandex_placed', [
        'default' => 'body',
        'sanitize_callback' => 'sanitize_select',
    ]);
    $customize->add_setting('jp_analytics_custom_placed', [
        'default' => 'body',
        'sanitize_callback' => 'sanitize_select',
    ]);

    $customize->add_setting('jp_analytics_google', ['sanitize_callback' => 'esc_js',]);
    $customize->add_setting('jp_analytics_yandex', ['sanitize_callback' => 'esc_js',]);
    $customize->add_setting('jp_analytics_custom', ['sanitize_callback' => 'esc_js',]);

    $customize->add_control('jp_analytics_google_placed', [
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

    $customize->add_control(new WP_Customize_Code_Editor_Control($customize, 'jp_analytics_google', [
        'description' => 'Paste tracking code here &dArr;',
        'section' => 'jp_analytics',
        'settings' => 'jp_analytics_google',
        'code_type' => 'text/javascript',
        'input_attrs' => [
            'placeholder' => '',
        ],
    ]));

    $customize->add_control('jp_analytics_yandex_placed', [
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

    $customize->add_control(new WP_Customize_Code_Editor_Control($customize, 'jp_analytics_yandex', [
        'description' => 'Paste tracking code here &dArr;',
        'section' => 'jp_analytics',
        'settings' => 'jp_analytics_yandex',
        'code_type' => 'text/javascript',
        'input_attrs' => [
            'placeholder' => '',
        ],
    ]));

    $customize->add_control('jp_analytics_custom_placed', [
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

    $customize->add_control(new WP_Customize_Code_Editor_Control($customize, 'jp_analytics_custom', [
        'description' => 'Paste tracking code here &dArr;',
        'section' => 'jp_analytics',
        'settings' => 'jp_analytics_custom',
        'code_type' => 'text/javascript',
        'input_attrs' => [
            'placeholder' => '',
        ],
    ]));

    // Section Login
    $customize->add_section('jp_login', [
        'title' => 'Login',
        'description' => 'Customizer Custom Login logo',
        'panel' => 'jp_theme_options',
    ]);

    $customize->add_setting('jp_login_logo', [
        'default' => JP_IMG . '/login-logo.png',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $customize->add_control(new WP_Customize_Image_Control($customize, 'jp_login_logo', [
        'label' => 'Logo',
        'description' => 'Image size 80x80 px',
        'section' => 'jp_login',
        'settings' => 'jp_login_logo',
    ]));

    $customize->add_setting('jp_login_background_color', [
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_hex_color_no_hash',
    ]);

    $customize->add_control(new WP_Customize_Color_Control($customize, 'jp_login_background_color', [
        'label' => 'Background Color',
        'section' => 'jp_login',
    ]));

    $customize->add_setting('jp_login_background_image', [
        'default' => '',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_background_setting',
    ]);

    $customize->add_control(new WP_Customize_Image_Control($customize, 'jp_login_background_image', [
        'label' => 'Background Image',
        'section' => 'jp_login',
    ]));

    $customize->add_setting('jp_login_background_position', [
        'default' => 'left top',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_background_setting',
    ]);

    $customize->add_control('jp_login_background_position', [
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

    $customize->add_setting('jp_login_background_size', [
        'default' => 'auto',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_background_setting',
    ]);

    $customize->add_control('jp_login_background_size', [
        'label' => 'Image Size',
        'section' => 'jp_login',
        'type' => 'select',
        'choices' => [
            'auto' => 'Original (auto)',
            'contain' => 'Fit to Screen (contain)',
            'cover' => 'Fill Screen (cover)',
        ],
    ]);

    $customize->add_setting('jp_login_background_repeat', [
        'default' => 'repeat',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_background_setting',
    ]);

    $customize->add_control('jp_login_background_repeat', [
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

    $customize->add_setting('jp_login_background_attachment', [
        'default' => 'scroll',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_background_setting',
    ]);

    $customize->add_control('jp_login_background_attachment', [
        'label' => 'Scroll with Page',
        'section' => 'jp_login',
        'type' => 'select',
        'choices' => [
            'scroll' => 'Scroll',
            'fixed' => 'Fixed',
        ],
    ]);
}

add_action('customize_register', 'jp_customize_register');
