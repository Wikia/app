<?php

$wgExtensionFunctions[] = 'wfSpecialIFrameUpload';


function wfSpecialIFrameUpload(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");
include_once("includes/SpecialUpload.php");
include_once("includes/Parser.php");
class IFrameUpload extends UnlistedSpecialPage {

	 
	
  function IFrameUpload(){
    UnlistedSpecialPage::UnlistedSpecialPage("IFrameUpload");
  }

  function execute(){
  	global $wgRequest, $wgOut, $wgUser;
	$sk = $wgUser->getSkin();
	$wgOut->addHTML($sk->getUserStyles());
	//$wgOut->addHTML($sk->getHeadScripts());
	$form = new UploadFormCustom( $wgRequest );
	$wgOut->addHTML("
				<style>
			.uploadLabel {
				font-family:Arial;
				font-size:11px;
				font-weight:800;
				font-color:#666666;
			}
			</style>

");
	$form->execute();
 	
	// This line removes the navigation and everything else from the
 	// page, if you don't set it, you get what looks like a regular wiki
 	// page, with the body you defined above.
 	$wgOut->setArticleBodyOnly(true);

  }
  
  


}

 SpecialPage::addPage( new IFrameUpload );
 global $wgMessageCache,$wgOut;
 //$wgMessageCache->addMessage( 'commenteaction', 'comment action' );
 

Class UploadFormCustom extends UploadForm {

/**
	 * Displays the main upload form, optionally with a highlighted
	 * error message up at the top.
	 *
	 * @param string $msg as HTML
	 * @access private
	 */
	function mainUploadForm( $msg='' ) {
		global $wgOut, $wgUser;
		global $wgUseCopyrightUpload;

		$cols = intval($wgUser->getOption( 'cols' ));
		$ew = $wgUser->getOption( 'editwidth' );
		if ( $ew ) $ew = " style=\"width:100%\"";
		else $ew = '';

		if ( '' != $msg ) {
			$sub = wfMsgHtml( 'uploaderror' );
			$wgOut->addHTML( "<h2>{$sub}</h2>\n" .
			  "<span class='error'>{$msg}</span>\n" );
		}
	
		$sk = $wgUser->getSkin();


		$sourcefilename = "File"; //wfMsgHtml( 'sourcefilename' );
		$destfilename = "Title"; //wfMsgHtml( 'destfilename' );
		//$summary = wfMsgWikiHtml( 'fileuploadsummary' );

		//$licenses = new Licenses();
		//$license = wfMsgHtml( 'license' );
		//$nolicense = wfMsgHtml( 'nolicense' );
		//$licenseshtml = $licenses->getHtml();

		$ulb = wfMsgHtml( 'uploadbtn' );


		$titleObj = Title::makeTitle( NS_SPECIAL, 'IFrameUpload' );
		$action = $titleObj->escapeLocalURL();

		$encDestFile = htmlspecialchars( $this->mDestFile );

		$watchChecked = $wgUser->getOption( 'watchdefault' )
			? 'checked="checked"'
			: '';

		$wgOut->addHTML( "
	<form   method='post' enctype='multipart/form-data' action=\"$action\">
		<table border='0'>
		<tr>
			<td align='right' class='uploadLabel'><label for='wpUploadFile'>{$sourcefilename}:</label></td>
			<td align='left'>
				<input tabindex='1' class='createbox' type='file' name='wpUploadFile' id='wpUploadFile' " . ($this->mDestFile?"":"onchange='fillDestFilename()' ") . "size='40' />
			</td>
		</tr>
		<tr>
			<td align='right' class='uploadLabel'><label for='wpDestFile'>{$destfilename}:</label></td>
			<td align='left'>
				<input tabindex='2' class='createbox' type='text' name='wpDestFile' id='wpDestFile' size='40' value=\"$encDestFile\" />
			</td>
		</tr>
		<tr>
			<td align='right' class='uploadLabel' valign='top'><label for='wpUploadDescription'>{$summary}</label></td>
			<td align='left'>
				<textarea tabindex='3' class='createbox' name='wpUploadDescription' id='wpUploadDescription' rows='3' cols='{$cols}'{$ew}>" . htmlspecialchars( $this->mUploadDescription ) . "</textarea>
			</td>
		</tr>
		<tr>" );

		if ( $licenseshtml != '' ) {
			global $wgStylePath;
			$wgOut->addHTML( "
			<td align='right'><label for='wpLicense'>$license:</label></td>
			<td align='left'>
				<script type='text/javascript' src=\"$wgStylePath/common/upload.js\"></script>
				<select name='wpLicense' id='wpLicense' tabindex='4'
					onchange='licenseSelectorCheck()'>
					<option value=''>$nolicense</option>
					$licenseshtml
				</select>
			</td>
			</tr>
			<tr>
		");
		}

		if ( $wgUseCopyrightUpload ) {
			$filestatus = wfMsgHtml ( 'filestatus' );
			$copystatus =  htmlspecialchars( $this->mUploadCopyStatus );
			$filesource = wfMsgHtml ( 'filesource' );
			$uploadsource = htmlspecialchars( $this->mUploadSource );
			
			$wgOut->addHTML( "
			        <td align='right' nowrap='nowrap' class='uploadLabel'><label for='wpUploadCopyStatus'>$filestatus:</label></td>
			        <td><input tabindex='5' type='text' name='wpUploadCopyStatus' id='wpUploadCopyStatus' value=\"$copystatus\" size='40' /></td>
		        </tr>
			<tr>
		        	<td align='right'><label for='wpUploadCopyStatus' class='uploadLabel'>$filesource:</label></td>
			        <td><input tabindex='6' type='text' name='wpUploadSource' id='wpUploadCopyStatus' value=\"$uploadsource\" size='40' /></td>
			</tr>
		 
		");
		}


		$wgOut->addHtml( "
		 
	<tr>

	</tr>
	<tr>
		<td></td>
		<td align='left'><input tabindex='9' type='submit' name='wpUpload' value=\"{$ulb}\" /></td>
	</tr>


	</table>
	</form>" );
	}
	
		/* -------------------------------------------------------------- */

	/**
	 * Show some text and linkage on successful upload.
	 * @access private
	 */
	function showSuccess() {
		global $wgUser, $wgOut, $wgContLang, $wgTitle;
		$wgOut->addHTML( "<span style='font-family:Arial;font-size:18px;font-weight:800'>" . $this->mUploadSaveName . "</span><br><br>");
		$img = Image::newFromName($this->mUploadSaveName);
		$img_tag = '<img src="' . $img->getURL() . '" alt="" width="75"/>';
		
		$wgOut->addHTML( '<table cellpadding="0" cellspacing="0">
							<tr>
								<td>' . $img_tag  . '</td>
								<td width="15"></td>
								<script type="text/javascript">var img = \'' . $img->getURL()  . '\'</script>
								<td><input type="button" class="createsubmit" value="Insert into Page" onclick="window.parent.wikiwyg.current_mode.insert_image(img)" /><br>
								</td>
							</tr>
							</table>
							<br>
							<a href="index.php?title=Special:IFrameUpload" style="font-family:Arial"><b>Upload Another Image</b></a>
							');
		echo $wgOut->getHTML();
		exit();
	}
	
	/**
	 * There's something wrong with this file, not enough to reject it
	 * totally but we require manual intervention to save it for real.
	 * Stash it away, then present a form asking to confirm or cancel.
	 *
	 * @param string $warning as HTML
	 * @access private
	 */
	function uploadWarning( $warning ) {
		global $wgOut;
		global $wgUseCopyrightUpload;

		$this->mSessionKey = $this->stashSession();
		if( !$this->mSessionKey ) {
			# Couldn't save file; an error has been displayed so let's go.
			return;
		}

		$wgOut->addHTML( "<h2>" . wfMsgHtml( 'uploadwarning' ) . "</h2>\n" );
		$wgOut->addHTML( "<ul class='warning'>{$warning}</ul><br />\n" );

		$save = wfMsg( 'savefile' );
		$reupload = wfMsg( 'reupload' );
		$iw = wfMsg( 'ignorewarning' );
		$reup = wfMsg( 'reuploaddesc' );
		$titleObj = Title::makeTitle( NS_SPECIAL, 'IFrameUpload' );
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
		<input type='hidden' name='wpIgnoreWarning' value='1' />
		<input type='hidden' name='wpSessionKey' value=\"" . htmlspecialchars( $this->mSessionKey ) . "\" />
		<input type='hidden' name='wpUploadDescription' value=\"" . htmlspecialchars( $this->mUploadDescription ) . "\" />
		<input type='hidden' name='wpLicense' value=\"" . htmlspecialchars( $this->mLicense ) . "\" />
		<input type='hidden' name='wpDestFile' value=\"" . htmlspecialchars( $this->mDestFile ) . "\" />
		<input type='hidden' name='wpWatchthis' value=\"" . htmlspecialchars( intval( $this->mWatchthis ) ) . "\" />
	{$copyright}
	<table border='0'>
		<tr>
			<tr>
				<td align='right'>
					<input tabindex='2' type='submit' name='wpUpload' value='$save' />
				</td>
				<td align='left'>$iw</td>
			</tr>
			<tr>
				<td align='right'>
					<input tabindex='2' type='submit' name='wpReUpload' value='{$reupload}' />
				</td>
				<td align='left'>$reup</td>
			</tr>
		</tr>
	</table></form>\n" );
	}
	
	function uploadError( $error ) {
		global $wgOut;
		$wgOut->addHTML( "<h2>" . wfMsgHtml( 'uploadwarning' ) . "</h2>\n" );
		$wgOut->addHTML( "<span class='error'>{$error}</span>\n" );
		$wgOut->addHTML( "<br/><br/><input tabindex='2' type='submit' name='wpReUpload' value='" . wfMsgHtml( 'reupload' ) . "' />\n" );
	}
	
	
}

}


?>