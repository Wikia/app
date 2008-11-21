<?php
/**
 * Avatar extension
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

$wgHooks['AdditionalUserProfilePreferences'][] = "wfLoadBlogAvatarForm";
$wgHooks['SavePreferences'][] = "wfSaveBlogAvatarForm";

function wfLoadBlogAvatarForm(&$oPrefs, &$sHtml ) {
	global $wgUser, $wgCityId;
   	wfProfileIn( __METHOD__ );
	$oAvatarObj = new BlogAvatar($wgUser->getID());
	$aDefAvatars = $oAvatarObj->getDefaultAvatars();

	/* run template */
	$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
	$oTmpl->set_vars( array(
		"wgUser"		=> $wgUser,
		"sUserAvatar"	=> $wgUser->getOption(AVATAR_USER_OPTION_NAME),
		"cityId"		=> $wgCityId,
		"aDefAvatars"	=> $aDefAvatars,
		"oAvatarObj"	=> $oAvatarObj,
		"sUserImg"		=> $oAvatarObj->getAvatarUrlName(),
		"imgH"			=> AVATAR_DEFAULT_HEIGHT,
		"imgW"			=> AVATAR_DEFAULT_WIDTH,
		"sFieldName"	=> AVATAR_UPLOAD_FIELD,
	) );

	$sHTML .= wfHidden( 'MAX_FILE_SIZE', AVATAR_MAX_SIZE );
	#---
	$sHtml .= $oTmpl->execute("pref-avatar-form");
   	wfProfileOut( __METHOD__ );
	return true;
}

function wfSaveBlogAvatarForm ($oPrefs, $oUser, &$sMsg, $oldOptions) {
	global $wgRequest;
   	wfProfileIn( __METHOD__ );
   	$result = true;

	Wikia::log( __METHOD__, "request", print_r($wgRequest, true) );
	Wikia::log( __METHOD__, "files", print_r( $_FILES, true) );

	$sUrl = $wgRequest->getVal( 'wkDefaultAvatar' );
	$sUploadedAvatar = $wgRequest->getFileName( AVATAR_UPLOAD_FIELD );

	/* is user trying to upload something */
	$isNotUploaded = ( empty( $sUploadedAvatar ) && empty( $sUrl ) );
	if ( !$isNotUploaded ) {
		$oAvatarObj = BlogAvatar::newFromUser( $oUser );
		/* check is set default avatar for user */
		if ( empty($sUrl) ) {
			/* upload user avatar */
			$isFileUploaded = $oAvatarObj->uploadAvatar($wgRequest);
			if ( !$isFileUploaded ) {
				$sMsg .= " Cannot save user's avatar ";
				$result = false;
			} else {
				$sUrl = $oAvatarObj->getAvatarUrlFull();
			}
		}
		wfDebug( __METHOD__.": selected avatar for user ".$oUser->getID().": $sUrl \n" );
		if ( !empty($sUrl) ) {
			/* set user option */
			$oUser->setOption( AVATAR_USER_OPTION_NAME, $sUrl );
		}
	}

   	wfProfileOut( __METHOD__ );
	return $result;
}

class BlogAvatar {
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

		//		$this->__setUser( $User );

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

	private function __setUser( $User ) {
		wfProfileIn( __METHOD__ );

		$this->oUser = $User;

		if( is_object( $this->oUser ) && !is_null( $this->oUser )) {
			$this->iUserID = $this->oUser->getId();

			$sAvatarPath = $this->oUser->getOption(AVATAR_USER_OPTION_NAME);
			if (!empty($sAvatarPath)) {
				wfDebug( __METHOD__.": found avatar for user {$iUserId}: $sAvatarPath\n" );
				$this->sAvatarPath = $sAvatarPath;
			}
        }
        wfProfileOut( __METHOD__ );
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
			$image = FileRepo::getHashPathForLevel( $image, 2 );
			$url = $uploadPath . '/' . $image;
			$this->mDefaultAvatars[] = $url;
		}
    	wfProfileOut( __METHOD__ );

