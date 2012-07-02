<?php

/**
 * Class holding information and functionallity specific to OpenLayers.
 * This infomation and features can be used by any mapping feature. 
 * 
 * @since 0.1
 * 
 * @file Maps_OpenLayers.php
 * @ingroup MapsOpenLayers
 * 
 * @author Jeroen De Dauw
 */
class MapsOpenLayers extends MapsMappingService {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.6.6
	 */	
	function __construct( $serviceName ) {
		parent::__construct(
			$serviceName,
			array( 'layers', 'openlayer' )
		);
	}	
	
	/**
	 * @see MapsMappingService::addParameterInfo
	 * 
	 * @since 0.7
	 */	
	public function addParameterInfo( array &$params ) {
		global $egMapsOLLayers, $egMapsOLControls, $egMapsResizableByDefault;
		
		$params['zoom']->addCriteria( new CriterionInRange( 0, 19 ) );
		$params['zoom']->setDefault( self::getDefaultZoom() );		
		
		$params['controls'] = new ListParameter( 'controls' );
		$params['controls']->setDefault( $egMapsOLControls );
		$params['controls']->addCriteria( new CriterionInArray( self::getControlNames() ) );
		$params['controls']->addManipulations(
			new ParamManipulationFunctions( 'strtolower' )
		);
		$params['controls']->setMessage( 'maps-openlayers-par-controls' );
		
		$params['layers'] = new ListParameter( 'layers' );
		$params['layers']->addManipulations( new MapsParamOLLayers() );
		$params['layers']->setDoManipulationOfDefault( true );
		$params['layers']->addCriteria( new CriterionOLLayer() );
		$params['layers']->setDefault( $egMapsOLLayers );
		$params['layers']->setMessage( 'maps-openlayers-par-layers' );
		
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
		global $egMapsOpenLayersZoom;
		return $egMapsOpenLayersZoom;
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
	 * Returns the names of all supported controls. 
	 * This data is a copy of the one used to actually translate the names
	 * into the controls, since this resides client side, in OpenLayerFunctions.js. 
	 * 
	 * @return array
	 */
	public static function getControlNames() {
		return array(
			'argparser', 'attribution', 'button', 'dragfeature', 'dragpan',
			'drawfeature', 'editingtoolbar', 'getfeature', 'keyboarddefaults', 'layerswitcher',
			'measure', 'modifyfeature', 'mousedefaults', 'mouseposition', 'mousetoolbar',
			'navigation', 'navigationhistory', 'navtoolbar', 'overviewmap', 'pan',
			'panel', 'panpanel', 'panzoom', 'panzoombar', 'autopanzoom', 'permalink',
			'scale', 'scaleline', 'selectfeature', 'snapping', 'split',
			'wmsgetfeatureinfo', 'zoombox', 'zoomin', 'zoomout', 'zoompanel',
			'zoomtomaxextent'
		);
	}

	/**
	 * Returns the names of all supported dynamic layers.
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
	 * Adds the layer dependencies. 
	 * 
	 * @since 0.7.1
	 * 
	 * @param array $dependencies
	 */
	public function addLayerDependencies( array $dependencies ) {
		foreach ( $dependencies as $dependency ) {
			$this->addDependency( $dependency );
		}
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
			array( 'ext.maps.openlayers' )
		);
	}
	
}
