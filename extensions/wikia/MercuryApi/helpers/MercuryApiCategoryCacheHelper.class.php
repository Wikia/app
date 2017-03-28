<?php

/**
 * We use this class to easily invalidate all category objects in cache related to a particular
 * page. The way to go is to call getTouched() and incorporate the resulting number to
 * the key used for getting the actual value from cache.
 *
 * On modification call setTouched to cause the cache to be invalidated.
 *
 * FIXME this is unnecessarily complicated
 * It would be better (simpler) to cache category data on Varnish and use surrogate keys to purge the responses.
 * We can't do this now, because Mercury uses icache to get the data from API.
 * Our icache doesn't support the surrogate keys at this point of time, see OPS-10115
 */
class MercuryApiCategoryCacheHelper {

	const CACHE_TTL = 60 * 60 * 24;
	const CACHE_VERSION = 1;

	public static function getTouched( string $categoryDBKey ) {
		global $wgMemc;
		return $wgMemc->get( self::getTouchedKey( $categoryDBKey ) );
	}

	public static function setTouched( string $categoryDBKey ) {
		global $wgMemc;
		$wgMemc->set( self::getTouchedKey( $categoryDBKey ), time() . rand( 0, 9999 ), self::CACHE_TTL );
	}

	private static function getTouchedKey( string $categoryDBKey ) {
		$key = wfMemcKey( 'mercury_category_touched', md5( $categoryDBKey ), self::CACHE_VERSION );
		return $key;
	}

	public static function getCacheKeyForMethod( string $categoryDBKey, string $internalKey ) {
		return wfMemcKey(
			__CLASS__,
			$internalKey,
			self::CACHE_VERSION,
			md5( $categoryDBKey ),
			self::getTouched( $categoryDBKey )
		);
	}
}
