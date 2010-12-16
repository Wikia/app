<?php

class FlagPageTabInstaller {
	function __construct( ) { }

	function insertTab( $skin, &$content_actions ) {
		global $wgTitle;
		if ( !$wgTitle->exists() ) {
			return false;
		}
		$linkParam = "page=" . $wgTitle->getPrefixedURL();
		wfLoadExtensionMessages( 'FlagPage' );
		$special = SpecialPage::getTitleFor( 'FlagPage' );
		$content_actions['flagpage'] = array(
			'class' => false,
			'text' => wfMsgHTML( 'flagpage-tab' ),
			'href' => $special->getLocalUrl( $linkParam ) );
		return true;
	}
}
