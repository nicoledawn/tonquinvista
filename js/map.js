(function( $ ) {

    const customMapStyles = [
        {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [
                {
                    "visibility": "on"
                },
                {
                    "color": "#DBFAEB"
                }
            ]
        },
        {
            "featureType": "landscape",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#637368"
                }
            ]
        },
        {
            featureType: "poi.business",
            stylers: [
                { 
                    visibility: "off"
                }
            ],
        },
        {
            "featureType": "poi",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#769E72"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#000000"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": "#EBF4A4"
                }
            ]
        },
        {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [
                {
                    "visibility": "on"
                },
                {
                    "color": "#8dab68"
                }
            ]
        },
        {
            "featureType": "poi.attraction",
            "elementType": "geometry",
            "stylers": [
                {
                    "visibility": "on"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "visibility": "simplified"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#5B5B3F"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": "#ABCE83"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "labels.icon",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "road.local",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#DCB00B"
                }
            ]
        },
        {
            "featureType": "road.arterial",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#9BBF72"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#EBF4A4"
                }
            ]
        },
        {
            "featureType": "transit",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "administrative",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "visibility": "on"
                },
                {
                    "color": "#87ae79"
                }
            ]
        },
        {
            "featureType": "administrative",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#7f2200"
                },
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "administrative",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": "#ffffff"
                },
                {
                    "visibility": "on"
                },
                {
                    "weight": 4.1
                }
            ]
        },
        {
            "featureType": "administrative",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#495421"
                }
            ]
        },
        {
            "featureType": "administrative.neighborhood",
            "elementType": "labels",
            "stylers": [
                {
                    "visibility": "on"
                }
            ]
        }
    ]

    /**
     * initMap
     *
     * Renders a Google Map onto the selected jQuery element
     *
     * @date    22/10/19
     * @since   5.8.6
     *
     * @param   jQuery $el The jQuery element.
     * @return  object The map instance.
     */
    function initMap( $el ) {
    
        // Find marker elements within map.
        var $markers = $el.find('.marker');
    
        // Create gerenic map.
        var mapArgs = {
            zoom        : $el.data('zoom') || 10,
            mapTypeId   : google.maps.MapTypeId.ROADMAP,
            styles      : customMapStyles,
        };

        var map = new google.maps.Map( $el[0], mapArgs );
    
        // Add markers.
        map.markers = [];
        $markers.each(function(){
            initMarker( $(this), map );
        });
    
        // Center map based on markers.
        centerMap( map );
    
        // Return map instance.
        return map;
    }
    
    /**
     * initMarker
     *
     * Creates a marker for the given jQuery element and map.
     *
     * @date    22/10/19
     * @since   5.8.6
     *
     * @param   jQuery $el The jQuery element.
     * @param   object The map instance.
     * @return  object The marker instance.
     */
    function initMarker( $marker, map ) {
    
        // Get position from marker.
        var lat = $marker.data('lat');
        var lng = $marker.data('lng');
        var latLng = {
            lat: parseFloat( lat ),
            lng: parseFloat( lng )
        };
    
        // Create marker instance.
        var marker = new google.maps.Marker({
            position : latLng,
            map: map,
            icon: 'https://tonquinvista.bcitwebdeveloper.ca/wp-content/uploads/2021/11/raindrop-map-locator-icon-100x100.png',
        });
    
        // Append to reference for later use.
        map.markers.push( marker );
    
        // If marker contains HTML, add it to an infoWindow.
        if( $marker.html() ){
    
            // Create info window.
            var infowindow = new google.maps.InfoWindow({
                content: $marker.html()
            });
    
            // Show info window when marker is clicked.
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open( map, marker );
            });
        }
    }
    
    /**
     * centerMap
     *
     * Centers the map showing all markers in view.
     *
     * @date    22/10/19
     * @since   5.8.6
     *
     * @param   object The map instance.
     * @return  void
     */
    function centerMap( map ) {
    
        // Create map boundaries from all map markers.
        var bounds = new google.maps.LatLngBounds();
        map.markers.forEach(function( marker ){
            bounds.extend({
                lat: marker.position.lat(),
                lng: marker.position.lng()
            });
        });
    
        // Case: Single marker.
        if( map.markers.length == 1 ){
            map.setCenter( bounds.getCenter() );
    
        // Case: Multiple markers.
        } else{
            map.fitBounds( bounds );
        }
    }
    
    // Render maps on page load.
    $(document).ready(function(){
        $('.acf-map').each(function(){
            var map = initMap( $(this) );
        });
    });
    
    })(jQuery);