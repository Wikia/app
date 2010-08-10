<?php
// Sanity check - check for MediaWiki environment...
if( !defined( 'MEDIAWIKI' ) ) {
	die( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
}

class ImportFreeImages extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'ImportFreeImages'/*class*/, 'upload'/*restriction*/ );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgUser, $wgOut, $wgRequest, $wgIFI_FlickrAPIKey, $wgEnableUploads;
		global $wgIFI_ResultsPerPage, $wgIFI_FlickrSort, $wgIFI_FlickrLicense, $wgIFI_ResultsPerRow;
		global $wgIFI_PromptForFilename, $wgIFI_FlickrSearchBy, $wgIFI_ThumbType;
                global $wgHTTPProxy;
                
		wfLoadExtensionMessages( 'ImportFreeImages' );

		wfSetupSession();
		require_once("phpFlickr-2.2.0/phpFlickr.php");

		$importPage = SpecialPage::getTitleFor( 'ImportFreeImages' );

		if( empty( $wgIFI_FlickrAPIKey ) ) {
			// error - need to set $wgIFI_FlickrAPIKey to use this extension
			$wgOut->errorpage( 'error', 'importfreeimages_noapikey' );
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

		# Check that the user has 'upload' right and is logged in
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

		# Show a message if the database is in read-only mode
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		$import = $wgRequest->getVal( 'url', '' );
		if( $wgRequest->wasPosted() && $import != '' ) {
			if( $this->wfIFI_handleUpload( $f, $import ) )
				return;
			$wgOut->addHTML('<hr/>');
		}

		$q = $wgRequest->getText( 'q' );

		global $wgScript;
		$wgOut->addHTML( wfMsg( 'importfreeimages-description' ) . "<br /><br />
			<form method=GET action=\"$wgScript\">".wfMsg('search').
			Xml::hidden( 'title', $importPage->getPrefixedDBkey() ) .
			": <input type=text name=q value='" . htmlspecialchars($q) . "'><input type=submit value=".wfMsg('search')."></form>");

		if( $q != '' ) {
			$page = $wgRequest->getInt( 'p', 1 );
			$q = $wgRequest->getVal( 'q' );
			// TODO: get the right licenses



                        $photos = $f->photos_search(
				array(
					$wgIFI_FlickrSearchBy => $q,
					'tag_mode' => 'any',
					'page' => $page,
					'per_page' => $wgIFI_ResultsPerPage,
					'license' => $wgIFI_FlickrLicense,
					'sort' => $wgIFI_FlickrSort
				)
			);

			if( $photos == null || !is_array($photos) || sizeof($photos) == 0 || !isset($photos['photo'])
			|| !is_array($photos['photo']) || sizeof($photos['photo']) == 0 ) {
				$wgOut->addHTML( wfMsg( 'importfreeimages_nophotosfound', htmlspecialchars( $q ) ) );
				return;
			}
			$sk = $wgUser->getSkin();
			$wgOut->addHTML("
				<table cellpadding=4>
				<form method='POST' name='uploadphotoform' action='" . $importPage->escapeFullURL() . "'>
					<input type=hidden name='url' value=''>
					<input type=hidden name='id' value=''>
					<input type=hidden name='action' value='submit'>
					<input type=hidden name='owner' value=''>
					<input type=hidden name='name' value=''>
					<input type=hidden name='ititle' value=''>
					<input type=hidden name='token' value='" . $wgUser->editToken() . "'>
					<input type=hidden name='q' value='" . htmlspecialchars($q) . "'>
			<script type='text/javascript'>
				function s2( url, id, owner, name, ititle ) {
					document.uploadphotoform.url.value = url;
					document.uploadphotoform.id.value = id;
					document.uploadphotoform.owner.value = owner;
					document.uploadphotoform.name.value = name;
					document.uploadphotoform.ititle.value = ititle;
					if( " . ($wgIFI_PromptForFilename ? "true" : "false") . " ) {
						document.uploadphotoform.ititle.value = prompt(" . Xml::encodeJsVar( wfMsg('importfreeimages_promptuserforfilename') ) . ", ititle);
						if( document.uploadphotoform.ititle.value == '' ) {
							document.uploadphotoform.ititle.value = ititle;
						}
					}
					document.uploadphotoform.submit();
				}
			</script>");
			$ownermsg = wfMsg( 'importfreeimages_owner' );
			$importmsg = wfMsg( 'importfreeimages_importthis' );
			$i = 0;
			foreach( $photos['photo'] as $photo ) {
				$owner = $f->people_getInfo( $photo['owner'] );

				$owner_esc = htmlspecialchars( $photo['owner'], ENT_QUOTES );
				$id_esc = htmlspecialchars( $photo['id'], ENT_QUOTES );
				$title_esc = htmlspecialchars( $photo['title'], ENT_QUOTES );
				$username_esc = htmlspecialchars( $owner['username'], ENT_QUOTES );
				$thumb_esc = htmlspecialchars( "http://farm{$photo['farm']}.static.flickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_{$wgIFI_ThumbType}.jpg", ENT_QUOTES );

				$owner_js = Xml::encodeJsVar( $photo['owner'] );
				$id_js = Xml::encodeJsVar( $photo['id'] );
				$title_js = Xml::encodeJsVar( $photo['title'] );
				$username_js = Xml::encodeJsVar( $owner['username'] );
				$url_js = Xml::encodeJsVar( "http://farm{$photo['farm']}.static.flickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}.jpg" );

				if( $i % $wgIFI_ResultsPerRow == 0 ) $wgOut->addHTML("<tr>");
				$wgOut->addHTML( "
					<td align='center' style='padding-top: 15px; border-bottom: 1px solid #ccc;'>
						<font size=-2><a href='http://www.flickr.com/photos/$owner_esc/$id_esc/'>$title_esc</a>
						<br />$ownermsg: <a href='http://www.flickr.com/people/$owner_esc/'>$username_esc</a>
						<br /><img src='$thumb_esc' />
						<br />(<a href='#' onclick='s2($url_js, $id_js, $owner_js, $username_js, $title_js);'>$importmsg</a>)</font>
					</td>
				" );
				if( $i % $wgIFI_ResultsPerRow == ($wgIFI_ResultsPerRow - 1) ) $wgOut->addHTML("</tr>");
				$i++;
			}

			$wgOut->addHTML("</form></table>");
			if( $wgIFI_ResultsPerPage * $page < $photos['total'] ) {
				$page++;
				$wgOut->addHTML("<br />" . $sk->makeLinkObj($importPage, wfMsg('importfreeimages_next', $wgIFI_ResultsPerPage), "p=$page&q=" . urlencode($q) ) );
			}
		}
	}

	/**
	 * Shows a custom upload warning
	 * @param $u UploadForm object
	 * @param $warning Mixed: warning message (MediaWiki:Fileexists plus some other stuff)
	 */
	function wfIFI_uploadWarning( $u, $warning ) {
		global $wgOut, $wgUseCopyrightUpload;

		wfLoadExtensionMessages( 'ImportFreeImages' );

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
		if ( $wgUseCopyrightUpload ){
			$copyright = '<input type="hidden" name="wpUploadCopyStatus" value="' . htmlspecialchars( $u->mUploadCopyStatus ) . '" />
						<input type="hidden" name="wpUploadSource" value="' . htmlspecialchars( $u->mUploadSource ) . '" />';
		} else {
			$copyright = '';
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
		</table></form>\n" . wfMsg( 'importfreeimages_returntoform', $_SERVER["HTTP_REFERER"] ) );
		//  $_SERVER["HTTP_REFERER"]; -- javascript.back wasn't working for some reason... hmph.
	}

	/**
	 * Return values:
	 *  true: Don't show query form, because
	 *          either everything worked
	 *          or something is so wrong that it makes no sense to continue
	 *  false: Temporary error (e.g. proposed pagename is protected against creation),
	 *         show query again so user has a chance to retry.
	 */
	function wfIFI_handleUpload( $f, $import ) {
		global $wgRequest, $wgUser, $wgOut, $wgTmpDirectory;
		global $wgIFI_GetOriginal, $wgIFI_CreditsTemplate, $wgIFI_AppendRandomNumber;

		wfLoadExtensionMessages( 'ImportFreeImages' );

		# Check token, to preven Cross Site Request Forgeries
		$token = $wgRequest->getVal( 'token' );
		if( !$wgUser->matchEditToken( $token ) ) {
			$wgOut->addWikiMsg( 'sessionfailure' );
			return false;
		}

		$id = $wgRequest->getVal( 'id' );
		$ititle = $wgRequest->getVal( 'ititle' );
		$owner = $wgRequest->getVal( 'owner' );
		$name = $wgRequest->getVal( 'name' );

		if( $wgIFI_GetOriginal ) {
			// get URL of original :1

			$sizes = $f->photos_getSizes( $id );
			$original = '';
			foreach( $sizes as $size ) {
				if( $size['label'] == 'Original' ) {
					$original = $size['source'];
					$import = $size['source'];
				} else if( $size['label'] == 'Large' ) {
					$large = $size['source'];
				}
			}
			// sometimes Large is returned but no Original!
			if( $original == '' && $large != '' )
				$import = $large;
		}

		if( !preg_match( '/^http:\/\/farm[0-9]+\.static\.flickr\.com\/.*\.(jpg|gif|png)$/', $import, $matches ) ) {
			$wgOut->showErrorPage( 'error', 'importfreeimages_invalidurl', array( wfEscapeWikiText( $import ) ) );
			return true;
		}
		$fileext = '.' . $matches[1];

		// store the contents of the file
		$pageContents = file_get_contents($import);
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
		if( !empty( $wgIFI_CreditsTemplate ) ) {
			$owner_wiki = wfEscapeWikiText( $owner );
			$id_wiki = wfEscapeWikiText( $id );
			$caption = "{{" . $wgIFI_CreditsTemplate . intval( $info['license'] ) . "|1=$id_wiki|2=$owner_wiki|3=$name_wiki}}";
		} else {
			// TODO: this is totally wrong: The whole message should be configurable, we shouldn't include arbitrary templates
			// additionally, the license information is not correct (we are not guaranteed to get "CC by 2.0" images only)
			$caption = wfMsgForContent('importfreeimages_filefromflickr', $ititle, "http://www.flickr.com/people/" . urlencode($owner) . " " . $name_wiki) . " <nowiki>$import</nowiki>. {{CC by 2.0}} ";
			$caption = trim($caption);
		}

		// UploadForm class should be autoloaded by now on MediaWiki 1.13+
		// But on older versions, we need to require_once() it manually
		if( !class_exists( 'UploadForm' ) ){
			require_once('includes/SpecialUpload.php');
		}
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
			$this->wfIFI_uploadWarning( $u, $warning );
			return true;
		} elseif( !$nt->userCan( 'create' ) ) {
			$wgOut->showPermissionsErrorPage( $nt->getUserPermissionsErrors( 'create', $wgUser ) );
			return false;
		} else {
			$u->execute();
			return true;
		}
	}

} // class
