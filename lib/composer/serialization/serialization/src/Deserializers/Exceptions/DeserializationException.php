<?php

namespace Deserializers\Exceptions;

/**
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DeserializationException extends \RuntimeException {

	public function __construct( $message = '', \Exception $previous = null ) {
		parent::__construct( $message, 0, $previous );
	}

}
