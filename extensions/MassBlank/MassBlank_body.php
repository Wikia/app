<?php

if( !defined( 'MEDIAWIKI' ) )
	die( 'Not an entry point.' );

class SpecialMassBlank extends SpecialPage {
	function __construct() {
		
		parent::__construct( 'MassBlank', 'massblank' );
	}

	function execute( $par ){
		global $wgUser, $wgRequest;

		if( !$this->userCanExecute( $wgUser ) ){
			$this->displayRestrictionError();
			return;
		}

		$this->setHeaders();
		$this->outputHeader();

		$target = $wgRequest->getText( 'target', $par );

		// Normalise name
		if ( $target !== '' ) {
			$user = User::newFromName( $target );
			if ( $user ) $target = $user->getName();
		}

		$reason = $wgRequest->getText( 'wpReason',
			wfMsgForContent( 'massblank-defaultreason', $target ) );
		$posted = $wgRequest->wasPosted() &&
			$wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) );
		if( $posted ) {
			$pages = $wgRequest->getArray( 'pages' );
			if( $pages ) {
				return $this->doBlank( $pages, $reason );
			}
		}
		if( $target != '' ) {
			$this->listForm( $target, $reason );
		} else {
			$this->promptForm();
		}
	}

	function promptForm() {
		global $wgOut;

		$input = Xml::input( 'target', 40 );
		$submit = Xml::submitButton( wfMsg( 'massblank-submit-user' ) );

		$wgOut->addWikiMsg( 'massblank-tools' );
		$wgOut->addHTML(
			Xml::openElement( 'form', array(
				'action' => $this->getTitle()->getLocalURL( 'action=submit' ),
				'method' => 'post' )
			) . "$input\n$submit\n"
		);

		$wgOut->addHTML( "</form>" );
	}

	function listForm( $username, $reason ) {
		global $wgUser, $wgOut, $wgLang;

		$pages = $this->getNewPages( $username );

		if( count( $pages ) == 0 ) {
			$wgOut->addWikiMsg( 'massblank-nopages', $username );
			return $this->promptForm();
		}
		$wgOut->addWikiMsg( 'massblank-list', $username );

		$massblank = $this->getTitle();
		$submit = Xml::submitButton( wfMsg( 'massblank-submit-blank' ) );

		$wgOut->addHTML(
			Xml::openElement( 'form', array(
				'action' => $massblank->getLocalURL( 'action=blank' ),
				'method' => 'post' )
			) .
			Html::Hidden( 'wpEditToken', $wgUser->editToken() ) .
			Xml::inputLabel(
				wfMsg( 'massblank-blankcomment' ), 'wpReason', 'wpReason', 60, $reason
			) . '<br /><br />' .
			Xml::submitButton( wfMsg( 'massblank-submit-blank' ) )
		);

		$wgOut->addHTML( '<ul>' );

		$sk = $wgUser->getSkin();
		foreach( $pages as $info ) {
			list( $title, $edits ) = $info;
			$image = $title->getNamespace() == NS_IMAGE ? wfLocalFile( $title ) : false;
			$thumb = $image && $image->exists() ? $image->transform( array( 'width' => 120, 'height' => 120 ), 0 ) : false;

			$changes = wfMsgExt( 'nchanges', 'parsemag', $wgLang->formatNum( $edits ) );
			
			$wgOut->addHTML( '<li>' .
				Xml::check( 'pages[]', true,
					array( 'value' =>  $title->getPrefixedDbKey() )
				) .
				'&#160;' .
				( $thumb ? $thumb->toHtml( array( 'desc-link' => true ) ) : '' ) .
				$sk->makeKnownLinkObj( $title ) .
				'&#160;(' .
				$sk->makeKnownLinkObj( $title, $changes, 'action=history' ) .
				")</li>\n" );
		}
		$wgOut->addHTML(
			"</ul>\n" .
			Xml::submitButton( wfMsg( 'massblank-submit-blank' ) ) .
			"</form>"
		);
	}

	function getNewPages( $username ) {
		$dbr = wfGetDB( DB_SLAVE );
		$result = $dbr->select( 'recentchanges',
			array( 'rc_namespace', 'rc_title', 'rc_timestamp', 'COUNT(*) AS edits' ),
			array(
				'rc_user_text' => $username,
				"(rc_new = 1)"
			),
			__METHOD__,
			array(
				'ORDER BY' => 'rc_timestamp DESC',
				'GROUP BY' => 'rc_namespace, rc_title'
			)
		);
		$pages = array();
		while( $row = $dbr->fetchObject( $result ) ) {
			$pages[] = array( Title::makeTitle( $row->rc_namespace, $row->rc_title ), $row->edits );
		}
		$dbr->freeResult( $result );
		return $pages;
	}

	function doBlank( $pages, $reason ) {
		foreach( $pages as $page ) {
			$title = Title::newFromURL( $page );
			$file = $title->getNamespace() == NS_IMAGE ? wfLocalFile( $title ) : false;
			if ( !$file ) {
				$article = new Article( $title );
				$article->doEdit( '', $reason );
			}
		}
	}
}
