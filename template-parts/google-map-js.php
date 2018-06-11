<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfg_bUbfwXmpJaKc27H03VaQXPZELMS_I&callback=initMap" async
        defer></script>
<?php
$map = get_google_map_options();

function isOptionEnabled($option)
{
    echo $option ? 'true' : 'false';
}

dump($map);

if (true === $map['enable']) { ?>
    <script>
        function initMap() {
            var uluru, map, mapElement, mapMarker, mapOptions;

            uluru = {
                lat: <?php echo $map['latitude']; ?>,
                lng: <?php echo $map['longitude']; ?>,
            };

            mapElement = document.getElementById("<?php echo $map['selector'] ?>");

            mapOptions = {
                center: uluru,

                zoom: <?php echo $map['zoom'] ?>,
                zoomControl: <?php isOptionEnabled($map['zoom_control']) ?>,
                zoomControlOptions: {
                    position: <?php echo $map['zoom_position'] ?>
                },

                scaleControl: <?php isOptionEnabled($map['scale_control']) ?>,

                gestureHandling: "<?php echo $map['gesture_handling_control'] ?>",

                fullscreenControl: <?php isOptionEnabled($map['full_screen_control']) ?>,
                fullscreenControlOptions: {
                    position: <?php echo $map['full_screen_position'] ?>,
                },

                mapTypeId: "<?php echo $map['type_themes'] ?>",
                mapTypeControl: <?php isOptionEnabled($map['type_control']) ?>,
                mapTypeControlOptions: {
                    style: <?php echo $map['type_control'] ?>,
                    position: <?php echo $map['type_position'] ?>
                },

                streetViewControl: <?php isOptionEnabled($map['street_view_control']) ?>,
                streetViewControlOptions: {
                    position: <?php echo $map['street_view_position'] ?>
                },

                draggable: <?php isOptionEnabled($map['draggable']) ?>,
                scrollwheel: <?php isOptionEnabled($map['scroll_wheel']) ?>,
                disableDoubleClickZoom: <?php isOptionEnabled($map['double_click_zoom']) ?>,

                clickableIcons: <?php isOptionEnabled($map['clickable_poi_control']) ?>,

                /*styles: [{
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [{"color": "#000000"}, {"lightness": 17}]
                }, {
                    "featureType": "landscape",
                    "elementType": "geometry",
                    "stylers": [{"color": "#000000"}, {"lightness": 20}]
                }, {
                    "featureType": "road.highway",
                    "elementType": "geometry.fill",
                    "stylers": [{"color": "#000000"}, {"lightness": 17}]
                }, {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [{"color": "#000000"}, {"lightness": 29}, {"weight": 0.2}]
                }, {
                    "featureType": "road.arterial",
                    "elementType": "geometry",
                    "stylers": [{"color": "#000000"}, {"lightness": 18}]
                }, {
                    "featureType": "road.local",
                    "elementType": "geometry",
                    "stylers": [{"color": "#000000"}, {"lightness": 16}]
                }, {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [{"color": "#000000"}, {"lightness": 21}]
                }, {
                    "elementType": "labels.text.stroke",
                    "stylers": [{"visibility": "on"}, {"color": "#000000"}, {"lightness": 16}]
                }, {
                    "elementType": "labels.text.fill",
                    "stylers": [{"saturation": 36}, {"color": "#000000"}, {"lightness": 40}]
                }, {"elementType": "labels.icon", "stylers": [{"visibility": "off"}]}, {
                    "featureType": "transit",
                    "elementType": "geometry",
                    "stylers": [{"color": "#000000"}, {"lightness": 19}]
                }, {
                    "featureType": "administrative",
                    "elementType": "geometry.fill",
                    "stylers": [{"color": "#000000"}, {"lightness": 20}]
                }, {
                    "featureType": "administrative",
                    "elementType": "geometry.stroke",
                    "stylers": [{"color": "#000000"}, {"lightness": 17}, {"weight": 1.2}]
                }]*/
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
                map: map
            });
        }
    </script>
<?php } ?>
