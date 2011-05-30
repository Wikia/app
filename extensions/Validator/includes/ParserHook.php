<?php

/**
 * Class for out of the box parser hook functionality integrated with the validation
 * provided by Validator.
 *
 * @since 0.4
 *
 * @file ParserHook.php
 * @ingroup Validator
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class ParserHook {
	
	const TYPE_TAG = 0;
	const TYPE_FUNCTION = 1;
	
	/**
	 * @since 0.4.3
	 * 
	 * @var array
	 */
	protected static $registeredHooks = array();
	
	/**
	 * Returns an array of registered parser hooks (keys) and their handling
	 * ParserHook deriving class names (values).
	 * 
	 * @since 0.4.3
	 * 
	 * @return array
	 */
	public static function getRegisteredParserHooks() {
		return self::$registeredHooks;
	}
	
	/**
	 * Returns the name of the ParserHook deriving class that defines a certain parser hook,
	 * or false if there is none.
	 * 
	 * @since 0.4.3
	 * 
	 * @param string $hookName
	 * 
	 * @return mixed string or false
	 */
	public static function getHookClassName( $hookName ) {
		return array_key_exists( $hookName, self::$registeredHooks ) ? self::$registeredHooks[$hookName] : false;
	}
	
	/**
	 * @since 0.4
	 * 
	 * @var Validator
	 */	
	protected $validator;
	
	/**
	 * @since 0.4
	 * 
	 * @var Parser
	 */
	protected $parser;
	
	/**
	 * @since 0.4.4
	 * 
	 * @var PPFrame
	 */
	protected $frame;
	
	/**
	 * @since 0.4.4
	 * 
	 * @var ParserHook::TYPE_ enum item
	 */	
	protected $currentType;
	
	/**
	 * @since 0.4
	 * 
	 * @var boolean
	 */
	public $forTagExtensions; 
	
	/**
	 * @since 0.4
	 * 
	 * @var boolean
	 */	
	public $forParserFunctions; 
	
	/**
	 * Gets the name of the parser hook.
	 * 
	 * @since 0.4
	 * 
	 * @return string or array of string
	 */
	protected abstract function getName();
	
	/**
	 * Renders and returns the output.
	 * 
	 * @since 0.4
	 * 
	 * @param array $parameters
	 * 
	 * @return string
	 */
	protected abstract function render( array $parameters );	
	
	/**
	 * Constructor.
	 * 
	 * @since 0.4
	 * 
	 * @param boolean $forTagExtensions
	 * @param boolean $forParserFunctions
	 */
	public function __construct( $forTagExtensions = true, $forParserFunctions = true ) {
		$this->forTagExtensions = $forTagExtensions;
		$this->forParserFunctions = $forParserFunctions;
	}
	
	/**
	 * Function to hook up the coordinate rendering functions to the parser.
	 * 
	 * @since 0.4
	 * 
	 * @param Parser $wgParser
	 * 
	 * @return true
	 */
	public function init( Parser &$wgParser ) {
		$className = get_class( $this );
		$first = true;
		
		foreach ( $this->getNames() as $name ) {
			if ( $first ) {
				self::$registeredHooks[$name] = $className;
				$first = false;
			}
			
			if ( $this->forTagExtensions ) {
				$wgParser->setHook(
					$name,
					array( new ParserHookCaller( $className, 'renderTag' ), 'runHook' )
				);
			}
			
			if ( $this->forParserFunctions ) {
				$wgParser->setFunctionHook(
					$name,
					array( new ParserHookCaller( $className, 'renderFunction' ), 'runHook' )
				);
			}
		}

		return true;
	}
	
	/**
	 * returns an array with the names for the parser hook.
	 * 
	 * @since 0.4
	 * 
	 * @return array
	 */
	protected function getNames() {
		$names = $this->getName();
		
		if ( !is_array( $names ) ) {
			$names = array( $names );
		}

		return $names;
	}
	
	/**
	 * Function to add the magic word in pre MW 1.16.
	 * 
	 * @since 0.4
	 * 
	 * @param array $magicWords
	 * @param string $langCode
	 * 
	 * @return true
	 */
	public function magic( array &$magicWords, $langCode ) {
		foreach ( $this->getNames() as $name ) {
			$magicWords[$name] = array( 0, $name );
		}
		
		return true;
	}
	
	/**
	 * Handler for rendering the tag hook.
	 * 
	 * @since 0.4
	 * 
	 * @param minxed $input string or null
	 * @param array $args
	 * @param Parser $parser
	 * @param PPFrame $frame Available from 1.16
	 * 
	 * @return string
	 */
	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame = null  ) {
		$this->parser = $parser;
		$this->frame = $frame;
		
		$defaultParameters = $this->getDefaultParameters( self::TYPE_TAG );
		$defaultParam = array_shift( $defaultParameters );

		// If there is a first default parameter, set the tag contents as it's value.
		if ( !is_null( $defaultParam ) && !is_null( $input ) ) {
			$args[$defaultParam] = $input;
		}

		return $this->validateAndRender( $args, self::TYPE_TAG );
	}
	
	/**
	 * Handler for rendering the function hook.
	 * 
	 * @since 0.4
	 * 
	 * @param Parser $parser
	 * ... further arguments ...
	 * 
	 * @return array
	 */
	public function renderFunction() {
		$args = func_get_args();
		
		$this->parser = array_shift( $args );	
		$output = $this->validateAndRender( $args, self::TYPE_FUNCTION );
		$options = $this->getFunctionOptions();
		
		if ( array_key_exists( 'isHTML', $options ) && $options['isHTML'] ) {
			return $this->parser->insertStripItem( $output, $this->parser->mStripState );
		}
		
		return array_merge( 
			array( $output ),
			$options
		);
	}
	
	/**
	 * Returns the parser function otpions.
	 * 
	 * @since 0.4
	 * 
	 * @return array
	 */
	protected function getFunctionOptions() {
		return array();
	}
	
	/**
	 * Takes care of validation and rendering, and returns the output.
	 * 
	 * @since 0.4
	 * 
	 * @param array $arguments
	 * @param integer $type Item of the ParserHook::TYPE_ enum
	 * 
	 * @return string
	 */
	public function validateAndRender( array $arguments, $type ) {
		global $egValidatorErrorLevel;
		
		$names = $this->getNames();
		$this->validator = new Validator( $names[0] );
		
		if ( $type === self::TYPE_FUNCTION ) {
			$this->validator->setFunctionParams( $arguments, $this->getParameterInfo( $type ), $this->getDefaultParameters( $type ) );
		}
		else {
			$this->validator->setParameters( $arguments, $this->getParameterInfo( $type ) );
		}
		
		$this->validator->validateParameters();
		
		$fatalError = $this->validator->hasFatalError();
		
		if ( $fatalError === false ) {
			$output = $this->render( $this->validator->getParameterValues() );
			$output = $this->renderErrors( $output );
		}
		else {
			$output = $this->renderFatalError( $fatalError );		
		}
		
		return $output;
	}
	
	/**
	 * Returns the ValidationError objects for the errors and warnings that should be displayed.
	 * 
	 * @since 0.4
	 * 
	 * @return array of array of ValidationError
	 */
	protected function getErrorsToDisplay() {
		$errors = array();
		$warnings = array();
		
		foreach ( $this->validator->getErrors() as $error ) {
			// Check if the severity of the error is high enough to display it.
			if ( $error->shouldShow() ) {
				$errors[] = $error;
			}
			else if ( $error->shouldWarn() ) {
				$warnings[] = $error;
			}
		}
		
		return array( 'errors' => $errors, 'warnings' => $warnings );
	}
	
	/**
	 * Creates and returns the output when a fatal error prevent regular rendering.
	 * 
	 * @since 0.4
	 * 
	 * @param ValidationError $error
	 * 
	 * @return string
	 */
	protected function renderFatalError( ValidationError $error ) {
		return '<div><span class="errorbox">' .
			htmlspecialchars( wfMsgExt( 'validator-fatal-error', 'parsemag', $error->getMessage() ) ) . 
			'</span></div><br /><br />';
	}
	
	/**
	 * @since 0.4
	 * 
	 * @param string $output
	 * 
	 * @return string
	 */
	protected function renderErrors( $output ) {
		$displayStuff = $this->getErrorsToDisplay();
		
		if ( count( $displayStuff['errors'] ) > 0 ) {
			$output .= wfMsgExt( 'validator_error_parameters', 'parsemag', count( $displayStuff['errors'] ) );
			
			foreach( $displayStuff['errors'] as $error ) {
				$output .= '<br />* ' . $error->getMessage();
			}
			
			if ( count( $displayStuff['warnings'] ) > 0 ) {
				$output .= '<br />* ' . wfMsgExt( 'validator-warning-adittional-errors', 'parsemag', count( $displayStuff['warnings'] ) );
			}
		}
		else if ( count( $displayStuff['warnings'] ) > 0 ) {
			$output .= wfMsgExt(
				'validator-warning',
				'parsemag',
				wfMsgExt( 'validator_warning_parameters', 'parsemag', count( $displayStuff['warnings'] ) )
			);
		}
		
		return $output;
	}
	
	/**
	 * Returns an array containing the parameter info.
	 * Override in deriving classes to add parameter info.
	 * 
	 * @since 0.4
	 * 
	 * @param integer $type Item of the ParserHook::TYPE_ enum
	 * 
	 * @return array
	 */
	protected function getParameterInfo( $type ) {
		return array();
	}
	
	/**
	 * Returns the list of default parameters.
	 * Override in deriving classes to add default parameters.
	 * 
	 * @since 0.4
	 * 
	 * @param integer $type Item of the ParserHook::TYPE_ enum
	 * 
	 * @return array
	 */
	protected function getDefaultParameters( $type ) {
		return array();
	}
	
	/**
	 * Returns the data needed to describe the parser hook.
	 * This is mainly needed because some of the individual get methods
	 * that return the needed data are protected, and cannot be made
	 * public without breaking b/c in a rather bad way.
	 * 
	 * @since 0.4.3
	 * 
	 * @param integer $type Item of the ParserHook::TYPE_ enum
	 * 
	 * @return array
	 */
	public function getDescriptionData( $type ) {
		return array(
			'names' => $this->getNames(),
			'description' => $this->getDescription(),
			'parameters' => $this->getParameterInfo( $type ),
			'defaults' => $this->getDefaultParameters( $type ),
		);
	}
	
	/**
	 * Returns a description message for the parser hook, or false when there is none.
	 * Override in deriving classes to add a message.
	 * 
	 * @since 0.4.3
	 * 
	 * @return mixed string or false
	 */
	public function getDescription() {
		return false;
	}
	
	/**
	 * Returns if the current render request is coming from a tag extension.
	 * 
	 * @since 0.4.4
	 * 
	 * @return boolean
	 */
	protected function isTag() {
		return $this->currentType == self::TYPE_TAG;
	}
	
	/**
	 * Returns if the current render request is coming from a parser function.
	 * 
	 * @since 0.4.4
	 * 
	 * @return boolean
	 */
	protected function isFunction() {
		return $this->currentType == self::TYPE_FUNCTION;
	}
	
	/**
	 * Utility function to parse wikitext without having to care
	 * about handling a tag extension or parser function. 
	 * 
	 * @since 0.4.4
	 * 
	 * @param string $text The wikitext to be parsed
	 * 
	 * @return string the parsed output
	 */
	protected function parseWikitext( $text ) {
		// Parse the wikitext to HTML.
		if ( $this->isFunction() ) {
			return $this->parser->parse(
				text,
				$this->parser->mTitle,
				$this->parser->mOptions,
				true,
				false
			)->getText();
		}
		else {
			return $this->parser->recursiveTagParse(
				$text,
				$this->frame
			);				
		}		
	}	
	
}

/**
 * Completely evil class to create a new instance of the handling ParserHook when the actual hook gets called.
 * 
 * @evillness >9000 - to be replaced when a better solution (LSB?) is possible.
 * 
 * @since 0.4
 * 
 * @author Jeroen De Dauw
 */
class ParserHookCaller {
	
	protected $class;
	protected $method;
	
	function __construct( $class, $method ) {
		$this->class = $class;
		$this->method = $method;
	}
	 
	public function runHook() {
		$args = func_get_args();
		return call_user_func_array( array( new $this->class(), $this->method ), $args );
	}
	
}