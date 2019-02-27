<?php

use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;

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

	public function bucket(): Bucket {
		return $this->storage->bucket( $this->bucketName );
	}

	public function temporaryBucket(): Bucket {
		return $this->storage->bucket( $this->temporaryBucketName );
	}

	/**
	 * Convenience method to fetch an object from the originals bucket.
	 * @param ObjectName $name
	 * @return \Google\Cloud\Storage\StorageObject
	 */
	public function getOriginal( ObjectName $name ) {
		return $this->bucket()->object( $name->value() );
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

	/**
	 * Check if the provided file path matches thumbnail path.
	 * @param $path
	 * @return false|int
	 */
	public function isDirAThumbnailPath( $path ) {
		return preg_match( '/([a-z_-]+\/)?images\/thumb\//', $path );
	}
}
