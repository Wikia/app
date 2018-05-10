<?php

use Maps\Element;
use Maps\Elements\Location;
use Maps\LocationParser;

/**
 * Class handling the #display_map rendering.
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Kim Eik
 */
class MapsDisplayMapRenderer {

	private $service;

	/**
	 * @var LocationParser
	 */
	private $locationParser;

	public function __construct( MapsMappingService $service ) {
		$this->service = $service;
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
		$this->initializeLocationParser();

		$this->handleMarkerData( $params, $parser );

		$mapName = $this->service->getMapId();

		$output = $this->getMapHTML( $params, $mapName );

		$configVars = Skin::makeVariablesScript( $this->service->getConfigVariables() );

		$this->service->addHtmlDependencies(
			self::getLayerDependencies( $params['mappingservice'], $params )
		);

		$parserOutput = $parser->getOutput();
		$parserOutput->addHeadItem( $configVars );

		// Wikia change - defer adding service html dependencies
		// They will be handled in OutputPageParserOutput hook handler

		$parserOutput->addModules( $this->service->getResourceModules() );

		$parserOutput->mapsMappingServices = $parserOutput->mapsMappingServices ?? [];

		$serviceName = $this->service->getName();

		$parserOutput->mapsMappingServices[$serviceName] = $this->service;

		// end Wikia change

		return $output;
	}

	private function initializeLocationParser() {
		$this->locationParser = \Maps\MapsFactory::newDefault()->newLocationParser();
	}

	/**
	 * Converts the data in the coordinates parameter to JSON-ready objects.
	 * These get stored in the locations parameter, and the coordinates on gets deleted.
	 */
	private function handleMarkerData( array &$params, Parser $parser ) {
		$params['centre'] = $this->getCenter( $params['centre'] );

		$parserClone = clone $parser;

		if ( is_object( $params['wmsoverlay'] ) ) {
			$params['wmsoverlay'] = $params['wmsoverlay']->getJSONObject();
		}

		$params['locations'] = $this->getLocationJson( $params, $parserClone );

		unset( $params['coordinates'] );

		$this->handleShapeData( $params, $parserClone );

		if ( $params['mappingservice'] === 'openlayers' ) {
			$params['layers'] = self::evilOpenLayersHack( $params['layers'] );
		}
	}

	private function getCenter( $coordinatesOrAddress ) {
		if ( $coordinatesOrAddress === false ) {
			return false;
		}

		try {
			// FIXME: a Location makes no sense here, since the non-coordinate data is not used
			$location = $this->locationParser->parse( $coordinatesOrAddress );
		}
		catch ( \Exception $ex ) {
			// TODO: somehow report this to the user
			return false;
		}

		return $location->getJSONObject();
	}

	private function getLocationJson( array $params, $parserClone ) {
		$iconUrl = MapsMapper::getFileUrl( $params['icon'] );
		$visitedIconUrl = MapsMapper::getFileUrl( $params['visitedicon'] );

		$locationJsonObjects = [];

		foreach ( $params['coordinates'] as $coordinatesOrAddress ) {
			try {
				$location = $this->locationParser->parse( $coordinatesOrAddress );
			}
			catch ( \Exception $ex ) {
				// TODO: somehow report this to the user
				continue;
			}

			$locationJsonObjects[] = $this->getLocationJsonObject(
				$location,
				$params,
				$iconUrl,
				$visitedIconUrl,
				$parserClone
			);
		}

		return $locationJsonObjects;
	}

	private function getLocationJsonObject( Location $location, array $params, $iconUrl, $visitedIconUrl, Parser $parserClone ) {
		$jsonObj = $location->getJSONObject( $params['title'], $params['label'], $iconUrl, '', '', $visitedIconUrl );

		$jsonObj['title'] = $parserClone->parse(
			$jsonObj['title'],
			$parserClone->getTitle(),
			new ParserOptions()
		)->getText();
		$jsonObj['text'] = $parserClone->parse(
			$jsonObj['text'],
			$parserClone->getTitle(),
			new ParserOptions()
		)->getText();

		if ( isset( $jsonObj['inlineLabel'] ) ) {
			$jsonObj['inlineLabel'] = strip_tags(
				$parserClone->parse( $jsonObj['inlineLabel'], $parserClone->getTitle(), new ParserOptions() )->getText(
				),
				'<a><img>'
			);
		}

		$hasTitleAndtext = $jsonObj['title'] !== '' && $jsonObj['text'] !== '';
		$jsonObj['text'] = ( $hasTitleAndtext ? '<b>' . $jsonObj['title'] . '</b><hr />' : $jsonObj['title'] ) . $jsonObj['text'];
		$jsonObj['title'] = strip_tags( $jsonObj['title'] );

		return $jsonObj;
	}

