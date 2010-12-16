<?php
// Sanity check - check for MediaWiki environment...
if( !defined( 'MEDIAWIKI' ) )
	die( "This is an extension to the MediaWiki package and cannot be run standalone." );

class MultipleUpload extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'MultipleUpload'/*class*/, 'upload'/*restriction*/ );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;
		wfLoadExtensionMessages( 'MultiUpload' );
		$this->setHeaders();

		# Check permissions
		if( !$wgUser->isAllowed( 'upload' ) ) {
			$wgOut->permissionRequired( 'upload' );
			return;
		}

		# Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		# If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		$form = new MultipleUploadForm( $wgRequest );
		$form->execute();

		$form->cleanupTempFile();
	}
}

/**
 * Main class
 * @ingroup SpecialPage
 */
class MultipleUploadForm extends UploadForm {

	// extra goodies
	// access private
	var $mUploadTempNameArray, $mUploadSizeArray, $mOnameArray, $mUploadError, $mDestFileArray, $mFilePropsArray;
	var $mUploadDescriptionArray;
	var $mShowUploadForm, $mHasWarning, $mFileIndex;
	var $mWarnings = 0;
	var $mSessionKey = null;

	/**
	 * Constructor : initialise object
	 * Get data POSTed through the form and assign them to the object
	 * @param $request Data posted.
	 */
	function MultipleUploadForm( &$request ) {
		global $wgMaxUploadFiles;
		// call the parent constructor
		parent::UploadForm($request);

		// initialize
		$this->mUploadTempNameArray = $this->mUploadSizeArray = $this->mOnameArray = $this->mUploadError = $this->mDestFileArray = $this->mUploadDescriptionArray = array();
		$this->mmFilePropsArray = array();
		$this->mShowUploadForm = true;
		$this->mFileIndex = 0;

		for( $x = 0; $x < $wgMaxUploadFiles; $x++ ) $this->mDestFileArray[$x] = $request->getText( "wpDestFile_$x" );

		if( !$request->wasPosted() ) {
			# GET requests just give the main form; no data except wpDestfile.
			return;
		}

		for( $x = 0; $x < $wgMaxUploadFiles; $x++ ) {
			$this->mDestFile[$x] = $request->getText( "wpDestFile_$x" );
			$this->mUploadDescriptionArray[$x] = $request->getText( "wpUploadDescription_$x" );
		}
		$this->mSessionKey		= $request->getInt( 'wpSessionKey' );

		if( !empty( $this->mSessionKey )  ) {
			for( $x = 0; $x < $wgMaxUploadFiles; $x++ ) {
				if( !isset( $_SESSION["wsUploadData_$x"][$this->mSessionKey] ) ) continue;
				$data = $_SESSION["wsUploadData_$x"][$this->mSessionKey];
				$this->mUploadTempNameArray[$x]   	= $data['mTempPath'];
				$this->mUploadSizeArray[$x]	 		= $data['mFileSize'];
				$this->mOnameArray[$x]		  		= $data['mSrcName'];
				$this->mFileProps[$x]				= $data['mFileProps'];
				$this->mCurlError        = 0 /*UPLOAD_ERR_OK*/;
				$this->mStashed          = true;
				$this->mRemoveTempFile   = false;
			}
		} else {
			/**
			 *Check for a newly uploaded file.
			 */
			for( $x = 0; $x < $wgMaxUploadFiles; $x++ ) {
				$this->mUploadTempNameArray[$x] = $request->getFileTempName( "wpUploadFile_$x" );
				$this->mUploadSizeArray [$x]	= $request->getFileSize( "wpUploadFile_$x" );
				$this->mOnameArray[$x]		  	= $request->getFileName( "wpUploadFile_$x" );
				$this->mUploadErrorArray[$x]	= $request->getUploadError( "wpUploadFile_$x" );
				$this->mUploadDescriptionArray[$x] = $request->getVal( "wpUploadDescription_$x" );
			}
		}

	}

