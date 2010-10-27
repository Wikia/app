<?php

/**
 * External storage driver for riak
 *
 * @ingroup ExternalStorage
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 */

class ExternalStoreRiak {

	private $mRiakBucket, $mRiakNode;

	/**
	 * public constructor, uses globals defined somewhere else
	 *
	 * @access public
	 */
	public function __construct() {
		$this->mRiakBucket = "blobs";
	}

	/**
	 * get riak database handler
	 *
	 * @acccess private
	 */
	private function getClient() {

		wfProfileIn( __METHOD__ );

		$riak = new RiakCache( $this->mRiakBucket, $this->mRiakNode );
		$this->mRiakNode = $riak->getNodeName();

		wfProfileOut( __METHOD__ );

		return $riak->getRiakClient();
	}

	/**
	 * Fetch data from given URL
	 * @param string $url An url of the form riak://<host>/<bucket>/<key>
	 *
	 * @access public
	 */
	public function fetchFromURL( $url ) {
		list( $proto, $x, $node, $bucket, $key ) = explode( "/", $url, 5 );
		wfDebugLog( "RiakCache", __METHOD__ . ": node: $node, bucket: $bucket, key: $key\n" );
		$this->mRiakBucket = $bucket;
		$this->mRiakNode = $node;
		return $this->fetchBlob( $key );
	}

	/**
	 * Insert a data item into a given cluster
	 *
	 * @param string $bucket the cluster name
	 * @param string $data the data item
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
	 *
	 * @param string $key key to resource
	 * @param string $node node name for riak configuration
	 *
	 * @access private
	 */
	private function fetchBlob( $key ) {

		wfProfileIn( __METHOD__ );

		$value = false;
		if( $this->mRiakBucket ) {
			$client = $this->getClient();
			$bucket = $client->bucket( $this->mRiakBucket );
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

		$url = false;

		if( $this->mRiakBucket ) {
			/**
			 * false = get default riak node for storage,
			 * will be set in getClient()
			 */
			$this->mRiakNode =  false;
			$client = $this->getClient();
			$bucket = $client->bucket( $this->mRiakBucket );
			$object = $bucket->newBinary( $key, $data );
			$status = $object->store();

			$url = sprintf( "riak://%s/%s/%s", $this->mRiakNode, $this->mRiakBucket, $key );
		}
		else {
			Wikia::log( __METHOD__, false, "bucket is not defined" );
		}

		/**
		 * construct url
		 */

		wfProfileOut( __METHOD__ );

		return $url;
	}
};
