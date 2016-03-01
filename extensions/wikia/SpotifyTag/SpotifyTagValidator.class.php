<?php

class SpotifyTagValidator {

	public static function validateAttributes( $params ) {
		return array_key_exists( 'uri', $params ) && !empty( $params['uri'] );
	}
}
