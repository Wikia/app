<?php

/**
 * Class holding information and functionallity specific to Google Maps v2.
 * This infomation and features can be used by any mapping feature. 
 * 
 * @since 0.1
 * 
 * @file Maps_GoogleMaps.php
 * @ingroup MapsGoogleMaps
 * 
 * @author Jeroen De Dauw
 */
class MapsGoogleMaps extends MapsMappingService {
	
	/**
	 * A list of supported overlays.
	 * 
	 * @var array
	 */
	protected static $overlayData = array(
		'photos' => '0',
		'videos' => '1',
		'wikipedia' => '2',
		'webcams' => '3'
	);		
	
	/**
	 * Constructor.
	 * 
	 * @since 0.6.6
	 */
	function __construct( $serviceName ) {
		parent::__construct(
			$serviceName,
			array( 'googlemaps', 'google', 'googlemap', 'gmap', 'gmaps' )
		);
	}
	
	/**
	 * @see MapsMappingService::addParameterInfo
	 * 
	 * @since 0.7
	 */
	public function addParameterInfo( array &$params ) {
		global $egMapsGoogleMapsType, $egMapsGoogleMapsTypes, $egMapsGoogleAutozoom, $egMapsGMapControls, $egMapsGMapOverlays;
		
		$params['zoom']->addCriteria( new CriterionInRange( 0, 20 ) );
		$params['zoom']->setDefault( self::getDefaultZoom() );
		
		$params['controls'] = new ListParameter( 'controls' );
		$params['controls']->setDefault( $egMapsGMapControls );
		$params['controls']->addCriteria( new CriterionInArray( self::getControlNames() ) );
		$params['controls']->addManipulations(
			new ParamManipulationFunctions( 'strtolower' ),
			new ParamManipulationImplode( ',', "'" )
		);		

		$params['type'] = new Parameter(
			'type',
			Parameter::TYPE_STRING,
			$egMapsGoogleMapsType, // FIXME: default value should not be used when not present in types parameter.
			array(),
			array(
				new CriterionInArray( array_keys( self::$mapTypes ) ),
			),
			array( 'types' )		
		);
		$params['type']->addManipulations( new MapsParamGMapType() );

		$params['types'] = new ListParameter(
			'types',
			ListParameter::DEFAULT_DELIMITER,
			Parameter::TYPE_STRING,
			$egMapsGoogleMapsTypes,
			array(),
			array(
				new CriterionInArray( array_keys( self::$mapTypes ) ),
			)
		);
		$params['types']->addManipulations( new MapsParamGMapType(), new ParamManipulationImplode( ',' ) );		
		
		$params['autozoom'] = new Parameter(
			'autozoom',
			Parameter::TYPE_BOOLEAN,
			$egMapsGoogleAutozoom
		);
		$params['autozoom']->addManipulations( new ParamManipulationBoolstr() );
		
		$params['kml'] = new ListParameter( 'kml' );
		$params['kml']->setDefault( array() );
		$params['kml']->addManipulations( new ParamManipulationImplode( ',', "'" ) );

		$params['overlays'] = new ListParameter( 'overlays' );
		$params['overlays']->setDefault( $egMapsGMapOverlays );
		$params['overlays']->addCriteria( new CriterionGoogleOverlay( self::$overlayData ) );
		$params['overlays']->addManipulations( new ParamManipulationFunctions( 'strtolower' ) ); // TODO
	}
	
	/**
	 * @see iMappingService::getDefaultZoom
	 * 
	 * @since 0.6.5
	 */
	public function getDefaultZoom() {
		global $egMapsGoogleMapsZoom;
		return $egMapsGoogleMapsZoom;
	}
	
	/**
	 * Returns all possible values for the overlays parameter.
	 * 
	 * @since 0.7.1
	 * 
	 * @return array
	 */
	public function getOverlayNames() {
		return array_keys( self::$overlayData );
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
		
		return 'map_google_' . $mapsOnThisPage;
	}

