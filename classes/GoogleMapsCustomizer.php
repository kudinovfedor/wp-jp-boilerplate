<?php

if (!class_exists('GoogleMapsCustomizer')) {
    /**
     * Class GoogleMapsCustomizer.
     *
     * @author Kudinov Fedor <admin@joompress.biz>
     */
    class GoogleMapsCustomizer
    {
        /**
         * @var array
         */
        public $languages = [
            'ar' => 'Arabic',
            'be' => 'Belarusian',
            'bg' => 'Bulgarian',
            'bn' => 'Bengali',
            'ca' => 'Catalan',
            'cs' => 'Czech',
            'da' => 'Danish',
            'de' => 'German',
            'el' => 'Greek',
            'en' => 'English',
            'en-Au' => 'English(Australian)',
            'en-GB' => 'English(Great Britain)',
            'es' => 'Spanish',
            'eu' => 'Basque',
            'fa' => 'Farsi',
            'fi' => 'Finnish',
            'fil' => 'Filipino',
            'fr' => 'French',
            'gl' => 'Galician',
            'gu' => 'Gujarati',
            'hi' => 'Hindi',
            'hr' => 'Croatian',
            'hu' => 'Hungarian',
            'id' => 'Indonesian',
            'it' => 'Italian',
            'iw' => 'Hebrew',
            'ja' => 'Japanese',
            'kk' => 'Kazakh',
            'kn' => 'Kannada',
            'ko' => 'Korean',
            'ky' => 'Kyrgyz',
            'lt' => 'Lithuanian',
            'lv' => 'Latvian',
            'mk' => 'Macedonian',
            'ml' => 'Malayalam',
            'mr' => 'Marathi',
            'my' => 'Burmese',
            'nl' => 'Dutch',
            'no' => 'Norwegian',
            'pa' => 'Punjabi',
            'pl' => 'Polish',
            'pt' => 'Portuguese',
            'pt-BR' => 'Portuguese(Brazil)',
            'pt-PT' => 'Portuguese(Portugal)',
            'ro' => 'Romanian',
            'ru' => 'Russian',
            'sk' => 'Slovak',
            'sl' => 'Slovenian',
            'sq' => 'Albanian',
            'sr' => 'Serbian',
            'sv' => 'Swedish',
            'ta' => 'Tamil',
            'te' => 'Telugu',
            'th' => 'Thai',
            'tl' => 'Tagalog',
            'tr' => 'Turkish',
            'uk' => 'Ukrainian',
            'uz' => 'Uzbek',
            'vi' => 'Vietnamese',
            'zh-CN' => 'Chinese(Simlified)',
            'zh-TW' => 'Chinese(Traditional)',
    ];

        /**
         * @var array
         */
        private $position = [
            1 => 'Top Left',
            2 => 'Top Center',
            3 => 'Top Right',
            4 => 'Left Center',
            5 => 'Left Top',
            6 => 'Left Bottom',
            7 => 'Right Top',
            8 => 'Right Center',
            9 => 'Right Bottom',
            10 => 'Bottom Left',
            11 => 'Bottom Center',
            12 => 'Bottom Right',
        ];

        /**
         * @var SnazzyMaps
         */
        private $snazzy_maps;

        /**
         * GoogleMapsCustomizer constructor.
         */
        public function __construct()
        {
            add_action('customize_register', [$this, 'customizer']);
        }

        /**
         * Google Maps Customizer
         *
         * @param $customize WP_Customize_Manager
         */
        public function customizer($customize)
        {
            $this->snazzy_maps = new SnazzyMaps;

            // Panel Google Maps API
            $customize->add_panel('google_map', [
                'title' => 'Google Maps API',
                'description' => 'Customizer for Google Map',
                'priority' => 202,
            ]);

            // Section Project Setup
            $customize->add_section('google_map_project_setup', [
                'title' => 'Project setup',
                'panel' => 'google_map',
            ]);

            $customize->selective_refresh->add_partial('google_map_project_setup_api_key', [
                'selector' => '.jp-google-map',
            ]);

            $customize->add_setting('google_map_display', [
                'default' => false,
                'sanitize_callback' => 'wp_validate_boolean',
            ]);
            $customize->add_setting('google_map_project_setup_api_key', [
                'default' => '',
                'sanitize_callback' => '',
            ]);
            $customize->add_setting('google_map_project_setup_version', [
                'default' => '',
                'sanitize_callback' => '',
            ]);
            $customize->add_setting('google_map_project_setup_language', [
                'default' => 0,
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_project_setup_region', [
                'default' => '',
                'sanitize_callback' => '',
            ]);
            $customize->add_setting('google_map_project_setup_map_callback', [
                'default' => 'initMap',
                'sanitize_callback' => '',
            ]);
            $customize->add_setting('google_map_project_setup_map_selector', [
                'default' => 'google-map',
                'sanitize_callback' => '',
            ]);
            $customize->add_setting('google_map_project_setup_height', [
                'default' => 400,
                'sanitize_callback' => 'absint',
            ]);
            $customize->add_setting('google_map_project_setup_width', [
                'default' => 600,
                'sanitize_callback' => 'absint',
            ]);
            $customize->add_setting('google_map_project_setup_latitude', [
                'default' => '',
                'sanitize_callback' => '',
            ]);
            $customize->add_setting('google_map_project_setup_longitude', [
                'default' => '',
                'sanitize_callback' => '',
            ]);
            $customize->add_setting('google_map_project_setup_zoom_level', [
                'default' => 3,
                'sanitize_callback' => 'absint',
            ]);

            $customize->add_control('google_map_display', [
                'label' => 'Enable/Disable',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_display',
                'type' => 'checkbox',
            ]);

            $customize->add_control('google_map_project_setup_api_key', [
                'label' => 'Google Maps API Key',
                'description' => 'All Google Maps JavaScript API applications require authentication.',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_api_key',
                'type' => 'text',
            ]);

            $customize->add_control('google_map_project_setup_version', [
                'label' => 'Google Maps API Version',
                'description' => 'You can indicate which version of the API to load within your application.',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_version',
                'type' => 'text',
            ]);

            $customize->add_control('google_map_project_setup_language', [
                'label' => 'Language localization',
                'description' => 'Change the default language settings.',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_language',
                'type' => 'select',
                'choices' => array_merge([0 => 'Default'], $this->languages),
            ]);

            $customize->add_control('google_map_project_setup_region', [
                'label' => 'Region localization',
                'description' => 'Specify a region code, which alters the map\'s behavior based on a given country or territory.',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_region',
                'type' => 'text',
            ]);

            $customize->add_control('google_map_project_setup_map_callback', [
                'label' => 'Map callback (for js)',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_map_callback',
                'type' => 'text',
            ]);

            $customize->add_control('google_map_project_setup_map_selector', [
                'label' => 'Map selector (for css)',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_map_selector',
                'type' => 'text',
            ]);

            $customize->add_control('google_map_project_setup_height', [
                'label' => 'Height',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_height',
                'type' => 'number',
                'input_attrs' => [
                    'min' => 0,
                    'step' => 1,
                ],
            ]);

            $customize->add_control('google_map_project_setup_width', [
                'label' => 'Width',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_width',
                'type' => 'number',
                'input_attrs' => [
                    'min' => 0,
                    'step' => 1,
                ],
            ]);

            $customize->add_control('google_map_project_setup_latitude', [
                'label' => 'Latitide',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_latitude',
                'type' => 'text',
            ]);

            $customize->add_control('google_map_project_setup_longitude', [
                'label' => 'Longitude',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_longitude',
                'type' => 'text',
            ]);

            $customize->add_control('google_map_project_setup_zoom_level', [
                'label' => 'Zoom level',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_zoom_level',
                'type' => 'number',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                ],
            ]);

            // Section Layers
            $customize->add_section('google_map_layers', [
                'title' => 'Layers',
                'panel' => 'google_map',
            ]);

            $customize->add_setting('google_map_layers_layer', [
                'default' => 'off',
                'sanitize_callback' => 'sanitize_radio',
            ]);

            $customize->add_control('google_map_layers_layer', [
                //'label' => 'Layers',
                'section' => 'google_map_layers',
                'settings' => 'google_map_layers_layer',
                'type' => 'radio',
                'choices' => [
                    'off' => 'Off',
                    'traffic' => 'Traffic',
                    'transit' => 'Transit',
                    'bicycling' => 'Bicycling',
                ],
            ]);

            // Section Controls
            $customize->add_section('google_map_controls', [
                'title' => 'Controls',
                'panel' => 'google_map',
            ]);

            $customize->add_setting('google_map_controls_map_type', [
                'default' => 1,
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_controls_zoom', [
                'default' => 1,
                'sanitize_callback' => 'absint',
            ]);
            $customize->add_setting('google_map_controls_gesture_handling', [
                'default' => 'auto',
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_controls_full_screen', [
                'default' => 0,
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_controls_street_view', [
                'default' => 1,
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_controls_scale', [
                'default' => 1,
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_controls_clickable_poi', [
                'default' => 0,
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_controls_draggable', [
                'default' => 1,
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_controls_double_click_to_zoom', [
                'default' => 1,
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_controls_mouse_wheel_to_zoom', [
                'default' => 1,
                'sanitize_callback' => 'sanitize_select',
            ]);

            $customize->add_control('google_map_controls_map_type', [
                'label' => 'Map type',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_map_type',
                'type' => 'select',
                'choices' => [
                    0 => 'Hide',
                    1 => 'Horizontal Bar',
                    2 => 'Dropdown Menu',
                ],
            ]);

            $customize->add_control('google_map_controls_zoom', [
                'label' => 'Zoom',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_zoom',
                'type' => 'select',
                'choices' => [
                    0 => 'Hide',
                    1 => 'Show',
                ],
            ]);

            $customize->add_control('google_map_controls_gesture_handling', [
                'label' => 'Gesture handling',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_gesture_handling',
                'type' => 'select',
                'choices' => [
                    'none' => 'None',
                    'auto' => 'Auto',
                    'greedy' => 'Greedy',
                    'cooperative' => 'Cooperative',
                ],
            ]);

            $customize->add_control('google_map_controls_full_screen', [
                'label' => 'Full screen',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_full_screen',
                'type' => 'select',
                'choices' => [
                    0 => 'Hide',
                    1 => 'Show',
                ],
            ]);

            $customize->add_control('google_map_controls_street_view', [
                'label' => 'Street view',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_street_view',
                'type' => 'select',
                'choices' => [
                    0 => 'Hide',
                    1 => 'Show',
                ],
            ]);

            $customize->add_control('google_map_controls_scale', [
                'label' => 'Scale',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_scale',
                'type' => 'select',
                'choices' => [
                    0 => 'Hide',
                    1 => 'Show',
                ],
            ]);

            $customize->add_control('google_map_controls_clickable_poi', [
                'label' => 'Clickable POI',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_clickable_poi',
                'type' => 'select',
                'choices' => [
                    0 => 'Disable',
                    1 => 'Enable',
                ],
            ]);

            $customize->add_control('google_map_controls_draggable', [
                'label' => 'Draggable',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_draggable',
                'type' => 'select',
                'choices' => [
                    0 => 'Disable',
                    1 => 'Enable',
                ],
            ]);

            $customize->add_control('google_map_controls_double_click_to_zoom', [
                'label' => 'Double click to zoom',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_double_click_to_zoom',
                'type' => 'select',
                'choices' => [
                    0 => 'Enable',
                    1 => 'Disable',
                ],
            ]);

            $customize->add_control('google_map_controls_mouse_wheel_to_zoom', [
                'label' => 'Mouse wheel to zoom',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_mouse_wheel_to_zoom',
                'type' => 'select',
                'choices' => [
                    0 => 'Disable',
                    1 => 'Enable',
                ],
            ]);

            // Section Positions
            $customize->add_section('google_map_positions', [
                'title' => 'Positions',
                'panel' => 'google_map',
            ]);

            $customize->add_setting('google_map_positions_map_type', [
                'default' => 1,
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_positions_zoom', [
                'default' => 9,
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_positions_street_view', [
                'default' => 9,
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_positions_full_screen', [
                'default' => 3,
                'sanitize_callback' => 'sanitize_select',
            ]);

            $customize->add_control('google_map_positions_map_type', [
                'label' => 'Map type',
                'section' => 'google_map_positions',
                'settings' => 'google_map_positions_map_type',
                'type' => 'select',
                'choices' => $this->position,
            ]);

            $customize->add_control('google_map_positions_zoom', [
                'label' => 'Zoom',
                'section' => 'google_map_positions',
                'settings' => 'google_map_positions_zoom',
                'type' => 'select',
                'choices' => $this->position,
            ]);

            $customize->add_control('google_map_positions_street_view', [
                'label' => 'Street view',
                'section' => 'google_map_positions',
                'settings' => 'google_map_positions_street_view',
                'type' => 'select',
                'choices' => $this->position,
            ]);

            $customize->add_control('google_map_positions_full_screen', [
                'label' => 'Full screen',
                'section' => 'google_map_positions',
                'settings' => 'google_map_positions_full_screen',
                'type' => 'select',
                'choices' => $this->position,
            ]);

            // Section Themes
            $customize->add_section('google_map_themes', [
                'title' => 'Themes',
                'panel' => 'google_map',
            ]);

            $customize->add_setting('google_map_themes_type', [
                'default' => 'roadmap',
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_themes_styling', [
                'default' => '',
                'sanitize_callback' => '',
            ]);

            $customize->add_control('google_map_themes_type', [
                'label' => 'Map Types',
                'section' => 'google_map_themes',
                'settings' => 'google_map_themes_type',
                'type' => 'select',
                'choices' => [
                    'roadmap' => 'Road Map',
                    'satellite' => 'Satellite',
                    'hybrid' => 'Hybrid',
                    'terrain' => 'Terrain',
                ],
            ]);

            $customize->add_control(new WP_Customize_Code_Editor_Control($customize, 'google_map_themes_styling',
                [
                    'label' => 'Styling a Map',
                    'description' => 'Javascript code (array), <a href="https://developers.google.com/maps/documentation/javascript/styling" target="_blank" rel="nofollow noopener">Example</a>.',
                    'section' => 'google_map_themes',
                    'settings' => 'google_map_themes_styling',
                    'code_type' => 'text/javascript',
                    'input_attrs' => [
                        'placeholder' => '',
                    ],
                ]));

            // Section Snazzy Maps
            $customize->add_section('snazzy_maps', [
                'title' => 'Snazzy Maps',
                'description' => 'To apply the selected filters and sorting, select them and click the Publish button, then reload the page.',
                'description_hidden' => false,
                'panel' => 'google_map',
            ]);

            $customize->add_setting('snazzy_maps_style', [
                'default' => 0,
                'sanitize_callback' => 'absint',
            ]);
            $customize->add_setting('snazzy_maps_limit', [
                'default' => 100,
                'sanitize_callback' => 'absint',
                'transport' => 'postMessage',
            ]);
            $customize->add_setting('snazzy_maps_sort_by', [
                'default' => '',
                'sanitize_callback' => 'sanitize_select',
                'transport' => 'postMessage',
            ]);
            $customize->add_setting('snazzy_maps_filter_by_tag', [
                'default' => '',
                'sanitize_callback' => 'sanitize_select',
                'transport' => 'postMessage',
            ]);
            $customize->add_setting('snazzy_maps_filter_by_color', [
                'default' => '',
                'sanitize_callback' => 'sanitize_select',
                'transport' => 'postMessage',
            ]);

            $customize->add_control('snazzy_maps_style', [
                'label' => 'Style',
                'description' => '<a href="https://snazzymaps.com/" target="_blank" rel="nofollow noopener">Snazzy Maps</a> is a repository of different styles for Google Maps aimed towards web designers and developers.',
                'section' => 'snazzy_maps',
                'settings' => 'snazzy_maps_style',
                'type' => 'select',
                'choices' => array_replace([0 => 'Default'], $this->snazzy_maps->getMapStyles()),
            ]);
            $customize->add_control('snazzy_maps_limit', [
                'label' => 'Limit',
                'description' => sprintf('Total qty. <b>%s</b>, maximum limit is 1000 items.',
                    $this->snazzy_maps->countItems()),
                'section' => 'snazzy_maps',
                'settings' => 'snazzy_maps_limit',
                'type' => 'number',
                'input_attrs' => [
                    'min' => 1,
                    'max' => 1000,
                    'step' => 1,
                ],
            ]);
            $customize->add_control('snazzy_maps_sort_by', [
                'label' => 'Sort by...',
                'section' => 'snazzy_maps',
                'settings' => 'snazzy_maps_sort_by',
                'type' => 'select',
                'choices' => [
                    '' => 'Sort by...',
                    'name' => 'Name',
                    'popular' => 'Popular',
                    'recent' => 'Recent',
                ],
            ]);
            $customize->add_control('snazzy_maps_filter_by_tag', [
                'label' => 'Filter by Tag',
                'section' => 'snazzy_maps',
                'settings' => 'snazzy_maps_filter_by_tag',
                'type' => 'select',
                'choices' => [
                    '' => 'Filter by Tag',
                    'colorful' => 'Colorful',
                    'complex' => 'Complex',
                    'dark' => 'Dark',
                    'greyscale' => 'Greyscale',
                    'light' => 'Light',
                    'monochrome' => 'Monochrome',
                    'no-labels' => 'No Labels',
                    'simple' => 'Simple',
                    'two-tone' => 'Two Tone',
                ],
            ]);
            $customize->add_control('snazzy_maps_filter_by_color', [
                'label' => 'Filter by Color',
                'section' => 'snazzy_maps',
                'settings' => 'snazzy_maps_filter_by_color',
                'type' => 'select',
                'choices' => [
                    '' => 'Filter by Color',
                    'black' => 'Black',
                    'blue' => 'Blue',
                    'gray' => 'Gray',
                    'green' => 'Green',
                    'multi' => 'Multi',
                    'orange' => 'Orange',
                    'purple' => 'Purple',
                    'red' => 'Red',
                    'white' => 'White',
                    'yellow' => 'Yellow',
                ],
            ]);

            // Section Marker
            $customize->add_section('google_map_marker', [
                'title' => 'Marker',
                'description' => 'Options used to define the properties that can be set on a Marker.',
                'panel' => 'google_map',
            ]);

            /*$customize->add_setting('google_map_marker_anchor_point', [
                'default' => '',
                'sanitize_callback' => '',
            ]);*/
            $customize->add_setting('google_map_marker_animation', [
                'default' => 0,
                'sanitize_callback' => 'absint',
            ]);
            $customize->add_setting('google_map_marker_clickable', [
                'default' => 1,
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_marker_cross_drag', [
                'default' => 1,
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_marker_cursor', [
                'default' => 'pointer',
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_marker_draggable', [
                'default' => 0,
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_marker_icon', [
                'default' => '',
                'sanitize_callback' => '',
            ]);
            $customize->add_setting('google_map_marker_label', [
                'default' => '',
                'sanitize_callback' => '',
            ]);
            /*$customize->add_setting('google_map_marker_map', [
                'default' => '',
                'sanitize_callback' => '',
            ]);*/
            $customize->add_setting('google_map_marker_opacity', [
                'default' => 1,
                'sanitize_callback' => 'absint',
            ]);
            $customize->add_setting('google_map_marker_optimized', [
                'default' => 1,
                'sanitize_callback' => 'sanitize_select',
            ]);
            /*$customize->add_setting('google_map_marker_position', [
                'default' => '',
                'sanitize_callback' => '',
            ]);
            $customize->add_setting('google_map_marker_shape', [
                'default' => '',
                'sanitize_callback' => '',
            ]);*/
            $customize->add_setting('google_map_marker_title', [
                'default' => '',
                'sanitize_callback' => 'wp_strip_all_tags',
            ]);
            $customize->add_setting('google_map_marker_visible', [
                'default' => 1,
                'sanitize_callback' => 'sanitize_select',
            ]);
            $customize->add_setting('google_map_marker_zindex', [
                'default' => 0,
                'sanitize_callback' => 'absint',
            ]);

            /*$customize->add_control('google_map_marker_anchor_point', [
                'label' => 'Anchor Point',
                'description' => 'The offset from the marker\'s position to the tip of an InfoWindow that has been opened with the marker as anchor.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_anchor_point',
                'type' => 'text',
            ]);*/

            $customize->add_control('google_map_marker_animation', [
                'label' => 'Animation',
                'description' => 'Which animation to play when marker is added to a map.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_animation',
                'type' => 'select',
                'choices' => [
                    0 => 'None',
                    1 => 'Bounce',
                    2 => 'Drop',
                ],
            ]);

            $customize->add_control('google_map_marker_clickable', [
                'label' => 'Clickable',
                'description' => 'If enable, the marker receives mouse and touch events. Default value is enable.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_clickable',
                'type' => 'select',
                'choices' => [
                    0 => 'Disable',
                    1 => 'Enable',
                ],
            ]);

            $customize->add_control('google_map_marker_cross_drag', [
                'label' => 'Cross On Drag',
                'description' => 'If disable, disables cross that appears beneath the marker when dragging. This option is enable by default.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_cross_drag',
                'type' => 'select',
                'choices' => [
                    0 => 'Disable',
                    1 => 'Enable',
                ],
            ]);

            $customize->add_control('google_map_marker_cursor', [
                'label' => 'Cursor',
                'description' => 'Mouse cursor to show on hover',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_cursor',
                'type' => 'select',
                'choices' => [
                    'alias' => 'Alias',
                    'all-scroll' => 'All-scroll',
                    'auto' => 'Auto',
                    'cell' => 'Cell',
                    'context-menu' => 'Context-menu',
                    'col-resize' => 'Col-resize',
                    'copy' => 'Copy',
                    'crosshair' => 'Crosshair',
                    'default' => 'Default',
                    'e-resize' => 'E-resize',
                    'ew-resize' => 'Ew-resize',
                    'grab' => 'Grab',
                    'grabbing' => 'Grabbing',
                    'help' => 'Help',
                    'move' => 'Move',
                    'n-resize' => 'N-resize',
                    'ne-resize' => 'Ne-resize',
                    'nesw-resize' => 'Nesw-resize',
                    'ns-resize' => 'Ns-resize',
                    'nw-resize' => 'Nw-resize',
                    'nwse-resize' => 'Nwse-resize',
                    'no-drop' => 'No-drop',
                    'none' => 'None',
                    'not-allowed' => 'Not-allowed',
                    'pointer' => 'Pointer',
                    'progress' => 'Progress',
                    'row-resize' => 'Row-resize',
                    's-resize' => 'S-resize',
                    'se-resize' => 'Se-resize',
                    'sw-resize' => 'Sw-resize',
                    'text' => 'Text',
                    'vertical-text' => 'Vertical-text',
                    'w-resize' => 'W-resize',
                    'wait' => 'Wait',
                    'zoom-in' => 'Zoom-in',
                    'zoom-out' => 'Zoom-out',
                ],
            ]);

            $customize->add_control('google_map_marker_draggable', [
                'label' => 'Draggable',
                'description' => 'If rnable, the marker can be dragged. Default value is disable.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_draggable',
                'type' => 'select',
                'choices' => [
                    0 => 'Disable',
                    1 => 'Enable',
                ],
            ]);

            $customize->add_control('google_map_marker_icon', [
                'label' => 'Icon',
                'description' => 'Icon for the foreground. If a string is provided, it is treated as though it were an Icon with the string as url.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_icon',
                'type' => 'text',
            ]);

            $customize->add_control('google_map_marker_label', [
                'label' => 'Label',
                'description' => 'Adds a label to the marker. The label can either be a string, or a MarkerLabel object.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_label',
                'type' => 'text',
            ]);

            $customize->add_control('google_map_marker_map', [
                'label' => 'Map',
                'description' => 'Map on which to display Marker.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_map',
                'type' => 'text',
            ]);

            $customize->add_control('google_map_marker_opacity', [
                'label' => 'Opacity',
                'description' => 'The marker\'s opacity between 0.0 and 1.0.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_opacity',
                'type' => 'number',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 1,
                    'step' => 0.1,
                ],
            ]);

            $customize->add_control('google_map_marker_optimized', [
                'label' => 'Optimized',
                'description' => 'Optimization renders many markers as a single static element. Optimized rendering is enabled by default. Disable optimized rendering for animated GIFs or PNGs, or when each marker must be rendered as a separate DOM element (advanced usage only).',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_optimized',
                'type' => 'select',
                'choices' => [
                    0 => 'Disable',
                    1 => 'Enable',
                ],
            ]);

            /*$customize->add_control('google_map_marker_position', [
                'label' => 'Position',
                'description' => 'Marker position. Required.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_position',
                'type' => 'text',
            ]);

            $customize->add_control('google_map_marker_shape', [
                'label' => 'Shape',
                'description' => 'Image map region definition used for drag/click.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_shape',
                'type' => 'text',
            ]);*/

            $customize->add_control('google_map_marker_title', [
                'label' => 'Title',
                'description' => 'Rollover text',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_title',
                'type' => 'text',
            ]);

            $customize->add_control('google_map_marker_visible', [
                'label' => 'Visible',
                'description' => 'If enable, the marker is visible',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_visible',
                'type' => 'select',
                'choices' => [
                    0 => 'Disable',
                    1 => 'Enable',
                ],
            ]);

            $customize->add_control('google_map_marker_zindex', [
                'label' => 'zIndex',
                'description' => 'All markers are displayed on the map in order of their zIndex, with higher values displaying in front of markers with lower values. By default, markers are displayed according to their vertical position on screen, with lower markers appearing in front of markers further up the screen.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_zindex',
                'type' => 'number',
            ]);

            // Section Info Window
            $customize->add_section('google_map_infowindow', [
                'title' => 'Info Window',
                'description' => '',
                'panel' => 'google_map',
            ]);

            $customize->add_setting('google_map_infowindow_display', [
                'default' => false,
                'sanitize_callback' => 'wp_validate_boolean',
            ]);

            $customize->add_setting('google_map_infowindow_disable_auto_pan', [
                'default' => false,
                'sanitize_callback' => 'wp_validate_boolean',
            ]);

            $customize->add_setting('google_map_infowindow_max_width', [
                'default' => 320,
                'sanitize_callback' => 'absint',
            ]);

            $customize->add_setting('google_map_infowindow_zindex', [
                'default' => 0,
                'sanitize_callback' => 'absint',
            ]);

            $customize->add_setting('google_map_infowindow_name', [
                'default' => '',
                'sanitize_callback' => 'esc_html',
            ]);

            $customize->add_setting('google_map_infowindow_address', [
                'default' => '',
                'sanitize_callback' => 'esc_html',
            ]);

            $customize->add_setting('google_map_infowindow_phone_number', [
                'default' => '',
                'sanitize_callback' => 'esc_html',
            ]);

            $customize->add_setting('google_map_infowindow_website_url', [
                'default' => '',
                'sanitize_callback' => 'esc_url_raw',
            ]);

            $customize->add_setting('google_map_infowindow_email', [
                'default' => '',
                'sanitize_callback' => 'sanitize_email',
            ]);

            $customize->add_setting('google_map_infowindow_details', [
                'default' => '',
                'sanitize_callback' => 'esc_html',
            ]);

            $customize->add_control('google_map_infowindow_display', [
                'label' => 'Enable/Disable',
                'description' => 'Enable the Info Window.',
                'section' => 'google_map_infowindow',
                'settings' => 'google_map_infowindow_display',
                'type' => 'checkbox',
            ]);

            $customize->add_control('google_map_infowindow_name', [
                'label' => 'Name',
                'description' => '',
                'section' => 'google_map_infowindow',
                'settings' => 'google_map_infowindow_name',
                'type' => 'text',
            ]);

            $customize->add_control('google_map_infowindow_address', [
                'label' => 'Address',
                'description' => '',
                'section' => 'google_map_infowindow',
                'settings' => 'google_map_infowindow_address',
                'type' => 'text',
            ]);

            $customize->add_control('google_map_infowindow_phone_number', [
                'label' => 'Telephone number',
                'description' => '',
                'section' => 'google_map_infowindow',
                'settings' => 'google_map_infowindow_phone_number',
                'type' => 'tel',
            ]);

            $customize->add_control('google_map_infowindow_website_url', [
                'label' => 'Website URL',
                'description' => '',
                'section' => 'google_map_infowindow',
                'settings' => 'google_map_infowindow_website_url',
                'type' => 'url',
            ]);

            $customize->add_control('google_map_infowindow_email', [
                'label' => 'Email',
                'description' => '',
                'section' => 'google_map_infowindow',
                'settings' => 'google_map_infowindow_email',
                'type' => 'email',
            ]);

            $customize->add_control('google_map_infowindow_details', [
                'label' => 'Details',
                'description' => 'A text area with a maximum length of <b>150 characters</b>:',
                'section' => 'google_map_infowindow',
                'settings' => 'google_map_infowindow_details',
                'type' => 'textarea',
                'input_attrs' => [
                    'maxlength' => 150,
                ],
            ]);

            $customize->add_control('google_map_infowindow_disable_auto_pan', [
                'label' => 'Disable Auto Pan',
                'description' => 'Disable auto-pan on open. By default, the info window will pan the map so that it is fully visible when it opens.',
                'section' => 'google_map_infowindow',
                'settings' => 'google_map_infowindow_disable_auto_pan',
                'type' => 'checkbox',
            ]);

            $customize->add_control('google_map_infowindow_max_width', [
                'label' => 'Max Width',
                'description' => 'Maximum width of the infowindow, regardless of content\'s width. This value is only considered if it is set before a call to open. To change the maximum width when changing content, call close, setOptions, and then open.',
                'section' => 'google_map_infowindow',
                'settings' => 'google_map_infowindow_max_width',
                'type' => 'number',
            ]);

            $customize->add_control('google_map_infowindow_zindex', [
                'label' => 'zIndex',
                'description' => 'All InfoWindows are displayed on the map in order of their zIndex, with higher values displaying in front of InfoWindows with lower values. By default, InfoWindows are displayed according to their latitude, with InfoWindows of lower latitudes appearing in front of InfoWindows at higher latitudes. InfoWindows are always displayed in front of markers.',
                'section' => 'google_map_infowindow',
                'settings' => 'google_map_infowindow_zindex',
                'type' => 'number',
            ]);

        }
    }

    new GoogleMapsCustomizer;
}
