<?php

use ParamProcessor\ParamDefinition;
use ParamProcessor\ProcessingError;
use ParamProcessor\Processor;

/**
 * Class for out of the box parser hook functionality integrated with the validation
 * provided by Validator.
 *
 * @since 0.4
 * @deprecated since 1.0 in favour of the ParserHooks library
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Daniel Werner
 */
abstract class ParserHook {

	const TYPE_TAG = 0;
	const TYPE_FUNCTION = 1;

	/**
	 * @since 0.4.3
	 *
	 * @var array
	 */
	protected static $registeredHooks = [];

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
	 * @var Processor
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
	 * Bitfifeld of Options influencing the characteristics of the registered
	 * tag/parser function.
	 * 
	 * @since 0.4.13
	 * 
	 * @var int 
	 */
	protected $parserHookOptions;
	
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
	 * Flag for constructor, whether the function hook should be one callable without
	 * leading hash, i.e. {{plural:...}} instead of {{#if:...}}
	 * 
	 * @since 0.4.13
	 */
	const FH_NO_HASH = 1;
	
	/* *
	 * @ToDo: implementation of this functionality
	 * 
	 * Flag for constructor, whether the tag hook should be handled as function tag hook
	 * and not as a normal tag hook. See Parser::setFunctionTagHook() for details.
	 */
	#const TH_AS_FUNCTION_TAG = 2;
	
	/**
	 * Constructor.
	 *
	 * @since 0.4
	 *
	 * @param boolean $forTagExtensions
	 * @param boolean $forParserFunctions
	 * @param integer $flag combination of option flags to manipulare the parser hooks
	 *        characteristics. The following are available:
	 *        - ParserHook::FH_NO_HASH makes the function callable without leading hash.
	 */
	public function __construct( $forTagExtensions = true, $forParserFunctions = true, $flags = 0 ) {
		$this->forTagExtensions = $forTagExtensions;
		$this->forParserFunctions = $forParserFunctions;
		// store flags:
		$this->parserHookOptions = $flags;
	}

	/**
	 * Function to hook up the coordinate rendering functions to the parser.
	 *
	 * @since 0.4
	 *
	 * @param Parser $parser
	 *
	 * @return true
	 */
	public function init( Parser $parser ) {
		$className = get_class( $this );
		$first = true;

		foreach ( $this->getNames() as $name ) {
			if ( $first ) {
				self::$registeredHooks[$name] = $className;
				$first = false;
			}
			
			// Parser Tag hooking:
			if ( $this->forTagExtensions ) {
				$parser->setHook(
					$name,
					[ new ParserHookCaller( $className, 'renderTag' ), 'runTagHook' ]
				);
			}

			// Parser Function hooking:
			if ( $this->forParserFunctions ) {
				$flags = 0;
				$function = 'renderFunction';
				$callerFunction = 'runFunctionHook';
				
				// use object arguments if available:
				if ( defined( 'SFH_OBJECT_ARGS' ) ) {
					$flags = $flags | SFH_OBJECT_ARGS;
					$function .= 'Obj';
					$callerFunction .= 'Obj';
				}
				// no leading Hash required?
				if ( $this->parserHookOptions & self::FH_NO_HASH ) {
					$flags = $flags | SFH_NO_HASH;
				}
				
				$parser->setFunctionHook(
					$name,
					[ new ParserHookCaller( $className, $function ), $callerFunction ],
					$flags
				);
			}
		}

		return true;
	}

	/**
	 * Returns an array with the names for the parser hook.
	 *
	 * @since 0.4
	 *
	 * @return array
	 */
	protected function getNames() {
		$names = $this->getName();

		if ( !is_array( $names ) ) {
			$names = [ $names ];
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
	 * @return boolean
	 */
	public function magic( array &$magicWords, $langCode ) {
		foreach ( $this->getNames() as $name ) {
			$magicWords[$name] = [ 0, $name ];
		}

		return true;
	}

	/**
	 * Handler for rendering the tag hook registered by Parser::setHook()
	 *
	 * @since 0.4
	 *
	 * @param mixed $input string or null
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

		// If there is a first default parameter, set the tag contents as its value.
		if ( !is_null( $defaultParam ) && !is_null( $input ) ) {
			$args[$defaultParam] = $input;
		}

		return $this->validateAndRender( $args, self::TYPE_TAG );
	}

	/**
	 * Handler for rendering the function hook registered by Parser::setFunctionHook()
	 *
	 * @since 0.4
	 *
	 * @param Parser $parser
	 * ... further arguments ...
	 *
	 * @return array
	 */
	public function renderFunction( Parser $parser /*, n args */ ) {
		$args = func_get_args();
		
		$this->parser = array_shift( $args );
								
		$output = $this->validateAndRender( $args, self::TYPE_FUNCTION );
		$options = $this->getFunctionOptions();

		if ( array_key_exists( 'isHTML', $options ) && $options['isHTML'] ) {
			/** @ToDo: FIXME: Is this really necessary? The same thing is propably going to
			 *                happen in Parser::braceSubstitution() if 'isHTML' is set!
			 *  @ToDo: other options besides 'isHTML' like 'noparse' are ignored here!
			 */
			return $this->parser->insertStripItem( $output, $this->parser->mStripState );
		}

		return array_merge(
			[ $output ],
			$options
		);
	}
	
	/**
	 * Handler for rendering the function hook registered by Parser::setFunctionHook() together
	 * with object style arguments (SFH_OBJECT_ARGS flag).
	 *
	 * @since 0.4.13
	 * 
	 * @param Parser $parser
	 * @param PPFrame $frame
	 * @param type $args
	 * @return array 
	 */
	public function renderFunctionObj( Parser $parser, PPFrame $frame, $args ) {
		$this->frame = $frame;
		
		// create non-object args for old style 'renderFunction()'
		$oldStyleArgs = [ $parser ];
		
		foreach( $args as $arg ) {
			$oldStyleArgs[] = trim( $frame->expand( $arg ) );
		}
		
		/*
		 * since we can't validate un-expandet arguments, we just go on with old-style function
		 * handling from here. Only advantage is that we have $this->frame set properly.
		 */
		return call_user_func_array( [ $this, 'renderFunction' ], $oldStyleArgs );
	}

	/**
	 * Returns the parser function otpions.
	 *
	 * @since 0.4
	 *
	 * @return array
	 */
	protected function getFunctionOptions() {
		return [];
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
		$names = $this->getNames();
		$this->validator = Processor::newDefault();
		$this->validator->getOptions()->setName( $names[0] );

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
		}
		else {
			$output = $this->renderFatalError( $fatalError );
		}

		return $output;
	}

	/**
	 * Returns the ProcessingError objects for the errors and warnings that should be displayed.
	 *
	 * @since 0.4
	 *
	 * @return array of array of ProcessingError
	 */
	protected function getErrorsToDisplay() {
		$errors = [];
		$warnings = [];

		foreach ( $this->validator->getErrors() as $error ) {
			// Check if the severity of the error is high enough to display it.
			if ( $error->shouldShow() ) {
				$errors[] = $error;
			}
			elseif ( $error->shouldWarn() ) {
				$warnings[] = $error;
			}
		}

		return [ 'errors' => $errors, 'warnings' => $warnings ];
	}

	/**
	 * Creates and returns the output when a fatal error prevent regular rendering.
	 *
	 * @since 0.4
	 *
	 * @param ProcessingError $error
	 *
	 * @return string
	 */
	protected function renderFatalError( ProcessingError $error ) {
		return '<div><span class="errorbox">' .
			wfMessage( 'validator-fatal-error', $error->getMessage() )->parse() .
			'</span></div><br /><br />';
	}

	// TODO: replace render errors functionality

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
		return [];
	}

	public function getParamDefinitions( $type = self::TYPE_FUNCTION ) {
		return $this->getParameterInfo( $type );
	}

	/**
	 * Returns the list of default parameters. These parameters can be used as
	 * unnamed parameters where it is not necessary to use the name and the '=' as
	 * long as there is no '=' within the value.
	 * It is possible to define that a parameter should not have a named fallback.
	 * Therefore the information has to be returnd as sub-array with the parameter
	 * name as first and Validator::PARAM_UNNAMED as second value. Parameter using
	 * this option must be set first, before any unnamed parameter in the same order
	 * as set here. All parameters defined before the last parameter making use of
	 * Validator::PARAM_UNNAMED will automatically be populated with this option.
	 * 
	 * Override in deriving classes to add default parameters.
	 *
	 * @since 0.4
	 *
	 * @param integer $type Item of the ParserHook::TYPE_ enum
	 *
	 * @return array
	 */
	protected function getDefaultParameters( $type ) {
		return [];
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
		return [
			'names' => $this->getNames(),
			'description' => $this->getDescription(),
			'message' => $this->getMessage(),
			'parameters' => ParamDefinition::getCleanDefinitions( $this->getParameterInfo( $type ) ),
			'defaults' => $this->getDefaultParameters( $type ),
		];
	}

	/**
	 * Returns a description for the parser hook, or false when there is none.
	 * Override in deriving classes to add a message.
	 *
	 * @since 0.4.3
	 * @deprecated since 1.0
	 *
	 * @return mixed string or false
	 */
	public function getDescription() {
		$msg = $this->getMessage();
		return $msg === false ? false : wfMessage( $msg )->plain();
	}
	
	/**
	 * Returns a description message for the parser hook, or false when there is none.
	 * Override in deriving classes to add a message.
	 * 
	 * @since 0.4.10
	 * 
	 * @return mixed string or false
	 */
	public function getMessage() {
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
				$text,
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
 * @author Daniel Werner
 */
class ParserHookCaller {
	
	protected $class;
	protected $method;
	
	function __construct( $class, $method ) {
		$this->class = $class;
		$this->method = $method;
	}
	
	/*
	 * See Parser::braceSubstitution() and Parser::extensionSubstitution() for details about
	 * how the Parser object and other parameters are being passed. Therefore for function
	 * hooks &$parser fullfills the same purpos as $parser for the tag hook.
	 * functionTagHook (!) calls (if implemented at a later time) are more like function hooks,
	 * meaning, they would require &$parser as well.
	 */
	
	public function runTagHook( $input, array $args, Parser $parser, PPFrame $frame = null  ) {
		$obj = new $this->class();		
		return $obj->{$this->method}( $input, $args, $parser, $frame );
	}
	
	public function runFunctionHook( Parser $parser /*, n args */ ) {
		$args = func_get_args();
		$args[0] = $parser; // with '&' becaus call_user_func_array is being used
		return call_user_func_array( [ new $this->class(), $this->method ], $args );
	}
	
	public function runFunctionHookObj( Parser $parser, PPFrame $frame, array $args ) {
		$obj = new $this->class();		
		return $obj->{$this->method}( $parser, $frame, $args );
	}

}