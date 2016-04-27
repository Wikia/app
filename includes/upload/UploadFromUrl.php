<?php
/**
 * Implements uploading from a HTTP resource.
 *
 * @ingroup Upload
 * @author Bryan Tong Minh
 * @author Michael Dale
 */
class UploadFromUrl extends UploadBase {
	protected $mUrl;
	protected $mIgnoreWarnings = true;

	protected $mTempPath, $mTmpHandle;

	/**
	 * Checks if the user is allowed to use the upload-by-URL feature. If the
	 * user is allowed, pass on permissions checking to the parent.
	 *
	 * @param $user User
	 *
	 * @return bool
	 */
	public static function isAllowed( $user ) {
		if ( !$user->isAllowed( 'upload_by_url' ) ) {
			return 'upload_by_url';
		}
		return parent::isAllowed( $user );
	}

	/**
	 * Checks if the upload from URL feature is enabled
	 * @return bool
	 */
	public static function isEnabled() {
		global $wgAllowCopyUploads;
		return $wgAllowCopyUploads && parent::isEnabled();
	}

	/**
	 * Entry point for API upload
	 *
	 * @param $name string
	 * @param $url string
	 */
	public function initialize( $name, $url ) {
		$this->mUrl = $url;

		# File size and removeTempFile will be filled in later
		$this->initializePathInfo( $name, $this->makeTemporaryFile(), 0, false );
	}

	/**
	 * Entry point for SpecialUpload
	 * @param $request WebRequest object
	 */
	public function initializeFromRequest( &$request ) {
		$desiredDestName = $request->getText( 'wpDestFile' );
		if ( !$desiredDestName ) {
			$desiredDestName = $request->getText( 'wpUploadFileURL' );
		}
		return $this->initialize(
			$desiredDestName,
			trim( $request->getVal( 'wpUploadFileURL' ) )
		);
	}

	/**
	 * @param $request WebRequest object
	 * @return bool
	 */
	public static function isValidRequest( $request ) {
		global $wgUser;

		$url = $request->getVal( 'wpUploadFileURL' );
		return !empty( $url ) && UploadFromUrl::isValidURI( $url ) && $wgUser->isAllowed( 'upload_by_url' );
	}

	public static function isValidURI( $url ) {
		return Http::isValidURI( $url ) || UploadFromUrl::isValidBase64( $url );
	}

	public static function isValidBase64( $url ) {
		$base64 = UploadFromUrl::getBase64( $url );
		return preg_match(
			'|^\s*(?:(?:[A-Za-z0-9+/]{4})+\s*)*[A-Za-z0-9+/]*={0,2}\s*$|',
			$base64
		);
	}

	public static function getBase64( $url ) {
		$encoded = explode( ',', $url );
		return isset( $encoded[ 1 ] ) ? $encoded[ 1 ] : $encoded[ 0 ];
	}

	/**
	 * @return string
	 */
	public function getSourceType() {
		return 'url';
	}

	/**
	 * @return Status
	 */
	public function fetchFile() {
		if ( !UploadFromUrl::isValidURI( $this->mUrl ) ) {
			return Status::newFatal( 'http-invalid-url' );
		}

		return $this->reallyFetchFile();
	}

	/**
	 * Create a new temporary file in the URL subdirectory of wfTempDir().
	 *
	 * @return string Path to the file
	 */
	protected function makeTemporaryFile() {
		return tempnam( wfTempDir(), 'URL' );
	}

	/**
	 * Callback: save a chunk of the result of a HTTP request to the temporary file
	 *
	 * @param $req mixed
	 * @param $buffer string
	 * @return int number of bytes handled
	 */
	public function saveTempFileChunk( $req, $buffer ) {
		$nbytes = fwrite( $this->mTmpHandle, $buffer );

		if ( $nbytes == strlen( $buffer ) ) {
			$this->mFileSize += $nbytes;
		} else {
			// Well... that's not good!
			fclose( $this->mTmpHandle );
			$this->mTmpHandle = false;
		}

		return $nbytes;
	}

	/**
	 * Download the file, save it to the temporary file and update the file
	 * size and set $mRemoveTempFile to true.
	 * @return Status
	 */
	protected function reallyFetchFile() {
		if ( $this->mTempPath === false ) {
			return Status::newFatal( 'tmp-create-error' );
		}

		// Note the temporary file should already be created by makeTemporaryFile()
		$this->mTmpHandle = fopen( $this->mTempPath, 'wb' );
		if ( !$this->mTmpHandle ) {
			return Status::newFatal( 'tmp-create-error' );
		}

		$this->mRemoveTempFile = true;
		$this->mFileSize = 0;

		/* Wikia change - begin */
		$options = array( 'followRedirects' => true, 'noProxy' => true );
		wfRunHooks( 'UploadFromUrlReallyFetchFile', array( &$options ) );
		if ( UploadFromUrl::isValidBase64( $this->mUrl ) ) {
			$status = $this->saveTempBase64();
		} else {
			$req = MWHttpRequest::factory( $this->mUrl, $options );

			$req->setCallback( array( $this, 'saveTempFileChunk' ) );
			$status = $req->execute();
		}
		/* Wikia change - end */

		if ( $this->mTmpHandle ) {
			// File got written ok...
			fclose( $this->mTmpHandle );
			$this->mTmpHandle = null;
		} else {
			// We encountered a write error during the download...
			return Status::newFatal( 'tmp-write-error' );
		}

		if ( !$status->isOk() ) {
			return $status;
		}

		return $status;
	}

	protected function saveTempBase64() {
		$buffer = base64_decode( UploadFromUrl::getBase64( $this->mUrl ) );
		$this->saveTempFileChunk( null, $buffer );
		return new Status();
	}

	/**
	 * Wrapper around the parent function in order to defer verifying the
	 * upload until the file really has been fetched.
	 */
	public function verifyUpload() {
		return parent::verifyUpload();
	}

	/**
	 * Wrapper around the parent function in order to defer checking warnings
	 * until the file really has been fetched.
	 */
	public function checkWarnings() {
		return parent::checkWarnings();
	}

	/**
	 * Wrapper around the parent function in order to defer checking protection
	 * until we are sure that the file can actually be uploaded
	 */
	public function verifyTitlePermissions( $user ) {
		return parent::verifyTitlePermissions( $user );
	}

}
