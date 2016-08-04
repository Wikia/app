<?php

namespace ValueParsers\Normalizers;

use InvalidArgumentException;

/**
 * Interface for string normalization.
 *
 * @since 0.3
 *
 * @license GPL 2+
 * @author Daniel Kinzler
 */
interface StringNormalizer {

	/**
	 * @param string $value
	 *
	 * @throws InvalidArgumentException if $value is not a string
	 * @return string the normalized value
	 */
	public function normalize( $value );

}
