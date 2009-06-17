<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @addtogroup SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @version: 0.1
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension named RequestWiki.\n";
	exit( 1 ) ;
}

/**
 * main class
 */
class RequestWikiPage extends SpecialPage {

	/**
	 * contructor
	 */
	function  __construct() {
		wfLoadExtensionMessages("RequestWiki");
		parent::__construct( 'RequestWiki'  /*class*/, 'requestwiki' /*restriction*/);
	}

	/**
	 * execute
	 *
	 * main entry point
	 *
	 * @author eloy@wikia.com
	 * @access public
	 *
	 * @param string $subpage: subpage of Title
	 *
	 * @return nothing
	 */
	function execute() {
		global $wgOut;

		/**
		 * redirect to central wikia new autocreate page
		 * @see extensions/wikia/AutoCreateWiki/
		 */

		$wgOut->redirect( "http://www.wikia.com/wiki/Special:CreateWiki");
		return true;
	}

};

