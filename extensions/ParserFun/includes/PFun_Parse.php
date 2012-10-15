<?php

/**
 * Class for the '#parse' parser function.
 * 
 * @since 0.1
 * 
 * @file PFun_Parse.php
 * @ingroup ParserFun
 * 
 * @author Daniel Werner
 */
class ParserFunParse extends ParserHook {
	
	/**
	 * Whether or not the input text should be parsed by Parser::braceSubstitution()
	 * after the function has returned its value (this is possible by returning function
	 * result as array with 'noparse' set to false).
	 * This is always set to 'true' for new MW versions which support object style parser
	 * function arguments sinc we call the parsing process manually in this case.
	 * 
	 * @since 0.1
	 * 
	 * @var boolean
	 */
	protected $postParse_fallback;
	
	public function __construct() {
		// make this a parser function extension (no tag extension) only:
		parent::__construct( false, true );
	}
	
	/**
	 * No LSB in pre-5.3 PHP, to be refactored later
	 */	
	public static function staticInit( Parser &$parser ) {
		global $egParserFunEnabledFunctions;
		if( in_array( 'parse', $egParserFunEnabledFunctions ) ) {
			// only register function if not disabled by configuration
			$instance = new self;
			$instance->init( $parser );
		}
		return true;
	}
	
	/**
	 * Gets the name of the parser hook.
	 * @see ParserHook::getName
	 * 
	 * @return string
	 */
	protected function getName() {
		return 'parse';
	}
	
	/**
	 * Returns an array containing the parameter info.
	 * @see ParserHook::getParameterInfo
	 * 
	 * @return array
	 */
	protected function getParameterInfo( $type ) {
		$params = array();
		
		# input text.
		# since 0.1
		$params['text'] = new Parameter( 'text' );
		
		# if 'true', this will prevent parsing. Usful if something should be unstripped only.
		# since 0.1
		$params['parse'] = new Parameter( 'parse', Parameter::TYPE_BOOLEAN );
		$params['parse']->setDefault( true );
		
		# Whether the input text should be unstripped first.
		# since 0.1
		$params['unstrip'] = new Parameter( 'unstrip', Parameter::TYPE_STRING );
		$params['unstrip']->addCriteria( new CriterionInArray( 'none', 'nowiki', 'general', 'all' ) );
		$params['unstrip']->setDefault( 'none' );
		
		/**
		 * @ToDo: Perhaps a 'context' parameter would be quite interesting.
		 */
		
		return $params;
	}
	
	/**
	 * Returns the list of default parameters.
	 * @see ParserHook::getDefaultParameters
	 * 
	 * @return array
	 */
	protected function getDefaultParameters( $type ) {
		return array(
			array( 'text', Validator::PARAM_UNNAMED ),
		);
	}
	
	/**
	 * Returns the parser function options.
	 * @see ParserHook::getFunctionOptions
	 * 
	 * @return array
	 */
	protected function getFunctionOptions() {
		return array(
			'noparse' => !$this->postParse_fallback,
			'isHTML' => false
		);
	}
		
	/**
	 * Renders and returns the output.
	 * @see ParserHook::renderTag
	 * 
	 * @param array $parameters
	 * 
	 * @return string
	 */
	public function render( array $parameters ) {
		$text = $parameters['text'];
		
		// current parsers StripState object
		$stripState = $this->parser->mStripState;
		
		switch( $parameters['unstrip'] ) {
			
			// case 'none': <do nothing>
			
			case 'nowiki':
				$text = $stripState->unstripNoWiki( $text );
				break;
			
			case 'general':
				$text = $stripState->unstripGeneral( $text );
				break;
			
			case 'all':
				$text = $stripState->unstripBoth( $text );
				break;
		}
		
		// parse if $frame is set (new MW versions) and parsing is not disabled for this one:
		if( $this->frame !== null && $parameters['parse'] === true ) {
			
			// we don't need the fallback since $frame is given:
			$this->postParse_fallback = false;
			
			/**
			 * Doing the parsing here allows to parse <noinclude> / <includeonly> acording to the context
			 * of where the function is defined and called. IF we use the parser function 'noparse' return
			 * value, it would always be parsed like a page view meaning <includeonly> content would appear.
			 */
			$text = $this->parser->preprocessToDom( $text, $this->frame->isTemplate() ? Parser::PTD_FOR_INCLUSION : 0 );
			$text = trim( $this->frame->expand( $text ) );			
		}
		else {
			// fallback for old MW versions or in case the 'parse' #parse parameter is set to false
			$this->postParse_fallback = $parameters['parse'];
		}
		
		return $text;
	}
	
}
