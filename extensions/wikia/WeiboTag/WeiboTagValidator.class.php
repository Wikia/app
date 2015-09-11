<?php

class WeiboTagValidator {

	public static function validateAttributes( $params ) {
		return array_key_exists( 'uids', $params ) && !empty( $params['uids'] );
	}
}
