<?php
/**
 * Redirect to JS page in edit mode
 */
// special page
$wgSpecialPages['JS'] = 'SpecialJs';
class SpecialJs extends RedirectSpecialPage {
	function __construct() {
		parent::__construct( 'JS' );
	}
	function getRedirect( $subpage ) {
		return Title::makeTitle( NS_MEDIAWIKI, 'Common.js' );
	}
	function getRedirectQuery() {
		return ['action' => 'edit'];
	}
}
