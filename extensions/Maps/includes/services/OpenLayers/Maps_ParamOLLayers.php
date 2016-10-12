<?php

/**
 * Parameter manipulation ensuring the value is 
 * 
 * @since 0.7
 * 
 * @file Maps_ParamOLLayers.php
 * @ingroup Maps
 * @ingroup ParameterManipulations
 * @ingroup MapsOpenLayers
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsParamOLLayers extends ListParameterManipulation {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.7
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @see ParameterManipulation::manipulate
	 * 
	 * @since 0.7
	 */	
	public function manipulate( Parameter &$parameter, array &$parameters ) {
		global $egMapsOLLayerGroups, $egMapsOLAvailableLayers;
		
		$layerDefs = array();
		$layerNames = array();
		
		foreach ( $parameter->getValue() as $layerOrGroup ) {
			$lcLayerOrGroup = strtolower( $layerOrGroup );
			
			// Layer groups. Loop over all items and add them when not present yet.
			if ( array_key_exists( $lcLayerOrGroup, $egMapsOLLayerGroups ) ) {
				foreach ( $egMapsOLLayerGroups[$lcLayerOrGroup] as $layerName ) {
					if ( !in_array( $layerName, $layerNames ) ) {
						if ( is_array( $egMapsOLAvailableLayers[$layerName] ) ) {
							$layerDefs[] = 'new ' . $egMapsOLAvailableLayers[$layerName][0];
						}
						else {
							$layerDefs[] = 'new ' . $egMapsOLAvailableLayers[$layerName];
						}
						$layerNames[] = $layerName;
					}
				}
			}
			// Single layers. Add them when not present yet.
			elseif ( array_key_exists( $lcLayerOrGroup, $egMapsOLAvailableLayers ) ) {
				if ( !in_array( $lcLayerOrGroup, $layerNames ) ) {
					if ( is_array( $egMapsOLAvailableLayers[$lcLayerOrGroup] ) ) {
						$layerDefs[] = 'new ' . $egMapsOLAvailableLayers[$lcLayerOrGroup][0];
					}
					else {
						$layerDefs[] = 'new ' . $egMapsOLAvailableLayers[$lcLayerOrGroup];
					}
					
					$layerNames[] = $lcLayerOrGroup;
				}
			}
			// Image layers. Check validity and add when not present yet.
			else {
				$title = Title::newFromText( $layerOrGroup, Maps_NS_LAYER );
				
				if ( $title->getNamespace() == Maps_NS_LAYER && $title->exists() ) {
					$layerPage = new MapsLayerPage( $title );
					
					if ( $layerPage->hasValidDefinition( 'openlayers' ) ) {
						$layer = $layerPage->getLayer();
						if ( !in_array( $layerOrGroup, $layerNames ) ) {
							$layerDefs[] = $layer->getJavaScriptDefinition();
							$layerNames[] = $layerOrGroup;							
						}
					}
					else {
						wfWarn( "Invalid layer ($layerOrGroup) encountered after validation." );
					}
				}
				else {
					wfWarn( "Invalid layer ($layerOrGroup) encountered after validation." );
				}
			}
		}
		
		$parameter->setValue( $layerDefs );
		
		MapsMappingServices::getServiceInstance( 'openlayers' )->addLayerDependencies( $this->getDependencies( $layerNames ) );
	}
	
	/**
	 * Returns the depencies for the provided layers.
	 * 
	 * @since 0.7.1
	 * 
	 * @param array $layerNames
	 * 
	 * @return array
	 */
	protected function getDependencies( array $layerNames ) {
		global $egMapsOLLayerDependencies, $egMapsOLAvailableLayers;
		
		$layerDependencies = array();
		
		foreach ( $layerNames as $layerName ) {
			if ( array_key_exists( $layerName, $egMapsOLAvailableLayers ) // The layer must be defined in php
				&& is_array( $egMapsOLAvailableLayers[$layerName] ) // The layer must be an array...
				&& count( $egMapsOLAvailableLayers[$layerName] ) > 1 // ...with a second element...
				&& array_key_exists( $egMapsOLAvailableLayers[$layerName][1], $egMapsOLLayerDependencies ) ) { //...that is a dependency.
				$layerDependencies[] = $egMapsOLLayerDependencies[$egMapsOLAvailableLayers[$layerName][1]];
			}
		}

		return array_unique( $layerDependencies );
	}
	
}