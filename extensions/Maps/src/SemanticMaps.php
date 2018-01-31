<?php

namespace Maps;

use MapsMappingService;
use MapsMappingServices;
use SMKMLPrinter;
use SMMapPrinter;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SemanticMaps {

	private $mwGlobals;

	private function __construct( array &$mwGlobals ) {
		$this->mwGlobals =& $mwGlobals;
	}

	public static function newFromMediaWikiGlobals( array &$mwGlobals ) {
		return new self( $mwGlobals );
	}

	public function initExtension() {
		// Hook for initializing the Geographical Data types.
		$this->mwGlobals['wgHooks']['SMW::DataType::initTypes'][] = 'SemanticMapsHooks::initGeoDataTypes';

		// Hook for defining the default query printer for queries that ask for geographical coordinates.
		$this->mwGlobals['wgHooks']['SMWResultFormat'][] = 'SemanticMapsHooks::addGeoCoordsDefaultFormat';

		// Hook for adding a Semantic Maps links to the Admin Links extension.
		$this->mwGlobals['wgHooks']['AdminLinks'][] = 'SemanticMapsHooks::addToAdminLinks';

		$this->registerResourceModules();

		$this->registerGoogleMaps();
		$this->registerLeaflet();
		$this->registerOpenLayers();

		$this->mwGlobals['smwgResultFormats']['kml'] = SMKMLPrinter::class;

		$this->mwGlobals['smwgResultAliases'][$this->mwGlobals['egMapsDefaultServices']['qp']][] = 'map';
		SMMapPrinter::registerDefaultService( $this->mwGlobals['egMapsDefaultServices']['qp'] );

		// Internationalization
		$this->mwGlobals['wgMessagesDirs']['SemanticMaps'] = __DIR__ . '/i18n';
	}

	private function registerResourceModules() {
		$moduleTemplate = [
			'position' => 'bottom',
			'group' => 'ext.semanticmaps',
		];

		$this->mwGlobals['wgResourceModules']['ext.sm.common'] = $moduleTemplate + [
				'localBasePath' => __DIR__ . '/../SemanticMaps/src',
				'remoteExtPath' => 'Maps/SemanticMaps/src',
				'scripts' => [
					'ext.sm.common.js'
				]
			];
	}

	private function registerGoogleMaps() {
		$this->mwGlobals['wgResourceModules']['ext.sm.googlemaps3ajax'] = [
			'localBasePath' => __DIR__ . '/../SemanticMaps/src/services/GoogleMaps3',
			'remoteExtPath' => 'Maps/SemanticMaps/src/services/GoogleMaps3',
			'group' => 'ext.semanticmaps',
			'dependencies' => [
				'ext.maps.googlemaps3',
				'ext.sm.common'
			],
			'scripts' => [
				'ext.sm.googlemaps3ajax.js'
			]
		];

		/* @var MapsMappingService $googleMaps */
		$googleMaps = MapsMappingServices::getServiceInstance( 'googlemaps3' );
		$googleMaps->addResourceModules( [ 'ext.sm.googlemaps3ajax' ] );

		SMMapPrinter::registerService( $googleMaps );

		$this->mwGlobals['smwgResultFormats'][$googleMaps->getName()] = SMMapPrinter::class;
		$this->mwGlobals['smwgResultAliases'][$googleMaps->getName()] = $googleMaps->getAliases();
	}

	private function registerLeaflet() {
		$this->mwGlobals['wgResourceModules']['ext.sm.fi.leafletajax'] = [
			'localBasePath' => __DIR__ . '/../SemanticMaps/src/services/Leaflet',
			'remoteExtPath' => 'Maps/SemanticMaps/src/services/Leaflet',
			'group' => 'ext.semanticmaps',
			'dependencies' => [
				'ext.maps.leaflet',
				'ext.sm.common'
			],
			'scripts' => [
				'ext.sm.leafletajax.js'
			]
		];

		/* @var MapsMappingService $leaflet */
		$leaflet = MapsMappingServices::getServiceInstance( 'leaflet' );
		$leaflet->addResourceModules( [ 'ext.sm.fi.leafletajax' ] );

		SMMapPrinter::registerService( $leaflet );

		$this->mwGlobals['smwgResultFormats'][$leaflet->getName()] = SMMapPrinter::class;
		$this->mwGlobals['smwgResultAliases'][$leaflet->getName()] = $leaflet->getAliases();
	}

	private function registerOpenLayers() {
		$this->mwGlobals['wgResourceModules']['ext.sm.fi.openlayersajax'] = [
			'localBasePath' => __DIR__ . '/../SemanticMaps/src/services/OpenLayers',
			'remoteExtPath' => 'Maps/SemanticMaps/src/services/OpenLayers',
			'group' => 'ext.semanticmaps',
			'dependencies' => [
				'ext.maps.openlayers',
				'ext.sm.common'
			],
			'scripts' => [
				'ext.sm.openlayersajax.js'
			]
		];

		/* @var MapsMappingService $openLayers */
		$openLayers = MapsMappingServices::getServiceInstance( 'openlayers' );
		$openLayers->addResourceModules( [ 'ext.sm.fi.openlayersajax' ] );

		SMMapPrinter::registerService( $openLayers );

		$this->mwGlobals['smwgResultFormats'][$openLayers->getName()] = SMMapPrinter::class;
		$this->mwGlobals['smwgResultAliases'][$openLayers->getName()] = $openLayers->getAliases();
	}

}
