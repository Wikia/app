<?php
/**
 * Specialpage for the Commentbox extension.
 *
 * @addtogroup Extensions
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
		wfLoadExtensionMessages( 'Commentbox' );

		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->displayRestrictionError();
			return;
		}
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

			$wgOut->addWikiText( wfMsg( 'spamprotectiontext' ) );
			$wgOut->addWikiText( wfMsg( 'spamprotectionmatch', "<nowiki>{$matches[0]}</nowiki>" ) );
			$wgOut->returnToMain( false, $wgTitle );
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
		try {
			$req = new FauxRequest( array(
						'action'  => 'edit',
						'title'   => $title->getPrefixedText(),
						'text'    => $text,
						'summary' => wfMsgForContent( 'commentbox-log' ),
						'token'   => $wgUser->editToken(),
						), true );
			$api = new ApiMain( $req, true );
			$api->execute();
			wfDebug( "Completed API-Save\n" );
			// we only reach this point if Api doesn't throw an exception
			$data = $api->getResultData();
			if ( $data['edit']['result'] == 'Failure' ) {
				$spamurl = $data['edit']['spamblacklist'];
				if ( $spamurl != '' )
					throw new Exception( "Die Seite enthaelt die Spam-Url ``{$spamurl}''" );
				else
					throw new Exception( "Unbekannter Fehler" );
			}
		} catch ( Exception $e ) {
			global $wgOut;
			$wgOut->setPageTitle( wfMsg( 'commentbox-errorpage-title' ) );
			$wgOut->addHTML( "<div class='errorbox'>" . htmlspecialchars( $e->getMessage() ) . "</div><br clear='both' />" );
			if ( $title != null )
				$wgOut->returnToMain( false, $title );
			return;
		}

		$wgOut->redirect( $title->getFullURL() );
		return;
	}

	function fail( $str, $title = null ) {
		global $wgOut;
		$wgOut->setPageTitle( wfMsg( 'commentbox-errorpage-title' ) );
		$wgOut->addWikiText( "<div class='errorbox'>" . wfMsg( $str ) . "</div><br clear='both' />" );
		if ( $title != null )
			$wgOut->returnToMain( false, $title );
		return;
	}

}

