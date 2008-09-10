<?

$wgExtensionFunctions[] = 'wfMiniAjaxUpload';

function wfMiniAjaxUpload(){
	
	class MiniAjaxUpload extends SpecialPage {
		
		function MiniAjaxUpload(){
			UnlistedSpecialPage::UnlistedSpecialPage("MiniAjaxUpload");
		}
		
		function execute(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP;
			$wgOut->setArticleBodyOnly(true);
			$form = new PollAjaxUploadForm($wgRequest);
			$form->execute();
		}
		
	}
	
	SpecialPage::addPage( new MiniAjaxUpload );
}

/* Class has been modified a bit.
   If wpNoCaption is true the caption field wont be shown
   If wpOverwriteFile is passed in as true, a timestamp wont be prepended to the file
   wpThumbWidth is the width of the thumbnail that will be returned
   wpCallbackPrefix is the prefix appended to javascript calls (ie uploaded multiple files)
   Also, to prevent overwriting uploads of files with popular names ie image.jpg
   	all the uploaded files are prepended with the current timestamp.
*/

require_once 'specials/SpecialUpload.php';
require_once 'SpecialPage.php';
class MiniAjaxUploadForm extends UploadForm{
	
	/**
	 * Do the upload
	 * Checks are made in SpecialUpload::execute()
	 *
	 * @access private
	 */
	function processUpload(){
		global $wgUser, $wgOut, $wgFileExtensions;
	 	$details = null;
	 	$value = null;
	 	$value = $this->internalProcessUpload( $details );
		
	 	switch($value) {
			case self::SUCCESS:
				$this->showSuccess();
			    return;

			case self::BEFORE_PROCESSING:
				return false;

			case self::LARGE_FILE_SERVER:
				$this->mainUploadForm( wfMsgHtml( 'largefileserver' ) );
			    return;

			case self::EMPTY_FILE:
				$this->mainUploadForm( wfMsgHtml( 'emptyfile' ) );
			    return;

			case self::MIN_LENGHT_PARTNAME:
				$this->mainUploadForm( wfMsgHtml( 'minlength1' ) );
			    return;

			case self::ILLEGAL_FILENAME:
				$filtered = $details['filtered'];
				$this->uploadError( wfMsgWikiHtml( 'illegalfilename', htmlspecialchars( $filtered ) ) );
			    return;

			case self::PROTECTED_PAGE:
				return $this->uploadError( wfMsgWikiHtml( 'protectedpage' ) );

			case self::OVERWRITE_EXISTING_FILE:
				$errorText = $details['overwrite'];
				$overwrite = new WikiError( $wgOut->parse( $errorText ) );
				return $this->uploadError( $overwrite->toString() );

			case self::FILETYPE_MISSING:
				return $this->uploadError( wfMsgExt( 'filetype-missing', array ( 'parseinline' ) ) );

			case self::FILETYPE_BADTYPE:
				$finalExt = $details['finalExt'];
				return $this->uploadError( wfMsgExt( 'filetype-badtype', array ( 'parseinline' ), htmlspecialchars( $finalExt ), implode ( ', ', $wgFileExtensions ) ) );

			case self::VERIFICATION_ERROR:
				$veri = $details['veri'];
				return $this->uploadError( $veri->toString() );

			case self::UPLOAD_VERIFICATION_ERROR:
				$error = $details['error'];
				return $this->uploadError( $error );

			case self::UPLOAD_WARNING:
				$warning = $details['warning'];
				return $this->uploadWarning( $warning );
	 	}
		
		/* TODO: Each case returns instead of breaking to maintain the highest level of compatibility during branch merging.
		They should be reviewed and corrected separatelly.
		*/
		 new MWException( __METHOD__ . ": Unknown value `{$value}`" );
	}
	
