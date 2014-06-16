<?php

class BaseXWikiImage {
	public $mDefaultPath = 'http://images.wikia.com/messaging/images/';

	public $mPath = false;

	public $mUser = false;

	public $mDefaultAvatars = false;

	public $avatarUrl = null;

	public $userPageUrl = null;

	public function __construct() {
	}

	public $imageGroupToken = "base_x_wiki";

	public function getImageGroupToken() {
		return $imageGroupToken;
	}

	public function getDefaultAvatars( $thumb = "" ) {
		if ( $thumb == "" && is_array( $this->mDefaultAvatars ) && count( $this->mDefaultAvatars ) > 0 ) {
			return $this->mDefaultAvatars;
		}

		$this->mDefaultAvatars = array();
		$images = getMessageForContentAsArray( 'blog-avatar-defaults' );

		if ( is_array( $images ) ) {
			foreach ( $images as $image ) {
				$hash = FileRepo::getHashPathForLevel( $image, 2 );
				$this->mDefaultAvatars[] = $this->mDefaultPath . $thumb . $hash . $image;
			}
		}

		return $this->mDefaultAvatars;
	}

	public function setUrl( $url ) {
		$this->avatarUrl = $url;
	}

	public function getUrl( $thumb = "" ) {
		if ( !empty($this->avatarUrl) ) {
			return $this->avatarUrl;
		} else {
			$url = $this->getPurgeUrl( $thumb ); // get the basic URL
			return wfReplaceImageServer( $url, $this->mUser->getTouched() );
		}
	}

	public function getPurgeUrl( $thumb = "" ) {
		global $wgBlogAvatarPath;
		$url = $this->mUser->getOption( AVATAR_USER_OPTION_NAME );

		if ( $url ) {
			/**
			 * if default avatar we glue with messaging.wikia.com
			 * if uploaded avatar we glue with common avatar path
			 */
			if ( strpos( $url, '/' ) !== false ) {
				/**
				 * uploaded file, we are adding common/avatars path
				 */
				// avatars selected from "samples" are stored as full URLs (BAC-1195)
				if ( strpos( $url, 'http://' ) === false ) {
					$url = $wgBlogAvatarPath . rtrim( $thumb, '/' ) . $url;
				}
			} else {
				/**
				 * default avatar, path from messaging.wikia.com
				 */
				$hash = FileRepo::getHashPathForLevel( $url, 2 );
				$url = $this->mDefaultPath . trim( $thumb, '/' ) . '/' . $hash . $url;
			}
		} else {
			$defaults = $this->getDefaultAvatars( trim( $thumb, "/" ) . "/" );
			$url = array_shift( $defaults );
		}

		return $url;
	}

	public function getThumbnail( $width, $inPurgeFormat = false ) {
		if ( $inPurgeFormat ) {
			$url = $this->getPurgeUrl( '/thumb/' );
		} else {
			$url = $this->getUrl( '/thumb/' );
		}

		return ImagesService::getThumbUrlFromFileUrl( $url, $width );
	}

	/**
	 * Get the URL in a generic form (ie: images.wikia.com) to be used
	 * for purging thumbnails.
	 *
	 * @access public
	 * @author Sean Colombo
	 *
	 * @param width - the width of the thumbnail (height will be same propotion to width as in unscaled image)
	 * @return string -- url to Avatar on the purgable hostname.
	 */
	public function getThumbnailPurgeUrl( $width ) {
		return $this->getThumbnail( $width, true );
	}

	/**
	 * Returns true if the user whose masthead this is, has an avatar set.
	 * Returns false if they do not (and would end up using the default avatar).
	 */
	public function hasAvatar() {
		$hasAvatar = false;
		if ( !empty($this->avatarUrl) ) {
			$hasAvatar = true;
		} else {
			$url = $this->mUser->getOption( AVATAR_USER_OPTION_NAME );
			if ( ($url) && (strpos( $url, '/' ) !== false) ) {
				// uploaded file
				$hasAvatar = true;
			}
		}
		return $hasAvatar;
	} // end hasAvatar()

	public function getLocalPath() {
		if ( $this->mPath ) {
			return $this->mPath;
		}

		$image = sprintf( '%s.png', $this->mUser->getID() );
		$hash = sha1( (string)$this->mUser->getID() );
		$folder = substr( $hash, 0, 1 ) . '/' . substr( $hash, 0, 2 );

		$this->mPath = "/{$folder}/{$image}";


		return $this->mPath;
	}

	public function getFullPath() {
		global $wgBlogAvatarDirectory;
		return $wgBlogAvatarDirectory . $this->getLocalPath();
	}

	public function getSwiftStorage() {
		global $wgBlogAvatarSwiftContainer, $wgBlogAvatarSwiftPathPrefix;
		return \Wikia\SwiftStorage::newFromContainer( $wgBlogAvatarSwiftContainer, $wgBlogAvatarSwiftPathPrefix );
	}

	public function getTempFile() {
		return tempnam( wfTempDir(), 'avatar' );
	}

	public function isDefault() {
		$url = $this->mUser->getOption( AVATAR_USER_OPTION_NAME );
		if ( $url ) {
			/**
			 * default avatar are only filenames without path
			 */
			if ( strpos( $url, '/' ) !== false ) {
				return false;
			}
		}
		return true;
	}

