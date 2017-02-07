<?php

namespace ParamProcessor;

use Exception;
use OutOfBoundsException;

/**
 * Factory for IParamDefinition implementing objects.
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ParamDefinitionFactory {

	/**
	 * Maps parameter type to handling IParameterDefinition implementing class.
	 *
	 * @since 1.0
	 *
	 * @var array
	 */
	private $typeToClass = [];

	/**
	 * Maps parameter type to its associated components.
	 *
	 * @since 1.0
	 *
	 * @var array
	 */
	private $typeToComponent = [];

	/**
	 * Singleton.
	 *
	 * @since 1.0
	 * @deprecated since 1.0
	 *
	 * @return ParamDefinitionFactory
	 */
	public static function singleton() {
		static $instance = false;

		if ( $instance === false ) {
			$instance = new self();
			$instance->registerGlobals();
		}

		return $instance;
	}

	/**
	 * Registers the parameter types specified in the global $wgParamDefinitions.
	 *
	 * @since 1.0
	 */
	public function registerGlobals() {
		foreach ( $GLOBALS['wgParamDefinitions'] as $type => $data ) {
			if ( is_string( $data ) ) {
				$data = [ 'definition' => $data ];
			}

			$this->registerType( $type, $data );
		}
	}

	/**
	 * Registers a parameter type.
	 *
	 * The type is specified as a string identifier for the type, ie 'boolean',
	 * and an array containing further data. This data currently includes:
	 *
	 * - string-parser:       the parser to use to transform string values
	 *                        This class needs to implement ValueParser. Default: NullParser
	 * - typed-parser:        the parser to use to transform typed PHP values
	 *                        This class needs to implement ValueParser. Default: NullParser
	 * - validator:           the validation object to use
	 *                        This class needs to implement ValueValidator. Default: NullValidator
	 * - validation-callback  a callback to use for validation, called before the ValueValidator
	 *                        This callback needs to return a boolean indicating validity.
	 *
	 * @since 1.0
	 *
	 * @param string $type
	 * @param array $data
	 *
	 * @return boolean Indicates if the type was registered
	 */
	public function registerType( $type, array $data ) {
		if ( array_key_exists( $type, $this->typeToClass ) ) {
			return false;
		}

		$class = array_key_exists( 'definition', $data ) ? $data['definition'] : 'ParamProcessor\ParamDefinition';
		$this->typeToClass[$type] = $class;

		$defaults = [
			'string-parser' => 'ValueParsers\NullParser',
			'typed-parser' => 'ValueParsers\NullParser',
			'validator' => 'ValueValidators\NullValidator',
			'validation-callback' => null,
		];

		$this->typeToComponent[$type] = [];

		foreach ( $defaults as $component => $default ) {
			$this->typeToComponent[$type][$component] = array_key_exists( $component, $data ) ? $data[$component] : $default;
		}

		return true;
	}

	/**
	 * Creates a new instance of a IParamDefinition based on the provided type.
	 *
	 * @since 1.0
	 *
	 * @param string $type
	 * @param string $name
	 * @param mixed $default
	 * @param string $message
	 * @param boolean $isList
	 *
	 * @return IParamDefinition
	 * @throws OutOfBoundsException
	 */
	public function newDefinition( $type, $name, $default, $message, $isList = false ) {
		if ( !array_key_exists( $type, $this->typeToClass ) ) {
			throw new OutOfBoundsException( 'Unknown parameter type "' . $type . '".' );
		}

		$class = $this->typeToClass[$type];

		/**
		 * @var IParamDefinition $definition
		 */
		$definition = new $class(
			$type,
			$name,
			$default,
			$message,
			$isList
		);

		$validator = $this->typeToComponent[$type]['validator'];

		if ( $validator !== '\ValueValidators\NullValidator' ) {
			$definition->setValueValidator( new $validator() );
		}

		$validationCallback = $this->typeToComponent[$type]['validation-callback'];

		if ( $validationCallback !== null ) {
			$definition->setValidationCallback( $validationCallback );
		}

		return $definition;
	}

	/**
	 * Returns the specified component for the provided parameter type.
	 * This method is likely to change in the future in a compat breaking way.
	 *
	 * @since 1.0
	 *
	 * @param string $paramType
	 * @param string $componentType
	 *
	 * @throws Exception
	 * @return mixed
	 */
	public function getComponentForType( $paramType, $componentType ) {
		if ( !array_key_exists( $paramType, $this->typeToComponent ) ) {
			throw new Exception( 'Unknown parameter type "' . $paramType . '".' );
		}

		if ( !array_key_exists( $componentType, $this->typeToComponent[$paramType] ) ) {
			throw new Exception( 'Unknown parameter component type "' . $paramType . '".' );
		}

		return $this->typeToComponent[$paramType][$componentType];
	}

	/**
	 * Construct a new ParamDefinition from an array.
	 *
	 * @since 1.0
	 *
	 * @param array $param
	 * @param bool $getMad
	 *
	 * @return IParamDefinition|false
	 * @throws Exception
	 */
	public function newDefinitionFromArray( array $param, $getMad = true ) {
		foreach ( [ 'name', 'message' ] as $requiredElement ) {
			if ( !array_key_exists( $requiredElement, $param ) ) {
				if ( $getMad ) {
					throw new Exception( 'Could not construct a ParamDefinition from an array without ' . $requiredElement . ' element' );
				}

				return false;
			}
		}

		$parameter = $this->newDefinition(
			array_key_exists( 'type', $param ) ? $param['type'] : 'string',
			$param['name'],
			array_key_exists( 'default', $param ) ? $param['default'] : null,
			$param['message'],
			array_key_exists( 'islist', $param ) ? $param['islist'] : false
		);

		$parameter->setArrayValues( $param );

		return $parameter;
	}

}
