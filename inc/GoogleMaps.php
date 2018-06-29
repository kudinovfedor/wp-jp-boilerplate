<?php

if (!class_exists('GoogleMaps')) {
    /**
     * Class GoogleMaps
     *
     * @author Kudinov Fedor <admin@joompress.biz>
     */
    class GoogleMaps
    {
        /**
         * @var array
         */
        private $options = array();

        /**
         * @var string
         */
        private $script_handle = 'jp-googleapis';

        /**
         * @var SnazzyMaps
         */
        private $snazzy_maps;

        /**
         * GoogleMaps constructor.
         */
        public function __construct()
        {
            $this->options = $this->getOptions();

            $this->snazzy_maps = new SnazzyMaps;
        }

        /**
         * Init Scripts
         *
         * @return void
         */
        public function init()
        {
            if ($this->isEnabled()) {
                add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
                add_filter('script_loader_tag', array($this, 'addAsyncDeferAttribute'), 10, 2);
            }
        }

        /**
         * Check Enable and Api Key exist
         *
         * @return bool
         */
        public function isEnabled()
        {
            $this->options = $this->getOptions();

            return $this->options['enable'] && !empty($this->options['api_key']);
        }

        /**
         * Get Google Maps Api Src
         *
         * @return string
         */
        public function getGoogleApisSrc()
        {
            $query_data = array(
                'v' => $this->options['version'],
                'language' => $this->options['language'],
                'region' => $this->options['region'],
                'key' => $this->options['api_key'],
                'callback' => $this->options['callback'],
            );

            $query_data = array_filter($query_data, array($this, 'isNotEmpty'), ARRAY_FILTER_USE_BOTH);

            $query = http_build_query($query_data);

            $src = sprintf('https://maps.googleapis.com/maps/api/js?%s', $query);

            return $src;
        }

        /**
         * Enqueue a script.
         *
         * @return void
         */
        public function enqueueScripts()
        {
            wp_register_script($this->script_handle, $this->getGoogleApisSrc(), array(), null, true);
            wp_enqueue_script($this->script_handle);
        }

        /**
         * Add attributes (async, defer) to script
         *
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
         * Get Google Maps options
         *
         * @return array
         */
        public function getOptions()
        {
            return array(
                // Project Setup
                'enable' => get_theme_mod('google_map_display', false),
                'api_key' => get_theme_mod('google_map_project_setup_api_key'),
                'version' => get_theme_mod('google_map_project_setup_version'),
                'language' => get_theme_mod('google_map_project_setup_language'),
                'region' => get_theme_mod('google_map_project_setup_region'),
                'callback' => get_theme_mod('google_map_project_setup_map_callback', 'initMap'),
                'selector' => get_theme_mod('google_map_project_setup_map_selector', 'google-map'),
                'width' => get_theme_mod('google_map_project_setup_width', 600),
                'height' => get_theme_mod('google_map_project_setup_height', 400),
                'latitude' => get_theme_mod('google_map_project_setup_latitude', 36.580247),
                'longitude' => get_theme_mod('google_map_project_setup_longitude', -41.817628),
                'zoom' => get_theme_mod('google_map_project_setup_zoom_level', 3),

                // Layers
                'layers' => get_theme_mod('google_map_layers_layer', 'off'),

                // Controls
                'control' => array(
                    'type' => get_theme_mod('google_map_controls_map_type', 1),
                    'zoom' => get_theme_mod('google_map_controls_zoom', 1),
                    'gesture_handling' => get_theme_mod('google_map_controls_gesture_handling', 'auto'),
                    'full_screen' => get_theme_mod('google_map_controls_full_screen', 0),
                    'street_view' => get_theme_mod('google_map_controls_street_view', 1),
                    'scale' => get_theme_mod('google_map_controls_scale', 1),
                    'clickable_poi' => get_theme_mod('google_map_controls_clickable_poi', 0),
                    'draggable' => get_theme_mod('google_map_controls_draggable', 1),
                    'double_click_zoom' => get_theme_mod('google_map_controls_double_click_to_zoom', 1),
                    'scroll_wheel' => get_theme_mod('google_map_controls_mouse_wheel_to_zoom', 1),
                ),

                // Positions
                'position' => array(
                    'type' => get_theme_mod('google_map_positions_map_type', 1),
                    'zoom' => get_theme_mod('google_map_positions_zoom', 9),
                    'street_view' => get_theme_mod('google_map_positions_street_view', 9),
                    'full_screen' => get_theme_mod('google_map_positions_full_screen', 3),
                ),

                // Themes
                'themes' => array(
                    'type' => get_theme_mod('google_map_themes_type', 'roadmap'),
                    'styles' => get_theme_mod('google_map_themes_styles', 0),
                ),

                // Marker
                'marker' => array(
                    //'anchor_point' => get_theme_mod('google_map_marker_anchor_point'),
                    'animation' => get_theme_mod('google_map_marker_animation', 0),
                    'clickable' => get_theme_mod('google_map_marker_clickable', 1),
                    'cross_drag' => get_theme_mod('google_map_marker_cross_drag', 1),
                    'cursor' => get_theme_mod('google_map_marker_cursor', 'pointer'),
                    'draggable' => get_theme_mod('google_map_marker_draggable', 0),
                    'icon' => get_theme_mod('google_map_marker_icon'),
                    'label' => get_theme_mod('google_map_marker_label', ''),
                    //'map_marker' => get_theme_mod('google_map_marker_map'),
                    'opacity' => get_theme_mod('google_map_marker_opacity', 1),
                    'optimized' => get_theme_mod('google_map_marker_optimized', 1),
                    //'position' => get_theme_mod('google_map_marker_position'),
                    //'shape' => get_theme_mod('google_map_marker_shape'),
                    'title' => get_theme_mod('google_map_marker_title', ''),
                    'visible' => get_theme_mod('google_map_marker_visible', 1),
                    'zindex' => get_theme_mod('google_map_marker_zindex', 0),
                ),

                // Info Window
                'info_window' => array(
                    'enable' => get_theme_mod('google_map_infowindow_display', false),
                    'name' => get_theme_mod('google_map_infowindow_name', ''),
                    'address' => get_theme_mod('google_map_infowindow_address', ''),
                    'phone_number' => get_theme_mod('google_map_infowindow_phone_number', ''),
                    'website_url' => get_theme_mod('google_map_infowindow_website_url', ''),
                    'email' => get_theme_mod('google_map_infowindow_email', ''),
                    'details' => get_theme_mod('google_map_infowindow_details', ''),
                    'disable_auto_pan' => get_theme_mod('google_map_infowindow_disable_auto_pan', false),
                    'max_width' => get_theme_mod('google_map_infowindow_max_width', 320),
                    'zindex' => get_theme_mod('google_map_infowindow_zindex', 0),
                ),

            );
        }

        /**
         * Check the value is not empty
         *
         * @param $value
         * @param $key
         *
         * @return bool
         */
        private function isNotEmpty($value, $key)
        {
            return !empty($value);
        }

        /**
         * Is Option Enabled
         *
         * @param $option
         *
         * @return void
         */
        private function isOptionEnabled($option)
        {
            echo $option ? 'true' : 'false';
        }

        /**
         * Output HTML Markup
         *
         * @param bool $dimensions
         *
         * @return void
         */
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

        /**
         * Outputting styles for Info Window
         *
         * @return void
         */
        private function getInfoWindowStyles()
        { ?>
            <style>
                <?php //.gm-style-iw {text-align: center; top: 0 !important; left: 0 !important;} ?>
                .iw-wrapper { font: normal 13px/1.2 Arial, Helvetica, sans-serif; color: #000; background-color: #fff; text-align: left; }

                .iw-header { padding: 10px 15px; background-color: #4285f4; color: #fff; font-size: 16px; }

                .iw-content { padding: 8px 15px; border: 1px solid #4285f4; }

                .iw-options { padding: 3px 0; }

                .iw-details { border-top: 1px solid #e6e6e6; padding-top: 8px; margin-top: 5px; }

                .iw-link { color: #4285f4; text-decoration: none; }

                .iw-link:hover { color: #4285f4; text-decoration: underline; }
            </style>
        <?php }

        /**
         * Init Google Maps Js
         *
         * @return void
         */
        private function initMapJS()
        {
            $map = $this->options;

            if ($map['info_window']['enable']) {
                $this->getInfoWindowStyles();
            }
            ?>
            <script>
                function <?php echo $map['callback']; ?>() {
                    var uluru, map, mapElement, mapMarker, mapOptions, infoWindow;

                    uluru = {
                        lat: <?php echo $map['latitude']; ?>,
                        lng: <?php echo $map['longitude']; ?>,
                    };

                    mapElement = document.getElementById("<?php echo $map['selector'] ?>");

                    mapOptions = {
                        //disableDefaultUI: true,
                        center: uluru,

                        zoom: <?php echo $map['zoom'] ?>,
                        zoomControl: <?php $this->isOptionEnabled($map['control']['zoom']) ?>,
                        zoomControlOptions: {
                            position: <?php echo $map['position']['zoom'] ?>,
                        },

                        scaleControl: <?php $this->isOptionEnabled($map['control']['scale']) ?>,

                        gestureHandling: "<?php echo $map['control']['gesture_handling'] ?>",

                        fullscreenControl: <?php $this->isOptionEnabled($map['control']['full_screen']) ?>,
                        fullscreenControlOptions: {
                            position: <?php echo $map['position']['full_screen'] ?>,
                        },

                        mapTypeId: "<?php echo $map['themes']['type'] ?>",
                        mapTypeControl: <?php $this->isOptionEnabled($map['control']['type']) ?>,
                        mapTypeControlOptions: {
                            style: <?php echo $map['control']['type'] ?>,
                            position: <?php echo $map['position']['type'] ?>,
                        },

                        streetViewControl: <?php $this->isOptionEnabled($map['control']['street_view']) ?>,
                        streetViewControlOptions: {
                            position: <?php echo $map['position']['street_view'] ?>,
                        },

                        draggable: <?php $this->isOptionEnabled($map['control']['draggable']) ?>,
                        scrollwheel: <?php $this->isOptionEnabled($map['control']['scroll_wheel']) ?>,
                        disableDoubleClickZoom: <?php $this->isOptionEnabled($map['control']['double_click_zoom']) ?>,

                        clickableIcons: <?php $this->isOptionEnabled($map['control']['clickable_poi']) ?>,

                        styles: <?php echo $map['themes']['styles'] === 0 ? '[]' : $this->snazzy_maps->getItemJson($map['themes']['styles']) ?>,
                    };

                    map = new google.maps.Map(mapElement, mapOptions);

                    mapMarker = new google.maps.Marker({
                        animation: <?php echo $map['marker']['animation'] !== 0 ? $map['marker']['animation'] : 'null'; ?>,
                        clickable: <?php $this->isOptionEnabled($map['marker']['clickable']) ?>,
                        crossOnDrag: <?php $this->isOptionEnabled($map['marker']['cross_drag']) ?>,
                        cursor: "<?php echo $map['marker']['cursor'] ?>",
                        draggable: <?php $this->isOptionEnabled($map['marker']['draggable']) ?>,
                        icon: {
                            'fillColor': '#ee1c25',
                            'fillOpacity': 1,
                            'strokeWeight': 0,
                            'scale': 1.1,
                            'path': 'M10.2,7.4c-6,0-10.9,4.9-10.9,10.9c0,6,10.9,18.4,10.9,18.4s10.9-12.3,10.9-18.4C21.2,12.2,16.3,7.4,10.2,7.4z M10.2,22.9c-2.6,0-4.6-2.1-4.6-4.6s2.1-4.6,4.6-4.6s4.6,2.1,4.6,4.6S12.8,22.9,10.2,22.9z',
                            'anchor': {'x': 10, 'y': 30},
                            'origin': {'x': 0, 'y': 0},
                            'style': 1
                        },
                        label: "<?php echo $map['marker']['label'] ?>",
                        map: map,
                        opacity: <?php echo $map['marker']['opacity'] ?>,
                        optimized: <?php $this->isOptionEnabled($map['marker']['optimized']) ?>,
                        position: uluru,
                        title: "<?php echo $map['marker']['title'] ?>",
                        visible: <?php $this->isOptionEnabled($map['marker']['visible']) ?>,
                        zIndex: <?php echo $map['marker']['zindex'] ?>,
                    });

                    <?php
                    if ('off' !== $map['layers']) {
                        echo sprintf('var %1$sLayer = new google.maps.%2$sLayer(); %1$sLayer.setMap(map);' . PHP_EOL,
                            $map['layers'], ucfirst($map['layers']));
                    }

                    if ($map['info_window']['enable']) { ?>

                    var iwObj, iwWrapper, iwHeader, iwContent, iwOptions = '';

                    iwObj = {
                        'name': '<?php echo $map['info_window']['name'] ?>',
                        'address': '<?php echo $map['info_window']['address'] ?>',
                        'phone': '<?php echo $map['info_window']['phone_number'] ?>',
                        'url': '<?php echo $map['info_window']['website_url'] ?>',
                        'email': '<?php echo $map['info_window']['email'] ?>',
                        'details': '<?php echo $map['info_window']['details'] ?>',
                    };

                    iwOptions += iwObj.address ? '<div class="iw-options">' + iwObj.address + '</div>' : '';
                    iwOptions += iwObj.phone ? '<div class="iw-options"><a class="iw-link" href="tel:' + iwObj.phone + '">' + iwObj.phone + '</a></div>' : '';
                    iwOptions += iwObj.url ? '<div class="iw-options"><a class="iw-link" href="' + iwObj.url + '" target="_blank" rel="nofollow noopener">' + iwObj.url + '</a></div>' : '';
                    iwOptions += iwObj.email ? '<div class="iw-options"><a class="iw-link" href="mailto:' + iwObj.email + '">' + iwObj.email + '</a></div>' : '';
                    iwOptions += iwObj.details ? '<div class="iw-options iw-details">' + iwObj.details + '</div>' : '';

                    iwHeader = iwObj.name ? '<header class="iw-header">' + iwObj.name + '</header>' : '';
                    iwContent = '<div class="iw-content">' + iwOptions + '</div>';

                    iwWrapper = '<div class="iw-wrapper">' + iwHeader + iwContent + '</div>';

                    infoWindow = new google.maps.InfoWindow({
                        content: iwWrapper,
                        disableAutoPan: <?php $this->isOptionEnabled($map['info_window']['disable_auto_pan']) ?>,
                        maxWidth: <?php echo $map['info_window']['max_width'] ?>,
                        zIndex: <?php echo $map['info_window']['zindex'] ?>,
                    });

                    google.maps.event.addListener(mapMarker, 'click', function () {
                        infoWindow.open(map, mapMarker);
                        console.log('Marker was clicked!');
                    });

                    google.maps.event.addListener(map, 'click', function () {
                        infoWindow.close();
                    });

                    <?php /*
                    google.maps.event.addListener(infoWindow, 'domready', function () {
                        var iwOuter, iwBackground, iwButton;
                        iwOuter = document.querySelector('.gm-style-iw');
                        iwBackground = iwOuter.previousElementSibling;
                        iwButton = iwOuter.nextElementSibling;
                        console.log(iwOuter, iwBackground, iwButton);
                    });
                    */ ?>

                    <?php } ?>

                    console.log('Google Maps API version: ' + google.maps.version);
                }
            </script>
        <?php }
    }

    $google_map = new GoogleMaps;
    $google_map->init();
}

if (!function_exists('google_map')) {
    /**
     * Display Google Map (HTML + Script tag with callback function)
     */
    function google_map()
    {
        if (class_exists('GoogleMaps')) {
            /**
             * @var GoogleMaps $google_map
             */
            global $google_map;
            $google_map->htmlMarkup();
        }
    }
}
