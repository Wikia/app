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

	private $mBucket, $mNode, $mNodeName;

	public function __construct( $bucket = false, $node = false ) {
		global $wgRiakStorageNodes, $wgRiakDefaultNode;

		$this->mBucket = $bucket;
		if( $node ) {
			if( isset( $wgRiakStorageNodes[ $node ] ) ) {
				wfDebugLog( __CLASS__, __METHOD__ . ": using $node as requested riak node.", true );
				$this->mNode  = $wgRiakStorageNodes[ $node ];
				$this->mNodeName = $node;
			}
			else {
				wfDebugLog( __CLASS__, __METHOD__ . ": node $node is not defined in wgRiakStorageNodes variable.\n", true );
				wfDie( "Node $node is not defined in wgRiakStorageNodes variable" );
			}
		}
		else {
			/**
			 * fallback to default riak node, used in ExternalStoreRiak for example
			 * @see includes/wikia/ExternalStoreRiak.php
			 */
			wfDebugLog( __CLASS__, __METHOD__ . ": using $wgRiakDefaultNode as default riak node.\n", true );
			$this->mNode  = $wgRiakStorageNodes[ $wgRiakDefaultNode ];
			$this->mNodeName = $wgRiakDefaultNode;
		}
	}

	/**
	 * riak node data as string, just for debugging, shortcut
	 *
	 * @return string riak node data
	 */
	private function riakNode() {
		return sprintf(
			" [%s:%s/%s] ",
			$this->mNode[ "host" ],
			$this->mNode[ "port" ],
			$this->mNode[ "prefix"]
		);
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
			wfDebugLog( __CLASS__, __METHOD__ . $this->riakNode() . ": catched exception, error: " . $e->getMessage() . ".\n", true );
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
		wfDebugLog( __CLASS__,  __METHOD__ . $this->riakNode() . ": setting $bucket as riak bucket.\n" );
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
		wfDebugLog( __CLASS__,  __METHOD__ . $this->riakNode() . ": getting {$this->mBucket} as riak bucket.\n" );

		return $this->mBucket;
	}

	/**
	 * get node name
	 *
	 * @access public
	 *
	 * @return string node name
	 */
	public function getNodeName() {
		return $this->mNodeName;
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
		wfDebugLog( __CLASS__, __METHOD__ . $this->riakNode() . ": getting value from key $key.\n" );
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
		wfDebugLog( __CLASS__, __METHOD__ . $this->riakNode() . ": storing value for key $key.\n" );
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
		wfDebugLog( __CLASS__, __METHOD__ . $this->riakNode() . ": deleting value from key $key.\n" );
	}

	public function keys() {
		return array();
	}
}