	/**
	 * Really do the upload
	 * Checks are made in SpecialUpload::execute()
	 * @access private
	 */
	function processUpload() {
		global $wgMaxUploadFiles, $wgOut, $wgRequest;

		$images = 0;
		$wgOut->addHTML( '<table>' );
		$this->mShowUploadForm = false;

		$titleObj = SpecialPage::getTitleFor( 'MultipleUpload' );
		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'method' => 'post', 'action' => $titleObj->getLocalURL( 'action=submit' ),
			 'enctype' => 'multipart/form-data', 'id' => 'uploadwarning' ) ) . "\n"
		);

		$this->mLicense           = $wgRequest->getText( 'wpLicense' );

		for( $x = 0; $x < $wgMaxUploadFiles; $x++ ) {
			$this->mFileIndex = $x;
			if( !isset( $this->mUploadTempNameArray[$x] ) || $this->mUploadTempNameArray[$x] == null ) {
				continue;
			}

			$images++;
			$this->mTempPath 		= $this->mUploadTempNameArray[$x]; 
			$this->mFileSize 		= $this->mUploadSizeArray[$x];
			$this->mSrcName 		= $this->mOnameArray[$x]; // for mw > 1.9
			$this->mRemoveTempFile 	= true; 
			$this->mIgnoreWarning 	= $wgRequest->getCheck( 'wpIgnoreWarning' );

			$this->mUploadError 	= $this->mUploadErrorArray[$x];
			$this->mDesiredDestName = $this->mDestFileArray[$x];
			$this->mComment 		= $this->mUploadDescriptionArray[$x];
			$this->mFileProps		= $this->mFileProps[$x];

			$wgOut->addHTML( '<tr><td>' );
			parent::processUpload();
			$wgOut->addHTML( '</td></tr>' );
		}

		$wgOut->addHTML( '</table>' );
		// Display a form again with a warning if we gave no files, instead of a blank screen
		if( 0 == $images ) {
			$this->mShowUploadForm = true;
			$this->mUploadSaveName = wfMsg( 'multiupload-blank' );
			$this->mainUploadForm( wfMsg( 'multiupload-no-files' ) );
		} else {
			$this->mShowUploadForm = false;
			$wgOut->redirect( '' ); // clear the redirect, we want to show a nice page of images
			$this->mShowUploadForm = true;
			if( $this->mHasWarning ) {
				$this->showWarningOptions();
			}
		}
		$wgOut->addHTML( Xml::closeElement( 'form' ) . "\n" );
	}

	/**
	 * Show some text and linkage on successful upload.
	 * @access private
	 */
	function showSuccess() {
		global $wgUser, $wgOut;
		$t = $this->mLocalFile->getTitle();
		$wgOut->addHTML( '<h2>' . wfMsg( 'multiupload-fileuploaded' ) . '</h2>' );
		$wgOut->addHTML( $wgUser->getSkin()->makeThumbLink2( $t, $this->mLocalFile, array( 'caption' => $t->getText() ) ) );
	}

	/**
	 * @param string $error as HTML
	 * @access private
	 */
	function uploadError( $error ) {
		global $wgOut;
		$wgOut->addHTML( "<b>{$this->mUploadSaveName}</b>\n" );
		$wgOut->addHTML( "<span class='error'>{$error}</span>\n" );
	}

	function showWarningOptions() {
		global $wgOut, $wgMaxUploadFiles, $wgUseCopyrightUpload;

		$save = wfMsgHtml( 'multipleupload-saveallfiles' );
		$reupload = wfMsgHtml( 'reupload' );
		$iw = wfMsgWikiHtml( 'multipleupload-ignoreallwarnings' );
		$reup = wfMsgWikiHtml( 'reuploaddesc' );

		if ( $wgUseCopyrightUpload ) {
			$copyright =  '
	<input type="hidden" name="wpUploadCopyStatus" value="' . htmlspecialchars( $this->mUploadCopyStatus ) . '" />
	<input type="hidden" name="wpUploadSource" value="' . htmlspecialchars( $this->mUploadSource ) . '" />';
		} else {
			$copyright = '';
		}

		$wgOut->addHTML( '<input type="hidden" name="wpIgnoreWarning" value="1" />
		<input type="hidden" name="wpSessionKey" value="' . htmlspecialchars( $this->mSessionKey ) . '" />
		<input type="hidden" name="wpLicense" value="' . htmlspecialchars( $this->mLicense ) . '" />');

		for( $x = 0; $x < $wgMaxUploadFiles; $x++ ) {
			$wgOut->addHTML("<input type='hidden' name='wpDestFile_$x' value=\"" . htmlspecialchars( $this->mDestFileArray[$x] ) . "\" />");
		}

		$wgOut->addHTML("<input type='hidden' name='wpWatchthis' value=\"" . htmlspecialchars( intval( $this->mWatchthis ) ) . "\" />
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

	/**
	 * Displays the main upload form, optionally with a highlighted
	 * error message up at the top.
	 *
	 * @param string $msg as HTML
	 * @access private
	 */
	function mainUploadForm( $msg = '' ) {
		global $wgOut, $wgUser, $wgScriptPath, $wgUseCopyrightUpload, $wgMaxUploadFiles;

		if( $msg == '' && !$this->mShowUploadForm ) return;
		$cols = intval( $wgUser->getOption( 'cols' ) );
		$ew = $wgUser->getOption( 'editwidth' );
		if ( $ew ) $ew = " style=\"width:100%\"";
		else $ew = '';

		if ( '' != $msg ) {
			$wgOut->addHTML( "<b>{$this->mUploadSaveName}</b>\n<br />" );
			$sub = wfMsgHtml( 'multipleupload-addresswarnings' );
			$wgOut->addHTML( "<b>{$sub}</b><br /><span class='error'>{$msg}</span>\n" );
		}
		$wgOut->addHTML( '<div id="uploadtext">' );
		$wgOut->addWikiMsg('multipleupload-text', $wgMaxUploadFiles);
		$wgOut->addHTML( '</div>' );
		$sk = $wgUser->getSkin();

		$sourcefilename = wfMsgHtml( 'sourcefilename' );
		$destfilename = wfMsgHtml( 'destfilename' );
		$summary = wfMsg( 'fileuploadsummary' );
		$licenses = new Licenses();
		$license = wfMsgHtml( 'license' );
		$nolicense = wfMsgHtml( 'nolicense' );
		$licenseshtml = $licenses->getHtml();
		$ulb = wfMsgHtml( 'uploadbtn' );

		$titleObj = Title::makeTitle( NS_SPECIAL, 'MultipleUpload' );
		$action = $titleObj->escapeLocalURL();

		$watchChecked = $wgUser->getOption( 'watchdefault' )
			? 'checked="checked"'
			: '';

		$wgOut->addScriptFile( $wgScriptPath . '/extensions/MultiUpload/multiupload.js' );
		$wgOut->addHTML( "
	<form id='upload' method='post' enctype='multipart/form-data' action=\"$action\">
		<table border='0' width='90%'>
		<tr>
			<td align='left'><label for='wpUploadFile'><b>{$sourcefilename}</b></label></td>
			<td align='left'><label for='wpDestFile'><b>{$destfilename}</b></label></td>
			<td align='left' valign='middle'><b>{$summary}</b></td>
		</tr>");
	for( $i = 0; $i < $wgMaxUploadFiles; $i++ ) {
		$encDestFile = htmlspecialchars( $this->mDestFileArray[$i] );
		$wgOut->addHTML("
		<tr>
			<td align='left'>
				<input tabindex='1' type='file' name='wpUploadFile_$i' id='wpUploadFile_$i' " . ( $this->mDestName ? "" : "onchange='fillDestFilenameMulti($i)' " ) . "size='25' />
			</td>
			<td align='left'>
				<input tabindex='2' type='text' name='wpDestFile_$i' id='wpDestFile_$i' size='25' value=\"$encDestFile\" />
			</td>
			<td align='left'>
				<input tabindex='3' name='wpUploadDescription_$i' id='wpUploadDescription' value=\"". htmlspecialchars( $this->mComment ) . "\" size=25>
			</td>
		</tr>
		<tr>" );
	}

		if ( $licenseshtml != '' ) {
			global $wgAjaxLicensePreview, $wgJsMimeType;
			$wgOut->addScriptFile( 'upload.js' );
			// This is one nasty hack...but necessary to make upload.js not bitch if the user actually touches the "Licensing" dropdown menu instead of just admiring it from a distance.
			$wgOut->addInlineScript( 'var wgAjaxLicensePreview = "'.$wgAjaxLicensePreview.'";' );
			$wgOut->addHTML( "
			<td align='left' colspan='3'>
			<label for='wpLicense'>$license</label>
				<select name='wpLicense' id='wpLicense' tabindex='4' style='font-size: xx-small;'
					onchange='licenseSelectorCheck()'>
					<option value=''>$nolicense</option>
					$licenseshtml
				</select>
			</td>
			</tr>
			<tr>");
			// So that the license previews will show up on the page
			$wgOut->addHTML( '
					<td id="mw-license-preview" colspan="3"></td>
				</tr>
				<tr>' );
		}

		if ( $wgUseCopyrightUpload ) {
			global $wgRequest;
			$filestatus = wfMsgHtml( 'filestatus' );
			$copystatus = htmlspecialchars( $this->mUploadCopyStatus );
			$filesource = wfMsgHtml( 'filesource' );
			$uploadsource = htmlspecialchars( $this->mUploadSource );

			$wgOut->addHTML( "
					<td align='right' nowrap='nowrap'><label for='wpUploadCopyStatus'>$filestatus</label></td>
					<td><input tabindex='5' type='text' name='wpUploadCopyStatus' id='wpUploadCopyStatus' value=\"$copystatus\" size='40' /></td>
				</tr>
			<tr>
					<td align='right'><label for='wpUploadCopyStatus'>$filesource</label></td>
					<td><input tabindex='6' type='text' name='wpUploadSource' id='wpUploadCopyStatus' value=\"$uploadsource\" size='40' /></td>
			</tr>
			<tr>" );
			// For license selector
			$wgOut->addHTML( Xml::hidden( 'wpLicense', $wgRequest->getText( 'wpLicense' ) ) . "\n" );
		}

		$wgOut->addHTML( "
		<td>
 			<input tabindex='7' type='checkbox' name='wpWatchthis' id='wpWatchthis' $watchChecked value='true' />
			<label for='wpWatchthis'>" . wfMsgHtml( 'watchthis' ) . "</label>
			<input tabindex='8' type='checkbox' name='wpIgnoreWarning' id='wpIgnoreWarning' value='true' />
			<label for='wpIgnoreWarning'>" . wfMsgHtml( 'ignorewarnings' ) . "</label>
		</td>
	</tr>
	<tr>

	</tr>
	<tr>
		<td align='left'><input tabindex='9' type='submit' name='wpUpload' value=\"{$ulb}\" /></td>
	</tr>

	</table>
	</form>" );
	}

	/**
	 * Override uploadWarning so we can put multiple warnings on the same page
	 * @param $warning String: warning as HTML
	 * @access private
	 */
	function uploadWarning( $warning ) {
		global $wgOut, $wgUseCopyrightUpload;

		$this->mHasWarning = true;	
		$this->mSessionKey = $this->stashSession();
		if( !$this->mSessionKey ) {
			# Couldn't save file; an error has been displayed so let's go.
			return;
		}

		$wgOut->addHTML( '<h2>' . wfMsgHtml( 'uploadwarning' ) . "</h2>\n" );
		$wgOut->addHTML( '<ul class="warning">' . $warning . "</ul>\n" );

		$titleObj = SpecialPage::getTitleFor( 'Upload' );

		if ( $wgUseCopyrightUpload ) {
			$copyright = Xml::hidden( 'wpUploadCopyStatus', $this->mCopyrightStatus ) . "\n" .
					Xml::hidden( 'wpUploadSource', $this->mCopyrightSource ) . "\n";
		} else {
			$copyright = '';
		}

		$wgOut->addHTML(
			Xml::hidden( 'wpIgnoreWarning', '1' ) . "\n" .
			Xml::hidden( 'wpUploadDescription_' . $this->mFileIndex, $this->mComment ) . "\n" .
			Xml::hidden( 'wpLicense', $this->mLicense ) . "\n" .
			Xml::hidden( 'wpDestFile_' . $this->mFileIndex, $this->mDesiredDestName ) . "\n" .
			Xml::hidden( 'wpWatchthis', $this->mWatchthis ) . "\n" .
			"{$copyright}<br />" .
			Xml::check( 'wpUpload_' . $this->mSessionKey, array( 'name' => 'wpUpload', 'id' => 'wpUpload', 'checked' => 'checked' ) ) . ' ' .
			Xml::label( wfMsg( 'ignorewarning' ), 'wpUpload_' . $this->mSessionKey ) . '<br />' .
			Xml::check( 'wpReUpload_' . $this->mSessionKey ) . 
			Xml::label( wfMsg( 'reuploaddesc' ), 'wpUpload_' . $this->mSessionKey )
		);
	}

	function stashSession() {
		$stash = $this->saveTempUploadedFile( $this->mDestName, $this->mTempPath );

		if( !$stash ) {
			# Couldn't save the file.
			return false;
		}

		if( $this->mSessionKey == null ) {
			$this->mSessionKey = mt_rand( 0, 0x7fffffff );
		}
		$_SESSION['wsUploadData_' . $this->mFileIndex][$this->mSessionKey] = array(
			'mTempPath'       => $stash,
			'mFileSize'       => $this->mFileSize,
			'mSrcName'        => $this->mSrcName,
			'mFileProps'      => $this->mFileProps,
			'version'         => self::SESSION_VERSION,
		);
		return $this->mSessionKey;
	}

	/**
	 * If we've modified the upload file we need to manually remove it
	 * on exit to clean up.
	 * @access private
	 */ 
	function cleanupTempFile() {
		global $wgMaxUploadFiles;
		for( $x = 0; $x < $wgMaxUploadFiles; $x++ ) {
			$this->mTempPath = $this->mTempPathArray[$x];
			parent::cleanupTempFile();
		}
	}

}