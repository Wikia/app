<?php
if ( ! defined( 'MEDIAWIKI' ) )
    die();

/**#@+
 *  Provides a way of importing properly licensed photos from flickr
 *
 * @addtogroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:ImportFreeImages Documentation
 *
 *
 * @author Travis Derouin <travis@wikihow.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgIFI_FlickrAPIKey = '';
$wgIFI_CreditsTemplate = 'MediaWiki:Flickr'; // use this to format the image content with some key parameters
$wgIFI_GetOriginal = true; // import the original version of the photo
$wgIFI_PromptForFilename = true;  // prompt the user through javascript for the destination filename

$wgIFI_ResultsPerPage = 20;
$wgIFI_ResultsPerRow = 4;
// see the flickr api page for more information on these params
// for licnese info http://www.flickr.com/services/api/flickr.photos.licenses.getInfo.html
// default 4 is CC Attribution License
$wgIFI_FlickrLicense = "4,5";
$wgIFI_FlickrSort = "interestingness-desc";
$wgIFI_FlickrSearchBy = "tags"; // Can be tags or text. See http://www.flickr.com/services/api/flickr.photos.search.html
$wgIFI_AppendRandomNumber = true; /// append random # to destination filename
$wgIFI_ThumbType = "t"; // s for square t for thumbnail

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'ImportFreeImages',
	'version'        => preg_replace('/^.* (\d\d\d\d-\d\d-\d\d) .*$/', '\1', '$LastChangedDate$'), #just the date of the last change
	'author'         => 'Travis Derouin',
	'description'    => 'Provides a way of importing properly licensed photos from flickr.',
	'descriptionmsg' => 'importfreeimages-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:ImportFreeImages',
);

$wgExtensionMessagesFiles['ImportFreeImages'] = dirname(__FILE__) . '/ImportFreeImages.i18n.php';
$wgSpecialPages['ImportFreeImages'] = array( 'SpecialPage', 'ImportFreeImages' );
$wgSpecialPageGroups['ImportFreeImages'] = 'media';

# Note: we can't delay message loading currently, since we don't override SpecialPage::execute(),
# which calls SpecialPage::getDescription() before calling any of our functions.
# We need some way to autoload messages for getDescription()...
$wgExtensionFunctions[] = 'wfImportFreeImages';
function wfImportFreeImages() {
	wfLoadExtensionMessages( 'ImportFreeImages' );
}

// I wish I didn't have to copy paste most of

function wfIFI_uploadWarning($u, $warning) {
	global $wgOut;
	global $wgUseCopyrightUpload;

	$u->mSessionKey = $u->stashSession();
	if( !$u->mSessionKey ) {
		# Couldn't save file; an error has been displayed so let's go.
		return;
	}

	$wgOut->addHTML( "<h2>" . wfMsgHtml( 'uploadwarning' ) . "</h2>\n" );
	$wgOut->addHTML( "<ul class='warning'>{$warning}</ul><br />\n" );

	$save = wfMsgHtml( 'savefile' );
	$reupload = wfMsgHtml( 'reupload' );
	$iw = wfMsgWikiHtml( 'ignorewarning' );
	$reup = wfMsgWikiHtml( 'reuploaddesc' );
	$titleObj = Title::makeTitle( NS_SPECIAL, 'Upload' );
	$action = $titleObj->escapeLocalURL( 'action=submit' );
	if ( $wgUseCopyrightUpload )
	{
		$copyright =  "
    <input type='hidden' name='wpUploadCopyStatus' value=\"" . htmlspecialchars( $u->mUploadCopyStatus ) . "\" />
    <input type='hidden' name='wpUploadSource' value=\"" . htmlspecialchars( $u->mUploadSource ) . "\" />
    ";
	} else {
		$copyright = "";
	}

	$wgOut->addHTML( "
    <form id='uploadwarning' method='post' enctype='multipart/form-data' action='$action'>
        <input type='hidden' name='wpIgnoreWarning' value='1' />
        <input type='hidden' name='wpSessionKey' value=\"" . htmlspecialchars( $u->mSessionKey ) . "\" />
        <input type='hidden' name='wpUploadDescription' value=\"" . htmlspecialchars( $u->mUploadDescription ) . "\" />
        <input type='hidden' name='wpLicense' value=\"" . htmlspecialchars( $u->mLicense ) . "\" />
        <input type='hidden' name='wpDestFile' value=\"" . htmlspecialchars( $u->mDestFile ) . "\" />
        <input type='hidden' name='wpWatchu' value=\"" . htmlspecialchars( intval( $u->mWatchu ) ) . "\" />
    {$copyright}
    <table border='0'>
        <tr>
            <tr>
                <td align='right'>
                    <input tabindex='2' type='submit' name='wpUpload' value=\"$save\" />
                </td>
                <td align='left'>$iw</td>
            </tr>
        </tr>
    </table></form>\n" . wfMsg('importfreeimages_returntoform',  $_SERVER["HTTP_REFERER"]) );
//  $_SERVER["HTTP_REFERER"]; -- javascript.back wasn't working for some reason... hmph.

}

/* Return values:
 *  true: Don't show query form, because
 *          either everything worked
 *          or something is so wrong that it makes no sense to continue
 *  false: Temporary error (e.g. proposed pagename is protected against creation),
 *         show query again so user has a chance to retry.
 */
