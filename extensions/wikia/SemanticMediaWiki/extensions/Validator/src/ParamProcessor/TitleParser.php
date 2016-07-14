<?php

namespace ParamProcessor;

use ValueParsers\ParseException;
use ValueParsers\StringValueParser;

/**
 * ValueParser that parses the string representation of a MediaWiki Title object.
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class TitleParser extends StringValueParser {

	/**
	 * @see StringValueParser::stringParse
	 *
	 * @since 0.1
	 *
	 * @param string $value
	 *
	 * @return MediaWikiTitleValue
	 * @throws ParseException
	 */
	protected function stringParse( $value ) {
		$value = \Title::newFromText( $value );

		if ( is_null( $value ) ) {
			throw new ParseException( 'Not a title' );
		}

		return new MediaWikiTitleValue( $value );
	}

}