	/**
	 * @see MapsMappingService::createMarkersJs
	 * 
	 * @since 0.6.5
	 */
	public function createMarkersJs( array $markers ) {
		$markerItems = array();

		foreach ( $markers as $marker ) {
			$markerItems[] = MapsMapper::encodeJsVar( (object)array(
				'lat' => $marker[0],
				'lon' => $marker[1],
				'title' => $marker[2],
				'label' =>$marker[3],
				'icon' => $marker[4]
			) );
		}
		
		// Create a string containing the marker JS.
		return '[' . implode( ',', $markerItems ) . ']';
	}
	
	/**
	 * A list of mappings between supported map type values and their corresponding JS variable.
	 * 
	 * http://code.google.com/apis/maps/documentation/reference.html#GMapType.G_NORMAL_MAP
	 * 
	 * @var array
	 */ 
	public static $mapTypes = array(
		'normal' => 'G_NORMAL_MAP',
		'satellite' => 'G_SATELLITE_MAP',
		'hybrid' => 'G_HYBRID_MAP',
		'terrain' => 'G_PHYSICAL_MAP',
		'physical' => 'G_PHYSICAL_MAP',
		'earth' => 'G_SATELLITE_3D_MAP',
		'sky' => 'G_SKY_VISIBLE_MAP',
		'moon' => 'G_MOON_VISIBLE_MAP',
		'moon-elevation' => 'G_MOON_ELEVATION_MAP',
		'mars' => 'G_MARS_VISIBLE_MAP',
		'mars-elevation' => 'G_MARS_ELEVATION_MAP',
		'mars-infrared' => 'G_MARS_INFRARED_MAP'
	);
	
	/**
	 * Returns the names of all supported controls. 
	 * This data is a copy of the one used to actually translate the names
	 * into the controls, since this resides client side, in GoogleMapFunctions.js. 
	 * 
	 * @return array
	 */
	public static function getControlNames() {
		return array(
			'auto',
			'large',
			'small',
			'large-original',
			'small-original',
			'zoom',
			'type',
			'type-menu',
			'overlays',
			'overview',
			'overview-map',
			'scale',
			'nav-label',
			'nav',
			'searchbar'
		);
	}
	
	/**
	 * @see MapsMappingService::getDependencies
	 * 
	 * @return array
	 */
	protected function getDependencies() {
		global $wgLang;
		global $egGoogleMapsKey, $egMapsStyleVersion, $egMapsScriptPath;
		
		$langCode = self::getMappedLanguageCode( $wgLang->getCode() ); 
		
		return array(
			Html::linkedScript( "http://maps.google.com/maps?file=api&v=2&key=$egGoogleMapsKey&hl=$langCode" ),
			Html::linkedScript( "$egMapsScriptPath/includes/services/GoogleMaps/GoogleMapFunctions.js?$egMapsStyleVersion" ),
			Html::inlineScript( 'window.unload = GUnload; var msgOverlays = ' . Xml::encodeJsVar( wfMsg( 'maps_overlays' ) ) . ';' )
		);
	}
	
	/**
	 * Maps language codes to Google Maps API v2 compatible values.
	 * 
	 * @param string $code
	 * 
	 * @return string The mapped code
	 */
	protected static function getMappedLanguageCode( $code ) {
		$mappings = array(
	         'en_gb' => 'en',// v2 does not support en_gb - use english :(
	         'he' => 'iw',   // iw is googlish for hebrew
	         'fj' => 'fil',  // google does not support Fijian - use Filipino as close(?) supported relative
	         'or' => 'en'    // v2 does not support Oriya.
		);
		
		if ( array_key_exists( $code, $mappings ) ) {
			$code = $mappings[$code];
		}
		
		return $code;
	}
	
	/**
	 * This function ensures backward compatibility with Semantic Google Maps and other extensions
	 * using $wgGoogleMapsKey instead of $egGoogleMapsKey.
	 */
	public static function validateGoogleMapsKey() {
		global $egGoogleMapsKey, $wgGoogleMapsKey;
		
		if ( isset( $wgGoogleMapsKey ) && trim( $egGoogleMapsKey ) == '' ) {
			$egGoogleMapsKey = $wgGoogleMapsKey;
		}
	}
	
