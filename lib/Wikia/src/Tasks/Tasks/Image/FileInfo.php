<?php

namespace Wikia\Tasks\Tasks\Image;

class FileInfo {

	private $bucket;
	private $relativePath;
	private $revision;
	private $pathPrefix;

	public function __construct( string $bucket, string $relativePath, $revision, $pathPrefix ) {
		$this->bucket = $bucket;
		$this->relativePath = $relativePath;
		$this->revision = $revision;
		$this->pathPrefix = $pathPrefix;
	}

	public static function deserializeFromTask( array $data ): FileInfo {
		return new FileInfo( $data['bucket'], $data['relative-path'], $data['revision'], $data['path-prefix'] );
	}

	public function serializeForTask(): array {
		return [
			'bucket' => $this->bucket,
			'relative-path' => $this->relativePath,
			'revision' => $this->revision,
			'path-prefix' => $this->pathPrefix,
		];
	}

	public function getBucket() {
		return $this->bucket;
	}

	public function getRelativePath() {
		return $this->relativePath;
	}

	public function getRevision() {
		return $this->revision;
	}

	public function getPathPrefix() {
		return $this->pathPrefix;
	}
}
