<?php

namespace ValueParsers;

use InvalidArgumentException;

/**
 * A generic value parser that forwards parsing to a list of other value parsers and returns the
 * result of the first parse attempt that succeeded.
 *
 * @since 0.3
 *
 * @licence GNU GPL v2+
 * @author Thiemo Mättig
 */
class DispatchingValueParser implements ValueParser {

	/**
	 * @var ValueParser[]
	 */
	private $parsers;

	/**
	 * @see ParseException::getExpectedFormat
	 *
	 * @var string
	 */
	private $format;

	/**
	 * @param ValueParser[] $parsers
	 * @param string $format An identifier describing the expected format of the values to parse.
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( array $parsers, $format ) {
		if ( empty( $parsers ) ) {
			throw new InvalidArgumentException( '$parsers must be a non-empty array' );
		}

		if ( !is_string( $format ) || $format === '' ) {
			throw new InvalidArgumentException( '$format must be a non-empty string' );
		}

		$this->parsers = $parsers;
		$this->format = $format;
	}

	/**
	 * @param mixed $value
	 *
	 * @throws ParseException
	 * @return mixed
	 */
	public function parse( $value ) {
		foreach ( $this->parsers as $parser ) {
			try {
				return $parser->parse( $value );
			} catch ( ParseException $ex ) {
				continue;
			}
		}

		throw new ParseException(
			'The value is not recognitzed by the configured parsers',
			$value,
			$this->format
		);
	}

}
