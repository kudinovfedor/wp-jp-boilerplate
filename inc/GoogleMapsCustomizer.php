<?php

if (!class_exists('GoogleMapsCustomizer')) {
    /**
     * Class GoogleMapsCustomizer.
     */
    class GoogleMapsCustomizer
    {
        /**
         * @var array
         */
        public $languages = array(
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
        );

        /**
         * @var SnazzyMaps
         */
        public $snazzy_maps;

        /**
         * GoogleMapsCustomizer constructor.
         */
        public function __construct()
        {
            $this->snazzy_maps = new SnazzyMaps;
            add_action('customize_register', array($this, 'customizer'));
        }

        /**
         * Google Maps Customizer
         *
         * @param $wp_customize WP_Customize_Manager
         */
        public function customizer($wp_customize)
        {
            // Panel Google Maps API
            $wp_customize->add_panel('google_map', array(
                'title' => 'Google Maps API',
                'description' => 'Customizer for Google Map',
                'priority' => 203,
            ));

            // Section Project Setup
            $wp_customize->add_section('google_map_project_setup', array(
                'title' => 'Project setup',
                'panel' => 'google_map',
            ));

            $wp_customize->selective_refresh->add_partial('google_map_project_setup_api_key', array(
                'selector' => '.jp-google-map',
            ));

            $wp_customize->add_setting('google_map_display', array(
                'default' => false,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_project_setup_api_key', array(
                'default' => '',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_project_setup_version', array(
                'default' => '',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_project_setup_language', array(
                'default' => 0,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_project_setup_region', array(
                'default' => '',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_project_setup_map_callback', array(
                'default' => 'initMap',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_project_setup_map_selector', array(
                'default' => 'google-map',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_project_setup_height', array(
                'default' => 400,
                'sanitize_callback' => 'absint',
            ));
            $wp_customize->add_setting('google_map_project_setup_width', array(
                'default' => 600,
                'sanitize_callback' => 'absint',
            ));
            $wp_customize->add_setting('google_map_project_setup_latitude', array(
                'default' => '',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_project_setup_longitude', array(
                'default' => '',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_project_setup_zoom_level', array(
                'default' => 3,
                'sanitize_callback' => 'absint',
            ));

            $wp_customize->add_control('google_map_display', array(
                'label' => 'Enable/Disable',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_display',
                'type' => 'checkbox',
            ));

            $wp_customize->add_control('google_map_project_setup_api_key', array(
                'label' => 'Google Maps API Key',
                'description' => 'All Google Maps JavaScript API applications require authentication.',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_api_key',
                'type' => 'text',
            ));

            $wp_customize->add_control('google_map_project_setup_version', array(
                'label' => 'Google Maps API Version',
                'description' => 'You can indicate which version of the API to load within your application.',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_version',
                'type' => 'text',
            ));

            $wp_customize->add_control('google_map_project_setup_language', array(
                'label' => 'Language localization',
                'description' => 'Change the default language settings.',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_language',
                'type' => 'select',
                'choices' => array_merge(array(0 => 'Default'), $this->languages),
            ));

            $wp_customize->add_control('google_map_project_setup_region', array(
                'label' => 'Region localization',
                'description' => 'Specify a region code, which alters the map\'s behavior based on a given country or territory.',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_region',
                'type' => 'text',
            ));

            $wp_customize->add_control('google_map_project_setup_map_callback', array(
                'label' => 'Map callback (for js)',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_map_callback',
                'type' => 'text',
            ));

            $wp_customize->add_control('google_map_project_setup_map_selector', array(
                'label' => 'Map selector (for css)',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_map_selector',
                'type' => 'text',
            ));

            $wp_customize->add_control('google_map_project_setup_height', array(
                'label' => 'Height',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_height',
                'type' => 'number',
                'input_attrs' => array(
                    'min' => 0,
                    'step' => 1,
                ),
            ));

            $wp_customize->add_control('google_map_project_setup_width', array(
                'label' => 'Width',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_width',
                'type' => 'number',
                'input_attrs' => array(
                    'min' => 0,
                    'step' => 1,
                ),
            ));

            $wp_customize->add_control('google_map_project_setup_latitude', array(
                'label' => 'Latitide',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_latitude',
                'type' => 'text',
            ));

            $wp_customize->add_control('google_map_project_setup_longitude', array(
                'label' => 'Longitude',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_longitude',
                'type' => 'text',
            ));

            $wp_customize->add_control('google_map_project_setup_zoom_level', array(
                'label' => 'Zoom level',
                'section' => 'google_map_project_setup',
                'settings' => 'google_map_project_setup_zoom_level',
                'type' => 'number',
                'input_attrs' => array(
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                ),
            ));

            // Section Layers
            $wp_customize->add_section('google_map_layers', array(
                'title' => 'Layers',
                'panel' => 'google_map',
            ));

            $wp_customize->add_setting('google_map_layers_layer', array(
                'default' => 'off',
                'sanitize_callback' => '',
            ));

            $wp_customize->add_control('google_map_layers_layer', array(
                //'label' => 'Layers',
                'section' => 'google_map_layers',
                'settings' => 'google_map_layers_layer',
                'type' => 'radio',
                'choices' => array(
                    'off' => 'Off',
                    'traffic' => 'Traffic',
                    'transit' => 'Transit',
                    'bicycling' => 'Bicycling',
                ),
            ));

            // Section Controls
            $wp_customize->add_section('google_map_controls', array(
                'title' => 'Controls',
                'panel' => 'google_map',
            ));

            $wp_customize->add_setting('google_map_controls_map_type', array(
                'default' => 1,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_controls_zoom', array(
                'default' => 1,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_controls_gesture_handling', array(
                'default' => 'auto',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_controls_full_screen', array(
                'default' => 0,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_controls_street_view', array(
                'default' => 1,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_controls_scale', array(
                'default' => 1,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_controls_clickable_poi', array(
                'default' => 0,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_controls_draggable', array(
                'default' => 1,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_controls_double_click_to_zoom', array(
                'default' => 1,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_controls_mouse_wheel_to_zoom', array(
                'default' => 1,
                'sanitize_callback' => '',
            ));

            $wp_customize->add_control('google_map_controls_map_type', array(
                'label' => 'Map type',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_map_type',
                'type' => 'select',
                'choices' => array(
                    0 => 'Hide',
                    1 => 'Horizontal Bar',
                    2 => 'Dropdown Menu',
                ),
            ));

            $wp_customize->add_control('google_map_controls_zoom', array(
                'label' => 'Zoom',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_zoom',
                'type' => 'select',
                'choices' => array(
                    0 => 'Hide',
                    1 => 'Show',
                ),
            ));

            $wp_customize->add_control('google_map_controls_gesture_handling', array(
                'label' => 'Gesture handling',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_gesture_handling',
                'type' => 'select',
                'choices' => array(
                    'none' => 'None',
                    'auto' => 'Auto',
                    'greedy' => 'Greedy',
                    'cooperative' => 'Cooperative',
                ),
            ));

            $wp_customize->add_control('google_map_controls_full_screen', array(
                'label' => 'Full screen',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_full_screen',
                'type' => 'select',
                'choices' => array(
                    0 => 'Hide',
                    1 => 'Show',
                ),
            ));

            $wp_customize->add_control('google_map_controls_street_view', array(
                'label' => 'Street view',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_street_view',
                'type' => 'select',
                'choices' => array(
                    0 => 'Hide',
                    1 => 'Show',
                ),
            ));

            $wp_customize->add_control('google_map_controls_scale', array(
                'label' => 'Scale',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_scale',
                'type' => 'select',
                'choices' => array(
                    0 => 'Hide',
                    1 => 'Show',
                ),
            ));

            $wp_customize->add_control('google_map_controls_clickable_poi', array(
                'label' => 'Clickable POI',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_clickable_poi',
                'type' => 'select',
                'choices' => array(
                    0 => 'Disable',
                    1 => 'Enable',
                ),
            ));

            $wp_customize->add_control('google_map_controls_draggable', array(
                'label' => 'Draggable',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_draggable',
                'type' => 'select',
                'choices' => array(
                    0 => 'Disable',
                    1 => 'Enable',
                ),
            ));

            $wp_customize->add_control('google_map_controls_double_click_to_zoom', array(
                'label' => 'Double click to zoom',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_double_click_to_zoom',
                'type' => 'select',
                'choices' => array(
                    0 => 'Enable',
                    1 => 'Disable',
                ),
            ));

            $wp_customize->add_control('google_map_controls_mouse_wheel_to_zoom', array(
                'label' => 'Mouse wheel to zoom',
                'section' => 'google_map_controls',
                'settings' => 'google_map_controls_mouse_wheel_to_zoom',
                'type' => 'select',
                'choices' => array(
                    0 => 'Disable',
                    1 => 'Enable',
                ),
            ));

            // Section Positions
            $wp_customize->add_section('google_map_positions', array(
                'title' => 'Positions',
                'panel' => 'google_map',
            ));

            $wp_customize->add_setting('google_map_positions_map_type', array(
                'default' => 1,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_positions_zoom', array(
                'default' => 9,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_positions_street_view', array(
                'default' => 9,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_positions_full_screen', array(
                'default' => 3,
                'sanitize_callback' => '',
            ));

            $wp_customize->add_control('google_map_positions_map_type', array(
                'label' => 'Map type',
                'section' => 'google_map_positions',
                'settings' => 'google_map_positions_map_type',
                'type' => 'select',
                'choices' => array(
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
                ),
            ));

            $wp_customize->add_control('google_map_positions_zoom', array(
                'label' => 'Zoom',
                'section' => 'google_map_positions',
                'settings' => 'google_map_positions_zoom',
                'type' => 'select',
                'choices' => array(
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
                ),
            ));

            $wp_customize->add_control('google_map_positions_street_view', array(
                'label' => 'Street view',
                'section' => 'google_map_positions',
                'settings' => 'google_map_positions_street_view',
                'type' => 'select',
                'choices' => array(
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
                ),
            ));

            $wp_customize->add_control('google_map_positions_full_screen', array(
                'label' => 'Full screen',
                'section' => 'google_map_positions',
                'settings' => 'google_map_positions_full_screen',
                'type' => 'select',
                'choices' => array(
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
                ),
            ));

            // Section Themes
            $wp_customize->add_section('google_map_themes', array(
                'title' => 'Themes',
                'panel' => 'google_map',
            ));

            $wp_customize->add_setting('google_map_themes_type', array(
                'default' => 'roadmap',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_themes_styles', array(
                'default' => 0,
                'sanitize_callback' => 'absint',
            ));

            $wp_customize->add_control('google_map_themes_type', array(
                'label' => 'Google Maps theme',
                'section' => 'google_map_themes',
                'settings' => 'google_map_themes_type',
                'type' => 'select',
                'choices' => array(
                    'roadmap' => 'Road Map',
                    'satellite' => 'Satellite',
                    'hybrid' => 'Hybrid',
                    'terrain' => 'Terrain',
                ),
            ));

            $wp_customize->add_control('google_map_themes_styles', array(
                'label' => 'Shazzy Maps theme',
                'description' => '<a href="https://snazzymaps.com/" target="_blank" rel="nofollow noopener">Snazzy Maps</a> is a repository of different styles for Google Maps aimed towards web designers and developers.',
                'section' => 'google_map_themes',
                'settings' => 'google_map_themes_styles',
                'type' => 'select',
                'choices' => array_replace(array(0 => 'Default'), $this->snazzy_maps->getMapStyles()),
            ));

            // Section Marker
            $wp_customize->add_section('google_map_marker', array(
                'title' => 'Marker',
                'description' => 'Options used to define the properties that can be set on a Marker.',
                'panel' => 'google_map',
            ));

            $wp_customize->add_setting('google_map_marker_anchor_point', array(
                'default' => '',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_marker_animation', array(
                'default' => 0,
                'sanitize_callback' => 'absint',
            ));
            $wp_customize->add_setting('google_map_marker_clickable', array(
                'default' => 1,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_marker_cross_drag', array(
                'default' => 1,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_marker_cursor', array(
                'default' => '',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_marker_draggable', array(
                'default' => 0,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_marker_icon', array(
                'default' => '',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_marker_label', array(
                'default' => '',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_marker_map', array(
                'default' => '',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_marker_opacity', array(
                'default' => 1,
                'sanitize_callback' => 'absint',
            ));
            $wp_customize->add_setting('google_map_marker_optimized', array(
                'default' => 1,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_marker_position', array(
                'default' => '',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_marker_shape', array(
                'default' => '',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_marker_title', array(
                'default' => '',
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_marker_visible', array(
                'default' => 1,
                'sanitize_callback' => '',
            ));
            $wp_customize->add_setting('google_map_marker_zindex', array(
                'default' => '',
                'sanitize_callback' => 'absint',
            ));

            $wp_customize->add_control('google_map_marker_anchor_point', array(
                'label' => 'Anchor Point',
                'description' => 'The offset from the marker\'s position to the tip of an InfoWindow that has been opened with the marker as anchor.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_anchor_point',
                'type' => 'text',
            ));

            $wp_customize->add_control('google_map_marker_animation', array(
                'label' => 'Animation',
                'description' => 'Which animation to play when marker is added to a map.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_animation',
                'type' => 'select',
                'choices' => array(
                    0 => 'None',
                    1 => 'Bounce',
                    2 => 'Drop',
                ),
            ));

            $wp_customize->add_control('google_map_marker_clickable', array(
                'label' => 'Clickable',
                'description' => 'If enable, the marker receives mouse and touch events. Default value is enable.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_clickable',
                'type' => 'select',
                'choices' => array(
                    0 => 'Disable',
                    1 => 'Enable',
                ),
            ));

            $wp_customize->add_control('google_map_marker_cross_drag', array(
                'label' => 'Cross On Drag',
                'description' => 'If disable, disables cross that appears beneath the marker when dragging. This option is enable by default.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_cross_drag',
                'type' => 'select',
                'choices' => array(
                    0 => 'Disable',
                    1 => 'Enable',
                ),
            ));

            $wp_customize->add_control('google_map_marker_cursor', array(
                'label' => 'Cursor',
                'description' => 'Mouse cursor to show on hover',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_cursor',
                'type' => 'text',
            ));

            $wp_customize->add_control('google_map_marker_draggable', array(
                'label' => 'Draggable',
                'description' => 'If rnable, the marker can be dragged. Default value is disable.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_draggable',
                'type' => 'select',
                'choices' => array(
                    0 => 'Disable',
                    1 => 'Enable',
                ),
            ));

            $wp_customize->add_control('google_map_marker_icon', array(
                'label' => 'Icon',
                'description' => 'Icon for the foreground. If a string is provided, it is treated as though it were an Icon with the string as url.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_icon',
                'type' => 'text',
            ));

            $wp_customize->add_control('google_map_marker_label', array(
                'label' => 'Label',
                'description' => 'Adds a label to the marker. The label can either be a string, or a MarkerLabel object.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_label',
                'type' => 'text',
            ));

            $wp_customize->add_control('google_map_marker_map', array(
                'label' => 'Map',
                'description' => 'Map on which to display Marker.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_map',
                'type' => 'text',
            ));

            $wp_customize->add_control('google_map_marker_opacity', array(
                'label' => 'Opacity',
                'description' => 'The marker\'s opacity between 0.0 and 1.0.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_opacity',
                'type' => 'number',
                'input_attrs' => array(
                    'min' => 0,
                    'max' => 1,
                    'step' => 0.1,
                ),
            ));

            $wp_customize->add_control('google_map_marker_optimized', array(
                'label' => 'Optimized',
                'description' => 'Optimization renders many markers as a single static element. Optimized rendering is enabled by default. Disable optimized rendering for animated GIFs or PNGs, or when each marker must be rendered as a separate DOM element (advanced usage only).',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_optimized',
                'type' => 'select',
                'choices' => array(
                    0 => 'Disable',
                    1 => 'Enable',
                ),
            ));

            $wp_customize->add_control('google_map_marker_position', array(
                'label' => 'Position',
                'description' => 'Marker position. Required.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_position',
                'type' => 'text',
            ));

            $wp_customize->add_control('google_map_marker_shape', array(
                'label' => 'Shape',
                'description' => 'Image map region definition used for drag/click.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_shape',
                'type' => 'text',
            ));

            $wp_customize->add_control('google_map_marker_title', array(
                'label' => 'Title',
                'description' => 'Rollover text',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_title',
                'type' => 'text',
            ));

            $wp_customize->add_control('google_map_marker_visible', array(
                'label' => 'Visible',
                'description' => 'If enable, the marker is visible',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_visible',
                'type' => 'select',
                'choices' => array(
                    0 => 'Disable',
                    1 => 'Enable',
                ),
            ));

            $wp_customize->add_control('google_map_marker_zindex', array(
                'label' => 'zIndex',
                'description' => 'All markers are displayed on the map in order of their zIndex, with higher values displaying in front of markers with lower values. By default, markers are displayed according to their vertical position on screen, with lower markers appearing in front of markers further up the screen.',
                'section' => 'google_map_marker',
                'settings' => 'google_map_marker_zindex',
                'type' => 'number',
            ));

        }
    }

    new GoogleMapsCustomizer;
}
