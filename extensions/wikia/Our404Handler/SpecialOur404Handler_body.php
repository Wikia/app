<?php
/**
 * Main part of Special:Our404Handler
 *
 * @file
 * @ingroup Extensions
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com> for Wikia.com
 * @copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @version 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

class Our404HandlerPage extends UnlistedSpecialPage {

	const NAME = 'Our404Handler';

	/**
	 * Constructor
	 */
	public function  __construct() {
		parent::__construct( self::NAME );
	}

	/**
	 * Main entry point
	 *
	 * @access public
	 *
	 * @param $subpage Mixed: subpage of SpecialPage
	 */
	public function execute( $subpage ) {
		$this->setHeaders();
		$this->doRender404();
	}


	/**
	 * Just render some simple 404 page
	 */
	public function doRender404() {
		global $wgOut, $wgContLang;

		$uri = substr( parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), 1 );
		$title = $wgContLang->ucfirst( urldecode( ltrim( $uri, "/" ) ) );
		$oTitle = Title::newFromText( $title );

		if ( is_null( $oTitle ) ) {
			$wgOut->setStatusCode( 404 );

			$info = wfMsgForContent( 'message404', $uri, urldecode( $title ) );
			$wgOut->addHTML( '<h2>' . wfMsg( 'our404handler-oops' ) . '</h2>
						<div>' . $wgOut->parse( $info ) . '</div>' );
			return;
		}

		// Preserve the query string on a redirect
		$query = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY );

		// Log the query string to understand what params are used
		Wikia\Logger\WikiaLogger::instance()->debug( __METHOD__, [ 'qs' => $query, 'ex' => new Exception() ] );

		header( "X-Redirected-By: Our404Handler" );
		header( sprintf( "Location: %s", $oTitle->getFullURL( $query ) ), true, 301 );
	}

	/**
	 * This hook is called when about to force a redirect to a canonical URL
	 * for a title when we have no other parameters on the URL.
	 *
	 * Return false when we want to prevent the redirect to the canonical URL
	 * for Our404Handler special page (for non-English wikis)
	 *
	 * @see PLATFORM-811, SEO-217
	 *
	 * @param WebRequest $request
	 * @param Title $title
	 * @param OutputPage $output
	 * @return bool
	 */
	public static function onTestCanonicalRedirect( WebRequest $request, Title $title, OutputPage $output) {
		if ( $title->isSpecial( self::NAME ) ) {
			return false;
		}

		return true;
	}
}