function wfIFI_handleUpload( $f, $import ) {
	global $wgRequest, $wgUser, $wgOut, $wgTmpDirectory;
	global $wgIFI_GetOriginal, $wgIFI_CreditsTemplate, $wgIFI_AppendRandomNumber;
	# Check token, to preven Cross Site Request Forgeries
	$token = $wgRequest->getVal( 'token' );
	if( !$wgUser->matchEditToken( $token ) ) {
		$wgOut->addWikitext(wfMsg('sessionfailure'));
		return false;
	}

	$id     = $wgRequest->getVal( 'id' );
	$ititle = $wgRequest->getVal( 'ititle' );
	$owner  = $wgRequest->getVal( 'owner' );
	$name   = $wgRequest->getVal( 'name' );

	if ($wgIFI_GetOriginal) {
		// get URL of original :1

		$sizes = $f->photos_getSizes( $id );
		$original = '';
		foreach ($sizes as $size) {
			if ($size['label'] == 'Original') {
				$original = $size['source'];
				$import = $size['source'];
			} else if ($size['label'] == 'Large') {
				$large = $size['source'];
			}
		}
		//somtimes Large is returned but no Original!
		if ($original == '' && $large != '')
			$import = $large;
	}

	if (!preg_match('/^http:\/\/farm[0-9]+\.static\.flickr\.com\/.*\.(jpg|gif|png)$/', $import, $matches)) {
		$wgOut->showErrorPage('error', 'importfreeimages_invalidurl', array( wfEscapeWikiText( $import ) ) );
		return true;
	}
	$fileext = '.' . $matches[1];

	// store the contents of the file

        $pageContents = Http::get( $import );
	$tempname = tempnam( $wgTmpDirectory, 'flickr' );
	$r = fopen( $tempname, 'wb' );
	if( $r === FALSE ) {
		# Could not open temporary file to write in
		$wgOut->errorPage( 'upload-file-error', 'upload-file-error-text' );
		return true;
	}
	$size = fwrite( $r, $pageContents );
	fclose( $r );

	$info = $f->photos_getInfo( $id );
	$name_wiki = wfEscapeWikiText( $name );
	if (!empty($wgIFI_CreditsTemplate)) {
		$owner_wiki = wfEscapeWikiText( $owner );
		$id_wiki    = wfEscapeWikiText( $id );
		$caption = "{{" . $wgIFI_CreditsTemplate . intval( $info['license'] ) . "|1=$id_wiki|2=$owner_wiki|3=$name_wiki}}";
	} else {
		// TODO: this is totally wrong: The whole message should be configurable, we shouldn't include arbitrary templates
		// additionally, the license information is not correct (we are not guaranteed to get "CC by 2.0" images only)
		$caption = wfMsgForContent('importfreeimages_filefromflickr', $ititle, "http://www.flickr.com/people/" . urlencode($owner) . " " . $name_wiki) . " <nowiki>$import</nowiki>. {{CC by 2.0}} ";
		$caption = trim($caption);
	}

	if (!class_exists("UploadForm"))
		require_once('includes/SpecialUpload.php');
	$u = new UploadForm($wgRequest);
	// TODO: we should use FauxRequest here instead of accessing member variables.
	// But FauxRequest doesn't yet allow us to pass files around
	$u->mTempPath = $tempname;
	$u->mFileSize = $size;
	$u->mComment = $caption;
	$u->mRemoveTempFile = true;
	$u->mIgnoreWarning = true;

	$filename = $ititle . ($wgIFI_AppendRandomNumber ? "-" . rand(0, 9999) : "") . $fileext;
	$filename = preg_replace('/ +/', ' ', $filename);
	/**
	 * Filter out illegal characters, and try to make a legible name
	 * out of it. We'll strip some silently that Title would die on.
	 * This is taken from SpecialUpload::internalProcessUploads()
	 */
	$filename = preg_replace ( "/[^".Title::legalChars()."]|:/", '-', $filename );
	$nt = Title::makeTitleSafe( NS_IMAGE, $filename );
	if( is_null( $nt ) ) {
		$wgOut->showErrorPage( 'error', 'illegalfilename', array( wfEscapeWikiText( $filename ) ) );
		return false;
	}
	$u->mSrcName = $filename;

	if( $nt->getArticleID() > 0 ) {
		$sk = $wgUser->getSkin();
		$dlink = $sk->makeKnownLinkObj( $t );
		$warning = '<li>'.wfMsgExt( 'fileexists', '', $dlink ).'</li>';

		// use our own upload warning as we dont have a 'reupload' feature
		wfIFI_uploadWarning($u, $warning);
		return true;
	} elseif( !$nt->userCan( 'create' ) ) {
		$wgOut->showPermissionsErrorPage( $nt->getUserPermissionsErrors( 'create', $wgUser ) );
		return false;
	} else {
		$u->execute();
		return true;
	}
}

