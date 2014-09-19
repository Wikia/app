<?php
/**
 * MemcacheClientShadower
 *
 * shadows a memcache client to ensure consistency between get methods
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

class MemcacheClientShadower extends MemCachedClientforWiki {
	private $shadow;

	public function __construct( $args ) {
		parent::__construct( $args );
		$this->shadow = new MemcacheMoxiCluster( $args );
	}

	public function get( $key ) {
		if ( mt_rand( 1, 100 ) < 20 ) {
			$shadow = Wikia\Measurements\Time::run( get_class( $this->shadow ) . '/' . __FUNCTION__, function () use ( $key ) {
				return $this->shadow->get( $key );
			} );
			$result = Wikia\Measurements\Time::run( 'MemCachedClientforWiki/' . __FUNCTION__, function () use ( $key ) {
				return parent::get( $key );
			} );
		} else {
			$shadow = $this->shadow->get( $key );
			$result = parent::get( $key );
		}

		if ( $shadow != $result ) {
			$this->get_sock( $key, $host );
			$this->shadow->get_sock( $key, $shadowHost );
			Wikia::log( __METHOD__, false, "$key {$host}/{$shadowHost}", true );
		}

		return $result;
	}

	public function set( $key, $value, $exp = 0 ) {
		if ( mt_rand( 1, 100 ) < 20 && $exp != 0) {
			$shadowKey = $key . ":moxi_shadow";

			Wikia\Measurements\Time::run( get_class( $this->shadow ) . '/' . __FUNCTION__, function () use ( $shadowKey, $value, $exp ) {
				return $this->shadow->set( $shadowKey, $value, $exp );
			} );

			$result = Wikia\Measurements\Time::run( 'MemCachedClientforWiki/' . __FUNCTION__, function () use ( $key, $value, $exp ) {
				return parent::set( $key, $value, $exp );
			} );
		} else {
			$result = parent::set( $key, $value, $exp );
		}

		if ( $result ) {
			$this->shadow->_dupe_cache[ $key ] = $value;
		}

		return $result;
	}
}