	/**
	 * Adds the needed output for the overlays control.
	 * 
	 * @param string $output
	 * @param string $mapName
	 * @param string $overlays
	 * @param string $controls
	 * 
	 * FIXME: layer onload function kills maps for some reason
	 */
	public function addOverlayOutput( &$output, $mapName, $overlays, $controls ) {
		global $egMapsGMapOverlays, $egMapsGoogleOverlLoaded;
		
		// Check to see if there is an overlays control.
		$hasOverlayControl = in_string( 'overlays', $controls );
		
		$overlayNames = array_keys( self::$overlayData );
		
		$validOverlays = array();
		foreach ( $overlays as $overlay ) {
			$segements = explode( '-', $overlay );
			$name = $segements[0];
			
			if ( in_array( $name, $overlayNames ) ) {
				$isOn = count( $segements ) > 1 ? $segements[1] : '0';
				$validOverlays[$name] = $isOn == '1';
			}
		}
		$overlays = $validOverlays;
		
		// If there are no overlays or there is no control to hold them, don't bother the rest.
		if ( !$hasOverlayControl || count( $overlays ) < 1 ) return;
		
		// Add the inputs for the overlays.
		$addedOverlays = array();
		$overlayHtml = '';
		$onloadFunctions = array();
		
		foreach ( $overlays as $overlay => $isOn ) {
			$overlay = strtolower( $overlay );
			
			if ( in_array( $overlay, $overlayNames ) ) {
				if ( !in_array( $overlay, $addedOverlays ) ) {
					$addedOverlays[] = $overlay;
					$label = wfMsg( 'maps_' . $overlay );
					$urlNr = self::$overlayData[$overlay];
					
					$overlayHtml .= Html::input(
						"$mapName-overlay-box",
						null,
						'checkbox',
						array(
							'id' => "$mapName-overlay-box-$overlay",
							'onclick' => "switchGLayer(GMaps['$mapName'], this.checked, GOverlays[$urlNr])"
						)
					) . htmlspecialchars( $label ) . '<br />' ;
					
					if ( $isOn ) {
						$onloadFunctions[] = "addOnloadHook( function() { initiateGOverlay('$mapName-overlay-box-$overlay', '$mapName', $urlNr) } );";
					}
				}
			}
		}
		
		$output .= Html::rawElement(
			'div',
			array(
				'class' => 'outer-more',
				'id' => htmlspecialchars( "$mapName-outer-more" )
			),
			'<form action="">' .
			Html::rawElement(
				'div',
				array(
					'class' => 'more-box',
					'id' => htmlspecialchars( "$mapName-more-box" )
				),
				$overlayHtml
			) .
			'</form>'
		);
			
		// If the overlays JS and CSS has not yet loaded, do it.
		if ( empty( $egMapsGoogleOverlLoaded ) ) {
			$egMapsGoogleOverlLoaded = true;
			
			$this->addDependency(
				$this->getOverlayCss()
				. Html::inlineScript( 'var timer_' . htmlspecialchars( $mapName ) . ';' . implode( "\n", $onloadFunctions ) )
			);
		}		
	}
	
	/**
	 * Returns CSS for the overlays. 
	 */
	protected function getOverlayCss() {
		return Html::inlineStyle( <<<EOT
.inner-more {
	text-align:center;
	font-size:12px;
	background-color: #fff;
	color: #000;
	border: 1px solid #fff;
	border-right-color: #b0b0b0;
	border-bottom-color: #c0c0c0;
	width:7em;
	cursor: pointer;
}

.inner-more.highlight {
	font-weight: bold;
	border: 1px solid #483D8B;
	border-right-color: #6495ed;
	border-bottom-color: #6495ed;
} 

.more-box {  position:absolute;
	top:25px; left:0px;
	margin-top:-1px;
	font-size:12px;
	padding: 6px 4px;
	width:120px;
	background-color: #fff;
	color: #000;
	border: 1px solid gray;
	border-top:1px solid #e2e2e2;
	display: none;
	cursor:default;
}

.more-box.highlight {
	width:119px;
	border-width:2px;
}
EOT
		);
	}
	
}								