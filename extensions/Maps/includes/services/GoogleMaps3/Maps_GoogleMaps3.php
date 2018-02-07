<?php

/**
 * Class holding information and functionality specific to Google Maps v3.
 * This information and features can be used by any mapping feature.
 *
 * @since 0.7
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Peter Grassberger < petertheone@gmail.com >
 */

class MapsGoogleMaps3 extends MapsMappingService {

	/**
	 * Maps user input map types to the Google Maps names for the map types.
	 */
	private static $mapTypes = [
		'normal' => 'ROADMAP',
		'roadmap' => 'ROADMAP',
		'satellite' => 'SATELLITE',
		'hybrid' => 'HYBRID',
		'terrain' => 'TERRAIN',
		'physical' => 'TERRAIN',
		'earth' => 'earth'
	];

	private static $mapLayers = [
		'traffic',
		'bicycling'
	];

	private static $typeControlStyles = [
		'default' => 'DEFAULT',
		'horizontal' => 'HORIZONTAL_BAR',
		'dropdown' => 'DROPDOWN_MENU'
	];

	private static $controlNames = [
		'pan',
		'zoom',
		'type',
		'scale',
		'streetview',
		'rotate'
	];

	public function __construct( $serviceName ) {
		parent::__construct(
			$serviceName,
			[ 'googlemaps', 'google' ]
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

		$params['zoom'] = [
			'type' => 'integer',
			'range' => [ 0, 20 ],
			'default' => self::getDefaultZoom(),
			'message' => 'maps-par-zoom',
		];

		$params['type'] = [
			'default' => $egMapsGMaps3Type,
			'values' => self::getTypeNames(),
			'message' => 'maps-googlemaps3-par-type',
			'post-format' => function ( $value ) {
				return MapsGoogleMaps3::$mapTypes[strtolower( $value )];
			},
		];

		$params['types'] = [
			'dependencies' => 'type',
			'default' => $egMapsGMaps3Types,
			'values' => self::getTypeNames(),
			'message' => 'maps-googlemaps3-par-types',
			'islist' => true,
			'post-format' => function ( array $value ) {
				foreach ( $value as &$part ) {
					$part = self::$mapTypes[strtolower( $part )];
				}

				return $value;
			},
		];

		$params['layers'] = [
			'default' => $egMapsGMaps3Layers,
			'values' => self::getLayerNames(),
			'message' => 'maps-googlemaps3-par-layers',
			'islist' => true,
		];

		$params['controls'] = [
			'default' => $egMapsGMaps3Controls,
			'values' => self::$controlNames,
			'message' => 'maps-googlemaps3-par-controls',
			'islist' => true,
			'post-format' => function ( $value ) {
				return array_map( 'strtolower', $value );
			},
		];

		$params['zoomstyle'] = [
			'default' => $egMapsGMaps3DefZoomStyle,
			'values' => [ 'default', 'small', 'large' ],
			'message' => 'maps-googlemaps3-par-zoomstyle',
			'post-format' => 'strtoupper',
		];

		$params['typestyle'] = [
			'default' => $egMapsGMaps3DefTypeStyle,
			'values' => array_keys( self::$typeControlStyles ),
			'message' => 'maps-googlemaps3-par-typestyle',
			'post-format' => function ( $value ) {
				return self::$typeControlStyles[strtolower( $value )];
			},
		];

		$params['autoinfowindows'] = [
			'type' => 'boolean',
			'default' => $egMapsGMaps3AutoInfoWindows,
			'message' => 'maps-googlemaps3-par-autoinfowindows',
		];

		$params['resizable'] = [
			'type' => 'boolean',
			'default' => $egMapsResizableByDefault,
			'message' => 'maps-par-resizable',
		];

		$params['kmlrezoom'] = [
			'type' => 'boolean',
			'default' => $GLOBALS['egMapsRezoomForKML'],
			'message' => 'maps-googlemaps3-par-kmlrezoom',
		];

		$params['poi'] = [
			'type' => 'boolean',
			'default' => $GLOBALS['egMapsShowPOI'],
			'message' => 'maps-googlemaps3-par-poi',
		];

		$params['markercluster'] = [
			'type' => 'boolean',
			'default' => false,
			'message' => 'maps-par-markercluster',
		];

		$params['clustergridsize'] = [
			'type' => 'integer',
			'default' => 60,
			'message' => 'maps-googlemaps3-par-clustergridsize',
		];

		$params['clustermaxzoom'] = [
			'type' => 'integer',
			'default' => 20,
			'message' => 'maps-par-clustermaxzoom',
		];

		$params['clusterzoomonclick'] = [
			'type' => 'boolean',
			'default' => true,
			'message' => 'maps-par-clusterzoomonclick',
		];

		$params['clusteraveragecenter'] = [
			'type' => 'boolean',
			'default' => true,
			'message' => 'maps-googlemaps3-par-clusteraveragecenter',
		];

		$params['clusterminsize'] = [
			'type' => 'integer',
			'default' => 2,
			'message' => 'maps-googlemaps3-par-clusterminsize',
		];

		$params['tilt'] = [
			'type' => 'integer',
			'default' => $egMapsGMaps3DefaultTilt,
			'message' => 'maps-googlemaps3-par-tilt',
		];

		$params['imageoverlays'] = [
			'type' => 'mapsimageoverlay',
			'default' => [],
			'delimiter' => ';',
			'islist' => true,
			'message' => 'maps-googlemaps3-par-imageoverlays',
		];

		$params['kml'] = [
			'default' => [],
			'message' => 'maps-par-kml',
			'islist' => true,
			// new MapsParamFile() FIXME
		];

		$params['gkml'] = [
			'default' => [],
			'message' => 'maps-googlemaps3-par-gkml',
			'islist' => true,
		];

		$params['fusiontables'] = [
			'default' => [],
			'message' => 'maps-googlemaps3-par-fusiontables',
			'islist' => true,
		];

		$params['searchmarkers'] = [
			'default' => '',
			'message' => 'maps-par-searchmarkers',
			// new CriterionSearchMarkers() FIXME
		];

		$params['enablefullscreen'] = [
			'type' => 'boolean',
			'default' => false,
			'message' => 'maps-par-enable-fullscreen',
		];
	}

	/**
	 * @since 0.6.5
	 */
	public function getDefaultZoom() {
		global $egMapsGMaps3Zoom;
		return $egMapsGMaps3Zoom;
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
	 * @see MapsMappingService::getResourceModules
	 *
	 * @since 1.0
	 *
	 * @return array of string
	 */
	public function getResourceModules() {
		return array_merge(
			parent::getResourceModules(),
			[ 'ext.maps.googlemaps3' ]
		);
	}

	/**
	 * @see MapsMappingService::getDependencies
	 *
	 * @return array
	 */
	protected function getDependencies() {
		return [
			self::getApiScript(
				is_string( $GLOBALS['egMapsGMaps3Language'] ) ?
					$GLOBALS['egMapsGMaps3Language'] : $GLOBALS['egMapsGMaps3Language']->getCode()
			)
		];
	}

	public static function getApiScript( $langCode, array $urlArgs = [] ) {
		$urlArgs = array_merge(
			[
				'language' => self::getMappedLanguageCode( $langCode )
			],
			$urlArgs
		);
		if ( $GLOBALS['egMapsGMaps3ApiKey'] !== '' ) {
			$urlArgs['key'] = $GLOBALS['egMapsGMaps3ApiKey'];
		}
		if ( $GLOBALS['egMapsGMaps3ApiVersion'] !== '' ) {
			$urlArgs['v'] = $GLOBALS['egMapsGMaps3ApiVersion'];
		}

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
		$mappings = [
			'en_gb' => 'en-gb',// v3 supports en_gb - but wants us to call it en-gb
			'he' => 'iw',      // iw is googlish for hebrew
			'fj' => 'fil',     // google does not support Fijian - use Filipino as close(?) supported relative
		];

		if ( array_key_exists( $code, $mappings ) ) {
			$code = $mappings[$code];
		}

		return $code;
	}
}
