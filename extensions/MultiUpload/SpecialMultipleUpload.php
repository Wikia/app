<?php
if ( ! defined( 'MEDIAWIKI' ) )
    die();

/**#@+
 * An extension that allows users to upload multiple files at once.
 *
 * @addtogroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:MultiUpload
 *
 * @author Travis Derouin <travis@wikihow.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

// change this parameter to limit the # of files one can upload
$wgMaxUploadFiles = isset( $wgMaxUploadFiles ) ? $wgMaxUploadFiles : 5;

$wgExtensionFunctions[] = 'wfMultipleUpload';

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'MultipleUpload',
	'author'         => 'Travis Derouin',
	'version'        => '1.0',
	'description'    => 'Allows users to upload several files at once.',
	'descriptionmsg' => 'multipleupload-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:MultiUpload',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['MultiUpload'] = $dir . 'SpecialMultipleUpload.i18n.php';
$wgExtensionAliasesFiles['MultiUpload'] = $dir . 'SpecialMultipleUpload.alias.php';

function wfMultipleUpload() {
	SpecialPage::AddPage(new SpecialPage('MultipleUpload'));

	global $wgMaxUploadFiles, $wgHooks;
	$wgMaxUploadFiles = intval( $wgMaxUploadFiles );
	wfLoadExtensionMessages( 'MultiUpload' );

    $wgHooks['MonoBookTemplateToolboxEnd'][]  = 'wfMultiUploadToolbox';
    $wgHooks['UploadComplete'][]  = 'wfMultiUploadShowSuccess';
    $wgHooks['SkinTemplateBuildNavUrlsNav_urlsAfterPermalink'][] = 'wfSpecialMultiUploadNav';

}

/**
 * Entry point
 */
function wfSpecialMultipleUpload() {
	global $wgRequest;
	$form = new MultipleUploadForm( $wgRequest );
	$form->execute();
}

/**
 *
 * @addtogroup SpecialPage
 */
class MultipleUploadForm extends UploadForm {

	// extra goodies
	// access private
	var  $mUploadTempNameArray, $mUploadSizeArray, $mOnameArray, $mUploadError, $mDestFileArray;
	var  $mUploadDescriptionArray;
	var  $mShowUploadForm, $mHasWarning, $mFileIndex;
	/**
	 * Constructor : initialise object
	 * Get data POSTed through the form and assign them to the object
	 * @param $request Data posted.
	 */
	function MultipleUploadForm( &$request ) {
		global $wgMaxUploadFiles;
		// call the parent constructor
		parent::UploadForm($request);

		//initialize
		$this->mUploadTempNameArray= $this->mUploadSizeArray= $this->mOnameArray= $this->mUploadError= $this->mDestFileArray = $this->mUploadDescriptionArray = array();
		$this->mShowUploadForm = true;
		$this->mFileIndex = 0;

		for ($x = 0; $x < $wgMaxUploadFiles; $x++) $this->mDestFileArray[$x] = $request->getText( "wpDestFile_$x" );

		if( !$request->wasPosted() ) {
			# GET requests just give the main form; no data except wpDestfile.
			return ;
		}

		for ($x = 0; $x < $wgMaxUploadFiles; $x++) {
			$this->mDestFile[$x] = $request->getText( "wpDestFile_$x" );
			$this->mUploadDescriptionArray[$x] = $request->getText( "wpUploadDescription_$x" );
		}
		$this->mSessionKey        = $request->getInt( 'wpSessionKey' );

		if( !empty( $this->mSessionKey )  ) {
			for ($x = 0; $x < $wgMaxUploadFiles; $x++) {
				//if (!isset($_SESSION["wsUploadData_$x"][$this->mSessionKey])) continue;
				$data = $_SESSION["wsUploadData_$x"][$this->mSessionKey];
				$this->mUploadTempNameArray[$x]   	= $data["mUploadTempName"];
				$this->mUploadSizeArray[$x]     = $data["mUploadSize"];
				$this->mOnameArray[$x]          = $data["mOname"];
			}
		} else {
			/**
			 *Check for a newly uploaded file.
			 */
			for ($x = 0; $x < $wgMaxUploadFiles; $x++) {
				$this->mUploadTempNameArray[$x] = $request->getFileTempName( "wpUploadFile_$x" );
				$this->mUploadSizeArray [$x]    = $request->getFileSize( "wpUploadFile_$x" );
				$this->mOnameArray[$x]          = $request->getFileName( "wpUploadFile_$x" );
				$this->mUploadErrorArray[$x]    = $request->getUploadError( "wpUploadFile_$x" );
				$this->mUploadDescriptionArray [$x] = $request->getVal("wpUploadDescription_$x");
			}
		}

	}

	/* -------------------------------------------------------------- */

