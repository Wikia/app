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
		global $wgOut, $wgContLang, $wgCanonicalNamespaceNames;

		/**
		 * check, maybe we have article with that title, if yes 301redirect to
		 * this article
		 */
		$uri = $_SERVER['REQUEST_URI'];
		if ( !preg_match( '!^https?://!', $uri ) ) {
			$uri = 'http://unused' . $uri;
		}
		$uri = substr( parse_url( $uri, PHP_URL_PATH ), 1 );

		Wikia::log( __METHOD__, false,  isset($_SERVER[ 'HTTP_REFERER' ])?$_SERVER[ 'HTTP_REFERER' ]:"[no referer]" );
		$title = $wgContLang->ucfirst( urldecode( ltrim( $uri, "/" ) ) );
		$namespace = NS_MAIN;

		/**
		 * first check if title is in namespace other than main
		 */
		$parts = explode( ":", $title, 2 );
		if( count( $parts ) == 2 ) {
			foreach( $wgCanonicalNamespaceNames as $id => $name ) {
				$translated = $wgContLang->getNsText( $id );
				if( strtolower( $translated ) === strtolower( $parts[0] ) ||
					strtolower( $name ) === strtolower( $parts[0] ) ) {
					$namespace = $id;
					$title = $parts[1];
					break;
				}
			}
		}

		/**
		 * create title from parts
		 */
		$oTitle = Title::newFromText( $title, $namespace );

		if( !is_null( $oTitle ) ) {
			// Preserve the query string on a redirect
			$query = parse_url ( $_SERVER['REQUEST_URI'], PHP_URL_QUERY );
			if( $namespace == NS_SPECIAL || $namespace == NS_MEDIA ) {
				/**
				 * these namespaces are special and don't have articles
				 */
				header( "X-Redirected-By: Our404Handler" );
				header( sprintf( "Location: %s", $oTitle->getFullURL($query) ), true, 301 );
				exit( 0 );

			} else {
				$oArticle = new Article( $oTitle );
				if( $oArticle->exists() ) {
					header( "X-Redirected-By: Our404Handler" );
					header( sprintf( "Location: %s", $oArticle->getTitle()->getFullURL($query) ), true, 301 );
					exit( 0 );
				}
			}

		}

		/**
		 * but if doesn't exist, we eventually show 404page
		 */
		$wgOut->setStatusCode( 404 );

		$info = wfMsgForContent( 'message404', $uri, urldecode( $title ) );
		$wgOut->addHTML( '<h2>'.wfMsg( 'our404handler-oops' ).'</h2>
						<div>'. $wgOut->parse( $info ) .'</div>' );
	}

	/**
	 * This hook is called when about to force a redirect to a canonical URL
	 * for a title when we have no other parameters on the URL.
	 *
	 * Return false when we want to prevent the redirect to the canonical URL
	 * for Our404Handler special page
	 *
	 * @see PLATFORM-811
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
};
