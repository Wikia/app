/**
 * JavasSript for the Google Maps v3 form input of the Semantic Maps extension.
 * @see http://www.mediawiki.org/wiki/Extension:Semantic_Maps
 * 
 * @since 1.0
 * @ingroup SemanticMaps
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ){ $.fn.gmapsmultiinput = function( mapDivId, options ) {
	var MAPFILES_URL = "http://maps.gstatic.com/intl/en_us/mapfiles/";
	
	var clickIcon = new google.maps.MarkerImage(
	    MAPFILES_URL + 'dd-start.png',
	    new google.maps.Size(20, 34),
	    new google.maps.Point(0, 0),
	    new google.maps.Point(10, 34)
	);
	
	var clickMarker = null;
	
	var geocoder = new google.maps.Geocoder();
	
	this.attr( { 'class': "ui-widget" } ).css( { 'width': 'auto' } );
	
	this.html(
		$( '<div />' ).css( {
			'display': 'none'
		} ).append( $( '<input />' ).attr( { 'type': 'text', 'name': options.inputname, 'id': mapDivId + '_values' } ) )
	);
	
	updateInputValue( semanticMaps.buildInputValue( options.locations ) );
	
	var table = $( '<table />' ).attr( { 'class' : 'mapinput ui-widget ui-widget-content' } );
	this.append( table );
	
	var mapDiv = $( '<div />' )
		.attr( {
			'id': mapDivId,
			'class': 'ui-widget ui-widget-content'
		} )
		.css( {
			'width': options.width,
			'height': options.height
		} );
	this.append( mapDiv );
	mapDiv.googlemaps( options );
	
	google.maps.event.addListener( mapDiv.map, 'click', onClickCallback );
	
	function onClickCallback() {
		// TODO
	}
	
	table.append(
		'<thead><tr class="ui-widget-header "><th colspan="2">' + mw.msg( 'semanticmaps-forminput-locations' ) + '</th></tr></thead><tbody>'
	);
	
	var rowNr = options.locations.length;
	
	for ( i in options.locations ) {
		appendTableRow( i, options.locations[i].lat, options.locations[i].lon );
	}
	
	table.append(
		'<tr id="' + mapDivId + '_addrow"><td width="300px">' +
			'<input type="text" class="text ui-widget-content ui-corner-all" width="95%" id="' + mapDivId + '_addfield" />' +
		'</td><td>' + 
			'<button id="' + mapDivId + '_addbutton" mapid="' + mapDivId + '">' + mw.msg( 'semanticmaps-forminput-add' ) + '</button>' +
		'</td></tr></tbody>'
	);
	
	$( "#" + mapDivId + '_addbutton' ).button().click( onAddButtonClick );
	
	function onAddButtonClick() {
		var location = $( '#' + mapDivId + '_addfield' ).attr( 'value' );
		submitGeocodeQuery( location );
		return false;		
	}
	
	function submitGeocodeQuery( query ) {
		if ( /\s*^\-?\d+(\.\d+)?\s*\,\s*\-?\d+(\.\d+)?\s*$/.test( query ) ) {
			var latlng = parseLatLng(query);
			
			if (latlng == null) {
				$( '#' + mapDivId + '_addfield' ).attr( 'value', '' );
			} else {
				geocode({ 'latLng': latlng });
			}
		} else {
			geocode({ 'address': query });
		}
	}
	
	function parseLatLng(value) {
		value.replace('/\s//g');
		var coords = value.split(',');
		var lat = parseFloat(coords[0]);
		var lng = parseFloat(coords[1]);
		if (isNaN(lat) || isNaN(lng)) {
			return null;
		} else {
			return new google.maps.LatLng(lat, lng);
		}
	}
	
	function geocode(request) {	
		var hash = '';
		
		if (request.latLng) {
		clickMarker = new google.maps.Marker({
			'position': request.latLng,
			'map': map,
			'title': request.latLng.toString(),
			'clickable': false,
			'icon': clickIcon,
			'shadow': shadow
		});
			hash = 'q=' + request.latLng.toUrlValue(6);
		} else {
			hash = 'q=' + request.address;
		}
		
		var vpbias = false;
		var country = '';
		var language = '';
		
		if (vpbias) {
			hash += '&vpcenter=' + map.getCenter().toUrlValue(6);
			hash += '&vpzoom=' + map.getZoom();
			request.bounds = map.getBounds();
		}
		
		if (country) {
			hash += '&country=' + country;
			request.country = country;
		}
		
		if (language) {
			hash += '&language=' + language;
			request.language = language;
		}

		hashFragment = '#' + escape(hash);
		window.location.hash = escape(hash);
		geocoder.geocode(request, showResults);
	}
	
	function showResults(results, status) {
		var reverse = (clickMarker != null); // TODO
		
		if (! results) {
			// TODO
			alert("Geocoder did not return a valid response");
		} else {
			//document.getElementById("statusValue").innerHTML = status;

			if (status == google.maps.GeocoderStatus.OK) {
				//document.getElementById("matchCount").innerHTML = results.length;
				var marker = new google.maps.Marker( {
					map: mapDiv.map,
					position: results[0].geometry.location,
					title: results[0].geometry.location.toString()
				} );
				addLocationRow( results[0].geometry.location.lat(), results[0].geometry.location.lng() );				
				//plotMatchesOnMap(results, reverse);
			} else {
				if ( !reverse) {
					mapDiv.map.setCenter(new google.maps.LatLng(0.0, 0.0));
					mapDiv.map.setZoom(1); // TODO
				}
			}
		}
	}
	
	function plotMatchesOnMap(results, reverse) {
		markers = new Array(results.length);
		var resultsListHtml = "";
		
		var openInfoWindow = function(resultNum, result, marker) {
			return function() {
				if (selected != null) {
					document.getElementById('p' + selected).style.backgroundColor = "white";
					clearBoundsOverlays();
				}
				
				map.fitBounds(result.geometry.viewport);
				infowindow.setContent(getAddressComponentsHtml(result.address_components));
				infowindow.open(map, marker);
				
				if (result.geometry.bounds) {
					boundsOverlay = new google.maps.Rectangle({
						'bounds': result.geometry.bounds,
						'strokeColor': '#ff0000',
						'strokeOpacity': 1.0,
						'strokeWeight': 2.0,
						'fillOpacity': 0.0
					});
					boundsOverlay.setMap(map);
					google.maps.event.addListener(boundsOverlay, 'click', onClickCallback);
					document.getElementById('boundsLegend').style.display = 'block';
				} else {
					boundsOverlay = null;
				}
				
				viewportOverlay = new google.maps.Rectangle({
						'bounds': result.geometry.viewport,
						'strokeColor': '#0000ff',
						'strokeOpacity': 1.0,
						'strokeWeight': 2.0,
						'fillOpacity': 0.0
					});
				viewportOverlay.setMap(map);
				google.maps.event.addListener(viewportOverlay, 'click', onClickCallback);
				document.getElementById('viewportLegend').style.display = 'block';

				document.getElementById('p' + resultNum).style.backgroundColor = "#eeeeff";
				document.getElementById('matches').scrollTop =
					document.getElementById('p' + resultNum).offsetTop -
					document.getElementById('matches').offsetTop;
				selected = resultNum;
			}
		}
			
		for (var i = 0; i < results.length; i++) {
			var icon = new google.maps.MarkerImage(
				getMarkerImageUrl(i),
				new google.maps.Size(20, 34),
				new google.maps.Point(0, 0),
				new google.maps.Point(10, 34)
			);
			
			markers[i] = new google.maps.Marker({
				'position': results[i].geometry.location,
				'map': map,
				'icon': icon,
				'shadow': shadow
			});

			google.maps.event.addListener(markers[i], 'click', openInfoWindow(i, results[i], markers[i]));
			
			resultsListHtml += getResultsListItem(i, getResultDescription(results[i]));
		}
		
		document.getElementById("matches").innerHTML = resultsListHtml;
		document.getElementById("p0").style.border = "none";
		document.getElementById("matches").style.display = "block";

		if (reverse){
			// make a smooth movement to the clicked position
			map.panTo(clickMarker.getPosition());
			google.maps.event.addListenerOnce(map, 'idle', function(){
				selectMarker(0);
			});
		}
		else {
			zoomToViewports(results);
			selectMarker(0);
		}
	}
	
	function getMarkerImageUrl(resultNum) {
		return MAPFILES_URL + "marker" + String.fromCharCode(65 + resultNum) + ".png";
	}
	
	function addLocationRow( lat, lon ) {
		var addRow = $( '#' + mapDivId + '_addrow' );
		
		addRow.remove();
		appendTableRow( rowNr, lat, lon ); // TODO
		table.append( addRow );
		$( '#' + mapDivId + '_addfield' ).attr( 'value', '' );
		$( "#" + mapDivId + '_addbutton' ).button().click( onAddButtonClick );
		rowNr++;
		
		updateInput();
	}
	
	function onRemoveButtonClick() {
		$( '#' + mapDivId + '_row_' + $( this ).attr( 'rowid' ) ).remove();
		updateInput();
		return false;		
	}
	
	function appendTableRow( i, lat, lon ) {
		table.append(
			'<tr id="' + mapDivId + '_row_' + i + '"><td>' +
				coord.dms( lat, lon ) +
			'</td><td>' + 
				'<button class="forminput-remove" rowid="' + i + '" id="' + mapDivId + '_addbutton_' + i + '">' +
					mw.msg( 'semanticmaps-forminput-remove' ) +
				'</button>' + 
			'</td></tr>'
		);
		
		$( "#" + mapDivId + '_addbutton_' + i ).button().click( onRemoveButtonClick );
	}
	

	
	function updateInput() {
		var locations = [];
		
		//$( '' ).each();
		
		updateInputValue( semanticMaps.buildInputValue( locations ) );
	}
	
	function updateInputValue( value ) {
		$( '#' + mapDivId + '_values' ).text( value );
	}
	
	return this;
	
}; })( jQuery, mediaWiki );