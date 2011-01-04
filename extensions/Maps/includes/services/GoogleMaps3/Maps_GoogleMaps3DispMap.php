<?php

/**
 * Class for handling the display_map parser hook with Google Maps v3.
 *
 * @ingroup MapsGoogleMaps3
 *
 * @author Jeroen De Dauw
 */
final class MapsGoogleMaps3DispMap extends MapsBaseMap {
	
	/**
	 * @see MapsBaseMap::getMapHTML()
	 */
	public function getMapHTML( array $params, Parser $parser ) {
		global $egMapsUseRL;
		
		$mapName = $this->service->getMapId();
		
		if ( !$egMapsUseRL ) {
			$centreLat = MapsMapper::encodeJsVar( $params['centre']['lat'] );
			$centreLon = MapsMapper::encodeJsVar( $params['centre']['lon'] );
			$zoom = MapsMapper::encodeJsVar( $params['zoom'] );
			$type = Xml::escapeJsString( $params['type'] );	

			MapsMapper::addInlineScript( $this->service, <<<EOT
			initGMap3(
				"$mapName",
				{
					zoom: $zoom,
					lat: $centreLat,
					lon: $centreLon,	
					types: [],
					mapTypeId: $type
				},
				[]
			);
EOT
			);			
		}
		
		return Html::element(
			'div',
			array(
				'id' => $mapName,
				'style' => "width: {$params['width']}; height: {$params['height']}; background-color: #cccccc; overflow: hidden;",
			),
			wfMsg( 'maps-loading-map' )
		);			
	}
	
}