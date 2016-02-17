<?php
/**
 * Redirect to CSS page in edit mode
 */

// special page
$wgSpecialPages['CSS'] = 'SpecialCss';

class SpecialCss extends RedirectSpecialPage {
	function __construct() {
		parent::__construct( 'CSS' );
	}

	function getRedirect( $subpage ) {
		return Title::makeTitle( NS_MEDIAWIKI, 'Wikia.css' );
	}

	function getRedirectQuery() {
		return ['action' => 'edit'];
	}
}
