<?php

/**
 * Class for handling the display_map parser hook with Yahoo! Maps
 *
 * @file Maps_YahooMapsDispMap.php
 * @ingroup MapsYahooMaps
 *
 * @author Jeroen De Dauw
 */
class MapsYahooMapsDispMap extends MapsBaseMap {
	
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
			initializeYahooMap(
				"$mapName",
				$centreLat,
				$centreLon,
				$zoom,
				$type,
				[{$params['types']}],
				[{$params['controls']}],
				{$params['autozoom']},
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