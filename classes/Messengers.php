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
         * Determines whether the site has a messenger.
         *
         * @see getMessengers()
         *
         * @return bool
         */
        public function hasMessengers()
        {
            return (bool)$this->getMessengers();
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
                    'tel' => get_theme_mod('jp_messenger_skype'),
                    'text' => 'Skype',
                    'icon' => 'fab fa-skype',
                ],
                'viber' => [
                    'tel' => get_theme_mod('jp_messenger_viber'),
                    'text' => 'Viber',
                    'icon' => 'fab fa-viber',
                ],
                'whatsapp' => [
                    'tel' => get_theme_mod('jp_messenger_whatsapp'),
                    'text' => 'WhatsApp',
                    'icon' => 'fab fa-whatsapp',
                ],
                'telegram' => [
                    'tel' => get_theme_mod('jp_messenger_telegram'),
                    'text' => 'Telegram',
                    'icon' => 'fab fa-telegram-plane',
                ],
            ];

            $messengers = array_filter($_messengers, function ($value) {
                return !empty($value['tel']);
            });

            return $messengers;
        }

        /**
         * HTML Markup (Messengers)
         *
         * @see hasMessengers()
         * @see getMessengers()
         *
         * @return string
         */
        public function getMarkup()
        {
            if ($this->hasMessengers()) {

                $items = '';

                foreach ($this->getMessengers() as $name => $messenger) {

                    $icon = sprintf(
                        '<i class="%s" aria-hidden="true" aria-label="%s"></i>',
                        esc_attr($messenger['icon']),
                        esc_attr($messenger['text'])
                    );

                    $text = sprintf('<span class="screen-reader-text">%s</span>', esc_attr($messenger['text']));

                    $link = sprintf(
                        '<a class="messenger-link messenger-%s" href="tel:%s" target="_blank" rel="nofollow noopener">%s %s</a>',
                        esc_attr($name),
                        esc_attr(get_phone_number($messenger['tel'])),
                        $icon,
                        $text
                    );

                    $item = sprintf('<li class="messenger-item">%s</li>', $link);

                    $items .= $item . PHP_EOL;
                }

                $list = sprintf('<ul class="messenger">%s</ul>', $items);

                return $list;

            }

            return null;
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

            $output = '';

            if ($this->hasMessengers()) {
                $items = '';

                foreach ($this->getMessengers() as $name => $messenger) {
                    $icon = sprintf(
                        '<i class="%s" aria-hidden="true" aria-label="%s"></i>',
                        esc_attr($messenger['icon']),
                        esc_attr($messenger['text'])
                    );

                    $text = sprintf('<span class="screen-reader-text">%s</span>', esc_attr($messenger['text']));

                    $link = sprintf(
                        '<a class="messenger-link messenger-%s" href="tel:%s" target="_blank" rel="nofollow noopener">%s %s</a>',
                        esc_attr($name),
                        esc_attr(get_phone_number($messenger['tel'])),
                        $icon,
                        $text
                    );

                    $item = sprintf('<li class="messenger-item">%s</li>', $link);

                    $items .= $item . PHP_EOL;
                }

                $output = sprintf('<ul class="messenger">%s</ul>', $items);
            }

            return $output;
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
            $customize->add_setting('jp_messenger_viber', ['default' => '', 'sanitize_callback' => '',]);
            $customize->add_setting('jp_messenger_whatsapp', ['default' => '', 'sanitize_callback' => '',]);
            $customize->add_setting('jp_messenger_telegram', ['default' => '', 'sanitize_callback' => '',]);

            $customize->selective_refresh->add_partial('jp_messenger_skype', [
                'selector' => '.messenger',
            ]);

            $customize->add_control('jp_messenger_skype', [
                'label' => 'Skype',
                'section' => 'jp_messenger',
                'settings' => 'jp_messenger_skype',
                'type' => 'tel',
            ]);

            $customize->add_control('jp_messenger_viber', [
                'label' => 'Viber',
                'section' => 'jp_messenger',
                'settings' => 'jp_messenger_viber',
                'type' => 'tel',
            ]);

            $customize->add_control('jp_messenger_whatsapp', [
                'label' => 'WhatsApp',
                'section' => 'jp_messenger',
                'settings' => 'jp_messenger_whatsapp',
                'type' => 'tel',
            ]);

            $customize->add_control('jp_messenger_telegram', [
                'label' => 'Telegram',
                'section' => 'jp_messenger',
                'settings' => 'jp_messenger_telegram',
                'type' => 'tel',
            ]);
        }
    }

    new Messengers();
}
