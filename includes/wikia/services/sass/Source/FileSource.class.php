<?php

namespace Wikia\Sass\Source;
use Wikia\Sass\Source\Context;

/**
 * FileSource represents a regular file containing SASS source code.
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
class FileSource extends Source {

	/**
	 * @var string File path
	 */
	protected $fileName;

	/**
	 * @var srting|null File contents (cache)
	 */
	protected $rawSource;
	/**
	 * @var int|null Last modified time (cache)
	 */
	protected $rawModifiedTime;

	/**
	 * Create Sass source instance associated with regular file
	 *
	 * @param $context SassSourceContext Context
	 * @param $fileName string File path
	 */
	public function __construct( Context $context, $fileName ) {
		if ( !is_file($fileName) ) {
			throw new \Wikia\Sass\Exception( __METHOD__ . ': File is not a regular file: ' . $fileName );
		}
		parent::__construct( $context );
		$this->fileName = realpath($fileName);
		$this->currentDir = dirname($this->fileName);
		$this->humanName = $this->fileName;
	}

	public function hasPermanentFile() {
		return true;
	}

	public function getLocalFile() {
		return $this->fileName;
	}

	public function releaseLocalFile() {
		// noop
	}

	protected function getRawSource() {
		if ( $this->rawSource === null ) {
			if ( !is_readable( $this->fileName ) ) {
				throw new \Wikia\Sass\Exception( __METHOD__ . ': Could not find SASS file: ' . $this->fileName);
			}
			wfSuppressWarnings();
			$contents = file_get_contents($this->fileName);
			wfRestoreWarnings();
			if ( $contents === false ) {
				throw new \Wikia\Sass\Exception( __METHOD__ . ': Could not read SASS file: ' . $this->fileName);
			}
			$this->rawSource = $contents;
		}
		return $this->rawSource;
	}

	protected function getRawModifiedTime() {
		if ( $this->rawModifiedTime === null ) {
			$this->rawModifiedTime = filemtime($this->fileName);
		}
		return $this->rawModifiedTime;
	}

	protected function getCurrentDir() {
		return $this->currentDir;
	}

}