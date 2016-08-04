<?php
use Maps\Element;
use Maps\Elements\Line;
use Maps\Elements\Location;

/**
 * Class handling the #display_map rendering.
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Kim Eik
 */
class MapsDisplayMapRenderer {

	/**
	 * @since 2.0
	 *
	 * @var iMappingService
	 */
	protected $service;

	/**
	 * Constructor.
	 *
	 * @param iMappingService $service
	 */
	public function __construct( iMappingService $service ) {
		$this->service = $service;
	}

	/**
	 * Returns the HTML to display the map.
	 *
	 * @since 2.0
	 *
	 * @param array $params
	 * @param Parser $parser
	 * @param string $mapName
	 *
	 * @return string
	 */
	protected function getMapHTML( array $params, Parser $parser, $mapName ) {
		return Html::rawElement(
			'div',
			array(
				'id' => $mapName,
				'style' => "width: {$params['width']}; height: {$params['height']}; background-color: #cccccc; overflow: hidden;",
				'class' => 'maps-map maps-' . $this->service->getName()
			),
			wfMessage( 'maps-loading-map' )->inContentLanguage()->escaped() .
				Html::element(
					'div',
					array( 'style' => 'display:none', 'class' => 'mapdata' ),
					FormatJson::encode( $this->getJSONObject( $params, $parser ) )
				)
		);
	}

	/**
	 * Returns a PHP object to encode to JSON with the map data.
	 *
	 * @since 2.0
	 *
	 * @param array $params
	 * @param Parser $parser
	 *
	 * @return mixed
	 */
	protected function getJSONObject( array $params, Parser $parser ) {
		return $params;
	}

	/**
	 * Handles the request from the parser hook by doing the work that's common for all
	 * mapping services, calling the specific methods and finally returning the resulting output.
	 *
	 * @param array $params
	 * @param Parser $parser
	 *
	 * @return string
	 */
	public final function renderMap( array $params, Parser $parser ) {
		$this->handleMarkerData( $params, $parser );

		$mapName = $this->service->getMapId();

		$output = $this->getMapHTML( $params, $parser, $mapName );

		$configVars = Skin::makeVariablesScript( $this->service->getConfigVariables() );

		$this->service->addDependencies( $parser );
		$parser->getOutput()->addHeadItem( $configVars );

		return $output;
	}

	/**
	 * Converts the data in the coordinates parameter to JSON-ready objects.
	 * These get stored in the locations parameter, and the coordinates on gets deleted.
	 *
	 * FIXME: complexity
	 *
	 * @since 1.0
	 *
	 * @param array &$params
	 * @param Parser $parser
	 */
	protected function handleMarkerData( array &$params, Parser $parser ) {
		if ( is_object( $params['centre'] ) ) {
			$params['centre'] = $params['centre']->getJSONObject();
		}

		$parserClone = clone $parser;

		if ( is_object( $params['wmsoverlay'] ) ) {
			$params['wmsoverlay'] = $params['wmsoverlay']->getJSONObject();
		}

		$iconUrl = MapsMapper::getFileUrl( $params['icon'] );
		$visitedIconUrl = MapsMapper::getFileUrl( $params['visitedicon'] );
		$params['locations'] = array();

		/**
		 * @var Location $location
		 */
		foreach ( $params['coordinates'] as $location ) {
			$jsonObj = $location->getJSONObject( $params['title'], $params['label'], $iconUrl, '', '',$visitedIconUrl);

			$jsonObj['title'] = $parserClone->parse( $jsonObj['title'], $parserClone->getTitle(), new ParserOptions() )->getText();
			$jsonObj['text'] = $parserClone->parse( $jsonObj['text'], $parserClone->getTitle(), new ParserOptions() )->getText();
			$jsonObj['inlineLabel'] = strip_tags($parserClone->parse( $jsonObj['inlineLabel'], $parserClone->getTitle(), new ParserOptions() )->getText(),'<a><img>');

			$hasTitleAndtext = $jsonObj['title'] !== '' && $jsonObj['text'] !== '';
			$jsonObj['text'] = ( $hasTitleAndtext ? '<b>' . $jsonObj['title'] . '</b><hr />' : $jsonObj['title'] ) . $jsonObj['text'];
			$jsonObj['title'] = strip_tags( $jsonObj['title'] );

			$params['locations'][] = $jsonObj;
		}

		unset( $params['coordinates'] );

		$this->handleShapeData( $params, $parserClone );

		if ( $params['mappingservice'] === 'openlayers' ) {
			$params['layers'] = self::evilOpenLayersHack( $params['layers'] );
		}
	}

