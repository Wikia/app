<?php
/**
 * Masthead extension
 *
 * @author Piotr Molski <moli@wikia-inc.com>
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

define ('AVATAR_DEFAULT_WIDTH', 100);
define ('AVATAR_DEFAULT_HEIGHT', 100);
define ('AVATAR_LOG_NAME', 'useravatar');
define ('AVATAR_USER_OPTION_NAME', 'avatar');
define ('AVATAR_MAX_SIZE', 512000 );
define ('AVATAR_UPLOAD_FIELD', 'wkUserAvatar');

$wgLogTypes[] = AVATAR_LOG_NAME;
$wgLogHeaders[AVATAR_LOG_NAME] = 'blog-avatar-alt';
$wgHooks['AdditionalUserProfilePreferences'][] = 'Masthead::additionalUserProfilePreferences';
$wgHooks['SavePreferences'][] = 'Masthead::savePreferences';
$wgHooks['SkinGetPageClasses'][] = 'Masthead::SkinGetPageClasses';
$wgHooks['ArticleSaveComplete'][] = 'Masthead::userMastheadInvalidateCache';

$wgLogNames[AVATAR_LOG_NAME] = "useravatar-log";

$wgLogActions[AVATAR_LOG_NAME . '/avatar_chn'] = 'blog-avatar-changed-log';
$wgLogActions[AVATAR_LOG_NAME . '/avatar_rem'] = 'blog-avatar-removed-log';

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Masthead',
	'description' => 'Displays masthead with avatar and useful links',
	'author' => array('Krzysztof Krzyzaniak (eloy) <eloy@wikia-inc.com>', 'Piotr Molski (moli) <moli@wikia-inc.com>', '[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]')
);

#--- register special page (MW 1.10 way)
if ( !function_exists( 'extAddSpecialPage' ) ) {
	require( "$IP/extensions/ExtensionFunctions.php" );
}

/**
 * messages file
 */
$wgExtensionMessagesFiles['Masthead'] = dirname(__FILE__) . '/Masthead.i18n.php';

