<?php

/**
 * Base form input class.
 *
 * @file SM_FormInput.php
 * @ingroup SemanticMaps
 *
 * @licence GNU GPL v2+
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

		$params = ParamDefinition::getCleanDefinitions( MapsMapper::getCommonParameters() );

		$this->service->addParameterInfo( $params );
		
		$params['zoom']->setDefault( false, false );		
		
		$params['multi'] = new Parameter( 'multi', Parameter::TYPE_BOOLEAN );
		$params['multi']->setDefault( $smgFIMulti, false );
		
		$params['fieldsize'] = new Parameter( 'fieldsize', Parameter::TYPE_INTEGER );
		$params['fieldsize']->setDefault( $smgFIFieldSize, false );
		$params['fieldsize']->addCriteria( new CriterionInRange( 5, 100 ) );

		$params['icon'] = new Parameter( 'icon' );
		$params['icon']->setDefault( '' );
		$params['icon']->addCriteria( New CriterionNotEmpty() );

		$manipulation = new MapsParamLocation();
		$manipulation->toJSONObj = true;

		$params['locations'] = array(
			'aliases' => array( 'points' ),
			'criteria' => new CriterionIsLocation(),
			'manipulations' => $manipulation,
			'default' => array(),
			'islist' => true,
			'delimiter' => self::SEPARATOR,
			'message' => 'semanticmaps-par-locations', // TODO
		);
		
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
			if ( !is_array( $value ) && !is_object( $value ) && !is_null( $value ) ) {
				$parameters[$key] = $value;
			}
		}

		if ( !is_null( $coordinates ) ) {
			$parameters['locations'] = $coordinates;
		}

		$validator = new Validator( wfMessage( 'maps_' . $this->service->getName() )->text(), false );
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
			
			$output = $this->getInputHTML( $params, $wgParser, $mapName );
			
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
				htmlspecialchars( wfMessage( 'validator-fatal-error', $fatalError->getMessage() )->text() ) .
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
		return Html::rawElement(
			'div',
			array(
				'id' => $mapName . '_forminput',
				'style' => 'display: inline',
				'class' => 'sminput sminput-' . $this->service->getName()
			),
			wfMessage( 'semanticmaps-loading-forminput' )->escaped() .
				Html::element(
					'div',
					array( 'style' => 'display:none', 'class' => 'sminputdata' ),
					FormatJson::encode( $this->getJSONObject( $params, $parser ) )
				)
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

	/**
	 * @since 2.0 alspha
	 * 
	 * @param string $coordinates
	 * @param string $input_name
	 * @param boolean $is_mandatory
	 * @param boolean $is_disabled
	 * @param array $field_args
	 * 
	 * @return string
	 */
	public function getEditorInputOutput( $coordinates, $input_name, $is_mandatory, $is_disabled, array $params ) {
		global $wgOut;
		$parameters = array();
		$wgOut->addHtml( MapsGoogleMaps3::getApiScript(
			'en',
			array( 'libraries' => 'drawing' )
		) );

		$wgOut->addModules( 'mapeditor' );

		$html = '
			<div >
				<textarea id="map-polygon" name="' . htmlspecialchars( $input_name ) . '" cols="4" rows="2"></textarea>
			</div>';

		$editor = new MapEditor( $this->getAttribs() );
		$html = $html . $editor->getEditorHtml();

		return $html;
	}

	/**
	 * @since 2.1
	 *
	 * @return string
	 */
	protected function getAttribs(){
		return array(
			'id' => 'map-canvas',
			'context' => 'forminput',
			'style' => 'width:600px; height:400px'
		);
	}

}
