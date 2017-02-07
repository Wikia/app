<?php

namespace Deserializers\Exceptions;

/**
 * Indicates the objectType specified in the serialization is not supported by a deserializer.
 *
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class UnsupportedTypeException extends DeserializationException {

	protected $unsupportedType;

	/**
	 * @param mixed $unsupportedType
	 * @param string $message
	 * @param \Exception $previous
	 */
	public function __construct( $unsupportedType, $message = '', \Exception $previous = null ) {
		$this->unsupportedType = $unsupportedType;

		parent::__construct( $message, $previous );
	}

	/**
	 * @return mixed
	 */
	public function getUnsupportedType() {
		return $this->unsupportedType;
	}

}