	protected function doRemoveFile() {
		$swift = $this->getSwiftStorage();

		$avatarRemotePath = $this->getLocalPath();
		$status = $swift->remove( $avatarRemotePath );

		return $status->isOk();
	}

	public function removeFile( $addLog = true ) {
		$result = $this->doRemoveFile();

		if ( $result === false ) {
			Wikia::log( __METHOD__, false, 'cannot remove xwiki image - ' . $this->getLocalPath() );
		} else {
			// remove thumbnails
			$this->purgeThumbnails();
		}

		return $result;
	}

	private function getThumbPath( $dir ) {
		return str_replace( "/avatars/", "/avatars/thumb/", $dir );
	}

	public function uploadByUrl( $url ) {
		// macbre: avatars operations are disabled during maintenance
		global $wgAvatarsMaintenance;
		if ( !empty($wgAvatarsMaintenance) ) {
			return UPLOAD_ERR_NO_TMP_DIR;
		}

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
		// macbre: avatars operations are disabled during maintenance
		global $wgAvatarsMaintenance;
		if ( !empty($wgAvatarsMaintenance) ) {
			return UPLOAD_ERR_NO_TMP_DIR;
		}

		$this->__setLogType();

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

	private function postProcessImageInternal( $sTmpFile, &$errorNo = UPLOAD_ERR_OK, &$errorMsg = '' ) {
		global $wgAvatarsUseSwiftStorage, $wgBlogAvatarSwiftContainer, $wgBlogAvatarSwiftPathPrefix;


		$aImgInfo = getimagesize( $sTmpFile );

		/**
		 * check if mimetype is allowed
		 */
		$aAllowMime = array( 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png', 'image/x-png', 'image/jpg' );
		if ( !in_array( $aImgInfo['mime'], $aAllowMime ) ) {
			global $wgLang;

			// This seems to be the most appropriate error message to describe that the image type is invalid.
			// Available error codes; http://php.net/manual/en/features.file-upload.errors.php
			$errorNo = UPLOAD_ERR_EXTENSION;
			$errorMsg = wfMsg( 'blog-avatar-error-type', $aImgInfo['mime'], $wgLang->listToText( $aAllowMime ) );

			return $errorNo;
		}

		switch ( $aImgInfo['mime'] ) {
			case 'image/gif':
				$oImgOrig = @imagecreatefromgif( $sTmpFile );
				break;
			case 'image/pjpeg':
			case 'image/jpeg':
			case 'image/jpg':
				$oImgOrig = @imagecreatefromjpeg( $sTmpFile );
				break;
			case 'image/x-png':
			case 'image/png':
				$oImgOrig = @imagecreatefrompng( $sTmpFile );
				break;
		}
		$aOrigSize = array( 'width' => $aImgInfo[0], 'height' => $aImgInfo[1] );

		/**
		 * generate new image to png format
		 */
		$sFilePath = empty($wgAvatarsUseSwiftStorage) ? $this->getFullPath() : $this->getTempFile(); // either NFS or temp file

		$ioh = new ImageOperationsHelper();
		$oImg = $ioh->postProcess( $oImgOrig, $aOrigSize );

		/**
		 * save to new file ... but create folder for it first
		 */
		if ( !is_dir( dirname( $sFilePath ) ) && !wfMkdirParents( dirname( $sFilePath ) ) ) {


			return UPLOAD_ERR_CANT_WRITE;
		}

		if ( !imagepng( $oImg, $sFilePath ) ) {

			$errorNo = UPLOAD_ERR_CANT_WRITE;
		} else {
			$errorNo = UPLOAD_ERR_OK;

			/* remove tmp image */
			imagedestroy( $oImg );

			// store the avatar on Swift
			if ( !empty($wgAvatarsUseSwiftStorage) ) {
				$swift = $this->getSwiftStorage();
				$res = $swift->store( $sFilePath, $this->getLocalPath(), [ ], 'image/png' );

				// errors handling
				$errorNo = $res->isOK() ? UPLOAD_ERR_OK : UPLOAD_ERR_CANT_WRITE;

				// synchronize between DC
				if ( $res->isOK() ) {
					$mwStorePath = sprintf( 'mwstore://swift-backend/%s%s%s',
						$wgBlogAvatarSwiftContainer, $wgBlogAvatarSwiftPathPrefix, $this->getLocalPath() );
					Wikia\SwiftSync\Queue::newFromParams( [
						'city_id' => 0,
						'op' => 'store',
						'src' => $sFilePath,
						'dst' => $mwStorePath
					] )->add();
				}

				// sync with NFS
				global $wgEnableSwithSyncToLocalFS;
				if ( !empty($wgEnableSwithSyncToLocalFS) ) {
					copy( $sFilePath, $this->getFullPath() );
				}
			}

			$sUserText = $this->mUser->getName();
			$mUserPage = Title::newFromText( $sUserText, NS_USER );
			$oLogPage = new LogPage(AVATAR_LOG_NAME);
			$oLogPage->addEntry( 'avatar_chn', $mUserPage, '' );
			unlink( $sTmpFile );

			/**
			 * notify image replication system
			 */
			global $wgEnableUploadInfoExt;
			if ( $wgEnableUploadInfoExt ) {
				UploadInfo::log( $mUserPage, $sFilePath, $this->getLocalPath() );
			}

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
