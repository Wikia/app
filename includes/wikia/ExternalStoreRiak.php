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
		global $wgRiakNodeHost, $wgRiakNodePort, $wgRiakNodePrefix;

		$this->mRiakClient = new RiakClient( $wgRiakNodeHost, $wgRiakNodePort, $wgRiakNodePrefix );

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
		$this->mRiakBucket = $bucket;
		return false;
	}


	/**
	 * prepare blob for storing in in riak, construct key from $page_id, $rev_id
	 * and $cluster
	 *
	 * @param string $cluster -- cluster name used in blob url
	 * @param mixed $data -- data for storing
	 * @param integer $page_id -- article id from page table
	 * @param integer $rev_id -- revision id from revision table
	 *
	 * @access public
	 */
	public function storeArchive( $cluster, $data, $page_id, $rev_id ) {
		global $wgCityId;

		$this->mRiakBucket = $cluster;
		$key = sprintf( "%d:%d:%d", $wgCityId, $page_id, $rev_id );
		$this->storeBlob( $key, $data );
	}

	/**
	 * fetch blob from riak, bucket should be already defined
	 * @access private
	 */
	private function fetchBlob( $key ) {

		wfProfileIn( __METHOD__ );

		$value = false;
		if( $this->mRiakBucket ) {
			$bucket = $this->mRiakClient()->bucket( $this->mRiakBucket );
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
	 * @access private
	 */
	private function storeBlob( $key, $data ) {

		wfProfileIn( __METHOD__ );

		if( $this->mRiakBucket ) {
			$bucket = $this->mRiakClient()->bucket( $this->mRiakBucket );
			$object = $bucket->newBinary( $key, $data );
			$object->store();
		}

		wfProfileOut( __METHOD__ );
	}
};
