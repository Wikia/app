<?php

class Masthead {

	/**
	 * default avatar path
	 */
	public $mDefaultPath = 'http://images.wikia.com/messaging/images/';

	/**
	 * path to file, relative
	 */
	public $mPath = false;

	/**
	 * user object
	 */
	public $mUser = false;

	/**
	 * city_id for messaging.wikia.com, will be used for creating image urls
	 */
	private $mMsgCityId = 4036;

	/**
	 * avatars from mediawiki message
	 */
	public $mDefaultAvatars = false;

	/**
	 * custom URL to avatar - if set, will be overriden
	 */
	public $avatarUrl = null;

	/**
	 * custom URL to user page - if set, will be overriden
	 */
	public $userPageUrl = null;

	public function __construct( $user = null ) {
		wfProfileIn( __METHOD__ );
		if(!empty($user) && ($user instanceof User)) {
			$this->mUser = $user;
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * static constructor
	 *
	 * @static
	 * @access public
	 */
	public static function newFromUser( User $User ) {
		return new Masthead( $User );
	}

	/**
	 * static constructor
	 * @static
	 * @access public
	 */
	public static function newFromUserID( $userId ) {
		wfProfileIn( __METHOD__ );

		$User = User::newFromId( $userId );
		$User->load();
		$Avatar = new Masthead( $User );

		wfProfileOut( __METHOD__ );
		return $Avatar;
	}

	/**
	 * static constructor
	 *
	 * @static
	 * @access public
	 */
	public static function newFromUserName( $login ) {
		wfProfileIn( __METHOD__ );

		$User = User::newFromName( $login );
		if( $User ) {
			$User->load();
			$Avatar = new Masthead( $User );
		}
		else {
			/**
			 * anonymous
			 */
			$Avatar = Masthead::newFromUserID( 0 );
		}
		wfProfileOut( __METHOD__ );
		return $Avatar;
	}

	/**
	 * getDefaultAvatars -- get avatars stored in mediawiki message and return as
	 * 	array
	 *
	 * @param $thumb String  -- if defined will be added as part of base path
	 *      default empty string ""
	 *
	 * @author Piotr Molski <moli@wikia-inc.com>
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 *
	 * @return array -- array with default avatars defined on messaging.wikia.com
	 */
	public function getDefaultAvatars( $thumb = "" ) {

		/**
		 * parse message only once per request
		 */
		if( $thumb == "" && is_array( $this->mDefaultAvatars ) && count( $this->mDefaultAvatars )> 0) {
			return $this->mDefaultAvatars;
		}

		wfProfileIn( __METHOD__ );

		$this->mDefaultAvatars = array();
		$images = getMessageForContentAsArray( 'blog-avatar-defaults' );

		if(is_array($images)) {
			foreach( $images as $image ) {
				$hash = FileRepo::getHashPathForLevel( $image, 2 );
				$this->mDefaultAvatars[] = $this->mDefaultPath . $thumb . $hash . $image;
			}
		}

		wfProfileOut( __METHOD__ );

		return $this->mDefaultAvatars;
	}

	/**
	 * getUserName
	 *
	 * @access public
	 *
	 * @return String
	 */
	public function getUserName() {
		$username = '';
		if (isset($this->mUser)) {
			$username = $this->mUser->getName();
		}
		return $username;
	}

	/**
	 * setUserPageUrl -- set url for user page
	 *
	 * @access public
	 */
	public function setUserPageUrl($url) {
		$this->userPageUrl = $url;
	}

	/**
	 * getUserPageUrl -- url for user page
	 *
	 * @access public
	 */
	public function getUserPageUrl() {
		if ( isset($this->userPageUrl) )
			$url = $this->userPageUrl;
		else
			$url = $this->mUser->getUserPage()->getFullUrl();
		return $url;
	}

	/**
	 * setUrl -- set url for avatar - if set, it will override default behavior
	 *
	 * @access public
	 */
	public function setUrl($url) {
		$this->avatarUrl = $url;
	}

	/**
	 * getUrl -- read url from preferences or from defaults if preference is
	 * not set.
	 *
	 * @access public
	 *
	 * @param $thumb String  -- if defined will be added as part of base path
	 *      default empty string ""
	 *
	 * @return String
	 */
	public function getUrl( $thumb = "" ) {
		if (!empty($this->avatarUrl)) {
			return $this->avatarUrl;
		} else {
			$url = $this->getPurgeUrl($thumb); // get the basic URL
			return wfReplaceImageServer( $url, $this->mUser->getTouched() );
		}
	}

	/**
	 * getPurgeUrl -- the basic URL (without image server rewriting, cachebuster,
	 * etc.) of the avatar.  This can be sent to squid to purge it.
	 *
	 * @access public
	 *
	 * @param $thumb String  -- if defined will be added as part of base path
	 *      default empty string ""
	 *
	 * @return String
	 */
	public function getPurgeUrl( $thumb = "" ) {
		global $wgBlogAvatarPath;
		$url = $this->mUser->getOption( AVATAR_USER_OPTION_NAME );

		if( $url ) {
			/**
			 * if default avatar we glue with messaging.wikia.com
			 * if uploaded avatar we glue with common avatar path
			 */
			if( strpos( $url, '/' ) !== false ) {
				/**
				 * uploaded file, we are adding common/avatars path
				 */
				$url = $wgBlogAvatarPath . rtrim($thumb, '/') . $url;
			}
			else {
				/**
				 * default avatar, path from messaging.wikia.com
				 */
				$hash = FileRepo::getHashPathForLevel( $url, 2 );
				$url = $this->mDefaultPath . trim( $thumb,  '/' ) . '/' . $hash . $url;
			}
		}
		else {
			$defaults = $this->getDefaultAvatars( trim( $thumb,  "/" ) . "/" );
			$url = array_shift( $defaults );
		}

		return $url;
	}

	/**
	 * method for taking scaled avatars
	 * - avatar will be scaled by external image thumbnailer
	 * - external image thumbnailer use only width and scale it with the same
	 *   proportion as original
	 * - currently there's no thumbnail file, it's only cached on varnish and
	 *   generated on fly as needed
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak (eloy)
	 *
	 * @param width - the width of the thumbnail (height will be same propotion to width as in unscaled image)
	 * @param inPurgeFormat - boolean - if true, then the returned URL will be in the format used for purging
	 *                                  which means it will use images.wikia.com instead of a CDN hostname.
	 *
	 *
	 * @return string -- url to Avatar
	 */
	public function getThumbnail( $width, $inPurgeFormat = false, $avoidUpscaling = false ) {
		if( $avoidUpscaling && file_exists( $this->getFullPath() ) ) {
			list( $imageWidth ) = getimagesize( $this->getFullPath() );

			if( $width > $imageWidth ) {
					$width = $imageWidth;
			}
		}

		if($inPurgeFormat){
			$url = $this->getPurgeUrl( '/thumb/' );
		} else {
			$url = $this->getUrl( '/thumb/' );
		}

		return ImagesService::getThumbUrlFromFileUrl($url, $width);
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
	public function hasAvatar(){
		$hasAvatar = false;
		if (!empty($this->avatarUrl)) {
			$hasAvatar = true;
		} else {
			global $wgBlogAvatarPath;
			$url = $this->mUser->getOption( AVATAR_USER_OPTION_NAME );
			if( ( $url ) && ( strpos( $url, '/' ) !== false ) ){
				// uploaded file
				$hasAvatar = true;
			}
		}
		return $hasAvatar;
	} // end hasAvatar()

	/**
	 * getImageTag -- return HTML <img> tag
	 *
	 * @access public
	 *
	 * @param Integer $width default AVATAR_DEFAULT_WIDTH -- width of image
	 * @param Integer $height default AVATAR_DEFAULT_HEIGHT -- height of image
	 * @param String  $alt	-- alternate text
	 * @param String  $class -- which class should be used for element
	 * @param String  $id -- DOM identifier
	 */
	public function getImageTag( $width = AVATAR_DEFAULT_WIDTH, $height = AVATAR_DEFAULT_HEIGHT, $alt = false, $class = "avatar", $id = false ) {
		global $wgUser;

		wfProfileIn( __METHOD__ );

		$url = $this->getUrl();

		if ( ! $alt ) {
			$alt = '[' .$this->mUser->getName() .']';
		}
		$attribs = array (
			'src' 		=> $url,
			'border' 	=> 0,
			'width'		=> $width,
			'height'	=> $height,
			'alt' 		=> $alt,
		);
		if( $class ) {
			$attribs[ 'class' ] = $class;
			if( $wgUser->getID() == $this->mUser->getID( ) ) {
				$attribs[ 'class' ] .= ' avatar-self';
			}
		}
		if( $id ) {
			$attribs[ 'id' ] = $id;
		}

		wfProfileOut( __METHOD__ );
		return Xml::element( 'img', $attribs, '', true );
	}

	/**
	 * display -- return image with link to user page
	 *
	 * @param Integer $width default AVATAR_DEFAULT_WIDTH -- width of image
	 * @param Integer $height default AVATAR_DEFAULT_HEIGHT -- height of image
	 * @param String  $alt	-- alternate text
	 * @param String  $class -- which class should be used for element
	 * @param String  $id -- DOM identifier
	 * @param Boolean $showEditMenu
	 * @param String  $tracker -- what tracker to add, if any
	 */
	public function display( $width = AVATAR_DEFAULT_WIDTH, $height = AVATAR_DEFAULT_HEIGHT, $alt = false, $class = "avatar", $id = false, $showEditMenu = false, $tracker = false ) {

		wfProfileIn( __METHOD__ );
		$image = $this->getImageTag( $width, $height, $alt, $class, $id );
		$additionalAttribs = "";
		if (!empty($showEditMenu)) {
			$showEditDiv = "document.getElementById('wk-avatar-change').style.visibility='visible'";
			$hideEditDiv = "document.getElementById('wk-avatar-change').style.visibility='hidden'";
			$additionalAttribs = "onmouseover=\"{$showEditDiv}\" onmouseout=\"{$hideEditDiv}\"";
		}
		if( ! $this->mUser->isAnon() ) {
			$url = sprintf('<a href="%s" %s>%s</a>', $this->getUserPageUrl(), $additionalAttribs, $image );
		}
		else {
			$url = $image;
		}
		wfProfileOut( __METHOD__ );

		return $url;
	}

	/**
	 * getLocalPath -- create file path from user identifier
	 */
	public function getLocalPath() {

		if( $this->mPath ) {
			return $this->mPath;
		}

		wfProfileIn( __METHOD__ );

		$image  = sprintf('%s.png', $this->mUser->getID() );
		$hash   = sha1( (string)$this->mUser->getID() );
		$folder = substr( $hash, 0, 1).'/'.substr( $hash, 0, 2 );

		$this->mPath = "/{$folder}/{$image}";

		wfProfileOut( __METHOD__ );

		return $this->mPath;
	}

	/**
	 * getFullPath -- return full path for image
	 */
	public function getFullPath() {
		global $wgBlogAvatarDirectory;
		return $wgBlogAvatarDirectory.$this->getLocalPath();
	}

	/**
	 * isDefault -- check if user use default avatars
	 */
	public function isDefault() {
		$url = $this->mUser->getOption( AVATAR_USER_OPTION_NAME );
		if( $url ) {
			/**
			 * default avatar are only filenames without path
			 */
			if( strpos( $url, '/' ) !== false ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * removeFile -- remove file from directory
	 */
	public function removeFile( $addLog = true ) {
		wfProfileIn( __METHOD__ );
		global $wgLogTypes, $wgUser;

		$result = false;
		$sImageFull = $this->getFullPath();

		if( file_exists( $sImageFull ) ) {
			if (!unlink($sImageFull)) {
				wfDebug( __METHOD__.": cannot remove avatar's files {$sImageFull}\n" );
				$result = false;
			} else {
				$this->mUser->setOption( AVATAR_USER_OPTION_NAME, "" );
				$this->mUser->saveSettings();

				/* add log */
				if( !empty($addLog) ) {
					$this->__setLogType();
					$sUserText =  $this->mUser->getName();
					$mUserPage = Title::newFromText( $sUserText, NS_USER );
					$oLogPage = new LogPage( AVATAR_LOG_NAME );
					$oLogPage->addEntry( 'avatar_rem', $mUserPage, '', array($sUserText));
				}
				/* */
				$result = true;

				/**
				 * notice image replication system
				 */
				global $wgEnableUploadInfoExt;
				if( $wgEnableUploadInfoExt ) {
					UploadInfo::log( $mUserPage, $sImageFull, $this->getLocalPath(), "", "r" );
				}

				// remove thumbnails
				$this->purgeThumbnails();

				$errorNo = UPLOAD_ERR_OK;

			}
		}
		wfProfileOut( __METHOD__ );
		return $result;
	}

	private function __setLogType() {
		global $wgLogTypes;
		wfProfileIn(__METHOD__);
		if (!in_array(AVATAR_LOG_NAME, $wgLogTypes)) {
			$wgLogTypes[] = AVATAR_LOG_NAME;
		}
		wfProfileOut(__METHOD__);
	}

	/**
	 * While this is technically downloading the URL, the function's purpose is to be similar
	 * to uploadFile, but instead of having the file come from the user's computer, it comes
	 * from the supplied URL.
	 *
	 * @param String $url -- the full URL of an image to download and apply as the user's Avatar.
	 *
	 * @return Integer -- error code of operation
	 */
	public function uploadByUrl($url){
		wfProfileIn(__METHOD__);
		$sTmpFile = '';

		$errorNo = $this->uploadByUrlToTempFile($url, $sTmpFile);

		if( $errorNo == UPLOAD_ERR_OK ) {
			$errorNo = $this->postProcessImageInternal($sTmpFile, $errorNo);
		}

		wfProfileOut(__METHOD__);
		return $errorNo;
	} // end uploadByUrl()


	public function uploadByUrlToTempFile($url, &$sTmpFile){
		global $wgTmpDirectory;
		wfProfileIn(__METHOD__);

		$errorNo = UPLOAD_ERR_OK; // start by presuming there is no error.

		if( !isset( $wgTmpDirectory ) || !is_dir( $wgTmpDirectory ) ) {
			$wgTmpDirectory = '/tmp';
		}

		// Pull the image from the URL and save it to a temporary file.
		$sTmpFile = $wgTmpDirectory.'/'.substr(sha1(uniqid($this->mUser->getID())), 0, 16);
		$imgContent = Http::get($url);
		if( !file_put_contents($sTmpFile, $imgContent)){
			wfProfileOut( __METHOD__ );
			return UPLOAD_ERR_CANT_WRITE;
		}
		wfProfileOut(__METHOD__);
	}

	/**
	 * uploadFile -- save file when is in proper format, do resize and
	 * other stuffs
	 *
	 * @param Request $request -- WebRequest instance
	 * @param String $input    -- name of file input in form
	 * @param $errorMsg -- optional string containing details on what went wrong if there is an UPLOAD_ERR_EXTENSION.
	 *
	 * @return Integer -- error code of operation
	 */
	public function uploadFile($request, $input = AVATAR_UPLOAD_FIELD, &$errorMsg='') {
		global $wgTmpDirectory;
		wfProfileIn(__METHOD__);
		$this->__setLogType();

		if( !isset( $wgTmpDirectory ) || !is_dir( $wgTmpDirectory ) ) {
			$wgTmpDirectory = '/tmp';
		}
//		Wikia::log( __METHOD__, "tmp", "Temp directory set to {$wgTmpDirectory}" );

		$errorNo = $request->getUploadError( $input );
		if ( $errorNo != UPLOAD_ERR_OK ) {
//			Wikia::log( __METHOD__, "error", "Upload error {$errorNo}" );
			wfProfileOut(__METHOD__);
			return $errorNo;
		}

		$file = new WebRequestUpload($request, $input);
		$iFileSize = $file->getSize();

		if( empty( $iFileSize ) ) {
			/**
			 * file size = 0
			 */
//			Wikia::log( __METHOD__, 'empty', "Empty file {$input} reported size {$iFileSize}" );
			wfProfileOut(__METHOD__);
			return UPLOAD_ERR_NO_FILE;
		}

		$sTmpFile = $wgTmpDirectory.'/'.substr(sha1(uniqid($this->mUser->getID())), 0, 16);
//		Wikia::log( __METHOD__, 'tmp', "Temp file set to {$sTmpFile}" );
		$sTmp = $request->getFileTempname($input);
//		Wikia::log( __METHOD__, 'path', "Path to uploaded file is {$sTmp}" );


		if( move_uploaded_file( $sTmp, $sTmpFile )  ) {
			$errorNo = $this->postProcessImageInternal($sTmpFile, $errorNo, $errorMsg);
		}
		else {
//			Wikia::log( __METHOD__, 'move', sprintf('Cannot move uploaded file from %s to %s', $sTmp, $sTmpFile ));
			$errorNo = UPLOAD_ERR_CANT_WRITE;
		}
		wfProfileOut(__METHOD__);
		return $errorNo;
	}

	/**
	 * Given the filename of the temporary image, post-process the image to be the right size, format, etc.
	 *
	 * Returns an error code if there is an error or UPLOAD_ERR_OK if there were no errors.
	 *
	 * @param String $sTmpFile -- the full path to the temporary image file (will be deleted after processing).
	 * @param $errorNo -- optional initial error-code state.
	 * @param $errorMsg -- optional string containing details on what went wrong if there is an UPLOAD_ERR_EXTENSION.
	 */
	private function postProcessImageInternal($sTmpFile, &$errorNo = UPLOAD_ERR_OK, &$errorMsg=''){
		wfProfileIn(__METHOD__);
		$aImgInfo = getimagesize($sTmpFile);

		/**
		 * check if mimetype is allowed
		 */
		$aAllowMime = array( 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png', 'image/x-png', 'image/jpg' );
		if (!in_array($aImgInfo['mime'], $aAllowMime)) {
			global $wgLang;

			// This seems to be the most appropriate error message to describe that the image type is invalid.
			// Available error codes; http://php.net/manual/en/features.file-upload.errors.php
			$errorNo = UPLOAD_ERR_EXTENSION;
			$errorMsg = wfMsg('blog-avatar-error-type', $aImgInfo['mime'], $wgLang->listToText( $aAllowMime ) );

//				Wikia::log( __METHOD__, 'mime', $errorMsg);
			wfProfileOut(__METHOD__);
			return $errorNo;
		}

		switch ($aImgInfo['mime']) {
			case 'image/gif':
				$oImgOrig = @imagecreatefromgif($sTmpFile);
				break;
			case 'image/pjpeg':
			case 'image/jpeg':
			case 'image/jpg':
				$oImgOrig = @imagecreatefromjpeg($sTmpFile);
				break;
			case 'image/x-png':
			case 'image/png':
				$oImgOrig = @imagecreatefrompng($sTmpFile);
				break;
		}
		$aOrigSize = array('width' => $aImgInfo[0], 'height' => $aImgInfo[1]);

		/**
		 * generate new image to png format
		 */
		$addedAvatars = array();
		$sFilePath = $this->getFullPath();

		$ioh = new ImageOperationsHelper();
		$oImg = $ioh->postProcess(  $oImgOrig, $aOrigSize );

		/**
		 * save to new file ... but create folder for it first
		 */
		if ( !is_dir( dirname( $sFilePath ) ) && !wfMkdirParents( dirname( $sFilePath ) ) ) {
			wfDebugLog( "avatar", __METHOD__ . sprintf( ": Cannot create directory %s", dirname( $sFilePath ) ), true );
			wfProfileOut( __METHOD__ );
			return UPLOAD_ERR_CANT_WRITE;
		}

		if( !imagepng( $oImg, $sFilePath ) ) {
			wfDebugLog( "avatar", __METHOD__ . ": Cannot save png Avatar: $sFilePath", true);
			$errorNo = UPLOAD_ERR_CANT_WRITE;
		}
		else {
			/* remove tmp file */
			imagedestroy($oImg);

			$sUserText =  $this->mUser->getName();
			$mUserPage = Title::newFromText( $sUserText, NS_USER );
			$oLogPage = new LogPage( AVATAR_LOG_NAME );
			$oLogPage->addEntry( 'avatar_chn', $mUserPage, '');
			unlink($sTmpFile);

			/**
			 * notify image replication system
			 */
			global $wgEnableUploadInfoExt;
			if( $wgEnableUploadInfoExt ) {
				UploadInfo::log( $mUserPage, $sFilePath, $this->getLocalPath() );
			}

			// remove generated thumbnails
			$this->purgeThumbnails();

			$errorNo = UPLOAD_ERR_OK;
		}
		wfProfileOut( __METHOD__ );

		return $errorNo;
	} // end postProcessImageInternal()


	function purgeUrl() {
		// Purge the avatar URL and the proportions commonly used in Oasis.
		global $wgUseSquid;
		if ( $wgUseSquid ) {
			// FIXME: is there a way to know what sizes will be used w/o hardcoding them here?
			$urls = array(
				$this->getPurgeUrl(),
				$this->getThumbnailPurgeUrl(20), # user-links & history dropdown
				$this->getThumbnailPurgeUrl(50), # article-comments
				$this->getThumbnailPurgeUrl(100), # user-profile
				$this->getThumbnailPurgeUrl(200) # user-profile
			);

			SquidUpdate::purge($urls);
		}
	}

	/**
	 * @param $article
	 * @param User $user
	 * @param $text
	 * @param $summary
	 * @param $minoredit
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param $revision
	 * @param $status
	 * @param $baseRevId
	 * @return bool
	 */
	static public function userMastheadInvalidateCache(&$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		if (!$user->isAnon()) {
			if(count($status->errors) == 0) {
				global $wgMemc;
				$mastheadDataEditCountKey = wfMemcKey('mmastheadData-editCount-' . $user->getID());
				$wgMemc->incr($mastheadDataEditCountKey);
			}

		}
		return true;
	}

	/**
	 * @brief remove thumbnails for avatar by cleaning up whole folder
	 *
	 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
	 * @access private
	 *
	 * @return boolean status of operation
	 */
	private function purgeThumbnails( ) {
		// get path to thumbnail folder
		wfProfileIn( __METHOD__ );

		// dirty hack, should work in this case
		$dir = $this->getFullPath( );
		$dir = str_replace( "/avatars/", "/avatars/thumb/", $dir );
		if( is_dir( $dir )  ) {
			$files = array();
			// copied from LocalFile->getThumbnails
			$handle = opendir( $dir );

			if ( $handle ) {
				while ( false !== ( $file = readdir( $handle ) ) ) {
					if ( $file{0} != '.' ) {
						$files[] = $file;
					}
				}
				closedir( $handle );
			}

			// copied from LocalFile->purgeThumbnails()
			$urls = array();
			$urls[] = $this->getPurgeUrl( "/thumb/" );
			foreach( $files as $file ) {
				@unlink( "$dir/$file" );
				$url = $this->getPurgeUrl( '/thumb/' ) . "/$file" ;
				$urls[] = $url;
				wfDebugLog( "avatar", __METHOD__ . ": removing $dir/$file and purging $url\n", true );
			}
		}
		else {
			wfDebugLog( "avatar", __METHOD__ . ": $dir exists but is not directory so not removed.\n", true );
		}
		wfProfileOut( __METHOD__ );
	}
}