	protected function handleShapeData( array &$params, Parser $parserClone ) {
		$textContainers = array(
			&$params['lines'] ,
			&$params['polygons'] ,
			&$params['circles'] ,
			&$params['rectangles'],
			&$params['imageoverlays'], // FIXME: this is Google Maps specific!!
		);

		foreach ( $textContainers as &$textContainer ) {
			if ( is_array( $textContainer ) ) {
				foreach ( $textContainer as &$obj ) {
					if ( $obj instanceof Element ) {
						$obj = $obj->getArrayValue();
					}

					$obj['title'] = $parserClone->parse( $obj['title'] , $parserClone->getTitle() , new ParserOptions() )->getText();
					$obj['text'] = $parserClone->parse( $obj['text'] , $parserClone->getTitle() , new ParserOptions() )->getText();

					$hasTitleAndtext = $obj['title'] !== '' && $obj['text'] !== '';
					$obj['text'] = ( $hasTitleAndtext ? '<b>' . $obj['title'] . '</b><hr />' : $obj['title'] ) . $obj['text'];
					$obj['title'] = strip_tags( $obj['title'] );
				}
			}
		}
	}

	/**
	 * FIXME
	 *
	 * Temporary hack until the mapping service handling gets a proper refactor
	 * This kind of JS construction is also rather evil and should not be done at this point
	 *
	 * @since 3.0
	 * @deprecated
	 *
	 * @param string[] $layers
	 *
	 * @return string[]
	 */
	public static function evilOpenLayersHack( $layers ) {
		global $egMapsOLLayerGroups, $egMapsOLAvailableLayers;

		$layerDefs = array();
		$layerNames = array();

		foreach ( $layers as $layerOrGroup ) {
			$lcLayerOrGroup = strtolower( $layerOrGroup );

			// Layer groups. Loop over all items and add them if not present yet:
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
			// Single layers. Add them if not present yet:
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
			// Image layers. Check validity and add if not present yet:
			else {
				$layerParts = explode( ';', $layerOrGroup, 2 );
				$layerGroup = $layerParts[0];
				$layerName = count( $layerParts ) > 1 ? $layerParts[1] : null;

				$title = Title::newFromText( $layerGroup, Maps_NS_LAYER );

				if ( $title !== null && $title->getNamespace() == Maps_NS_LAYER ) {
					// TODO: FIXME: This shouldn't be here and using $wgParser, instead it should
					//  be somewhere around MapsBaseMap::renderMap. But since we do a lot more than
					//  'parameter manipulation' in here, we already diminish the information needed
					//  for this which will never arrive there.
					global $wgParser;
					// add dependency to the layer page so if the layer definition gets updated,
					// the page where it is used will be updated as well:
					$rev = Revision::newFromTitle( $title );
					$revId = null;
					if( $rev !== null ) {
						$revId = $rev->getId();
					}
					$wgParser->getOutput()->addTemplate( $title, $title->getArticleID(), $revId );

					// if the whole layer group is not yet loaded into the map and the group exists:
					if( !in_array( $layerGroup, $layerNames )
						&& $title->exists()
					) {
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
									|| !in_array( $layerGroup . ';' . $layer->getName(), $layerNames )
								)
								&& $layer->isOk()
							) {
								$layerDefs[] = $layer->getJavaScriptDefinition();
							}
						}

						$layerNames[] = $usedLayer; // have to add this after loop of course!
					}
				}
				else {
					wfWarn( "Invalid layer ($layerOrGroup) encountered after validation." );
				}
			}
		}

		MapsMappingServices::getServiceInstance( 'openlayers' )->addLayerDependencies( self::getLayerDependencies( $layerNames ) );

//		print_r( $layerDefs );
//		die();
		return $layerDefs;
	}

	/**
	 * FIXME
	 * @see evilOpenLayersHack
	 */
	private static function getLayerDependencies( array $layerNames ) {
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
