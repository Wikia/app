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
	const IMAGEROOT = '/images';
	const FAVICON_ICO = '/images/c/central/images/6/64/Favicon.ico';
	const FAVICON_URL = 'http://images.wikia.com/central/images/6/64/Favicon.ico';
	const LOGOWIDE_PNG = 'templates/Wiki_wide.png';
	const LOGOWIDE_URL = 'http://images.wikia.com/starter/images/e/ed/TitleTemplate.png';

	public $mTitle, $mAction, $mSubpage;

	/**
	 * Constructor
	 */
	public function  __construct() {
		parent::__construct( 'Our404Handler'/*class*/ );
	}

	/**
	 * Main entry point
	 * Default action is to make thumb
	 *
	 * @access public
	 *
	 * @param $subpage Mixed: subpage of SpecialPage
	 */
	public function execute( $subpage ) {
		global $wgRequest;
		wfLoadExtensionMessages( 'Our404Handler' );

		$this->setHeaders();

		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'Our404Handler' );
		$this->mAction = $wgRequest->getVal( 'action' );
		$this->mSubpage = $subpage;
		$this->mAction = ( $this->mAction )
			? $wgRequest->getVal( 'action' )
			: 'thumb';

		if ( isset( $this->mSubpage ) && $this->mSubpage === 'thumb' ) {
			$sURI = $wgRequest->getVal( 'uri' );
			return $this->doThumbnail( $sURI );
		}

		$this->doRender404();
	}

	/**
	 * Just return thumbnail (create if needed). code based on /thumb.php
	 * from MediaWiki. Use cache for storing known values
	 *
	 * @access public
	 */
	public function doThumbnail( $uri ){
		global $wgOut, $wgMemc, $wgExternalSharedDB;

		wfProfileIn( __METHOD__ );

		/**
		 * take last part, it should be nnnpx-title schema
		 * (622px-Welcome_talk.png)
		 */
		$render   = false;
		$filename = array_pop( explode( '/', $uri ) );

		preg_match( "/(\d+)px\-([^\?]+)/", $filename, $parts );
		if( isset( $parts[ 1 ] ) && isset( $parts[ 2 ] ) ) {

			/**
			 * deal with local file
			 */
			$thumbWidth = $parts[ 1 ];
			$thumbName = $parts[ 2 ];
			$image = wfLocalFile( $thumbName );
			if( $image ) {
				try {
					$thumb = $image->transform( array( "width" => $thumbWidth ), File::RENDER_NOW );
					$render = true;
				}
				catch( Exception $ex ) {
					$thumb = false;
				}
			}
		}
		wfProfileOut( __METHOD__ );
		if( $render ) {
			/**
			 * @todo handle errors
			 */
			wfStreamFile( $thumb->getPath() );
		}
		else {
			return $this->doRender404( $uri );
		}
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
		$title = $wgContLang->ucfirst( urldecode( $uri ) );
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
				$oArticle = MediaWiki::articleFromTitle( $oTitle );
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
