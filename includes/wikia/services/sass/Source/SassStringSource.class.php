<?php

/**
 * SassStringSource represents a string containing Sass source code
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
class SassStringSource extends SassSource {

	protected $localFile;
	protected $rawSource;
	protected $rawModifiedTime;

	/**
	 * Create Sass source associated with given string
	 *
	 * @param $context SassSourceContext Context
	 * @param $source string Sass source code
	 * @param $modifiedTime int Last modified time (unix timestamp)
	 * @param $humanName string|null Human-readable description (used for debugging)
	 */
	public function __construct( SassSourceContext $context, $source, $modifiedTime, $humanName = null ) {
		parent::__construct( $context );
		$this->rawSource = $source;
		$this->rawModifiedTime = $modifiedTime;
		$this->humanName = $humanName;
	}

	public function hasPermanentFile() {
		return false;
	}

	public function getLocalFile() {
		if ( $this->localFile === null ) {
			$tempDir = $this->getContext()->getTempDir();
			//replace \ to / is needed because escapeshellcmd() replace \ into spaces (?!!)
			$localFile = str_replace('\\', '/', tempnam($tempDir, 'Sass'));

			file_put_contents($localFile,$this->rawSource);
			if ( !is_readable( $localFile ) ) {
				return false;
			}

			$this->localFile = $localFile;
		}
		return $this->localFile;
	}

	public function releaseLocalFile() {
		if ( $this->localFile !== null ) {
			unlink($this->localFile);
			$this->localFile = null;
		}
	}

	protected function getRawSource() {
		return $this->rawSource;
	}

	protected function getRawModifiedTime() {
		return $this->rawModifiedTime;
	}

	protected function getCurrentDir() {
		throw new SassException( __METHOD__ . ': Current directory is not available.' );
	}


}