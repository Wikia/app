 /**
  * Javascript functions for Google Maps v3 functionality in Maps.
  *
  * @file GoogleMap3Functions.js
  * @ingroup MapsGoogleMaps3
  *
  * @author Jeroen De Dauw
  */

/**
 * Created a new Map object with the provided properties and markers.
 */
function initGMap3( name, options, markerData ) {
	options.center = new google.maps.LatLng( options.lat, options.lon );
	
	var map = new google.maps.Map( document.getElementById( name ), options );
	
	// TODO: types - http://code.google.com/apis/maps/documentation/v3/reference.html#MapTypeRegistry
	
	for ( var i = markerData.length - 1; i >= 0; i-- ) {
		getGMaps3Marker( map, markerData[i] );
	}
}

function getGMaps3Marker( map, data ) {
	var marker = new google.maps.Marker( { 
		position: new google.maps.LatLng( data.lat, data.lon ),
		map: map,
		title: data.title,
		icon: data.icon
	} );
	
	var bothTxtAreSet = data.title.length > 0 && data.label.length > 0;
	var popupText = bothTxtAreSet ? '<b>' + data.title + '</b><hr />' + data.label : data.title + data.label;	
	
	var infowindow = new google.maps.InfoWindow( { content: popupText } );
	
	google.maps.event.addListener( marker, "click", function() {
		infowindow.close();
        infowindow.open( map, marker );    		
	} );
	
	return marker;
}