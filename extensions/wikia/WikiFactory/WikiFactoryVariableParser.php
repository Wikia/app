<?php

declare( strict_types = 1 );

class WikiFactoryVariableParser {
	/** @var string $varType */
	private $varType;

	public function __construct( string $varType ) {
		$this->varType = $varType;
	}

	/**
	 * @param mixed $value
	 * @return array|bool|int|string
	 * @throws WikiFactoryVariableParseException
	 */
	public function transformValue( $value ) {
		switch ( $this->varType ) {
			case 'boolean':
				return $this->handleBoolean( $value );
				break;
			case 'integer':
				return $this->handleInteger( $value );
				break;
			case 'array':
			case 'struct':
			case 'hash':
				return $this->handleArrayType( $value );
				break;
			default:
				return $value;
		}
	}

	/**
	 * @param $value
	 * @return bool
	 * @throws WikiFactoryVariableParseException
	 */
	private function handleBoolean( $value ): bool {
		if ( !is_numeric( $value ) || ( $value != 0 && $value != 1 ) ) {
			throw new WikiFactoryVariableParseException( WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_BOOLEAN );
		}

		return (bool)$value;
	}

	/**
	 * @param $value
	 * @return int
	 * @throws WikiFactoryVariableParseException
	 */
	private function handleInteger( $value ): int {
		if ( !is_numeric( $value ) ) {
			throw new WikiFactoryVariableParseException( WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_INTEGER );
		}

		return (int)$value;
	}

	/**
	 * @param $value
	 * @return array
	 * @throws WikiFactoryVariableParseException
	 */
	private function handleArrayType( $value ): array {
		if ( is_array( $value ) ) {
			return $value;
		}

		$decoded = json_decode( (string)$value, true );

		if ( !$decoded || !is_array( $decoded ) ) {
			throw new WikiFactoryVariableParseException( WikiFactoryVariableParseException::ERROR_VARIABLE_NOT_ARRAY );
		}

		return $decoded;
	}
}
