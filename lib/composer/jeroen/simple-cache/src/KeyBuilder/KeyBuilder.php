<?php

namespace SimpleCache\KeyBuilder;

/**
 * Interface for objects that can build a string key given a string seed.
 *
 * @file
 * @since 0.1
 * @ingroup SimpleCache
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
interface KeyBuilder {

	/**
	 * Builds a cache key given a seed value.
	 *
	 * @param string $keySeed
	 *
	 * @return string
	 */
	public function buildKey( $keySeed );

}