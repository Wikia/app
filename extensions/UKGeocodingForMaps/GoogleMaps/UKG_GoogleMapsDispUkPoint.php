<?php

/**
 * File holding the UKGGoogleMapsDispUkPoint class.
 *
 * @file UKG_GoogleMapsDispUkPoint.php
 * @ingroup UKGeocodingForMaps
 *
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Class for handling the display_uk_point(s) parser functions with Google Maps.
 *
 * @ingroup UKGeocodingForMaps
 *
 * @author Jeroen De Dauw
 */
final class UKGGoogleMapsDispUkPoint extends UKGBaseUkPointMap {
	
	public $serviceName = MapsGoogleMaps::SERVICE_NAME;

	/**
	 * @see MapsBaseMap::setMapSettings()
	 *
	 */
	protected function setMapSettings() {
		global $egMapsGoogleMapsZoom, $egMapsGoogleMapsPrefix, $egMapsGMapOverlays;
		
		$this->elementNamePrefix = $egMapsGoogleMapsPrefix;
		$this->defaultZoom = $egMapsGoogleMapsZoom;
		
		$this->spesificParameters = array(
			'overlays' => array(
				'type' => array( 'string', 'list' ),
				'criteria' => array(
					'is_google_overlay' => array()
					),
				'default' => $egMapsGMapOverlays,
				),
		);
	}
	
	/**
	 * @see MapsBaseMap::doMapServiceLoad()
	 *
	 */
	protected function doMapServiceLoad() {
		global $egGoogleMapsOnThisPage, $loadedAjaxApi, $egGoogleAjaxSearchKey;
		
		MapsGoogleMaps::addGMapDependencies( $this->output );
		$egGoogleMapsOnThisPage++;
		
		if ( !$loadedAjaxApi ) {
			$this->output .= "<script src='http://www.google.com/uds/api?file=uds.js&v=1.0&key=$egGoogleAjaxSearchKey' type='text/javascript'></script>";
			$loadedAjaxApi = true;
		}
		
		$this->elementNr = $egGoogleMapsOnThisPage;
	}
	
	/**
	 * @see MapsBaseMap::addSpecificMapHTML()
	 *
	 */
	public function addSpecificMapHTML( Parser $parser ) {
		global $egValidatorErrorLevel;
		
		MapsGoogleMaps::addOverlayOutput( $this->output, $this->mapName, $this->overlays, $this->controls );
		
		if ( $egValidatorErrorLevel >= Validator_ERRORS_WARN ) {
			$couldNotGeocodeMsg = Xml::escapeJsString( wfMsg( 'ukgeocoding_couldNotGeocode' ) );
			$showErrorJs = "document.getElementById( '{$this->mapName}_errors' ).innerHTML = '$couldNotGeocodeMsg';";
		} else {
			$showErrorJs = '';
		}
		
		$this->output .= Html::element(
			'div',
			array(
				'id' => $this->mapName,
				'style' => "width: $this->width; height: $this->height; background-color: #cccccc;",
			),
			wfMsg( 'maps-loading-map' )
		) . "<div id='{$this->mapName}_errors'></div>";
		
		$parser->getOutput()->addHeadItem(
			Html::inlineScript(
				<<<EOT
$(function() {
	var map = initializeGoogleMap('$this->mapName', 
		{
		lat: 0,
		lon: 0,
		zoom: $this->zoom,
		type: $this->type,
		types: [$this->types],
		controls: [$this->controls],
		scrollWheelZoom: $this->autozoom
		},
		[]
	);
	var localSearch = new GlocalSearch();
	function usePointFromPostcode( marker, callbackFunction ) {
		localSearch.setSearchCompleteCallback( null,
			function() {
				if ( localSearch.results[0] ) {    
					callbackFunction(new GLatLng(localSearch.results[0].lat, localSearch.results[0].lng), marker);
				} else {
					$showErrorJs
				}
			}
		);
		localSearch.execute(marker.location + ", UK");
	}
	function updateGoogleMap(point, marker) {
		map.addOverlay(createGMarker(point, marker.title, marker.label, marker.icon));
		bounds.extend(point);
		map.setCenter(bounds.getCenter(), map.getBoundsZoomLevel(bounds));
		if($this->zoom!=null) map.setZoom($this->zoom);
	}
	var markers = [$this->markerString];
	var bounds = new GLatLngBounds();
	for(i in markers) {
		usePointFromPostcode(markers[i], updateGoogleMap);
	}
});				
EOT
			)
		);
	}
	
}

