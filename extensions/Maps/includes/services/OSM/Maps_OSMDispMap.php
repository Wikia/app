<?php

/**
 * Class for handling the display_map parser hook with OSM.
 * 
 * @since 0.6.4
 * 
 * @file Maps_OSMDispMap.php
 * @ingroup OSM
 * 
 * @author Jeroen De Dauw
 */
class MapsOSMDispMap extends MapsBaseMap {
	
	/**
	 * @see MapsBaseMap::getMapHTML()
	 */
	public function getMapHTML( array $params, Parser $parser, $mapName ) {	
		global $wgLang;
		
		$thumbs = $params['thumbs'] ? 'yes' : 'no';
		$photos = $params['photos'] ? 'yes' : 'no';
		$lang = $wgLang->getCode();
		
		// https://secure.wikimedia.org/wikipedia/de/wiki/Wikipedia:WikiProjekt_Georeferenzierung/Wikipedia-World/en#Expert_mode
		return Html::element(
			'iframe',
			array(
				'id' => $mapName,
				'style' => "width: {$params['width']}; height: {$params['height']}; clear: both;",
				'src' => "http://toolserver.org/~kolossos/openlayers/kml-on-ol.php?zoom={$params['zoom']}&lat={$params['centre']['lat']}&lon={$params['centre']['lon']}&lang=$lang&thumbs=$thumbs&photo=$photos"
			),
			wfMsg( 'maps-loading-map' )
		);
	}
	
}
