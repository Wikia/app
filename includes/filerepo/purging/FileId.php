<?php

class FileId {

	private $bucket;
	private $relativePath;
	private $pathPrefix;

	public function __construct( $bucket, $relativePath, $pathPrefix ) {
		$this->bucket = $bucket;
		$this->relativePath = $relativePath;
		$this->pathPrefix = $pathPrefix;
	}

	public static function deserializeFromTask( array $data ): FileId {
		return new FileId( $data['bucket'], $data['relative-path'], $data['path-prefix'] );
	}

	public function serializeForTask(): array {
		return [
			'bucket' => $this->bucket,
			'relative-path' => $this->relativePath,
			'path-prefix' => $this->pathPrefix,
		];
	}

	public function getBucket() {
		return $this->bucket;
	}

	public function getRelativePath() {
		return $this->relativePath;
	}

	public function getPathPrefix() {
		return $this->pathPrefix;
	}
}
