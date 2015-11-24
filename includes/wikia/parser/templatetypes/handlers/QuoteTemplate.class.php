<?php

class QuoteTemplate {

	const LENGTH_CHECK_MULTIPLY = 2;
	const QUOTES_KEYS = [ 'quotation', 'author', 'subject' ];

	public static function execute( $args ) {
		//render templates
	}

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

		// we dont want to reverse if sizes are close
		$sized = $first * self::LENGTH_CHECK_MULTIPLY < $max ? array_reverse( $filtered, true ) : $filtered;
		$size = min( count( $sized ), count( self::QUOTES_KEYS ) );

		return array_combine( array_slice( self::QUOTES_KEYS, 0, $size ), array_slice( $sized, 0, $size ) );
	}
}
