<?php

/**
 * Login Form add reCAPTCHA field
 *
 * @return void
 */
function jp_login_form_recaptcha()
{
    $recaptcha = get_recaptcha_tag_attributes();
    ?>
    <style>.g-recaptcha {-webkit-transform: scale(0.895);-moz-transform: scale(0.895);-ms-transform: scale(0.895);-o-transform: scale(0.895);transform: scale(0.895);-webkit-transform-origin: 0 0;-moz-transform-origin: 0 0;-ms-transform-origin: 0 0;-o-transform-origin: 0 0;transform-origin: 0 0;margin-bottom: 15px;}</style>
    <div class="g-recaptcha"
         data-size="<?php echo esc_attr($recaptcha['size']); ?>"
         data-theme="<?php echo esc_attr($recaptcha['theme']); ?>"
         data-sitekey="<?php echo esc_attr($recaptcha['site-key']); ?>"
         data-tabindex="<?php echo esc_attr($recaptcha['tabindex']); ?>"
    ></div>
<?php }

add_action('login_form', 'jp_login_form_recaptcha');
add_action('register_form', 'jp_login_form_recaptcha');
add_action('lostpassword_form', 'jp_login_form_recaptcha');

/**
 * Authenticate a user, confirming the reCAPTCHA are valid.
 *
 * @param WP_User|WP_Error|null $user - WP_User or WP_Error object from a previous callback. Default null.
 * @param string $username - Username for authentication.
 * @param string $password - Password for authentication.
 *
 * @return WP_User|WP_Error WP_User on success, WP_Error on failure.
 */
function jp_check_recaptcha_login_form($user, $username, $password)
{
    if (is_wp_error($user)) {
        return $user;
    }

    $error = new WP_Error();

    $g_recaptcha = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';

    if (empty($g_recaptcha)) {

        $error->add('empty_input_response', '<strong>ERROR</strong>: reCAPTCHA checkbox should be marked.');

        return $error;
    }

    $query_data = array(
        'secret'   => get_theme_mod('jp_recaptcha_secret_key'),
        'response' => $g_recaptcha,
        'remoteip' => jp_get_ip() || '127.0.0.1',
    );

    $query = http_build_query($query_data);

    $url = sprintf('https://www.google.com/recaptcha/api/siteverify?%s', $query);

    $response = wp_remote_get($url);
    $response = json_decode($response['body'], true);

    if (true === $response['success']) {

        return $user;

    } else {

        foreach ($response['error-codes'] as $item) {
            if ('invalid_secret_key' === $item) {
                $error->add('invalid_secret_key',
                    '<strong>ERROR</strong>: Please check the validity of the reCAPTCHA keys.');
            } else {
                $error->add('recaptcha_error', '<strong>ERROR</strong>: Please try again');
            }
        }

        return $error;

    }
}

add_filter('authenticate', 'jp_check_recaptcha_login_form', 20, 3);
//add_filter('registration_errors', 'jp_check_recaptcha_register_form', 10, 1);
//add_filter('allow_password_reset', 'jp_check_recaptcha_password_reset_form', 10, 1);
