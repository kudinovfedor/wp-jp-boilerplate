<?php

remove_filter('authenticate', 'wp_authenticate_username_password', 20);
remove_filter('authenticate', 'wp_authenticate_email_password', 20);

add_filter('authenticate', 'jp_authenticate_username_password', 20, 3);
add_filter('authenticate', 'jp_authenticate_email_password', 20, 3);

/**
 * Authenticate a user, confirming the username and password are valid.
 *
 * @param WP_User|WP_Error|null $user WP_User or WP_Error object from a previous callback. Default null.
 * @param string $username Username for authentication.
 * @param string $password Password for authentication.
 *
 * @return WP_User|WP_Error WP_User on success, WP_Error on failure.
 */
function jp_authenticate_username_password($user, $username, $password)
{
    if ($user instanceof WP_User) {
        return $user;
    }

    if (empty($username) || empty($password)) {
        if (is_wp_error($user)) {
            return $user;
        }

        $error = new WP_Error();

        if (empty($username)) {
            $error->add('empty_username', '<strong>ERROR</strong>: The username field is empty.');
        }

        if (empty($password)) {
            $error->add('empty_password', '<strong>ERROR</strong>: The password field is empty.');
        }

        return $error;
    }

    $user = get_user_by('login', $username);

    if ( ! $user) {
        return new WP_Error('invalid_username',
            '<strong>ERROR</strong>: Invalid username or password.' .
            ' <a href="' . wp_lostpassword_url() . '">' .
            'Lost your password?' .
            '</a>'
        );
    }

    /**
     * Filters whether the given user can be authenticated with the provided $password.
     *
     * @param WP_User|WP_Error $user WP_User or WP_Error object if a previous callback failed authentication.
     * @param string $password Password to check against the user.
     */
    $user = apply_filters('wp_authenticate_user', $user, $password);
    if (is_wp_error($user)) {
        return $user;
    }

    if ( ! wp_check_password($password, $user->user_pass, $user->ID)) {
        return new WP_Error('incorrect_password',
            sprintf(
            /* translators: %s: user name */
                '<strong>ERROR</strong>: Invalid username or password.',
                '<strong>' . $username . '</strong>'
            ) .
            ' <a href="' . wp_lostpassword_url() . '">' .
            'Lost your password?' .
            '</a>'
        );
    }

    return $user;
}

/**
 * Authenticates a user using the email and password.
 *
 * @since 4.5.0
 *
 * @param WP_User|WP_Error|null $user WP_User or WP_Error object if a previous
 *                                        callback failed authentication.
 * @param string $email Email address for authentication.
 * @param string $password Password for authentication.
 *
 * @return WP_User|WP_Error WP_User on success, WP_Error on failure.
 */
function jp_authenticate_email_password($user, $email, $password)
{
    if ($user instanceof WP_User) {
        return $user;
    }

    if (empty($email) || empty($password)) {
        if (is_wp_error($user)) {
            return $user;
        }

        $error = new WP_Error();

        if (empty($email)) {
            $error->add('empty_username',
                '<strong>ERROR</strong>: The email field is empty.'); // Uses 'empty_username' for back-compat with wp_signon()
        }

        if (empty($password)) {
            $error->add('empty_password', '<strong>ERROR</strong>: The password field is empty.');
        }

        return $error;
    }

    if ( ! is_email($email)) {
        return $user;
    }

    $user = get_user_by('email', $email);

    if ( ! $user) {
        return new WP_Error('invalid_email',
            '<strong>ERROR</strong>: Invalid email address or password.' .
            ' <a href="' . wp_lostpassword_url() . '">' .
            'Lost your password?' .
            '</a>'
        );
    }

    /** This filter is documented in wp-includes/user.php */
    $user = apply_filters('wp_authenticate_user', $user, $password);

    if (is_wp_error($user)) {
        return $user;
    }

    if ( ! wp_check_password($password, $user->user_pass, $user->ID)) {
        return new WP_Error('incorrect_password',
            sprintf(
            /* translators: %s: email address */
                '<strong>ERROR</strong>: Invalid email address or password.',
                '<strong>' . $email . '</strong>'
            ) .
            ' <a href="' . wp_lostpassword_url() . '">' .
            'Lost your password?' .
            '</a>'
        );
    }

    return $user;
}
