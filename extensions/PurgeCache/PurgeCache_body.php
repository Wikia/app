<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}

class SpecialPurgeCache extends SpecialPage {

	function __construct() {
		parent::__construct( 'PurgeCache', 'purgecache' );
	}

	function execute( $par ) {
		global $wgUser, $wgRequest, $wgOut;

		

		$this->setHeaders();
		if ( $wgUser->isAllowed( 'purgecache' ) ) {
			if ( $wgRequest->getCheck( 'purge' ) && $wgRequest->wasPosted() ) {
				$dbw = wfGetDB( DB_MASTER );
				$dbw->delete( 'objectcache', '*', __METHOD__ );
				$wgOut->addWikiMsg( 'purgecache-purged' );
			} else {
				$wgOut->addWikiMsg( 'purgecache-warning' );
				$wgOut->addHTML( $this->makeForm() );
			}
		} else {
			$wgOut->permissionRequired( 'purgecache' );
		}
	}

	function makeForm() {
		$self = $this->getTitle();
		$form  = Xml::openElement( 'form', array( 'method' => 'post', 'action' => $self->getLocalUrl() ) );
		$form .= Xml::element( 'input', array( 'type' => 'submit', 'name' => 'purge', 'value' => wfMsg( 'purgecache-button' ) ) );
		$form .= Xml::closeElement( 'form' );
		return $form;
	}
}
