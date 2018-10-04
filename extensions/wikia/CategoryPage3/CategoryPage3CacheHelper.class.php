<?php

class CategoryPage3CacheHelper {
	const EXPIRATION_TIME = 60 * 60;

	/**
	 * Can be used as a part of memcache key
	 *
	 * @param $title
	 * @return bool|Object
	 */
	public static function getTouched( $title ) {
		global $wgMemc;
		return $wgMemc->get( static::getKey( $title ) );
	}

	public static function setTouched( $title ) {
		global $wgMemc;
		$wgMemc->set(
			static::getKey( $title ),
			time() . rand( 0, 9999 ),
			static::EXPIRATION_TIME
		);
	}

	private static function getKey( Title $title ) {
		$key = wfMemcKey( 'category_page3_touched', md5( $title->getDBKey() ) );
		return $key;
	}
}
