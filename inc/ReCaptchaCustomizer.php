<?php

if (!class_exists('ReCaptchaCustomizer')) {
    /**
     * Class ReCaptchaCustomizer
     */
    class ReCaptchaCustomizer
    {
        /**
         * @var array
         */
        public $languages = array(
            'ar' => 'Arabic',
            'af' => 'Afrikaans',
            'am' => 'Amharic',
            'hy' => 'Armenian',
            'az' => 'Azerbaijani',
            'eu' => 'Basque',
            'bn' => 'Bengali',
            'bg' => 'Bulgarian',
            'ca' => 'Catalan',
            'zh-HK' => 'Chinese (Hong Kong)',
            'zh-CN' => 'Chinese (Simplified)',
            'zh-TW' => 'Chinese (Traditional)',
            'hr' => 'Croatian',
            'cs' => 'Czech',
            'da' => 'Danish',
            'nl' => 'Dutch',
            'en-GB' => 'English (UK)',
            'en' => 'English (US)',
            'et' => 'Estonian',
            'fil' => 'Filipino',
            'fi' => 'Finnish',
            'fr' => 'French',
            'fr-CA' => 'French (Canadian)',
            'gl' => 'Galician',
            'ka' => 'Georgian',
            'de' => 'German',
            'de-AT' => 'German (Austria)',
            'de-CH' => 'German (Switzerland)',
            'el' => 'Greek',
            'gu' => 'Gujarati',
            'iw' => 'Hebrew',
            'hi' => 'Hindi',
            'hu' => 'Hungarain',
            'is' => 'Icelandic',
            'id' => 'Indonesian',
            'it' => 'Italian',
            'ja' => 'Japanese',
            'kn' => 'Kannada',
            'ko' => 'Korean',
            'lo' => 'Laothian',
            'lv' => 'Latvian',
            'lt' => 'Lithuanian',
            'ms' => 'Malay',
            'ml' => 'Malayalam',
            'mr' => 'Marathi',
            'mn' => 'Mongolian',
            'no' => 'Norwegian',
            'fa' => 'Persian',
            'pl' => 'Polish',
            'pt' => 'Portuguese',
            'pt-BR' => 'Portuguese (Brazil)',
            'pt-PT' => 'Portuguese (Portugal)',
            'ro' => 'Romanian',
            'ru' => 'Russian',
            'sr' => 'Serbian',
            'si' => 'Sinhalese',
            'sk' => 'Slovak',
            'sl' => 'Slovenian',
            'es' => 'Spanish',
            'es-419' => 'Spanish (Latin America)',
            'sw' => 'Swahili',
            'sv' => 'Swedish',
            'ta' => 'Tamil',
            'te' => 'Telugu',
            'th' => 'Thai',
            'tr' => 'Turkish',
            'uk' => 'Ukrainian',
            'ur' => 'Urdu',
            'vi' => 'Vietnamese',
            'zu' => 'Zulu',
        );

        /**
         * ReCaptchaCustomizer constructor.
         */
        public function __construct()
        {
            add_action('customize_register', array($this, 'customizer'));
        }

        /**
         * Google reCAPTCHA Customizer
         *
         * @param $wp_customize WP_Customize_Manager
         */
        public function customizer($wp_customize)
        {
            // Section reCAPTCHA
            $wp_customize->add_section('jp_recaptcha', array(
                'title' => 'Google reCAPTCHA v2',
                'description' => 'Register your website with Google to get required API keys and enter them below. <a target="_blank" rel="nofollow noopener" href="https://www.google.com/recaptcha/admin#list">Get the API Keys</a>',
                'priority' => 202,
                //'panel' => 'jp_theme_options',
            ));

            $wp_customize->add_setting('jp_recaptcha_site_key', array(
                'default' => '',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('jp_recaptcha_secret_key', array(
                'default' => '',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('jp_recaptcha_login_form', array(
                'default' => false,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('jp_recaptcha_registration_form', array(
                'default' => false,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('jp_recaptcha_reset_password_form', array(
                'default' => false,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('jp_recaptcha_comments_form', array(
                'default' => false,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('jp_recaptcha_theme', array(
                'default' => 'light',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('jp_recaptcha_size', array(
                'default' => 'normal',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('jp_recaptcha_language', array(
                'default' => 0,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('jp_recaptcha_tabindex', array(
                'default' => 0,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('jp_recaptcha_callback', array(
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('jp_recaptcha_expired_callback', array(
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('jp_recaptcha_error_callback', array(
                'sanitize_callback' => '',
            ));

            $wp_customize->selective_refresh->add_partial('jp_recaptcha_site_key', array(
                'selector' => '.jp-g-recaptcha',
            ));

            $wp_customize->add_control('jp_recaptcha_site_key', array(
                'label' => 'Site Key',
                'description' => '<b>Required.</b> Your site key.',
                'section' => 'jp_recaptcha',
                'settings' => 'jp_recaptcha_site_key',
                'type' => 'text',
                'input_attrs' => array(
                    'autocomplete' => 'off',
                ),
            ));

            $wp_customize->add_control('jp_recaptcha_secret_key', array(
                'label' => 'Secret Key',
                'description' => '<b>Required.</b> The shared key between your site and reCAPTCHA. <b>Do not tell anyone.</b>',
                'section' => 'jp_recaptcha',
                'settings' => 'jp_recaptcha_secret_key',
                'type' => 'password',
                'input_attrs' => array(
                    'autocomplete' => 'off',
                ),
            ));

            $wp_customize->add_control('jp_recaptcha_login_form', array(
                'label' => 'Login Form',
                'description' => 'Enable reCAPTCHA for Login Form',
                'section' => 'jp_recaptcha',
                'settings' => 'jp_recaptcha_login_form',
                'type' => 'checkbox',
            ));

            $wp_customize->add_control('jp_recaptcha_registration_form', array(
                'label' => 'Registration Form',
                'description' => 'Enable reCAPTCHA for Registration Form',
                'section' => 'jp_recaptcha',
                'settings' => 'jp_recaptcha_registration_form',
                'type' => 'checkbox',
            ));

            $wp_customize->add_control('jp_recaptcha_reset_password_form', array(
                'label' => 'Reset Password Form',
                'description' => 'Enable reCAPTCHA for Reset Password Form',
                'section' => 'jp_recaptcha',
                'settings' => 'jp_recaptcha_reset_password_form',
                'type' => 'checkbox',
            ));

            $wp_customize->add_control('jp_recaptcha_comments_form', array(
                'label' => 'Comments Form',
                'description' => 'Enable reCAPTCHA for Comments Form',
                'section' => 'jp_recaptcha',
                'settings' => 'jp_recaptcha_comments_form',
                'type' => 'checkbox',
            ));

            $wp_customize->add_control('jp_recaptcha_theme', array(
                'label' => 'Theme',
                'description' => 'Optional. The color theme of the widget.',
                'section' => 'jp_recaptcha',
                'settings' => 'jp_recaptcha_theme',
                'type' => 'select',
                'choices' => array(
                    'dark' => 'Dark',
                    'light' => 'Light',
                ),
            ));

            $wp_customize->add_control('jp_recaptcha_size', array(
                'label' => 'Size',
                'description' => 'Optional. The size of the widget.',
                'section' => 'jp_recaptcha',
                'settings' => 'jp_recaptcha_size',
                'type' => 'select',
                'choices' => array(
                    'compact' => 'Compact',
                    'normal' => 'Normal',
                ),
            ));

            $wp_customize->add_control('jp_recaptcha_language', array(
                'label' => 'Language',
                'description' => 'Optional. Forces the widget to render in a specific language. Auto-detects the user\'s language if unspecified.',
                'section' => 'jp_recaptcha',
                'settings' => 'jp_recaptcha_language',
                'type' => 'select',
                'choices' => array_merge(array(0 => 'Auto-detects'), $this->languages),
            ));

            $wp_customize->add_control('jp_recaptcha_tabindex', array(
                'label' => 'Tab Index',
                'description' => 'Optional. The tabindex of the widget and challenge. If other elements in your page use tabindex, it should be set to make user navigation easier.',
                'section' => 'jp_recaptcha',
                'settings' => 'jp_recaptcha_tabindex',
                'type' => 'number',
                'choices' => array(
                    'min' => 0,
                    'step' => 1,
                ),
            ));

            $wp_customize->add_control('jp_recaptcha_callback', array(
                'label' => 'Callback',
                'description' => 'Optional. The name of your callback function, executed when the user submits a successful response. The <b>g-recaptcha-response</b> token is passed to your callback.',
                'section' => 'jp_recaptcha',
                'settings' => 'jp_recaptcha_callback',
                'type' => 'text',
            ));

            $wp_customize->add_control('jp_recaptcha_expired_callback', array(
                'label' => 'Expired Callback',
                'description' => 'Optional. The name of your callback function, executed when the reCAPTCHA response expires and the user needs to re-verify.',
                'section' => 'jp_recaptcha',
                'settings' => 'jp_recaptcha_expired_callback',
                'type' => 'text',
            ));

            $wp_customize->add_control('jp_recaptcha_error_callback', array(
                'label' => 'Error Callback',
                'description' => 'Optional. The name of your callback function, executed when reCAPTCHA encounters an error (usually network connectivity) and cannot continue until connectivity is restored. If you specify a function here, you are responsible for informing the user that they should retry.',
                'section' => 'jp_recaptcha',
                'settings' => 'jp_recaptcha_error_callback',
                'type' => 'text',
            ));
        }

    }
}

new ReCaptchaCustomizer;