function wfSpecialImportFreeImages( $par )
{
	global $wgUser, $wgOut, $wgRequest, $wgIFI_FlickrAPIKey, $wgEnableUploads;
	global $wgIFI_ResultsPerPage, $wgIFI_FlickrSort, $wgIFI_FlickrLicense, $wgIFI_ResultsPerRow;
	global $wgIFI_PromptForFilename, $wgIFI_FlickrSearchBy, $wgIFI_ThumbType;
	global $wgHTTPProxy;
        wfSetupSession();
	require_once("phpFlickr-2.2.0/phpFlickr.php");

	$importPage = Title::makeTitle(NS_SPECIAL, "ImportFreeImages");

	if (empty($wgIFI_FlickrAPIKey)) {
		// error - need to set $wgIFI_FlickrAPIKey to use this extension
		$wgOut->errorpage('error', 'importfreeimages_noapikey');
		return;
	}
	$f = new phpFlickr($wgIFI_FlickrAPIKey);
        $proxyArr = explode(':', $wgHTTPProxy);
        $f->setProxy($proxyArr[0], $proxyArr[1]);

	# a lot of this code is duplicated from SpecialUpload, should be refactored
	# Check uploading enabled
	if( !$wgEnableUploads ) {
		$wgOut->showErrorPage( 'uploaddisabled', 'uploaddisabledtext' );
		return;
	}

	if( !$wgUser->isAllowed( 'upload' ) ) {
		if( !$wgUser->isLoggedIn() ) {
			$wgOut->showErrorPage( 'uploadnologin', 'uploadnologintext' );
		} else {
			$wgOut->permissionRequired( 'upload' );
		}
		return;
	}

	# Check blocks
	if( $wgUser->isBlocked() ) {
		$wgOut->blockedPage();
		return;
	}

	if( wfReadOnly() ) {
		$wgOut->readOnlyPage();
		return;
	}

	$import = $wgRequest->getVal( 'url', '' );

        if( $wgRequest->wasPosted() && $import != '' ) {
		if( wfIFI_handleUpload( $f, $import ) )
			return;
		$wgOut->addHTML('<hr/>');
	}

	$q = $wgRequest->getText( 'q' );
	$searchType = $wgRequest->getVal('searchtype');

        if (!in_array($searchType, array('any', 'all'))) {
		$searchType = 'all';
	}

	$wgOut->addHTML(wfMsg ('importfreeimages_description') . '<br /><br />
		<form method="get" action="' . $importPage->escapeFullURL() . '">
			<table>
			<tr>
				<td>' . wfMsg('search') . ':</td>
				<td><input type="text" name="q" value="' . htmlspecialchars($q) . '"/><input type="submit" value="' . wfMsg('search') . '"/></td>
			</tr><tr>
				<td>' . wfMsg('importfreeimages-searchtype-name') . '</td>
				<td>
					<select name="searchtype">
						<option value="all"' . ($searchType == 'all' ? ' selected="selected"' : '') . '>' . wfMsg('importfreeimages-searchtype-all') . '</option>
						<option value="any"' . ($searchType == 'any' ? ' selected="selected"' : '') . '>' . wfMsg('importfreeimages-searchtype-any') . '</option>
					</select>
				</td>
			</tr>
			</table>
		</form>');

	if ($q != '') {

		$page = $wgRequest->getInt( 'p', 1 );
		// TODO: get the right licenses
		$photos = $f->photos_search(array(
				$wgIFI_FlickrSearchBy => $q,
				"tag_mode" => $searchType,
				"page" => $page,
				"per_page" => $wgIFI_ResultsPerPage,
				"license" => $wgIFI_FlickrLicense,
				"sort" => $wgIFI_FlickrSort  ));
                 
		// $wgOut->addHTML('<pre>'.htmlspecialchars(print_r($photos, TRUE)).'</pre>');
		if ($photos == null 
                        || !is_array($photos)
                        || sizeof($photos) == 0
                        || !isset($photos['photo'])
                        || !is_array($photos['photo'])
                        || sizeof($photos['photo']) == 0 )
                {
			$wgOut->addHTML( wfMsg( "importfreeimages_nophotosfound", htmlspecialchars( $q ) ) );
			return;
		}

		$sk = $wgUser->getSkin();
		$wgOut->addHTML("
			<form method='post' name='uploadphotoform' action='" . $importPage->escapeFullURL() . "'>
				<input type='hidden' name='url' value=''/>
				<input type='hidden' name='id' value=''/>
				<input type='hidden' name='action' value='submit'/>
				<input type='hidden' name='owner' value=''/>
				<input type='hidden' name='name' value=''/>
				<input type='hidden' name='ititle' value=''/>
				<input type='hidden' name='token' value='" . $wgUser->editToken() . "'/>
				<input type='hidden' name='q' value='" . htmlspecialchars($q) . "'/>

				<script type='text/javascript'>
				function s2 (url, id, owner, name, ititle) {
					document.uploadphotoform.url.value = url;
					document.uploadphotoform.id.value = id;
					document.uploadphotoform.owner.value = owner;
					document.uploadphotoform.name.value = name;
					document.uploadphotoform.ititle.value = ititle;
					if (" . ($wgIFI_PromptForFilename ? "true" : "false") . ") {
						var filetitle = prompt(" . Xml::encodeJsVar( wfMsg('importfreeimages_promptuserforfilename') ) . ", ititle);
						if (filetitle === null) {	//user clicked 'cancel'
							return false;
						}
						document.uploadphotoform.ititle.value = filetitle == '' ? ititle : filetitle;
					}
					document.uploadphotoform.submit();
				}
			</script>
			<table cellpadding='4'>
		");
		$ownermsg = wfMsg('importfreeimages_owner');
		$importmsg = wfMsg('importfreeimages_importthis');
		$i = 0;
		foreach ($photos['photo'] as $photo) {

			//patch from author sent by e-mail
			if ($i % $wgIFI_ResultsPerRow == 0) $wgOut->addHTML("<tr>");
			$owner = $f->people_getInfo($photo['owner']);
			$wgOut->addHTML( "<td align='center' style='padding-top: 15px; border-bottom: 1px solid #ccc; font-size:80%'>");
			$wgOut->addHTML( "<a href='http://www.flickr.com/photos/" . $photo['owner'] . "/" . $photo['id'] . "/'>" );
			$wgOut->addHTML( $photo['title'] );
			$wgOut->addHTML( "</a><br/>".wfMsg('importfreeimages_owner').": " );
			$wgOut->addHTML( "<a href='http://www.flickr.com/people/" . $photo['owner'] . "/'>") ;
			$wgOut->addHTML( $owner['username'] );
			$wgOut->addHTML( "</a><br/>" );
			//$wgOut->addHTML( "<img  src=http://static.flickr.com/" . $photo['server'] . "/" . $photo['id'] . "_" . $photo['secret'] . "." . "jpg>" );
			$url="http://farm{$photo['farm']}.static.flickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}.jpg";
			$wgOut->addHTML( "<img src=\"http://farm{$photo['farm']}.static.flickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_{$wgIFI_ThumbType}.jpg\" alt=\"" . htmlspecialchars($photo['title']) . "\"/>" );
							
			$wgOut->addHTML( "<br/>(<a href='#' onclick=\"s2('$url', '{$photo['id']}','{$photo['owner']}', '" .
				addslashes($owner['username']  ) . "', '" . addslashes($photo['title']) . "'); return false;\">" .
				wfMsg('importfreeimages_importthis') . "</a>)\n</td>" );
			if ($i % $wgIFI_ResultsPerRow == ($wgIFI_ResultsPerRow - 1) ) $wgOut->addHTML("</tr>");
			$i++;
		}

		$wgOut->addHTML("</table></form>");
		if( $wgIFI_ResultsPerPage * $page < $photos['total'] ) {
			$page++;
			$wgOut->addHTML("<br />" . $sk->makeLinkObj($importPage, wfMsg('importfreeimages_next', $wgIFI_ResultsPerPage), "p=$page&q=" . urlencode($q) ) );
		}
	}
}
