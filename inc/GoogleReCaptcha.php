<?php

if (!class_exists('GoogleReCaptcha')) {
    /**
     * Class GoogleReCaptcha
     *
     * @author Kudinov Fedor <admin@joompress.biz>
     */
    class GoogleReCaptcha
    {
        /**
         * @var array
         */
        public $options = array();

        /**
         * @var array
         */
        public $error_code = array(
            'missing-input-secret' => 'ReCaptcha: The secret parameter is missing.',
            'invalid-input-secret' => 'ReCaptcha: The secret parameter is invalid or malformed.',
            'missing-input-response' => 'ReCaptcha: The response parameter is missing.',
            'invalid-input-response' => 'ReCaptcha: The response parameter is invalid or malformed.',
            'bad-request' => 'ReCaptcha: The request is invalid or malformed.',
        );

        /**
         * GoogleReCaptcha constructor.
         */
        public function __construct()
        {
            $this->options = array(
                'site-key' => get_theme_mod('jp_recaptcha_site_key'),
                'secret-key' => get_theme_mod('jp_recaptcha_secret_key'),
                'login-form' => get_theme_mod('jp_recaptcha_login_form'),
                'registration-form' => get_theme_mod('jp_recaptcha_registration_form'),
                'reset-password-form' => get_theme_mod('jp_recaptcha_reset_password_form'),
                'comments-form' => get_theme_mod('jp_recaptcha_comments_form'),
                'theme' => get_theme_mod('jp_recaptcha_theme', 'light'),
                'size' => get_theme_mod('jp_recaptcha_size', 'normal'),
                'language' => get_theme_mod('jp_recaptcha_language', 0),
                'tabindex' => get_theme_mod('jp_recaptcha_tabindex', 0),
                'callback' => get_theme_mod('jp_recaptcha_callback'),
                'expired-callback' => get_theme_mod('jp_recaptcha_expired_callback'),
                'error-callback' => get_theme_mod('jp_recaptcha_error_callback'),
            );

            if ($this->isEnabled()) {

                if ($this->isReCaptchaRequired('login') || $this->isReCaptchaRequired('registration') || $this->isReCaptchaRequired('reset-password')) {
                    add_action('login_enqueue_scripts', array($this, 'cssLogin'));
                    add_action('login_enqueue_scripts', array($this, 'enqueueScripts'));
                }

                if ($this->isReCaptchaRequired('login')) {
                    add_action('login_form', array($this, 'htmlMarkup'));
                    add_filter('authenticate', array($this, 'checkLoginForm'), 20, 3);
                }

                if ($this->isReCaptchaRequired('registration')) {
                    add_action('register_form', array($this, 'htmlMarkup'));
                    add_filter('registration_errors', array($this, 'checkRegistrationForm'), 10, 3);
                }

                if ($this->isReCaptchaRequired('reset-password')) {
                    add_action('lostpassword_form', array($this, 'htmlMarkup'));
                    add_filter('allow_password_reset', array($this, 'checkResetPasswordForm'));
                }

                if ($this->isReCaptchaRequired('comments') || is_customize_preview()) {

                    add_action('comment_form_after_fields', array($this, 'htmlMarkup'));
                    add_action('comment_form_logged_in_after', array($this, 'htmlMarkup'));

                    add_action('pre_comment_on_post', array($this, 'checkCommentsForm'));

                    add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));

                }

            }
        }

        /**
         * @return bool
         */
        public function isEnabled()
        {
            return $this->options['site-key'] && $this->options['secret-key'];
        }

        /**
         * @param $name
         *
         * @return mixed
         */
        public function isReCaptchaRequired($name)
        {
            return $this->options[$name . '-form'];
        }

        /**
         * @return void
         */
        public function cssLogin()
        {
            $style = '<style>.login .g-recaptcha{margin:0 -15px 15px}</style>';

            echo $style;
        }

        /**
         * Registers the script and enqueues it.
         *
         * @return void
         */
        public function enqueueScripts()
        {
            $query_data = array(
                'onload' => '',
                'render' => '',
                'hl' => get_theme_mod('jp_recaptcha_language'),
            );


            $query_data = array_filter($query_data, function ($value, $key) {
                return !empty($value);
            }, ARRAY_FILTER_USE_BOTH);

            $query = http_build_query($query_data);

            $src = 'https://www.google.com/recaptcha/api.js';

            if (!empty($query)) {
                $src = sprintf($src . '?%s', $query);
            }

            wp_register_script('jp_recaptcha', $src, array(), null, false);

            if ($this->is_comments() || $this->is_login_page() || is_customize_preview()) {
                wp_enqueue_script('jp_recaptcha');
            }

        }

        /**
         * Displays HTML Markup
         *
         * @return void
         */
        public function htmlMarkup()
        {
            $opt = $this->options;

            $markup = sprintf(
                '<div class="g-recaptcha" data-size="%s" data-theme="%s" data-sitekey="%s" data-tabindex="%d"></div>',
                esc_attr($opt['size']), esc_attr($opt['theme']), esc_attr($opt['site-key']), esc_attr($opt['tabindex'])
            );

            if (is_customize_preview()) {
                $markup = sprintf('<div class="jp-g-recaptcha">%s</div>', $markup);
            }

            if (is_singular()) {
                $markup = sprintf('<div class="form-row comment-form-recapthca">%s</div>', $markup);
            }

            echo $markup;
        }

        /**
         * Get Response from ReCaptcha API
         *
         * @param string $recaptcha
         * @return array|WP_Error
         */
        public function getResponse($recaptcha)
        {
            $query_data = array(
                'secret' => $this->options['secret-key'],
                'response' => $recaptcha,
                'remoteip' => $this->getIP() || '127.0.0.1',
            );

            $query = http_build_query($query_data);

            $url = sprintf('https://www.google.com/recaptcha/api/siteverify?%s', $query);

            $response = wp_remote_post($url, array(
                'timeout' => 30,
                'sslverify' => true,
            ));

            return json_decode($response['body'], true);
        }

        /**
         * Authenticate a user on Login form, confirming the reCAPTCHA are valid.
         *
         * @param WP_User|WP_Error|null $user - WP_User or WP_Error object from a previous callback. Default null.
         * @param string $username - Username for authentication.
         * @param string $password - Password for authentication.
         *
         * @return WP_User|WP_Error WP_User on success, WP_Error on failure.
         */
        public function checkLoginForm($user, $username, $password)
        {
            if (is_wp_error($user)) {
                return $user;
            }

            $errors = new WP_Error();

            $g_recaptcha = $_POST['g-recaptcha-response'] ?: '';

            if (empty($g_recaptcha)) {

                $errors->add('recaptcha_empty_input_response',
                    '<strong>ERROR</strong>: reCAPTCHA checkbox should be marked.');

                return $errors;
            }

            $response = $this->getResponse($g_recaptcha);

            if (true === $response['success']) {

                return $user;

            } else {

                foreach ($response['error-codes'] as $item) {
                    if (array_key_exists($item, $this->error_code)) {
                        $errors->add($item, '<strong>ERROR</strong>: ' . $this->error_code[$item]);
                    } else {
                        $errors->add('recaptcha_error', '<strong>ERROR</strong>: Please try again.');
                    }
                }

                return $errors;

            }
        }

        /**
         * Check Registration Form
         *
         * @param WP_Error $errors A WP_Error object containing any errors encountered during registration.
         * @param string $sanitized_user_login User's username after it has been sanitized.
         * @param string $user_email User's email.
         *
         * @return WP_Error
         */
        public function checkRegistrationForm($errors, $sanitized_user_login, $user_email)
        {
            $g_recaptcha = $_POST['g-recaptcha-response'] ?: '';

            if (empty($g_recaptcha)) {

                /** @var WP_Error $errors */
                $errors->add('recaptcha_empty_input_response',
                    '<strong>ERROR</strong>: reCAPTCHA checkbox should be marked.');

                return $errors;
            }

            $response = $this->getResponse($g_recaptcha);

            if (true === $response['success']) {

                return $errors;

            } else {

                foreach ($response['error-codes'] as $item) {
                    if (array_key_exists($item, $this->error_code)) {
                        $errors->add($item, '<strong>ERROR</strong>: ' . $this->error_code[$item]);
                    } else {
                        $errors->add('recaptcha_error', '<strong>ERROR</strong>: Please try again.');
                    }
                }

                return $errors;

            }
        }

        /**
         * Check Reset Password Form
         *
         * @param bool $allow
         *
         * @return bool|WP_Error
         */
        public function checkResetPasswordForm($allow)
        {
            $errors = new WP_Error();

            $g_recaptcha = $_POST['g-recaptcha-response'] ?: '';

            if (empty($g_recaptcha)) {

                $errors->add('recaptcha_empty_input_response',
                    '<strong>ERROR</strong>: reCAPTCHA checkbox should be marked.');

                return $errors;
            }

            $response = $this->getResponse($g_recaptcha);

            if (true === $response['success']) {

                return $allow;

            } else {

                foreach ($response['error-codes'] as $item) {
                    if (array_key_exists($item, $this->error_code)) {
                        $errors->add($item, '<strong>ERROR</strong>: ' . $this->error_code[$item]);
                    } else {
                        $errors->add('recaptcha_error', '<strong>ERROR</strong>: Please try again.');
                    }
                }

                return $errors;

            }
        }

        /**
         * Check Comments Form
         */
        public function checkCommentsForm()
        {
            $g_recaptcha = $_POST['g-recaptcha-response'] ?: '';

            if (empty($g_recaptcha)) {

                wp_die('<strong>ERROR</strong>: reCAPTCHA checkbox should be marked. <a href="javascript:history.back()">&laquo; Back</a>');

            }

            $response = $this->getResponse($g_recaptcha);

            if (false === $response['success']) {

                wp_die('<strong>ERROR</strong>: Click the BACK button on your browser and try again. <a href="javascript:history.back()">&laquo; Back</a>');

            }

            return;
        }

        /**
         * Get client IP.
         *
         * @return string|null
         */
        public function getIP()
        {
            $fields = array(
                'HTTP_CLIENT_IP',
                'HTTP_X_FORWARDED_FOR',
                'HTTP_X_FORWARDED',
                'HTTP_FORWARDED_FOR',
                'HTTP_FORWARDED',
                'REMOTE_ADDR',
            );

            foreach ($fields as $ip_field) {
                if (!empty($_SERVER[$ip_field])) {
                    return $_SERVER[$ip_field];
                }
            }

            return null;
        }

        /**
         * Get options
         *
         * @return array
         */
        public function getOptions()
        {
            return $this->options;
        }

        /**
         * Checking is the login page
         *
         * @return bool
         */
        public function is_login_page()
        {
            return in_array($GLOBALS['pagenow'], array('wp-login.php'));
        }

        /**
         * Checking allowed comments
         *
         * @return bool
         */
        public function is_comments()
        {
            return is_singular() && comments_open() && get_option('thread_comments');
        }

    }

    new GoogleReCaptcha;
}
