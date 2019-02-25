<?php

use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\ObjectIterator;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StorageObject;
use Wikia\Logger\WikiaLogger;

class GcsFileBackend extends FileBackendStore {

	private $storage;
	private $bucketName;
	private $objectNamePrefix;

	public function __construct( $config ) {
		parent::__construct( $config );
		$this->storage = new StorageClient( [
			'keyFile' => $config['gcsCredentials'],
		] );
		$this->bucketName = $config['gcsBucket'];
		$this->objectNamePrefix = $config['gcsObjectNamePrefix'];
	}

	/**
	 * @see FileBackendStore::getLocalCopy()
	 * @param array $params
	 * @return Status|TempFSFile|null
	 */
	public function getLocalCopy( array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'params' => $params,
			'call_stack' => ( new Exception() )->getTraceAsString(),
		] );

		list( $unused, $srcRel ) = $this->resolveStoragePathReal( $params['src'] );
		if ( $srcRel === null ) {
			return null;
		}
		$ext = FileBackend::extensionFromPath( $srcRel );
		try {
			$tmpFile = TempFSFile::factory( wfBaseName( $srcRel ) . '_', $ext );

			$this->bucket()
				->object( $this->objectName( $params['src'] ) )
				->downloadToFile( $tmpFile->getPath() );

			return $tmpFile;
		}
		catch ( Exception $e ) {
			WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e, ] );

			return null;
		}
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
			'storage_path' => $storagePath,
		] );

		// TODO: we can probably just return true
		return true;
	}

	/**
	 * @see FileBackendStore::createInternal()
	 */
	protected function doCreateInternal( array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString(),
		] );
		$status = Status::newGood();

		try {
			$this->bucket()
				->upload( $params['content'], [ 'name' => $this->objectName( $params['dst'] ) ] );
		}
		catch ( Exception $e ) {
			WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e, ] );
			$status->fatal( 'backend-fail-internal' );
		}

		return $status;
	}

	/**
	 * @see FileBackendStore::storeInternal()
	 */
	protected function doStoreInternal( array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString(),
			'params' => json_encode( $params ),
		] );
		$status = Status::newGood();

		try {
			$this->bucket()->upload( fopen( $params['src'], 'r' ), [
				'name' => $this->objectName( $params['dst'] ),
			] );
		}
		catch ( Exception $e ) {
			WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e, ] );
			$status->fatal( 'backend-fail-internal' );
		}

		return $status;
	}

	private function getThumbnailsDirectory( string $container, string $path ) {
		$prefixPosition = strpos( $path, "images/thumb/" );

		$langPrefix = null;
		if ( $prefixPosition != 0 ) {
			$langPrefix = substr( $path, 0, $prefixPosition /* minus slash */ - 1 );
			// get rid of the path prefix
			$path = substr( $path, $prefixPosition );
		} else {
			$langPrefix = "default";
		}

		// split /{first hash letter}/{hash}/{filename name}
		$path = explode( "/", substr( $path, strlen( "images/thumb/" ) ) );

		$hash = $path[1];
		$community = $container;
		$filename = $path[2];

		return "mediawiki/{$hash}/{$community}/{$langPrefix}/{$filename}";
	}

	/**
	 * @see FileBackendStore::doCleanInternal()
	 * @param $container
	 * @param $dir
	 * @param array $params
	 */
	protected function doCleanInternal( $container, $dir, array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString(),
			'params' => json_encode( $params ),
			'container' => $container,
			'dir' => $dir,
		] );

		if ( preg_match( '/([a-z_-]+\/)?images\/thumb\//', $dir ) ) {
			$directory = $this->getThumbnailsDirectory( $container, $dir );
			WikiaLogger::instance()->info( __METHOD__ . " - cleaning thumbnails", [
				'call_stack' => ( new Exception() )->getTraceAsString(),
				'gcs_directory' => $directory,
			] );
			foreach ( $this->temporaryBucket()->objects( [ 'prefix' => $directory ] ) as $file ) {
				$file->delete();
			}
		} else {
			WikiaLogger::instance()->warning( __METHOD__ . " - cleaning other than thumbnails", [
				'call_stack' => ( new Exception() )->getTraceAsString(),
			] );

			foreach ( $this->bucket()->objects( [
					'prefix' => $this->objectPath( $container, $dir ),
				] ) as $file
			) {
				$file->delete();
			}
		}
	}

	/**
	 * @see FileBackendStore::copyInternal()
	 */
	protected function doCopyInternal( array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString(),
		] );

		$status = Status::newGood();
		try {
			$this->bucket()
				->object( $this->objectName( $params['src'] ) )
				->copy( $this->bucket(), [ 'name' => $this->objectName( $params['dst'] ) ] );
		}
		catch ( Exception $e ) {
			WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e, ] );
			$status->fatal( 'backend-fail-internal' );
		}

		return $status;
	}

	/**
	 * @see FileBackendStore::deleteInternal()
	 */
	protected function doDeleteInternal( array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString(),
		] );
		$status = Status::newGood();
		try {
			$this->bucket()->object( $this->objectName( $params['src'] ) )->delete();
		}
		catch ( Exception $e ) {
			WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e, ] );
			$status->fatal( 'backend-fail-internal' );
		}

		return $status;
	}

	/**
	 * @see FileBackendStore::getFileStat()
	 */
	protected function doGetFileStat( array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString(),
			'storage_path' => $params['src'],
		] );

		$obj = $this->bucket()->object( $this->objectName( $params['src'] ) );

		if ( $obj->exists() ) {
			return [
				'mtime' => wfTimestamp( TS_MW, $obj->info()['updated'] ),
				'size' => $obj->info()['size'],
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
			'params' => json_encode( $params ),
		] );

		try {
			return new GoogleCloudFileList( $this->bucket()
				->objects( [ 'prefix' => $this->objectPath( $container, $dir ) ] ) );
		}
		catch ( Exception $e ) {
			WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e, ] );

			return [];
		}
	}

	private function bucket(): Bucket {
		return $this->storage->bucket( $this->bucketName );
	}

	private function temporaryBucket(): Bucket {
		return $this->storage->bucket( 'static-assets-temporary-dev' );
	}

	private function objectPath( String $container, String $path ) {
		return $this->objectNamePrefix . $container . '/' . $path;
	}

	private function objectName( String $storagePath ) {
		list( $container, $path ) = $this->resolveStoragePathReal( $storagePath );

		return $this->objectNamePrefix . $container . '/' . $path;
	}
}

class GoogleCloudFileList implements Iterator {

	/**
	 * @var ObjectIterator<StorageObject>
	 */
	private $objectIterator;

	public function __construct( ObjectIterator $storageObject ) {
		$this->objectIterator = $storageObject;
	}

	public function current() {
		return $this->objectIterator->current()->name();
	}

	public function key() {
		return $this->objectIterator->key();
	}

	public function next() {
		return $this->objectIterator->next();
	}

	public function rewind() {
		return $this->objectIterator->rewind();
	}

	public function valid() {
		return $this->objectIterator->valid();
	}
}
