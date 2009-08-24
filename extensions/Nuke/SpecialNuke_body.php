<?php

if( !defined( 'MEDIAWIKI' ) )
	die( 'Not an entry point.' );

class SpecialNuke extends SpecialPage {
	function __construct() {
		wfLoadExtensionMessages( 'Nuke' );
		parent::__construct( 'Nuke', 'nuke' );
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
			wfMsgForContent( 'nuke-defaultreason', $target ) );
		$posted = $wgRequest->wasPosted() &&
			$wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) );
		if( $posted ) {
			$pages = $wgRequest->getArray( 'pages' );
			if( $pages ) {
				return $this->doDelete( $pages, $reason );
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
		$submit = Xml::submitButton( wfMsg( 'nuke-submit-user' ) );

		$wgOut->addWikiMsg( 'nuke-tools' );
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
			$wgOut->addWikiMsg( 'nuke-nopages', $username );
			return $this->promptForm();
		}
		$wgOut->addWikiMsg( 'nuke-list', $username );

		$nuke = $this->getTitle();
		$submit = Xml::submitButton( wfMsg( 'nuke-submit-delete' ) );

		$wgOut->addHTML(
			Xml::openElement( 'form', array(
				'action' => $nuke->getLocalURL( 'action=delete' ),
				'method' => 'post' )
			) .
			Xml::hidden( 'wpEditToken', $wgUser->editToken() ) .
			Xml::inputLabel(
				wfMsg( 'deletecomment' ), 'wpReason', 'wpReason', 60, $reason
			) . '<br /><br />' .
			Xml::submitButton( wfMsg( 'nuke-submit-delete' ) )
		);

		$wgOut->addHTML( '<ul>' );

		$sk = $wgUser->getSkin();
		foreach( $pages as $info ) {
			list( $title, $edits ) = $info;
			$image = $title->getNamespace() == NS_IMAGE ? wfLocalFile( $title ) : false;
			$thumb = $image && $image->exists() ? $image->getThumbnail( 120, 120 ) : false;

			$changes = wfMsgExt( 'nchanges', 'parsemag', $wgLang->formatNum( $edits ) );
			
			$wgOut->addHTML( '<li>' .
				Xml::check( 'pages[]', true,
					array( 'value' =>  $title->getPrefixedDbKey() )
				) .
				'&nbsp;' .
				( $thumb ? $thumb->toHtml( array( 'desc-link' => true ) ) : '' ) .
				$sk->makeKnownLinkObj( $title ) .
				'&nbsp;(' .
				$sk->makeKnownLinkObj( $title, $changes, 'action=history' ) .
				")</li>\n" );
		}
		$wgOut->addHTML(
			"</ul>\n" .
			Xml::submitButton( wfMsg( 'nuke-submit-delete' ) ) .
			"</form>"
		);
	}

	function getNewPages( $username ) {
		$dbr = wfGetDB( DB_SLAVE );
		$result = $dbr->select( 'recentchanges',
			array( 'rc_namespace', 'rc_title', 'rc_timestamp', 'COUNT(*) AS edits' ),
			array(
				'rc_user_text' => $username,
				'(rc_new = 1) OR (rc_log_type = "upload" AND rc_log_action = "upload")' 
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

	function doDelete( $pages, $reason ) {
		foreach( $pages as $page ) {
			$title = Title::newFromUrl( $page );
			$file = $title->getNamespace() == NS_IMAGE ? wfLocalFile( $title ) : false;
			if ( $file ) {
				$oldimage = null; // Must be passed by reference
				FileDeleteForm::doDelete( $title, $file, $oldimage, $reason, false );								
			} else {
				$article = new Article( $title );
				$article->doDelete( $reason );
			}
		}
	}
}
