<?php

/**
 * Base form input class.
 *
 * @file SM_FormInput.php
 * @ingroup SemanticMaps
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SMFormInput {

	/**
	 * @since 1.0
	 * 
	 * @var iMappingService
	 */
	protected $service;		
	
	/**
	 * A character to separate multiple locations with.
	 * 
	 * @since 1.0
	 * 
	 * @var char
	 */
	const SEPARATOR = ';';
	
	/**
	 * Constructor.
	 * 
	 * @since 1.0
	 * 
	 * @param iMappingService $service
	 */
	public function __construct( iMappingService $service ) {
		$this->service = $service;
	}
	
	/**
	 * Returns an array containing the parameter info.
	 * 
	 * @since 1.0
	 * 
	 * @return array
	 */
	protected function getParameterInfo() {
		global $smgFIMulti, $smgFIFieldSize;
		
		$params = MapsMapper::getCommonParameters();
		$this->service->addParameterInfo( $params );
		
		$params['zoom']->setDefault( false, false );		
		
		$params['multi'] = new Parameter( 'multi', Parameter::TYPE_BOOLEAN );
		$params['multi']->setDefault( $smgFIMulti, false );
		
		$params['fieldsize'] = new Parameter( 'fieldsize', Parameter::TYPE_INTEGER );
		$params['fieldsize']->setDefault( $smgFIFieldSize, false );
		$params['fieldsize']->addCriteria( new CriterionInRange( 5, 100 ) );
		
		$params['centre'] = new Parameter( 'centre' );
		$params['centre']->setDefault( false, false );
		$params['centre']->addAliases( 'center' );
		$params['centre']->addCriteria( new CriterionIsLocation() );
		$manipulation = new MapsParamLocation();
		$manipulation->toJSONObj = true;
		$params['centre']->addManipulations( $manipulation );

		$params['icon'] = new Parameter( 'icon' );
		$params['icon']->setDefault( '' );
		$params['icon']->addCriteria( New CriterionNotEmpty() );
		
		$params['locations'] = new ListParameter( 'locations', self::SEPARATOR );
		$params['locations']->addCriteria( new CriterionIsLocation() );
		$manipulation = new MapsParamLocation();
		$manipulation->toJSONObj = true;
		$params['locations']->addManipulations( $manipulation );		
		
		$params['geocodecontrol'] = new Parameter( 'geocodecontrol', Parameter::TYPE_BOOLEAN );
		$params['geocodecontrol']->setDefault( true, false );
		$params['geocodecontrol']->setMessage( 'semanticmaps-par-geocodecontrol' );
		
		return $params;
	}
	
	/**
	 * 
	 * 
	 * @since 1.0
	 * 
	 * @param string $coordinates
	 * @param string $input_name
	 * @param boolean $is_mandatory
	 * @param boolean $is_disabled
	 * @param array $field_args
	 * 
	 * @return string
	 */
	public function getInputOutput( $coordinates, $input_name, $is_mandatory, $is_disabled, array $params ) {
		$parameters = array();
		foreach ( $params as $key => $value ) {
			if ( !is_array( $value ) && !is_object( $value ) ) {
				$parameters[$key] = $value;
			}
		}

		$parameters['locations'] = $coordinates;
		
		$validator = new Validator( wfMsg( 'maps_' . $this->service->getName() ), false );
		$validator->setParameters( $parameters, $this->getParameterInfo() );
		$validator->validateParameters();
		
		$fatalError  = $validator->hasFatalError();
		
		if ( $fatalError === false ) {
			global $wgParser;
			
			$params = $validator->getParameterValues();
			
			// We can only take care of the zoom defaulting here, 
			// as not all locations are available in whats passed to Validator.
			if ( $params['zoom'] === false && count( $params['locations'] ) <= 1 ) {
				$params['zoom'] = $this->service->getDefaultZoom();
			}			
			
			$mapName = $this->service->getMapId();
			
			$params['inputname'] = $input_name;
			
			$output = $this->getInputHTML( $params, $wgParser, $mapName ) . $this->getJSON( $params, $wgParser, $mapName );
			
			$this->service->addResourceModules( $this->getResourceModules() );
			
			$configVars = Skin::makeVariablesScript( $this->service->getConfigVariables() );
			
			// MediaWiki 1.17 does not play nice with addScript, so add the vars via the globals hook.
			if ( version_compare( $GLOBALS['wgVersion'], '1.18', '<' ) ) {
				$GLOBALS['egMapsGlobalJSVars'] += $this->service->getConfigVariables();
			}
			
			if ( true /* !is_null( $wgTitle ) && $wgTitle->isSpecialPage() */ ) { // TODO
				global $wgOut;
				$this->service->addDependencies( $wgOut );
				$wgOut->addScript( $configVars );
			}
			else {
				$this->service->addDependencies( $wgParser );			
			}			
			
			return $output;
		}
		else {
			return
				'<span class="errorbox">' .
				htmlspecialchars( wfMsgExt( 'validator-fatal-error', 'parsemag', $fatalError->getMessage() ) ) . 
				'</span>';			
		}			
	}
	
	/**
	 * Returns the HTML to display the map input.
	 * 
	 * @since 1.0
	 * 
	 * @param array $params
	 * @param Parser $parser
	 * @param string $mapName
	 * 
	 * @return string
	 */
	protected function getInputHTML( array $params, Parser $parser, $mapName ) {
		return Html::element(
			'div',
			array(
				'id' => $mapName . '_forminput',
				'style' => 'display: inline'
			),
			wfMsg( 'semanticmaps-loading-forminput' )
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
			MapsMapper::getBaseMapJSON( $this->service->getName() . '_forminputs' )
			. "mwmaps.{$this->service->getName()}_forminputs.{$mapName}=" . FormatJson::encode( $object ) . ';'
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
	 * @since 1.0
	 * 
	 * @return array of string
	 */
	protected function getResourceModules() {
		return array( 'ext.sm.forminputs' );
	}
	
}
