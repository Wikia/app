<?php

use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\ObjectIterator;
use Google\Cloud\Storage\StorageClient;
use Wikia\Logger\WikiaLogger;

class GoogleCloudStorage {

	private $storage;
	private $bucketName;
	private $temporaryBucketName;
	private $objectNamePrefix;

	public function __construct(
		StorageClient $storageClient, string $bucketName, string $temporaryBucketName,
		string $objectNamePrefix
	) {
		$this->storage = $storageClient;
		$this->bucketName = $bucketName;
		$this->temporaryBucketName = $temporaryBucketName;
		$this->objectNamePrefix = $objectNamePrefix;
	}

	public function downloadToFile( ObjectName $name, TempFSFile $tmpFile ) {
		$this->bucket()->object( $name->value() )->downloadToFile( $tmpFile->getPath() );
	}

	private function bucket(): Bucket {
		return $this->storage->bucket( $this->bucketName );
	}

	public function getFileStats( ObjectName $name ) {
		$obj = $this->bucket()->object( $name->value() );
		if ( !$obj->exists() ) {
			return null;
		}

		return [
			'mtime' => wfTimestamp( TS_MW, $obj->info()['updated'] ),
			'size' => $obj->info()['size'],
			'sha1' => $this->sha1ToHash( $obj->info()['sha1'] ),
		];
	}

	public function delete( ObjectName $name ) {
		$this->bucket()->object( $name->value() )->delete();
	}

	public function copy( ObjectName $from, ObjectName $to ) {
		$this->bucket()
			->object( $from->value() )
			->rewrite( $this->bucket(), [ 'name' => $to->value() ] );
	}

	public function getFileList( string $pathPrefix ): GoogleCloudFileList {
		$objects = $this->bucket()->objects( [ 'prefix' => $pathPrefix ] );

		return new GoogleCloudFileList( $objects );
	}

	public function deleteInPath( string $pathPrefix ) {
		$objects = $this->bucket()->objects( [ 'prefix' => $pathPrefix ] );
		$this->deleteObjects( $objects );
	}

	public function deleteTemporaryInPath( string $pathPrefix ) {
		$objects = $this->temporaryBucket()->objects( [ 'prefix' => $pathPrefix, ] );
		$this->deleteObjects( $objects );
	}

	/**
	 * @param ObjectIterator $objects
	 */
	protected function deleteObjects( ObjectIterator $objects ) {
		try {
			foreach ( $objects as $file ) {
				$file->delete();
			}
		}
		catch ( NotFoundException $e ) {
			WikiaLogger::instance()->debug( __METHOD__ .
											" - at least one file has already been deleted",
				[ 'exception' => $e ] );
		}
	}

	private function temporaryBucket(): Bucket {
		return $this->storage->bucket( $this->temporaryBucketName );
	}

	public function getObjectName( array $containerAndPath ): ObjectName {
		list ( $container, $path ) = $containerAndPath;

		return new ObjectName( $this->objectNamePrefix . $container . '/' . $path );
	}

	public function getPathPrefix( string $container, string $directory ): string {
		return $this->objectNamePrefix . $container . '/' . $directory;
	}

	public function getThumbnailPathPrefix( string $container, string $path ) {
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

		return "{$this->objectNamePrefix}{$hash}/{$community}/{$langPrefix}/{$filename}";
	}

	public function upload( ObjectName $targetName, $data, string $sha1 ) {
		$this->bucket()->upload( $data, [
			'name' => $targetName->value(),
			'metadata' => $this->getMetadata( $sha1 ),
		] );
	}


	private function getMetadata( $sha1 ) {
		return [
			// user metadata are nested like so: metadata.metadata
			'metadata' => [
				'sha1' => $sha1,
			],
		];
	}

	private function sha1ToHash( $sha1 ) {
		return wfBaseConvert( $sha1, 16, 36, 31 );
	}


}
