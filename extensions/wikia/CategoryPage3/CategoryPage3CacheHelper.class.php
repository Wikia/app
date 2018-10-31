<?php

class CategoryPage3CacheHelper {
	const EXPIRATION_TIME = 60 * 60;

	/**
	 * Can be used as a part of memcache key
	 *
	 * @param Title $title
	 * @return bool|Object
	 */
	public static function getTouched( Title $title ) {
		global $wgMemc;
		return $wgMemc->get( static::getKey( $title ) );
	}

	public static function setTouched( Title $title ) {
		global $wgMemc;
		$wgMemc->set(
			static::getKey( $title ),
			time() . rand( 0, 9999 ),
			static::EXPIRATION_TIME
		);
	}

	public static function getSurrogateKey( Title $title ): string {
		return  Wikia::surrogateKey( 'category-page3-' . $title->getArticleID() );
	}

	private static function getKey( Title $title ) {
		$key = wfMemcKey( 'category_page3_touched', md5( $title->getDBKey() ) );
		return $key;
	}
}
