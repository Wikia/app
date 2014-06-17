<?php

abstract class BaseXWikiImage {
	const IMAGE_PATH_TEMPLATE = '%1s/%2s/%s';
	// <1 first character of name hash>/<2 first characters of name hash>/<name><extension_suffix>
	const IMAGE_URL_TEMPLATE = 'http://images.wikia.com/%s%s/%s/%s%s';
	const THUMBNAIL_URL_BASE_TEMPLATE = 'http://images.wikia.com/%s%s/thumb/%s/%s%s';
	const IMAGE_HOST = "http://images.wikia.com/";
	const IMAGE_TYPE = "png"; //currently only storing images as PNG's is supported

	protected $name, $fileNameSuffix;

	abstract public function getContainerDirectory();

	abstract public function getSwiftContainer();

	abstract public function getSwiftPathPrefix();

	/*
	 * returns mime allowed in upload
	 */
	protected function getAllowedMime() {
		return [ 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png', 'image/x-png', 'image/jpg' ];
	}

	public function __construct( $name ) {
		$this->name = $name;
		$this->fileNameSuffix = "." . self::IMAGE_TYPE;
	}

	public function getUrl() {
		return wfReplaceImageServer( $this->getPurgeUrl() );
	}

	public function getThumbnailUrl( $width ) {
		$url = ImagesService::getThumbUrlFromFileUrl( $this->getLocalThumbnailPath(), $width );
		return wfReplaceImageServer( $url );
	}

	// urls used for purging cache
	public function getPurgeUrl() {
		return $this->getBaseUrl() . "/" . $this->getLocalPath();
	}

	public function getThumbnailPurgeUrl() {
		return $this->getBaseUrl() . "/" . $this->getLocalThumbnailPath();
	}

	protected function getBaseUrl() {
		return self::IMAGE_HOST . $this->getSwiftContainer() . $this->getSwiftPathPrefix();
	}

	protected function getLocalPath( $name = null ) {
		if ( empty($name) ) {
			$name = $this->name . $this->fileNameSuffix;
		}
		$nameHash = FileRepo::getHashPathForLevel( $this->name, 2 );
		return sprintf( self::IMAGE_PATH_TEMPLATE, $nameHash, $nameHash, $name );
	}

	protected function getLocalThumbnailPath( $name = null ) {
		return "thumb/" . $this->getLocalPath( $name );
	}

	public function getFullPath() {
		return rtrim( $this->getContainerDirectory(), PATH_SEPARATOR ) . PATH_SEPARATOR . $this->getLocalPath();
	}

	public function getSwiftStorage() {
		return \Wikia\SwiftStorage::newFromContainer( $this->getSwiftContainer(), $this->getSwiftPathPrefix() );
	}

	public function getTempFile() {
		return tempnam( wfTempDir(), trim( $this->getSwiftPathPrefix(), "/" ) );
	}

	public function removeFile() {
		$swift = $this->getSwiftStorage();

		$path = $this->getLocalPath();
		$status = $swift->remove( $path );
		$result = $status->isOk();

		if ( $result ) {
			Wikia::log( __METHOD__, false, 'cannot remove xwiki image - ' . $path );
		} else {
			// remove thumbnails
			$this->purgeThumbnails();
		}

		return $result;
	}

	private function getThumbPath( $dir ) {
		$path_token = trim( $this->getSwiftPathPrefix(), "/" );
		return str_replace( "/{$path_token}/", "/{$path_token}/thumb/", $dir );
	}

	public function uploadByUrl( $url ) {
		$sTmpFile = '';

		$errorNo = $this->uploadByUrlToTempFile( $url, $sTmpFile );

		if ( $errorNo == UPLOAD_ERR_OK ) {
			$errorNo = $this->postProcessImageInternal( $sTmpFile, $errorNo );
		}

		return $errorNo;
	} // end uploadByUrl()


	public function uploadByUrlToTempFile( $url, &$sTmpFile ) {
		$errorNo = UPLOAD_ERR_OK; // start by presuming there is no error.

		// Pull the image from the URL and save it to a temporary file.
		$sTmpFile = $this->getTempFile();

		$imgContent = Http::get( $url, 'default', [ 'noProxy' => true ] );
		if ( !file_put_contents( $sTmpFile, $imgContent ) ) {
			return UPLOAD_ERR_CANT_WRITE;
		}
		return $errorNo;
	}

	public function uploadFile( $request, $input = AVATAR_UPLOAD_FIELD, &$errorMsg = '' ) {
		$errorNo = $request->getUploadError( $input );
		if ( $errorNo != UPLOAD_ERR_OK ) {
			wfProfileOut( __METHOD__ );
			return $errorNo;
		}

		$file = new WebRequestUpload($request, $input);
		$iFileSize = $file->getSize();

		if ( empty($iFileSize) ) {
			/**
			 * file size = 0
			 */
			wfProfileOut( __METHOD__ );
			return UPLOAD_ERR_NO_FILE;
		}

		$sTmpFile = $this->getTempFile();
		$sTmp = $request->getFileTempname( $input );

		if ( move_uploaded_file( $sTmp, $sTmpFile ) ) {
			$errorNo = $this->postProcessImageInternal( $sTmpFile, $errorNo, $errorMsg );
		} else {
			$errorNo = UPLOAD_ERR_CANT_WRITE;
		}
		wfProfileOut( __METHOD__ );
		return $errorNo;
	}

	private function postProcessImageInternal( $sourceTempFilePath, &$errorNo = UPLOAD_ERR_OK, &$errorMsg = '' ) {
		$imgInfo = getimagesize( $sourceTempFilePath );

		if ( !in_array( $imgInfo['mime'], $this->getAllowedMime() ) ) {
			// This seems to be the most appropriate error message to describe that the image type is invalid.
			// Available error codes; http://php.net/manual/en/features.file-upload.errors.php
			$errorNo = UPLOAD_ERR_EXTENSION;
			//TODO: add localized generic error message
//			global $wgLang;
//			$errorMsg = wfMsg('blog-avatar-error-type', $imgInfo['mime'], $wgLang->listToText( $this->getAllowedMime() ) );
			return $errorNo;
		}

		$sourceImage = null;

		switch ( $imgInfo['mime'] ) {
			case 'image/gif':
				$sourceImage = @imagecreatefromgif( $sourceTempFilePath );
				break;
			case 'image/pjpeg':
			case 'image/jpeg':
			case 'image/jpg':
				$sourceImage = @imagecreatefromjpeg( $sourceTempFilePath );
				break;
			case 'image/x-png':
			case 'image/png':
				$sourceImage = @imagecreatefrompng( $sourceTempFilePath );
				break;
		}

		$targetFilePath = $this->getFullPath();

		$imageOperationsHelper = new ImageOperationsHelper();
		$imgObject = $imageOperationsHelper->postProcess( $sourceImage, [ 'width' => $imgInfo[0], 'height' => $imgInfo[1] ] );

		/**
		 * save to new file ... but create folder for it first
		 */
		if ( !is_dir( dirname( $targetFilePath ) ) && !wfMkdirParents( dirname( $targetFilePath ) ) ) {
			return UPLOAD_ERR_CANT_WRITE;
		}
		/**
		 * Save file as PNG
		 */
		if ( !imagepng( $imgObject, $targetFilePath ) ) {
			$errorNo = UPLOAD_ERR_CANT_WRITE;
		} else {
			$errorNo = UPLOAD_ERR_OK;

			/* remove tmp image */
			imagedestroy( $imgObject );

			// store the avatar on Swift
			$swift = $this->getSwiftStorage();
			$res = $swift->store( $targetFilePath, $this->getLocalPath(), [ ], 'image/png' );

			// errors handling
			$errorNo = $res->isOK() ? UPLOAD_ERR_OK : UPLOAD_ERR_CANT_WRITE;

			// synchronize between DC
			if ( $res->isOK() ) {
				$mwStorePath = sprintf( 'mwstore://swift-backend/%s%s%s',
					$this->getSwiftContainer(), $this->getSwiftPathPrefix(), $this->getLocalPath() );
				Wikia\SwiftSync\Queue::newFromParams( [
					'city_id' => 0,
					'op' => 'store',
					'src' => $targetFilePath,
					'dst' => $mwStorePath
				] )->add();
			}

			unlink( $sourceTempFilePath );

			// remove generated thumbnails
			$this->purgeThumbnails();
		}

		return $errorNo;
	}

	private function removeThumbnails() {
		$baseFileUrl = self::IMAGE_HOST . $this->getSwiftContainer() . $this->getSwiftPathPrefix();

		$swift = $this->getSwiftStorage();

		$backend = FileBackendGroup::singleton()->get( 'swift-backend' );
		$thumbnailDir = sprintf( 'mwstore://swift-backend/%s%s%s', $this->getSwiftContainer(), $this->getSwiftPathPrefix(), $this->getLocalThumbnailPath() );

		$urls = [ ];
		$files = [ ];
		$iterator = $backend->getFileList( array( 'dir' => $thumbnailDir ) );
		foreach ( $iterator as $file ) {
			$files[] = sprintf( "%s/%s", $this->getLocalThumbnailPath(), $file );
		}

		// deleting files on file system and creating an array of URLs to purge
		if ( !empty($files) ) {
			foreach ( $files as $file ) {
				$status = $swift->remove( $file );
				if ( !$status->isOk() ) {
				} else {
					$urls[] = wfReplaceImageServer( $baseFileUrl ) . "/$file";
				}
			}
		}

		return $urls;
	}

	private function purgeThumbnails() {
		$urls = $this->removeThumbnails();

		// purging avatars urls
		SquidUpdate::purge( $urls );
	}
}