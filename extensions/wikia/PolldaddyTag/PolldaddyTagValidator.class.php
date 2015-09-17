<?php

class PolldaddyTagValidator {

	public static function validateAttributes( $params ) {
		return array_key_exists( 'id', $params ) && !empty( $params['id'] );
	}
}
