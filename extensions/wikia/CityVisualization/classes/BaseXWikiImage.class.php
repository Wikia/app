<?php

abstract class BaseXWikiImage {

	const IMAGE_NAME_TEMPLATE = '%1s/%2s/%s%s';
	const IMAGE_URL_TEMPLATE = 'http://images.wikia.com/$s/images/%s/%s%s';
	const THUMBNAIL_URL_BASE_TEMPLATE = 'http://images.wikia.com/$s/images/thumb/%s/%s%s';
	const IMAGE_TYPE = "png";

	public $mDefaultPath = 'http://images.wikia.com/messaging/images/';

	public $mDefaultAvatars = false;
	protected $name, $fileNameSuffix;

	abstract protected function onFileRemoval( $success );

	abstract public function getImageGroupToken();

	abstract public function getFileDirectory();

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

	protected function rawGetUrl( $template ) {
		$nameHash = FileRepo::getHashPathForLevel( $this->name, 2 );
		return sprintf( $template, $this->getImageGroupToken(), $nameHash, $this->name );
	}


	public function getUrl() {
		return wfReplaceImageServer( $this->getPurgeUrl() );
	}

	public function getThumbnailUrl( $width ) {
		return wfReplaceImageServer( $this->getThumbnailPurgeUrl( $width ) );
	}

	// urls used for purging cache
	public function getPurgeUrl() {
		return $this->rawGetUrl( self::IMAGE_URL_TEMPLATE );
	}

	public function getThumbnailPurgeUrl( $width ) {
		$tempUrl = $this->rawGetUrl( self::THUMBNAIL_URL_BASE_TEMPLATE );
		return ImagesService::getThumbUrlFromFileUrl( $tempUrl, $width );
	}

	public function getLocalPath() {
		$nameHash = sha1( $this->name );
		return sprintf( self::IMAGE_PATH_TEMPLATE, $nameHash, $nameHash, $this->name, $this->fileNameSuffix );
	}

	public function getFullPath() {
		return rtrim( $this->getFileDirectory(), PATH_SEPARATOR ) . PATH_SEPARATOR . $this->getLocalPath();
	}

	public function getSwiftStorage() {
		global $wgBlogAvatarSwiftContainer, $wgBlogAvatarSwiftPathPrefix;
		return \Wikia\SwiftStorage::newFromContainer( $this->getSwiftContainer(), $this->getSwiftPathPrefix() );
	}

	public function getTempFile() {
		return tempnam( wfTempDir(), $this->getImageGroupToken() );
	}

	public function removeFile() {
		$swift = $this->getSwiftStorage();

		$path = $this->getLocalPath();
		$status = $swift->remove( $path );

		$result = $status->isOk();
		$this->onFileRemoval( $result );

		if ( $result ) {
			Wikia::log( __METHOD__, false, 'cannot remove xwiki image - ' . $path );
		} else {
			// remove thumbnails
			$this->purgeThumbnails();
		}

		return $result;
	}

	private function getThumbPath( $dir ) {
		return str_replace( "/{$this->getImageGroupToken()}/", "/{$this->getImageGroupToken()}/thumb/", $dir );
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
		// macbre: avatars operations are disabled during maintenance
		global $wgAvatarsMaintenance;
		if ( !empty($wgAvatarsMaintenance) ) {
			return UPLOAD_ERR_NO_TMP_DIR;
		}
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
			$this->onUploadMimeRejected();
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
	} // end postProcessImageInternal()

	private function purgeThumbnails() {
		global $wgAvatarsUseSwiftStorage, $wgBlogAvatarPath, $wgBlogAvatarSwiftContainer, $wgBlogAvatarSwiftPathPrefix;
		// get path to thumbnail folder


		// dirty hack, should work in this case
		if ( !empty($wgAvatarsUseSwiftStorage) ) {
			$swift = $this->getSwiftStorage();

			$backend = FileBackendGroup::singleton()->get( 'swift-backend' );
			$dir = sprintf( 'mwstore://swift-backend/%s%s%s', $wgBlogAvatarSwiftContainer, $wgBlogAvatarSwiftPathPrefix, $this->getLocalPath() );
			$dir = $this->getThumbPath( $dir );

			$avatarRemotePath = sprintf( "thumb%s", $this->getLocalPath() );

			$urls = [ ];
			$files = [ ];
			$iterator = $backend->getFileList( array( 'dir' => $dir ) );
			foreach ( $iterator as $file ) {
				$files[] = sprintf( "%s/%s", $avatarRemotePath, $file );
			}

			// deleting files on file system and creating an array of URLs to purge
			if ( !empty($files) ) {
				foreach ( $files as $file ) {
					$status = $swift->remove( $file );
					if ( !$status->isOk() ) {

					} else {
						$urls[] = wfReplaceImageServer( $wgBlogAvatarPath ) . "/$file";

					}
				}
			}

		} else {
			$dir = $this->getFullPath();
			$dir = $this->getThumbPath( $dir );
			if ( is_dir( $dir ) ) {
				$urls = [ ];
				$files = [ ];
				// copied from LocalFile->getThumbnails
				$handle = opendir( $dir );

				if ( $handle ) {
					while ( false !== ($file = readdir( $handle )) ) {
						if ( $file{0} != '.' ) {
							$files[] = $file;
						}
					}
					closedir( $handle );
				}

				// partialy copied from LocalFile->purgeThumbnails()
				foreach ( $files as $file ) {
					// deleting files on file system
					@unlink( "$dir/$file" );
					$urls[] = $this->getPurgeUrl( '/thumb/' ) . "/$file";

				}
			} else {

			}

		}

		// purging avatars urls
		SquidUpdate::purge( $urls );
	}
}