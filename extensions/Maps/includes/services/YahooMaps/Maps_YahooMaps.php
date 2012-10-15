<?php

/**
 * Class holding information and functionallity specific to Yahoo! Maps.
 * This infomation and features can be used by any mapping feature. 
 * 
 * @file Maps_YahooMaps.php
 * @ingroup MapsYahooMaps
 * 
 * @author Jeroen De Dauw
 */
class MapsYahooMaps extends MapsMappingService {

	/**
	 * Mapping for Yahoo! Maps map types. 
	 * See http://developer.yahoo.com/maps/ajax
	 * 
	 * @since 0.7
	 * 
	 * @var array
	 */
	public static $mapTypes = array(
		'normal' => 'YAHOO_MAP_REG',
		'satellite' => 'YAHOO_MAP_SAT',
		'hybrid' => 'YAHOO_MAP_HYB',
	);
	
	/**
	 * Constructor.
	 * 
	 * @since 0.6.6
	 */
	function __construct( $serviceName ) {
		parent::__construct(
			$serviceName,
			array( 'yahoo', 'yahoomap', 'ymap', 'ymaps' )
		);
	}		
	
	/**
	 * @see MapsMappingService::addParameterInfo
	 * 
	 * @since 0.7
	 */		
	public function addParameterInfo( array &$params ) {
		global $egMapsYahooAutozoom, $egMapsYahooMapsType, $egMapsYahooMapsTypes;
		global $egMapsYahooMapsZoom, $egMapsYMapControls, $egMapsResizableByDefault;
		
		$params['zoom']->addCriteria( new CriterionInRange( 1, 13 ) );
		$params['zoom']->setDefault( self::getDefaultZoom() );		
		
		$params['controls'] = new ListParameter( 'controls' );
		$params['controls']->setDefault( $egMapsYMapControls );
		$params['controls']->addCriteria( new CriterionInArray( self::getControlNames() ) );
		$params['controls']->addManipulations( new ParamManipulationFunctions( 'strtolower' ) );	
		$params['controls']->setMessage( 'maps-yahoomaps-par-controls' );
		
		$params['type'] = new Parameter(
			'type',
			Parameter::TYPE_STRING,
			$egMapsYahooMapsType, // FIXME: default value should not be used when not present in types parameter.
			array(),
			array(
				new CriterionInArray( self::getTypeNames() ),
			),
			array( 'types' )
		);
		$params['type']->addManipulations( new MapsParamYMapType() );
		$params['type']->setMessage( 'maps-yahoomaps-par-type' );

		$params['types'] = new ListParameter(
			'types',
			ListParameter::DEFAULT_DELIMITER,
			Parameter::TYPE_STRING,
			$egMapsYahooMapsTypes,
			array(),
			array(
				new CriterionInArray( self::getTypeNames() ),
			)
		);
		$params['types']->addManipulations( new MapsParamYMapType() );
		$params['types']->setMessage( 'maps-yahoomaps-par-types' );
		
		$params['autozoom'] = new Parameter(
			'autozoom',
			Parameter::TYPE_BOOLEAN,
			$egMapsYahooAutozoom
		);
		$params['autozoom']->setMessage( 'maps-yahoomaps-par-autozoom' );
		
		$params['resizable'] = new Parameter( 'resizable', Parameter::TYPE_BOOLEAN );
		$params['resizable']->setDefault( $egMapsResizableByDefault, false );
		$params['resizable']->setMessage( 'maps-par-resizable' );
	}
	
	/**
	 * @see iMappingService::getDefaultZoom
	 * 
	 * @since 0.6.5
	 */	
	public function getDefaultZoom() {
		global $egMapsYahooMapsZoom;
		return $egMapsYahooMapsZoom;
	}
	
	/**
	 * @see iMappingService::getEarthZoom
	 * 
	 * @since 1.0
	 */
	public function getEarthZoom() {
		return 17;
	}	

	/**
	 * @see MapsMappingService::getMapId
	 * 
	 * @since 0.6.5
	 */
	public function getMapId( $increment = true ) {
		static $mapsOnThisPage = 0;
		
		if ( $increment ) {
			$mapsOnThisPage++;
		}
		
		return 'map_yahoo_' . $mapsOnThisPage;
	}		
	
	/**
	 * @see MapsMappingService::getDependencies
	 * 
	 * @return array
	 */
	protected function getDependencies() {
		global $egYahooMapsKey;
		
		return array(
			Html::linkedScript( "http://api.maps.yahoo.com/ajaxymap?v=3.8&appid=$egYahooMapsKey" )
		);		
	}	
	
	/**
	 * Returns the names of all supported map types.
	 * 
	 * @return array
	 */
	public static function getTypeNames() {
		return array_keys( self::$mapTypes );
	}

	/**
	 * Returns the names of all supported controls. 
	 * This data is a copy of the one used to actually translate the names
	 * into the controls, since this resides client side, in YahooMapFunctions.js. 
	 * 
	 * @return array
	 */
	public static function getControlNames() {
		return array( 'scale', 'type', 'pan', 'zoom', 'zoom-short', 'auto-zoom' );
	}

	/**
	 * @see MapsMappingService::getResourceModules
	 * 
	 * @since 1.0
	 * 
	 * @return array of string
	 */
	public function getResourceModules() {
		return array_merge(
			parent::getResourceModules(),
			array( 'ext.maps.yahoomaps' )
		);
	}
	
}
