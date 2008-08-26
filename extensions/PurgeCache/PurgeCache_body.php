<?php
if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}

class PurgeCache extends SpecialPage {

	function PurgeCache() {
		SpecialPage::SpecialPage( 'PurgeCache', 'purgecache' );
	}
	
	function execute() {
		global $wgUser, $wgRequest, $wgOut;

		wfLoadExtensionMessages('PurgeCache');

		$this->setHeaders();
		if( $wgUser->isAllowed( 'purgecache' ) ) {
			if( $wgRequest->getCheck( 'purge' ) && $wgRequest->wasPosted() ) {
				$dbw =& wfGetDB( DB_MASTER );
				$dbw->delete( 'objectcache', '*', 'PurgeCache::execute' );
				$wgOut->addWikiText( wfMsg('purgecache-purged') );
			} else {
				$wgOut->addWikiText( wfMsg('purgecache-warning') );
				$wgOut->addHtml( $this->makeForm() );
			}
		} else {
			$wgOut->permissionRequired( 'purgecache' );
		}
	}
	
	function makeForm() {
		$self = $this->getTitle();
		$form  = wfOpenElement( 'form', array( 'method' => 'post', 'action' => $self->getLocalUrl() ) );
		$form .= wfElement( 'input', array( 'type' => 'submit', 'name' => 'purge', 'value' => wfMsg('purgecache-button') ) );
		$form .= wfCloseElement( 'form' );
		return $form;
	}
}