	/**
	 * Really do the upload
	 * Checks are made in SpecialUpload::execute()
	 * @access private
	 */
	function processUpload() {
		global $wgMaxUploadFiles, $wgOut;

		$wgOut->addHTML("<table>");
		$this->mShowUploadForm = false;
		for ($x = 0; $x < $wgMaxUploadFiles; $x++) {
			$this->mFileIndex = $x;
			if (!isset ($this->mUploadTempNameArray[$x]) || $this->mUploadTempNameArray[$x] == null) continue;
   
            $this->mTempPath = $this->mUploadTempNameArray[$x]; 
            $this->mFileSize = $this->mUploadSizeArray[$x];
            $this->mSrcName = $this->mOnameArray[$x]; // for mw > 1.9
            $this->mRemoveTempFile = true;
            $this->mIgnoreWarning = true;

			$this->mUploadError = $this->mUploadErrorArray [$x];
			$this->mDesiredDestName = $this->mDestFileArray [$x];
			$this->mComment = $this->mUploadDescriptionArray [$x];
			$wgOut->addHTML("<tr><td>");
			parent::processUpload();
			$wgOut->addHTML("</td></tr>");
		}

		$wgOut->addHTML("</table>");
		$this->mShowUploadForm = false;
		$wgOut->redirect(''); // clear the redirect, we want to show a nice page of images
		$this->mShowUploadForm = true;
		if ($this->mHasWarning) {
			$this->showWarningOptions();
		}
	}

	/* -------------------------------------------------------------- */

