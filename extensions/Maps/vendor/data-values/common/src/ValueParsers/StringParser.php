<?php

namespace ValueParsers;

use DataValues\StringValue;
use InvalidArgumentException;
use ValueParsers\Normalizers\NullStringNormalizer;
use ValueParsers\Normalizers\StringNormalizer;

/**
 * Implementation of the ValueParser interface for StringValues.
 *
 * @since 0.3
 *
 * @licence GNU GPL v2+
 * @author Daniel Kinzler
 */
class StringParser implements ValueParser {

	/**
	 * @var StringNormalizer
	 */
	private $normalizer;

	/**
	 * @param StringNormalizer $normalizer
	 */
	public function __construct( StringNormalizer $normalizer = null ) {
		$this->normalizer = $normalizer ?: new NullStringNormalizer();
	}

	/**
	 * @see ValueParser::parse
	 *
	 * @param string $value
	 *
	 * @throws InvalidArgumentException if $value is not a string
	 * @return StringValue
	 */
	public function parse( $value ) {
		if ( !is_string( $value ) ) {
			throw new InvalidArgumentException( 'Parameter $value must be a string' );
		}

		$value = $this->normalizer->normalize( $value );
		return new StringValue( $value );
	}

}
