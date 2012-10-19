<?php
// Sanity check - check for MediaWiki environment...
if( !defined( 'MEDIAWIKI' ) ) {
	die( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
}

class SpecialImportFreeImages extends SpecialPage {

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
		global $wgUser, $wgOut, $wgRequest, $wgEnableUploads;

		$this->setHeaders();
		$this->outputHeader();

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

		# Do all magic
		$this->showForm();
		$this->showResult();
	}

	/**
	 * Show the search form
	 */
	protected function showForm() {
		global $wgOut, $wgScript, $wgRequest;

		$wgOut->addHTML( Html::rawElement( 'fieldset', array(),
				Html::element( 'legend', array(), wfMsg( 'importfreeimages' ) ) . "\n" .
				wfMsgExt( 'importfreeimages_description', 'parse' ) . "\n" .
				Html::rawElement( 'form', array( 'action' => $wgScript ),
					Html::element( 'input', array(
						'type' => 'hidden',
						'name' => 'title',
						'value' => $this->getTitle()->getPrefixedText(),
					) ) . "\n" .
					Html::element( 'input', array(
						'type' => 'text',
						'name' => 'q',
						'size' => '40',
						'value' => $wgRequest->getText( 'q' ),
					) ) . "\n" .
					Html::element( 'input', array(
						'type' => 'submit',
						'value' => wfMsg( 'search' )
					) )
				)
		) );
	}

	/**
	 * Show the search result if available
	 */
	protected function showResult() {
		global $wgRequest, $wgUser, $wgOut;

		$page = $wgRequest->getInt( 'p', 1 );
		$q = $wgRequest->getVal( 'q' );
		if ( !$q )
			return;

		$ifi = new ImportFreeImages();
		// TODO: get the right licenses
		$photos = $ifi->searchPhotos( $q, $page );
		if ( !$photos ) {
			$wgOut->addHTML( wfMsg( 'importfreeimages_nophotosfound', htmlspecialchars( $q ) ) );
			return;
		}

		$sk = $wgUser->getSkin();
		$wgOut->addHTML( '<table cellpadding="4" id="mw-ifi-result">' );

		$specialUploadTitle = SpecialPage::getTitleFor( 'Upload' );

		$ownermsg = wfMsg( 'importfreeimages_owner' );
		$importmsg = wfMsg( 'importfreeimages_importthis' );
		$i = 0;
		foreach( $photos['photo'] as $photo ) {
			$owner = $ifi->getOwnerInfo( $photo['owner'] );

			$owner_esc = htmlspecialchars( $photo['owner'], ENT_QUOTES );
			$id_esc = htmlspecialchars( $photo['id'], ENT_QUOTES );
			$title_esc = htmlspecialchars( $photo['title'], ENT_QUOTES );
			$username_esc = htmlspecialchars( $owner['username'], ENT_QUOTES );
			$thumb_esc = htmlspecialchars( "http://farm{$photo['farm']}.static.flickr.com/{$photo['server']}/{$photo['id']}_{$photo['secret']}_{$ifi->thumbType}.jpg", ENT_QUOTES );
			$format = isset($photo['originalformat']) ? $photo['originalformat'] : '.jpg';
			$link = $specialUploadTitle->escapeLocalURL( array(
				'wpSourceType' => 'IFI',
				'wpFlickrId' => $photo['id'],
				'wpDestFile' => $photo['title'].'.'.$format
			) );

			if ( $i % $ifi->resultsPerRow == 0 ) {
				$wgOut->addHTML( '<tr>' );
			}

			# TODO: Fix nasty HTML generation
			$wgOut->addHTML( "
					<td align='center' style='padding-top: 15px; border-bottom: 1px solid #ccc;'>
						<font size=-2><a href='http://www.flickr.com/photos/$owner_esc/$id_esc/'>$title_esc</a>
						<br />$ownermsg: <a href='http://www.flickr.com/people/$owner_esc/'>$username_esc</a>
						<br /><img src='$thumb_esc' />
						<br />(<a href='$link'>$importmsg</a>)</font>
					</td>
			" );

			if ( $i % $ifi->resultsPerRow == ( $ifi->resultsPerRow - 1 ) ) {
				$wgOut->addHTML( '</tr>' );
			}

			$i++;
		}

		$wgOut->addHTML( '</table>' );

		if ( $ifi->resultsPerPage * $page < $photos['total'] ) {
			$page++;
			$wgOut->addHTML( '<br />' . $sk->makeLinkObj(
				$this->getTitle(),
				wfMsgHtml( 'importfreeimages_next', $ifi->resultsPerPage ),
				"p=$page&q=" . urlencode( $q )
			) );
		}
	}

} // class