	/**
	 * Show some text and linkage on successful upload.
	 * @access private
	 */
	function showSuccess() {
		global $wgUser, $wgOut, $wgContLang;

		$sk = $wgUser->getSkin();
		$ilink = $sk->makeMediaLink( $this->mUploadSaveName, Image::imageUrl( $this->mUploadSaveName ) );
		$dname = $wgContLang->getNsText( NS_IMAGE ) . ':'.$this->mUploadSaveName;
		$dlink = $sk->makeKnownLink( $dname, $dname );

		$wgOut->addWikiText( "[[$dname|left|thumb]]" );
		$text = wfMsgWikiHtml( 'fileuploaded', $ilink, $dlink );
		$wgOut->addHTML( $text );
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

		if (!$this->mHasWarning) {
			$titleObj = Title::makeTitle( NS_SPECIAL, 'MultipleUpload' );
			$action = $titleObj->escapeLocalURL( 'action=submit' );
			$wgOut->addHTML( "<h2>" . wfMsgHtml( 'uploadwarning' )  . "</h2>\n
				<form id='uploadwarning' method='post' enctype='multipart/form-data' action='$action'>");
		}
		$this->mHasWarning = true;
		$this->mSessionKey = $this->stashSession();
		if( !$this->mSessionKey ) {
			# Couldn't save file; an error has been displayed so let's go.
			return;
		}

		$wgOut->addHTML( "<b>{$this->mUploadSaveName}</b>\n" );
		$wgOut->addHTML( "<ul class='warning'>{$warning}</ul><br />\n" );
		$wgOut->addHTML(" <input type='hidden' name='wpUploadDescription_{$this->mFileIndex}' value=\"" . htmlspecialchars( $this->mUploadDescription ) . "\" />");

	}
	function stashSession() {
		$stash = $this->saveTempUploadedFile(
			$this->mUploadSaveName, $this->mUploadTempName );

		if( !$stash ) {
			# Couldn't save the file.
			return false;
		}

		if ($this->mSessionKey == null)
			$key = mt_rand( 0, 0x7fffffff );
		else
			$key = $this->mSessionKey;
		$_SESSION["wsUploadData_" . $this->mFileIndex][$key] = array(
			'mUploadTempName' => $stash,
			'mUploadSize'     => $this->mUploadSize,
			'mOname'          => $this->mOname
		);
		return $key;
	}

	function showWarningOptions() {
		global $wgOut, $wgMaxUploadFiles, $wgUseCopyrightUpload;
		$save = wfMsgHtml( 'multipleupload-saveallfiles' );
		$reupload = wfMsgHtml( 'reupload' );
		$iw = wfMsgWikiHtml( 'multipleupload-ignoreallwarnings' );
		$reup = wfMsgWikiHtml( 'reuploaddesc' );
		if ( $wgUseCopyrightUpload ) {
			$copyright =  "
	<input type='hidden' name='wpUploadCopyStatus' value=\"" . htmlspecialchars( $this->mUploadCopyStatus ) . "\" />
	<input type='hidden' name='wpUploadSource' value=\"" . htmlspecialchars( $this->mUploadSource ) . "\" />
	";
		} else {
			$copyright = "";
		}
		$wgOut->addHTML( "
		<input type='hidden' name='wpIgnoreWarning' value='1' />
		<input type='hidden' name='wpSessionKey' value=\"" . htmlspecialchars( $this->mSessionKey ) . "\" />
		<input type='hidden' name='wpLicense' value=\"" . htmlspecialchars( $this->mLicense ) . "\" />
		");
		for ($x = 0; $x < $wgMaxUploadFiles; $x++) {
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
	function mainUploadForm( $msg='' ) {
		global $wgOut, $wgUser;
		global $wgUseCopyrightUpload, $wgMaxUploadFiles;

		if ($msg == '' && !$this->mShowUploadForm) return;
		$cols = intval($wgUser->getOption( 'cols' ));
		$ew = $wgUser->getOption( 'editwidth' );
		if ( $ew ) $ew = " style=\"width:100%\"";
		else $ew = '';

		if ( '' != $msg ) {
			$wgOut->addHTML( "<b>{$this->mUploadSaveName}</b>\n<br />" );
			$sub = wfMsgHtml( 'multipleupload-addresswarnings' );
			$wgOut->addHTML( "<b>{$sub}</b><br /><span class='error'>{$msg}</span>\n" );
		}
		$wgOut->addHTML( '<div id="uploadtext">' );
		$wgOut->addWikiText( wfMsg('multipleupload-text', $wgMaxUploadFiles) );
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

		$wgOut->addHTML( "
<script type=\"text/javascript\">
function fillDestFilenameMulti(i) {
    if (!document.getElementById)
        return;
	var path = document.getElementById('wpUploadFile_' + i).value;
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
    var destFile = document.getElementById('wpDestFile_' + i);
    if (destFile)
        destFile.value = fname;
}
</script>

	<form id='upload' method='post' enctype='multipart/form-data' action=\"$action\">
		<table border='0'>
		<tr>
			<td align='left'><label for='wpUploadFile'><b>{$sourcefilename}</b></label></td>
			<td align='left'><label for='wpDestFile'><b>{$destfilename}</b></label></td>
			<td align='left' valign='middle'><b>{$summary}</b></td>
		</tr>");
	for ($i = 0; $i < $wgMaxUploadFiles; $i++) {
		$encDestFile = htmlspecialchars( $this->mDestFileArray[$i] );
		$wgOut->addHTML("
		<tr>
			<td align='left'>
				<input tabindex='1' type='file' name='wpUploadFile_$i' id='wpUploadFile_$i' " . ($this->mDestName?"":"onchange='fillDestFilenameMulti($i)' ") . "size='25' />
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
			global $wgStylePath;
			$wgOut->addHTML( "
			<td align='left' colspan=3>
			<label for='wpLicense'>$license:</label>
				<script type='text/javascript' src=\"$wgStylePath/common/upload.js\"></script>
				<select name='wpLicense' id='wpLicense' tabindex='4' style='font-size: xx-small;'
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
			        <td align='right' nowrap='nowrap'><label for='wpUploadCopyStatus'>$filestatus</label></td>
			        <td><input tabindex='5' type='text' name='wpUploadCopyStatus' id='wpUploadCopyStatus' value=\"$copystatus\" size='40' /></td>
		        </tr>
			<tr>
		        	<td align='right'><label for='wpUploadCopyStatus'>$filesource</label></td>
			        <td><input tabindex='6' type='text' name='wpUploadSource' id='wpUploadCopyStatus' value=\"$uploadsource\" size='40' /></td>
			</tr>
			<tr>
		");
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

	/* -------------------------------------------------------------- */

}

function wfSpecialMultiUploadNav( &$skintemplate, &$nav_urls, &$oldid, &$revid ) {
    global $wgUser;
    if ($wgUser->isAllowed( 'upload' ))
        $nav_urls['multiupload'] = array(
            'text' => wfMsg( 'multiupload_link' ),
            'href' => $skintemplate->makeSpecialUrl( 'MultipleUpload')
        );

    return true;
}
function wfMultiUploadToolbox( &$monobook ) {
    if ( isset( $monobook->data['nav_urls']['multiupload'] ) )  {
        if ( $monobook->data['nav_urls']['multiupload']['href'] == '' ) {
            ?><li id="t-ismultiupload"><?php echo $monobook->msg( 'multiupload-toolbox' ); ?></li><?php
        } else {
            ?><li id="t-multiupload"><?php
                ?><a href="<?php echo htmlspecialchars( $monobook->data['nav_urls']['multiupload']['href'] ) ?>"><?php
                    echo $monobook->msg( 'multiupload-toolbox' );
                ?></a><?php
            ?></li><?php
        }
    }
    return true;
}

function wfMultiUploadShowSuccess($uploadForm) {
    global $wgOut, $wgTitle;
    if ($wgTitle->getText() == "MultipleUpload") {
    	//debug_print_backtrace();
        $imgTitle = $uploadForm->mLocalFile->getTitle();
        $wgOut->addWikiText( "[[{$imgTitle->getFullText()}|left|thumb]]" );
        $text = wfMsgWikiHtml( 'multiupload-fileuploaded');
        $wgOut->addHTML( $text );
    }
    return true;
}
