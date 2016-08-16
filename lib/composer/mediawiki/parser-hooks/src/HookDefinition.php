<?php

namespace ParserHooks;

use InvalidArgumentException;
use ParamProcessor\ParamDefinition;

/**
 * Definition of a parser hooks signature.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class HookDefinition {

	protected $names;
	protected $parameters;
	protected $defaultParameters;

	/**
	 * @since 1.0
	 *
	 * @param string|string[] $names
	 * The name or the names of your parser hook.
	 * 
	 * @param ParamDefinition[] $parameters
	 * The definitions of the parameters your parser hook accepts.
	 * For more information on ParamDefinition, see the ParamProcessor
	 * documentation at https://github.com/JeroenDeDauw/ParamProcessor
	 * 
	 * @param string|string[] $defaultParameters
	 * An ordered list of parameter names, denoting which parameters are the defaults.
	 * If the user specifies a value without indicating the parameter name, the
	 * first default parameter is used.
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( $names, array $parameters = array(), $defaultParameters = array() ) {
		$this->setNames( $names );
		$this->parameters = $parameters;
		$this->setDefaultParams( $defaultParameters );
	}

	protected function setNames( $names ) {
		$this->names = $this->getStringList( $names );

		if ( $this->names === array() ) {
			throw new InvalidArgumentException( 'The list of names cannot be empty' );
		}
	}

	protected function setDefaultParams( $defaultParameters ) {
		$this->defaultParameters = $this->getStringList( $defaultParameters );
	}

	protected function getStringList( $strings ) {
		if ( !is_string( $strings ) && !is_array( $strings ) ) {
			throw new InvalidArgumentException( 'Argument needs to be an array or a string' );
		}

		$strings = (array)$strings;

		$this->assertAreStrings( $strings );

		return $strings;
	}

	protected function assertAreStrings( array $strings ) {
		foreach ( $strings as $string ) {
			if ( !is_string( $string ) ) {
				throw new InvalidArgumentException( 'All elements must be strings' );
			}
		}
	}

	/**
	 * Returns the names of the hook. This returned
	 * array contains at least one name.
	 *
	 * @since 1.0
	 *
	 * @return string[]
	 */
	public function getNames() {
		return $this->names;
	}

	/**
	 * Returns the definitions of the parameters that the hook accepts.
	 *
	 * @since 1.0
	 *
	 * @return ParamDefinition[]
	 */
	public function getParameters() {
		return $this->parameters;
	}

	/**
	 * Returns an ordered list of parameter names for parameters
	 * that can be provided without specifying a name. The first
	 * parameter in the list is the one to be used for the first
	 * unnamed parameter encountered.
	 *
	 * @since 1.0
	 *
	 * @return string[]
	 */
	public function getDefaultParameters() {
		return $this->defaultParameters;
	}

}
