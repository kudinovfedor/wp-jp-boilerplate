<?php

if ( ! class_exists('GoogleMaps')) {
    /**
     * Class GoogleMaps
     */
    class GoogleMaps
    {
        /**
         * @var array
         */
        public $options = array();

        /**
         * @var string
         */
        public $script_handle = 'jp-googleapis';

        /**
         * GoogleMaps constructor.
         */
        public function __construct()
        {
            $this->options = array(
                // Project Setup
                'enable'                   => get_theme_mod('google_map_display', false),
                'api_key'                  => get_theme_mod('google_map_project_setup_api_key'),
                'version'                  => get_theme_mod('google_map_project_setup_version'),
                'language'                 => get_theme_mod('google_map_project_setup_language'),
                'region'                   => get_theme_mod('google_map_project_setup_region'),
                'callback'                 => get_theme_mod('google_map_project_setup_map_callback', 'initMap'),
                'selector'                 => get_theme_mod('google_map_project_setup_map_selector', 'google-map'),
                'width'                    => get_theme_mod('google_map_project_setup_width', 600),
                'height'                   => get_theme_mod('google_map_project_setup_height', 400),
                'latitude'                 => get_theme_mod('google_map_project_setup_latitude', 36.580247),
                'longitude'                => get_theme_mod('google_map_project_setup_longitude', -41.817628),
                'zoom'                     => get_theme_mod('google_map_project_setup_zoom_level', 3),

                // Controls
                'type_control'             => get_theme_mod('google_map_controls_map_type', 'horizontal_bar'),
                'zoom_control'             => get_theme_mod('google_map_controls_zoom', 1),
                'gesture_handling_control' => get_theme_mod('google_map_controls_gesture_handling', 'auto'),
                'full_screen_control'      => get_theme_mod('google_map_controls_full_screen', 0),
                'street_view_control'      => get_theme_mod('google_map_controls_street_view', 1),
                'scale_control'            => get_theme_mod('google_map_controls_scale', 1),
                'clickable_poi_control'    => get_theme_mod('google_map_controls_clickable_poi', 0),
                'draggable'                => get_theme_mod('google_map_controls_draggable', 1),
                'double_click_zoom'        => get_theme_mod('google_map_controls_double_click_to_zoom', 1),
                'scroll_wheel'             => get_theme_mod('google_map_controls_mouse_wheel_to_zoom', 1),

                // Positions
                'type_position'            => get_theme_mod('google_map_positions_map_type', 1),
                'zoom_position'            => get_theme_mod('google_map_positions_zoom', 9),
                'street_view_position'     => get_theme_mod('google_map_positions_street_view', 9),
                'full_screen_position'     => get_theme_mod('google_map_positions_full_screen', 3),

                // Themes
                'type_themes'              => get_theme_mod('google_map_themes_type', 'roadmap'),
                'styles_themes'            => get_theme_mod('google_map_themes_styles', 0),
            );

            if ($this->isEnabled()) {
                add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
                add_filter('script_loader_tag', array($this, 'addAsyncDeferAttribute'), 10, 2);
            }
        }

        /**
         * @return bool
         */
        public function isEnabled()
        {
            return $this->options['enable'] && ! empty($this->options['api_key']);
        }

        /**
         * Get Google Maps Api Src
         *
         * @return string
         */
        public function getGoogleApisSrc()
        {
            $query_data = array(
                'v'        => $this->options['version'],
                'language' => $this->options['language'],
                'region'   => $this->options['region'],
                'key'      => $this->options['api_key'],
                'callback' => $this->options['callback'],
            );

            $query_data = array_filter($query_data, array($this, 'isNotEmpty'), ARRAY_FILTER_USE_BOTH);

            $query = http_build_query($query_data);

            $src = sprintf('https://maps.googleapis.com/maps/api/js?%s', $query);

            return $src;
        }

        /**
         * @return void
         */
        public function enqueueScripts()
        {
            wp_register_script($this->script_handle, $this->getGoogleApisSrc(), array(), null, true);
            wp_enqueue_script($this->script_handle);
        }

        /**
         * @param $tag
         * @param $handle
         *
         * @return mixed
         */
        public function addAsyncDeferAttribute($tag, $handle)
        {
            if ($this->script_handle === $handle) {

                return str_replace(' src', ' async defer src', $tag);

            }

            return $tag;
        }

        /**
         * @param $value
         * @param $key
         *
         * @return bool
         */
        public function isNotEmpty($value, $key)
        {
            return ! empty($value);
        }

        /**
         * Is Option Enabled
         *
         * @param $option
         *
         * @return void
         */
        public function isOptionEnabled($option)
        {
            echo $option ? 'true' : 'false';
        }

        public function htmlMarkup($dimensions = true)
        {
            if ($this->isEnabled()) {

                $style = sprintf(
                    'style="width: %spx; height: %spx;"',
                    $this->options['width'], $this->options['height']
                );

                $markup = sprintf(
                    '<div id="%s" class="google-map" %s></div>',
                    $this->options['selector'],
                    $dimensions ? $style : ''
                );

                if (is_customize_preview()) {
                    $markup = sprintf('<div class="jp-google-map">%s</div>', $markup);
                }

                echo $markup;

                $this->initMapJS();
            }
        }

        public function initMapJS()
        {
            global $snazzy_maps;
            $map = $this->options;

            $style_theme_id = (int)$map['styles_themes'];
            ?>
            <script>
                function <?php echo $map['callback']; ?>() {
                    var uluru, map, mapElement, mapMarker, mapOptions;

                    uluru = {
                        lat: <?php echo $map['latitude']; ?>,
                        lng: <?php echo $map['longitude']; ?>,
                    };

                    mapElement = document.getElementById("<?php echo $map['selector'] ?>");

                    mapOptions = {
                        //disableDefaultUI: true,
                        center: uluru,

                        zoom: <?php echo $map['zoom'] ?>,
                        zoomControl: <?php $this->isOptionEnabled($map['zoom_control']) ?>,
                        zoomControlOptions: {
                            position: <?php echo $map['zoom_position'] ?>,
                        },

                        scaleControl: <?php $this->isOptionEnabled($map['scale_control']) ?>,

                        gestureHandling: "<?php echo $map['gesture_handling_control'] ?>",

                        fullscreenControl: <?php $this->isOptionEnabled($map['full_screen_control']) ?>,
                        fullscreenControlOptions: {
                            position: <?php echo $map['full_screen_position'] ?>,
                        },

                        mapTypeId: "<?php echo $map['type_themes'] ?>",
                        mapTypeControl: <?php $this->isOptionEnabled($map['type_control']) ?>,
                        mapTypeControlOptions: {
                            style: <?php echo $map['type_control'] ?>,
                            position: <?php echo $map['type_position'] ?>,
                        },

                        streetViewControl: <?php $this->isOptionEnabled($map['street_view_control']) ?>,
                        streetViewControlOptions: {
                            position: <?php echo $map['street_view_position'] ?>,
                        },

                        draggable: <?php $this->isOptionEnabled($map['draggable']) ?>,
                        scrollwheel: <?php $this->isOptionEnabled($map['scroll_wheel']) ?>,
                        disableDoubleClickZoom: <?php $this->isOptionEnabled($map['double_click_zoom']) ?>,

                        clickableIcons: <?php $this->isOptionEnabled($map['clickable_poi_control']) ?>,

                        styles: <?php echo $style_theme_id === 0 ? '[]' : $snazzy_maps->getItemJson($style_theme_id) ?>,
                    };

                    map = new google.maps.Map(mapElement, mapOptions);

                    mapMarker = new google.maps.Marker({
                        position: uluru,
                        icon: {
                            "fillColor": "#ee1c25",
                            "fillOpacity": 1,
                            "strokeWeight": 0,
                            "scale": 1.1,
                            "path": "M10.2,7.4c-6,0-10.9,4.9-10.9,10.9c0,6,10.9,18.4,10.9,18.4s10.9-12.3,10.9-18.4C21.2,12.2,16.3,7.4,10.2,7.4z M10.2,22.9c-2.6,0-4.6-2.1-4.6-4.6s2.1-4.6,4.6-4.6s4.6,2.1,4.6,4.6S12.8,22.9,10.2,22.9z",
                            "anchor": {"x": 10, "y": 30},
                            "origin": {"x": 0, "y": 0},
                            "style": 1
                        },
                        map: map,
                    });

                    mapMarker.addListener('click', function () {
                        console.log('Marker was clicked!');
                    });

                    console.log('Google Maps API version: ' + google.maps.version);
                }
            </script>
        <?php }
    }
}

/**
 * @var GoogleMaps $google_map
 */
$google_map = new GoogleMaps;
