<?php

if (!class_exists('Phones')) {
    /**
     * Class Phones
     *
     * @author Kudinov Fedor <admin@joompress.biz>
     */
    class Phones
    {
        /**
         * Phones constructor.
         */
        public function __construct()
        {
            add_action('customize_register', [$this, 'customizeRegister']);
            add_shortcode('jp_phones', [$this, 'addShortcode']);
        }

        /**
         * Return Phone Number in array
         *
         * @return array
         */
        public function getPhones()
        {
            $_phones = [
                get_theme_mod('jp_phone_one'),
                get_theme_mod('jp_phone_two'),
                get_theme_mod('jp_phone_three'),
                get_theme_mod('jp_phone_four'),
                get_theme_mod('jp_phone_five'),
            ];

            $phones = array_filter($_phones, function ($value) {
                return !empty($value);
            });

            return $phones;
        }

        /**
         * HTML Markup (Phones)
         *
         * @see getPhones()
         *
         * @return string
         */
        public function getMarkup()
        {
            $items = '';

            foreach ($this->getPhones() as $phone) {

                $icon = '<i class="fas fa-phone fa-fw" aria-hidden="true"></i>';

                $number = sprintf(
                    '<a class="phone-number" href="tel:%s">%s %s</a>',
                    esc_attr($this->clearPhoneNumber($phone)),
                    $icon,
                    esc_html($phone)
                );

                $item = sprintf('<li class="phone-item">%s</li>', $number);

                $items .= $item . PHP_EOL;

            }

            $html = empty($items) ? $items : sprintf('<ul class="phone">%s</ul>', $items);

            return $html;
        }

        /**
         * Add Shortcode Phones
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
            // Section Phones
            $customize->add_section('jp_phones', [
                'title' => 'Phones',
                'description' => 'Customizer Custom Phone numbers',
                'panel' => 'jp_theme_options',
            ]);

            $customize->add_setting('jp_phone_one', ['sanitize_callback' => '',]);
            $customize->add_setting('jp_phone_two', ['sanitize_callback' => '',]);
            $customize->add_setting('jp_phone_three', ['sanitize_callback' => '',]);
            $customize->add_setting('jp_phone_four', ['sanitize_callback' => '',]);
            $customize->add_setting('jp_phone_five', ['sanitize_callback' => '',]);

            $customize->selective_refresh->add_partial('jp_phone_one', [
                'selector' => '.phone',
            ]);

            $customize->add_control('jp_phone_one', [
                'label' => 'Phone 1',
                'section' => 'jp_phones',
                'settings' => 'jp_phone_one',
                'type' => 'tel',
            ]);

            $customize->add_control('jp_phone_two', [
                'label' => 'Phone 2',
                'section' => 'jp_phones',
                'settings' => 'jp_phone_two',
                'type' => 'tel',
            ]);

            $customize->add_control('jp_phone_three', [
                'label' => 'Phone 3',
                'section' => 'jp_phones',
                'settings' => 'jp_phone_three',
                'type' => 'tel',
            ]);

            $customize->add_control('jp_phone_four', [
                'label' => 'Phone 4',
                'section' => 'jp_phones',
                'settings' => 'jp_phone_four',
                'type' => 'tel',
            ]);

            $customize->add_control('jp_phone_five', [
                'label' => 'Phone 5',
                'section' => 'jp_phones',
                'settings' => 'jp_phone_five',
                'type' => 'tel',
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

    new Phones();
}
