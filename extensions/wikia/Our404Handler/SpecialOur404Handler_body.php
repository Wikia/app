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

	public $mTitle;

	/**
	 * Constructor
	 */
	public function  __construct() {
		parent::__construct( 'Our404Handler'/*class*/ );
	}

	/**
	 * Main entry point
	 *
	 * @access public
	 *
	 * @param $subpage Mixed: subpage of SpecialPage
	 */
	public function execute( $subpage ) {
		global $wgRequest;
		$this->setHeaders();
		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'Our404Handler' );
		$this->doRender404();
	}


	/**
	 * Just render some simple 404 page
	 *
	 * @access public
	 */
	public function doRender404( $uri = null ) {
		global $wgOut, $wgContLang, $wgCanonicalNamespaceNames;

		/**
		 * check, maybe we have article with that title, if yes 301redirect to
		 * this article
		 */
		if( $uri === null ) {
			$uri = $_SERVER['REQUEST_URI'];
			if ( !preg_match( '!^https?://!', $uri ) ) {
				$uri = 'http://unused' . $uri;
			}
			$uri = substr( parse_url( $uri, PHP_URL_PATH ), 1 );
		}
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
			if( $namespace == NS_SPECIAL || $namespace == NS_MEDIA ) {
				/**
				 * these namespaces are special and don't have articles
				 */
				header( sprintf( "Location: %s", $oTitle->getFullURL() ), true, 301 );
				exit( 0 );

			} else {
				$oArticle = new Article( $oTitle );
				if( $oArticle->exists() ) {
					header( sprintf( "Location: %s", $oArticle->mTitle->getFullURL() ), true, 301 );
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
};
