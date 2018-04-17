<?php

/**
 * Class holding information and functionality specific to OpenLayers.
 * This information and features can be used by any mapping feature.
 *
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsOpenLayers extends MapsMappingService {

	public function __construct( $serviceName ) {
		parent::__construct(
			$serviceName,
			[ 'layers', 'openlayer' ]
		);
	}

	/**
	 * Returns the names of all supported dynamic layers.
	 *
	 * @param boolean $includeGroups
	 *
	 * @return array
	 */
	public static function getLayerNames( $includeGroups = false ) {
		global $egMapsOLAvailableLayers, $egMapsOLLayerGroups;

		$keys = array_keys( $egMapsOLAvailableLayers );

		if ( $includeGroups ) {
			$keys = array_merge( $keys, array_keys( $egMapsOLLayerGroups ) );
		}

		return $keys;
	}

	/**
	 * @see MapsMappingService::addParameterInfo
	 */
	public function addParameterInfo( array &$params ) {
		global $egMapsOLLayers, $egMapsOLControls, $egMapsResizableByDefault;

		$params['zoom'] = [
			'type' => 'integer',
			'range' => [ 0, 19 ],
			'default' => self::getDefaultZoom(),
			'message' => 'maps-par-zoom',
		];

		$params['controls'] = [
			'default' => $egMapsOLControls,
			'values' => self::getControlNames(),
			'message' => 'maps-openlayers-par-controls',
			'islist' => true,
			'tolower' => true,
		];

		$params['layers'] = [
			'default' => $egMapsOLLayers,
			'message' => 'maps-openlayers-par-layers',
			'manipulatedefault' => true,
			'islist' => true,
			'tolower' => true,
			// TODO-customMaps: addCriteria( new CriterionOLLayer() );
		];

		$params['resizable'] = [
			'type' => 'boolean',
			'default' => false,
			'manipulatedefault' => false,
			'message' => 'maps-par-resizable',
		];

		$params['overlays'] = [
			// Default empty array will end up in JS just right without manipulation.
			'default' => [],
			'manipulatedefault' => false,
			'message' => 'maps-openlayers-par-overlays',

			// NOTE: code has moved into @see MapsDisplayMapRenderer
			// TODO-customMaps: addCriteria( new CriterionOLLayer( ';' ) );
			// TODO-customMaps: addManipulations( new MapsParamOLLayers() );
		];

		$params['resizable'] = [
			'type' => 'boolean',
			'default' => $egMapsResizableByDefault,
			'message' => 'maps-par-resizable',
		];

		$params['searchmarkers'] = [
			'default' => '',
			'message' => 'maps-par-searchmarkers',
			'values' => [ 'title', 'all', '' ],
			'tolower' => true,
		];

		$params['kml'] = [
			'default' => [],
			'message' => 'maps-par-kml',
			'islist' => true,
			// new MapsParamFile() FIXME
		];
	}

	/**
	 * @since 0.6.5
	 */
	public function getDefaultZoom() {
		global $egMapsOpenLayersZoom;
		return $egMapsOpenLayersZoom;
	}

	/**
	 * Returns the names of all supported controls.
	 * This data is a copy of the one used to actually translate the names
	 * into the controls, since this resides client side, in OpenLayerFunctions.js.
	 *
	 * @return array
	 */
	public static function getControlNames() {
		return [
			'argparser',
			'attribution',
			'button',
			'dragfeature',
			'dragpan',
			'drawfeature',
			'editingtoolbar',
			'getfeature',
			'keyboarddefaults',
			'layerswitcher',
			'measure',
			'modifyfeature',
			'mousedefaults',
			'mouseposition',
			'mousetoolbar',
			'navigation',
			'navigationhistory',
			'navtoolbar',
			'overviewmap',
			'pan',
			'panel',
			'panpanel',
			'panzoom',
			'panzoombar',
			'autopanzoom',
			'permalink',
			'scale',
			'scaleline',
			'selectfeature',
			'snapping',
			'split',
			'wmsgetfeatureinfo',
			'zoombox',
			'zoomin',
			'zoomout',
			'zoompanel',
			'zoomtomaxextent'
		];
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

		return 'open_layer_' . $mapsOnThisPage;
	}

	/**
	 * @see MapsMappingService::getResourceModules
	 *
	 * @since 0.7.3
	 *
	 * @return array of string
	 */
	public function getResourceModules() {
		return array_merge(
			parent::getResourceModules(),
			[ 'ext.maps.openlayers' ]
		);
	}

	/**
	 * Returns a list of all config variables that should be passed to the JS.
	 *
	 * @since 1.0.1
	 *
	 * @return array
	 */
	public function getConfigVariables() {
		return array_merge(
			parent::getConfigVariables(),
			[ 'egMapsScriptPath' => $GLOBALS['wgScriptPath'] . '/extensions/Maps/' ]
		);
	}

}
