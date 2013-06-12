<?php

/**
 * Class holding information and functionality specific to Google Maps v3.
 * This information and features can be used by any mapping feature.
 * 
 * @since 0.7
 * 
 * @file Maps_GoogleMaps3.php
 * @ingroup MapsGoogleMaps3
 * 
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsGoogleMaps3 extends MapsMappingService {
	
	/**
	 * List of map types (keys) and their internal values (values). 
	 * 
	 * @since 0.7
	 * 
	 * @var array
	 */
	public static $mapTypes = array(
		'normal' => 'ROADMAP',
		'roadmap' => 'ROADMAP',
		'satellite' => 'SATELLITE',
		'hybrid' => 'HYBRID',
		'terrain' => 'TERRAIN',
		'physical' => 'TERRAIN',
		'earth' => 'earth'
	);
	
	/**
	 * List of supported map layers. 
	 * 
	 * @since 1.0
	 * 
	 * @var array
	 */
	protected static $mapLayers = array(
		'traffic',
		'bicycling'
	);	
	
	public static $typeControlStyles = array(
		'default' => 'DEFAULT',
		'horizontal' => 'HORIZONTAL_BAR',
		'dropdown' => 'DROPDOWN_MENU'
	);
	
	/**
	 * List of supported control names.
	 * 
	 * @since 1.0
	 * 
	 * @var array
	 */
	protected static $controlNames = array(
		'pan',
		'zoom',
		'type',
		'scale',
		'streetview'
	);		
	
	/**
	 * Constructor.
	 * 
	 * @since 0.6.6
	 */	
	function __construct( $serviceName ) {
		parent::__construct(
			$serviceName,
			array( 'googlemaps', 'google' )
		);
	}
	
	/**
	 * @see MapsMappingService::addParameterInfo
	 * 
	 * @since 0.7
	 */	
	public function addParameterInfo( array &$params ) {
		global $egMapsGMaps3Type, $egMapsGMaps3Types, $egMapsGMaps3Controls, $egMapsGMaps3Layers;
		global $egMapsGMaps3DefTypeStyle, $egMapsGMaps3DefZoomStyle, $egMapsGMaps3AutoInfoWindows;
		global $egMapsResizableByDefault, $egMapsGMaps3DefaultTilt;

		$params['zoom']->setRange( 0, 20 );
		$params['zoom']->setDefault( self::getDefaultZoom() );
		
		$params['type'] = new Parameter( 'type' );
		$params['type']->setDefault( $egMapsGMaps3Type );
		$params['type']->addCriteria( new CriterionInArray( self::getTypeNames() ) );
		$params['type']->addManipulations( new MapsParamGMap3Type() );
		$params['type']->setMessage( 'maps-googlemaps3-par-type' );
		
		$params['types'] = new ListParameter( 'types' );
		$params['types']->addDependencies( 'type' );
		$params['types']->setDefault( $egMapsGMaps3Types );
		$params['types']->addCriteria( new CriterionInArray( self::getTypeNames() ) );		
		$params['types']->addManipulations( new MapsParamGMap3Type(), new MapsParamGMap3Types() );
		$params['types']->setMessage( 'maps-googlemaps3-par-types' );
		
		$params['layers'] = new ListParameter( 'layers' );
		$params['layers']->setDefault( $egMapsGMaps3Layers );
		$params['layers']->addCriteria( new CriterionInArray( self::getLayerNames() ) );
		$params['layers']->setMessage( 'maps-googlemaps3-par-layers' );	
		
		$params['controls'] = new ListParameter( 'controls' );
		$params['controls']->setDefault( $egMapsGMaps3Controls );
		$params['controls']->addCriteria( new CriterionInArray( self::$controlNames ) );
		$params['controls']->addManipulations( new ParamManipulationFunctions( 'strtolower' ) );
		$params['controls']->setMessage( 'maps-googlemaps3-par-controls' );
		
		$params['zoomstyle'] = new Parameter( 'zoomstyle' );
		$params['zoomstyle']->setDefault( $egMapsGMaps3DefZoomStyle );
		$params['zoomstyle']->addCriteria( new CriterionInArray( 'default', 'small', 'large' ) );
		$params['zoomstyle']->addManipulations( new MapsParamGMap3Zoomstyle() );
		$params['zoomstyle']->setMessage( 'maps-googlemaps3-par-zoomstyle' );
		
		$params['typestyle'] = new Parameter( 'typestyle' );
		$params['typestyle']->setDefault( $egMapsGMaps3DefTypeStyle );
		$params['typestyle']->addCriteria( new CriterionInArray( array_keys( self::$typeControlStyles ) ) );
		$params['typestyle']->addManipulations( new MapsParamGMap3Typestyle() );
		$params['typestyle']->setMessage( 'maps-googlemaps3-par-typestyle' );

		$params['autoinfowindows'] = new Parameter( 'autoinfowindows', Parameter::TYPE_BOOLEAN );
		$params['autoinfowindows']->setDefault( $egMapsGMaps3AutoInfoWindows );
		$params['autoinfowindows']->setMessage( 'maps-googlemaps3-par-autoinfowindows' );
		
		$params['kml'] = new ListParameter( 'kml' );
		$params['kml']->setDefault( array() );
		$params['kml']->setMessage( 'maps-googlemaps3-par-kml' );
		$params['kml']->addManipulations(new MapsParamFile());
		
		$params['gkml'] = new ListParameter( 'gkml' );
		$params['gkml']->setDefault( array() );
		$params['gkml']->setMessage( 'maps-googlemaps3-par-gkml' );

		$params['fusiontables'] = new ListParameter( 'fusiontables' );
		$params['fusiontables']->setDefault( array() );
		$params['fusiontables']->setMessage( 'maps-googlemaps3-par-fusiontables' );

		$params['resizable'] = new Parameter( 'resizable', Parameter::TYPE_BOOLEAN );
		$params['resizable']->setDefault( $egMapsResizableByDefault, false );
		$params['resizable']->setMessage( 'maps-par-resizable' );
		
		$params['tilt'] = new Parameter( 'tilt', Parameter::TYPE_INTEGER );
		$params['tilt']->setDefault( $egMapsGMaps3DefaultTilt, false );
		$params['tilt']->setMessage( 'maps-googlemaps3-par-tilt' );
		
		$params['kmlrezoom'] = new Parameter( 'kmlrezoom', Parameter::TYPE_BOOLEAN );
		$params['kmlrezoom']->setDefault( $GLOBALS['egMapsRezoomForKML'], false );
		$params['kmlrezoom']->setMessage( 'maps-googlemaps3-par-kmlrezoom' );

		$params['poi'] = new Parameter( 'poi', Parameter::TYPE_BOOLEAN );
		$params['poi']->setDefault( $GLOBALS['egMapsShowPOI'], false );
		$params['poi']->setMessage( 'maps-googlemaps3-par-poi' );

		$params['imageoverlays'] = new ListParameter( 'imageoverlays' , ';' );
		$params['imageoverlays']->setDefault( array() );
		$params['imageoverlays']->addManipulations( new MapsParamImageOverlay('~'));

		$params['markercluster'] = new Parameter(
			'markercluster' ,
			Parameter::TYPE_BOOLEAN
		);
		$params['markercluster']->setDefault( false );
		$params['markercluster']->setDoManipulationOfDefault( false );

		$params['searchmarkers'] = new Parameter(
			'searchmarkers' ,
			Parameter::TYPE_STRING
		);
		$params['searchmarkers']->setDefault( '' );
		$params['searchmarkers']->addCriteria( new CriterionSearchMarkers() );
		$params['searchmarkers']->setDoManipulationOfDefault( false );

	}
	
	/**
	 * @see iMappingService::getDefaultZoom
	 * 
	 * @since 0.6.5
	 */	
	public function getDefaultZoom() {
		global $egMapsGMaps3Zoom;
		return $egMapsGMaps3Zoom;
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
		
		return 'map_google3_' . $mapsOnThisPage;
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
	 * Returns the names of all supported map layers.
	 * 
	 * @since 1.0
	 * 
	 * @return array
	 */
	public static function getLayerNames() {
		return self::$mapLayers;
	}	
	
	/**
	 * @see MapsMappingService::getDependencies
	 * 
	 * @return array
	 */
	protected function getDependencies() {
		return array(
			self::getApiScript( $GLOBALS['wgLang']->getCode() ),
		);
	}

	public static function getApiScript( $langCode, array $urlArgs = array() ) {
		global $egGoogleJsApiKey;

		$urlArgs = array_merge(
			array(
				'language' => self::getMappedLanguageCode( $langCode ),
				'sensor' => 'false'
			),
			$urlArgs
		);

		if ( $egGoogleJsApiKey !== '' ) {
			$urlArgs['key'] = $egGoogleJsApiKey;
		}

		return Html::linkedScript( 'http://maps.googleapis.com/maps/api/js?' . wfArrayToCgi( $urlArgs ) );
	}
	
	/**
	 * Maps language codes to Google Maps API v3 compatible values.
	 * 
	 * @param string $code
	 * 
	 * @return string The mapped code
	 */
	protected static function getMappedLanguageCode( $code ) {
		$mappings = array(
	         'en_gb' => 'en-gb',// v3 supports en_gb - but wants us to call it en-gb
	         'he' => 'iw',      // iw is googlish for hebrew
	         'fj' => 'fil',     // google does not support Fijian - use Filipino as close(?) supported relative
		);
		
		if ( array_key_exists( $code, $mappings ) ) {
			$code = $mappings[$code];
		}
		
		return $code;
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
			array( 'ext.maps.googlemaps3' )
		);
	}

	/**
	 * Returns a list of all config variables that should be passed to the JS.
	 * 
	 * @since 1.0.1
	 * 
	 * @return array
	 */
	public final function getConfigVariables() {
		return parent::getConfigVariables() 
			+ array(
				'egGoogleJsApiKey' => $GLOBALS['egGoogleJsApiKey']
			);
	}
	
}
