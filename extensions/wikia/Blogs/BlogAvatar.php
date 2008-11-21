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
		$oAvatarObj = new BlogAvatar($oUser->getID());
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

    public function __construct($iUserId) {
    	wfProfileIn( __METHOD__ );
    	global $wgMessageCache;
		global $wgWikiaAvatarUrlPath;

		/* default settings */
		$this->__setUser($iUserId);

        /* load messages (if not already added) */
        wfLoadExtensionMessages("Blogs");
        wfProfileOut( __METHOD__ );
	}

	/**
	 * static constructor/helper
	 *
	 * @static
	 * @access public
	 */
	public static function newFromUser( $User ) {
		return self::newFromUserId( $User->getId() );
	}

	public static function newFromUserID( $iUserId ) {
		wfProfileIn( __METHOD__ );
		if ($iUserId > 0) {
			$oUserAvatar = new BlogAvatar($iUserId);
		} else {
			$oUserAvatar = NULL;
		}
		wfProfileOut( __METHOD__ );
		return $oUserAvatar;
	}

	private function __setUser($iUserId) {
		wfProfileIn( __METHOD__ );
		$this->iUserID = $iUserId;
		$this->oUser = User::newFromId($iUserId);
		if (is_object( $this->oUser ) && !is_null( $this->oUser )) {
			$this->oUser->load();
			$sAvatarPath = $this->oUser->getOption(AVATAR_USER_OPTION_NAME);
			if (!empty($sAvatarPath)) {
				wfDebug( __METHOD__.": found avatar for user {$iUserId}: $sAvatarPath\n" );
				$this->sAvatarPath = $sAvatarPath;
			}
        }
        wfProfileOut( __METHOD__ );
	}

	public function getDefaultAvatars() {
		global $parserMemc, $wgLang, $wgContLang;
		global $wgWikiaAvatarDefaultImagesMsg;

		$aImgDefPaths = array();
		wfProfileIn( __METHOD__ );
		if (!empty($wgWikiaAvatarDefaultImagesMsg)) {
			$aLines = explode( "\n", wfMsgForContent( $wgWikiaAvatarDefaultImagesMsg ) );
			wfDebug( __METHOD__.": found ".count($aLines)." default avatars\n" );
			foreach ($aLines as $sLine) {
				if (strpos($sLine, '*') !== 0) {
					continue;
				} else {
					$sLine = trim($sLine, '* ');
					$aImgDefPaths[] = $sLine;
				}
			}
		}
    	wfProfileOut( __METHOD__ );
    	return $aImgDefPaths;
	}

	public function isDefault() {
		wfProfileIn( __METHOD__ );
		$sImageFull = $this->getAvatarFileName();
		if ( file_exists($sImageFull) ) {
			$this->bDefault = false;
		}
		else {
			$this->bDefault = true;
		}
		wfProfileOut( __METHOD__ );
		return $this->bDefault;
	}

	public function getAvatarImageTag($iWidth = AVATAR_DEFAULT_WIDTH, $iHeight = AVATAR_DEFAULT_HEIGHT, $sAlt = '') {
		wfProfileIn( __METHOD__ );
		$sPath = $this->getAvatarUrlName();
		if ( empty($sAlt) ) {
			$sAlt = wfMsg('avatar-blog-alt');
		}
		wfProfileOut( __METHOD__ );
		return Xml::element( 'img', array (
				'src' 		=> $sPath,
				'border' 	=> 0,
				'width'		=> $iWidth,
				'height'	=> $iHeight,
				'alt' 		=> $sAlt
			), '', true );
	}

	public function getAvatarImageTagWithLink($iWidth = AVATAR_DEFAULT_WIDTH, $iHeight = AVATAR_DEFAULT_HEIGHT, $sAlt = '', $sLinkType = 'upload') {
		global $wgUser;
		wfProfileIn( __METHOD__ );

		$sPath = $this->getAvatarImageTag($iWidth, $iHeight, $sAlt);
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
		wfProfileIn( __METHOD__ );
		global $wgWikiaAvatarUrlPath, $wgWikiaAvatarDefaultImage;
		$sFilePath = $wgWikiaAvatarDefaultImage;
		if (!empty($this->oUser)) {
			$sFilePath = $this->oUser->getOption(AVATAR_USER_OPTION_NAME);
			/*
			error_log ("getAvatarUrlName = ".$sFilePath."\n", 3, "/tmp/moli.log");
			if ( !empty($sFilePath) ) {
				error_log ("getAvatarUrlName (1) = ".strpos($sFilePath, 'http://')."\n", 3, "/tmp/moli.log");
				if ( strpos($sFilePath, 'http://') === FALSE ) {
					//$sFilePath = $wgWikiaAvatarUrlPath . $sFilePath;
				}
			}*/
		}
		error_log ("getAvatarUrlName (2) = ".$sFilePath."\n", 3, "/tmp/moli.log");
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
