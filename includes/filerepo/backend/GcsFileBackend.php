<?php

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\ObjectIterator;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Storage\StorageObject;
use Wikia\Logger\WikiaLogger;

class GcsFileBackend extends FileBackendStore {

	private $storage;
	private $bucketName;
	private $temporaryBucketName;
	private $objectNamePrefix;

	public function __construct( $config ) {
		parent::__construct( $config );
		$this->storage = new StorageClient( [ 'keyFile' => $config['gcsCredentials'] ] );
		$this->bucketName = $config['gcsBucket'];
		$this->temporaryBucketName = $config['gcsTemporaryBucket'];
		$this->objectNamePrefix = $config['gcsObjectNamePrefix'];
	}

	/**
	 * Copied from SwiftFileBackend for compatibility. Might have no sense.
	 * @see FileBackendStore::isValidContainerName()
	 */
	protected static function isValidContainerName( $container ) {
		return preg_match( '/^[a-z0-9][a-z0-9-_.]{0,199}$/i', $container );
	}

	/**
	 * Copied from SwiftFileBackend for compatibility. Might have no sense.
	 * @see FileBackendStore::resolveContainerPath()
	 * @param $container
	 * @param $relStoragePath
	 * @return string|null
	 */
	protected function resolveContainerPath( $container, $relStoragePath ) {
		if ( !mb_check_encoding( $relStoragePath, 'UTF-8' ) ) { // mb_string required by CF
			return null; // not UTF-8, makes it hard to use CF and the swift HTTP API
		} elseif ( strlen( urlencode( $relStoragePath ) ) > 1024 ) {
			return null; // too long for Swift
		}

		return $relStoragePath;
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

		list( $unused, $rel ) = $this->resolveStoragePathReal( $storagePath );

		return $rel !== null;
	}

	/**
	 * @see FileBackendStore::createInternal()
	 * @param array $params
	 * @return Status
	 */
	protected function doCreateInternal( array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString(),
		] );
		$status = Status::newGood();

		try {
			$this->bucket()->upload( $params['content'], [
				'name' => $this->objectName( $params['dst'] ),
				'metadata' => $this->getMetadata( sha1( $params['content'] ) ),
			] );
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

		$sha1 = sha1_file( $params['src'] );
		if ( $sha1 === false ) { // source doesn't exist?
			$status->fatal( 'backend-fail-copy', $params['src'], $params['dst'] );

			return $status;
		}

		WikiaLogger::instance()->info( __METHOD__ . " - generating sha1", [
			'call_stack' => ( new Exception() )->getTraceAsString(),
			'params' => json_encode( $params ),
			'sha1' => $sha1,
		] );

		try {
			$this->bucket()->upload( fopen( $params['src'], 'r' ), [
				'name' => $this->objectName( $params['dst'] ),
				'metadata' => $this->getMetadata( $sha1 ),
				'metadata.zorf' => 'morf',
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

		// This is likely unnecessary as we call Thumblr explicitly to clean up thumbs, but just to be sure.
		// We will use call_stack to see if there are any places we've missed and if not we can remove this
		// condition and calls to clean thumbnails
		if ( preg_match( '/([a-z_-]+\/)?images\/thumb\//', $dir ) ) {
			$directory = $this->getThumbnailsDirectory( $container, $dir );
			WikiaLogger::instance()->info( __METHOD__ . " - cleaning thumbnails", [
				'call_stack' => ( new Exception() )->getTraceAsString(),
				'gcs_directory' => $directory,
			] );

			$objects = $this->temporaryBucket()->objects( [ 'prefix' => $directory ] );
			$this->deleteFiles( $objects );
		} else {
			$path = $this->objectPath( $container, $dir );
			WikiaLogger::instance()->warning( __METHOD__ . " - cleaning other than thumbnails", [
				'call_stack' => ( new Exception() )->getTraceAsString(),
				'path' => $path,
			] );

			$objects = $this->bucket()->objects( [ 'prefix' => $path ] );
			$this->deleteFiles( $objects );
		}
	}

	/**
	 * @param ObjectIterator $objects
	 */
	protected function deleteFiles( ObjectIterator $objects ) {
		try {
			foreach ( $objects as $file ) {
				$file->delete();
			}
		}
		catch ( NotFoundException $e ) {
			WikiaLogger::instance()->debug(
				__METHOD__ . " - at least one file has already been deleted",
				[ 'exception' => $e ] );
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
				->rewrite( $this->bucket(), [
					'name' => $this->objectName( $params['dst'] ),
				] );
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
	 * @see FileBackendStore::doGetFileSha1base36()
	 * @param array $params
	 * @return bool|string
	 */
	public function doGetFileSha1base36( array $params ) {
		$stat = $this->getFileStat( $params );
		if ( $stat ) {
			return $stat['sha1'];
		} else {
			return false;
		}
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
				'sha1' => $this->sha1ToHash( $obj->info()['sha1'] ),
			];
		} else {
			return false;
		}
	}

	private function getMetadata( $sha1 ) {
		return [
			// user metadata are nested like so: metadata.metadata
			'metadata' => [
				'sha1' => $sha1,
			]
		];
	}

	private function sha1ToHash( $sha1 ) {
		return wfBaseConvert( $sha1, 16, 36, 31 );
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
		return $this->storage->bucket( $this->temporaryBucketName );
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
