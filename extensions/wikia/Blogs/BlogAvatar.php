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
define ("AVATAR_MAX_SIZE", 512000 );
define ("AVATAR_UPLOAD_FIELD", 'wkUserAvatar');


$wgHooks['AdditionalUserProfilePreferences'][] = "BlogAvatar::additionalUserProfilePreferences";
$wgHooks['SavePreferences'][] = "BlogAvatar::savePreferences";
$wgHooks['MonacoBeforePageBar'][] = "BlogAvatar::userMasthead";


$wgExtensionCredits['specialpage'][] = array(
    "name" => "RemoveAvatar",
    "description" => "Remove User's avatars",
    "author" => "Krzysztof Krzyzaniak (eloy) <eloy@wikia-inc.com>, Piotr Molski (moli) <moli@wikia-inc.com>"
);

#--- register special page (MW 1.10 way)
if ( !function_exists( 'extAddSpecialPage' ) ) {
    require( "$IP/extensions/ExtensionFunctions.php" );
}

/**
 * messages file
 */
if (!array_key_exists("Blogs", $wgExtensionMessagesFiles)) {
	$wgExtensionMessagesFiles["Blogs"] = dirname(__FILE__) . '/Blogs.i18n.php';
}

#--- permissions
$wgAvailableRights[] = 'removeavatar';
$wgGroupPermissions['staff']['removeavatar'] = true;
$wgGroupPermissions['sysop']['removeavatar'] = true;
extAddSpecialPage( '', 'RemoveAvatar', 'BlogAvatarRemovePage' );
$wgSpecialPageGroups['RemoveAvatar'] = 'users';

class BlogAvatar {

	/**
	 * default avatar path
	 */
	public $mDefaultPath = "http://images.wikia.com/messaging/images/";

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

