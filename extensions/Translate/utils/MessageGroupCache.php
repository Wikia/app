<?php

class MessageGroupCache {
	protected $group;
	protected $cache;

	// Implementation detail
	protected $code;

	// id or instance of MessageGroup
	public function __construct( $group ) {
		if ( is_object( $group ) ) {
			$this->group = $group->getId();
		} else {
			$this->group = $group;
		}
	}

	public function exists( $code = 'en' ) {
		return file_exists( $this->getCacheFileName( $code ) );
	}

	public function getKeys( $code = 'en' ) {
		$cache = $this->open( $code );
		return unserialize( $cache->get( $this->specialKey( 'keys' ) ) );
	}

	public function getTimestamp( $code = 'en' ) {
		$cache = $this->open( $code );
		return $cache->get( $this->specialKey( 'timestamp' ) );
	}

	public function get( $key, $code = 'en' ) {
		$cache = $this->open( $code );
		return $cache->get( $key );
	}

	public function create( $messages, $code = 'en' ) {
		$this->cache = null; // Needed?

		$cache = CdbWriter::open( $this->getCacheFileName( $code ) );

		$keys = array_keys( $messages );
		$cache->set( $this->specialKey( 'keys' ), serialize( $keys ) );

		foreach ( $messages as $key => $value ) {
			$cache->set( $key, $value );
		}

		$cache->set( $this->specialKey( 'timestamp' ), wfTimestamp() );
		$cache->close();
	}

	protected function open( $code ) {
		if ( $code !== $this->code || !$this->cache ) {
			if ( $this->cache ) $this->cache->close();
			$this->cache = CdbReader::open( $this->getCacheFileName( $code ) );
		}
		return $this->cache;
	}

	protected function getCacheFileName( $code ) {
		global $wgCacheDirectory;
		return "$wgCacheDirectory/translate_groupcache-{$this->group}-$code.cdb";
	}

	protected function specialKey( $key ) {
		return "<|$key#>";
	}

}