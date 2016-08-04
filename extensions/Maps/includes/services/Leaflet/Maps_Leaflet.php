<?php

/**
 * Class holding information and functionality specific to Leaflet.
 * This information and features can be used by any mapping feature.
 *
 * @licence GNU GPL v2+
 * @author Pavel Astakhov < pastakhov@yandex.ru >
 */
class MapsLeaflet extends MapsMappingService {

	/**
	 * Constructor
	 */
	public function __construct( $serviceName ) {
		parent::__construct(
			$serviceName,
			array( 'leafletmaps', 'leaflet' )
		);
	}

	/**
	 * @see MapsMappingService::addParameterInfo
	 *
	 * @since 3.0
	 */
	public function addParameterInfo( array &$params ) {
		$params['zoom'] = array(
			'type' => 'integer',
			'range' => array( 0, 20 ),
			'default' => false,
			'message' => 'maps-leaflet-par-zoom'
		);

		$params['defzoom'] = array(
			'type' => 'integer',
			'range' => array( 0, 20 ),
			'default' => self::getDefaultZoom(),
			'message' => 'maps-leaflet-par-defzoom'
		);

		$params['resizable'] = array(
			'type' => 'boolean',
			'default' => $GLOBALS['egMapsResizableByDefault'],
			'message' => 'maps-leaflet-par-resizable'
		);
	}

	/**
	 * @see iMappingService::getDefaultZoom
	 *
	 * @since 3.0
	 */
	public function getDefaultZoom() {
		return $GLOBALS['egMapsLeafletZoom'];
	}

	/**
	 * @see MapsMappingService::getMapId
	 *
	 * @since 3.0
	 */
	public function getMapId( $increment = true ) {
		static $mapsOnThisPage = 0;

		if ( $increment ) {
			$mapsOnThisPage++;
		}

		return 'map_leaflet_' . $mapsOnThisPage;
	}

	/**
	 * @see MapsMappingService::getResourceModules
	 *
	 * @since 3.0
	 *
	 * @return array of string
	 */
	public function getResourceModules() {
		return array_merge(
			parent::getResourceModules(),
			array( 'ext.maps.leaflet' )
		);
	}

	protected function getDependencies() {
		$leafletPath = $GLOBALS['wgScriptPath'] . '/extensions/Maps/includes/services/Leaflet/leaflet';
		return array(
			Html::linkedStyle( "$leafletPath/leaflet.css" ),
			'<!--[if lte IE 8]>' . Html::linkedStyle( "$leafletPath/leaflet.ie.css" ). '<![endif]-->',
			Html::linkedScript( "$leafletPath/leaflet.js" ),
		);
	}

}
