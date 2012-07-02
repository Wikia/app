<?php

/**
 * Abstract class MapsBaseMap provides the scafolding for classes handling display_map
 * calls for a specific mapping service. It inherits from MapsMapFeature and therefore
 * forces inheriting classes to implement sereveral methods.
 *
 * @file Maps_BaseMap.php
 * @ingroup Maps
 *
 * @author Jeroen De Dauw
 */
class MapsBaseMap {
	
	/**
	 * @since 0.6.x
	 * 
	 * @var iMappingService
	 */	
	protected $service;

	/**
	 * @since 0.7.3
	 * 
	 * @var array
	 */
	protected $properties = array();
	
	/**
	 * Constructor.
	 * 
	 * @param MapsMappingService $service
	 */
	public function __construct( iMappingService $service ) {
		$this->service = $service;
	}
	
	/**
	 * @since 0.7.3
	 */	
	public function addParameterInfo( array &$params ) {
	}
	
	/**
	 * Handles the request from the parser hook by doing the work that's common for all
	 * mapping services, calling the specific methods and finally returning the resulting output.
	 *
	 * @since 1.0
	 *
	 * @param array $params
	 * @param Parser $parser
	 * 
	 * @return html
	 */
	public final function renderMap( array $params, Parser $parser ) {
		$this->setCentre( $params );
		
		if ( $params['zoom'] === false ) {
			$params['zoom'] = $this->service->getDefaultZoom();
		}
		
		$mapName = $this->service->getMapId();
		
		$output = $this->getMapHTML( $params, $parser, $mapName ) . $this->getJSON( $params, $parser, $mapName );
		
		$configVars = Skin::makeVariablesScript( $this->service->getConfigVariables() );
		
		// MediaWiki 1.17 does not play nice with addScript, so add the vars via the globals hook.
		if ( version_compare( $GLOBALS['wgVersion'], '1.18', '<' ) ) {
			$GLOBALS['egMapsGlobalJSVars'] += $this->service->getConfigVariables();
		}
		
		global $wgTitle;
		if ( !is_null( $wgTitle ) && $wgTitle->isSpecialPage() ) {
			global $wgOut;
			$this->service->addDependencies( $wgOut );
			$wgOut->addScript( $configVars );
		}
		else {
			$this->service->addDependencies( $parser );
			$parser->getOutput()->addHeadItem( $configVars );			
		}
		
		return $output;
	}
	
	/**
	 * Returns the HTML to display the map.
	 * 
	 * @since 1.0
	 * 
	 * @param array $params
	 * @param Parser $parser
	 * @param string $mapName
	 * 
	 * @return string
	 */
	protected function getMapHTML( array $params, Parser $parser, $mapName ) {
		return Html::element(
			'div',
			array(
				'id' => $mapName,
				'style' => "width: {$params['width']}; height: {$params['height']}; background-color: #cccccc; overflow: hidden;",
			),
			wfMsg( 'maps-loading-map' )
		);
	}		
	
	/**
	 * Returns the JSON with the maps data.
	 *
	 * @since 0.7.3
	 *
	 * @param array $params
	 * @param Parser $parser
	 * @param string $mapName
	 * 
	 * @return string
	 */	
	protected function getJSON( array $params, Parser $parser, $mapName ) {
		$object = $this->getJSONObject( $params, $parser );
		
		if ( $object === false ) {
			return '';
		}
		
		return Html::inlineScript(
			MapsMapper::getBaseMapJSON( $this->service->getName() )
			. "mwmaps.{$this->service->getName()}.{$mapName}=" . FormatJson::encode( $object ) . ';'
		);
	}
	
	/**
	 * Returns a PHP object to encode to JSON with the map data.
	 *
	 * @since 0.7.3
	 *
	 * @param array $params
	 * @param Parser $parser
	 * 
	 * @return mixed
	 */	
	protected function getJSONObject( array $params, Parser $parser ) {
		return $params;
	}
	
	/**
	 * Translates the coordinates field to the centre field and makes sure it's set to it's default when invalid. 
	 * 
	 * @since 1.0
	 * 
	 * @param array &$params
	 */
	protected function setCentre( array &$params ) {
		// If it's false, the coordinate was invalid, or geocoding failed. Either way, the default's should be used.
		if ( $params['coordinates'] === false ) {
			global $egMapsDefaultMapCentre;
		
			$centre = MapsGeocoders::attemptToGeocode( $egMapsDefaultMapCentre, $params['geoservice'], $this->service->getName() );
			
			if ( $centre === false ) {
				throw new Exception( 'Failed to parse the default centre for the map. Please check the value of $egMapsDefaultMapCentre.' );
			}
			else {
				$params['centre'] = $centre;
			}
		}
		else {
			$params['centre'] = $params['coordinates'];
		}
		
		unset( $params['coordinates'] );
	}
	
}