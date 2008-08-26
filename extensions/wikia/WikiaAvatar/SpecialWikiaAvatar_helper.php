<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzy¿aniak <eloy@wikia.com> for Wikia.com
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

class WikiaAvatar {

    #--- server default image
    var $mDefault = true;
    var $mUserID;	#--- just used id
    var $mUser;		#--- whole user object
    var $mSize = 0;

    const AVATAR_DIR_NAME = "avatars";

    var $aDefaultImages = array(
        "l" => "default_l.gif",
        "m" => "default_m.gif",
        "s" => "default_s.gif"
    );

    var $aDefaultImagesPath = "http://images.wikia.com/common/avatars";

    #--- constructor
    public function __construct($userid)
    {
    	$this->mUserID = $userid;
        $this->mUser = User::newFromId($userid);
        if (is_object( $this->mUser ) && !is_null( $this->mUser )) {
            $this->mUser->load();
        }

    	#--- Add messages (if not already added)
    	global $wgMessageCache, $wgWikiaAvatarMessages;
        	foreach( $wgWikiaAvatarMessages as $key => $value ) {
    	    $wgMessageCache->addMessages( $wgWikiaAvatarMessages[$key], $key );
    	}

    	global $wgAvatarPath, $wgAvatarUploadPath, $wgUploadPath, $wgUploadDirectory;
        if (empty($wgAvatarUploadPath)) {
            wfDebug( __METHOD__.": wgAvatarUploadPath is empty, taking default ".$wgUploadDirectory."/avatars/\n" );
            $wgAvatarUploadPath = $wgUploadDirectory."/avatars/";
        }
        if (empty($wgAvatarPath)) {
            wfDebug( __METHOD__.": wgAvatarPath is empty, taking default ".$wgUploadPath."/avatars/\n" );
            $wgAvatarPath = $wgUploadPath."/avatars/";
        }
    }

    /**
     * @addto Avatar
     * eloy: change directory to store hashed paths
     */
    public function getAvatarImage($size = "l")
    {
    	global $wgUser, $wgDBname, $wgAvatarPath, $wgAvatarUploadPath;
    	global $wgUploadPath, $wgUploadDirectory;

        $this->mSize = $size;

        if (empty($wgAvatarUploadPath)) {
            wfDebug( __METHOD__.": wgAvatarUploadPath is empty, taking default ".$wgUploadDirectory."/avatars/\n" );
            $wgAvatarUploadPath = $wgUploadDirectory."/avatars/";
        }
        if (empty($wgAvatarPath)) {
            wfDebug( __METHOD__.": wgAvatarPath is empty, taking default ".$wgUploadPath."/avatars/\n" );
            $wgAvatarPath = $wgUploadPath."/avatars/";
        }

        #--- build path for image
        $sImage = self::getAvatarFile($this->mUserID, $this->mSize);
        $sImageFull = self::getAvatarFileFull($this->mUserID, $this->mSize);

    	#-- check if directory part exists and is writable
    	if (!is_dir(dirname($sImageFull))) {
            #--- try create
            if (!mkdir(dirname($sImageFull), 0777, true /*recursive*/)) {
                wfDebug( __METHOD__.": cannot create directory for {$sImageFull}\n" );
            }
        }

        if (file_exists($sImageFull)) {
            $sAvatarImage = $sImage;
    	    $this->mDefault = false;
        }
        else {
            $sAvatarImage = $this->aDefaultImages[$this->mSize];
    	    $this->mDefault = true;
        }
        #---
        $sAvatarPath = ($this->mDefault) ? $this->aDefaultImagesPath : $wgAvatarPath;
        #---
        return $sAvatarPath."/".$sAvatarImage . "?r=" . rand();
    }

    /**
     * check if default image will be served
     */
    public function isDefault()
    {
    	if (empty($this->mSize)) {
    	    $this->mSize = "l";
    	}
    	$sImageFull = self::getAvatarFileFull($this->mUserID, $this->mSize);
    	if (file_exists($sImageFull)) {
    	    $this->mDefault = false;
    	    return false;
    	}
    	else {
    	    $this->mDefault = true;
    	    return true;
    	}
    }

    /**
     * return whole <img...> tag
     */
    public function getAvatarImageTag($size = "l")
    {
    	$sPath = $this->getAvatarImage($size);
    	$aSize = self::getAvatarSize($size);

    	return sprintf("<img src=\"%s\" border=\"0\" width=\"%d\" height=\"%d\" alt=\"[Avatar]\" />",
    	    $sPath, $aSize["width"], $aSize["height"] );
    }

