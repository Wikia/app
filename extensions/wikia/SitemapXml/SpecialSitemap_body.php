<?php

/**
 * Main part of Special:Sitemap
 *
 * @file
 * @ingroup Extensions
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> for Wikia Inc.
 * @copyright © 2010, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @version 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

class SitemapPage extends UnlistedSpecialPage {

	/**
	 * standard constructor
	 * @access public
	 * @param $name
	 */
	public function __construct( $name = 'Sitemap' ) {
		parent::__construct( $name );
	}

	/**
	 * Main entry point
	 *
	 * @access public
	 *
	 * @param $subpage Mixed: subpage of SpecialPage
	 */
	public function execute( $subpage ) {
		// keeping the checks for old sitemaps for now so we return 404s
		$showIndex = strpos( $subpage, '-index.xml' ) !== false;

		$forceOldSitemap = strpos( $subpage, '-oldsitemapxml-' ) !== false;
		$forceNewSitemap = strpos( $subpage, '-newsitemapxml-' ) !== false;

		if ( ( $showIndex && !$forceOldSitemap ) || $forceNewSitemap ) {
			$this->getOutput()->disable();
			$response = F::app()->sendRequest( 'SitemapXml', 'index', [ 'path' => $subpage ] );
			$response->sendHeaders();
			echo $response->getBody();
			return;
		}
		$this->print404();
		return;
	}

	/**
	 * show 404
	 *
	 * @access private
	 */
	private function print404() {
		$this->getOutput()->disable();

		header( 'HTTP/1.0 404 Not Found' );
		echo '404: Page doesn\'t exist';
	}

}
