<?php

class SassSourceContext {

	protected $rootDir;
	protected $instances = array();
	protected $filesMap = array();

	public function __construct( $rootDir ) {
		$this->rootDir = $rootDir;
	}

	public function getRootDir() {
		return $this->rootDir;
	}

	/**
	 * @param $fileName
	 * @return SassSource
	 */
	public function getFile( $fileName, $relativeToPath = null ) {
		$requested = $fileName;
		$fileName = $this->findFile($fileName,$relativeToPath);
//		var_dump($requested,$fileName);
		if ( $fileName === false ) {
			throw new SassException( __METHOD__ . ': Requested SASS file not found: ' . $requested );
		}
		if ( empty( $this->instances[$fileName] ) ) {
			$this->instances[$fileName] = new SassFileSource($this,$fileName);
		}
		return $this->instances[$fileName];
	}

	const NOT_FOUND = '__NOT_FOUND__';

	public function findFile( $fileName, $relativeToPath = null ) {
		if ( file_exists( $fileName ) ) {
			return realpath($fileName);
		}

		$requested = $fileName;

		$prefixes = array();
		if ( $relativeToPath ) {
			$prefixes[] = rtrim( $relativeToPath, '/' );
		}
		$prefixes[] = $this->getRootDir();
		$prefixes[] = '';

		foreach ($prefixes as $prefix) {
			if ( !empty( $this->filesMap[$prefix][$requested] ) ) {
				$value = $this->filesMap[$prefix][$requested];
				if ( $value !== self::NOT_FOUND ) {
					return $value;
				} else {
					continue;
				}
			}

			$parts = explode( '/', $requested );
			$filename = array_pop( $parts );
			$directory = implode( '/', $parts ) . '/';

			if ( !startsWith( $directory, '/' ) ) {
				$directory = '/' . $directory;
			}
			$directory = $prefix . $directory;

			// Filenames to check.
			// These should be arranged in order of likeliness.
			$filenames = array();
			$filenames[] = $filename;
			$filenames[] = $filename . '.scss';
			$filenames[] = '_' . $filename . '.scss';
			$filenames[] = $filename . '.sass';
			$filenames[] = '_' . $filename . '.sass';

			$fileName = false;
			if ( file_exists( $directory ) ) {
				foreach( $filenames as $f ) {
					$fullPath = $directory . $f;
					if ( file_exists( $fullPath ) ) {
						$fileName = realpath($fullPath);
						break;
					}
				}
			}

			$this->filesMap[$prefix][$requested] = $fileName ?: self::NOT_FOUND;

			if ( $fileName ) {
				return $fileName;
			}
		}

		return false;
	}

	public function clearInstances() {
		$this->instances = array();
	}

	public function clearMapping() {
		$this->filesMap = array();
	}

}