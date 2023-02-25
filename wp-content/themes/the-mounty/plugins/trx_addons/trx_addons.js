/* global jQuery:false */
/* global THE_MOUNTY_STORAGE:false */
/* global TRX_ADDONS_STORAGE:false */

(function() {
	"use strict";
	
	jQuery(document).on('action.add_googlemap_styles', the_mounty_trx_addons_add_googlemap_styles);
	jQuery(document).on('action.init_hidden_elements', the_mounty_trx_addons_init);
	
	// Add theme specific styles to the Google map
	function the_mounty_trx_addons_add_googlemap_styles(e) {
		if (typeof TRX_ADDONS_STORAGE == 'undefined') return;
		TRX_ADDONS_STORAGE['googlemap_styles']['light'] = [
            {
                "featureType": "administrative",
                "elementType": "all",
                "stylers": [
                    {
                        "weight": "1.26"
                    },
                    {
                        "saturation": "-100"
                    },
                    {
                        "lightness": "-4"
                    }
                ]
            },
            {
                "featureType": "administrative.neighborhood",
                "elementType": "all",
                "stylers": [
                    {
                        "weight": "2.42"
                    },
                    {
                        "hue": "#005aff"
                    },
                    {
                        "lightness": "-3"
                    },
                    {
                        "saturation": "-76"
                    },
                    {
                        "gamma": "0.87"
                    }
                ]
            },
            {
                "featureType": "administrative.neighborhood",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "saturation": "-11"
                    },
                    {
                        "lightness": "6"
                    }
                ]
            },
            {
                "featureType": "landscape.man_made",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#f7f1df"
                    },
                    {
                        "saturation": "-22"
                    },
                    {
                        "lightness": "22"
                    },
                    {
                        "gamma": "1.00"
                    }
                ]
            },
            {
                "featureType": "landscape.natural",
                "elementType": "all",
                "stylers": [
                    {
                        "saturation": "32"
                    },
                    {
                        "lightness": "10"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "poi.attraction",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "lightness": "12"
                    },
                    {
                        "saturation": "-27"
                    },
                    {
                        "gamma": "1.00"
                    },
                    {
                        "weight": "0.87"
                    }
                ]
            },
            {
                "featureType": "poi.business",
                "elementType": "all",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "poi.business",
                "elementType": "geometry",
                "stylers": [
                    {
                        "visibility": "on"
                    }
                ]
            },
            {
                "featureType": "poi.business",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "saturation": "18"
                    },
                    {
                        "hue": "#ffc100"
                    },
                    {
                        "lightness": "15"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#bde6ab"
                    }
                ]
            },
            {
                "featureType": "poi.sports_complex",
                "elementType": "geometry",
                "stylers": [
                    {
                        "hue": "#ff8200"
                    },
                    {
                        "gamma": "1.13"
                    },
                    {
                        "lightness": "-13"
                    },
                    {
                        "saturation": "71"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "lightness": "88"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "off"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffe15f"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [
                    {
                        "color": "#efd151"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels",
                "stylers": [
                    {
                        "saturation": "-63"
                    },
                    {
                        "lightness": "30"
                    },
                    {
                        "gamma": "0.95"
                    },
                    {
                        "weight": "2.76"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "lightness": "30"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "color": "black"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "labels",
                "stylers": [
                    {
                        "visibility": "on"
                    },
                    {
                        "saturation": "-77"
                    },
                    {
                        "lightness": "40"
                    }
                ]
            },
            {
                "featureType": "transit.station.airport",
                "elementType": "geometry.fill",
                "stylers": [
                    {
                        "lightness": "23"
                    },
                    {
                        "saturation": "-38"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#a2daf2"
                    }
                ]
            }
        ];
	}
	
	
	function the_mounty_trx_addons_init(e, container) {
		if (arguments.length < 2) var container = jQuery('body');
		if (container===undefined || container.length === undefined || container.length == 0) return;
		container.find('.sc_countdown_item canvas:not(.inited)').addClass('inited').attr('data-color', THE_MOUNTY_STORAGE['alter_link_color']);
	}

})();