	private function handleShapeData( array &$params, Parser $parserClone ) {
		$textContainers = [
			&$params['lines'],
			&$params['polygons'],
			&$params['circles'],
			&$params['rectangles'],
			&$params['imageoverlays'], // FIXME: this is Google Maps specific!!
		];

		foreach ( $textContainers as &$textContainer ) {
			if ( is_array( $textContainer ) ) {
				foreach ( $textContainer as &$obj ) {
					if ( $obj instanceof Element ) {
						$obj = $obj->getArrayValue();
					}

					$obj['title'] = $parserClone->parse(
						$obj['title'],
						$parserClone->getTitle(),
						new ParserOptions()
					)->getText();
					$obj['text'] = $parserClone->parse(
						$obj['text'],
						$parserClone->getTitle(),
						new ParserOptions()
					)->getText();

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

		$layerDefs = [];
		$layerNames = [];

		foreach ( $layers as $layerOrGroup ) {
			$lcLayerOrGroup = strtolower( $layerOrGroup );

			// Layer groups. Loop over all items and add them if not present yet:
			if ( array_key_exists( $lcLayerOrGroup, $egMapsOLLayerGroups ) ) {
				foreach ( $egMapsOLLayerGroups[$lcLayerOrGroup] as $layerName ) {
					if ( !in_array( $layerName, $layerNames ) ) {
						if ( is_array( $egMapsOLAvailableLayers[$layerName] ) ) {
							$layerDefs[] = 'new ' . $egMapsOLAvailableLayers[$layerName][0];
						} else {
							$layerDefs[] = 'new ' . $egMapsOLAvailableLayers[$layerName];
						}
						$layerNames[] = $layerName;
					}
				}
			} // Single layers. Add them if not present yet:
			elseif ( array_key_exists( $lcLayerOrGroup, $egMapsOLAvailableLayers ) ) {
				if ( !in_array( $lcLayerOrGroup, $layerNames ) ) {
					if ( is_array( $egMapsOLAvailableLayers[$lcLayerOrGroup] ) ) {
						$layerDefs[] = 'new ' . $egMapsOLAvailableLayers[$lcLayerOrGroup][0];
					} else {
						$layerDefs[] = 'new ' . $egMapsOLAvailableLayers[$lcLayerOrGroup];
					}

					$layerNames[] = $lcLayerOrGroup;
				}
			}
		}
		return $layerDefs;
	}

	/**
	 * Returns the HTML to display the map.
	 *
	 * @param array $params
	 * @param string $mapName
	 *
	 * @return string
	 */
	protected function getMapHTML( array $params, $mapName ) {
		return Html::rawElement(
			'div',
			[
				'id' => $mapName,
				'style' => "width: {$params['width']}; height: {$params['height']}; background-color: #cccccc; overflow: hidden;",
				'class' => 'maps-map maps-' . $this->service->getName()
			],
			wfMessage( 'maps-loading-map' )->inContentLanguage()->escaped() .
			Html::element(
				'div',
				[ 'style' => 'display:none', 'class' => 'mapdata' ],
				FormatJson::encode( $params )
			)
		);
	}

	public static function getLayerDependencies( $service, $params ) {
		global $egMapsOLLayerDependencies, $egMapsOLAvailableLayers,
			   $egMapsLeafletLayerDependencies, $egMapsLeafletAvailableLayers,
			   $egMapsLeafletLayersApiKeys;

		$layerDependencies = [];

		if ( $service === 'leaflet' ) {
			$layerNames = $params['layers'];
			foreach ( $layerNames as $layerName ) {
				if ( array_key_exists( $layerName, $egMapsLeafletAvailableLayers )
					&& $egMapsLeafletAvailableLayers[$layerName]
					&& array_key_exists( $layerName, $egMapsLeafletLayersApiKeys )
					&& array_key_exists( $layerName, $egMapsLeafletLayerDependencies ) ) {
					$layerDependencies[] = '<script src="' . $egMapsLeafletLayerDependencies[$layerName] .
						$egMapsLeafletLayersApiKeys[$layerName] . '"></script>';
				}
			}
		} else {
			if ( $service === 'openlayers' ) {
				$layerNames = $params['layers'];
				foreach ( $layerNames as $layerName ) {
					if ( array_key_exists( $layerName, $egMapsOLAvailableLayers ) // The layer must be defined in php
						&& is_array( $egMapsOLAvailableLayers[$layerName] ) // The layer must be an array...
						&& count( $egMapsOLAvailableLayers[$layerName] ) > 1 // ...with a second element...
						&& array_key_exists(
							$egMapsOLAvailableLayers[$layerName][1],
							$egMapsOLLayerDependencies
						) ) { //...that is a dependency.
						$layerDependencies[] = $egMapsOLLayerDependencies[$egMapsOLAvailableLayers[$layerName][1]];
					}
				}

			}
		}

		return array_unique( $layerDependencies );
	}

}
