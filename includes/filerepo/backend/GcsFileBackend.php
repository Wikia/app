<?php

use Google\Cloud\Storage\StorageClient;
use Wikia\Logger\WikiaLogger;

class GcsFileBackend extends FileBackendStore {

	private $storage;

	public function __construct( $config ) {
		parent::__construct( $config );
		$this->storage =
			new GoogleCloudStorage( new StorageClient( [ 'keyFile' => $config['gcsCredentials'] ] ),
				$config['gcsBucket'], $config['gcsTemporaryBucket'],
				$config['gcsObjectNamePrefix'] );
	}

	/**
	 * Container name is always valid if it is a UTF-8.
	 * @see FileBackendStore::isValidContainerName()
	 * @param $container
	 * @return bool
	 */
	protected static function isValidContainerName( $container ) {
		return mb_check_encoding( $container, 'UTF-8' );
	}

	/**
	 * https://cloud.google.com/storage/docs/naming
	 * @see FileBackendStore::resolveContainerPath()
	 * @param $container
	 * @param $relStoragePath
	 * @return string|null
	 */
	protected function resolveContainerPath( $container, $relStoragePath ) {
		if ( strlen( $relStoragePath ) == 0 && strlen( $container ) == 0 ) {
			return null; // path and container cannot be empty
		} elseif ( !mb_check_encoding( $relStoragePath, 'UTF-8' ) ) {
			return null; // not UTF-8, not supported by GCS
		} elseif ( strlen( urlencode( $container ) ) + strlen( urlencode( $relStoragePath ) ) >
				   1024 ) {
			// container name is now part of the path so, container name PLUS storage path cannot be longer than
			// 1024 bytes when UTF-8 encoded
			return null;
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

		list( $container, $path ) = $this->resolveStoragePathReal( $params['src'] );
		if ( $path === null ) {
			return null;
		}
		$ext = FileBackend::extensionFromPath( $path );
		try {
			$tmpFile = TempFSFile::factory( wfBaseName( $path ) . '_', $ext );
			$this->storage->downloadToFile( $this->storage->getObjectName( [ $container, $path ] ),
				$tmpFile );

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

		$destination = $this->storage->getObjectName( $params['dst'] );
		$data = $params['content'];
		$sha1 = sha1( $params['content'] );

		try {
			$this->storage->upload( $destination, $data, $sha1 );
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

		$destination = $this->storage->getObjectName( $params['dst'] );
		$data = fopen( $params['src'], 'r' );
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
			$this->storage->upload( $destination, $data, $sha1 );
		}
		catch ( Exception $e ) {
			WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e, ] );
			$status->fatal( 'backend-fail-internal' );
		}

		return $status;
	}

	/**
	 * @see FileBackendStore::doCleanInternal()
	 * @param $container
	 * @param $dir
	 * @param array $params
	 */
	protected function doCleanInternal( $container, $dir, array $params ) {
		// This is likely unnecessary as we call Thumblr explicitly to clean up thumbs, but just to be sure.
		// We will use call_stack to see if there are any places we've missed and if not we can remove this
		// condition and calls to clean thumbnails
		if ( preg_match( '/([a-z_-]+\/)?images\/thumb\//', $dir ) ) {
			$pathPrefix = $this->storage->getThumbnailPathPrefix( $container, $dir );
			WikiaLogger::instance()->info( __METHOD__ . " - cleaning thumbnails", [
				'call_stack' => ( new Exception() )->getTraceAsString(),
				'gcs_directory' => $pathPrefix,
			] );
			$this->storage->deleteTemporaryInPath( $pathPrefix );
		} else {
			$pathPrefix = $this->storage->getPathPrefix( $container, $dir );
			WikiaLogger::instance()->warning( __METHOD__ . " - cleaning other than thumbnails", [
				'call_stack' => ( new Exception() )->getTraceAsString(),
				'gcs_directory' => $pathPrefix,
			] );
			$this->storage->deleteInPath( $pathPrefix );
		}
	}

	/**
	 * @see FileBackendStore::copyInternal()
	 * @param array $params
	 * @return Status
	 */
	protected function doCopyInternal( array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString(),
		] );

		$status = Status::newGood();
		try {
			$this->storage->copy( $this->storage->getObjectName( $this->resolveStoragePathReal( $params['src'] ) ),
				$this->storage->getObjectName( $this->resolveStoragePathReal( $params['dst'] ) ) );
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
			$this->storage->delete( $this->storage->getObjectName( $this->resolveStoragePathReal( $params['src'] ) ) );
		}
		catch ( Exception $e ) {
			WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e, ] );
			$status->fatal( 'backend-fail-internal' );
		}

		return $status;
	}

	/**
	 * Do not call this function from places outside FileBackend
	 *
	 * @see FileBackendStore::getFileList()
	 *
	 * @param $container string Resolved container name
	 * @param $dir string Resolved path relative to container
	 * @param $params array
	 * @return Traversable|array|null
	 */
	public function getFileListInternal( $container, $dir, array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString(),
			'container' => $container,
			'dir' => $dir,
			'params' => json_encode( $params ),
		] );

		try {
			return $this->storage->getFileList( $this->storage->getPathPrefix( $container, $dir ) );
		}
		catch ( Exception $e ) {
			WikiaLogger::instance()->error( __METHOD__, [ 'exception' => $e, ] );

			return [];
		}
	}

	/**
	 * @see FileBackendStore::getFileStat()
	 * @param array $params
	 * @return array|bool
	 * @throws MWException
	 */
	protected function doGetFileStat( array $params ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'call_stack' => ( new Exception() )->getTraceAsString(),
			'storage_path' => $params['src'],
		] );

		return $this->storage->getFileStats( $this->storage->getObjectName( $this->resolveStoragePathReal( $params['src'] ) ) );
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
}
