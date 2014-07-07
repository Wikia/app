<?php
/**
 * Cache for stable version outputs of the PHP parser
 */
class FRParserCacheStable extends ParserCache {
	/**
	 * Get an instance of this object
	 */
	public static function singleton() {
		static $instance;
		if ( !isset( $instance ) ) {
			global $parserMemc;
			$instance = new self( $parserMemc );
		}
		return $instance;
	}

	/**
	 * Like ParserCache::getParserOutputKey() with stable-pcache instead of pcache
	 * @param $article Article
	 * @param $hash string
	 * @return mixed|string
	 */
	protected function getParserOutputKey( $article, $hash ) {
		$key = parent::getParserOutputKey( $article, $hash ); // call super!
		return str_replace( ':pcache:', ':stable-pcache:', $key );
	}

	/**
	 * Like ParserCache::getOptionsKey() with stable-pcache instead of pcache
	 * @param $article Article
	 * @return mixed|string
	 */
	protected function getOptionsKey( $article ) {
		$key = parent::getOptionsKey( $article ); // call super!
		return str_replace( ':pcache:', ':stable-pcache:', $key );
	}
}
