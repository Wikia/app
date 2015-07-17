<?php

/**
 * Query printer for maps. Is invoked via SMMapper.
 * Can be overridden per service to have custom output.
 *
 * @file SM_MapPrinter.php
 * @ingroup SemanticMaps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SMMapPrinter extends SMWResultPrinter {
	
	/**
	 * @since 0.6
	 * 
	 * @var iMappingService
	 */
	protected $service;	
	
	/**
	 * @since 1.0
	 * 
	 * @var false or string
	 */
	protected $fatalErrorMsg = false;
	
	/**
	 * Constructor.
	 * 
	 * @param $format String
	 * @param $inline
	 */
	public function __construct( $format, $inline = true ) {
		$this->service = MapsMappingServices::getValidServiceInstance( $format, 'qp' );
		
		parent::__construct( $format, $inline );
	}

	/**
	 * Returns an array containing the parameter info.
	 * 
	 * @since 1.0
	 * 
	 * @return array
	 */
	protected function getParameterInfo() {
		global $egMapsDefaultLabel, $egMapsDefaultTitle;
		global $smgQPForceShow, $smgQPShowTitle, $smgQPTemplate, $smgQPHideNamespace;
		
		$params = ParamDefinition::getCleanDefinitions( MapsMapper::getCommonParameters() );

		$this->service->addParameterInfo( $params );
		
		$params['zoom']->setDefault( false );		
		$params['zoom']->setDoManipulationOfDefault( false );		
		
		$params['staticlocations'] = new ListParameter( 'staticlocations', ';' );
		$params['staticlocations']->addAliases( 'locations', 'points' );
		$params['staticlocations']->addCriteria( new CriterionIsLocation( '~' ) );
		$params['staticlocations']->addManipulations( new MapsParamLocation( '~' ) );
		$params['staticlocations']->setDefault( array() );
		$params['staticlocations']->setMessage( 'semanticmaps-par-staticlocations' );

		$params['icon'] = new Parameter(
			'icon',
			Parameter::TYPE_STRING,
			'',
			array(),
			array(
				New CriterionNotEmpty()
			)
		);
		$params['icon']->setMessage( 'maps-displaypoints-par-icon' );

		$params['visitedicon'] = new Parameter(
			'visitedicon',
			Parameter::TYPE_STRING,
			'',
			array(),
			array(
				New CriterionNotEmpty()
			)
		);
		$params['visitedicon']->setMessage( 'maps-displaymap-par-visitedicon' );
		
		$params['forceshow'] = new Parameter(
			'forceshow',
			Parameter::TYPE_BOOLEAN,
			$smgQPForceShow,
			array( 'force show' )
		);
		$params['forceshow']->setMessage( 'semanticmaps-par-forceshow' );

		$params['showtitle'] = new Parameter(
			'showtitle',
			Parameter::TYPE_BOOLEAN,
			$smgQPShowTitle,
			array( 'show title' )
		);
		$params['showtitle']->setMessage( 'semanticmaps-par-showtitle' );

		$params['hidenamespace'] = new Parameter(
			'hidenamespace',
			Parameter::TYPE_BOOLEAN,
			$smgQPHideNamespace,
			array( 'hide namespace' )
		);
		$params['hidenamespace']->setMessage( 'semanticmaps-par-hidenamespace' );

		$params['template'] = new Parameter(
			'template',
			Parameter::TYPE_STRING,
			$smgQPTemplate,
			array(),
			array(
				New CriterionNotEmpty()
			)
		);
		$params['template']->setDoManipulationOfDefault( false );
		$params['template']->setMessage( 'semanticmaps-par-template' );
		
		$params['title'] = new Parameter(
			'title',
			Parameter::TYPE_STRING,
			$egMapsDefaultTitle
		);
		$params['title']->setMessage( 'maps-displaypoints-par-title' );
		
		$params['label'] = new Parameter(
			'label',
			Parameter::TYPE_STRING,
			$egMapsDefaultLabel,
			array( 'text' )
		);
		$params['label']->setMessage( 'maps-displaypoints-par-label' );

		$params['lines'] = array(
			'default' => array(),
			'message' => 'maps-displaypoints-par-lines', // TODO
			'criteria' => new CriterionLine( '~' ),
			'manipulations' => new MapsParamLine( '~' ),
			'delimiter' => ';',
			'islist' => true,
		);

		$params['polygons'] = array(
			'default' => array(),
			'message' => 'maps-displaypoints-par-polygons', // TODO
			'criteria' => new CriterionPolygon( '~' ), // TODO
			'manipulations' => new MapsParamPolygon( '~' ), // TODO
			'delimiter' => ';',
			'islist' => true,
		);

		$params['circles'] = array(
			'default' => array(),
			'message' => 'maps-displaypoints-par-circles', // TODO
			'manipulations' => new MapsParamCircle( '~' ), // TODO
			'delimiter' => ';',
			'islist' => true,
		);

		$params['rectangles'] = array(
			'default' => array(),
			'message' => 'maps-displaypoints-par-rectangles', // TODO
			'manipulations' => new MapsParamRectangle( '~' ), // TODO
			'delimiter' => ';',
			'islist' => true,
		);
		
		return $params;
	}
	
	/**
	 * Builds up and returns the HTML for the map, with the queried coordinate data on it.
	 *
	 * @param SMWQueryResult $res
	 * @param $outputmode
	 * 
	 * @return array or string
	 */
	public final function getResultText( SMWQueryResult $res, $outputmode ) {
		if ( $this->fatalErrorMsg === false ) {
			global $wgParser;
			
			$params = $this->params;
			
			$queryHandler = new SMQueryHandler( $res, $outputmode );
			$queryHandler->setShowSubject( $params['showtitle'] );
			$queryHandler->setTemplate( $params['template'] );
			$queryHandler->setHideNamespace( $params['hidenamespace'] );
			
			$this->handleMarkerData( $params, $queryHandler );
			$locationAmount = count( $params['locations'] );
			
			if ( $params['forceshow'] || $locationAmount > 0 ) {
				// We can only take care of the zoom defaulting here, 
				// as not all locations are available in whats passed to Validator.
				if ( $params['zoom'] === false && $locationAmount <= 1 ) {
					$params['zoom'] = $this->service->getDefaultZoom();
				}
				
				$mapName = $this->service->getMapId();
				
				// MediaWiki 1.17 does not play nice with addScript, so add the vars via the globals hook.
				if ( version_compare( $GLOBALS['wgVersion'], '1.18', '<' ) ) {
					$GLOBALS['egMapsGlobalJSVars'] += $this->service->getConfigVariables();
				}
				
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

				return $this->getMapHTML( $params, $wgParser, $mapName );
			}
			else {
				return $params['default'];
			}
		}
		else {
			return $this->fatalErrorMsg;
		}
	}

	/**
	 * Returns the HTML to display the map.
	 *
	 * @since 1.1
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
	 * @since 1.1
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
	 * Converts the data in the coordinates parameter to JSON-ready objects.
	 * These get stored in the locations parameter, and the coordinates on gets deleted.
	 * 
	 * @since 1.0
	 * 
	 * @param array &$params
	 * @param $queryHandler
	 */
	protected function handleMarkerData( array &$params, $queryHandler ) {
		$queryShapes = $queryHandler->getShapes();
		global $wgParser;

		$parser = version_compare( $GLOBALS['wgVersion'], '1.18', '<' ) ? $wgParser : clone $wgParser;
		
		$iconUrl = MapsMapper::getFileUrl( $params['icon'] );
		$visitedIconUrl = MapsMapper::getFileUrl( $params['visitedicon'] );
		$params['locations'] = array();

		foreach ( $params['staticlocations'] as $location ) {
			if ( $location->isValid() ) {
				$jsonObj = $location->getJSONObject( $params['title'], $params['label'], $iconUrl, '', '', $visitedIconUrl );
				
				$jsonObj['title'] = $parser->parse( $jsonObj['title'], $parser->getTitle(), new ParserOptions() )->getText();
				$jsonObj['text'] = $parser->parse( $jsonObj['text'], $parser->getTitle(), new ParserOptions() )->getText();
				
				$hasTitleAndtext = $jsonObj['title'] !== '' && $jsonObj['text'] !== '';
				$jsonObj['text'] = ( $hasTitleAndtext ? '<b>' . $jsonObj['title'] . '</b><hr />' : $jsonObj['title'] ) . $jsonObj['text'];
				$jsonObj['title'] = strip_tags( $jsonObj['title'] );
				
				$params['locations'][] = $jsonObj;					
			}
		}
		
		foreach ( $queryShapes['locations'] as $location ) {
			if ( $location->isValid() ) {
				$jsonObj = $location->getJSONObject( $params['title'], $params['label'], $iconUrl, '', '', $visitedIconUrl );
				
				$jsonObj['title'] = strip_tags( $jsonObj['title'] );
				
				$params['locations'][] = $jsonObj;				
			}
		}
		unset( $params['staticlocations'] );
		foreach ( $queryShapes['lines'] as $line ) {
			$jsonObj = $line->getJSONObject( $params['title'], $params['label'] );
			$params['lines'][] = $jsonObj;				
		}
		foreach ( $queryShapes['polygons'] as $polygon ) {
			$jsonObj = $polygon->getJSONObject( $params['title'], $params['label'] );
			$params['polygons'][] = $jsonObj;				
		}


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
}
