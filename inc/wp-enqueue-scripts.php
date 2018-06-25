<?php

/**
 * Enqueue Style And Script
 */
function jp_enqueue_style_script()
{
    $suffix = SCRIPT_DEBUG ? '' : '.min';

    wp_enqueue_style('jp-style', JP_TEMPLATE . '/style' . $suffix . '.css', array(), null);

    wp_register_script('jp-validate',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate' . $suffix . '.js',
        array('jquery'), null, true);

    wp_register_script('jp-common', JP_JS . '/common' . $suffix . '.js', array('jquery'), null, true);
    wp_enqueue_script('jp-common');

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
        wp_enqueue_script('jp-validate');
    }
}

add_action('wp_enqueue_scripts', 'jp_enqueue_style_script');

/**
 * Remove Jquery Migrate
 *
 * @param WP_Scripts $scripts WP_Scripts object.
 */
function jp_remove_jquery_migrate($scripts)
{
    if (is_admin()) {
        return;
    }

    $suffix = SCRIPT_DEBUG ? '' : '.min';
    $jquery_version = '1.12.4';

    $scripts->remove('jquery');
    $scripts->add('jquery', false, array('jquery-core'), $jquery_version);

    $scripts->remove('jquery-core');
    $scripts->add('jquery-core',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery/' . $jquery_version . '/jquery' . $suffix . '.js', array(),
        $jquery_version, array('in_footer' => true));
    //$scripts->add('jquery-core', JP_JS . '/libs/jquery' . $suffix . '.js', array(), null, 1);

    $scripts->add_data('jquery', 'group', 1);
    $scripts->add_data('jquery-core', 'group', 1);
    $scripts->add_data('jquery-migrate', 'group', 1);
}

add_action('wp_default_scripts', 'jp_remove_jquery_migrate', 11);

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
 * wp_head Analytics Tracking Code
 *
 * @return void
 */
function jp_wp_head()
{
    analytics_tracking_code('head');
}

add_action('wp_head', 'jp_wp_head', 20);

/**
 * wp_footer Analytics Tracking Code
 *
 * @return void
 */
function jp_wp_footer()
{
    analytics_tracking_code('body');
}

add_action('wp_footer', 'jp_wp_footer', 20);

/**
 * @param $tag
 * @param $handle
 *
 * @return mixed
 */
function jp_add_async_attribute($tag, $handle)
{
    $scripts_to_async = array('jp-js-handle');

    foreach ($scripts_to_async as $async_script) {

        if ($async_script === $handle) {

            return str_replace(' src', ' async src', $tag);

        }

    }

    return $tag;

}

add_filter('script_loader_tag', 'jp_add_async_attribute', 10, 2);

/**
 * @param $tag
 * @param $handle
 *
 * @return mixed
 */
function jp_add_defer_attribute($tag, $handle)
{
    $scripts_to_defer = array('jp-js-handle');

    foreach ($scripts_to_defer as $defer_script) {

        if ($defer_script === $handle) {

            return str_replace(' src', ' defer src', $tag);

        }

    }

    return $tag;
}

add_filter('script_loader_tag', 'jp_add_defer_attribute', 10, 2);

/**
 * @param $tag
 * @param $handle
 *
 * @return mixed
 */
function jp_add_async_defer_attribute($tag, $handle)
{
    $scripts = array('jp-js-handle');

    foreach ($scripts as $script) {

        if ($script === $handle) {

            return str_replace(' src', ' async defer src', $tag);

        }
    }

    return $tag;
}

add_filter('script_loader_tag', 'jp_add_async_defer_attribute', 10, 2);
