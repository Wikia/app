<?php

/**
 * Class for handling the display_point(s) parser functions with OpenLayers.
 *
 * @file Maps_OpenLayersDispPoint.php
 * @ingroup MapsOpenLayers
 *
 * @author Jeroen De Dauw
 */
class MapsOpenLayersDispPoint extends MapsBasePointMap {
	
	/**
	 * @see MapsBaseMap::addSpecificMapHTML
	 */
	public function addSpecificMapHTML( Parser $parser ) {
		global $wgLang;
		
		$mapName = $this->service->getMapId();
		
		$this->output .= Html::element(
			'div',
			array(
				'id' => $mapName,
				'style' => "width: $this->width; height: $this->height; background-color: #cccccc; overflow: hidden;",
			),
			wfMsg( 'maps-loading-map' )
		);
		
		$langCode = $wgLang->getCode();
		
		MapsMapper::addInlineScript( $this->service, <<<EOT
		initOpenLayer(
			"$mapName",
			$this->centreLon,
			$this->centreLat,
			$this->zoom,
			{$this->layers},
			[$this->controls],
			$this->markerJs,
			"$langCode"
		);
EOT
		);
	}

}