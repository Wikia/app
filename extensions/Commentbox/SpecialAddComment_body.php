<?php
/**
 * Specialpage for the Commentbox extension.
 *
 * @file
 * @ingroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

class SpecialAddComment extends UnlistedSpecialPage {
	public function __construct() {
		parent::__construct( 'AddComment', 'edit' );
	}

	public function execute( $par ) {
		global $wgUser, $wgRequest, $wgOut, $wgCommentboxNamespaces;
		if ( !$wgRequest->wasPosted() ) {
			$wgOut->redirect( Title::newMainPage()->getFullURL() );
			return;
		}
		$this->setHeaders();

		$Pagename = $wgRequest->getText( 'wpPageName' );
		$Author   = $wgRequest->getText( 'wpAuthor', '' );
		$Comment  = $wgRequest->getText( 'wpComment', '' );
		$title = Title::newFromText( $Pagename );
		if ( $title == NULL || !$title->exists() ) {
			$this->fail( 'commentbox-error-page-nonexistent' );
			return;
		}

		if ( !array_key_exists( $title->getNamespace(), $wgCommentboxNamespaces )
		|| !$wgCommentboxNamespaces[ $title->getNamespace() ] ) {
			$this->fail( 'commentbox-error-namespace', $title );
			return;
		}

		if ( $Comment == '' || $Comment == wfMsgNoTrans( 'commentbox-prefill' ) ) {
			$this->fail( 'commentbox-error-empty-comment', $title );
			return;
		}

		if ( !$title->userCan( 'edit' ) ) {
			$this->displayRestrictionError();
			return;
		}

		// TODO: Integrate with SpamBlacklist etc.
		// Currently, no http/https-links are allowed at all
		$matches = array();
		if ( preg_match( '@https?://[-.\w]+@', $Comment, $matches ) ||
		    preg_match( '@https?://[-.\w]+@', $Author, $matches ) ) {
			$wgOut->setPageTitle( wfMsg( 'spamprotectiontitle' ) );
			$wgOut->setRobotPolicy( 'noindex,nofollow' );
			$wgOut->setArticleRelated( false );

			$wgOut->addWikiMsg( 'spamprotectiontext' );
			$wgOut->addWikiMsg( 'spamprotectionmatch', "<nowiki>{$matches[0]}</nowiki>" );
			$wgOut->returnToMain( false, $title );
			return;
		}

		$article = new Article( $title );
		$text = $article->getContent();
		$subject = '';
		if ( !preg_match( wfMsgForContentNoTrans( 'commentbox-regex' ), $text ) )
			$subject = wfMsgForContent( 'commentbox-first-comment-heading' ) . "\n";
		$sig = $wgUser->isLoggedIn() ? "-- ~~~~" : "-- $Author ~~~~~";
		// Append <br /> after each newline, except if the user started a new paragraph
		$Comment = preg_replace( '/(?<!\n)\n(?!\n)/', "<br />\n", $Comment );
		$text .= "\n\n" . $subject . $Comment . "\n<br />" . $sig;

		$reqArr = array(
			'wpTextbox1' => $text,
			'wpSummary' => wfMsgForContent( 'commentbox-log' ),
			'wpEditToken' => $wgUser->editToken(),
			'wpIgnoreBlankSummary' => '',
			'wpStarttime' => wfTimestampNow(),
			'wpEdittime' => $article->getTimestamp(),
		);
		$request = new FauxRequest( $reqArr, true );
		$ep = new EditPage( $article );
		$ep->setContextTitle( $title );
		$ep->importFormData( $request );
		$details = array(); // Passed by ref
		$status = $ep->internalAttemptSave( $details );
		$retval = $status->value;

		switch ( $retval ) {
		case EditPage::AS_SUCCESS_UPDATE:
			$wgOut->redirect( $title->getFullURL() );
			break;
		case EditPage::AS_SPAM_ERROR:
			$ep->spamPageWithContent( $details['spam'] );
			break;
		case EditPage::AS_BLOCKED_PAGE_FOR_USER:
			$wgOut->blockedPage();
			break;
		case EditPage::AS_READ_ONLY_PAGE_ANON:
		case EditPage::AS_READ_ONLY_PAGE_LOGGED:
			$wgOut->permissionRequired( 'edit' );
			break;
		case EditPage::AS_READ_ONLY_PAGE:
			$wgOut->readOnlyPage();
		}
	}

	function fail( $str, $title = null ) {
		global $wgOut;
		$wgOut->setPageTitle( wfMsg( 'commentbox-errorpage-title' ) );
		$wgOut->wrapWikiMsg( "<div class='errorbox'>$1</div><br clear='both' />", $str );
		if ( $title != null )
			$wgOut->returnToMain( false, $title );
		return;
	}

}

