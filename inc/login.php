<?php

/**
 * Login Form (logo src)
 *
 * @return void
 */
function jp_login_head()
{
    $default = JP_IMG . '/login-logo.png';
    $login_logo = get_theme_mod('jp_login_logo', $default);

    echo sprintf('<style>.login h1 a{background-image: url("%s"); }</style>', $login_logo);
}

add_action('login_head', 'jp_login_head');

/**
 * Login Form (authorization error)
 *
 * @return string
 */
function jp_login_error()
{
    return __('<strong>ERROR:</strong> The username and password is incorrect.', 'joompress');
}

add_filter('login_errors', 'jp_login_error');

/**
 * Login Form (logo url)
 *
 * @return string
 */
function jp_login_header_url()
{
    return esc_attr(esc_url(site_url()));
}

add_filter('login_headerurl', 'jp_login_header_url');

/**
 * Login Form (logo title)
 *
 * @return string
 */
function jp_login_header_title()
{
    return esc_attr(get_bloginfo('name'));
}

add_filter('login_headertitle', 'jp_login_header_title');