    /**
     * return whole <a><img...></a> link
     */
    public function getAvatarImageLink($size = "l", $withlinks = 1)
    {
    	global $wgUser;
    	$sPath = $this->getAvatarImageTag($size);
    	$isDefault = $this->isDefault();

    	#--- check if this avatar is for wgUser or another
    	if ($this->mUserID == $wgUser->getID()) {
    	    if ($withlinks == 1) {
    	        $sLink=sprintf("<a style=\"font-size: 9px;\" href=\"/index.php?title=Special:AvatarUpload\">[%s]</a>",
    		    wfMsg("avatarupload_change"));
       	    }
    	    elseif ($withlinks == 2) {
    	        $sLink=sprintf("<a style=\"font-size: 9px;\" href=\"/index.php?title=Special:AvatarUpload&action=remove\" onClick=\"return confirm('%s');\">[%s]</a>",
    	        wfMsg("avatarupload_removeconfirm"),
    		    wfMsg("avatarupload_removeavatar"));
       	    }
            else {
            	$sLink="";
            }
        }
        else {
            #--- never show links
            $sLink="";
        }

        return sprintf("<a href=\"%s\">%s</a><br />%s",
             Title::makeTitle(NS_USER_PROFILE, $this->mUser->getName())->getLocalURL(), $sPath, $sLink);
    }

    static public function getAvatarFile($mUserID, $size)
    {
        $sImage = "{$mUserID}x{$size}.png";
        $sHash = sha1("{$mUserID}");
        $sDir = substr($sHash, 0, 1)."/".substr($sHash, 0, 2);
        return "{$sDir}/{$sImage}";
    }

    static public function getAvatarFileFull($mUserID, $size)
    {
        global $wgAvatarUploadPath;
        return $wgAvatarUploadPath."/".self::getAvatarFile($mUserID, $size);
    }

	public function removeAvatarFile($mUserID, $size)
	{
		$sImageFull = self::getAvatarFileFull($mUserID, $size);
		if (file_exists($sImageFull))
		{
			if (!unlink($sImageFull))
			{
            	wfDebug( __METHOD__.": cannot remove avatar's files {$sImageFull}\n" );
				return false;
			}
			return true;
		}
		return false;
	}

	public function removeAllAvatarFile($mUserID)
	{
		global $wgLogTypes, $wgUser;

		if (!$this->removeAvatarFile($mUserID, "l"))
		{
			return false;
		}
		if (!$this->removeAvatarFile($mUserID, "m"))
		{
			return false;
		}
		if (!$this->removeAvatarFile($mUserID, "s"))
		{
			return false;
		}

		# everything ok
		if (!in_array('avatar', $wgLogTypes))
		{
			$wgLogTypes[] = 'avatar';
		}

		$aUser = User::newFromId($mUserID);
		$userText =  $aUser->getName();
		$userProfilePage = Title::newFromText( $userText, 207 );
		$logPage = new LogPage( 'avatar' );
		$logComment = "Remove {$userText}'s avatars by {$wgUser->getName()}";
		$logPage->addEntry( 'avatar', $userProfilePage, $logComment);
		return true;
	}

    static public function getAvatarSize($size="l")
    {
        $aDefaultSizes = array(
            "l" => array( "width" => 75, "height" => 75 ),
            "m" => array( "width" => 30, "height" => 30 ),
            "s" => array( "width" => 16, "height" => 16 ),
        );

        if (in_array($size, array("l", "m", "s"))) {
            return $aDefaultSizes[$size];
        }
        else {
            return $aDefaultSizes["l"];
        }
    }

};