	public function __construct( User $User ) {
		wfProfileIn( __METHOD__ );
		$this->mUser = $User;
		wfLoadExtensionMessages("Blogs");
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
	 * @static
	 * @access public
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
	 *
	 * @static
	 * @access public
	 */
	public static function newFromUserName( $login ) {
		wfProfileIn( __METHOD__ );

		$User = User::newFromName( $login );
		if( $User ) {
			$User->load();
			$Avatar = new BlogAvatar( $User );
		}
		else {
			/**
			 * anonymous
			 */
			$Avatar = BlogAvatar::newFromUserID( 0 );
		}
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

		$this->mDefaultAvatars = array();
		$images = getMessageAsArray( "blog-avatar-defaults" );

		foreach( $images as $image ) {
			$hash = FileRepo::getHashPathForLevel( $image, 2 );
			$this->mDefaultAvatars[] = $this->mDefaultPath . $hash . $image;
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
		$username = "";
		if (isset($this->mUser)) {
			$username = $this->mUser->getName();
		}
		return $username;
	}

	/**
	 * getUrl -- read url from preferences or from defaults if preference is
	 * not set.
	 *
	 * @access private
	 *
	 * @return String
	 */
	public function getUrl() {
		global $wgBlogAvatarPath;
		$url = $this->mUser->getOption( AVATAR_USER_OPTION_NAME );
		if( $url ) {
			/**
			 * if default avatar we glue with messaging.wikia.com
			 * if uploaded avatar we glue with common avatar path
			 */
			if( strpos( $url, "/" ) !== false ) {
				/**
				 * uploaded file, we are adding common/avatars path
				 */
				$url = $wgBlogAvatarPath . $url . "?" . $this->mUser->mTouched;
			}
			else {
				/**
				 * default avatar, path from messaging.wikia.com
				 */
				$hash = FileRepo::getHashPathForLevel( $url, 2 );
				$url = $this->mDefaultPath . $hash . $url;
			}
		}
		else {
			$defaults = $this->getDefaultAvatars();
			$url = array_shift( $defaults );
		}
		
		return wfReplaceImageServer( $url );
	}

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
		Wikia::log( __METHOD__, "url", $url );

		if ( ! $alt ) {
			$alt = "[" .$this->mUser->getName() ."]";
		}
		$attribs = array (
			'src' 		=> $url,
			'border' 	=> 0,
			'width'		=> $width,
			'height'	=> $height,
			'alt' 		=> $alt,
		);
		if( $class ) {
			$attribs[ "class" ] = $class;
			if( $wgUser->getID() == $this->mUser->getID( ) ) {
				$attribs[ "class" ] .= " avatar-self";
			}
		}
		if( $id ) {
			$attribs[ "id" ] = $id;
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
	 */
	public function display( $width = AVATAR_DEFAULT_WIDTH, $height = AVATAR_DEFAULT_HEIGHT, $alt = false, $class = "avatar", $id = false, $showEditMenu = false ) {

		wfProfileIn( __METHOD__ );
		$image = $this->getImageTag( $width, $height, $alt, $class, $id );
		$additionalAttribs = "";
		if (!empty($showEditMenu)) {
			$showEditDiv = "document.getElementById('wk-avatar-change').style.visibility='visible'";
			$hideEditDiv = "document.getElementById('wk-avatar-change').style.visibility='hidden'";
			$additionalAttribs = "onmouseover=\"{$showEditDiv}\" onmouseout=\"{$hideEditDiv}\"";
		}
		if( ! $this->mUser->isAnon() ) {
			$url = sprintf("<a href=\"%s\" %s>%s</a>", $this->mUser->getUserPage()->getFullUrl(), $additionalAttribs, $image );
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

		$image  = sprintf("%s.png", $this->mUser->getID() );
		$hash   = sha1( (string)$this->mUser->getID() );
		$folder = substr( $hash, 0, 1)."/".substr( $hash, 0, 2 );

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
			if( strpos( $url, "/" ) !== false ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * removeFile -- remove file from directory
	 */
	public function removeFile() {
		wfProfileIn( __METHOD__ );
		global $wgLogTypes, $wgUser;

		$result = false;
		$sImageFull = $this->getFullPath();

		if (file_exists($sImageFull)) {
			if (!unlink($sImageFull)) {
				wfDebug( __METHOD__.": cannot remove avatar's files {$sImageFull}\n" );
				$result = false;
			} else {
				/* add log */
				$this->__setLogType();
				$sUserText =  $this->mUser->getName();
				$this->mUser->setOption( AVATAR_USER_OPTION_NAME, "" );
				$this->mUser->saveSettings();
				$mUserBlogPage = Title::newFromText( $sUserText, NS_BLOG_ARTICLE );
				$oLogPage = new LogPage( AVATAR_LOG_NAME );
				$sLogComment = "Remove {$sUserText}'s avatars by {$wgUser->getName()}";
				$oLogPage->addEntry( AVATAR_LOG_NAME, $mUserBlogPage, $sLogComment);
				/* */
				$result = true;
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
	 * @param Request $request -- WebRequest instance
	 * @param String $input    -- name of file input in form
	 *
	 * @return Integer -- error code of operation
	 */
	public function uploadFile($request, $input = AVATAR_UPLOAD_FIELD) {
		global $wgTmpDirectory;
		wfProfileIn(__METHOD__);

		$this->__setLogType();

		if( !isset( $wgTmpDirectory ) || !is_dir( $wgTmpDirectory ) ) {
			$wgTmpDirectory = "/tmp";
		}
		Wikia::log( __METHOD__, "tmp", "Temp directory set to {$wgTmpDirectory}" );

		$errorNo = $request->getUploadError( $input );
		if ( $errorNo != UPLOAD_ERR_OK ) {
			Wikia::log( __METHOD__, "error", "Upload error {$errorNo}" );
			wfProfileOut(__METHOD__);
			return $errorNo;
		}
		$iFileSize = $request->getFileSize( $input );

		if( empty( $iFileSize ) ) {
			/**
			 * file size = 0
			 */
			Wikia::log( __METHOD__, "empty", "Empty file {$input} reported size {$iFileSize}" );
			wfProfileOut(__METHOD__);
			return UPLOAD_ERR_NO_FILE;
		}

		$sTmpFile = $wgTmpDirectory."/".substr(sha1(uniqid($this->mUser->getID())), 0, 16);
		Wikia::log( __METHOD__, "tmp", "Temp file set to {$sTmpFile}" );
		$sTmp = $request->getFileTempname($input);
		Wikia::log( __METHOD__, "path", "Path to uploaded file is {$sTmp}" );

		if( move_uploaded_file( $sTmp, $sTmpFile )  ) {
			$aImgInfo = getimagesize($sTmpFile);

			/**
			 * check if mimetype is allowed
			 */
			$aAllowMime = array( "image/jpeg", "image/pjpeg", "image/gif", "image/png", "image/x-png", "image/jpg", "image/bmp" );
			if (!in_array($aImgInfo["mime"], $aAllowMime)) {
				Wikia::log( __METHOD__, "mime", "Imvalid mime type, allowed: " . implode(",", $aAllowMime) );
				wfProfileOut(__METHOD__);
				return $errorNo;
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

			/**
			 * save to new file ... but create folder for it first
			 */
			if ( !is_dir( dirname( $sFilePath ) ) && !wfMkdirParents( dirname( $sFilePath ) ) ) {
				Wikia::log( __METHOD__, "dir", sprintf("Cannot create directory %s", dirname( $sFilePath ) ) );
				wfProfileOut( __METHOD__ );
				return UPLOAD_ERR_CANT_WRITE;
			}

			if ( !imagepng($oImg, $sFilePath) ) {
				Wikia::log( __METHOD__, "save", sprintf("Cannot save png Avatar: %s", $sFilePath ));
				$errorNo = UPLOAD_ERR_CANT_WRITE;
			}
			else {
				/* remove tmp file */
				imagedestroy($oImg);

				$sUserText =  $this->mUser->getName();
				$mUserBlogPage = Title::newFromText( $sUserText, NS_BLOG_ARTICLE );
				$oLogPage = new LogPage( AVATAR_LOG_NAME );
				$sLogComment = wfMsg('blog-avatar-changed-log', $sUserText);
				$oLogPage->addEntry( AVATAR_LOG_NAME, $mUserBlogPage, $sLogComment);
				unlink($sTmpFile);
				$errorNo = UPLOAD_ERR_OK;
			}
		}
		else {
			Wikia::log( __METHOD__, "move", sprintf("Cannot move uploaded file from %s to %s", $sTmp, $sTmpFile ));
			$errorNo = UPLOAD_ERR_CANT_WRITE;
		}
		wfProfileOut(__METHOD__);
		return $errorNo;
	}

	/**
	 * additionalUserProfilePreferences -- Hook handler
	 *
	 * @param PreferencesForm $oPrefs  -- preferences form instance
	 * @param String $html -- generated html
	 */
	static public function additionalUserProfilePreferences( &$oPrefs, &$html) {
		global $wgUser, $wgCityId;
		wfProfileIn( __METHOD__ );
		$oAvatarObj = BlogAvatar::newFromUser( $wgUser );
		$aDefAvatars = $oAvatarObj->getDefaultAvatars();

		if ( $wgUser->isBlocked() ) {
			# if user is blocked - don't show avatar form
			return true;
		}
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
			"sUserImg"		=> $oAvatarObj->getURL(),
			"imgH"			=> AVATAR_DEFAULT_HEIGHT,
			"imgW"			=> AVATAR_DEFAULT_WIDTH,
			"sFieldName"	=> AVATAR_UPLOAD_FIELD,
		) );

		$html .= wfHidden( 'MAX_FILE_SIZE', AVATAR_MAX_SIZE );
		$html .= $oTmpl->execute("pref-avatar-form");

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * savePreferences -- Hook handler
	 *
	 * @param PreferencesForm $oPrefs  -- preferences form instance
	 * @param User $User -- user object
	 * @param String $sMsg -- status message
	 * @param $oldOptions
	 */
	static public function savePreferences( $oPrefs, $mUser, &$sMsg, $oldOptions ) {
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
			$oAvatarObj = BlogAvatar::newFromUser( $mUser );
			/* check is set default avatar for user */
			if ( empty($sUrl) ) {
				/* upload user avatar */
				$errorNo = $oAvatarObj->uploadFile( $wgRequest );
				if ( $errorNo != UPLOAD_ERR_OK ) {
					switch( $errorNo ) {
						case UPLOAD_ERR_NO_FILE:
							$sMsg .= wfMsg( "blog-avatar-error-nofile");
							break;

						case UPLOAD_ERR_CANT_WRITE:
							$sMsg .= wfMsg( "blog-avatar-error-cantwrite");
							break;
						case UPLOAD_ERR_FORM_SIZE:
							$sMsg .= wfMsg( "blog-avatar-error-size", (int)(AVATAR_MAX_SIZE/1024) );
							break;

						default:
							$sMsg .= wfMsg( "blog-avatar-error-cantwrite");
					}
					$result = false;
				} else {
					$sUrl = $oAvatarObj->getLocalPath();
				}
				Wikia::log( __METHOD__, "url", $sUrl );
			}

			if ( !empty($sUrl) ) {
				/* set user option */
				$mUser->setOption( AVATAR_USER_OPTION_NAME, $sUrl );
			}
		}
		Wikia::log( __METHOD__, "url", "selected avatar for user ".$mUser->getID().": $sUrl" );

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * userMasthead -- Hook handler
	 *
	 * @param
	 *
	 */
	static public function userMasthead() {
		global $wgTitle, $wgUser, $wgOut, $wgExtensionsPath, $wgStyleVersion, $wgRequest;
		global $wgJsMimeType, $wgMergeStyleVersionJS;

		$namespace = $wgTitle->getNamespace();
		$dbKey = SpecialPage::resolveAlias( $wgTitle->getDBkey() );
		$isAnon = $wgUser->isAnon();

		$allowedNamespaces = array( NS_USER, NS_USER_TALK );
		if ( defined("NS_BLOG_ARTICLE") ) {
			$allowedNamespaces[] = NS_BLOG_ARTICLE;
		}
		$allowedPages = array (
			'Watchlist',
			'WidgetDashboard',
			'Preferences',
			'Contributions',
			'Emailuser'
		);
		if( in_array( $namespace, $allowedNamespaces ) ||
			( ( $namespace == NS_SPECIAL ) && ( in_array( $dbKey, $allowedPages ) ) )
		) {
			/**
			 * change dbkey for nonspecial articles, in this case we use NAMESPACE
			 * as key
			 */
			if ( $namespace != NS_SPECIAL ) {
				$dbKey = $namespace;
			}

			/* hides article/talk tabs in Monaco.php */
			$Avatar = null;
			$userspace = "";
			$out = array();
			/* check conditions */
			if ( in_array( $namespace, $allowedNamespaces ) ) {
				$userspace = $wgTitle->getBaseText();
				$Avatar = BlogAvatar::newFromUserName( $userspace );
			}

			if ( in_array( $dbKey, $allowedPages ) ) {
				$reqTitle = $wgRequest->getText("title", false);
				if ( strpos( $reqTitle, "/") !== false ) {
					list ( , $userspace ) = explode( "/", $reqTitle, 2 );
					$user = User::newFromName( $userspace );
					if( ! $user ) {
						/**
						 * means that url is malformed or page doesn't exists
						 * or user doesn't exist. We don't know what user it is
						 * and we give up
						 */
						return true;
					}
					$userspace = $user->getName();
					$Avatar = BlogAvatar::newFromUserName( $userspace );
				} else {
					$userspace = $wgUser->getName();
					$Avatar = BlogAvatar::newFromUser( $wgUser );
				}
			}
			if ($userspace != "") {
				$out['userspace'] = $userspace;

				$oTitle = Title::newFromText( $userspace, NS_USER );
				if ($oTitle instanceof Title) {
					$out['nav_links'][] = array('text' => wfMsg('nstab-user'), 'href' => $oTitle->getLocalUrl(), "dbkey" => NS_USER );
				}
				$oTitle = Title::newFromText( $userspace, NS_USER_TALK );
				if ($oTitle instanceof Title) {
					$out['nav_links'][] = array('text' => wfMsg('talkpage'), 'href' => $oTitle->getLocalUrl(), "dbkey" => NS_USER_TALK );
				}
				if ( defined("NS_BLOG_ARTICLE") ) {
					$oTitle = Title::newFromText( $userspace, NS_BLOG_ARTICLE );
					if ($oTitle instanceof Title) {
						$out['nav_links'][] = array('text' => wfMsg('blog-page'), 'href' => $oTitle->getLocalUrl(), "dbkey" => NS_BLOG_ARTICLE );
					}
				}
				if( !$isAnon ) {
					$oTitle = Title::newFromText( "Contributions/{$userspace}", NS_SPECIAL );
					if ($oTitle instanceof Title) {
						$out['nav_links'][] = array('text' => wfMsg('contris'), 'href' => $oTitle->getLocalUrl(), "dbkey" => "Contributions" );
					}
				}

				if ( $wgUser->isLoggedIn() && $wgUser->getName() == $userspace ) {
					$out['nav_links'][] = array('text' => wfMsg('prefs-watchlist'), 'href' => Title::newFromText("Watchlist", NS_SPECIAL )->getLocalUrl(), "dbkey" => "Watchlist" );
					$out['nav_links'][] = array('text' => wfMsg('blog-widgets-label'), 'href' => Title::newFromText("WidgetDashboard", NS_SPECIAL )->getLocalUrl(), "dbkey" => "WidgetDashboard" );
					$out['nav_links'][] = array('text' => wfMsg('preferences'), 'href' => Title::newFromText("Preferences", NS_SPECIAL )->getLocalUrl(), "dbkey" => "Preferences" );
				} elseif ( !$isAnon ) {
					$oTitle = Title::newFromText( "EmailUser/{$userspace}", NS_SPECIAL );
					if ($oTitle instanceof Title) {
						$out['nav_links'][] = array('text' => wfMsg("emailpage"), 'href' => $oTitle->getLocalUrl(), "dbkey" => "Emailuser" );
					}
				}

				$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
				$tmpl->set_vars( array(
					'data'      => $out,
					"avatar"    => $Avatar,
					"current"   => $dbKey,
					"userspace" => $userspace,
				));
				echo $tmpl->execute('UserMasthead');
			}
		}
		return true;
	}
}

class BlogAvatarRemovePage extends SpecialPage {
	var $mAvatar;
	var $mTitle;
	var $mPosted;
	var $mUser;
	var $mCommitRemoved;

	#--- constructor
	public function __construct() {
		$this->mPosted = false;
		$this->mCommitRemoved = false;
		$this->mSysMsg = false;
		$this->mTitle = Title::makeTitle( NS_SPECIAL, "RemoveAvatar" );
		parent::__construct( "RemoveAvatar", 'removeavatar');
	}

	public function execute() {
		global $wgUser, $wgOut, $wgRequest;
		wfProfileIn( __METHOD__ );

		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			wfProfileOut( __METHOD__ );
			return;
		}
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			wfProfileOut( __METHOD__ );
			return;
		}
		if ( !$wgUser->isLoggedIn() ) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return;
		}
		if ( !$wgUser->isAllowed( 'removeavatar' ) ) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return;
		}

		$wgOut->setPageTitle( wfMsg("blog-avatar-removeavatar") );

		if ($wgRequest->getVal("action") === "search_user") {
			$this->mPosted = true;
		}

		if ($wgRequest->getVal("action") === "remove_avatar") {
			$this->mCommitRemoved = true;
		}

		wfProfileOut( __METHOD__ );
		$this->removeForm();
	}

	private function removeForm() {
		global $wgUser, $wgOut, $wgRequest;

		if ($this->mPosted) {
			if ($wgRequest->getVal("av_user")) {
				$avUser = User::newFromName($wgRequest->getVal("av_user"));
				if ($avUser->getID() !== 0) {
					$this->mAvatar = BlogAvatar::newFromUser($avUser);
					$this->mUser = $avUser;
				}
			}
		}

		if ($this->mCommitRemoved) {
			if ($wgRequest->getVal("av_user")) {
				$avUser = User::newFromName($wgRequest->getVal("av_user"));
				if ($avUser->getID() !== 0) {
					$this->mAvatar = BlogAvatar::newFromUser($avUser);
					if (!$this->mAvatar->removeFile($avUser->getID())) {
						$this->iStatus = "WMSG_REMOVE_ERROR";
					}
					$this->mUser = $avUser;
					$this->mPosted = true;
				}
			}
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"title"     	=> $this->mTitle,
			"avatar"   	 	=> $this->mAvatar,
			"search_user"	=> $wgRequest->getVal("av_user"),
			"user"			=> $this->mUser,
			"is_posted" 	=> $this->mPosted,
			"status"    	=> $iStatus
		));
		$wgOut->addHTML( $oTmpl->execute("remove-avatar-form") );
	}
}
