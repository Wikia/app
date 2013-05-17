<?php

namespace Wikia\Sass\Source;

/**
 * Context is a class containing context for spawning new Sass sources.
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
class Context {

	protected $rootDir;
	protected $tempDir;
	protected $instances = array();
	protected $filesMap = array();

	/**
	 * Create new context instance
	 *
	 * @param $rootDir string Base root dir (relative file paths are searched here as well)
	 * @param $tempDir string|null Temporary directory
	 */
	public function __construct( $rootDir, $tempDir = null ) {
		$this->rootDir = $rootDir;
		$this->tempDir = $tempDir ?: sys_get_temp_dir();
	}

	/**
	 * Get a base root directory
	 *
	 * @return string Base root directory
	 */
	public function getRootDir() {
		return $this->rootDir;
	}

	/**
	 * Get a temporary directory
	 *
	 * @return string Temporary directory
	 */
	public function getTempDir() {
		return $this->tempDir;
	}

	/**
	 * Get a Sass source representing regular file specified by file name
	 * and optionally an extra path to search for this file in
	 *
	 * @param $fileName string File path (can be relative or absolute)
	 * @param $relativeToPath string|null Extra path to search for this file in (optional)
	 * @return Source instance
	 * @throws \Wikia\Sass\Exception
	 */
	public function getFile( $fileName, $relativeToPath = null ) {
		$requested = $fileName;
		$fileName = $this->findFile($fileName,$relativeToPath);
//		var_dump($requested,$fileName);
		if ( $fileName === false ) {
			throw new \Wikia\Sass\Exception( __METHOD__ . ': Requested SASS file not found: ' . $requested );
		}
		if ( empty( $this->instances[$fileName] ) ) {
			$this->instances[$fileName] = new FileSource($this,$fileName);
		}
		return $this->instances[$fileName];
	}

	const NOT_FOUND = '__NOT_FOUND__';

	/**
	 * Find an existing file that matches Ruby's Sass processor searching order.
	 *
	 * @param $fileName string File path (can be relative or absolute)
	 * @param $relativeToPath string|null Extra path to search for this file in (optional)
	 * @return string|bool Absolute file path or false if file was not found
	 */
	public function findFile( $fileName, $relativeToPath = null ) {
		$requested = $fileName;

		$prefixes = array();
		if ( $relativeToPath ) {
			$prefixes[] = rtrim( $relativeToPath, '/' );
		}
		$prefixes[] = $this->getRootDir();
		$prefixes[] = '';

		foreach ($prefixes as $prefix) {
//			var_dump("pref $prefix");
			if ( !empty( $this->filesMap[$prefix][$requested] ) ) {
				$value = $this->filesMap[$prefix][$requested];
//				var_dump("map $value");
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
//					var_dump("chk $fullPath");
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