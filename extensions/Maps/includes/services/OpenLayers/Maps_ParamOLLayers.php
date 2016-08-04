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
 * @author Daniel Werner
 */
class MapsParamOLLayers extends ListParameterManipulation {
	
	/**
	 * @since 3.0
	 *
	 * @var string
	 */
	protected $groupNameSep;

	/**
	 * Constructor.
	 *
	 * @param string $groupNameSeparator Separator between layer group and the
	 *        layers name within the group.
	 *
	 * @since 0.7
	 */
	public function __construct( $groupNameSeparator = ';' ) {
		parent::__construct();
		$this->groupNameSep = $groupNameSeparator;
	}
	
	/**
	 * @see ParameterManipulation::manipulate
	 *
	 * @since 0.7
	 */
	public function manipulate( Parameter &$parameter, array &$parameters ) {
		global $egMapsOLLayerGroups, $egMapsOLAvailableLayers;
		
		$layerDefs = array();
		$usedLayers = array();
		
		foreach ( $parameter->getValue() as $layerOrGroup ) {
			$lcLayerOrGroup = strtolower( $layerOrGroup );
			
			// Layer groups. Loop over all items and add them if not present yet.
			if ( array_key_exists( $lcLayerOrGroup, $egMapsOLLayerGroups ) ) {
				foreach ( $egMapsOLLayerGroups[$lcLayerOrGroup] as $layerName ) {
					if ( !in_array( $layerName, $usedLayers ) ) {
						if ( is_array( $egMapsOLAvailableLayers[$layerName] ) ) {
							$layerDefs[] = 'new ' . $egMapsOLAvailableLayers[$layerName][0];
						}
						else {
							$layerDefs[] = 'new ' . $egMapsOLAvailableLayers[$layerName];
						}
						$usedLayers[] = $layerName;
					}
				}
			}
			// Single layers. Add them if not present yet.
			elseif ( array_key_exists( $lcLayerOrGroup, $egMapsOLAvailableLayers ) ) {
				if ( !in_array( $lcLayerOrGroup, $usedLayers ) ) {
					if ( is_array( $egMapsOLAvailableLayers[$lcLayerOrGroup] ) ) {
						$layerDefs[] = 'new ' . $egMapsOLAvailableLayers[$lcLayerOrGroup][0];
					}
					else {
						$layerDefs[] = 'new ' . $egMapsOLAvailableLayers[$lcLayerOrGroup];
					}
					
					$usedLayers[] = $lcLayerOrGroup;
				}
			}
			// Image layers. Check validity and add if not present yet.
			else {
				$layerParts = explode( $this->groupNameSep, $layerOrGroup, 2 );
				$layerGroup = $layerParts[0];
				$layerName = count( $layerParts ) > 1 ? $layerParts[1] : null;

				$title = Title::newFromText( $layerGroup, Maps_NS_LAYER );

				if ( $title !== null && $title->getNamespace() == Maps_NS_LAYER ) {
					/**
					 * TODO/FIXME: This shouldn't be here and using $wgParser, instead it should
					 * be somewhere around MapsBaseMap::renderMap. But since we do a lot more than
					 * 'parameter manipulation' in here, we already diminish the information needed
					 * for this which will never arrive there. Perhaps the whole
					 * MapsLayer::getJavaScriptDefinition() shouldn't be done here.
					 */
					global $wgParser;
					// add dependency to the layer page so if the layer definition gets updated,
					// the page where it is used will be updated as well:
					$rev = Revision::newFromTitle( $title );
					$wgParser->getOutput()->addTemplate( $title, $title->getArticleID(), $rev->getId() );

					// if the whole layer group is not yet loaded into the map and the group exists:
					if( ! in_array( $layerGroup, $usedLayers )
						&& $title->exists()
					) {
						$layerPage = new MapsLayerPage( $title );

						if( $layerName !== null ) {
							// load specific layer with name:
							$layer = MapsLayers::loadLayer( $title, $layerName );
							$layers = new MapsLayerGroup( $layer );
							$usedLayer = $layerOrGroup;
						}
						else {
							// load all layers from group:
							$layers = MapsLayers::loadLayerGroup( $title );
							$usedLayer = $layerGroup;
						}

						foreach( $layers->getLayers() as $layer ) {
							if( ( // make sure named layer is only taken once (in case it was requested on its own before)
								$layer->getName() === null
									|| ! in_array( $layerGroup . $this->groupNameSep . $layer->getName(), $usedLayers )
							)
								&& $layer->isOk()
							) {
								$layerDefs[] = $layer->getJavaScriptDefinition();
							}
						}
						$usedLayers[] = $usedLayer; // have to add this after loop of course!
					}
				}
				else {
					wfWarn( "Invalid layer ($layerOrGroup) encountered after validation." );
				}
			}
		}
		
		$parameter->setValue( $layerDefs );
		
		MapsMappingServices::getServiceInstance( 'openlayers' )->addLayerDependencies( $this->getDependencies( $usedLayers ) );
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
