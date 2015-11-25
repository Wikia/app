<?php

class QuoteTemplate {
	const LENGTH_CHECK_MULTIPLIER = 2;
	const QUOTES_KEYS = [ 'quotation', 'author', 'subject' ];
	const QUOTE_TEMPLATE_PATH = 'includes/wikia/parser/templatetypes/templates/quote.mustache';

	/**
	 * @desc renders wikia quote template
	 *
	 * @param array $args
	 * @return string
	 */
	public static function execute( $args ) {
		$params = self::mapQuoteParams( $args );

		return !empty($params) ? \MustacheService::getInstance()->render( self::QUOTE_TEMPLATE_PATH, $params ) : '';
	}

	/**
	 * @desc maps template args to the wikia quote template format
	 *
	 * @param array $params
	 * @return array
	 */
	public static function mapQuoteParams( $params ) {
		$clean = [ ];
		foreach ( $params as $key => $value ) {
			if ( is_numeric( $key ) ) {
				$clean[ $key ] = $value;
			}
		}
		$filtered = !empty( $clean ) ? $clean : $params;

		$first = strlen( reset( $filtered ) );
		$max = array_reduce( $filtered, function ( $max, $item ) {
			return max( $max, strlen( $item ) );
		}, 0 );

		// we don't want to reverse if sizes are close
		$sized = $first * self::LENGTH_CHECK_MULTIPLIER < $max ? array_reverse( $filtered, true ) : $filtered;
		$size = min( count( $sized ), count( self::QUOTES_KEYS ) );

		return array_combine( array_slice( self::QUOTES_KEYS, 0, $size ), array_slice( $sized, 0, $size ) );
	}
}
