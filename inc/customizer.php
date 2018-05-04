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

    // Panel Theme Options
    $wp_customize->add_panel('jp_theme_options', array(
        'title' => __('Theme Options', 'joompress'),
        'description' => esc_html__('Theme Options Customizer', 'joompress'),
        'priority' => 201,
    ));

    // Section Scroll Top
    $wp_customize->add_section('jp_scroll_top', array(
        'title' => __('Scroll Top', 'joompress'),
        'description' => esc_html__('Customizer Custom Scroll Top', 'joompress'),
        'panel' => 'jp_theme_options',
    ));

    $wp_customize->add_setting('jp_scroll_top_enable', array(
        'default' => true,
    ));

    $wp_customize->add_setting('jp_scroll_top_width', array(
        'default' => '55',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_setting('jp_scroll_top_height', array(
        'default' => '55',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_setting('jp_scroll_top_shape', array(
        'default' => 'circle',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_setting('jp_scroll_top_position', array(
        'default' => 'right',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_setting('jp_scroll_top_offset_left_right', array(
        'default' => '20',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_setting('jp_scroll_top_offset_bottom', array(
        'default' => '20',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_setting('jp_scroll_top_border_width', array(
        'default' => '1',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_setting('jp_scroll_top_border_color', array(
        'default' => '#000000',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_setting('jp_scroll_top_background_color', array(
        'default' => '#000000',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_setting('jp_scroll_top_background_color_hover', array(
        'default' => '#000000',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_setting('jp_scroll_top_arrow_color', array(
        'default' => '#ffffff',
        'transport' => 'postMessage',
    ));

    $wp_customize->add_control('jp_scroll_top_enable', array(
        'label' => __('Display', 'joompress'),
        'description' => esc_html__('Show/Hide scroll top', 'joompress'),
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_enable',
        'type' => 'checkbox',
    ));

    $wp_customize->add_control('jp_scroll_top_width', array(
        'label' => __('Width', 'joompress'),
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_width',
        'type' => 'number',
    ));

    $wp_customize->add_control('jp_scroll_top_height', array(
        'label' => __('Height', 'joompress'),
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_height',
        'type' => 'number',
    ));

    $wp_customize->add_control('jp_scroll_top_shape', array(
        'label' => __('Shape', 'joompress'),
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_shape',
        'type' => 'select',
        'choices' => array(
            'circle' => __('Circle', 'joompress'),
            'rounded' => __('Rounded', 'joompress'),
            'square' => __('Square', 'joompress'),
        ),
    ));

    $wp_customize->add_control('jp_scroll_top_position', array(
        'label' => __('Position', 'joompress'),
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_position',
        'type' => 'select',
        'choices' => array(
            'right' => __('Right', 'joompress'),
            'left' => __('Left', 'joompress'),
        ),
    ));

    $wp_customize->add_control('jp_scroll_top_offset_left_right', array(
        'label' => __('Offset Left/Right', 'joompress'),
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_offset_left_right',
        'type' => 'number',
    ));

    $wp_customize->add_control('jp_scroll_top_offset_bottom', array(
        'label' => __('Offset bottom', 'joompress'),
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_offset_bottom',
        'type' => 'number',
    ));

    $wp_customize->add_control('jp_scroll_top_border_width', array(
        'label' => __('Border width', 'joompress'),
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_border_width',
        'type' => 'number',
    ));

    $wp_customize->add_control('jp_scroll_top_border_color', array(
        'label' => __('Border color', 'joompress'),
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_border_color',
        'type' => 'color',
    ));

    $wp_customize->add_control('jp_scroll_top_background_color', array(
        'label' => __('Background color', 'joompress'),
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_background_color',
        'type' => 'color',
    ));

    $wp_customize->add_control('jp_scroll_top_background_color_hover', array(
        'label' => __('Background color hover', 'joompress'),
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_background_color_hover',
        'type' => 'color',
    ));

    $wp_customize->add_control('jp_scroll_top_arrow_color', array(
        'label' => __('Arrow color', 'joompress'),
        'section' => 'jp_scroll_top',
        'settings' => 'jp_scroll_top_arrow_color',
        'type' => 'color',
    ));

    // Section Analytics Tracking Code
    $wp_customize->add_section('jp_analytics', array(
        'title' => __('Analytics', 'joompress'),
        'description' => esc_html__('Analytics Tracking Code', 'joompress'),
        'panel' => 'jp_theme_options',
    ));

    $wp_customize->add_setting('jp_analytics_google_placed', array(
        'default' => 'body',
    ));

    $wp_customize->add_setting('jp_analytics_yandex_placed', array(
        'default' => 'body',
    ));

    $wp_customize->add_setting('jp_analytics_custom_placed', array(
        'default' => 'body',
    ));

    $wp_customize->add_setting('jp_analytics_google', array());

    $wp_customize->add_setting('jp_analytics_yandex', array());

    $wp_customize->add_setting('jp_analytics_custom', array());

    $wp_customize->add_control('jp_analytics_google_placed', array(
        'label' => __('Google Analytics', 'joompress'),
        'description' => esc_html__('Placed (head/body)', 'joompress'),
        'section' => 'jp_analytics',
        'settings' => 'jp_analytics_google_placed',
        'type' => 'select',
        'choices' => array(
            'head' => __('Head', 'joompress'),
            'body' => __('Body', 'joompress'),
        ),
    ));

    $wp_customize->add_control(new WP_Customize_Code_Editor_Control($wp_customize, 'jp_analytics_google', array(
        'label' => 'JavaScript Code',
        'description' => esc_html__('Paste tracking code here &dArr;', 'joompress'),
        'section' => 'jp_analytics',
        'settings' => 'jp_analytics_google',
        'code_type' => 'text/javascript',
        'input_attrs' => array(
            'placeholder' => '',
        ),
    )));

    $wp_customize->add_control('jp_analytics_yandex_placed', array(
        'label' => __('Yandex Metrika', 'joompress'),
        'description' => esc_html__('Placed (head/body)', 'joompress'),
        'section' => 'jp_analytics',
        'settings' => 'jp_analytics_yandex_placed',
        'type' => 'select',
        'choices' => array(
            'head' => __('Head', 'joompress'),
            'body' => __('Body', 'joompress'),
        ),
    ));

    $wp_customize->add_control(new WP_Customize_Code_Editor_Control($wp_customize, 'jp_analytics_yandex', array(
        'description' => esc_html__('Paste tracking code here &dArr;', 'joompress'),
        'section' => 'jp_analytics',
        'settings' => 'jp_analytics_yandex',
        'code_type' => 'text/javascript',
        'input_attrs' => array(
            'placeholder' => '',
        ),
    )));

    $wp_customize->add_control('jp_analytics_custom_placed', array(
        'label' => __('Custom Analytics', 'joompress'),
        'description' => esc_html__('Placed (head/body)', 'joompress'),
        'section' => 'jp_analytics',
        'settings' => 'jp_analytics_custom_placed',
        'type' => 'select',
        'choices' => array(
            'head' => __('Head', 'joompress'),
            'body' => __('Body', 'joompress'),
        ),
    ));

    $wp_customize->add_control(new WP_Customize_Code_Editor_Control($wp_customize, 'jp_analytics_custom', array(
        'description' => esc_html__('Paste tracking code here &dArr;', 'joompress'),
        'section' => 'jp_analytics',
        'settings' => 'jp_analytics_custom',
        'code_type' => 'text/javascript',
        'input_attrs' => array(
            'placeholder' => '',
        ),
    )));

    // Section Login
    $wp_customize->add_section('jp_login', array(
        'title' => __('Login', 'joompress'),
        'description' => esc_html__('Customizer Custom Login', 'joompress'),
        'panel' => 'jp_theme_options',
    ));

    $wp_customize->add_setting('jp_login_logo', array(
        'default' => JP_IMG . '/login-logo.png',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'jp_login_logo', array(
        'label' => __('Logo', 'joompress'),
        'description' => esc_html__('Image size 80x80 px', 'joompress'),
        'section' => 'jp_login',
        'settings' => 'jp_login_logo',
    )));

}

add_action('customize_register', 'jp_customize_register');

/**
 * Customizer Preview
 */
function jp_customizer_preview()
{
    wp_register_script('jp_customizer_preview', JP_JS . '/customizer-preview.js', array(
        'jquery',
        'customize-preview'
    ), null, true);
    wp_enqueue_script('jp_customizer_preview');
}

add_action('customize_preview_init', 'jp_customizer_preview');

/**
 * Customizer Controls
 */
function jp_customize_controls_enqueue_scripts()
{
    wp_register_script('jp_customizer_control', JP_JS . '/customizer-control.js', array(
        'jquery',
        'customize-controls'
    ), null, true);
    wp_enqueue_script('jp_customizer_control');
}

add_action('customize_controls_enqueue_scripts', 'jp_customize_controls_enqueue_scripts');

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
    $offset = get_theme_mod('jp_scroll_top_offset_left_right', 20);

    $output = sprintf('%s: %spx;', $position, $offset);

    echo $output;
}
