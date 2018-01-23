<?php

use Maps\Element;
use Maps\Elements\BaseElement;
use Maps\Elements\Location;
use Maps\LocationParser;
use ParamProcessor\ParamDefinition;

/**
 * Query printer for maps. Is invoked via SMMapper.
 * Can be overridden per service to have custom output.
 *
 * @ingroup SemanticMaps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Peter Grassberger < petertheone@gmail.com >
 */
class SMMapPrinter extends SMW\ResultPrinter {

	private static $services = [];

	/**
	 * @var LocationParser
	 */
	private $locationParser;
	/**
	 * @var MapsMappingService
	 */
	private $service;
	/**
	 * @var string|boolean
	 */
	private $fatalErrorMsg = false;

	/**
	 * @param string $format
	 * @param bool $inline
	 */
	public function __construct( $format, $inline = true ) {
		$this->service = self::$services[$format];

		parent::__construct( $format, $inline );
	}

	/**
	 * @since 3.4
	 * FIXME: this is a temporary hack that should be replaced when SMW allows for dependency
	 * injection in query printers.
	 *
	 * @param MapsMappingService $service
	 */
	public static function registerService( MapsMappingService $service ) {
		self::$services[$service->getName()] = $service;
	}

	public static function registerDefaultService( $serviceName ) {
		self::$services['map'] = self::$services[$serviceName];
	}

	/**
	 * Builds up and returns the HTML for the map, with the queried coordinate data on it.
	 *
	 * @param SMWQueryResult $res
	 * @param $outputmode
	 *
	 * @return string
	 */
	public final function getResultText( SMWQueryResult $res, $outputmode ) {
		if ( $this->fatalErrorMsg !== false ) {
			return $this->fatalErrorMsg;
		}

		$this->addTrackingCategoryIfNeeded();

		$params = $this->params;

		$this->initializeLocationParser();

		$queryHandler = new SMQueryHandler( $res, $outputmode );
		$queryHandler->setLinkStyle( $params['link'] );
		$queryHandler->setHeaderStyle( $params['headers'] );
		$queryHandler->setShowSubject( $params['showtitle'] );
		$queryHandler->setTemplate( $params['template'] );
		$queryHandler->setUserParam( $params['userparam'] );
		$queryHandler->setHideNamespace( $params['hidenamespace'] );
		$queryHandler->setActiveIcon( $params['activeicon'] );

		$this->handleMarkerData( $params, $queryHandler );

		$params['ajaxquery'] = urlencode( $params['ajaxquery'] );

		$this->service->addHtmlDependencies(
			MapsDisplayMapRenderer::getLayerDependencies( $params['format'], $params )
		);

		$locationAmount = count( $params['locations'] );

		if ( $locationAmount > 0 ) {
			// We can only take care of the zoom defaulting here,
			// as not all locations are available in whats passed to Validator.
			if ( $this->fullParams['zoom']->wasSetToDefault() && $locationAmount > 1 ) {
				$params['zoom'] = false;
			}

			$mapName = $this->service->getMapId();

			SMWOutputs::requireHeadItem(
				$mapName,
				$this->service->getDependencyHtml() .
				$configVars = Skin::makeVariablesScript( $this->service->getConfigVariables() )
			);

			foreach ( $this->service->getResourceModules() as $resourceModule ) {
				SMWOutputs::requireResource( $resourceModule );
			}

			if ( array_key_exists( 'source', $params ) ) {
				unset( $params['source'] );
			}

			return $this->getMapHTML( $params, $mapName );
		} else {
			return $params['default'];
		}
	}

	private function addTrackingCategoryIfNeeded() {
		/**
		 * @var Parser $wgParser
		 */
		global $wgParser;

		if ( $GLOBALS['egMapsEnableCategory'] && $wgParser->getOutput() !== null ) {
			$wgParser->addTrackingCategory( 'maps-tracking-category' );
		}
	}

	private function initializeLocationParser() {
		$this->locationParser = \Maps\MapsFactory::newDefault()->newLocationParser();
	}