#--- permissions
$wgAvailableRights[] = 'removeavatar';
$wgGroupPermissions['staff']['removeavatar'] = true;
#$wgGroupPermissions['sysop']['removeavatar'] = true;
$wgGroupPermissions['helper']['removeavatar'] = true;
extAddSpecialPage( '', 'RemoveUserAvatar', 'UserAvatarRemovePage' );
$wgSpecialPageGroups['RemoveUserAvatar'] = 'users';

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

	public function __construct( User $User ) {
		wfProfileIn( __METHOD__ );
		$this->mUser = $User;
		wfLoadExtensionMessages('Masthead');
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
		$images = getMessageAsArray( 'blog-avatar-defaults' );

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
					$url = $this->mDefaultPath . $thumb . $hash . $url;
				}
			}
			else {
				$defaults = $this->getDefaultAvatars( trim( $thumb,  "/" ) . "/" );
				$url = array_shift( $defaults );
			}

			return wfReplaceImageServer( $url, $this->mUser->getTouched() );
		}
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
	 * @return string -- url to Avatar
	 */
	public function getThumbnail( $width ) {
		$url = $this->getUrl( '/thumb/' );

		/**
		 * returned url is virtual base for thumbnail, so
		 *
		 * - get last part of path
		 * - add it as thumbnail file prefixed with widthpx
		 */
		$file = array_pop( explode( "/", $url ) );
		return sprintf( "%s/%dpx-%s", $url, $width, $file );
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
//		Wikia::log( __METHOD__, 'url', $url );

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
		if (!empty($tracker)) {
			$additionalAttribs .= " onclick=\"WET.byStr('{$tracker}')\"";
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
	public function removeFile() {
		wfProfileIn( __METHOD__ );
		global $wgLogTypes, $wgUser;

		$result = false;
		$sImageFull = $this->getFullPath();

		if( file_exists( $sImageFull ) ) {
			if (!unlink($sImageFull)) {
				wfDebug( __METHOD__.": cannot remove avatar's files {$sImageFull}\n" );
				$result = false;
			} else {
				/* add log */
				$this->__setLogType();
				$sUserText =  $this->mUser->getName();
				$this->mUser->setOption( AVATAR_USER_OPTION_NAME, "" );
				$this->mUser->saveSettings();
				$mUserPage = Title::newFromText( $sUserText, NS_USER );
				$oLogPage = new LogPage( AVATAR_LOG_NAME );
				$oLogPage->addEntry( 'avatar_rem', $mUserPage, '', array($sUserText));
				/* */
				$result = true;

				/**
				 * notice image replication system
				 */
				global $wgEnableUploadInfoExt;
				if( $wgEnableUploadInfoExt ) {
					UploadInfo::log( $mUserPage, $sImageFull, $this->getLocalPath(), "", "r" );
				}
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
		$errorNo = $this->postProcessImageInternal($sTmpFile, $errorNo);

		wfProfileOut(__METHOD__);
		return $errorNo;
	} // end uploadByUrl()

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
		$iFileSize = $request->getFileSize( $input );

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
	private function postProcessImageInternal($sTmpFile, $errorNo = UPLOAD_ERR_OK, &$errorMsg=''){
		wfProfileIn(__METHOD__);
		$aImgInfo = getimagesize($sTmpFile);

		/**
		 * check if mimetype is allowed
		 */
		$aAllowMime = array( 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png', 'image/x-png', 'image/jpg' );
		if (!in_array($aImgInfo['mime'], $aAllowMime)) {
			// This seems to be the most appropriate error message to describe that the image type is invalid.
			// Available error codes; http://php.net/manual/en/features.file-upload.errors.php
			$errorNo = UPLOAD_ERR_EXTENSION;
			$errorMsg = wfMsg('blog-avatar-error-type', $aImgInfo['mime'], implode(',', $aAllowMime));

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

		/**
		 * calculate new image size - should be 100 x 100
		 */
		$iImgW = AVATAR_DEFAULT_WIDTH;
		$iImgH = AVATAR_DEFAULT_HEIGHT;
		/* WIDTH > HEIGHT */
		if ( $aOrigSize['width'] > $aOrigSize['height'] ) {
			$iImgH = $iImgW * ( $aOrigSize['height'] / $aOrigSize['width'] );
		}
		/* HEIGHT > WIDTH */
		if ( $aOrigSize['width'] < $aOrigSize['height'] ) {
			$iImgW = $iImgH * ( $aOrigSize['width'] / $aOrigSize['height'] );
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
			$aOrigSize['width']/*sw*/,
			$aOrigSize['height']/*sh*/
		);

		/**
		 * save to new file ... but create folder for it first
		 */
		if ( !is_dir( dirname( $sFilePath ) ) && !wfMkdirParents( dirname( $sFilePath ) ) ) {
//				Wikia::log( __METHOD__, 'dir', sprintf('Cannot create directory %s', dirname( $sFilePath ) ) );
			wfProfileOut( __METHOD__ );
			return UPLOAD_ERR_CANT_WRITE;
		}

		if( !imagepng( $oImg, $sFilePath ) ) {
//				Wikia::log( __METHOD__, 'save', sprintf('Cannot save png Avatar: %s', $sFilePath ));
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
			$errorNo = UPLOAD_ERR_OK;
		}

		return $errorNo;
	} // end postProcessImageInternal()

	/**
	 * additionalUserProfilePreferences -- Hook handler
	 *
	 * @param PreferencesForm $oPrefs  -- preferences form instance
	 * @param String $html -- generated html
	 */
	static public function additionalUserProfilePreferences($oPrefs, &$html) {
		global $wgUser, $wgCityId, $wgEnableUploads, $wgUploadDirectory;
		wfProfileIn( __METHOD__ );
		$oAvatarObj = Masthead::newFromUser( $wgUser );
		$aDefAvatars = $oAvatarObj->getDefaultAvatars();

		if ( $wgUser->isBlocked() ) {
			# if user is blocked - don't show avatar form
			return true;
		}

		// List of conditions taken from
		// extensions/wikia/UserProfile_NY/SpecialUploadAvatar.php */
		// RT#53727: Avatar uploads not disabled
		$bUploadsPossible = $wgEnableUploads && $wgUser->isAllowed( 'upload' ) && is_writeable( $wgUploadDirectory );
//		var_dump($wgEnableUploads,$wgUser->isAllowed( 'upload' ),is_writeable( $wgUploadDirectory ));

		/**
		 * run template
		 */
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$oTmpl->set_vars( array(
			'wgUser'           => $wgUser,
			'sUserAvatar'      => $wgUser->getOption(AVATAR_USER_OPTION_NAME),
			'cityId'           => $wgCityId,
			'aDefAvatars'      => $aDefAvatars,
			'oAvatarObj'       => $oAvatarObj,
			'sUserImg'         => $oAvatarObj->getURL(),
			'imgH'             => AVATAR_DEFAULT_HEIGHT,
			'imgW'             => AVATAR_DEFAULT_WIDTH,
			'sFieldName'       => AVATAR_UPLOAD_FIELD,
			'bUploadsPossible' => $bUploadsPossible,
		) );

		$html .= wfHidden( 'MAX_FILE_SIZE', AVATAR_MAX_SIZE );
		$html .= $oTmpl->execute('pref-avatar-form');

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
			$oAvatarObj = Masthead::newFromUser( $mUser );
			/* check is set default avatar for user */
			if ( empty($sUrl) ) {
				/* upload user avatar */
				$errorMsg = "";
				$errorNo = $oAvatarObj->uploadFile( $wgRequest, AVATAR_UPLOAD_FIELD, $errorMsg );
				if ( $errorNo != UPLOAD_ERR_OK ) {
					switch( $errorNo ) {
						case UPLOAD_ERR_NO_FILE:
							$sMsg .= wfMsg( 'blog-avatar-error-nofile');
							break;

						case UPLOAD_ERR_CANT_WRITE:
							$sMsg .= wfMsg( 'blog-avatar-error-cantwrite');
							break;

						case UPLOAD_ERR_FORM_SIZE:
							$sMsg .= wfMsg( 'blog-avatar-error-size', (int)(AVATAR_MAX_SIZE/1024) );
							break;

						case UPLOAD_ERR_EXTENSION:
							$sMsg .= $errorMsg;
							break;

						default:
							$sMsg .= wfMsg( 'blog-avatar-error-cantwrite');
					}
					$result = false;
				} else {
					$sUrl = $oAvatarObj->getLocalPath();
				}
//				Wikia::log( __METHOD__, 'url', $sUrl );
			}

			if ( !empty($sUrl) ) {
				/* set user option */
				$mUser->setOption( AVATAR_USER_OPTION_NAME, $sUrl );
			}
		}
//		Wikia::log( __METHOD__, 'url', 'selected avatar for user '.$mUser->getID().': $sUrl' );

		wfProfileOut( __METHOD__ );
		return $result;
	}

	static public function SkinGetPageClasses(&$classes) {
		global $wgTitle;

		$namespace = $wgTitle->getNamespace();
		$dbKey = SpecialPage::resolveAlias( $wgTitle->getDBkey() );

		$allowedNamespaces = array( NS_USER, NS_USER_TALK );
		if ( defined('NS_BLOG_ARTICLE') ) {
			$allowedNamespaces[] = NS_BLOG_ARTICLE;
		}

		# special pages visible only for the current user
		# /$par is used for other things here
		$allowedPagesSingle = array (
			'Watchlist',
			'WidgetDashboard',
			'Preferences',
			'MyHome',
		);

		# special pages visible for other users
		# /$par or target paramtere are used for username
		$allowedPagesMulti = array (
			'Contributions',
			'Emailuser',
			'SavedPages',
			'Following'
		);

		if (in_array($namespace, $allowedNamespaces)) {
			$mastheadClass = ' masthead-regular';
		} elseif ($namespace == NS_SPECIAL && (in_array($dbKey, $allowedPagesSingle) || in_array($dbKey, $allowedPagesMulti))) {
			$mastheadClass = ' masthead-special';
		}

		if (!empty($mastheadClass)) {
			$classes .= $mastheadClass;
			global $wgHooks;
			$wgHooks['MonacoBeforePageBar'][] = 'Masthead::userMasthead';
		}

		return true;
	}

	/**
	 * userMasthead -- Hook handler
	 *
	 * @param
	 *
	 */
	static public function userMasthead() {
		global $wgTitle, $wgUser, $wgOut, $wgRequest, $wgLang;

		$namespace = $wgTitle->getNamespace();
		$dbKey = SpecialPage::resolveAlias( $wgTitle->getDBkey() );
		$isAnon = $wgUser->isAnon();

		$allowedNamespaces = array( NS_USER, NS_USER_TALK );
		if ( defined('NS_BLOG_ARTICLE') ) {
			$allowedNamespaces[] = NS_BLOG_ARTICLE;
		}

		# special pages visible only for the current user
		# /$par is used for other things here
		$allowedPagesSingle = array (
			'Watchlist',
			'WidgetDashboard',
			'Preferences',
			'MyHome',
		);

		# special pages visible for other users
		# /$par or target paramtere are used for username
		$allowedPagesMulti = array (
			'Contributions',
			'Emailuser',
			'SavedPages',
			'Following',
		);

		if( in_array( $namespace, $allowedNamespaces ) ||
			( $namespace == NS_SPECIAL && ( in_array( $dbKey, $allowedPagesSingle ) || in_array( $dbKey, $allowedPagesMulti ) ) )
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
				# Title::getBaseText only backs up one step, we need the leftmost part
				list( $userspace ) = explode( "/", $wgTitle->getText(), 2 );
				$Avatar = Masthead::newFromUserName( $userspace );
			} elseif ( in_array( $dbKey, $allowedPagesSingle ) ) {
				$userspace = $wgUser->getName();
				$Avatar = Masthead::newFromUser( $wgUser );
			} elseif ( in_array( $dbKey, $allowedPagesMulti ) ) {
				$reqTitle = $wgRequest->getText('title', false);

				# try to get a target user name
				$userspace = $wgRequest->getText('target', false);
				if ( empty( $userspace ) && strpos( $reqTitle, '/') !== false ) {
					list ( , $userspace ) = explode( '/', $reqTitle, 2 );
				}

				if (empty($userspace)) {
					$userspace = $wgUser->getName();
				}
				$userspace = str_replace('_', ' ', $userspace);
				$Avatar = Masthead::newFromUserName( $userspace );
			}

			if ($userspace != '') {
				$isDestinationUserAnon = User::isIP($userspace);
				$isUserOnOwnPage = $wgUser->getName() == $userspace;
				$out['userspace'] = $userspace;
				$out['nav_links'] = array();

				global $wgEnableMyHomeExt;
				if ( !empty($wgEnableMyHomeExt) && $wgUser->isLoggedIn() && $isUserOnOwnPage) {
					$out['nav_links'][] = array('text' => wfMsg('myhome'), 'href' => Title::newFromText('MyHome', NS_SPECIAL )->getLocalUrl(), 'dbkey' => 'MyHome', 'tracker' => 'myhome');
				}
				$oTitle = Title::newFromText( $userspace, NS_USER );
				if ($oTitle instanceof Title) {
					$out['nav_links'][] = array('text' => wfMsg('nstab-user'), 'href' => $oTitle->getLocalUrl(), 'dbkey' => NS_USER, 'tracker' => 'user');
				}
				$oTitle = Title::newFromText( $userspace, NS_USER_TALK );
				if ($oTitle instanceof Title) {
					$out['nav_links'][] = array('text' => wfMsg('talkpage'), 'href' => $oTitle->getLocalUrl(), 'dbkey' => NS_USER_TALK, 'tracker' => 'usertalk');
				}
				if ( defined('NS_BLOG_ARTICLE') && !$isDestinationUserAnon) {
					$oTitle = Title::newFromText( $userspace, NS_BLOG_ARTICLE );
					if ($oTitle instanceof Title) {
						$out['nav_links'][] = array('text' => wfMsg('blog-page'), 'href' => $oTitle->getLocalUrl(), 'dbkey' => NS_BLOG_ARTICLE, 'tracker' => 'userblog');
					}
				}

				global $wgEnableWikiaFollowedPages;
				if ( !empty($wgEnableWikiaFollowedPages) && $wgEnableWikiaFollowedPages) {
					$follow = FollowHelper::getMasthead($userspace);
					if (!empty($follow)) {
						$out['nav_links'][] = $follow;
					}
				}

				// macbre: hide "Contributions" tab on Recipes Wiki
				global $wgEnableRecipesTweaksExt;
				$oTitle = Title::newFromText( "Contributions/{$userspace}", NS_SPECIAL );
				if ($oTitle instanceof Title && empty($wgEnableRecipesTweaksExt)) {
					$out['nav_links'][] = array('text' => wfMsg('contris'), 'href' => $oTitle->getLocalUrl(), 'dbkey' => 'Contributions', 'tracker' => 'contributions');
				}

				// macbre: add "Saved Pages" tab
				if (!empty($wgEnableRecipesTweaksExt)) {
					$out['nav_links'][] = array('text' => wfMsg('savedpages'), 'href' => Skin::makeSpecialUrl("SavedPages/{$userspace}"), 'dbkey' => 'SavedPages', 'tracker' => 'savedpages');
				}

				$avatarActions = array();
				//no actions for anon's page
				if (!$isDestinationUserAnon) {
					if (!$isUserOnOwnPage) {
						$user = User::newFromName( $userspace );
						if ($user) {
							$avatarActions[] = array(
								'tracker' => 'newsection',
								'href' => $user->getTalkPage()->getLocalURL('action=edit&amp;section=new'),
								'text' => wfMsg('addnewtalksection-link')
							);
						}
					}

					if (!$isUserOnOwnPage && !$isAnon) {
						$user = User::newFromName($userspace);
						if ($user) {
							$destinationUserId = $user->getId();
							$skin = $wgUser->getSkin();
							if ($skin->showEmailUser($destinationUserId)) {
								$oTitle = Title::newFromText( "EmailUser/{$userspace}", NS_SPECIAL );
								if ($oTitle instanceof Title) {
									$avatarActions[] = array(
										'tracker' => 'emailuser',
										'href' => $oTitle->getLocalUrl(),
										'text' => wfMsg('emailpage')
									);
								}
							}
						}

						if ($wgUser->isAllowed( 'block' )) {
							$oTitle = Title::newFromText( "Block/{$userspace}", NS_SPECIAL );
							if ($oTitle instanceof Title) {
								$avatarActions[] = array(
									'tracker' => 'blockip',
									'href' => $oTitle->getLocalUrl(),
									'text' => wfMsg('blockip')
								);
							}
						}
					}

					if ($isUserOnOwnPage) {
						$avatarActions[] = array(
							'tracker' => 'editavatar',
							'href' => Title::newFromText('Preferences', NS_SPECIAL)->getLocalUrl(),
							'text' => wfMsg('blog-avatar-edit')
						);
					}

					if ( !$Avatar->isDefault() && $wgUser->isAllowed( 'removeavatar' ) ) {
						$avatarActions[] = array(
							'tracker' => 'removeavatar',
							'href' => Title::newFromText('RemoveUserAvatar', NS_SPECIAL)->getLocalUrl('action=search_user&amp;av_user=' . $Avatar->getUserName()),
							'text' => wfMsg('blog-avatar-delete')
						);
					}
				}

				//stats
				$firstDate = $editCount = 0;
				if (!$isDestinationUserAnon) {
					$userStats = Masthead::getUserStatsData($userspace);
					$editCount = $userStats['editCount'];
					$firstDate = $userStats['firstDate'];
				}

				$editCounter = $wgLang->formatNum($editCount);
				$out['edit_counter_date'] = $editCounter;

				wfRunHooks('Masthead::editCounter', array(&$editCounter, User::newFromName($userspace)));
				$out['edit_counter_main'] = $editCounter;
				$out['edit_since'] = wfMsg('masthead-edits-since');
				$out['edit_date'] = $firstDate ? $firstDate : $wgLang->date(wfTimestamp(TS_MW));

				$tmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
				$tmpl->set_vars( array(
					'data'      => $out,
					'username'  => $isDestinationUserAnon ? wfMsg('masthead-anonymous-user') : $userspace,
					'avatar'    => $Avatar->display( 50, 50, false, 'avatar', false, /*( ( $userspace == $wgUser->getName() ) || ( $wgUser->isAllowed( 'removeavatar' ) && ( !$Avatar->isDefault() ) ) )*/ true, 'usermasthead/user' ),
					'current'   => $dbKey,
					'avatarActions' => $avatarActions,
					'anonymousUser' => $isDestinationUserAnon ? $userspace : '',
				));
				echo $tmpl->render('UserMasthead');

				global $wgMastheadVisible, $wgSupressPageTitle, $wgSupressSiteNotice;
				//hide #page_tabs
				if (!$wgTitle->isSubpage()) {
					$wgMastheadVisible = true;
				}
				//hide .firstHeading [except for blogs]
				$wgSupressPageTitle = !($wgTitle->isSubpage());
				//hide sitenotice
				$wgSupressSiteNotice = true;
			}
		}
		return true;
	}

	static public function getUserStatsData( $userName, $useMasterDb = false ) {
		global $wgLang, $wgCityId, $wgExternalDatawareDB;

		$result = array( 'editCount' => 0, 'firstDate' => 0 );

		$destionationUser = User::newFromName($userName);
		$destionationUserId = $destionationUser ? $destionationUser->getId() : 0;
		if($destionationUserId != 0) {
			global $wgMemc, $wgEnableAnswers;

			if(!empty($wgEnableAnswers) && class_exists('AttributionCache')) {
				// use AttributionCache to get edit points and first edit date
				$attrCache = AttributionCache::getInstance();

				$editCount = $attrCache->getUserEditPoints($destionationUserId);
				$firstDate = $wgLang->date(wfTimestamp(TS_MW, $attrCache->getUserFirstEditDateFromCache($destionationUserId)));
			}
			else {
				$mastheadDataEditDateKey = wfMemcKey('mmastheadData-editDate-' . $destionationUserId);
				$mastheadDataEditCountKey = wfMemcKey('mmastheadData-editCount-' . $destionationUserId);
				$mastheadDataEditDate = $wgMemc->get($mastheadDataEditDateKey);
				$mastheadDataEditCount = $wgMemc->get($mastheadDataEditCountKey);

				if(empty($mastheadDataEditCount) || empty($mastheadDataEditDate)) {
					$dbr = wfGetDB( $useMasterDb ? DB_MASTER : DB_SLAVE );

					$dbResult = $dbr->select(
						'revision',
						array('min(rev_timestamp) AS date, count(*) AS edits'),
						array('rev_user_text' => $destionationUser->getName()),
						__METHOD__
					);

					if ($row = $dbr->FetchObject($dbResult)) {
						$firstDate = $wgLang->date(wfTimestamp(TS_MW, $row->date));
						$editCount = $row->edits;
					}
					if ($dbResult !== false) {
						$dbr->FreeResult($dbResult);
					}
					$wgMemc->set($mastheadDataEditDateKey, $firstDate, 60 * 60);
					$wgMemc->set($mastheadDataEditCountKey, $editCount, 60 * 60);
				} else {
					$firstDate = $mastheadDataEditDate;
					$editCount = $mastheadDataEditCount;
				}
			}
			$result['editCount'] = $editCount;
			$result['firstDate'] = $firstDate;
		}
		return $result;
	}

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
	 * Check if masthead should be shown on current page
	 *
	 * TODO: use this method inside Masthead class
	 */
	public static function isMastheadShown() {
		global $wgTitle;

		wfProfileIn(__METHOD__);

		$namespace = $wgTitle->getNamespace();
		$dbKey = SpecialPage::resolveAlias( $wgTitle->getDBkey() );

		$allowedNamespaces = array( NS_USER, NS_USER_TALK );
		if ( defined('NS_BLOG_ARTICLE') ) {
			$allowedNamespaces[] = NS_BLOG_ARTICLE;
		}

		# special pages visible only for the current user
		# /$par is used for other things here
		$allowedPagesSingle = array (
			'Watchlist',
			'WidgetDashboard',
			'Preferences',
			'MyHome',
		);

		# special pages visible for other users
		# /$par or target paramtere are used for username
		$allowedPagesMulti = array (
			'Contributions',
			'Emailuser',
			'SavedPages',
		);

		// not shown by default
		$shown = false;

		if (in_array($namespace, $allowedNamespaces)) {
			$shown = true;
		}
		elseif ($namespace == NS_SPECIAL && (in_array($dbKey, $allowedPagesSingle) || in_array($dbKey, $allowedPagesMulti))) {
			$shown = true;
		}

		wfProfileOut(__METHOD__);

		return $shown;
	}
}

class UserAvatarRemovePage extends SpecialPage {
	var $mAvatar;
	var $mTitle;
	var $mPosted;
	var $mUser;
	var $mCommitRemoved;
	var $iStatus;

	#--- constructor
	public function __construct() {
		wfLoadExtensionMessages( 'Masthead' );
		$this->mPosted = false;
		$this->mCommitRemoved = false;
		$this->mSysMsg = false;
		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'RemoveUserAvatar' );
		parent::__construct( 'RemoveUserAvatar', 'removeavatar');
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

		$wgOut->setPageTitle( wfMsg('blog-avatar-removeavatar') );

		if ($wgRequest->getVal('action') === 'search_user') {
			$this->mPosted = true;
		}

		if ($wgRequest->getVal('action') === 'remove_avatar') {
			$this->mCommitRemoved = true;
		}

		wfProfileOut( __METHOD__ );
		$this->removeForm();
	}

	private function removeForm() {
		global $wgUser, $wgOut, $wgRequest;

		if ($this->mPosted) {
			if ($wgRequest->getVal('av_user')) {
				$avUser = User::newFromName($wgRequest->getVal('av_user'));
				if ($avUser->getID() !== 0) {
					$this->mAvatar = Masthead::newFromUser($avUser);
					$this->mUser = $avUser;
				}
			}
		}

		if ($this->mCommitRemoved) {
			if ($wgRequest->getVal('av_user')) {
				$avUser = User::newFromName($wgRequest->getVal('av_user'));
				if ($avUser->getID() !== 0) {
					$this->mAvatar = Masthead::newFromUser($avUser);
					if (!$this->mAvatar->removeFile($avUser->getID())) {
						$this->iStatus = 'WMSG_REMOVE_ERROR';
					}
					$this->mUser = $avUser;
					$this->mPosted = true;
				}
			}
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$oTmpl->set_vars( array(
			'title'     	=> $this->mTitle,
			'avatar'   	 	=> $this->mAvatar,
			'search_user'	=> $wgRequest->getVal('av_user'),
			'user'			=> $this->mUser,
			'is_posted' 	=> $this->mPosted,
			'status'    	=> $this->iStatus
		));
		$wgOut->addHTML( $oTmpl->execute('remove-avatar-form') );
	}
}