################################# Helpers  ###################################
function wfWAvatarUpload($request, $user)
{
    global $wgTmpDirectory, $wgLogTypes, $wgDebugLogGroups;

    #--- $wgDebugLogGroups["avatar"] = "/tmp/debug-avatar.log";

    wfProfileIn(__METHOD__);

	if (!in_array('avatar', $wgLogTypes)) {
		$wgLogTypes[] = 'avatar';
	}

    if (!isset($wgTmpDirectory) || empty($wgTmpDirectory)) {
    	$wgTmpDirectory = "/tmp";
    }
    wfDebugLog( "avatar", "Temp directory set to {$wgTmpDirectory}" );

    $iErrNo = UPLOAD_ERR_OK;
    $iFileSize = $request->getFileSize("wpUpload");

    if (empty($iFileSize)) {
        return UPLOAD_ERR_NO_FILE; #--- file size = 0;
    }

    $sTmpFile = $wgTmpDirectory."/".substr(sha1(uniqid($user->getID())), 0, 16);
    $oTmp = $request->getFileTempname("wpUpload");
    wfDebugLog( "avatar", "Temp file set to {$sTmpFile}" );
    wfDebugLog( "avatar", "Path to uploaded file is {$oTmp}" );

    if (move_uploaded_file($oTmp, $sTmpFile)) {
        $aImgInfo = getimagesize($sTmpFile);

        #--- check if mimetype is allowed
        #if (!in_array($aImgInfo["mime"],
        #    array("image/jpeg", "image/pjpeg", "image/gif", "image/png", "image/x-png", "image/jpg", "image/bmp"))) {
        #    wfProfileOut(__METHOD__);
        #    return UPLOAD_ERR_EXTENSION;
        #}

        switch ($aImgInfo["mime"]) {
            case "image/gif":
                $oImgOrig = @imagecreatefromgif($sTmpFile);
                break;
            case "image/jpeg":
                $oImgOrig = @imagecreatefromjpeg($sTmpFile);
                break;
            case "image/bmp":
                $oImgOrig = @imagecreatefrombmp($sTmpFile);
                break;
            case "image/png":
                $oImgOrig = @imagecreatefrompng($sTmpFile);
                break;
        }
        $aOrigSize = array("width" => $aImgInfo[0], "height" => $aImgInfo[1]);


        #--- generate thumbnails (always png format)
        $addedAvatars = array();
        foreach (array("l","m","s") as $size) {
            $sThumb = WikiaAvatar::getAvatarFileFull($user->getID(), $size);
            $aThumbSize = WikiaAvatar::getAvatarSize($size);

            #--- calculate thumbnail size
            if ( $aOrigSize["width"] > $aOrigSize["height"] ) {
                $iThumbW = $aThumbSize["width"];
            	$iThumbH = $aOrigSize["height"] * ( $aThumbSize["height"] / $aOrigSize["width"] );
            }
            if ( $aOrigSize["width"] < $aOrigSize["height"] ) {
                $iThumbW = $aOrigSize["width"] * ( $aThumbSize["width"] / $aOrigSize["height"] );
            	$iThumbH = $aThumbSize["height"];
            }
            if ( $aOrigSize["width"] == $aOrigSize["height"] ) {
            	$iThumbW = $aThumbSize["width"];
            	$iThumbH = $aThumbSize["height"];
            }

            #--- empty image with thumb size on white background
            $oImg = @imagecreatetruecolor($aThumbSize["width"], $aThumbSize["height"]);
            $white = imagecolorallocate($oImg, 255, 255, 255);
            imagefill($oImg, 0, 0, $white);

            $tImg = $oImgOrig;
            imagecopyresampled($oImg, $tImg,
                floor ( ( $aThumbSize["width"] - $iThumbW ) / 2 ) /*dx*/,
                floor ( ( $aThumbSize["height"] - $iThumbH ) / 2 ) /*dy*/,
                0 /*sx*/, 0 /*sy*/,
                $iThumbW /*dw*/, $iThumbH /*dh*/,
                $aOrigSize["width"]/*sw*/, $aOrigSize["height"]/*sh*/
            );

            #--- write to file
            if (!imagepng($oImg, $sThumb)) {
                wfDebugLog( "avatar", sprintf("%s: cannot save png Avatar: %s", __METHOD__, $sThumb ));
                $iErrNo = UPLOAD_ERR_CANT_WRITE;
            } else {
            	$addedAvatars[] = $size;
			}
            imagedestroy($oImg);
        }

        if (empty($iErrNo)) {
			$userText = $user->getName();
			$userProfilePage = Title::newFromText( $user->getName(), 207 );
			$logComment = "Add/change avatars (sizes: '".implode("','", $addedAvatars)."') by {$userText}";
			$logPage = new LogPage( 'avatar' );
			$logPage->addEntry( 'avatar', $userProfilePage, $logComment);
		}
        unlink($sTmpFile);
    }
    else {
        $iErrNo = UPLOAD_ERR_CANT_WRITE;
        wfDebugLog( "avatar", sprintf("%s: cannot move uploaded file from %s to", __METHOD__, $oTmp, $sTmpFile ));
    }
    wfProfileOut(__METHOD__);
    return $iErrNo;
}
############################## Ajax methods ##################################

function axWAvatarUpload()
{
    global $wgRequest, $wgUser;

    $iStatus = wfWAvatarUpload($wgRequest, $wgUser);

    $aResponse = array(
        "error" => $iStatus
    );

    if (!function_exists('json_encode'))  {
        $oJson = new Services_JSON();
        return $oJson->encode($aResponse);
    }
    else {
        return json_encode($aResponse);
    }
}
global $wgAjaxExportList;
$wgAjaxExportList[] = "axWAvatarUpload";

?>
