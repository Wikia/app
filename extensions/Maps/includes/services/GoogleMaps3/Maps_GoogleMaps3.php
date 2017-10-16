<?php

/**
 * Class holding information and functionality specific to Google Maps v3.
 * This information and features can be used by any mapping feature.
 *
 * @since 0.7
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
	public function __construct( $serviceName ) {
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

		$params['zoom'] = array(
			'type' => 'integer',
			'range' => array( 0, 20 ),
			'default' => self::getDefaultZoom(),
			'message' => 'maps-googlemaps3-par-zoom',
		);

		$params['type'] = array(
			'default' => $egMapsGMaps3Type,
			'values' => self::getTypeNames(),
			'message' => 'maps-googlemaps3-par-type',
			'post-format' => function( $value ) {
				return MapsGoogleMaps3::$mapTypes[strtolower( $value )];
			},
		);

		$params['types'] = array(
			'dependencies' => 'type',
			'default' => $egMapsGMaps3Types,
			'values' => self::getTypeNames(),
			'message' => 'maps-googlemaps3-par-types',
			'islist' => true,
			'post-format' => function( array $value ) {
				foreach ( $value as &$part ) {
					$part = MapsGoogleMaps3::$mapTypes[strtolower( $part )];
				}

				return $value;
			},
		);

		$params['layers'] = array(
			'default' => $egMapsGMaps3Layers,
			'values' => self::getLayerNames(),
			'message' => 'maps-googlemaps3-par-layers',
			'islist' => true,
		);

		$params['controls'] = array(
			'default' => $egMapsGMaps3Controls,
			'values' => self::$controlNames,
			'message' => 'maps-googlemaps3-par-controls',
			'islist' => true,
			'post-format' => function( $value ) {
				return array_map( 'strtolower', $value );
			},
		);

		$params['zoomstyle'] = array(
			'default' => $egMapsGMaps3DefZoomStyle,
			'values' => array( 'default', 'small', 'large' ),
			'message' => 'maps-googlemaps3-par-zoomstyle',
			'post-format' => 'strtoupper',
		);

		$params['typestyle'] = array(
			'default' => $egMapsGMaps3DefTypeStyle,
			'values' => array_keys( self::$typeControlStyles ),
			'message' => 'maps-googlemaps3-par-typestyle',
			'post-format' => function( $value ) {
				return MapsGoogleMaps3::$typeControlStyles[strtolower( $value )];
			},
		);

		$params['autoinfowindows'] = array(
			'type' => 'boolean',
			'default' => $egMapsGMaps3AutoInfoWindows,
			'message' => 'maps-googlemaps3-par-autoinfowindows',
		);

		$params['resizable'] = array(
			'type' => 'boolean',
			'default' => $egMapsResizableByDefault,
			'message' => 'maps-googlemaps3-par-resizable',
		);

		$params['kmlrezoom'] = array(
			'type' => 'boolean',
			'default' => $GLOBALS['egMapsRezoomForKML'],
			'message' => 'maps-googlemaps3-par-kmlrezoom',
		);

		$params['poi'] = array(
			'type' => 'boolean',
			'default' => $GLOBALS['egMapsShowPOI'],
			'message' => 'maps-googlemaps3-par-poi',
		);

		$params['markercluster'] = array(
			'type' => 'boolean',
			'default' => false,
			'message' => 'maps-googlemaps3-par-markercluster',
		);

		$params['tilt'] = array(
			'type' => 'integer',
			'default' => $egMapsGMaps3DefaultTilt,
			'message' => 'maps-googlemaps3-par-tilt',
		);

		$params['imageoverlays'] = array(
			'type' => 'mapsimageoverlay',
			'default' => array(),
			'delimiter' => ';',
			'islist' => true,
			'message' => 'maps-googlemaps3-par-imageoverlays',
		);

		$params['kml'] = array(
			'default' => array(),
			'message' => 'maps-googlemaps3-par-kml',
			'islist' => true,
			// new MapsParamFile() FIXME
		);

		$params['gkml'] = array(
			'default' => array(),
			'message' => 'maps-googlemaps3-par-gkml',
			'islist' => true,
		);

		$params['fusiontables'] = array(
			'default' => array(),
			'message' => 'maps-googlemaps3-par-fusiontables',
			'islist' => true,
		);

		$params['searchmarkers'] = array(
			'default' => '',
			'message' => 'maps-googlemaps3-par-searchmarkers',
			// new CriterionSearchMarkers() FIXME
		);

		$params['enablefullscreen'] = array(
			'type' => 'boolean',
			'default' => false,
			'message' => 'maps-googlemaps3-par-enable-fullscreen',
		);
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
			self::getApiScript(
				is_string( $GLOBALS['egMapsGMaps3Language'] ) ?
				$GLOBALS['egMapsGMaps3Language'] : $GLOBALS['egMapsGMaps3Language']->getCode()
			 )
		);
	}

	public static function getApiScript( $langCode, array $urlArgs = array() ) {
		$urlArgs = array_merge(
			array(
				'language' => self::getMappedLanguageCode( $langCode ),
				'sensor' => 'false'
			),
			$urlArgs
		);

		return Html::linkedScript( '//maps.googleapis.com/maps/api/js?' . wfArrayToCgi( $urlArgs ) );
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
}
