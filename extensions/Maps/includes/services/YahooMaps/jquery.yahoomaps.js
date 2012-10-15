/**
 * JavasSript for OpenLayers maps in the Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Maps
 * 
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $ ){ $.fn.yahoomaps = function( mapElementId, options ) {
	
	var typesContainType = false;

	for ( var i = 0; i < options.types.length; i++ ) {
		if ( options.types[i] == options.type ) typesContainType = true;
	}
	
	if ( !typesContainType ) {
		options.types.push( options.type );
	}	 
	 
	var map = new YMap( mapElementId, eval( options.type ) ); 
	
	map.removeZoomScale();

	for ( var i = options.controls.length - 1; i >= 0; i-- ){
		if ( options.controls[i].toLowerCase() == 'auto-zoom' ) {
			if ( this.get( 0 ).offsetHeight > 42 ) options.controls[i] = this.get( 0 ).offsetHeight > 100 ? 'zoom' : 'zoom-short';
		}			
		
		switch ( options.controls[i] ) {
			case 'scale' : 
				map.addZoomScale();
			case 'type' :
				var types = [];
				
				for ( x in options.types ) {
					types.push( eval( options.types[x] ) );
				}
				
				map.addTypeControl( types );
				break;		
			case 'pan' :
				map.addPanControl();
				break;
			case 'zoom' : 
				map.addZoomLong();
				break;		
			case 'zoom-short' : 
				map.addZoomShort();				
				break;
		}
	}
	
	map.setMapType( eval( options.type ) );
	
	if ( !options.autozoom ) map.disableKeyControls();
	
	if ( !options.locations ) {
		options.locations = [];
	}
	
	var map_locations = ( ( options.zoom === false || options.centre === false ) && options.locations.length > 1 ) ? Array() : null;
	
	for ( var i= options.locations.length - 1; i >= 0; i-- ) {
		var location = options.locations[i];
		location.point = new YGeoPoint( location.lat, location.lon );	
		map.addOverlay( createYMarker( location.point, location.title, location.text, location.icon ) );
		if ( map_locations != null ) map_locations.push( location.point );
	}

	if ( map_locations != null ) {
		var centerAndZoom = map.getBestZoomAndCenter( map_locations );
		map.drawZoomAndCenter( centerAndZoom.YGeoPoint, centerAndZoom.zoomLevel );
	}
	
	if ( options.zoom !== false ) map.setZoomLevel( options.zoom );
	
	if ( options.centre !== false ) map.drawZoomAndCenter( new YGeoPoint( options.centre.lat, options.centre.lon ) );
	
	if ( options.resizable ) {
		mw.loader.using( 'ext.maps.resizable', function() {
			_this.resizable();
		} );
	}

    this.addMarker = function( location ) {
		map.addOverlay( createYMarker(
            new YGeoPoint( location.lat, location.lon ),
            location.title,
            location.text,
            location.icon
        ) );
    };
	
	/**
	 * Returns YMarker object on the provided location.
	 * It will show a popup baloon with title and label when clicked, if either of these is set.
	 */
	function createYMarker(geoPoint, title, text, icon){
		var newMarker;
		
		if ( icon !== '' ) {
			// Determine size of icon and pass it in.
			var newimg = new Image();
			newimg.src = icon;
			newMarker = new YMarker( geoPoint,  new YImage( icon, new YSize( newimg.width, newimg.height ) ) );
		} else {
			newMarker = new YMarker( geoPoint );
		}	
		
		if ( text !== '' ) {
			YEvent.Capture(newMarker, EventsList.MouseClick, 
				function() {
					newMarker.openSmartWindow( text );
				}
			);
		}

		return newMarker;
	}	
	
	return this;
	
}; })( jQuery );