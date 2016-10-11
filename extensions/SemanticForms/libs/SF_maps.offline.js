/**
 * @author Yaron Koren
 * @author Paladox
 */

/*jshint -W038 */

function setupMapFormInput( inputDiv, mapService ) {

	/**
	 * Round off a number to five decimal places - that's the most
	 * we need for coordinates, one would think.
	 */
	function sfRoundOffDecimal( num ) {
		return Math.round( num * 100000 ) / 100000;
	}

	var map,
		marker,
		markers;

	function googleMapsSetMarker( location ) {
		if ( marker === undefined ){
			marker = new google.maps.Marker( {
				position: location,
				map: map,
				draggable: true
			} );
		} else {
			marker.setPosition(location);
		}
		var stringVal = sfRoundOffDecimal( location.lat() ) + ', ' + sfRoundOffDecimal( location.lng() );
		inputDiv.find('.sfCoordsInput').val( stringVal );
	}

	function openLayersSetMarker( location ) {
		// OpenLayers does not have a real marker move
		// option - instead, just delete the old marker
		// and add a new one.
		markers.clearMarkers();
		marker = new OpenLayers.Marker( location );
		markers.addMarker( marker );

		// Transform the coordinates back, in order to display them.
		var realLonLat = location.clone();
		realLonLat.transform(
			map.getProjectionObject(), // transform from Spherical Mercator Projection
			new OpenLayers.Projection("EPSG:4326") // to WGS 1984
		);
		var stringVal = sfRoundOffDecimal( realLonLat.lat ) + ', ' + sfRoundOffDecimal( realLonLat.lon );
		inputDiv.find('.sfCoordsInput').val( stringVal );
	}

	if ( mapService === "Google Maps" ) {
		var mapCanvas = inputDiv.find('.sfMapCanvas')[ 0 ];
		var mapOptions = {
			zoom: 1,
			center: new google.maps.LatLng( 0, 0 )
		};
		map = new google.maps.Map( mapCanvas, mapOptions );
		var geocoder = new google.maps.Geocoder();

		google.maps.event.addListener( map, 'click', function( event ) {
			googleMapsSetMarker( event.latLng );
		} );
	} else { // if ( mapService == "OpenLayers" ) {
		var mapCanvasID = inputDiv.find( '.sfMapCanvas' ).attr( 'id' );
		map = new OpenLayers.Map( mapCanvasID );
		map.addLayer( new OpenLayers.Layer.OSM() );
		map.zoomTo( 0 );
		markers = new OpenLayers.Layer.Markers( "Markers" );
		map.addLayer( markers );

		map.events.register( "click", map, function( e ) {
			var opx = map.getLayerPxFromViewPortPx(e.xy) ;
			var loc = map.getLonLatFromPixel( opx );
			openLayersSetMarker( loc );
		} );
	}

	function toOpenLayersLonLat( map, lat, lon ) {
		return new OpenLayers.LonLat( lon, lat ).transform(
			new OpenLayers.Projection( "EPSG:4326" ), // transform from WGS 1984
			map.getProjectionObject() // to Spherical Mercator Projection
		);
	}

	function setMarkerFromInput() {
		var coordsText = inputDiv.find('.sfCoordsInput').val();
		var coordsParts = coordsText.split(",");
		if ( coordsParts.length !== 2 ) {
			inputDiv.find('.sfCoordsInput').val('');
			return;
		}
		var lat = coordsParts[0].trim();
		var lon = coordsParts[1].trim();
		if ( !jQuery.isNumeric( lat ) || !jQuery.isNumeric( lon ) ) {
			inputDiv.find('.sfCoordsInput').val('');
			return;
		}
		if ( lat < -90 || lat > 90 || lon < -180 || lon > 180 ) {
			inputDiv.find('.sfCoordsInput').val('');
			return;
		}
		if ( mapService === "Google Maps" ) {
			var gmPoint = new google.maps.LatLng( lat, lon );
			googleMapsSetMarker( gmPoint );
			map.setCenter( gmPoint );
		} else { // if ( mapService == "OpenLayers" ) {
			var olPoint = toOpenLayersLonLat( map, lat, lon );
			openLayersSetMarker( olPoint );
			map.setCenter( olPoint, 14 );
		}
	}

	inputDiv.find('.sfUpdateMap').click( function() {
		setMarkerFromInput();
	});

	inputDiv.find('.sfCoordsInput').keypress( function( e ) {
		// Is this still necessary fro IE compatibility?
		var keycode = (e.keyCode ? e.keyCode : e.which);
		if ( keycode === 13 ) {
			setMarkerFromInput();
			// Prevent the form from getting submitted.
			e.preventDefault();
		}
	});

	function doLookup() {
		var addressText = inputDiv.find('.sfAddressInput').val(),
			alert;
		if ( mapService === "Google Maps" ) {
			geocoder.geocode( { 'address': addressText }, function(results, status) {
				if (status === google.maps.GeocoderStatus.OK) {
					map.setCenter(results[0].geometry.location);
					googleMapsSetMarker( results[0].geometry.location );
					map.setZoom(14);
				} else {
					alert("Geocode was not successful for the following reason: " + status);
				}
			});
		} // else { if ( mapService == "OpenLayers" ) {
			// Do nothing, for now - address lookup/geocode is
			// not yet enabled for OpenLayers.
		// }
	}

	inputDiv.find('.sfAddressInput').keypress( function( e ) {
		// Is this still necessary fro IE compatibility?
		var keycode = (e.keyCode ? e.keyCode : e.which);
		if ( keycode === 13 ) {
			doLookup();
			// Prevent the form from getting submitted.
			e.preventDefault();
		}
	} );

	inputDiv.find('.sfLookUpAddress').click( function() {
		doLookup();
	});


	if ( inputDiv.find('.sfCoordsInput').val() !== '' ) {
		setMarkerFromInput();
		map.setZoom(14);
	}
}

jQuery(document).ready( function() {
	jQuery(".sfGoogleMapsInput").each( function() {
		setupMapFormInput( jQuery(this), "Google Maps" );
	});
	jQuery(".sfOpenLayersInput").each( function() {
		setupMapFormInput( jQuery(this), "OpenLayers" );
	});
});
