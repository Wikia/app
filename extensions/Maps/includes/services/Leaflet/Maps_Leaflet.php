<?php

/**
 * Class holding information and functionality specific to Leaflet.
 * This information and features can be used by any mapping feature.
 *
 * @licence GNU GPL v2+
 * @author Pavel Astakhov < pastakhov@yandex.ru >
 */
class MapsLeaflet extends MapsMappingService {

	public function __construct( $serviceName ) {
		parent::__construct(
			$serviceName,
			[ 'leafletmaps', 'leaflet' ]
		);
	}

	/**
	 * @see MapsMappingService::addParameterInfo
	 *
	 * @since 3.0
	 */
	public function addParameterInfo( array &$params ) {
		global $GLOBALS;

		$params['zoom'] = [
			'type' => 'integer',
			'range' => [ 0, 20 ],
			'default' => false,
			'message' => 'maps-par-zoom'
		];

		$params['defzoom'] = [
			'type' => 'integer',
			'range' => [ 0, 20 ],
			'default' => self::getDefaultZoom(),
			'message' => 'maps-leaflet-par-defzoom'
		];

		$params['layers'] = [
			'aliases' => 'layer',
			'type' => 'string',
			'values' => array_keys( $GLOBALS['egMapsLeafletAvailableLayers'], true, true ),
			'default' => $GLOBALS['egMapsLeafletLayers'],
			'message' => 'maps-leaflet-par-layers',
			'islist' => true,
		];

		$params['overlaylayers'] = [
			'type' => 'string',
			'values' => array_keys( $GLOBALS['egMapsLeafletAvailableOverlayLayers'], true, true ),
			'default' => $GLOBALS['egMapsLeafletOverlayLayers'],
			'message' => 'maps-leaflet-par-overlaylayers',
			'islist' => true,
		];

		$params['resizable'] = [
			'type' => 'boolean',
			'default' => $GLOBALS['egMapsResizableByDefault'],
			'message' => 'maps-par-resizable'
		];

		$params['enablefullscreen'] = [
			'type' => 'boolean',
			'default' => false,
			'message' => 'maps-par-enable-fullscreen',
		];

		$params['scrollwheelzoom'] = [
			'type' => 'boolean',
			'default' => true,
			'message' => 'maps-par-scrollwheelzoom',
		];

		$params['markercluster'] = [
			'type' => 'boolean',
			'default' => false,
			'message' => 'maps-par-markercluster',
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

		$params['clustermaxradius'] = [
			'type' => 'integer',
			'default' => 80,
			'message' => 'maps-par-maxclusterradius',
		];

		$params['clusterspiderfy'] = [
			'type' => 'boolean',
			'default' => true,
			'message' => 'maps-leaflet-par-clusterspiderfy',
		];
	}

	/**
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
			[ 'ext.maps.leaflet' ]
		);
	}

	protected function getDependencies() {
		$leafletPath = $GLOBALS['wgScriptPath'] . '/extensions/Maps/includes/services/Leaflet/leaflet';

		return [
			Html::linkedStyle( "$leafletPath/leaflet.css" ),
			Html::linkedScript( "$leafletPath/leaflet.js" ),
		];
	}

}
