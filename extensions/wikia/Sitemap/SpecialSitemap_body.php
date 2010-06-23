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

	private $mType, $mTitle, $mNamespaces, $mNamespace, $mPriorities;

	/**
	 * standard constructor
	 * @access public
	 */
	public function __construct( $name = "Sitemap" ) {
		parent::__construct( $name );

		$this->mPriorities = array(
			// MediaWiki standard namespaces
			NS_MAIN                 => '1.0',
			NS_TALK                 => '1.0',
			NS_USER                 => '1.0',
			NS_USER_TALK            => '1.0',
			NS_PROJECT              => '1.0',
			NS_PROJECT_TALK         => '1.0',
			NS_FILE                 => '1.0',
			NS_FILE_TALK            => '1.0',
			NS_MEDIAWIKI            => '0.5',
			NS_MEDIAWIKI_TALK       => '0.5',
			NS_TEMPLATE             => '0.5',
			NS_TEMPLATE_TALK        => '0.5',
			NS_HELP                 => '0.5',
			NS_HELP_TALK            => '0.5',
			NS_CATEGORY             => '1.0',
			NS_CATEGORY_TALK        => '1.0',
        );
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
		if( !empty( $subpage ) ) {
			$this->mType = $subpage;
		}

		$t = $wgRequest->getText( "type", "" );
		if( $t != "" ) {
			$this->mType = $t;
		}

		$this->mTitle = SpecialPage::getTitleFor( "Sitemap", $subpage );
		$this->parseType();
		$this->getNamespacesList();
		if( $this->mType == "namespace" ) {
			$this->generateNamespace();
		}
		else {
			$this->generateIndex();
		}
	}

	/**
	 * get all namespaces, take them from article so will only have
	 * pages for existed namespaces
	 */
	private function getNamespacesList() {
		global $wgSitemapNamespaces;
        if( is_array( $wgSitemapNamespaces ) ) {
            $this->mNamespaces = $wgSitemapNamespaces;
            return;
        }

		wfProfileIn( __METHOD__ );
		$dbr = wfGetDB( DB_SLAVE );
        $res = $dbr->select( 'page',
            array( 'page_namespace' ),
			array(),
            __METHOD__,
            array(
                'GROUP BY' => 'page_namespace',
                'ORDER BY' => 'page_namespace',
            )
        );

        while ( $row = $dbr->fetchObject( $res ) ) {
            $this->mNamespaces[] = $row->page_namespace;
        }
		wfProfileOut( __METHOD__ );
    }

	/**
	 * parse type and set mType and mNamespace
	 */
	private function parseType() {
		if( $this->mType === "index" || $this->mType === false ) {
			$this->mType = "index";
			$this->mNamespace = 0; // it's not used though
			return;
		}
		/**
		 * requested files are named like sitemap-wikicities-NS_150-0.xml.gz
		 * index is named like sitemap-index-wikicities.xml
		 */
		if( preg_match( "/^sitemap\-.+NS_(\d+)\-(\d+)/", $this->mType, $match ) ) {
			$this->mType = "namespace";
			$this->mNamespace = $match[ 1 ];
		}
	}

	private function generateIndex() {
		global $wgServer, $wgOut;

		$timestamp = wfTimestamp( TS_ISO_8601, wfTimestampNow() );
		$id = wfWikiID();

		$wgOut->disable();
		$wgOut->sendCacheControl();

		header( "Content-type: application/xml; charset=UTF-8" );
		$out = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$out .= sprintf( "<!-- generated on fly by %s -->", $this->mTitle->getFullURL() );
		$out .= "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		foreach( $this->mNamespaces as $namespace ) {
			$out .= "\t<sitemap>\n";
			$out .= "\t\t<loc>{$wgServer}/sitemap-{$id}-NS_{$namespace}_0.xml.gz</loc>\n";
			$out .= "\t\t<lastmod>{$timestamp}</lastmod>\n";
			$out .= "\t</sitemap>\n";
		}
		$out .= "</sitemapindex>\n";

		print $out;
	}

	/**
	 * @access private
	 */
	private function generateNamespace() {
		global $wgServer, $wgOut;

		$dbr = wfGetDB( DB_SLAVE );

		$wgOut->disable();
		$wgOut->sendCacheControl();

		header( "Content-type: application/x-gzip" );

		$out = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$out .= sprintf( "<!-- generated on fly by %s -->", $this->mTitle->getFullURL() );
		$sth = $dbr->select(
			'page',
            array(
                'page_namespace',
                'page_title',
                'page_touched',
            ),
            array( 'page_namespace' => $this->mNamespace ),
			__METHOD__
        );

		$out .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		while( $row = $dbr->fetchObject( $sth ) ) {
			$title = Title::makeTitle( $row->page_namespace, $row->page_title );
			$stamp = wfTimestamp( TS_ISO_8601, $row->page_touched );
			$prior = isset( $this->mPriorities[ $row->page_namespace ] )
				? $this->mPriorities[ $row->page_namespace ]
				: "0.5";

			$out .= $this->titleEntry( $title->getFullURL(), $stamp, $prior );
		}
		$out .= "</urlset>\n";

		print gzencode( $out );
	}

	private function titleEntry( $url, $date, $priority ) {
        return
	        "\t<url>\n" .
            "\t\t<loc>$url</loc>\n" .
            "\t\t<lastmod>$date</lastmod>\n" .
			"\t\t<priority>$priority</priority>\n" .
            "\t</url>\n";

	}
}
