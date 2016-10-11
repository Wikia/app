<?php

namespace Serializers;

/**
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface DispatchableSerializer extends Serializer {

	/**
	 * @since 3.0
	 *
	 * @param mixed $object
	 *
	 * @return boolean
	 */
	public function isSerializerFor( $object );

}
