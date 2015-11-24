<?php

class QuoteTemplate {

	const LENGTH_CHECK_MULTIPLY = 2;

	public static function execute( $args ) {
		//render templates
	}

	public static function mapQuoteParams( $params ) {
		$keys = [ 'quotation', 'author', 'subject' ];

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
		$size = min( count( $sized ), count( $keys ) );

		$result = array_combine( array_slice( $keys, 0, $size ), array_slice( $sized, 0, $size ) );

		return $result;
	}
}
