/**
 * JavasSript for Google Maps v2 maps in the Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Maps
 * 
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $ ){ $.fn.googlemaps2 = function( options ) {
	
	options.types = ensureTypeIsSelectable( options.type, options.types );
	
	var types = [];
	
	for ( i in options.types ) {
		types.push( eval( options.types[i] ) );
	}
	
	var mapOptions = {
		mapTypes: types
	};
	
	var map = new GMap2( this.get( 0 ), mapOptions );
	
	map.setMapType( eval( options.type ) ); 
	
	var hasSearchBar = false;
	
	for ( var i = options.controls.length - 1; i >= 0; i-- ) {
		if ( options.controls[i] == 'searchbar' ) {
			hasSearchBar = true;
			break;
		}
	}
	
	// List of GControls: http://code.google.com/apis/maps/documentation/reference.html#GControl
	for ( var i = 0, n = options.controls.length; i < n; i++ ) {
		if ( options.controls[i] == 'auto' ) {
			if ( this.get( 0 ).offsetHeight > 75 ) options.controls[i] = this.get( 0 ).offsetHeight > 320 ? 'large' : 'small';
		}			

		switch ( options.controls[i] ) {
			case 'large' : 
				map.addControl( new GLargeMapControl3D() );
				break;
			case 'small' : 
				map.addControl( new GSmallZoomControl3D() );
				break;
			case 'large-original' : 
				map.addControl( new GLargeMapControl() );
				break;
			case 'small-original' : 
				map.addControl( new GSmallMapControl() );
				break;
			case 'zoom' : 
				map.addControl( new GSmallZoomControl() );
				break;
			case 'type' : 
				map.addControl( new GMapTypeControl() );
				break;				
			case 'type-menu' : 
				map.addControl( new GMenuMapTypeControl() );
				break;
			//case 'overlays' : 
			//	map.addControl( new MoreControl() );
			//	break;		
			case 'overview' : case 'overview-map' : 
				map.addControl( new GOverviewMapControl() );
				break;
			case 'scale' : 
				if ( hasSearchBar ) {
					map.addControl( new GScaleControl(), new GControlPosition( G_ANCHOR_BOTTOM_LEFT, new GSize( 5,37 ) ) );
				}
				else {
					map.addControl( new GScaleControl() );
				}
				break;
			case 'nav-label' : case 'nav' : 
				map.addControl( new GNavLabelControl() );
				break;
			case 'searchbar' :
				map.enableGoogleBar();
				break;
		}
	}	
	
	if ( !options.locations ) {
		options.locations = [];
	}
	
	var bounds = ( ( options.zoom === false || options.centre === false ) && options.locations.length > 1 ) ? new GLatLngBounds() : null;

	for ( i = options.locations.length - 1; i >= 0; i-- ) {
		var location = options.locations[i];
		location.point = new GLatLng( location.lat, location.lon );
		map.addOverlay( createGMarker( location ) );
		if ( bounds != null ) bounds.extend( location.point );
	}

	if ( bounds != null ) {
		map.setCenter( bounds.getCenter(), map.getBoundsZoomLevel( bounds ) );
	}

	if ( options.centre !== false ) {
		map.setCenter( new GLatLng( options.centre.lat, options.centre.lon ) );
	}
	
	if ( options.zoom !== false ) {
		map.setZoom( options.zoom );
	}
	
	if ( options.autozoom ) {
		map.enableScrollWheelZoom();
	}

	map.enableContinuousZoom();
	
	// Code to add KML files.
	for ( i = options.kml.length - 1; i >= 0; i-- ) {
		map.addOverlay( new GGeoXml( options.kml[i] ) );
	}
	
	if ( options.resizable ) {
		mw.loader.using( 'ext.maps.resizable', function() {
			_this.resizable();
		} );
	}
	
    function ensureTypeIsSelectable( type, types ) {
    	var typesContainType = false;

    	for ( var i = 0, n = types.length; i < n; i++ ) {
    		if ( types[i] == type ) {
    			typesContainType = true;
    			break;
    		}
    	}

    	if ( !typesContainType ) {
    		types.push( type );
    	}
    	
    	return types;
    }

    /**
     * Returns GMarker object on the provided location. It will show a popup baloon
     * with title and label when clicked, if either of these is set.
     */
	function createGMarker( markerData ) {
    	var marker;
    	
    	if ( markerData.icon !== '' ) {
    		var iconObj = new GIcon( G_DEFAULT_ICON );
    		iconObj.image = markerData.icon;
    		
    		var newimg = new Image();
    		newimg.src = markerData.icon;
    		
    		// Only do these things when there is an actual width, which there won,t the first time the image is loaded.
    		// FIXME: this means the image won't have it's correct size when it differs from the default on first load!
    		if ( newimg.width > 0 ) {
    			/* Determine size of icon and pass it in */
    			iconObj.iconSize.width = newimg.width;
    			iconObj.iconSize.height = newimg.height;
    			iconObj.shadow = null;	
    			
    			/* Anchor the icon on bottom middle */
    			var anchor = new GPoint();
    			anchor.x = Math.floor( newimg.width / 2 );
    			anchor.y = newimg.height;
    			iconObj.iconAnchor = anchor;			
    		}

    		marker = new GMarker( markerData.point, { icon: iconObj } );
    	} else {
    		marker = new GMarker( markerData.point );
    	}
    	
    	if ( markerData.text !== '' ) {
    		GEvent.addListener(marker, 'click',
    			function() {
    				marker.openInfoWindowHtml(
						'<div style="overflow:auto;max-height:130px;">' + markerData.text + '</div>',
    					{ maxWidth:350 }
					);
    			}
    		);		
    	}

    	return marker;
    }
	
	return this;
	
}; })( jQuery );