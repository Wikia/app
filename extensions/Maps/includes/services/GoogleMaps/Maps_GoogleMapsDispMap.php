<?php

/**
 * Class for handling the display_map parser hook with Google Maps.
 *
 * @file Maps_GoogleMapsDispMap.php
 * @ingroup MapsGoogleMaps
 *
 * @author Jeroen De Dauw
 */
final class MapsGoogleMapsDispMap extends MapsBaseMap {
	
	/**
	 * @see MapsBaseMap::getMapHTML()
	 */
	public function getMapHTML( array $params, Parser $parser ) {
		global $egMapsUseRL;
		
		$mapName = $this->service->getMapId();
		
		$output = '';
		
		$this->service->addOverlayOutput( $output, $mapName, $params['overlays'], $params['controls'] );
		
		if ( !$egMapsUseRL ) {
			$centreLat = MapsMapper::encodeJsVar( $params['centre']['lat'] );
			$centreLon = MapsMapper::encodeJsVar( $params['centre']['lon'] );
			$zoom = MapsMapper::encodeJsVar( $params['zoom'] );
			$type = Xml::escapeJsString( $params['type'] );	
				
			MapsMapper::addInlineScript( $this->service, <<<EOT
			initializeGoogleMap("$mapName", 
				{
				lat: $centreLat,
				lon: $centreLon,
				zoom: $zoom,
				type: $type,
				types: [{$params['types']}],
				controls: [{$params['controls']}],
				scrollWheelZoom: {$params['autozoom']},
				kml: [{$params['kml']}]
				},
			[]);
EOT
			);
		}
		
		return $output . Html::element(
			'div',
			array(
				'id' => $mapName,
				'style' => "width: {$params['width']}; height: {$params['height']}; background-color: #cccccc; overflow: hidden;",
			),
			wfMsg( 'maps-loading-map' )
		);			
	}
	
}