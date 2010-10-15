<?php

/**
 * External storage driver for riak
 *
 * @ingroup ExternalStorage
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 */

class ExternalStoreRiak {

	private $mRiakClient, $mRiakBucket;

	/**
	 * public constructor, uses globals defined somewhere else
	 *
	 * @access public
	 */
	public function __construct() {
		global $wgRiakNodeHost, $wgRiakNodePort, $wgRiakNodePrefix, $wgRiakNodeProxy ;

		$this->mRiakBucket = "blobs";
		$this->mRiakClient = new RiakClient( $wgRiakNodeHost, $wgRiakNodePort, $wgRiakNodePrefix, 'mapred', $wgRiakNodeProxy );


	}

	/**
	 * Fetch data from given URL
	 * @param string $url An url of the form riak://bucket/<key>
	 *
	 * @access public
	 */
	public function fetchFromURL( $url ) {
		list( $proto, $bucket, $key ) = explode( "/", $url, 3 );
		$this->mRiakBucket = $bucket;
		return $this->fetchBlob( $key );
	}

	/**
	 * Insert a data item into a given cluster
	 *
	 * @param $cluster String: the cluster name
	 * @param $data String: the data item
	 * @return string URL
	 */
	public function store( $bucket, $data ) {
		# key for blobs is not known here
		return false;
	}


	/**
	 * Set bucket for storing blobs
	 *
	 * @param string $bucket bucket name
	 */
	public function setBucket( $bucket ) {
		$this->mRiakBucket = $bucket;
	}

	/**
	 * fetch blob from riak, bucket should be already defined
	 * @access private
	 */
	private function fetchBlob( $key ) {

		wfProfileIn( __METHOD__ );

		$value = false;
		if( $this->mRiakBucket ) {
			$bucket = $this->mRiakClient->bucket( $this->mRiakBucket );
			$object = $bucket->getBinary( $key );
			if( $object->exists() ) {
				$value = $object->getData();
			}
		}

		wfProfileOut( __METHOD__ );

		return $value;
	}

	/**
	 * store blob in riak in given key, bucket should be already defined
	 * @access public
	 *
	 * @return boolean status
	 */
	public function storeBlob( $key, $data ) {

		wfProfileIn( __METHOD__ );

		$status = false;

		if( $this->mRiakBucket ) {
			$bucket = $this->mRiakClient->bucket( $this->mRiakBucket );
			$object = $bucket->newBinary( $key, $data );
			$status = $object->store();
		}
		else {
			Wikia::log( __METHOD__, false, "bucket is not defined" );
		}

		wfProfileOut( __METHOD__ );

		return $status;
	}
};
