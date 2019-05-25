<?php

if (!class_exists('GoogleTagManager')) {
    /**
     * Class GoogleTagManager
     *
     * @author Kudinov Fedor <admin@joompress.biz>
     */
    class GoogleTagManager
    {
        /**
         * Container ID
         *
         * @var string $id
         */
        private $id;

        /**
         * GoogleTagManager constructor.
         */
        public function __construct()
        {
            $this->id = $this->getId();

            add_action('customize_register', [$this, 'customizer']);

            if ($this->getId()) {
                add_action('wp_head',[$this, 'printHead']);
                add_action('wp_body_open', [$this, 'printBody']);
            }
        }

        /**
         * Get container ID
         *
         * @return string
         */
        public function getId()
        {
            return get_theme_mod('jp_google_tag_manager_id', '');
        }

        /**
         * Get array of containers IDs
         *
         * @return array
         */
        public function getArrayIds()
        {
            return explode(
                ',',
                str_replace(
                    [';', ' '],
                    [',', ''],
                    $this->getId()
                )
            );
        }

        /**
         * Prints script in the head tag on the front end.
         *
         * @return void
         */
        public function printHead()
        {
            $output = '<!-- Google Tag Manager -->' . PHP_EOL;

            foreach ($this->getArrayIds() as $id) {

                $output .= "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','" . esc_js($id) . "');</script>" . PHP_EOL;

            }

            $output .= '<!-- End Google Tag Manager -->' . PHP_EOL;

            echo $output;
        }

        /**
         * Prints noscript in the body tag on the front end.
         *
         * @return void
         */
        public function printBody()
        {
            $output = '<!-- Google Tag Manager (noscript) -->' . PHP_EOL;

            foreach ($this->getArrayIds() as $id) {
                $output .= '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' . esc_attr($id) . '" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>' . PHP_EOL;
            }

            $output .= '<!-- End Google Tag Manager (noscript) -->' . PHP_EOL;

            echo $output;
        }

        /**
         * Google Tag Manager Customizer
         *
         * @param $customize WP_Customize_Manager
         */
        public function customizer($customize)
        {
            // Section Google Tag Manager
            $customize->add_section('jp_google_tag_manager', [
                'title' => 'Google Tag Manager',
                'description' => '',
                'priority' => 204,
                //'panel' => 'jp_theme_options',
            ]);

            $customize->add_setting('jp_google_tag_manager_id', [
                'default' => '',
                'sanitize_callback' => 'esc_attr',
            ]);

            $customize->add_control('jp_google_tag_manager_id', [
                'label' => 'Google Tag Manager ID',
                'description' => 'You can get yours <b>container ID</b> <a href="https://www.google.com/analytics/tag-manager/" target="_blank">here</a>! 
                Use comma without space (,) to enter multiple IDs. <br> Add action <b><code>do_action(\'wp_body_open\')</code></b> after opening tag <b>&lt;body&gt;</b> if not added or <b><code>wp_body_open();</code></b>.',
                'section' => 'jp_google_tag_manager',
                'settings' => 'jp_google_tag_manager_id',
                'type' => 'text',
                'input_attrs' => [
                    'placeholder' => 'GTM-XXXXXXX',
                ],
            ]);
        }
    }

    new GoogleTagManager;
}
