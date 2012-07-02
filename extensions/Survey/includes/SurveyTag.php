<?php

/**
 * Class to render survey tags.
 * 
 * @since 0.1
 * 
 * @file SurveyTag.php
 * @ingroup Survey
 * 
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SurveyTag {
	
	/**
	 * List of survey parameters.
	 * 
	 * @since 0.1
	 * 
	 * @var array
	 */
	protected $parameters;
	
	protected $contents;
	
	/**
	 * Constructor.
	 * 
	 * @since 0.1
	 * 
	 * @param array $args
	 * @param string|null $contents
	 */
	public function __construct( array $args, $contents = null ) {
		$this->parameters = $args;
		$this->contents = $contents;
		
		$args = filter_var_array( $args, $this->getSurveyParameters() );
		
		if ( is_array( $args ) ) {
			$this->parameters = array();
			
			foreach ( $args as $name => $value ) {
				if ( !is_null( $value ) && $value !== false ) {
					$this->parameters['survey-data-' . $name] = $value;
				}
			}
			
			$this->parameters['class'] = 'surveytag';
			$this->parameters['survey-data-token'] = 
				$GLOBALS['wgUser']->editToken( serialize( array( 'submitsurvey', $GLOBALS['wgUser']->getName() ) ) );
		} else {
			throw new MWException( 'Invalid parameters for survey tag.' );
		}
	}
	
	/**
	 * Renrder the survey div.
	 * 
	 * @since 0.1
	 * 
	 * @param Parser $parser
	 * 
	 * @return string
	 */
	public function render( Parser $parser ) {
		static $loadedJs = false;
		
		if ( !$loadedJs ) {
			$parser->getOutput()->addModules( 'ext.survey.tag' );
			$parser->getOutput()->addHeadItem( 
				Skin::makeVariablesScript( array(  
					'wgSurveyDebug' => SurveySettings::get( 'JSDebug' )
				) )
			);
		}
		
		return Html::element(
			'span',
			$this->parameters,
			$this->contents
		);
	}
	
	/**
	 * 
	 * 
	 * @since 0.1
	 * 
	 * @param array $args
	 * 
	 * @return array
	 */
	protected function getSurveyParameters() {
		return array(
			'id' => array( 'filter' => FILTER_VALIDATE_INT, 'options' => array( 'min_range' => 1 ) ),
			'name' => array(),
			'cookie' => array(),
			'title' => array(),
			'require-enabled' => array( 'filter' => FILTER_VALIDATE_INT, 'options' => array( 'min_range' => 0, 'max_range' => 1 ) ),
			'expiry' => array( 'filter' => FILTER_VALIDATE_INT, 'options' => array( 'min_range' => 0 ) ),
			'min-pages' => array( 'filter' => FILTER_VALIDATE_INT, 'options' => array( 'min_range' => 0 ) ),
			'ratio' => array( 'filter' => FILTER_VALIDATE_INT, 'options' => array( 'min_range' => 0, 'max_range' => 100 ) ),
		);
	}

}
