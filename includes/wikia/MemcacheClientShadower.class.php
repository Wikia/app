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
		$shadow = $this->shadow->get( $key );
		$result = parent::get( $key );

		if ( $shadow != $result ) {
			$this->get_sock( $key, $host );
			$this->shadow->get_sock($key, $shadowHost);
			Wikia::log( __METHOD__, false, "$key {$host}/{$shadowHost}", true );
		}

		return $result;
	}

	public function set( $key, $value, $exp = 0 ) {
		$result = parent::set( $key, $value, $exp );

		if ( $result ) {
			$this->shadow->_dupe_cache[ $key ] = $value;
		}

		return $result;
	}
}