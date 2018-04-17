<?php

namespace SimpleCache\KeyBuilder;

/**
 * @file
 * @since 0.1
 * @ingroup SimpleCache
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class NamespacedKeyBuilder implements KeyBuilder {

	protected $keyNamespace;

	public function __construct( $keyNamespace ) {
		$this->keyNamespace = $keyNamespace;
	}

	public function buildKey( $keySeed ) {
		return sha1( json_encode( array( $this->keyNamespace, $keySeed ) ) );
	}

}