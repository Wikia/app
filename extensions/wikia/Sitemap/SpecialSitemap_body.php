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

	private $mType, $mTitle, $mNamespaces, $mNamespace, $mPriorities,
		$mSizeLimit, $mPage, $mGoogleCode, $mVideoNamespaces;

	/**
	 * @var MediaQueryService
	 */
	private $mMediaService;
	public $mCacheTime;

	/**
	 * standard constructor
	 * @access public
	 */
	public function __construct( $name = "Sitemap" ) {
		parent::__construct( $name );

		$this->mPriorities = array(
			// MediaWiki standard namespaces
			NS_MAIN                 => '1.0',
			NS_TALK                 => '0.1',
			NS_USER                 => '0.2',
			NS_USER_TALK            => '0.1',
			NS_PROJECT              => '0.1',
			NS_PROJECT_TALK         => '0.1',
			NS_FILE                 => '0.5',
			NS_FILE_TALK            => '0.1',
			NS_MEDIAWIKI            => '0.1',
			NS_MEDIAWIKI_TALK       => '0.1',
			NS_TEMPLATE             => '0.1',
			NS_TEMPLATE_TALK        => '0.1',
			NS_HELP                 => '0.1',
			NS_HELP_TALK            => '0.1',
			NS_CATEGORY             => '1.0',
			NS_CATEGORY_TALK        => '0.1',
        );

		$this->mVideoNamespaces = array_merge( F::app()->wg->ContentNamespaces, array( 500 /* NS_BLOG not defined yet */ ) );
		$this->mSizeLimit = ( pow( 2, 20 ) * 10 ) - 20; // safe margin
		$this->mLinkLimit = 25000;
		$this->mPage = 0;
		$this->mCacheTime = 86400*14; // cron is run every week but we want to keep them longer
		$this->mMediaService = F::build('MediaQueryService');
	}


	/**
	 * Main entry point
	 *
	 * @access public
	 *
	 * @param $subpage Mixed: subpage of SpecialPage
	 */
	public function execute( $subpage ) {
		global $wgRequest, $wgUser, $wgOut;

		/**
		 * subpage works as type param, param has precedence, default is "index"
		 */
		$this->mType = "index";
		if ( !empty( $subpage ) ) {
			$this->mType = $subpage;
		}

		$t = $wgRequest->getText( "type", "" );
		if ( $t != "" ) {
			$this->mType = $t;
		}

		$this->parseType();

		if( $this->mType == "google" ) {
			$this->verifyGoogle();
		}
		else {
			$this->mTitle = SpecialPage::getTitleFor( "Sitemap", $subpage );
			$this->getNamespacesList();
			if ( $this->mType == "namespace" ) {
				$this->generateNamespace();
			}
			else if($subpage == 'sitemap-index.xml') {
				$this->generateIndex();
			}
			else {
				$this->print404();
			}
		}
	}

	/**
	 * get all namespaces, take them from article so will only have
	 * pages for existed namespaces
	 *
	 * @access public
	 */
	public function getNamespacesList() {
		global $wgSitemapNamespaces;

		if ( is_array( $wgSitemapNamespaces ) ) {
			$this->mNamespaces = $wgSitemapNamespaces;
			return;
		}

		$excludeList = array(NS_USER, NS_PROJECT, NS_MEDIAWIKI, NS_TEMPLATE, NS_HELP, 110, 1100, 1200, 1202);

		wfProfileIn( __METHOD__ );
		$dbr = wfGetDB( DB_SLAVE, "vslow" );
		$res = $dbr->select(
			'page',
			array( 'page_namespace' ),
			array(),
			__METHOD__,
			array(
				'GROUP BY' => 'page_namespace',
				'ORDER BY' => 'page_namespace',
			)
		);


		while ( $row = $dbr->fetchObject( $res ) ) {
			if( $row->page_namespace >= 0 ) {

				if ( !in_array($row->page_namespace, $excludeList ) ) {
					if (  $row->page_namespace%2 != 1 ) {
						$this->mNamespaces[] = $row->page_namespace;
					}
				}

			}
		}
		wfProfileOut( __METHOD__ );

		return $this->mNamespaces;
	}


	/**
	 * compare provided hex with local configuration
	 *
	 * @access private
	 */
	private function verifyGoogle() {
		global $wgGoogleSiteVerification, $wgGoogleSiteVerificationAlwaysValid, $wgOut;

		$wgOut->disable();

		$out = "";
		if( $wgGoogleSiteVerification == $this->mGoogleCode ||
			$wgGoogleSiteVerificationAlwaysValid ) {
			header( "Cache-Control: public, max-age=3600", true );
			$out .= "google-site-verification: google{$this->mGoogleCode}.html";
		}
		else {
			header( "Cache-Control: no-cache" );
			header( "HTTP/1.0 404 Not Found" );
			$out .= "go away";
		}
		print $out;
	}

	/**
	 * parse type and set mType and mNamespace
	 */
	private function parseType() {
		/**
		 * requested files are named like sitemap-wikicities-NS_150-0.xml.gz
		 * index is named like sitemap-index-wikicities.xml
		 */
		if ( preg_match( "/^sitemap\-.+NS_(\d+)\-(\d+)/", $this->mType, $match ) ) {
			$this->mType = "namespace";
			$this->mNamespace = $match[ 1 ];
			$this->mPage = $match[ 2 ];
		}
		elseif( preg_match( "/^google([0-9a-f]{16}).html$/", $this->mType, $match ) ) {
			$this->mType = "google";
			$this->mGoogleCode = $match[ 1 ];
		}
		else {
			$this->mType = "index";
			$this->mNamespace = false;
		}
	}

	/**
	 * generate xml with index file
	 *
	 * @access private
	 */
	private function generateIndex() {
		global $wgServer, $wgOut, $wgMemc, $wgContentNamespaces;

		wfProfileIn( __METHOD__ );

		$timestamp = wfTimestamp( TS_ISO_8601, wfTimestampNow() );
		$id = wfWikiID();

		$wgOut->disable();

		$out = "";
		$out .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$out .= sprintf( "<!-- generated on fly by %s -->\n", $this->mTitle->getFullURL() );
		$out .= "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

		header( "Content-type: application/xml; charset=UTF-8" );
		header( "Cache-control: max-age=86400", true );

		$index = $wgMemc->get( wfMemcKey( "sitemap-index") );
		if( is_array( $index ) ) {
			foreach( $index as $namespace => $pages ) {
				$cnt = 0;
				foreach( $pages as $page ) {
					$out .= sprintf( "\t<!-- page %d -->\n", $cnt );
					$out .= "\t<sitemap>\n";
					$out .= "\t\t<loc>{$wgServer}/sitemap-{$id}-NS_{$namespace}-{$cnt}.xml.gz</loc>\n";
					$out .= "\t\t<lastmod>{$timestamp}</lastmod>\n";
					$out .= "\t</sitemap>\n";
					$cnt++;
				}
			}
		}
		else {
			$this->getNamespacesList();
			foreach ( $this->mNamespaces as $namespace ) {
				$out .= "\t<sitemap>\n";
				$out .= "\t\t<loc>{$wgServer}/sitemap-{$id}-NS_{$namespace}-0.xml.gz</loc>\n";
				$out .= "\t\t<lastmod>{$timestamp}</lastmod>\n";
				$out .= "\t</sitemap>\n";
			}
		}

		$out .= "</sitemapindex>\n";

		wfProfileOut( __METHOD__ );

		print $out;
	}

	/**
	 * @access private
	 */
	private function generateNamespace() {
		global $wgServer, $wgOut, $wgMemc;

		$dbr = wfGetDB( DB_SLAVE, "vslow" );

		$wgOut->disable();

		header( "Content-type: application/x-gzip" );
		header( "Cache-control: max-age=86400", true );

		$out = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$out .= sprintf( "<!-- generated on the fly by %s -->\n", $this->mTitle->getFullURL() );

		$scope = array( 'page_namespace' => $this->mNamespace );
		$index = $wgMemc->get( wfMemcKey( "sitemap-index") );
		if( isset( $index[ $this->mNamespace ] [ $this->mPage ] ) ) {
			$scope[] = sprintf( "page_id BETWEEN %d AND %d",
				$index[ $this->mNamespace ] [ $this->mPage ][ "start" ],
				$index[ $this->mNamespace ] [ $this->mPage ][ "end" ]
			);
			$out .= sprintf( "<!-- pages from %d to %d -->\n",
				$index[ $this->mNamespace ] [ $this->mPage ][ "start" ],
				$index[ $this->mNamespace ] [ $this->mPage ][ "end" ]
			);
		}
		$sth = $dbr->select(
			'page',
			array(
				'page_namespace',
				'page_title',
				'page_touched',
			),
			$scope,
			__METHOD__,
			array( "ORDER BY" => "page_id" )
		);

		$includeVideo = (bool) F::app()->wg->EnableVideoSitemaps;
		if( $includeVideo && !in_array( $this->mNamespace, $this->mVideoNamespaces ) ) {
			$includeVideo = false;
		}

		$out .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"" . ( $includeVideo ? ' xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"' : '' ) . ">\n";
		while ( $row = $dbr->fetchObject( $sth ) ) {
			$size = strlen( $out );
			$title = Title::makeTitle( $row->page_namespace, $row->page_title );
			$stamp = wfTimestamp( TS_ISO_8601, $row->page_touched );
			$prior = isset( $this->mPriorities[ $row->page_namespace ] )
				? $this->mPriorities[ $row->page_namespace ]
				: "0.5";

			$entry = $this->titleEntry( $title, $stamp, $prior, $includeVideo );

			/**
			 * break if it's to big
			 */
			if ( strlen( $entry ) + $size > $this->mSizeLimit ) {
				break;
			}

			$out .= $entry;
		}
		$out .= "</urlset>\n";

		print gzencode( $out );
	}

	private function titleEntry( Title $title, $date, $priority, $includeVideo = false ) {
		return
			"\t<url>\n" .
			"\t\t<loc>{$title->getFullURL()}</loc>\n" .
			"\t\t<lastmod>$date</lastmod>\n" .
			"\t\t<priority>$priority</priority>\n" .
			( $includeVideo ? $this->videoEntry( $title ) : "" ) .
			"\t</url>\n";
	}

	private function videoEntry( Title $title ) {
		$entries = array();

		$articleVideos = $this->mMediaService->getMediaFromArticle( $title, MediaQueryService::MEDIA_TYPE_VIDEO );

		foreach( $articleVideos as $videoTitleData ) {
			$metaData = $videoTitleData['meta'];
			if($metaData['canEmbed'] === 0) {
				continue;
			}
			$entry =
					"\t\t<video:video>\n" .
					"\t\t\t<video:title>{$metaData['title']}</video:title>\n" .
					"\t\t\t<video:description>{$metaData['description']}</video:description>\n" .
					( !empty($videoTitleData['thumbUrl']) ? "\t\t\t<video:thumbnail_loc>{$videoTitleData['thumbUrl']}</video:thumbnail_loc>\n" : "" ) .
					( ( $metaData['srcType'] == 'player') ? "\t\t\t<video:player_loc allow_embed=\"yes\" autoplay=\"{$metaData['autoplayParam']}\">{$metaData['srcParam']}</video:player_loc>\n" :
							"\t\t\t<video:content_loc>{$metaData['srcParam']}</video:content_loc>\n" ) .
					( !empty($metaData['duration']) ? "\t\t\t<video:duration>{$metaData['duration']}</video:duration>\n" : "" ) .
					"\t\t\t<video:family_friendly>yes</video:family_friendly>\n" .
					"\t\t</video:video>\n";

			$entries[] = $entry;
		}

		return implode("\t\n", $entries);
	}

	public function cachePages( $namespace ) {
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE, "vslow" );
		$sth = $dbr->select(
			array( "page" ),
			array( "page_title, page_id, page_namespace" ),
			array( "page_namespace" => $namespace ),
			__METHOD__,
			array( "ORDER BY" => "page_id" )
		);
		$pCounter = 0; // counter for pages in index
		$rCounter = 0; // counter for rows (titles)
		$index = array();
		$index[ $pCounter ] = array( );
		$last  = 0;
		while( $row = $dbr->fetchObject( $sth ) ) {
			if( empty( $index[ $pCounter ][ "start" ] )  ) {
				$index[ $pCounter ][ "start" ] = $row->page_id;
			}
			$rCounter++;
			if( $rCounter >= $this->mLinkLimit ) {
				$index[ $pCounter ][ "end" ] = $row->page_id;
				$pCounter++;
				$rCounter = 0;
				$index[ $pCounter ] = array( );
			}
			$last = $row->page_id;
		}
		if( empty( $index[ $pCounter ][ "end" ] ) ) {
			$index[ $pCounter ][ "end" ] = $last;
		}
		wfProfileOut( __METHOD__ );

		return $index;
	}

	/**
	 * show 404
	 *
	 * @access private
	 */
	private function print404() {
		global $wgOut;

		$wgOut->disable();

		$out = "";
		header( "Cache-Control: no-cache" );
		header( "HTTP/1.0 404 Not Found" );
		$out .= "404: Page doesn't exist";
		print $out;
	}
}
