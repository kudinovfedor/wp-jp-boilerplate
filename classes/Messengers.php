<?php

if (!class_exists('Messengers')) {
    /**
     * Class Messengers
     *
     * @author Kudinov Fedor <admin@joompress.biz>
     */
    class Messengers
    {
        /**
         * Messengers constructor.
         */
        public function __construct()
        {
            add_action('customize_register', [$this, 'customizeRegister']);
            add_shortcode('jp_messengers', [$this, 'addShortcode']);
        }

        /**
         * Return Messengers in array
         *
         * @return array
         */
        public function getMessengers()
        {
            $_messengers = [
                'skype' => [
                    'value' => get_theme_mod('jp_messenger_skype'),
                    'action' => get_theme_mod('jp_messenger_skype_action'),
                    'text' => 'Skype',
                    'icon' => 'fab fa-skype',
                ],
                'viber' => [
                    'value' => get_theme_mod('jp_messenger_viber'),
                    'action' => get_theme_mod('jp_messenger_viber_action'),
                    'text' => 'Viber',
                    'icon' => 'fab fa-viber',
                ],
                'whatsapp' => [
                    'value' => get_theme_mod('jp_messenger_whatsapp'),
                    'action' => get_theme_mod('jp_messenger_whatsapp_action'),
                    'text' => 'WhatsApp',
                    'icon' => 'fab fa-whatsapp',
                ],
                'telegram' => [
                    'value' => get_theme_mod('jp_messenger_telegram'),
                    'action' => get_theme_mod('jp_messenger_telegram_action'),
                    'text' => 'Telegram',
                    'icon' => 'fab fa-telegram-plane',
                ],
            ];

            $messengers = array_filter($_messengers, function ($value) {
                return !empty($value['value']);
            });

            return $messengers;
        }

        /**
         * HTML Markup (Messengers)
         *
         * @see getMessengers()
         *
         * @return string
         */
        public function getMarkup()
        {
            $actions = [
                'skype' => [
                    'none' => 'tel:%s',
                    'add' => 'skype:%s?add',
                    'chat' => 'skype:%s?chat',
                    'call' => 'skype:%s?call',
                    'video' => 'skype:%s?call&video=true',
                    'userinfo' => 'skype:%s?userinfo',
                    'sendfile' => 'skype:%s?sendfile',
                    'voicemail' => 'skype:%s?voicemail',
                ],
                'viber' => [
                    'none' => 'tel:%s',
                ],
                'whatsapp' => [
                    'none' => 'tel:%s',
                ],
                'telegram' => [
                    'none' => 'tel:%s',
                ],
            ];

            $items = '';

            foreach ($this->getMessengers() as $name => $messenger) {

	            $icon = sprintf('<i class="%s" aria-hidden="true"></i>', esc_attr($messenger['icon']));

                $readerText = sprintf('<span class="screen-reader-text">%s</span>', esc_html($messenger['text']));

                $value = $this->clearPhoneNumber($messenger['value']);
                $action = $messenger['action'] ? sprintf($actions[$name][$messenger['action']], $value) : sprintf('tel:%s', $value);

                $link = sprintf(
                    '<a class="messenger-link messenger-%s" href="%s" aria-label="%s">%s %s</a>',
                    esc_attr($name),
                    esc_attr($action),
	                esc_attr($messenger['text']),
                    $icon,
	                $readerText
                );

                $item = sprintf('<li class="messenger-item">%s</li>', $link);

                $items .= $item . PHP_EOL;
            }

            $html = empty($items) ? $items : sprintf('<ul class="messenger">%s</ul>', $items);

            return $html;
        }

        /**
         * Add Shortcode Messengers
         *
         * @param array $atts
         *
         * @return string
         */
        public function addShortcode($atts)
        {
            // Attributes
            $atts = shortcode_atts(
                [],
                $atts
            );

            return $this->getMarkup();
        }

        /**
         * Customize
         *
         * @param $customize WP_Customize_Manager
         *
         * @return void
         */
        public function customizeRegister($customize)
        {
            // Section Messenger
            $customize->add_section('jp_messenger', [
                'title' => 'Messenger',
                'description' => 'Customizer Custom Messenger links',
                'panel' => 'jp_theme_options',
            ]);

            $customize->add_setting('jp_messenger_skype', ['default' => '', 'sanitize_callback' => '',]);
            $customize->add_setting('jp_messenger_skype_action', ['default' => 'none', 'sanitize_callback' => '',]);
            $customize->add_setting('jp_messenger_viber', ['default' => '', 'sanitize_callback' => '',]);
            $customize->add_setting('jp_messenger_viber_action', ['default' => 'none', 'sanitize_callback' => '',]);
            $customize->add_setting('jp_messenger_whatsapp', ['default' => '', 'sanitize_callback' => '',]);
            $customize->add_setting('jp_messenger_whatsapp_action', ['default' => 'none', 'sanitize_callback' => '',]);
            $customize->add_setting('jp_messenger_telegram', ['default' => '', 'sanitize_callback' => '',]);
            $customize->add_setting('jp_messenger_telegram_action', ['default' => 'none', 'sanitize_callback' => '',]);

            $customize->selective_refresh->add_partial('jp_messenger_skype', [
                'selector' => '.messenger',
            ]);

            $customize->add_control('jp_messenger_skype', [
                'label' => 'Skype',
                'description' => 'Telephone or Username (for multichat, specify usernames separated by a semicolon) <br><b>Use action setting only when username is specified.</b> ',
                'section' => 'jp_messenger',
                'settings' => 'jp_messenger_skype',
                'type' => 'text',
            ]);

            $customize->add_control('jp_messenger_skype_action', [
                'label' => 'Action',
                'section' => 'jp_messenger',
                'settings' => 'jp_messenger_skype_action',
                'type' => 'select',
                'choices' => [
                    'none' => 'None',
                    'add' => 'Add user',
                    'chat' => 'Chat',
                    'call' => 'Call',
                    'video' => 'Video',
                    'userinfo' => 'User profile',
                    'sendfile' => 'Send file to share',
                    'voicemail' => 'Send voice email',
                ],
            ]);

            $customize->add_control('jp_messenger_viber', [
                'label' => 'Viber',
                'section' => 'jp_messenger',
                'settings' => 'jp_messenger_viber',
                'type' => 'tel',
            ]);

            $customize->add_control('jp_messenger_viber_action', [
                'label' => 'Action',
                'section' => 'jp_messenger',
                'settings' => 'jp_messenger_viber_action',
                'type' => 'select',
                'choices' => [
                    'none' => 'None',
                ],
            ]);

            $customize->add_control('jp_messenger_whatsapp', [
                'label' => 'WhatsApp',
                'section' => 'jp_messenger',
                'settings' => 'jp_messenger_whatsapp',
                'type' => 'tel',
            ]);

            $customize->add_control('jp_messenger_whatsapp_action', [
                'label' => 'Action',
                'section' => 'jp_messenger',
                'settings' => 'jp_messenger_whatsapp_action',
                'type' => 'select',
                'choices' => [
                    'none' => 'None',
                ],
            ]);

            $customize->add_control('jp_messenger_telegram', [
                'label' => 'Telegram',
                'section' => 'jp_messenger',
                'settings' => 'jp_messenger_telegram',
                'type' => 'tel',
            ]);

            $customize->add_control('jp_messenger_telegram_action', [
                'label' => 'Action',
                'section' => 'jp_messenger',
                'settings' => 'jp_messenger_telegram_action',
                'type' => 'select',
                'choices' => [
                    'none' => 'None',
                ],
            ]);
        }

        /**
         * Clean Phone Number
         *
         * @param string $phoneNumber
         *
         * @return string
         */
        private function clearPhoneNumber($phoneNumber)
        {
            return str_replace(['-', '(', ')', ' '], '', $phoneNumber);
        }
    }

    new Messengers();
}
