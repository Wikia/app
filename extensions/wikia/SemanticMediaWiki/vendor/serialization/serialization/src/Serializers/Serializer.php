<?php

namespace Serializers;

use Serializers\Exceptions\SerializationException;

/**
 * @since 1.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface Serializer {

	/**
	 * @since 1.0
	 *
	 * @param mixed $object
	 *
	 * @return array|int|string|bool|float A possibly nested structure consisting of only arrays and scalar values
	 * @throws SerializationException
	 */
	public function serialize( $object );

}
