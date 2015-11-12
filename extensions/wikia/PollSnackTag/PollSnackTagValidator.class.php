<?php

class PollSnackTagValidator {

	public static function validateAttributes( $params ) {
		return array_key_exists( 'hash', $params ) && !empty( $params['hash'] );
	}
}
