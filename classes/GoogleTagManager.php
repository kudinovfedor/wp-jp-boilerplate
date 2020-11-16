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
	     * Container AMP ID
	     *
	     * @var string $ampId
	     */
	    private $ampId;

        /**
         * GoogleTagManager constructor.
         */
        public function __construct()
        {
            $this->id = $this->getId();
            $this->ampId = $this->getAmpId();

            add_action('customize_register', [$this, 'customizer']);

            if ($this->getId()) {
                add_action('wp_head', [$this, 'printHead']);
                add_action('wp_body_open', [$this, 'printBody']);
            }

	        if ($this->getAmpId()) {
		        add_action('wp_footer', function () {
			        if (function_exists('amp_is_request') && amp_is_request()) {
				        $this->printComponent();
			        }
		        });
		        add_filter('amp_post_template_data', [$this, 'enableAmpAnalytics']);
		        add_action('amp_post_template_footer', [$this, 'printComponent']);
	        }
        }

        /**
         * Get container ID
         *
         * @return string
         */
        public function getId()
        {
            return get_theme_mod('jp_gtm_id', '');
        }

        /**
         * Get container AMP ID
         *
         * @return string
         */
        public function getAmpId()
        {
            return get_theme_mod('jp_gtm_amp_id', '');
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
	     * Print amp-analytics
	     *
	     * @return void
	     */
	    public function printComponent()
	    {
		    printf(
			    '<amp-analytics config="https://www.googletagmanager.com/amp.json?id=%s&gtm.url=SOURCE_URL" data-credentials="include"></amp-analytics>',
			    esc_attr($this->getAmpId())
		    );
	    }

	    /**
	     * @param array $data
	     */
	    public function enableAmpAnalytics($data)
	    {
		    $data['amp_component_scripts'] = array_merge(
		    	$data['amp_component_scripts'],
			    ['amp-analytics' => true]
		    );
	    }

        /**
         * Google Tag Manager Customizer
         *
         * @param $customize WP_Customize_Manager
         */
        public function customizer($customize)
        {
            // Section Google Tag Manager
            $customize->add_section('jp_gtm', [
                'title' => 'Google Tag Manager',
                'description' => '',
                'priority' => 204,
                //'panel' => 'jp_theme_options',
            ]);

            $customize->add_setting('jp_gtm_id', [
                'default' => '',
                'sanitize_callback' => 'esc_attr',
            ]);

	        $customize->add_setting('jp_gtm_amp_id', [
		        'default' => '',
		        'sanitize_callback' => 'esc_attr',
	        ]);

            $customize->add_control('jp_gtm_id', [
                'label' => 'GTM Container ID',
                'description' => 'You can get yours <b>container ID</b> <a href="https://www.google.com/analytics/tag-manager/" target="_blank">here</a>! 
                Use comma without space (,) to enter multiple IDs. <br> Add action <b><code>do_action(\'wp_body_open\')</code></b> after opening tag <b>&lt;body&gt;</b> if not added or <b><code>wp_body_open();</code></b>.',
                'section' => 'jp_gtm',
                'settings' => 'jp_gtm_id',
                'type' => 'text',
                'input_attrs' => [
                    'placeholder' => 'GTM-XXXXXXX',
                ],
            ]);

	        $customize->add_control('jp_gtm_amp_id', [
		        'label' => 'GTM AMP Container ID',
		        //'description' => '',
		        'section' => 'jp_gtm',
		        'settings' => 'jp_gtm_amp_id',
		        'type' => 'text',
		        'input_attrs' => [
			        'placeholder' => 'GTM-XXXXXXX',
		        ],
	        ]);
        }
    }

    new GoogleTagManager;
}
