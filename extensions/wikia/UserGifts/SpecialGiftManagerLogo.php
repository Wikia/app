<?php

$wgExtensionFunctions[] = 'wfSpecialGiftManagerLogo';

function wfSpecialGiftManagerLogo()
{
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class GiftManagerLogo extends SpecialPage 
{
	var $mUploadFile, $mUploadDescription, $mIgnoreWarning;
	var $mUploadSaveName, $mUploadTempName, $mUploadSize, $mUploadOldVersion;
	var $mUploadCopyStatus, $mUploadSource, $mReUpload, $mAction, $mUpload;
	var $mOname, $mSessionKey, $mStashed, $mDestFile;
	var $avatarUploadDirectory;
	var $avatarUploadUrl;
	var $fileExtensions;
	var $gift_id;
	var $l_file, $s_file, $m_file;
	
  function GiftManagerLogo()
  {
  	global $wgMessageCache;
  	
  	UnlistedSpecialPage::UnlistedSpecialPage("GiftManagerLogo", "", false);
  	
  	require_once ( dirname( __FILE__ ) . '/UserGifts.i18n.php' );
  	foreach( efSpecialUserGits() as $lang => $messages ) 
  	{
  		$wgMessageCache->addMessages( $messages, $lang );
  	}
  }

  function execute()
  {
  	global $wgRequest, $IP;
  	require_once("$IP/extensions/wikia/UserGifts/GiftsClass.php");
  	$this->gift_id = $wgRequest->getVal("gift_id");
  	$this->initLogo($wgRequest);
  	$this->executeLogo();	 
  }
  
  function initLogo(&$request){
  	$this->fileExtensions = array(   'gif',  'jpg', 'jepg', 'png' );
  	if( !$request->wasPosted() ) 
  	{
  		# GET requests just give the main form; no data except wpDestfile.
  		return;
  	}
  	$this->gift_id = 		$request->getVal("gift_id");
  	$this->mIgnoreWarning     = $request->getCheck( 'wpIgnoreWarning');
  	$this->mReUpload          = $request->getCheck( 'wpReUpload' );
  	$this->mUpload            = $request->getCheck( 'wpUpload' );
		
	$this->mUploadDescription = $request->getText( 'wpUploadDescription' );
	$this->mUploadCopyStatus  = $request->getText( 'wpUploadCopyStatus' );
	$this->mUploadSource      = $request->getText( 'wpUploadSource' );
	$this->mWatchthis         = $request->getBool( 'wpWatchthis' );
	wfDebug( "UploadForm: watchthis is: '$this->mWatchthis'\n" );

	$this->mAction            = $request->getVal( 'action' );
	$this->mSessionKey        = $request->getInt( 'wpSessionKey' );
	if( !empty( $this->mSessionKey ) && isset( $_SESSION['wsUploadData'][$this->mSessionKey] ) ) 
	{
		/**
		 * Confirming a temporarily stashed upload.
		 * We don't want path names to be forged, so we keep
		 * them in the session on the server and just give
		 * an opaque key to the user agent.
		 */
		$data = $_SESSION['wsUploadData'][$this->mSessionKey];
		$this->mUploadTempName   = $data['mUploadTempName'];
		$this->mUploadSize       = $data['mUploadSize'];
		$this->mOname            = $data['mOname'];
		$this->mStashed	 	 = true;
	} else {
		/**
		 *Check for a newly uploaded file.
		 */
		$this->mUploadTempName = $request->getFileTempName( 'wpUploadFile' );
		$this->mUploadSize     = $request->getFileSize( 'wpUploadFile' );
		$this->mOname          = htmlspecialchars($request->getFileName( 'wpUploadFile' ));
		$this->mSessionKey     = false;
		$this->mStashed        = false;
	}
  }

	
	/**
	 * Start doing stuff
	 * @access public
	 */
	function executeLogo() 
	{
		global $wgUser, $wgOut;
		global $wgEnableUploads, $wgUploadDirectory;
		global $wgGiftImagePath, $wgMessageCache, $wgGiftImageUploadPath, $wgUploadPath;
		
		#---
		if (empty($wgGiftImageUploadPath)) {
			wfDebug( __METHOD__.": wgGiftImageUploadPath is empty, taking default ".$wgUploadDirectory."/awards\n" );
			$wgGiftImageUploadPath = $wgUploadDirectory."/awards";
		}
		if (empty($wgGiftImagePath)) {
			wfDebug( __METHOD__.": wgGiftImagePath is empty, taking default ".$wgUploadPath."/awards\n" );
			$wgGiftImagePath = $wgUploadPath."/awards";
		}
		
		$this->avatarUploadDirectory = $wgGiftImageUploadPath;
		$this->avatarUploadUrl = $wgGiftImagePath;
		
		/** Show an error message if file upload is disabled */ 
		if( ! $wgEnableUploads ) {
			$wgOut->addWikiText( wfMsg( 'uploaddisabled' ) );
			return;
		}

		/** Various rights checks */
		if( !$wgUser->isAllowed( 'upload' ) || $wgUser->isBlocked() ) {
			$wgOut->errorpage( 'uploadnologin', 'uploadnologintext' );
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		
		/** Check if the image directory is writeable, this is a common mistake */
		if ( !is_writeable( $wgUploadDirectory ) ) {
			$wgOut->addWikiText( wfMsg( 'upload_directory_read_only', $wgUploadDirectory ) );
			return;
		}

		if( $this->mReUpload ) {
			$this->unsaveUploadedFile();
			$this->mainUploadForm();
		} else if ( 'submit' == $this->mAction || $this->mUpload ) {
			$this->processUpload();
		} else {
			$this->mainUploadForm();
		}
	}

	/* -------------------------------------------------------------- */

	/**
	 * Really do the upload
	 * Checks are made in SpecialUpload::execute()
	 * @access private
	 */
	function processUpload() {
		global $wgUser, $wgOut, $wgLang, $wgContLang;
		global $wgUseCopyrightUpload, $wgCheckCopyrightUpload, $wgMessageCache;
		global $wgGiftImagePath, $wgGiftImageUploadPath, $wgUploadPath, $wgUploadDirectory;

		/**
		 * If there was no filename or a zero size given, give up quick.
		 */
		if( trim( $this->mOname ) == '' || empty( $this->mUploadSize ) ) {
			return $this->mainUploadForm('<li>'.wfMsg( 'emptyfile' ).'</li>');
		}

		# Chop off any directories in the given filename
		if ( $this->mDestFile ) {
			$basename = basename( $this->mDestFile );
		} else {
			$basename = basename( $this->mOname );
		}
		
		/**
		 * We'll want to blacklist against *any* 'extension', and use
		 * only the final one for the whitelist.
		 */
		list( $partname, $ext ) = $this->splitExtensions( $basename );
		if( count( $ext ) ) {
			$finalExt = $ext[count( $ext ) - 1];
		} else {
			$finalExt = '';
		}
		$fullExt = implode( '.', $ext );

		
		$this->mUploadSaveName = $basename;
		$filtered = $basename;

		/* Don't allow users to override the blacklist (check file extension) */
		global $wgStrictFileExtensions;
		global $wgFileBlacklist;
		
		if( $this->checkFileExtensionList( $ext, $wgFileBlacklist ) ||
			($wgStrictFileExtensions &&
				!$this->checkFileExtension( $finalExt, $this->fileExtensions ) ) ) {
			return $this->uploadError( wfMsg( 'badfiletype', htmlspecialchars( $fullExt ) ) );
		}

		/**
		 * Look at the contents of the file; if we can recognize the
		 * type but it's corrupt or data of the wrong type, we should
		 * probably not accept it.
		 */
		if( !$this->mStashed ) {
			$veri= $this->verify($this->mUploadTempName, $finalExt);
			
			if( $veri !== true ) { //it's a wiki error...
				return $this->uploadError( $veri->toString() );
			}
		}
		
		/**
		 * Check for non-fatal conditions
		 */
		if ( ! $this->mIgnoreWarning ) {
			$warning = '';
			
			global $wgCheckFileExtensions;
			if ( $wgCheckFileExtensions ) {
				if ( ! $this->checkFileExtension( $finalExt, $this->fileExtensions ) ) {
					$warning .= '<li>'.wfMsg( 'badfiletype', htmlspecialchars( $fullExt ) ).'</li>';
				}
			}

			if (  ( $this->mUploadSize > 102400 ) ) {
				# TODO: Format $wgUploadSizeWarning to something that looks better than the raw byte
				# value, perhaps add GB,MB and KB suffixes?
				$warning .= '<li>'.wfMsg( 'largefile',  102400, $this->mUploadSize ).'</li>';
			}
			if ( $this->mUploadSize == 0 ) {
				$warning .= '<li>'.wfMsg( 'emptyfile' ).'</li>';
			}
			
			
			if( $warning != '' ) {
				/**
				 * Stash the file in a temporary location; the user can choose
				 * to let it through and we'll complete the upload then.
				 */
				return $this->uploadWarning($warning);
			}
		}
			
		/**
		 * Try actually saving the thing...
		 * It will show an error form on failure.
		 */
		 
		 
		$status = $this->saveUploadedFile( $this->mUploadSaveName, $this->mUploadTempName, strtoupper($fullExt) );
									 
		if( $status > 0 ) {
			$this->showSuccess($status);
		}
	}

	
	function createThumbnail($imageSrc, $ext, $destDir, $imgDest, $thumbWidth)
	{
		#---
		list($origWidth ,$origHeight,$TypeCode)=getimagesize($imageSrc);

		if($origWidth < $thumbWidth)
		{
			$thumbWidth = $origWidth;
		}
		$thumbHeight = ($thumbWidth * $origHeight / $origWidth);
		$border = "";
		if ($thumbHeight < $thumbWidth) 
		{
			$border = " -bordercolor white  -border  0x" . (($thumbWidth - $thumbHeight) / 2);
		}
		if ($TypeCode == 2)
		{
			exec("convert -size " . $thumbWidth . "x" . $thumbWidth . " -resize " . $thumbWidth . "    -quality 100 " . $border . " " . $imageSrc . " " . $destDir . "/" . $imgDest . ".jpg");
		}
		if ($TypeCode == 1)
		{
			exec("convert -size " . $thumbWidth . "x" . $thumbWidth . " -resize " . $thumbWidth . "  " . $imageSrc . " " . $border . " " . $destDir . "/" . $imgDest . ".gif");
		}
		if ($TypeCode == 3)
		{
			exec("convert -size " . $thumbWidth . "x" . $thumbWidth . " -resize " . $thumbWidth . "   " . $imageSrc . " " . $destDir . "/" . $imgDest . ".png");
		}
	}



	/**
	 * Move the uploaded file from its temporary location to the final
	 * destination. If a previous version of the file exists, move
	 * it into the archive subdirectory.
	 *
	 * @todo If the later save fails, we may have disappeared the original file.
	 *
	 * @param string $saveName
	 * @param string $tempName full path to the temporary file
	 * @param bool $useRename if true, doesn't check that the source file
	 *                        is a PHP-managed upload temporary
	 */
	function saveUploadedFile( $saveName, $tempName, $ext) {
		global $wgUploadDirectory, $wgOut, $wgUser, $wgDBname, $IP;
		
  		require_once("$IP/extensions/wikia/UserGifts/GiftsClass.php");
		$dest = $this->avatarUploadDirectory;
		
		$this->mSavedFile = "{$dest}/{$saveName}";
		$this->l_file = Gifts::getGiftFile($this->gift_id, "l");
		$this->m_file = Gifts::getGiftFile($this->gift_id, "m");
		$this->s_file = Gifts::getGiftFile($this->gift_id, "s");

		$sGiftFullPath = $dest."/".Gifts::getGiftDir($this->gift_id);
    	if (!is_dir($sGiftFullPath)) {
            #--- try create
            if (!mkdir($sGiftFullPath, 0777, true /*recursive*/)) {
                wfDebug( __METHOD__.": cannot create directory for {$sGiftFullPath}\n" );
            }
        }
		
	 	$this->createThumbnail($tempName,$ext,$dest,$this->l_file, 75);
		$this->createThumbnail($tempName,$ext,$dest,$this->m_file, 30);
		$this->createThumbnail($tempName,$ext,$dest,$this->s_file, 16);
		
		if($ext == "JPG" && is_file( $dest . "/" . $this->l_file . ".jpg")){$type = 2;}
		if($ext == "GIF" && is_file( $dest . "/" . $this->l_file . ".gif")){$type = 1;}
		if($ext == "PNG" && is_file( $dest . "/" . $this->l_file . ".png")){$type = 3;}

		if($ext!="JPG"){
			 if(is_file($dest . "/" . $this->s_file . ".jpg") ) unlink($dest . "/" . $this->s_file . ".jpg");
			 if(is_file($dest . "/" . $this->m_file . ".jpg") ) unlink($dest . "/" . $this->m_file . ".jpg");
			 if(is_file($dest . "/" . $this->l_file . ".jpg") ) unlink($dest . "/" . $this->l_file . ".jpg");	
		}
		if($ext!="GIF"){
			 if(is_file($dest . "/" . $this->s_file . ".gif") ) unlink($dest . "/" . $this->s_file . ".gif");
			 if(is_file($dest . "/" . $this->m_file . ".gif") ) unlink($dest . "/" . $this->m_file . ".gif");
			 if(is_file($dest . "/" . $this->l_file . ".gif") ) unlink($dest . "/" . $this->l_file . ".gif");	
		}
		if($ext!="PNG"){
			 if(is_file($dest . "/" . $this->s_file . ".png") ) unlink($dest . "/" . $this->s_file . ".png");
			 if(is_file($dest . "/" . $this->m_file . ".png") ) unlink($dest . "/" . $this->m_file . ".png");
			 if(is_file($dest . "/" . $this->l_file . ".png") ) unlink($dest . "/" . $this->l_file . ".png");	
		}
		
		if($type > 0 ){
			//$dbr =& wfGetDB( DB_SLAVE );
			//$sql = "UPDATE user set user_avatar = " . $type . " WHERE user_id = " . $wgUser->mId;
			//$res = $dbr->query($sql);
		}else{
			$wgOut->fileCopyError( $tempName, $stash );
		}
		
		return $type;
	} 

	/**
	 * Stash a file in a temporary directory for later processing
	 * after the user has confirmed it.
	 *
	 * If the user doesn't explicitly cancel or accept, these files
	 * can accumulate in the temp directory.
	 *
	 * @param string $saveName - the destination filename
	 * @param string $tempName - the source temporary file to save
	 * @return string - full path the stashed file, or false on failure
	 * @access private
	 */
	function saveTempUploadedFile( $saveName, $tempName ) {
		global $wgOut;		
		$archive = wfImageArchiveDir( $saveName, 'temp' );
		$stash = $archive . '/' . gmdate( "YmdHis" ) . '!' . $saveName;

		if ( !move_uploaded_file( $tempName, $stash ) ) {
			$wgOut->fileCopyError( $tempName, $stash );
			return false;
		}
		
		return $stash;
	}
	
	/**
	 * Stash a file in a temporary directory for later processing,
	 * and save the necessary descriptive info into the session.
	 * Returns a key value which will be passed through a form
	 * to pick up the path info on a later invocation.
	 *
	 * @return int
	 * @access private
	 */
	function stashSession() {
		#---		
		$stash = $this->saveTempUploadedFile( $this->mUploadSaveName, $this->mUploadTempName );

		if( !$stash ) {
			# Couldn't save the file.
			return false;
		}
		
		$key = mt_rand( 0, 0x7fffffff );
		$_SESSION['wsUploadData'][$key] = array(
			'mUploadTempName' => $stash,
			'mUploadSize'     => $this->mUploadSize,
			'mOname'          => $this->mOname );
		return $key;
	}

	/**
	 * Remove a temporarily kept file stashed by saveTempUploadedFile().
	 * @access private
	 */
	function unsaveUploadedFile() {
		wfSuppressWarnings();
		$success = unlink( $this->mUploadTempName );
		wfRestoreWarnings();
		if ( ! $success ) {
			$wgOut->fileDeleteError( $this->mUploadTempName );
		}
	}

	/* -------------------------------------------------------------- */

	/**
	 * Show some text and linkage on successful upload.
	 * @access private
	 */
	function showSuccess($status) {
		global $wgUser, $wgOut, $wgContLang, $wgDBname, $wgLogTypes;
		
		if (!in_array('gift_image', $wgLogTypes))
		{
			$wgLogTypes[] = 'gift_image';
		}

		$ext = "jpg";

		$output = "<h2>".wfMsg('uploadsuccess')."</h2>";
		$output .= "<h5>".wfMsg('listuploadimages')."</h5>";
		if($status==1)$ext = "gif";
		if($status==2)$ext = "jpg";
		if($status==3)$ext = "png";

    	$userText = $wgUser->getName();
		$img = Image::newFromName($this->l_file . "." . $ext);
		if ($img)
		{
			$imgTitle = $img->getTitle();
		}

        $logPage = new LogPage( 'gift_image' );
        $logComment = "Add/change image for gift ({$this->gift_id}) [[Special:ViewGift&gift_id={$this->gift_id}]] by {$userText}";
        $logPage->addEntry( 'gift_image', $imgTitle, $logComment);
		
		$output .= "<table cellspacing=0 cellpadding=5>";
		$output .= "<tr><td valign=top style='color:#666666;font-weight:800'>".wfMsg('large')."</td><td><img src=".$this->avatarUploadUrl."/" . $this->l_file . "." . $ext . "?ts=" .  rand()   . "></td></tr>";
		$output .= "<tr><td valign=top style='color:#666666;font-weight:800'>".wfMsg('medium')."</td><td><img src=".$this->avatarUploadUrl."/" . $this->m_file . "." . $ext . "?ts=" .  rand()   . "></td></tr>";
		$output .= "<tr><td valign=top style='color:#666666;font-weight:800'>".wfMsg('small')."</td><td><img src=".$this->avatarUploadUrl."/" . $this->s_file . "." . $ext . "?ts" .  rand()   . "=></td></tr>";
		$output .= "<tr><td><input type=button onclick=javascript:history.go(-1) value='".wfMsg('gobackbtn')."'></td></tr>";

		$output .= "<tr><td><a href=\"/index.php?title=Special:GiftManager\">".wfMsg('backtogiftlist')."</a> |";
		$output .= " <a href=\"/index.php?title=Special:GiftManager&amp;id={$this->gift_id}\">".wfMsg('backtoeditgift')."</a></td></tr>";
		$output .= "</table>";
		
		$wgOut->addHTML($output);
	}

	/**
	 * @param string $error as HTML
	 * @access private
	 */
	function uploadError( $error ) 
	{
		global $wgOut, $wgMessageCache;
		$sub = wfMsg( 'uploadwarning' );
		$wgOut->addHTML( "<h2>{$sub}</h2>\n" );
		$wgOut->addHTML( "<h4 class='error'>{$error}</h4>\n" );
		$wgOut->addHTML("<br><input type=button onclick=javascript:history.go(-1) value='".wfMsg('gobackbtn')."'>");
	}

	/**
	 * There's something wrong with this file, not enough to reject it
	 * totally but we require manual intervention to save it for real.
	 * Stash it away, then present a form asking to confirm or cancel.
	 *
	 * @param string $warning as HTML
	 * @access private
	 */
	function uploadWarning( $warning ) 
	{
		global $wgOut, $wgUser, $wgLang, $wgUploadDirectory, $wgRequest;
		global $wgUseCopyrightUpload, $wgMessageCache;

		$this->mSessionKey = $this->stashSession();
		if( !$this->mSessionKey ) {
			# Couldn't save file; an error has been displayed so let's go.
			return;
		}

		$sub = wfMsg( 'uploadwarning' );
		$wgOut->addHTML( "<h2>{$sub}</h2>\n" );
		$wgOut->addHTML( "<ul class='warning'>{$warning}</ul><br />\n" );

		$save = wfMsg( 'savefile' );
		$reupload = wfMsg( 'reupload' );
		$iw = wfMsg( 'ignorewarning' );
		$reup = wfMsg( 'reuploaddesc' );
		$titleObj = Title::makeTitle( NS_SPECIAL, 'Upload' );
		$action = $titleObj->escapeLocalURL( 'action=submit' );

		if ( $wgUseCopyrightUpload )
		{
			$copyright =  "
			<input type='hidden' name='wpUploadCopyStatus' value=\"" . htmlspecialchars( $this->mUploadCopyStatus ) . "\" />
			<input type='hidden' name='wpUploadSource' value=\"" . htmlspecialchars( $this->mUploadSource ) . "\" />
			";
		} else {
			$copyright = "";
		}

		$wgOut->addHTML( "
	<form id='uploadwarning' method='post' enctype='multipart/form-data' action='$action'>
		<input type='hidden' name='gift_id' value=\"" . ( $this->gift_id ) . "\" />
		<input type='hidden' name='wpIgnoreWarning' value='1' />
		<input type='hidden' name='wpSessionKey' value=\"" . htmlspecialchars( $this->mSessionKey ) . "\" />
		<input type='hidden' name='wpUploadDescription' value=\"" . htmlspecialchars( $this->mUploadDescription ) . "\" />
		<input type='hidden' name='wpDestFile' value=\"" . htmlspecialchars( $this->mDestFile ) . "\" />
		<input type='hidden' name='wpWatchthis' value=\"" . htmlspecialchars( intval( $this->mWatchthis ) ) . "\" />
	{$copyright}
	<table border='0'>
		<tr>
			<td align='right'>
				<input tabindex='2' type='button' onclick=javascript:history.go(-1) value='".wfMsg('gobackbtn')."' />
			</td>
		</tr>
	</table></form>\n" );
	}

	/**
	 * Displays the main upload form, optionally with a highlighted
	 * error message up at the top.
	 *
	 * @param string $msg as HTML
	 * @access private
	 */
	function mainUploadForm( $msg='' ) 
	{
		global $wgOut, $wgUser, $wgLang, $wgUploadDirectory, $wgRequest;
		global $wgUseCopyrightUpload, $wgMessageCache;
		
		$cols = intval($wgUser->getOption( 'cols' ));
		$ew = $wgUser->getOption( 'editwidth' );
		if ( $ew ) $ew = " style=\"width:100%\"";
		else $ew = '';

		if ( '' != $msg ) {
			$sub = wfMsg( 'uploaderror' );
			$wgOut->addHTML( "<h2>{$sub}</h2>\n" .
			  "<h4 class='error'>{$msg}</h4>\n" );
		}
		//$wgOut->addWikiText( wfMsg( 'uploadtext' ) );
		$sk = $wgUser->getSkin();


		$sourcefilename = wfMsg( 'sourcefilename' );
		$destfilename = wfMsg( 'destfilename' );
		
		$fd = wfMsg( 'filedesc' );
		$ulb = wfMsg( 'uploadbtn' );

		$iw = wfMsg( 'ignorewarning' );

		$titleObj = Title::makeTitle( NS_SPECIAL, 'Upload' );
		$action = $titleObj->escapeLocalURL();

		$encDestFile = htmlspecialchars( $this->mDestFile );
		$source = null;

        $wgOut->setPageTitle( wfMsg("addchangegifttitle") );
        $wgOut->setRobotpolicy( "noindex,nofollow" );

		if ( $wgUseCopyrightUpload )
		{
			$source = "
	<td align='right' nowrap='nowrap'>" . wfMsg ( 'filestatus' ) . ":</td>
	<td><input tabindex='3' type='text' name=\"wpUploadCopyStatus\" value=\"" .
	htmlspecialchars($this->mUploadCopyStatus). "\" size='40' /></td>
	</tr><tr>
	<td align='right'>". wfMsg ( 'filesource' ) . ":</td>
	<td><input tabindex='4' type='text' name='wpUploadSource' value=\"" .
	htmlspecialchars($this->mUploadSource). "\" style='width:100px' /></td>
	" ;
		}

		$watchChecked = $wgUser->getOption( 'watchdefault' )
			? 'checked="checked"'
			: '';

		$gift_image = Gifts::getGiftImage($this->gift_id,"l");
		$gift_img = $this->avatarUploadUrl."/" . $gift_image;
		$gift_name = "";
		if (file_exists($gift_img))
		{
			$gift_name = "<img src=\"".$gift_img. "\" border=\"0\" alt=\"gift\" />";
		}
		if($gift_image != "")
		{
			$output = "<table><tr><td style='color:#666666;font-weight:800'>".wfMsg('currentimage')."</td></tr>";
			$output .= "<tr><td>".$gift_name."</td></tr></table><br>";
		}
		$wgOut->addHTML($output);


		$wgOut->addHTML( "
	<form id='upload' method='post' enctype='multipart/form-data' action=\"\">
	<table border='0'><tr>

	<td style='color:#666666;font-weight:800'>".wfMsg('image_upload_info')."<p>".wfMsg('choose_file').":<br>
	<input tabindex='1' type='file' name='wpUploadFile' id='wpUploadFile'  size=\"25\" />
	</td></tr><tr>
	{$source}
	</tr>
	<tr><td>
	<input tabindex='5' type='submit' name='wpUpload' value=\"{$ulb}\" />
	</td></tr></table></form>\n" );
	}
	
	/* -------------------------------------------------------------- */

	/**
	 * Split a file into a base name and all dot-delimited 'extensions'
	 * on the end. Some web server configurations will fall back to
	 * earlier pseudo-'extensions' to determine type and execute
	 * scripts, so the blacklist needs to check them all.
	 *
	 * @return array
	 */
	function splitExtensions( $filename ) {
		$bits = explode( '.', $filename );
		$basename = array_shift( $bits );
		return array( $basename, $bits );
	}
	
	/**
	 * Perform case-insensitive match against a list of file extensions.
	 * Returns true if the extension is in the list.
	 *
	 * @param string $ext
	 * @param array $list
	 * @return bool
	 */
	function checkFileExtension( $ext, $list ) {
		return in_array( strtolower( $ext ), $list );
	}

	/**
	 * Perform case-insensitive match against a list of file extensions.
	 * Returns true if any of the extensions are in the list.
	 *
	 * @param array $ext
	 * @param array $list
	 * @return bool
	 */
	function checkFileExtensionList( $ext, $list ) {
		foreach( $ext as $e ) {
			if( in_array( strtolower( $e ), $list ) ) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Verifies that it's ok to include the uploaded file
	 *
	 * @param string $tmpfile the full path opf the temporary file to verify
	 * @param string $extension The filename extension that the file is to be served with
	 * @return mixed true of the file is verified, a WikiError object otherwise.
	 */
	function verify( $tmpfile, $extension ) {
		global $wgMessageCache;
		
		#magically determine mime type
		$magic=& wfGetMimeMagic();
		$mime= $magic->guessMimeType($tmpfile,false);
		
		$fname= "SpecialUpload::verify";
		
		#check mime type, if desired
		global $wgVerifyMimeType;
		if ($wgVerifyMimeType) 
		{
			#check mime type against file extension
			if( !$this->verifyExtension( $mime, $extension ) ) {
				return new WikiErrorMsg( 'uploadcorrupt' );
			}
		
			#check mime type blacklist
			global $wgMimeTypeBlacklist;
			if( isset($wgMimeTypeBlacklist) && !is_null($wgMimeTypeBlacklist) 
				&& $this->checkFileExtension( $mime, $wgMimeTypeBlacklist ) ) {
				return new WikiErrorMsg( 'badfiletype', htmlspecialchars( $mime ) );
			}
		}
	
		#check for htmlish code and javascript
		if( $this->detectScript ( $tmpfile, $mime ) ) {
			return new WikiErrorMsg( 'uploadscripted' );
		}
		
		/**
		* Scan the uploaded file for viruses
		*/
		$virus= $this->detectVirus($tmpfile);
		if ( $virus ) {
			return new WikiErrorMsg( 'uploadvirus', htmlspecialchars($virus) );
		}
		
		wfDebug( "$fname: all clear; passing.\n" );
		return true;
	}
	
	/**
	 * Checks if the mime type of the uploaded file matches the file extension.
	 *
	 * @param string $mime the mime type of the uploaded file
	 * @param string $extension The filename extension that the file is to be served with
	 * @return bool
	 */
	function verifyExtension( $mime, $extension ) {
		$fname = 'SpecialUpload::verifyExtension';

		$magic =& wfGetMimeMagic();

		if ( ! $mime || $mime == 'unknown' || $mime == 'unknown/unknown' )
			if ( ! $magic->isRecognizableExtension( $extension ) ) {
				wfDebug( "$fname: passing file with unknown detected mime type; unrecognized extension '$extension', can't verify\n" );
				return true;
			} else {
				wfDebug( "$fname: rejecting file with unknown detected mime type; recognized extension '$extension', so probably invalid file\n" );
				return false;
			}

		$match= $magic->isMatchingExtension($extension,$mime);
		
		if ($match===NULL) {
			wfDebug( "$fname: no file extension known for mime type $mime, passing file\n" );
			return true; 
		} elseif ($match===true) {
			wfDebug( "$fname: mime type $mime matches extension $extension, passing file\n" );
			
			#TODO: if it's a bitmap, make sure PHP or ImageMagic resp. can handle it!
			return true;
			
		} else {
			wfDebug( "$fname: mime type $mime mismatches file extension $extension, rejecting file\n" );
			return false; 
		}
	}
	
	/** Heuristig for detecting files that *could* contain JavaScript instructions or 
	* things that may look like HTML to a browser and are thus
	* potentially harmful. The present implementation will produce false positives in some situations.
	*
	* @param string $file Pathname to the temporary upload file
	* @param string $mime The mime type of the file
	* @return bool true if the file contains something looking like embedded scripts
	*/
	function detectScript($file,$mime) {
		
		#ugly hack: for text files, always look at the entire file.
		#For binarie field, just check the first K.
		
		if (strpos($mime,'text/')===0) $chunk = file_get_contents( $file );
		else {
			$fp = fopen( $file, 'rb' );
			$chunk = fread( $fp, 1024 );
			fclose( $fp );
		}
		
		$chunk= strtolower( $chunk );
		
		if (!$chunk) return false;
		
		#decode from UTF-16 if needed (could be used for obfuscation).
		if (substr($chunk,0,2)=="\xfe\xff") $enc= "UTF-16BE"; 
		elseif (substr($chunk,0,2)=="\xff\xfe") $enc= "UTF-16LE"; 
		else $enc= NULL;
			
		if ($enc) $chunk= iconv($enc,"ASCII//IGNORE",$chunk);
		
		$chunk= trim($chunk);
		
		#FIXME: convert from UTF-16 if necessarry!
		
		wfDebug("SpecialUpload::detectScript: checking for embedded scripts and HTML stuff\n");
		
		#check for HTML doctype
		if (eregi("<!DOCTYPE *X?HTML",$chunk)) return true;
		
		/**
		* Internet Explorer for Windows performs some really stupid file type
		* autodetection which can cause it to interpret valid image files as HTML
		* and potentially execute JavaScript, creating a cross-site scripting
		* attack vectors.
		*
		* Apple's Safari browser also performs some unsafe file type autodetection
		* which can cause legitimate files to be interpreted as HTML if the
		* web server is not correctly configured to send the right content-type
		* (or if you're really uploading plain text and octet streams!)
		*
		* Returns true if IE is likely to mistake the given file for HTML.
		* Also returns true if Safari would mistake the given file for HTML
		* when served with a generic content-type.
		*/
		
		$tags = array(
			'<body',
			'<head',
			'<html',   #also in safari
			'<img',
			'<pre',
			'<script', #also in safari
			'<table',
			'<title'   #also in safari
			);
			
		foreach( $tags as $tag ) {
			if( false !== strpos( $chunk, $tag ) ) {
				return true;
			}
		}
		
		/*
		* look for javascript 
		*/
		
		#resolve entity-refs to look at attributes. may be harsh on big files... cache result?
		$chunk = Sanitizer::decodeCharReferences( $chunk );
		
		#look for script-types
		if (preg_match("!type\s*=\s*['\"]?\s*(\w*/)?(ecma|java)!sim",$chunk)) return true;
		
		#look for html-style script-urls
		if (preg_match("!(href|src|data)\s*=\s*['\"]?\s*(ecma|java)script:!sim",$chunk)) return true;
		
		#look for css-style script-urls
		if (preg_match("!url\s*\(\s*['\"]?\s*(ecma|java)script:!sim",$chunk)) return true;
		
		wfDebug("SpecialUpload::detectScript: no scripts found\n");
		return false;
	}
	
	/** Generic wrapper function for a virus scanner program.
	* This relies on the $wgAntivirus and $wgAntivirusSetup variables.
	* $wgAntivirusRequired may be used to deny upload if the scan fails.
	*
	* @param string $file Pathname to the temporary upload file
	* @return mixed false if not virus is found, NULL if the scan fails or is disabled,
	*         or a string containing feedback from the virus scanner if a virus was found.
	*         If textual feedback is missing but a virus was found, this function returns true.
	*/
	function detectVirus($file) {
		global $wgAntivirus, $wgAntivirusSetup, $wgAntivirusRequired;
		
		$fname= "SpecialUpload::detectVirus";
		
		if (!$wgAntivirus) { #disabled?
			wfDebug("$fname: virus scanner disabled\n");
			
			return NULL;
		}
		
		if (!$wgAntivirusSetup[$wgAntivirus]) { 
			wfDebug("$fname: unknown virus scanner: $wgAntivirus\n"); 

			$wgOut->addHTML( "<div class='error'>".wfMsg('unknown_virus_scanner').": <i>$wgAntivirus</i></div>\n" ); #LOCALIZE
			
			return "unknown antivirus: $wgAntivirus";
		}
		
		#look up scanner configuration
		$virus_scanner= $wgAntivirusSetup[$wgAntivirus]["command"]; #command pattern
		$virus_scanner_codes= $wgAntivirusSetup[$wgAntivirus]["codemap"]; #exit-code map
		$msg_pattern= $wgAntivirusSetup[$wgAntivirus]["messagepattern"]; #message pattern
		
		$scanner= $virus_scanner; #copy, so we can resolve the pattern
		
		if (strpos($scanner,"%f")===false) $scanner.= " ".wfEscapeShellArg($file); #simple pattern: append file to scan
		else $scanner= str_replace("%f",wfEscapeShellArg($file),$scanner); #complex pattern: replace "%f" with file to scan
		
		wfDebug("$fname: running virus scan: $scanner \n");
		
		#execute virus scanner
		$code= false;
		
		#NOTE: there's a 50 line workaround to make stderr redirection work on windows, too.
		#      that does not seem to be worth the pain. 
		#      Ask me (Duesentrieb) about it if it's ever needed.
		if (wfIsWindows()) exec("$scanner",$output,$code); 
		else exec("$scanner 2>&1",$output,$code); 
		
		$exit_code= $code; #remeber for user feedback
		
		if ($virus_scanner_codes) { #map exit code to AV_xxx constants.
			if (isset($virus_scanner_codes[$code])) $code= $virus_scanner_codes[$code]; #explicite mapping
			else if (isset($virus_scanner_codes["*"])) $code= $virus_scanner_codes["*"]; #fallback mapping
		}
		
		if ($code===AV_SCAN_FAILED) { #scan failed (code was mapped to false by $virus_scanner_codes)
			wfDebug("$fname: failed to scan $file (code $exit_code).\n");
			
			if ($wgAntivirusRequired) return "scan failed (code $exit_code)";
			else return NULL; 
		}
		else if ($code===AV_SCAN_ABORTED) { #scan failed because filetype is unknown (probably imune)
			wfDebug("$fname: unsupported file type $file (code $exit_code).\n");
			return NULL; 
		}
		else if ($code===AV_NO_VIRUS) {
			wfDebug("$fname: file passed virus scan.\n");
			return false; #no virus found
		}
		else { 
			$output= join("\n",$output);
			$output= trim($output);
			
			if (!$output) $output= true; #if ther's no output, return true
			else if ($msg_pattern) {
				$groups= array();
				if (preg_match($msg_pattern,$output,$groups)) {
					if ($groups[1]) $output= $groups[1];
				}
			}
			
			wfDebug("$fname: FOUND VIRUS! scanner feedback: $output");
			return $output;
		}
	}
}

 SpecialPage::addPage( new GiftManagerLogo );
 global $wgMessageCache,$wgOut;
 //$wgMessageCache->addMessage( 'avatarupload', 'just a test extension' );
}

?>
