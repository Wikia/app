<?php

/**
 * Class for the 'personstatus' parser hook.
 * 
 * @since 0.1
 * 
 * @file PAMELA_PersonStatus.php
 * @ingroup PAMELA
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class PAMELAPersonStatus extends ParserHook {
	/**
	 * No LSB in pre-5.3 PHP *sigh*.
	 * This is to be refactored as soon as php >=5.3 becomes acceptable.
	 */	
	public static function staticInit( Parser &$parser ) {
		$instance = new self;
		return $instance->init( $parser );
	}	
	
	/**
	 * Gets the name of the parser hook.
	 * @see ParserHook::getName
	 * 
	 * @since 0.1
	 * 
	 * @return string
	 */
	protected function getName() {
		return 'personstatus';
	}
	
	/**
	 * Returns an array containing the parameter info.
	 * @see ParserHook::getParameterInfo
	 * 
	 * @since 0.1
	 * 
	 * @return array
	 */
	protected function getParameterInfo( $type ) {
		global $egPamRefreshInterval;
		
		$params = array();
		
		$params['person'] = new Parameter( 'person' );
		
		$params['interval'] = new Parameter( 'interval', Parameter::TYPE_INTEGER );
		$params['interval']->setDefault( $egPamRefreshInterval );
		$params['interval']->addCriteria( new CriterionInRange( 1, 9000 ) ); // Muhahaha
		
		return $params;
	}
	
	/**
	 * Returns the list of default parameters.
	 * @see ParserHook::getDefaultParameters
	 * 
	 * @since 0.1
	 * 
	 * @return array
	 */
	protected function getDefaultParameters( $type ) {
		return array( 'person' );
	}
	
	/**
	 * Renders and returns the output.
	 * @see ParserHook::render
	 * 
	 * @since 0.1
	 * 
	 * @param array $parameters
	 * 
	 * @return string
	 */
	public function render( array $parameters ) {
		global $egPamAPIURL;
		
		$this->parser->getOutput()->addModules( 'ext.pam.personwidget' );
		
		return Html::element(
			'div',
			array(
				'class' => 'personwidget',
				'apiurl' => $egPamAPIURL,
				'interval' => $parameters['interval'] * 1000,
				'person' => $parameters['person']
			),
			wfMsgForContent( 'pamela-loading' )
		);		
	}
	
	/**
	 * @see ParserHook::getDescription()
	 * 
	 * @since 0.1
	 */
	public function getDescription() {
		return wfMsg( 'pamela-personwidget-desc' );
	}
	
	/**
	 * Returns the parser function otpions.
	 * @see ParserHook::getFunctionOptions
	 * 
	 * @since 0.1
	 * 
	 * @return array
	 */
	protected function getFunctionOptions() {
		return array(
			'noparse' => true,
			'isHTML' => true
		);
	}	
	
}