    	return $this->mDefaultAvatars;
	}

	/**
	 * getImageURL -- return HTML <img> tag
	 *
	 * @access public
	 *
	 * @param Integer $width default AVATAR_DEFAULT_WIDTH -- width of image
	 * @param Integer $height default AVATAR_DEFAULT_HEIGHT -- height of image
	 * @param String  $alt	-- alternate text
	 */
	public function getImageURL( $width = AVATAR_DEFAULT_WIDTH, $height = AVATAR_DEFAULT_HEIGHT, $alt = false ) {
		wfProfileIn( __METHOD__ );
		$path = $this->getAvatarUrlName();
		if ( ! $alt ) {
			$alt = $this->oUser->getName();
		}
		wfProfileOut( __METHOD__ );
		return Xml::element( 'img',
			array (
				'src' 		=> $path,
				'border' 	=> 0,
				'width'		=> $width,
				'height'	=> $height,
				'alt' 		=> $alt
			), '', true
		);
	}

	public function getLinkURL($iWidth = AVATAR_DEFAULT_WIDTH, $iHeight = AVATAR_DEFAULT_HEIGHT, $sAlt = '', $sLinkType = 'upload') {
		global $wgUser;
		wfProfileIn( __METHOD__ );

		$sPath = $this->getImageURL($iWidth, $iHeight, $sAlt);
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

	public function setAvatarFileName() {
		wfProfileIn( __METHOD__ );
		$iUserID = $this->iUserID;
		$sImage = "{$iUserID}.png";
		$sHash = sha1("{$iUserID}");
		$sDir = substr($sHash, 0, 1)."/".substr($sHash, 0, 2);
		wfProfileOut( __METHOD__ );
		return "{$sDir}/{$sImage}";
	}

	public function getAvatarFileFull() {
		global $wgWikiaAvatarDirectory;
		return $wgWikiaAvatarDirectory."/".$this->setAvatarFileName();
	}

	public function getAvatarUrlFull() {
		global $wgWikiaAvatarUrlPath;
		return $wgWikiaAvatarUrlPath."/".$this->setAvatarFileName();
	}

	public function getAvatarUrlName() {

		global $wgWikiaAvatarUrlPath, $wgWikiaAvatarDefaultImage;

		wfProfileIn( __METHOD__ );

		$sFilePath = $wgWikiaAvatarDefaultImage;

		if( !empty( $this->oUser ) ) {
			$sFilePath = $this->oUser->getOption( AVATAR_USER_OPTION_NAME );
			/**
			 * when avatar for this user is not set we return default avatar
			 */
			if( ! $sFilePath ) {
			}
		}
		wfProfileOut( __METHOD__ );
		return $sFilePath;
    }

	public function getAvatarFilePath() {
		wfProfileIn( __METHOD__ );
		global $wgWikiaAvatarDirectory, $wgWikiaAvatarDefaultImage;
		$sFilePath = $wgWikiaAvatarDefaultImage;
		if (!empty($this->oUser)) {
			$sTmpPath = $this->oUser->getOption(AVATAR_USER_OPTION_NAME);
			if ( !empty($sTmpPath) ) {
				if ( strpos($sTmpPath, 'http://') === FALSE ) {
					/* not found full url */
					$sTmpPath = $wgWikiaAvatarDirectory . $sTmpPath;
					if ( file_exists($sTmpPath) ) {
						$sFilePath = $sTmpPath;
					}
				} else {
					if ( !file_exists($sTmpPath) ) {
						$sFilePath = $wgWikiaAvatarDefaultImage;
					}
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return $sFilePath;
	}

	public function removeAvatarFile($iUserID) {
		wfProfileIn( __METHOD__ );
		global $wgLogTypes, $wgUser;

		$result = false;
		if ($this->iUserID == $wgUser->getID()) {
			$sImageFull = self::getAvatarFilePath($iUserID);
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

	public function uploadAvatar($request, $sFormField = AVATAR_UPLOAD_FIELD) {
		global $wgTmpDirectory;
		wfProfileIn(__METHOD__);

		$this->__setLogType();

		if (!isset($wgTmpDirectory) || empty($wgTmpDirectory)) {
			$wgTmpDirectory = "/tmp";
		}
		wfDebugLog( __METHOD__, "Temp directory set to {$wgTmpDirectory}" );

		$iErrNo = false;
		$iFileSize = $request->getFileSize($sFormField);
		error_log ( "iFileSize = $iFileSize \n", 3, "/tmp/moli.log" );
		if (empty($iFileSize)) {
			/* file size = 0 */
			wfDebugLog( __METHOD__, "Empty file: " . $sFormField );
			wfProfileOut(__METHOD__);
			return $iErrNo;
		}

		$sTmpFile = $wgTmpDirectory."/".substr(sha1(uniqid($this->oUser->getID())), 0, 16);
		error_log ( "sTmpFile = $sTmpFile \n", 3, "/tmp/moli.log" );
		wfDebugLog( __METHOD__, "Temp file set to {$sTmpFile}" );
		$sTmp = $request->getFileTempname($sFormField);
		error_log ( "sTmp = $sTmp \n", 3, "/tmp/moli.log" );
		wfDebugLog( __METHOD__, "Path to uploaded file is {$sTmp}" );

		if (move_uploaded_file($sTmp, $sTmpFile)) {
			$aImgInfo = getimagesize($sTmpFile);

			/* check if mimetype is allowed */
			$aAllowMime = array("image/jpeg", "image/pjpeg", "image/gif", "image/png", "image/x-png", "image/jpg", "image/bmp");
			error_log ( "aImgInfo[\"mime\"] = ".$aImgInfo["mime"]." \n", 3, "/tmp/moli.log" );
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
			error_log ( "oImgOrig = ".print_r($oImgOrig, true)." \n", 3, "/tmp/moli.log" );

			/* generate new image to png format */
			$addedAvatars = array();
			$sFilePath = $this->getAvatarFileFull();
			error_log ( "sFilePath = ".$sFilePath." \n", 3, "/tmp/moli.log" );
			/* calculate new image size - should be 100 x 100 */
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

			error_log ( "iImgW x iImgH = ".$iImgW." x ". $iImgH ." \n", 3, "/tmp/moli.log" );
			/* empty image with thumb size on white background */
			$oImg = @imagecreatetruecolor($iImgW, $iImgH);
			error_log ( "oImg - ".print_r($oImg, true)." \n", 3, "/tmp/moli.log" );
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
				error_log ( "imagepng - false \n", 3, "/tmp/moli.log" );
				wfDebugLog( __METHOD__, sprintf("Cannot save png Avatar: %s", $sFilePath ));
			} else {
				/* remove tmp file */
				imagedestroy($oImg);
				error_log ( "imagedestroy - false \n", 3, "/tmp/moli.log" );

				$sUserText =  $this->oUser->getName();
				$oUserBlogPage = Title::newFromText( $sUserText, NS_BLOG_ARTICLE );
				$oLogPage = new LogPage( AVATAR_LOG_NAME );
				$sLogComment = "Add/change avatar by {$sUserText}";
				$oLogPage->addEntry( AVATAR_LOG_NAME, $oUserBlogPage, $sLogComment);
				error_log ( "oLogPage->addEntry \n", 3, "/tmp/moli.log" );
				unlink($sTmpFile);
				$iErrNo = true;
			}
		} else {
			wfDebugLog( __METHOD__, sprintf("Cannot move uploaded file from %s to %s", $sTmp, $sTmpFile ));
			error_log ( "cannot move \n", 3, "/tmp/moli.log" );
		}
		wfProfileOut(__METHOD__);
		return $iErrNo;
	}
}
