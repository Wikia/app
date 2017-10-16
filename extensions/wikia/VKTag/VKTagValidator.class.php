<?php

class VKTagValidator {

	public static function validateAttributes( $params ) {
		return array_key_exists( 'group-id', $params ) && !empty( $params['group-id'] );
	}
}
