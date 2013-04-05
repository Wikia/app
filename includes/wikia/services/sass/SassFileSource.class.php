<?php

class SassFileSource extends SassSource {

	protected $fileName;
	protected $dirName;

	public function __construct( SassSourceContext $context, $fileName ) {
		if ( !is_file($fileName) ) {
			throw new SassException( __METHOD__ . ': File is not a regular file: ' . $fileName );
		}
		parent::__construct( $context );
		$this->fileName = realpath($fileName);
		$this->currentDir = dirname($this->fileName);
		$this->humanName = $this->fileName;
	}

	protected function getRawModifiedTime() {
		if ( $this->rawModifiedTime === null ) {
			$this->rawModifiedTime = filemtime($this->fileName);
		}
		return $this->rawModifiedTime;
	}

	protected function getRawSource() {
		if ( $this->rawSource === null ) {
			if ( !is_readable( $this->fileName ) ) {
				throw new SassException( __METHOD__ . ': Could not find SASS file: ' . $this->fileName);
			}
			wfSuppressWarnings();
			$contents = file_get_contents($this->fileName);
			wfRestoreWarnings();
			if ( $contents === false ) {
				throw new SassException( __METHOD__ . ': Could not read SASS file: ' . $this->fileName);
			}
			$this->rawSource = $contents;
		}
		return $this->rawSource;
	}

}