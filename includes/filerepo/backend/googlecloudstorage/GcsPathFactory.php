<?php

class GcsPathFactory {

	private $objectNamePrefix;

	public function __construct( string $objectNamePrefix ) {
		$this->objectNamePrefix = $objectNamePrefix;
	}

	public function objectName( array $containerAndPath ): string {
		list ( $container, $path ) = $containerAndPath;

		return $this->objectNamePrefix . $container . '/' . $path;
	}

	public function objectsPrefix( string $container, string $directory ): string {
		return $this->objectNamePrefix . $container . '/' . $directory;
	}

	public function thumbnailsPrefix( string $container, string $path ) {
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
