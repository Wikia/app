<?php

/**
 * @file
 * @ingroup Cache
 *
 * @see lib/riak/riak.php
 * @see lib/riak/docs/index.html
 * @see http://riak.basho.com/edoc/raw-http-howto.txt for HTTP interface
 */

/**
 * Generic class to store objects in a riak repository
 * @author Krzysztof Krzyżaniak (eloy)
 */
class RiakCache extends BagOStuff {

	private $mBucket, $mNode;

	public function __construct( $bucket = false, $node = false ) {
		global $wgRiakStorageNodes, $wgRiakDefaultNode;

		$this->mBucket = $bucket;
		if( $node ) {
			if( isset( $wgRiakStorageNodes[ $node ] ) ) {
				$this->mNode  = $wgRiakStorageNodes[ $node ];
			}
			else {
				wfDie( "Node $node is not defined in wgRiakStorageNodes variable" );
			}
		}
		else {
			/**
			 * @todo should we die if not defined too?
			 */
			$this->mNode  = $wgRiakStorageNodes[ $wgRiakDefaultNode ];
		}
	}

	/**
	 * return default riak client instance, so far only initialized class
	 *
	 * @author Krzysztof Krzyżaniak (eloy)
	 *
	 * @see lib/riak/riak.php
	 * @see lib/riak/docs/index.html
	 * @see http://riak.basho.com/edoc/raw-http-howto.txt for HTTP interface
	 */
	function getRiakClient() {
		try {
			$riak = new RiakClient(
				$this->mNode[ "host" ],
				$this->mNode[ "port" ],
				$this->mNode[ "prefix" ],
				'mapred',
				$this->mNode[ "proxy" ]
			);
		}
		catch ( Exception $e ) {
			Wikia::log( __METHOD__, "error", $e->getMessage() );
			$riak = false;
		}
		return $riak;
	}

	/**
	 * set bucket name
	 *
	 * @param String $bucket -- bucket name
	 */
	public function setBucket( $bucket ) {
		$this->mBucket = $bucket;
	}

	/**
	 * get bucket name, if not set previously $wgDBname will be used
	 *
	 * @return String -- bucket name
	 */
	public function getBucket() {
		global $wgDBname;

		if( empty( $this->mBucket ) ) {
			$this->mBucket = $wgDBname;
		}
		return $this->mBucket;
	}

	/**
	 * get stored value for key
	 *
	 * @param string $key -- key name
	 *
	 * @return value stored in key
	 */
	public function get( $key ) {

		$bucket = $this->getRiakClient()->bucket( $this->getBucket() );
		$object = $bucket->get( $key );
		$data   = $object->getData();
		$value  = false;
		if( is_array( $data ) ) {
			$value     = array_shift( $data );
			$timestamp = array_shift( $data );
			if( $timestamp < time() ) {
				$this->delete( $key );
				$value = false;
			}
		}
		return $value;
	}

	/**
	 * store value in riak
	 *
	 * @param String $key
	 * @param Mixed $value
	 */
	public function set( $key, $value, $exptime = 0 ) {
		$bucket = $this->getRiakClient()->bucket( $this->getBucket() );
		$object = $bucket->newObject( $key, array( $value, empty( $exptime ) ? 0 : time() + $exptime  ) );
		$object->store();
	}

	/**
	 * delete value from riak
	 *
	 * @param String $key
	 */
	public function delete( $key, $exptime = 0 ) {
		$bucket = $this->getRiakClient()->bucket( $this->getBucket() );
		$object = $bucket->get( $key );
		$object->delete();
		$object->reload();
	}

	public function keys() {
		return array();
	}
}
