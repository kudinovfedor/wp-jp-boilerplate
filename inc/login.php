<?php

/**
 * Login Form (logo src)
 *
 * @return void
 */
function jp_login_head()
{
    $default    = JP_IMG . '/login-logo.png';
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

/**
 * Login Form add recaptcha field
 *
 * @return void
 */
function jp_login_form_recaptcha()
{ ?>
    <p class="g-recaptcha" data-size="normal" data-theme="light"
       data-sitekey="<?php echo get_option('captcha_site_key'); ?>"></p>
<?php }

add_action('login_form', 'jp_login_form_recaptcha');

function jp_authenticate_recaptcha_login_form($user, $username, $password)
{
    if ($user instanceof WP_User) {
        return $user;
    }

    //var_dump(isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : 'false');
    //var_dump($user, $username, $password);

    if (isset($_POST['g-recaptcha-response'])) {

        $secret   = get_option('captcha_secret_key');
        $response = wp_remote_get('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . "&response=" . $_POST['g-recaptcha-response']);
        $response = json_decode($response['body'], true);

        if (true === $response['success']) {

            return $user;

        } else {

            return new WP_Error('Captcha Invalid', '<strong>ERROR</strong>: You are a bot!');

        }

    } else {

        return new WP_Error('Captcha Invalid', '<strong>ERROR</strong>: You are a bot! If not then enable JavaScript');

    }

    //die();
}

add_filter('authenticate', 'jp_authenticate_recaptcha_login_form', 10, 3);