	/**
	 * Converts the data in the coordinates parameter to JSON-ready objects.
	 * These get stored in the locations parameter, and the coordinates on gets deleted.
	 *
	 * @param array &$params
	 * @param SMQueryHandler $queryHandler
	 */
	private function handleMarkerData( array &$params, SMQueryHandler $queryHandler ) {
		$params['centre'] = $this->getCenter( $params['centre'] );

		$iconUrl = MapsMapper::getFileUrl( $params['icon'] );
		$visitedIconUrl = MapsMapper::getFileUrl( $params['visitedicon'] );

		$params['locations'] = $this->getJsonForStaticLocations(
			$params['staticlocations'],
			$params,
			$iconUrl,
			$visitedIconUrl
		);

		unset( $params['staticlocations'] );

		$this->addShapeData( $queryHandler->getShapes(), $params, $iconUrl, $visitedIconUrl );

		if ( $params['format'] === 'openlayers' ) {
			$params['layers'] = MapsDisplayMapRenderer::evilOpenLayersHack( $params['layers'] );
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

	private function getJsonForStaticLocations( array $staticLocations, array $params, $iconUrl, $visitedIconUrl ) {
		/**
		 * @var Parser $wgParser
		 */
		global $wgParser;

		$parser = version_compare( $GLOBALS['wgVersion'], '1.18', '<' ) ? $wgParser : clone $wgParser;

		$locationsJson = [];

		foreach ( $staticLocations as $location ) {
			$locationsJson[] = $this->getJsonForStaticLocation(
				$location,
				$params,
				$iconUrl,
				$visitedIconUrl,
				$parser
			);
		}

		return $locationsJson;
	}

	private function getJsonForStaticLocation( Location $location, array $params, $iconUrl, $visitedIconUrl, Parser $parser ) {
		$jsonObj = $location->getJSONObject( $params['title'], $params['label'], $iconUrl, '', '', $visitedIconUrl );

		$jsonObj['title'] = $parser->parse( $jsonObj['title'], $parser->getTitle(), new ParserOptions() )->getText();
		$jsonObj['text'] = $parser->parse( $jsonObj['text'], $parser->getTitle(), new ParserOptions() )->getText();

		$hasTitleAndtext = $jsonObj['title'] !== '' && $jsonObj['text'] !== '';
		$jsonObj['text'] = ( $hasTitleAndtext ? '<b>' . $jsonObj['title'] . '</b><hr />' : $jsonObj['title'] ) . $jsonObj['text'];
		$jsonObj['title'] = strip_tags( $jsonObj['title'] );

		if ( $params['pagelabel'] ) {
			$jsonObj['inlineLabel'] = Linker::link( Title::newFromText( $jsonObj['title'] ) );
		}

		return $jsonObj;
	}

	/**
	 * @param Element[] $queryShapes
	 * @param array $params
	 * @param string $iconUrl
	 * @param string $visitedIconUrl
	 */
	private function addShapeData( array $queryShapes, array &$params, $iconUrl, $visitedIconUrl ) {
		$params['locations'] = array_merge(
			$params['locations'],
			$this->getJsonForLocations(
				$queryShapes['locations'],
				$params,
				$iconUrl,
				$visitedIconUrl
			)
		);

		$params['lines'] = $this->getElementJsonArray( $queryShapes['lines'], $params );
		$params['polygons'] = $this->getElementJsonArray( $queryShapes['polygons'], $params );
	}

	/**
	 * @param Location[] $locations
	 * @param array $params
	 * @param string $iconUrl
	 * @param string $visitedIconUrl
	 *
	 * @return array
	 */
	private function getJsonForLocations( array $locations, array $params, $iconUrl, $visitedIconUrl ) {
		$locationsJson = [];

		foreach ( $locations as $location ) {
			$jsonObj = $location->getJSONObject(
				$params['title'],
				$params['label'],
				$iconUrl,
				'',
				'',
				$visitedIconUrl
			);

			$jsonObj['title'] = strip_tags( $jsonObj['title'] );

			$locationsJson[] = $jsonObj;
		}

		return $locationsJson;
	}

	/**
	 * @param BaseElement[] $elements
	 * @param array $params
	 *
	 * @return array
	 */
	private function getElementJsonArray( array $elements, array $params ) {
		$elementsJson = [];

		foreach ( $elements as $element ) {
			$jsonObj = $element->getJSONObject( $params['title'], $params['label'] );
			$elementsJson[] = $jsonObj;
		}

		return $elementsJson;
	}

	/**
	 * Returns the HTML to display the map.
	 *
	 * @param array $params
	 * @param string $mapName
	 *
	 * @return string
	 */
	private function getMapHTML( array $params, $mapName ) {
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

	/**
	 * Returns the internationalized name of the mapping service.
	 *
	 * @return string
	 */
	public final function getName() {
		return wfMessage( 'maps_' . $this->service->getName() )->text();
	}

	/**
	 * Returns a list of parameter information, for usage by Special:Ask and others.
	 *
	 * @return array
	 */
	public function getParameters() {
		$params = parent::getParameters();
		$paramInfo = $this->getParameterInfo();

		// Do not display this as an option, as the format already determines it
		// TODO: this can probably be done cleaner with some changes in Maps
		unset( $paramInfo['mappingservice'] );

		$params = array_merge( $params, $paramInfo );

		return $params;
	}

	/**
	 * Returns an array containing the parameter info.
	 *
	 * @return array
	 */
	private function getParameterInfo() {
		global $smgQPShowTitle, $smgQPTemplate, $smgQPHideNamespace;

		$params = ParamDefinition::getCleanDefinitions( MapsMapper::getCommonParameters() );

		$this->service->addParameterInfo( $params );

		$params['staticlocations'] = [
			'type' => 'mapslocation', // FIXME: geoservice is not used
			'aliases' => [ 'locations', 'points' ],
			'default' => [],
			'islist' => true,
			'delimiter' => ';',
			'message' => 'semanticmaps-par-staticlocations',
		];

		$params['showtitle'] = [
			'type' => 'boolean',
			'aliases' => 'show title',
			'default' => $smgQPShowTitle,
		];

		$params['hidenamespace'] = [
			'type' => 'boolean',
			'aliases' => 'hide namespace',
			'default' => $smgQPHideNamespace,
		];

		$params['template'] = [
			'default' => $smgQPTemplate,
		];

		$params['userparam'] = [
			'default' => '',
		];

		$params['activeicon'] = [
			'type' => 'string',
			'default' => '',
		];

		$params['pagelabel'] = [
			'type' => 'boolean',
			'default' => false,
		];

		$params['ajaxcoordproperty'] = [
			'default' => '',
		];

		$params['ajaxquery'] = [
			'default' => '',
			'type' => 'string'
		];

		// Messages:
		// semanticmaps-par-staticlocations, semanticmaps-par-showtitle, semanticmaps-par-hidenamespace,
		// semanticmaps-par-template, semanticmaps-par-userparam, semanticmaps-par-activeicon,
		// semanticmaps-par-pagelabel, semanticmaps-par-ajaxcoordproperty semanticmaps-par-ajaxquery
		foreach ( $params as $name => &$data ) {
			if ( is_array( $data ) && !array_key_exists( 'message', $data ) ) {
				$data['message'] = 'semanticmaps-par-' . $name;
			}
		}

		return $params;
	}
}
