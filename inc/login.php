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

/**
 * Login Form (error messages displayed above the login form)
 *
 * @param string $errors Login error message.
 *
 * @return string
 */
function jp_login_error($errors)
{
    //$errors = __('<strong>ERROR:</strong> The username or password is incorrect.', 'joompress');

    return $errors;
}

add_filter('login_errors', 'jp_login_error');

/**
 * Error codes array for shaking the login form.
 *
 * @param array $shake_error_codes Error codes that shake the login form.
 *
 * @return array
 */
function jp_shake_error_codes($shake_error_codes)
{
    $new_error_codes = array(
        'recaptcha_empty_input_response',
        'recaptcha_error',
    );

    foreach ($new_error_codes as $error) {
        if (!in_array($error, $shake_error_codes, true)) {
            $shake_error_codes[] = $error;
        }
    }

    return $shake_error_codes;
}

add_filter('shake_error_codes', 'jp_shake_error_codes');