	function mainUploadForm( $msg='' ) {
		global $wgOut, $wgUser;
		global $wgUseCopyrightUpload;
		global $wgRequest, $wgAllowCopyUploads, $wgStyleVersion;

		if( !wfRunHooks( 'UploadForm:initial', array( &$this ) ) )
		{
			wfDebug( "Hook 'UploadForm:initial' broke output of the upload form" );
			return false;
		}

		$isOverwrite = $wgRequest->getVal('wpOverwriteFile');
		$noCaption = $wgRequest->getVal( 'wpNoCaption' );
		$this->mUploadDescription = $wgRequest->getVal('wpUploadDescription');
		
		// $cols = intval($wgUser->getOption( 'cols' ));
		$cols = 30;
		$ew = $wgUser->getOption( 'editwidth' );
		if ( $ew ) $ew = " style=\"width:100%\"";
		else $ew = '';

		if ( '' != $msg ) {
			$sub = wfMsgHtml( 'uploaderror' );
			/* $wgOut->addHTML( "<h2>{$sub}</h2>\n" .
			  "<span class='error'>{$msg}</span>\n" ); */
			
			$prefix = $wgRequest->getVal("callbackPrefix");
			if(strlen($prefix) == 0)
				$prefix = "";
			
			$wgOut->addHTML( "<script language=\"javascript\">
					  /*<![CDATA[*/
					  window.parent.{$prefix}uploadError('{$msg}');
					  /*]]>*/</script>");
		}
		
		// don't want the upload text stuff
		/* $wgOut->addHTML( '<div id="uploadtext">' );
		$wgOut->addWikiText( wfMsgNoTrans( 'uploadtext', $this->mDestFile ) );
		$wgOut->addHTML( '</div>' ); */
		
		$destfilename = wfMsgHtml( 'destfilename' );
		$sourcefilename = 'File';
		
		// $summary = wfMsgWikiHtml( 'fileuploadsummary' );
		if($isOverwrite != true || !$noCaption){
			$summary = "Caption";
		}else{
			$summary = "";
			$isOverwrite = true; 
		}
		
		$licenses = new Licenses();
		$license = wfMsgHtml( 'license' );
		$nolicense = wfMsgHtml( 'nolicense' );
		$licenseshtml = $licenses->getHtml();

		$ulb = wfMsgHtml( 'uploadbtn' );


		$titleObj = SpecialPage::getTitleFor( 'Upload' );
		// $action = $titleObj->escapeLocalURL();
		$action = $wgRequest->getRequestURL();

		$encDestFile = htmlspecialchars( $this->mDestFile );

		$watchChecked =
			( $wgUser->getOption( 'watchdefault' ) ||
				( $wgUser->getOption( 'watchcreations' ) && $this->mDestFile == '' ) )
			? 'checked="checked"'
			: '';

		// Prepare form for upload or upload/copy
		if( $wgAllowCopyUploads && $wgUser->isAllowed( 'upload_by_url' ) ) {
			$filename_form =
				"<input type='radio' id='wpSourceTypeFile' name='wpSourceType' value='file' onchange='toggle_element_activation(\"wpUploadFileURL\",\"wpUploadFile\")' checked />" .
				"<input tabindex='1' type='file' name='wpUploadFile' id='wpUploadFile' onfocus='toggle_element_activation(\"wpUploadFileURL\",\"wpUploadFile\");toggle_element_check(\"wpSourceTypeFile\",\"wpSourceTypeURL\")'" .
				($this->mDestFile?"":"onchange='fillDestFilename(\"wpUploadFile\")' ") . "size='40' />" .
				wfMsgHTML( 'upload_source_file' ) . "<br/>" .
				"<input type='radio' id='wpSourceTypeURL' name='wpSourceType' value='web' onchange='toggle_element_activation(\"wpUploadFile\",\"wpUploadFileURL\")' />" .
				"<input tabindex='1' type='text' name='wpUploadFileURL' id='wpUploadFileURL' onfocus='toggle_element_activation(\"wpUploadFile\",\"wpUploadFileURL\");toggle_element_check(\"wpSourceTypeURL\",\"wpSourceTypeFile\")'" .
				($this->mDestFile?"":"onchange='fillDestFilename(\"wpUploadFileURL\")' ") . "size='40' DISABLED />" .
				wfMsgHtml( 'upload_source_url' ) ;
		} else {
			$filename_form =
				"<input tabindex='1' type='file' name='wpUploadFile' id='wpUploadFile' " .
				($this->mDestFile?"":"onchange='fillDestFilename(\"wpUploadFile\")' ") .
				"size='40' />" .
				"<input type='hidden' name='wpSourceType' value='file' />" ;
		}

		$prefix = $wgRequest->getVal("callbackPrefix");
		
		if(strlen($prefix) == 0)
			$prefix = "";

		$wgOut->addHTML( "
			<script language=\"javascript\" src=\"/extensions/wikia/onejstorule.js?{$wgStyleVersion}\"></script>
			<script language=\"javascript\">
			
			function submitForm(){
				
				if(document.upload.wpUploadFile.value != ''){
					document.getElementById('wpDestFile').value = '" . time() . "-' + document.getElementById('wpDestFile').value;
					window.parent.{$prefix}completeImageUpload();
					return true;
				}else{
					window.parent.{$prefix}textError('The file you uploaded seems to be empty. This might be due to a typo in the file name. Please check whether you really want to upload this file.');
					return false;
				}
				
			}
			
			function fillDestFilename(id) {
				
				if (!document.getElementById) {
					return;
				}
				
				var path = document.getElementById(id).value;
				// Find trailing part
				
				var slash = path.lastIndexOf('/');
				var backslash = path.lastIndexOf('\\\\');
				var fname;
				
				if (slash == -1 && backslash == -1) {
					fname = path;
				} else if (slash > backslash) {
					fname = path.substring(slash+1, 10000);
				} else {
					fname = path.substring(backslash+1, 10000);
				}
				
				// Capitalise first letter and replace spaces by underscores
				fname = fname.charAt(0).toUpperCase().concat(fname.substring(1,10000)).replace(/ /g, '_');
				
				// Output result
				var destFile = document.getElementById('wpDestFile');
				if (destFile) {
					destFile.value = fname;
				}
			}
			</script>
			<style>
				body {
					margin:0px;
					padding:0px;
					font-family:arial;
				}
				
				.upload-form td {
					padding:0px 0px 9px 0px;
					font-size:13px;
				}
				
				.standard-button {
					background-color:#FAFAFA;
					border:1px solid #DCDCDC;
					color:#376EA6;
					font-size:12px;
					padding:3px;
				}
			</style>
			
			<form id='upload' name='upload'  onSubmit=\"return submitForm();\" method='post' enctype='multipart/form-data' action=\"$action\">
				<table border='0' cellpadding='0' cellspacing='0' class='upload-form'>		
					<tr>
						<td>{$filename_form}</td>
					</tr>
					<input tabindex='2' type='hidden' name='wpDestFile' id='wpDestFile' size='35' value=\"$encDestFile\" />
					<input type='hidden' name='wpIgnoreWarning' id='wpIgnoreWarning' value='true' />
					<tr>
						<td>
							<input tabindex='9' type='submit' id='wpUpload' name='wpUpload' value=\"" . wfMsgForContent( 'poll_upload_image_button' ) . "\" />
						</td>
					</tr>
				</table>
			</form>
	" );
	
	}
	/* --------------------------------------------------------------" */
	 
	// The way this works is probably REALLY bad.
	// I can't find the hook where MediaWiki is causing newly uploaded files
	// to forward to the summary page :(
	function showSuccess() {
		global $wgOut, $wgContLang, $wgUser, $wgRequest;
		
		$wgOut->setArticleBodyOnly(true);
		$wgOut->clearHTML();
		
		$prefix = $wgRequest->getVal("wpCallbackPrefix");
		$thumbWidth = $wgRequest->getVal("wpThumbWidth");
		$insertCat = $wgRequest->getVal("wpCategory");
		
		if(!is_numeric($thumbWidth))
			$thumbWidth = 0;
		
		$prefix = str_replace("<script>", "", $prefix);
		$prefix = str_replace("</script>", "", $prefix);
		
		if(strlen($prefix) == 0)
			$prefix = "";
		
		$img = Image::newFromName( $this->mDestName );
		
		$thumb = $img->getThumbnail( $thumbWidth  );
		$img_tag = $thumb->toHtml();

		
		?> 
			<script language="javascript">
			/*<![CDATA[*/ 
			window.parent.<?php print $prefix?>uploadComplete("<?php print addslashes( $img_tag ); ?>", "<?php print $this->mUploadSaveName ?>", "<?php print htmlentities ( $desc ) ?>");
			/*]]>*/</script>
		<?php
		die();
	}
	
	function uploadError( $error ) {
		global $wgOut, $wgRequest;
		/* $wgOut->addHTML( "<h2>" . wfMsgHtml( 'uploadwarning' ) . "</h2>\n" );
		$wgOut->addHTML( "<span class='error'>{$error}</span>\n" );*/
		
		$prefix = $wgRequest->getVal("callbackPrefix");
		if(strlen($prefix) == 0)
			$prefix = "";
		
		$error = addslashes ($error);
		$wgOut->addHTML("<script language=\"javascript\">
				/*<![CDATA[*/
				window.parent.{$prefix}uploadError('{$error}');
				/*]]>*/</script>");
	}
}

?>
