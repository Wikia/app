<?php
class UploadProfilePhoto extends SpecialPage {

	
	function UploadProfilePhoto(){
		UnlistedSpecialPage::UnlistedSpecialPage("UploadProfilePhoto");
	}
	
    
	function execute(){
		global $wgRequest, $IP, $wgOut, $wgUser, $wgMemc, $wgUserProfileDirectory;
		
		$wgOut->setArticleBodyOnly(true);
		
		if( !$wgUser->isLoggedIn() ){
			$wgOut->errorpage('error', 'noaccess');
			return "";
		}
		
		if( $wgRequest->getVal("action") === "remove") {
			$this->mPosted = true;
			$iStatus = $this->ProfileRemovePhoto($wgRequest, $wgUser);
		}
		if ($wgRequest->getVal("action") == "upload") {
			$this->mPosted = true;
			$iStatus = $this->ProfileUpload($wgRequest, $wgUser);
		}
		
		$oTmpl = new EasyTemplate( $wgUserProfileDirectory . "/templates/" );
		$oTmpl->set_vars( array(
		    "title"     => $this->mTitle,
		    "avatar"    => $this->mAvatar,
		    "user"      => $wgUser,
		    "links"     => $aLinks,
		    "is_posted" => $this->mPosted,
		    "status"    => $iStatus
		));
		$wgOut->addHTML( $oTmpl->execute("profile-photo-form") );
		
	}
	
	################################# Helpers  ###################################
	function ProfileRemovePhoto($request, $user){
		global $wgTmpDirectory, $wgLogTypes, $wgDebugLogGroups, $wgUser;
		wfProfileIn(__METHOD__);
		
		$p = new ProfilePhoto( $wgUser->getID() );
		$p->removePhoto();
		return WMSG_REMOVE_SUCCESS;
	}

	function CleanFilename($filename){//function to clean a filename string so it is a valid filename
		$reserved = preg_quote('\/:*?"<>|', '/');//characters that are  illegal on any of the 3 major OS's
		//replaces all characters up through space and all past ~ along with the above reserved characters
		$filename = str_replace(" ","",$filename);
		return preg_replace("/([{$reserved}])/e", "", $filename);
	}

	################################# Helpers  ###################################
	function ProfileUpload($request, $user)
	{
	    global $wgTmpDirectory, $wgLogTypes, $wgDebugLogGroups, $wgUser, $wgProfilePhotoUploadPath;
	
	    
	
	    wfProfileIn(__METHOD__);

	
	    if (!isset($wgTmpDirectory) || empty($wgTmpDirectory)) {
		$wgTmpDirectory = "/tmp";
	    }
	    wfDebugLog( "photo", "Temp directory set to {$wgTmpDirectory}" );
	
	    $iErrNo = UPLOAD_ERR_OK;
	    $iFileSize = $request->getFileSize("wpUpload");
	
	    if (empty($iFileSize)) {
		return UPLOAD_ERR_NO_FILE; #--- file size = 0;
	    }
	
	    $sTmpFile = $wgTmpDirectory."/".substr(sha1(uniqid($user->getID())), 0, 16);
	
	    $oTmp = $request->getFileTempname("wpUpload");
	    wfDebugLog( "photo", "Temp file set to {$sTmpFile}" );
	    wfDebugLog( "photo", "Path to uploaded file is {$oTmp}" );
	
	    if (move_uploaded_file($oTmp, $sTmpFile)) {
		$aImgInfo = getimagesize($sTmpFile);
	
		#--- check if mimetype is allowed
		if (!in_array($aImgInfo["mime"],
		array("image/jpeg", "image/pjpeg", "image/gif", "image/png", "image/x-png", "image/jpg", ))) {
			wfProfileOut(__METHOD__);
			return UPLOAD_ERR_EXTENSION;
		}
	
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

		$p = new ProfilePhoto( $wgUser->getID() );
		$new_photo_id = $p->addPhoto();
	    
		#--- generate thumbnails (always png format)
		$addedAvatars = array();
		foreach (array("l","m","s","g","p","d","t") as $size) {
		    $sThumb = ProfilePhoto::getPhotoFileFull($user->getID(), $new_photo_id, $size);
		    $aThumbSize = ProfilePhoto::getPhotoSize($size);
		   
			#-- check if directory part exists and is writable
			if (!is_dir(dirname($sThumb))) {
			    #--- try create
			    if (!mkdir(dirname($sThumb), 0777, true /*recursive*/)) {
				wfDebug( __METHOD__.": cannot create directory for {$sImageFull}\n" );
			    }
			}
			
		    $iThumbW = $aThumbSize["width"];
		    if( $aOrigSize["width"] < $iThumbW ){
			    $iThumbW  = $aOrigSize["width"];
		    }
		  //  echo $sTmpFile . "--" . $sThumb . "<BR>";
		   
		    exec("convert -resize " .$iThumbW . "  -quality 80  " . $sTmpFile . " " . $sThumb);
		   
		}
		//die();
		$hash = md5($user->getName());
		$dir = substr( $hash, 0, 3 );
		
		//create file with username.jpg format
		foreach (array("l","m","s","g","p","d","t") as $size) {
		    $sThumb = $wgProfilePhotoUploadPath . "/static/" . $dir . "/" . $this->CleanFilename($user->getName()) . "-" . $size . ".jpg";
		    $aThumbSize = ProfilePhoto::getPhotoSize($size);
			
		    $iThumbW = $aThumbSize["width"];
		    if( $aOrigSize["width"] < $iThumbW ){
			    $iThumbW  = $aOrigSize["width"];
		    }
		    exec("convert -resize " .$iThumbW . "  -quality 80  " . $sTmpFile . " " . $sThumb);
		   
		}
		
		
		unlink($sTmpFile);
	    }
	    else {
		$iErrNo = UPLOAD_ERR_CANT_WRITE;
		wfDebugLog( "photo", sprintf("%s: cannot move uploaded file from %s to", __METHOD__, $oTmp, $sTmpFile ));
	    }
	    wfProfileOut(__METHOD__);
	    return $iErrNo;
	}

  
}
?>