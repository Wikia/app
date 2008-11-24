<?php
/**
 * Avatar extension
 *
 * @author Piotr Molski <moli@wikia-inc.com>
 * @uthor Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

define ("AVATAR_DEFAULT_WIDTH", 100);
define ("AVATAR_DEFAULT_HEIGHT", 100);
define ("AVATAR_LOG_NAME", 'useravatar');
define ("AVATAR_USER_OPTION_NAME", 'avatar');
define ("AVATAR_MAX_SIZE", 20000);
define ("AVATAR_UPLOAD_FIELD", 'wkUserAvatar');


$wgHooks['AdditionalUserProfilePreferences'][] = "BlogAvatar::additionalUserProfilePreferences";
$wgHooks['SavePreferences'][] = "BlogAvatar::savePreferences";


class BlogAvatar {

	/**
	 * path to file, relative
	 */
	public $mPath = false;

	/* user id */
	var $iUserID;
	/* user object */
	var $oUser;
	/* default image */
	var $bDefault = true;
	/* avatar path */
	var $sAvatarPath = "";

	/**
	 * city_id for messaging.wikia.com, will be used for creating image urls
	 */
	private $mMsgCityId = 4036;

	/**
	 * avatars from mediawiki message
	 */
	public $mDefaultAvatars = false;

    public function __construct( User $User ) {
    	wfProfileIn( __METHOD__ );

        wfLoadExtensionMessages( "Blogs" );
		$this->oUser = $User;

        wfProfileOut( __METHOD__ );
	}

	/**
	 * static constructor
	 *
	 * @static
	 * @access public
	 */
	public static function newFromUser( User $User ) {
		return new BlogAvatar( $User );
	}

	/**
	 * static constructor
	 */
	public static function newFromUserID( $userId ) {
		wfProfileIn( __METHOD__ );

		$User = User::newFromId( $userId );
		$User->load();
		$Avatar = new BlogAvatar( $User );

		wfProfileOut( __METHOD__ );
		return $Avatar;
	}

	/**
	 * static constructor
	 */
	public static function newFromUserName( $login ) {
		wfProfileIn( __METHOD__ );

		$User = User::newFromName( $login );
		$User->load();
		$Avatar = new BlogAvatar( $User );

		wfProfileOut( __METHOD__ );
		return $Avatar;
	}

	/**
	 * getDefaultAvatars -- get avatars stored in mediawiki message and return as
	 * 	array
	 *
	 * @author Piotr Molski <moli@wikia-inc.com>
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 */
	public function getDefaultAvatars() {

		/**
		 * parse message only once per request
		 */
		if( is_array( $this->mDefaultAvatars ) && count( $this->mDefaultAvatars )> 0) {
			return $this->mDefaultAvatars;
		}

		wfProfileIn( __METHOD__ );

		$uploadPath = WikiFactory::getVarValueByName( "wgUploadPath", $this->mMsgCityId );

		$this->mDefaultAvatars = array();
		$images = getMessageAsArray( "blog-avatar-defaults" );
		foreach( $images as $image ) {
			$hash = FileRepo::getHashPathForLevel( $image, 2 );
			$url = $uploadPath . $hash . $image;
			$this->mDefaultAvatars[] = $url;
		}
    	wfProfileOut( __METHOD__ );

    	return $this->mDefaultAvatars;
	}


	/**
	 * getUrl -- read url from preferences or from defaults if preference is
	 * not set
	 *
	 * @access private
	 *
	 * @return String
	 */
	public function getUrl() {
		$url = $this->oUser->getOption( AVATAR_USER_OPTION_NAME );
		if( $url ) {
			return $url;
		}
		$defaults = $this->getDefaultAvatars();
		return array_shift( $defaults );
	}

	/**
	 * getImageTag -- return HTML <img> tag
	 *
	 * @access public
	 *
	 * @param Integer $width default AVATAR_DEFAULT_WIDTH -- width of image
	 * @param Integer $height default AVATAR_DEFAULT_HEIGHT -- height of image
	 * @param String  $alt	-- alternate text
	 */
	public function getImageTag( $width = AVATAR_DEFAULT_WIDTH, $height = AVATAR_DEFAULT_HEIGHT, $alt = false ) {
		wfProfileIn( __METHOD__ );

		$url = $this->getUrl();

		if ( ! $alt ) {
			$alt = "[" .$this->oUser->getName() ."]";
		}
		wfProfileOut( __METHOD__ );
		return Xml::element( 'img',
			array (
				'src' 		=> $url,
				'border' 	=> 0,
				'width'		=> $width,
				'height'	=> $height,
				'alt' 		=> $alt,
				"class"		=> "avatar"
			), '', true
		);
	}

	public function getLinkTag($iWidth = AVATAR_DEFAULT_WIDTH, $iHeight = AVATAR_DEFAULT_HEIGHT, $sAlt = '', $sLinkType = 'upload') {
		global $wgUser;
		wfProfileIn( __METHOD__ );

		$sPath = $this->getImageTag($iWidth, $iHeight, $sAlt);
		$oSkin = $wgUser->getSkin();

		/* check if this avatar is for wgUser or another */
		if ($this->iUserID == $wgUser->getID()) {
			switch ($sLinkType) {
				case 'upload':
					$sPath = $oSkin->makeLinkObj(Title::newFromText('Preferences', NS_SPECIAL), $sPath);
					break;
				case 'user'	:
					$sPath = $oSkin->userLink($wgUser->getId(), $sPath);
					break;
				default		: /* no link ? */
					break;
			}
		} else {
			/* never show links */
			$sPath = "";
		}

		wfProfileOut( __METHOD__ );
		return $sPath;
	}

	/**
	 * getLocalPath -- create file path from user identifier
     */
	public function getLocalPath() {

		if( $this->mPath ) {
			return $this->mPath;
		}

		wfProfileIn( __METHOD__ );

		$image  = "{$this->iUserID}.png";
		$hash   = sha1( "{$this->iUserID}" );
		$folder = substr( $hash, 0, 1)."/".substr( $hash, 0, 2 );

		$this->mPath = "{$folder}/{$image}";

		wfProfileOut( __METHOD__ );

		return $this->mPath;
	}

	public function getFullPath() {
		global $wgWikiaAvatarDirectory;
		return $wgWikiaAvatarDirectory."/".$this->getLocalPath();
	}

	/**
	 * getFullURL -- return full url to avatar image
	 */
	public function getFullURL() {
		global $wgWikiaAvatarPath;
		return $wgWikiaAvatarPath."/".$this->getLocalPath();
	}

	/**
	 * removeFile -- remove file from directory
	 */
	public function removeFile($iUserID) {
		wfProfileIn( __METHOD__ );
		global $wgLogTypes, $wgUser;

		$result = false;
		if ($this->iUserID == $wgUser->getID()) {
			$sImageFull = $this->getFullPath();

			if (file_exists($sImageFull)) {
				if (!unlink($sImageFull)) {
					wfDebug( __METHOD__.": cannot remove avatar's files {$sImageFull}\n" );
					$result = false;
				} else {
					/* add log */
					$this->__setLogType();
					$sUserText =  $this->oUser->getName();
					$oUserBlogPage = Title::newFromText( $sUserText, NS_BLOG_ARTICLE );
					$oLogPage = new LogPage( AVATAR_LOG_NAME );
					$sLogComment = "Remove {$sUserText}'s avatars by {$wgUser->getName()}";
					$oLogPage->addEntry( AVATAR_LOG_NAME, $oUserBlogPage, $sLogComment);
					/* */
					$result = true;
				}
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
	 * uploadFile -- save file when is in proper format, do resize and
	 * other stuffs
	 *
	 */
	public function uploadFile($request, $sFormField = AVATAR_UPLOAD_FIELD) {
		global $wgTmpDirectory;
		wfProfileIn(__METHOD__);

		$this->__setLogType();

		if (!isset($wgTmpDirectory) || empty($wgTmpDirectory)) {
			$wgTmpDirectory = "/tmp";
		}
		Wikia::log( __METHOD__, "tmp", "Temp directory set to {$wgTmpDirectory}" );

		$iErrNo = false;
		$iFileSize = $request->getFileSize($sFormField);

		if (empty($iFileSize)) {
			/**
			 * file size = 0
			 */
			wfDebugLog( __METHOD__, "Empty file: " . $sFormField );
			wfProfileOut(__METHOD__);
			return $iErrNo;
		}

		$sTmpFile = $wgTmpDirectory."/".substr(sha1(uniqid($this->oUser->getID())), 0, 16);
		Wikia::log( __METHOD__, "tmp", "Temp file set to {$sTmpFile}" );
		$sTmp = $request->getFileTempname($sFormField);
		Wikia::log( __METHOD__, "path", "Path to uploaded file is {$sTmp}" );

		if( move_uploaded_file( $sTmp, $sTmpFile )  ) {
			$aImgInfo = getimagesize($sTmpFile);

			/* check if mimetype is allowed */
			$aAllowMime = array("image/jpeg", "image/pjpeg", "image/gif", "image/png", "image/x-png", "image/jpg", "image/bmp");
			if (!in_array($aImgInfo["mime"], $aAllowMime)) {
				wfDebugLog( __METHOD__, "Imvalid mime type - allowed: " . implode(",", $aAllowMime) );
				wfProfileOut(__METHOD__);
				return $iErrNo;
			}

			switch ($aImgInfo["mime"]) {
				case "image/gif":
					$oImgOrig = @imagecreatefromgif($sTmpFile);
					break;
				case "image/pjpeg":
				case "image/jpeg":
				case "image/jpg":
					$oImgOrig = @imagecreatefromjpeg($sTmpFile);
					break;
				case "image/bmp":
					$oImgOrig = @imagecreatefrombmp($sTmpFile);
					break;
				case "image/x-png":
				case "image/png":
					$oImgOrig = @imagecreatefrompng($sTmpFile);
					break;
			}
			$aOrigSize = array("width" => $aImgInfo[0], "height" => $aImgInfo[1]);

			/**
			 * generate new image to png format
			 */
			$addedAvatars = array();
			$sFilePath = $this->getFullPath();

			/**
			 * calculate new image size - should be 100 x 100
			 */
			$iImgW = AVATAR_DEFAULT_WIDTH;
			$iImgH = AVATAR_DEFAULT_HEIGHT;
			/* WIDTH > HEIGHT */
			if ( $aOrigSize["width"] > $aOrigSize["height"] ) {
				$iImgH = $iImgW * ( $aOrigSize["height"] / $aOrigSize["width"] );
			}
			/* HEIGHT > WIDTH */
			if ( $aOrigSize["width"] < $aOrigSize["height"] ) {
				$iImgW = $iImgH * ( $aOrigSize["width"] / $aOrigSize["height"] );
			}

			/* empty image with thumb size on white background */
			$oImg = @imagecreatetruecolor($iImgW, $iImgH);
			$white = imagecolorallocate($oImg, 255, 255, 255);
			imagefill($oImg, 0, 0, $white);

			imagecopyresampled(
				$oImg,
				$oImgOrig,
				floor ( ( AVATAR_DEFAULT_WIDTH - $iImgW ) / 2 ) /*dx*/,
				floor ( ( AVATAR_DEFAULT_HEIGHT - $iImgH ) / 2 ) /*dy*/,
				0 /*sx*/,
				0 /*sy*/,
				$iImgW /*dw*/,
				$iImgH /*dh*/,
				$aOrigSize["width"]/*sw*/,
				$aOrigSize["height"]/*sh*/
			);

			/* save to new file */
			if ( !imagepng($oImg, $sFilePath) ) {
				Wikia::log( __METHOD__, "save", sprintf("Cannot save png Avatar: %s", $sFilePath ));
			} else {
				/* remove tmp file */
				imagedestroy($oImg);

				$sUserText =  $this->oUser->getName();
				$oUserBlogPage = Title::newFromText( $sUserText, NS_BLOG_ARTICLE );
				$oLogPage = new LogPage( AVATAR_LOG_NAME );
				$sLogComment = "Add/change avatar by {$sUserText}";
				$oLogPage->addEntry( AVATAR_LOG_NAME, $oUserBlogPage, $sLogComment);
				unlink($sTmpFile);
				$iErrNo = true;
			}
		} else {
			Wikia::log( __METHOD__, "move", sprintf("Cannot move uploaded file from %s to %s", $sTmp, $sTmpFile ));
		}
		wfProfileOut(__METHOD__);
		return $iErrNo;
	}

	/**
	 * AdditionalUserProfilePreferences -- Hook handler
	 *
	 * @param PreferencesForm $oPrefs  -- preferences form instance
	 * @param String $html -- generated html
	 */
	static public function additionalUserProfilePreferences( &$oPrefs, &$html) {
		global $wgUser, $wgCityId;
		wfProfileIn( __METHOD__ );
		$oAvatarObj = BlogAvatar::newFromUser( $wgUser );
		$aDefAvatars = $oAvatarObj->getDefaultAvatars();

		/**
		 * run template
		 */
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"wgUser"		=> $wgUser,
			"sUserAvatar"	=> $wgUser->getOption(AVATAR_USER_OPTION_NAME),
			"cityId"		=> $wgCityId,
			"aDefAvatars"	=> $aDefAvatars,
			"oAvatarObj"	=> $oAvatarObj,
			"sUserImg"		=> $oAvatarObj->getFullURL(),
			"imgH"			=> AVATAR_DEFAULT_HEIGHT,
			"imgW"			=> AVATAR_DEFAULT_WIDTH,
			"sFieldName"	=> AVATAR_UPLOAD_FIELD,
		) );

		$html = wfHidden( 'MAX_FILE_SIZE', AVATAR_MAX_SIZE );
		$html .= $oTmpl->execute("pref-avatar-form");

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * AdditionalUserProfilePreferences -- Hook handler
	 *
	 * @param PreferencesForm $oPrefs  -- preferences form instance
	 * @param User $User -- user object
	 * @param String $sMsg -- status message
	 * @param $oldOptions
	 */
	static public function savePreferences( $oPrefs, $oUser, &$sMsg, $oldOptions ) {
		global $wgRequest;
		wfProfileIn( __METHOD__ );
		$result = true;

		$sUrl = wfBasename( $wgRequest->getVal( 'wkDefaultAvatar' ) );
		$sUploadedAvatar = $wgRequest->getFileName( AVATAR_UPLOAD_FIELD );

		/**
		 * we store in different way default and uploaded pictures
		 *
		 * default: we store only filename
		 * uploaded: we store relative path to filename
		 */

		/**
		 * is user trying to upload something
		 */
		$isNotUploaded = ( empty( $sUploadedAvatar ) && empty( $sUrl ) );
		if ( !$isNotUploaded ) {
			$oAvatarObj = BlogAvatar::newFromUser( $oUser );
			/* check is set default avatar for user */
			if ( empty($sUrl) ) {
				/* upload user avatar */
				$isFileUploaded = $oAvatarObj->uploadFile( $wgRequest );
				if ( !$isFileUploaded ) {
					$sMsg .= " Cannot save user's avatar ";
					$result = false;
				} else {
					$sUrl = $oAvatarObj->getFullURL();
				}
				Wikia::log( __METHOD__, "url", $sUrl );
			}


			if ( !empty($sUrl) ) {
				/* set user option */
				$oUser->setOption( AVATAR_USER_OPTION_NAME, $sUrl );
			}
		}
		Wikia::log( __METHOD__, "url", "selected avatar for user ".$oUser->getID().": $sUrl" );

		wfProfileOut( __METHOD__ );
		return $result;
	}
}
