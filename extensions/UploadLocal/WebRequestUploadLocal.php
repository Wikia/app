<?php
class WebRequestUploadLocal extends WebRequestUpload {
	/**
	 * Constructor.
	 *
	 * @param $doesExist Boolean True if the file exists.
	 * @param $fileInfo Array The file information object.
	 */
	public function __construct( $doesExist, $fileInfo ) {
		$this->doesExist = $doesExist;
		$this->fileInfo = $fileInfo;
	}

	/**
	 * Returns whether this upload failed because of overflow of a maximum set
	 * in php.ini.  Always false when uploading locally.
	 *
	 * @return bool
	 */
	public function isIniSizeOverflow() {
		return false;
	}
}
