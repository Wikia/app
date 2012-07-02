<?php

/**
 * Query printer for maps. Is invoked via SMMapper.
 * Can be overriden per service to have custom output.
 *
 * @file SM_MapPrinter.php
 * @ingroup SemanticMaps
 *
 * @licence GNU GPL v3
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
	 * @param $service iMappingService
	 */
	public function __construct( $format, $inline, iMappingService $service ) {
		$this->service = $service;
		
		parent::__construct( $format, $inline );
		$this->useValidator = true;
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
		global $smgQPForceShow, $smgQPShowTitle, $smgQPTemplate;
		
		$params = MapsMapper::getCommonParameters();
		$this->service->addParameterInfo( $params );		
		
		$params['zoom']->setDefault( false );		
		$params['zoom']->setDoManipulationOfDefault( false );		
		
		$params['staticlocations'] = new ListParameter( 'staticlocations', ';' );
		$params['staticlocations']->addAliases( 'locations' );
		$params['staticlocations']->addCriteria( new CriterionIsLocation( '~' ) );
		$params['staticlocations']->addManipulations( new MapsParamLocation( '~' ) );		
		$params['staticlocations']->setDefault( array() );
		$params['staticlocations']->setMessage( 'semanticmaps-par-staticlocations' );
		
		$params['centre'] = new Parameter( 'centre' );
		$params['centre']->setDefault( false );
		$params['centre']->addAliases( 'center' );
		$params['centre']->addCriteria( new CriterionIsLocation() );
		$params['centre']->setDoManipulationOfDefault( false );
		$manipulation = new MapsParamLocation();
		$manipulation->toJSONObj = true;
		$params['centre']->addManipulations( $manipulation );
		$params['centre']->setMessage( 'semanticmaps-par-centre' );
		
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
			
			$this->handleMarkerData( $params, $queryHandler->getLocations() );
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
				
				$result = $this->getMapHTML( $params, $wgParser, $mapName ) . $this->getJSON( $params, $wgParser, $mapName );
				
				return array(
					$result,
					'noparse' => true, 
					'isHTML' => true
				);				
			}
			else {
				return '';
			}
		}
		else {
			return $this->fatalErrorMsg;
		}
	}
	
	/**
	 * Returns the HTML to display the map.
	 * 
	 * @since 1.0
	 * 
	 * @param array $params
	 * @param Parser $parser
	 * @param string $mapName
	 * 
	 * @return string
	 */
	protected function getMapHTML( array $params, Parser $parser, $mapName ) {
		return Html::element(
			'div',
			array(
				'id' => $mapName,
				'style' => "width: {$params['width']}; height: {$params['height']}; background-color: #cccccc; overflow: hidden;",
			),
			wfMsg( 'maps-loading-map' )
		);
	}	
	
	/**
	 * Returns the JSON with the maps data.
	 *
	 * @since 1.0
	 *
	 * @param array $params
	 * @param Parser $parser
	 * @param string $mapName
	 * 
	 * @return string
	 */	
	protected function getJSON( array $params, Parser $parser, $mapName ) {
		$object = $this->getJSONObject( $params, $parser );
		
		if ( $object === false ) {
			return '';
		}
		
		return Html::inlineScript(
			MapsMapper::getBaseMapJSON( $this->service->getName() )
			. "mwmaps.{$this->service->getName()}.{$mapName}=" . json_encode( $object ) . ';'
		);
	}
	
	/**
	 * Returns a PHP object to encode to JSON with the map data.
	 *
	 * @since 1.0
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
	 * @param array $queryLocations
	 */
	protected function handleMarkerData( array &$params, array $queryLocations ) {
		global $wgParser;

		$parser = version_compare( $GLOBALS['wgVersion'], '1.18', '<' ) ? $wgParser : clone $wgParser;
		
		$iconUrl = MapsMapper::getFileUrl( $params['icon'] );
		$params['locations'] = array();

		foreach ( $params['staticlocations'] as $location ) {
			if ( $location->isValid() ) {
				$jsonObj = $location->getJSONObject( $params['title'], $params['label'], $iconUrl );
				
				$jsonObj['title'] = $parser->parse( $jsonObj['title'], $parser->getTitle(), new ParserOptions() )->getText();
				$jsonObj['text'] = $parser->parse( $jsonObj['text'], $parser->getTitle(), new ParserOptions() )->getText();
				
				$hasTitleAndtext = $jsonObj['title'] !== '' && $jsonObj['text'] !== '';
				$jsonObj['text'] = ( $hasTitleAndtext ? '<b>' . $jsonObj['title'] . '</b><hr />' : $jsonObj['title'] ) . $jsonObj['text'];
				$jsonObj['title'] = strip_tags( $jsonObj['title'] );
				
				$params['locations'][] = $jsonObj;					
			}
		}
		
		foreach ( $queryLocations as $location ) {
			if ( $location->isValid() ) {
				$jsonObj = $location->getJSONObject( $params['title'], $params['label'], $iconUrl );
				
				$jsonObj['title'] = strip_tags( $jsonObj['title'] );
				
				$params['locations'][] = $jsonObj;				
			}
		}
		
		unset( $params['staticlocations'] );
	}	
	
	/**
	 * Reads the parameters and gets the query printers output.
	 * 
	 * @param SMWQueryResult $results
	 * @param array $params
	 * @param $outputmode
	 * 
	 * @return array
	 */
	public final function getResult( SMWQueryResult $results, array $params, $outputmode ) {
		$this->handleParameters( $params, $outputmode );
		return $this->getResultText( $results, SMW_OUTPUT_HTML );
	}

	/**
	 * Returns the internationalized name of the mapping service.
	 * 
	 * @return string
	 */
	public final function getName() {
		return wfMsg( 'maps_' . $this->service->getName() );
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
     * Takes in an element of the Parameter::TYPE_ enum and turns it into an SMW type (string) indicator.
     * 
     * @since 1.0
     * 
     * @param Parameter::TYPE_ $type
     * 
     * @return string
     */
    protected function getMappedParamType( $type ) {
    	static $typeMap = array(
    		Parameter::TYPE_STRING => 'string',
    		Parameter::TYPE_BOOLEAN => 'boolean',
    		Parameter::TYPE_CHAR => 'int',
    		Parameter::TYPE_FLOAT => 'int',
    		Parameter::TYPE_INTEGER => 'int',
    		Parameter::TYPE_NUMBER => 'int',
    	);
    	
    	return $typeMap[$type];
    }
	
}
