<?php

namespace ParamProcessor;

use Exception;

use ValueParsers\ValueParser;
use ValueParsers\NullParser;

use ValueValidators\ValueValidator;
use ValueValidators\NullValidator;

/**
 * Parameter definition.
 * Specifies what kind of values are accepted, how they should be validated,
 * how they should be formatted, what their dependencies are and how they should be described.
 *
 * Try to avoid using this interface outside of ParamProcessor for anything else then defining parameters.
 * In particular, do not derive from this class to implement methods such as formatValue.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ParamDefinition implements IParamDefinition {

	/**
	 * Indicates whether parameters that are provided more then once  should be accepted,
	 * and use the first provided value, or not, and generate an error.
	 *
	 * @since 1.0
	 *
	 * @var boolean
	 */
	public static $acceptOverriding = false;

	/**
	 * Indicates whether parameters not found in the criteria list
	 * should be stored in case they are not accepted. The default is false.
	 *
	 * @since 1.0
	 *
	 * @var boolean
	 */
	public static $accumulateParameterErrors = false;

	/**
	 * Indicates if the parameter value should trimmed during the clean process.
	 *
	 * @since 1.0
	 *
	 * @var boolean|null
	 */
	protected $trimValue = null;

	/**
	 * Indicates if the parameter manipulations should be applied to the default value.
	 *
	 * @since 1.0
	 *
	 * @var boolean
	 */
	protected $applyManipulationsToDefault = true;

	/**
	 * Dependency list containing parameters that need to be handled before this one.
	 *
	 * @since 1.0
	 *
	 * @var array
	 */
	protected $dependencies = array();

	/**
	 * The default value for the parameter, or null when the parameter is required.
	 *
	 * @since 1.0
	 *
	 * @var mixed
	 */
	protected $default;

	/**
	 * The main name of the parameter.
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * @since 1.0
	 * @var boolean
	 */
	protected $isList;

	/**
	 * @since 1.0
	 * @var string
	 */
	protected $delimiter = ',';

	/**
	 * List of aliases for the parameter name.
	 *
	 * @since 1.0
	 *
	 * @var array
	 */
	protected $aliases = array();

	/**
	 * A message that acts as description for the parameter or false when there is none.
	 * Can be obtained via getMessage and set via setMessage.
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	protected $message = 'validator-message-nodesc';

	/**
	 * Original array definition of the parameter
	 *
	 * @since 1.0
	 *
	 * @var array
	 */
	protected $options = array();

	/**
	 * @since 1.0
	 *
	 * @var ValueParser|null
	 */
	protected $parser = null;

	/**
	 * @since 1.0
	 *
	 * @var ValueValidator|null
	 */
	protected $validator = null;

	/**
	 * @since 0.1
	 *
	 * @var callable|null
	 */
	protected $validationFunction = null;

	/**
	 * @since 0.1
	 *
	 * @var string
	 */
	protected $type;

	/**
	 * Constructor.
	 *
	 * @since 1.0
	 *
	 * @param string $type
	 * @param string $name
	 * @param mixed $default Use null for no default (which makes the parameter required)
	 * @param string $message
	 * @param boolean $isList
	 */
	public function __construct( $type, $name, $default = null, $message = null, $isList = false ) {
		$this->type = $type;
		$this->name = $name;
		$this->default = $default;
		$this->message = $message;
		$this->isList = $isList;

		$this->postConstruct();
	}

	/**
	 * Allows deriving classed to do additional stuff on instance construction
	 * without having to get and pass all the constructor arguments.
	 *
	 * @since 1.0
	 */
	protected function postConstruct() {

	}

	/**
	 * @see IParamDefinition::trimDuringClean
	 *
	 * @since 1.0
	 *
	 * @return boolean|null
	 */
	public function trimDuringClean() {
		return $this->trimValue;
	}

	/**
	 * @see IParamDefinition::getAliases
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public function getAliases() {
		return $this->aliases;
	}

	/**
	 * @see IParamDefinition::hasAlias
	 *
	 * @since 1.0
	 *
	 * @param string $alias
	 *
	 * @return boolean
	 */
	public function hasAlias( $alias ) {
		return in_array( $alias, $this->getAliases() );
	}

	/**
	 * @see IParamDefinition::hasDependency
	 *
	 * @since 1.0
	 *
	 * @param string $dependency
	 *
	 * @return boolean
	 */
	public function hasDependency( $dependency ) {
		return in_array( $dependency, $this->getDependencies() );
	}

	/**
	 * Returns the list of allowed values, or false if there is no such restriction.
	 *
	 * @since 1.0
	 *
	 * @return array|boolean false
	 */
	public function getAllowedValues() {
		$allowedValues = array();

		// TODO: properly implement this
		$this->validator->setOptions( $this->options );

		if ( $this->validator !== null && method_exists( $this->validator, 'getWhitelistedValues' ) ) {
			$allowedValues = $this->validator->getWhitelistedValues();

			if ( $allowedValues === false ) {
				$allowedValues = array();
			}
		}

		return $allowedValues;
	}

	/**
	 * @see IParamDefinition::setDefault
	 *
	 * @since 1.0
	 *
	 * @param mixed $default
	 * @param boolean $manipulate Should the default be manipulated or not? Since 0.4.6.
	 */
	public function setDefault( $default, $manipulate = true ) {
		$this->default = $default;
		$this->setDoManipulationOfDefault( $manipulate );
	}

	/**
	 * @see IParamDefinition::getDefault
	 *
	 * @since 1.0
	 *
	 * @return mixed
	 */
	public function getDefault() {
		return $this->default;
	}

	/**
	 * @see IParamDefinition::getMessage
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @see IParamDefinition::setMessage
	 *
	 * @since 1.0
	 *
	 * @param string $message
	 */
	public function setMessage( $message ) {
		$this->message = $message;
	}

	/**
	 * @see IParamDefinition::setDoManipulationOfDefault
	 *
	 * @since 1.0
	 *
	 * @param boolean $doOrDoNotThereIsNoTry
	 */
	public function setDoManipulationOfDefault( $doOrDoNotThereIsNoTry ) {
		$this->applyManipulationsToDefault = $doOrDoNotThereIsNoTry;
	}

	/**
	 * @see IParamDefinition::shouldManipulateDefault
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function shouldManipulateDefault() {
		return $this->applyManipulationsToDefault;
	}

	/**
	 * @see IParamDefinition::addAliases
	 *
	 * @since 1.0
	 *
	 * @param mixed $aliases string or array of string
	 */
	public function addAliases( $aliases ) {
		$args = func_get_args();
		$this->aliases = array_merge( $this->aliases, is_array( $args[0] ) ? $args[0] : $args );
	}

	/**
	 * @see IParamDefinition::addDependencies
	 *
	 * @since 1.0
	 *
	 * @param mixed $dependencies string or array of string
	 */
	public function addDependencies( $dependencies ) {
		$args = func_get_args();
		$this->dependencies = array_merge( $this->dependencies, is_array( $args[0] ) ? $args[0] : $args );
	}

	/**
	 * @see IParamDefinition::getName
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns a message key for a message describing the parameter type.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getTypeMessage() {
		$message = 'validator-type-' . $this->getType();

		if ( $this->isList() ) {
			$message .= '-list';
		}

		return $message;
	}

	/**
	 * @see IParamDefinition::getDependencies
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public function getDependencies() {
		return $this->dependencies;
	}

	/**
	 * @see IParamDefinition::isRequired
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function isRequired() {
		return is_null( $this->default );
	}

	/**
	 * @see IParamDefinition::isList
	 *
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function isList() {
		return $this->isList;
	}

	/**
	 * @see IParamDefinition::getDelimiter
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getDelimiter() {
		return $this->delimiter;
	}

	/**
	 * @see IParamDefinition::setDelimiter
	 *
	 * @since 1.0
	 *
	 * @param $delimiter string
	 */
	public function setDelimiter( $delimiter ) {
		$this->delimiter = $delimiter;
	}

	/**
	 * @see IParamDefinition::setArrayValues
	 *
	 * @since 1.0
	 *
	 * @param array $param
	 */
	public function setArrayValues( array $param ) {
		if ( array_key_exists( 'aliases', $param ) ) {
			$this->addAliases( $param['aliases'] );
		}

		if ( array_key_exists( 'dependencies', $param ) ) {
			$this->addDependencies( $param['dependencies'] );
		}

		if ( array_key_exists( 'trim', $param ) ) {
			$this->trimValue = $param['trim'];
		}

		if ( array_key_exists( 'delimiter', $param ) ) {
			$this->delimiter = $param['delimiter'];
		}

		if ( array_key_exists( 'manipulatedefault', $param ) ) {
			$this->setDoManipulationOfDefault( $param['manipulatedefault'] );
		}

		$this->options = $param;
	}

	/**
	 * @see IParamDefinition::validate
	 *
	 * @since 1.0
	 * @deprecated
	 *
	 * @param $param IParam
	 * @param $definitions array of IParamDefinition
	 * @param $params array of IParam
	 * @param Options $options
	 *
	 * @return array|true
	 *
	 * TODO: return error list (ie Status object)
	 */
	public function validate( IParam $param, array $definitions, array $params, Options $options ) {
		if ( $this->isList() ) {
			$valid = true;
			$values = $param->getValue();

			foreach ( $values as $value ) {
				// TODO: restore not bailing out at one error in list but filtering on valid
				$valid = $this->validateValue( $value, $param, $definitions, $params, $options );

				if ( !$valid ) {
					break;
				}
			}

			return $valid && $this->validateList( $param, $definitions, $params, $options );
		}
		else {
			$valid = $this->validateValue( $param->getValue(), $param, $definitions, $params, $options );

			return $valid ? true : array( new ProcessingError( 'Error' ) ); // TODO
		}
	}

	/**
	 * @see IParamDefinition::format
	 *
	 * @since 1.0
	 * @deprecated
	 *
	 * @param IParam $param
	 * @param IParamDefinition[] $definitions
	 * @param IParam[] $params
	 */
	public function format( IParam $param, array &$definitions, array $params ) {
		if ( $this->isList() ) {
			$values = $param->getValue();

			foreach ( $values as &$value ) {
				$value = $this->formatValue( $value, $param, $definitions, $params );
			}

			$param->setValue( $values );
			$this->formatList( $param, $definitions, $params );
		}
		else {
			$param->setValue( $this->formatValue( $param->getValue(), $param, $definitions, $params ) );
		}

		// deprecated, deriving classes should not add array-definitions to the list
		$definitions = self::getCleanDefinitions( $definitions );

		if ( array_key_exists( 'post-format', $this->options ) ) {
			$param->setValue( call_user_func( $this->options['post-format'], $param->getValue() ) );
		}
	}

	/**
	 * Formats the parameters values to their final result.
	 *
	 * @since 1.0
	 * @deprecated
	 *
	 * @param $param IParam
	 * @param $definitions array of IParamDefinition
	 * @param $params array of IParam
	 */
	protected function formatList( IParam $param, array &$definitions, array $params ) {
		// TODO
	}

	/**
	 * Formats the parameter value to it's final result.
	 *
	 * @since 1.0
	 * @deprecated
	 *
	 * @param mixed $value
	 * @param IParam $param
	 * @param IParamDefinition[] $definitions
	 * @param IParam[] $params
	 *
	 * @return mixed
	 */
	protected function formatValue( $value, IParam $param, array &$definitions, array $params ) {
		return $value;
		// No-op
	}

	/**
	 * Returns a cleaned version of the list of parameter definitions.
	 * This includes having converted all supported definition types to
	 * ParamDefinition classes and having all keys set to the names of the
	 * corresponding parameters.
	 *
	 * @since 1.0
	 *
	 * @param IParamDefinition[] $definitions
	 *
	 * @return IParamDefinition[]
	 * @throws Exception
	 */
	public static function getCleanDefinitions( array $definitions ) {
		$cleanList = array();

		foreach ( $definitions as $key => $definition ) {
			if ( is_array( $definition ) ) {
				if ( !array_key_exists( 'name', $definition ) && is_string( $key ) ) {
					$definition['name'] = $key;
				}

				$definition = ParamDefinitionFactory::singleton()->newDefinitionFromArray( $definition );
			}

			if ( !( $definition instanceof IParamDefinition ) ) {
				throw new Exception( '$definition not an instance of IParamDefinition' );
			}

			$cleanList[$definition->getName()] = $definition;
		}

		return $cleanList;
	}

	/**
	 * @see IParamDefinition::getType
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @see IParamDefinition::getValueParser
	 *
	 * @since 1.0
	 *
	 * @return ValueParser
	 */
	public function getValueParser() {
		if ( $this->parser === null ) {
			$this->parser = new NullParser();
		}

		return $this->parser;
	}

	/**
	 * @see IParamDefinition::getValueValidator
	 *
	 * @since 1.0
	 *
	 * @return ValueValidator
	 */
	public function getValueValidator() {
		if ( $this->validator === null ) {
			$this->validator = new NullValidator();
		}

		return $this->validator;
	}

	/**
	 * @see IParamDefinition::setValueParser
	 *
	 * @since 1.0
	 *
	 * @param ValueParser $parser
	 */
	public function setValueParser( ValueParser $parser ) {
		$this->parser = $parser;
	}

	/**
	 * @see IParamDefinition::setValueValidator
	 *
	 * @since 1.0
	 *
	 * @param ValueValidator $validator
	 */
	public function setValueValidator( ValueValidator $validator ) {
		$this->validator = $validator;
	}

	/**
	 * @see IParamDefinition::setValidationCallback
	 *
	 * @since 1.0
	 *
	 * @param callable $validationFunction
	 */
	public function setValidationCallback( /* callable */ $validationFunction ) {
		$this->validationFunction = $validationFunction;
	}

	/**
	 * @see IParamDefinition::getValidationCallback
	 *
	 * @since 1.0
	 *
	 * @return callable|null
	 */
	public function getValidationCallback() {
		return $this->validationFunction;
	}

	/**
	 * @since 0.1
	 *
	 * @return array
	 */
	public function getOptions() {
		return $this->options;
	}

}
