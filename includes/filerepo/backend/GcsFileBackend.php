<?php

use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;
use Wikia\Logger\WikiaLogger;

class GcsFileBackend extends FileBackendStore {

	private $storage;

	private $bucketName;

	private $objectNamePrefix;

	public function __construct( $config ) {
		parent::__construct( $config );
		$this->storage = new StorageClient( [
			'keyFile' => $config['gcsCredentials']
		] );
		$this->bucketName = $config['gcsBucket'];
		$this->objectNamePrefix = $config['gcsObjectNamePrefix'];
	}

	/**
	 * Get a local copy on disk of the file at a storage path in the backend.
	 * The temporary copy will have the same file extension as the source.
	 * Temporary files may be purged when the file object falls out of scope.
	 *
	 * $params include:
	 *     src    : source storage path
	 *     latest : use the latest available data
	 *
	 * @param $params Array
	 * @return TempFSFile|null Returns null on failure
	 */
	public function getLocalCopy( array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'params' => $params,
			'call_stack' => ( new Exception() )->getTraceAsString()
		] );
	}

	/**
	 * Check if a file can be created at a given storage path.
	 * FS backends should check if the parent directory exists and the file is writable.
	 * Backends using key/value stores should check if the container exists.
	 *
	 * @param $storagePath string
	 * @return bool
	 */
	public function isPathUsableInternal( $storagePath ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString(),
			'storage_path' => $storagePath
		] );
		// TODO: we can probably just return true
		return true;
	}

	/**
	 * @see FileBackendStore::createInternal()
	 */
	protected function doCreateInternal( array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString()
		] );
	}

	/**
	 * @see FileBackendStore::storeInternal()
	 */
	protected function doStoreInternal( array $params ) {
		$status = Status::newGood();
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString(),
			'params' => json_encode( $params )
		] );


		try {
			$this->bucket()->upload( fopen( $params['src'], 'r' ), [
				'name' => $this->objectName( $params['dst'] )
			] );
		} catch( Exception $e ) {
			$status->fatal('backend-fail-internal');
		}

		return $status;
	}

	/**
	 * @see FileBackendStore::copyInternal()
	 */
	protected function doCopyInternal( array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString()
		] );
	}

	/**
	 * @see FileBackendStore::deleteInternal()
	 */
	protected function doDeleteInternal( array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString()
		] );
	}

	/**
	 * @see FileBackendStore::getFileStat()
	 */
	protected function doGetFileStat( array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString(),
			'storage_path' => $params['src']
		] );

		$obj = $this->bucket()->object( $this->objectName( $params['src'] ) );

		if ( $obj->exists() ) {
			return [
				'mtime' => wfTimestamp( TS_MW, $obj->info()['updated'] ),
				'size' => $obj->info()['size']
			];
		} else {
			return false;
		}
	}

	/**
	 * Do not call this function from places outside FileBackend
	 *
	 * @see FileBackendStore::getFileList()
	 *
	 * @param $container string Resolved container name
	 * @param $dir string Resolved path relative to container
	 * @param $params Array
	 * @return Traversable|Array|null
	 */
	public function getFileListInternal( $container, $dir, array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString(),
			'container' => $container,
			'dir' => $dir,
			'params' => json_encode( $params )
		] );

		$this->bucket()->objects( [
			'prefix' => $this->objectPath( $container, $dir )
		] );
	}

	private function bucket(): Bucket {
		return $this->storage->bucket( $this->bucketName );
	}

	private function objectPath( String $container, String $path ) {
		return $this->objectNamePrefix . $container . '/' . $path;
	}

	private function objectName( String $storagePath ) {
		list( $container, $path ) = $this->resolveStoragePathReal( $storagePath );
		return $this->objectNamePrefix . $container . '/' . $path;
	}
}