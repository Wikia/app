<?php

abstract class BaseXWikiImage {
	// <1 first character of name hash>/<2 first characters of name hash>/<name><extension_suffix>
	const IMAGE_HOST = "http://images.wikia.com/";
	const IMAGE_TYPE = "png"; //currently only storing images as PNG's is supported

	protected $name, $fileNameSuffix, $height, $width;

	const MWSTORE_SWIFT_BACKEND_TEMPLATE = 'mwstore://swift-backend/%s%s%s';

	abstract protected function getContainerDirectory();

	abstract protected function getSwiftContainer();

	abstract protected function getSwiftPathPrefix();

	/*
	 * returns mime allowed in upload
	 */
	protected function getAllowedMime() {
		return [ 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png', 'image/x-png', 'image/jpg' ];
	}

	public function __construct( $name, $width = null, $height = null ) {
		$this->name = $name;
		$this->height = $height;
		$this->width = $width;
		$this->fileNameSuffix = "." . self::IMAGE_TYPE;
	}

	public function getUrl() {
		return wfReplaceImageServer( $this->getPurgeUrl() );
	}

	public function getName() {
		return $this->name;
	}

	public function getThumbnailUrl( $width ) {
		$url = ImagesService::getThumbUrlFromFileUrl( $this->getThumbnailPurgeUrl(), $width );
		return wfReplaceImageServer( $url );
	}

	public function getCroppedThumbnailUrl( $desiredWidth, $desiredHeight, $newExtension = null ) {
		if ( empty( $this->width ) or empty( $this->height ) ) {
			$this->provideImageDimensions();
		}

		if ( empty( $this->width ) or empty( $this->height ) ) {
			\Wikia\Logger\WikiaLogger::instance()
				->warning( "Cannot get image dimensions, not cropping thumbnail for img: " . $this->name );
			return $this->getThumbnailUrl( $desiredWidth );
		} else {
			$url = ImagesService::getCroppedThumbnailUrl( $this->getThumbnailPurgeUrl(), $desiredWidth, $desiredHeight, $this->width, $this->height, $newExtension );
			return wfReplaceImageServer( $url );
		}
	}

	// urls used for purging cache
	public function getPurgeUrl() {
		return $this->getBaseUrl() . "/" . $this->getLocalPath();
	}

	public function getThumbnailPurgeUrl() {
		return $this->getBaseUrl() . "/" . $this->getLocalThumbnailPath();
	}

	public function getImageDimensions() {
		if ( empty( $this->width ) && empty( $this->height ) ) {
			$this->provideImageDimensions();
		}

		return [ "width" => $this->width, "height" => $this->height ];
	}

	public function getWidth() {
		return $this->width;
	}

	public function getHeight() {
		return $this->height;
	}

	public function exists() {
		return $this->getSwiftStorage()->exists( $this->getLocalPath() );
	}

	protected function provideImageDimensions( $img = null ) {
		if ( empty( $img ) ) {
			if ( $this->exists() ) {
				$file = $this->getSwiftStorage()->read( $this->getLocalPath() );
				$img = imagecreatefromstring( $file );
			}
		}

		if ( !empty( $img ) ) {
			$this->width = imagesx( $img );
			$this->height = imagesy( $img );
		}
	}

	protected function getBaseUrl() {
		return self::IMAGE_HOST . $this->getSwiftContainer() . $this->getSwiftPathPrefix();
	}

	protected function getLocalPath() {
		$name = $this->name . $this->fileNameSuffix;
		$nameHash = FileRepo::getHashPathForLevel( $name, 2 );
		return $nameHash . "$name";
	}

	protected function getLocalThumbnailPath() {
		return "thumb/" . $this->getLocalPath();
	}

	public function getFullPath() {
		return rtrim( $this->getContainerDirectory(), "/" ) . "/" . $this->getLocalPath();
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
			// remove thumbnails
			$this->purgeThumbnails();
		} else {
			Wikia::log( __METHOD__, false, 'cannot remove xwiki image - ' . $path );
		}

		return $result;
	}

	public function uploadByUrl( $url ) {
		$sTmpFile = '';

		$errorNo = $this->uploadByUrlToTempFile( $url, $sTmpFile );

		if ( $errorNo == UPLOAD_ERR_OK ) {
			$errorNo = $this->postProcessImageInternal( $sTmpFile, $errorNo );
		}

		return $errorNo;
	}

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

		$file = new WebRequestUpload( $request, $input );
		$iFileSize = $file->getSize();

		if ( empty( $iFileSize ) ) {
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

	protected function loadImageFromPath( $path ) {
		$sourceImage = null;
		$imgInfo = getimagesize( $path );

		switch ( $imgInfo['mime'] ) {
			case 'image/gif':
				$sourceImage = @imagecreatefromgif( $path );
				break;
			case 'image/pjpeg':
			case 'image/jpeg':
			case 'image/jpg':
				$sourceImage = @imagecreatefromjpeg( $path );
				break;
			case 'image/x-png':
			case 'image/png':
				$sourceImage = @imagecreatefrompng( $path );
				break;
		}
		imagesavealpha( $sourceImage, true );
		return $sourceImage;
	}

	private function postProcessImageInternal( $sourceTempFilePath, &$errorNo = UPLOAD_ERR_OK, &$errorMsg = '' ) {
		$imgInfo = getimagesize( $sourceTempFilePath );

		if ( !in_array( $imgInfo['mime'], $this->getAllowedMime() ) ) {
			$errorNo = UPLOAD_ERR_EXTENSION;
			return $errorNo;
		}

		$targetFilePath = $this->getFullPath();
		$imgObject = $this->loadImageFromPath( $sourceTempFilePath );

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
			$this->provideImageDimensions( $imgObject );

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
				$mwStorePath = sprintf( self::MWSTORE_SWIFT_BACKEND_TEMPLATE,
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
		$thumbnailDir = sprintf( self::MWSTORE_SWIFT_BACKEND_TEMPLATE, $this->getSwiftContainer(), $this->getSwiftPathPrefix(), $this->getLocalThumbnailPath() );

		$urls = [ ];
		$files = [ ];
		$iterator = $backend->getFileList( array( 'dir' => $thumbnailDir ) );
		foreach ( $iterator as $file ) {
			$files[] = sprintf( "%s/%s", $this->getLocalThumbnailPath(), $file );
		}

		// deleting files on file system and creating an array of URLs to purge
		if ( !empty( $files ) ) {
			foreach ( $files as $file ) {
				$status = $swift->remove( $file );
				if ( !$status->isOk() ) {
					\Wikia\Logger\WikiaLogger::instance()->warning("removal of thumbnail file ${file} failed");
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