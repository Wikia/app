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

	const BLOBS_TABLE_NAME = 'sitemap_blobs';

	/**
	 * For video-extended sitemaps, we query Solr to find out which file pages with videos are
	 * indexed in it. This is a limit for this query. If the limit is exceeded, the optimization
	 * is disabled and we query Solr for each of the file pages with videos separately.
	 *
	 * @see SitemapPage::hasSnippet
	 */
	const SOLR_LIMIT = 10000;

	private $mType, $mTitle, $mNamespaces, $mNamespace, $mPriorities,
		$mSizeLimit, $mPage;

	/**
	 * @var MediaQueryService
	 */
	private $mMediaService;
	public $mCacheTime;

	/**
	 * standard constructor
	 * @access public
	 * @param $name
	 */
	public function __construct( $name = 'Sitemap' ) {
		parent::__construct( $name );

		$this->mPriorities = [
			// MediaWiki standard namespaces
			NS_MAIN => '1.0',
			NS_FILE => '0.5',
			NS_CATEGORY => '1.0',
		];

		$this->mSizeLimit = ( pow( 2, 20 ) * 10 ) - 20; // safe margin
		$this->mLinkLimit = 5000;
		$this->mPage = 0;
		$this->mCacheTime = 86400 * 14; // cron is run every week but we want to keep them longer
		$this->mMediaService = new MediaQueryService();
	}


	/**
	 * Main entry point
	 *
	 * @access public
	 *
	 * @param $subpage Mixed: subpage of SpecialPage
	 */
	public function execute( $subpage ) {
		global $wgMemc, $wgRequest, $wgOut;

		if ( !is_array( $wgMemc->get( wfMemcKey( 'sitemap-index' ) ) ) ) {
			$wgOut->disable();
			header( 'HTTP/1.1 500 Internal Server Error' );
			echo '<h1>500 Internal Server Error</h1>' . PHP_EOL;
			echo '<p>Sitemap not available. Please check again later.</p>' . PHP_EOL;
			return;
		}

		/**
		 * subpage works as type param, param has precedence, default is "index"
		 */
		$this->mType = 'index';
		if ( !empty( $subpage ) ) {
			$this->mType = $subpage;
		}

		$t = $wgRequest->getText( 'type', '' );
		if ( $t != '' ) {
			$this->mType = $t;
		}

		$this->parseType();

		// cache on both CDN and client
		header( 'Cache-Control: s-maxage=86400', true );
		header( 'X-Pass-Cache-Control: public, max-age=86400', true );
		header( 'X-Robots-Tag: noindex' );

		$this->mTitle = SpecialPage::getTitleFor( 'Sitemap', $subpage );
		$this->getNamespacesList();
		if ( $this->mType == 'namespace' ) {
			$wgOut->disable();

			header( 'Content-type: application/x-gzip' );
			print $this->generateNamespace();
		} else if ( $subpage == 'sitemap-index.xml' ) {
			$this->generateIndex();
		} else {
			$this->print404();
		}
	}

	/**
	 * get all namespaces, take them from article so will only have
	 * pages for existed namespaces
	 *
	 * @return array
	 * @access public
	 */
	public function getNamespacesList() {
		global $wgContLang;

		$excludeList = [ NS_USER, NS_PROJECT, NS_MEDIAWIKI, NS_TEMPLATE, NS_HELP, 110, 1100, 1200, 1202 ];

		$nsIds = $wgContLang->getNamespaceIds();
		$sitemapNsIds = array_filter( $nsIds, function ( $id ) use ( $excludeList ) {
			// Exclude negative namespaces
			if ( $id < 0 ) {
				return false;
			}

			// Exclude talk pages
			if ( $id % 2 !== 0 ) {
				return false;
			}

			// Exclude namespaces from $excludeList:
			if ( in_array( $id, $excludeList ) ) {
				return false;
			}

			return true;
		} );

		$dbr = wfGetDB( DB_SLAVE, 'vslow' );
		$res = $dbr->select(
			'page',
			[ 'page_namespace' ],
			[ 'page_namespace' => $sitemapNsIds ],
			__METHOD__,
			[
				'GROUP BY' => 'page_namespace',
				'ORDER BY' => 'page_namespace',
			]
		);

		while ( $row = $dbr->fetchObject( $res ) ) {
			$this->mNamespaces[] = $row->page_namespace;
		}

		return $this->mNamespaces;
	}

	/**
	 * parse type and set mType and mNamespace
	 */
	private function parseType() {
		/**
		 * requested files are named like sitemap-wikicities-NS_150-0.xml.gz
		 * index is named like sitemap-index-wikicities.xml
		 */
		if ( preg_match( '/^sitemap\-.+NS_(\d+)\-(\d+)/', $this->mType, $match ) ) {
			$this->mType = 'namespace';
			$this->mNamespace = $match[1];
			$this->mPage = $match[2];
		} else {
			$this->mType = 'index';
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

		$timestamp = wfTimestamp( TS_ISO_8601, wfTimestampNow() );
		$id = wfWikiID();

		$wgOut->disable();

		$out = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$out .= "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

		header( 'Content-type: application/xml; charset=UTF-8' );
		header( 'Cache-control: max-age=86400', true );

		$index = $wgMemc->get( wfMemcKey( 'sitemap-index' ) );
		if ( is_array( $index ) ) {
			foreach ( $index as $namespace => $pages ) {
				$cnt = 0;
				foreach ( $pages as $page ) {
					$out .= sprintf( "\t<!-- page %d -->\n", $cnt );
					$out .= "\t<sitemap>\n";
					$out .= "\t\t<loc>{$wgServer}/sitemap-{$id}-NS_{$namespace}-{$cnt}.xml.gz</loc>\n";
					$out .= "\t\t<lastmod>{$timestamp}</lastmod>\n";
					$out .= "\t</sitemap>\n";
					$cnt++;
				}
			}
		} else {
			$this->getNamespacesList();
			foreach ( $this->mNamespaces as $namespace ) {
				$out .= "\t<sitemap>\n";
				$out .= "\t\t<loc>{$wgServer}/sitemap-{$id}-NS_{$namespace}-0.xml.gz</loc>\n";
				$out .= "\t\t<lastmod>{$timestamp}</lastmod>\n";
				$out .= "\t</sitemap>\n";
			}
		}

		$out .= "</sitemapindex>\n";

		print $out;
	}

	/**
	 * generate and return sitemap for mNamespace and mPage (gzip-ed)
	 * @access private
	 */
	private function generateNamespace( Array $sitemapIndex = null, $forceUpdate = false ) {
		global $wgMemc;

		if ( !$forceUpdate ) {
			$namespaceSitemap = $this->generateNamespaceFromDb();
			if ( !empty( $namespaceSitemap ) ) {
				// this sitemap was pre-generated by the maintenance script and stored in db
				/*
				 * We have to decode sitemap, change localhost urls to real wiki url
				 * and encode it again
				 * because on maintenance level we do not know what domain we should use
				 */
				return gzencode( str_replace( 'http://localhost/', 'http://' . $_SERVER['SERVER_NAME'] . '/', gzdecode( $namespaceSitemap ) ) );
			}
		}
		$startTime = microtime( true );

		$dbr = wfGetDB( DB_SLAVE, 'vslow' );

		$out = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

		$scope = [
			'page_namespace' => $this->mNamespace,
			'page_is_redirect' => false,
		];

		$index = is_array( $sitemapIndex ) ? $sitemapIndex : $wgMemc->get( wfMemcKey( 'sitemap-index' ) );
		if ( isset( $index[$this->mNamespace][$this->mPage] ) ) {
			$scope[] = sprintf( 'page_id BETWEEN %d AND %d',
				$index[$this->mNamespace][$this->mPage]['start'],
				$index[$this->mNamespace][$this->mPage]['end']
			);
			$out .= sprintf( "<!-- pages from %d to %d -->\n",
				$index[$this->mNamespace][$this->mPage]['start'],
				$index[$this->mNamespace][$this->mPage]['end']
			);
		}

		$sth = $dbr->select(
			'page',
			[
				'page_namespace',
				'page_title',
				'page_touched',
				'page_id',
			],
			$scope,
			__METHOD__,
			[
				'ORDER BY' => 'page_id',
				'USE INDEX' => 'PRIMARY', # PLATFORM-1286
			]
		);

		$includeVideo = F::app()->wg->EnableVideoSitemaps && $this->mNamespace == NS_FILE;

		$out .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"" . ( $includeVideo ? ' xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"' : '' ) . ">\n";
		while ( $row = $dbr->fetchObject( $sth ) ) {
			$size = strlen( $out );
			$entry = $this->titleEntry( $row, $includeVideo );

			/**
			 * break if it's to big
			 */
			if ( strlen( $entry ) + $size > $this->mSizeLimit ) {
				break;
			}

			$out .= $entry;
		}
		$out .= "</urlset>\n";
		$endTime = microtime( true );
		$out .= "<!-- Generating time: " . ( $endTime - $startTime ) . " sec - " . date( 'Y-m-d H:i:s' ) . " -->\n";

		return gzencode( $out );
	}

	private function generateNamespaceFromDb() {
		$dbr = wfGetDB( DB_SLAVE );
		if ( $dbr->tableExists( self::BLOBS_TABLE_NAME ) ) {
			$sitemapContent = $dbr->selectField(
				self::BLOBS_TABLE_NAME,
				'sbl_content',
				[
					'sbl_ns_id' => $this->mNamespace,
					'sbl_page_id' => $this->mPage
				],
				__METHOD__
			);
		} else {
			$sitemapContent = null;
		}

		return $sitemapContent;
	}

	private function storeNamespaceToDb( $sitemapNamespaceContent ) {
		$dbr = wfGetDB( DB_MASTER );
		if ( $dbr->tableExists( self::BLOBS_TABLE_NAME ) ) {
			$dbr->replace(
				self::BLOBS_TABLE_NAME,
				null,
				[
					'sbl_ns_id' => $this->mNamespace,
					'sbl_page_id' => $this->mPage,
					'sbl_content' => $sitemapNamespaceContent
				],
				__METHOD__
			);
			$dbr->commit();
		}
	}

	private function titleEntry( $row, $includeVideo ) {
		$title = Title::makeTitle( $row->page_namespace, $row->page_title );
		$timestamp = wfTimestamp( TS_ISO_8601, $row->page_touched );
		$priority = isset( $this->mPriorities[$row->page_namespace] )
			? $this->mPriorities[$row->page_namespace]
			: '0.5';

		$videoEntry = '';
		if ( $includeVideo ) {
			$skipDescription = !$this->hasSnippet( $row->page_id );
			$videoEntry = $this->videoEntry( $title, $skipDescription );
		}

		return
			"\t<url>\n" .
			"\t\t<loc>{$title->getFullURL()}</loc>\n" .
			"\t\t<lastmod>$timestamp</lastmod>\n" .
			"\t\t<priority>$priority</priority>\n" .
			$videoEntry .
			"\t</url>\n";
	}

	private function videoEntry( Title $title, $skipDescription = false ) {
		$file = wfFindFile( $title );

		$videoTitleData = $this->mMediaService->getMediaData( $title, $skipDescription ? 0 : 500 );

		$isVideo = WikiaFileHelper::isFileTypeVideo( $file );
		if ( !$isVideo ) {
			return '';
		}

		$metaData = $videoTitleData['meta'];

		if ( ( $videoTitleData['type'] != MediaQueryService::MEDIA_TYPE_VIDEO ) || $metaData['canEmbed'] === 0 ) {
			return '';
		}

		$description = !empty( $videoTitleData['desc'] ) ? $videoTitleData['desc'] . ' ' : ( !empty( $metaData['description'] ) ? $metaData['description'] . ' ' : '' );
		$description .= $videoTitleData['title'];
		$entry =
			"\t\t<video:video>\n" .
			"\t\t\t<video:title><![CDATA[{$videoTitleData['title']}]]></video:title>\n" .
			"\t\t\t<video:description><![CDATA[{$description}]]></video:description>\n" .
			( !empty( $videoTitleData['thumbUrl'] ) ? "\t\t\t<video:thumbnail_loc>{$videoTitleData['thumbUrl']}</video:thumbnail_loc>\n" : "" ) .
			( ( $metaData['srcType'] == 'player' ) ? "\t\t\t<video:player_loc allow_embed=\"yes\" " . ( !empty( $metaData['autoplayParam'] ) ? "autoplay=\"{$metaData['autoplayParam']}\"" : "" ) . ">" . htmlentities( $metaData['srcParam'] ) . "</video:player_loc>\n" :
				"\t\t\t<video:content_loc>" . htmlentities( $metaData['srcParam'] ) . "</video:content_loc>\n" ) .
			( !empty( $metaData['duration'] ) ? "\t\t\t<video:duration>{$metaData['duration']}</video:duration>\n" : "" ) .
			"\t\t\t<video:family_friendly>yes</video:family_friendly>\n" .
			"\t\t</video:video>\n";

		return $entry;
	}

	public function cachePages( $namespace ) {
		$dbr = wfGetDB( DB_SLAVE, 'vslow' );
		$sth = $dbr->select(
			[ 'page' ],
			[ 'page_title, page_id, page_namespace' ],
			[ 'page_namespace' => $namespace ],
			__METHOD__,
			[ 'ORDER BY' => 'page_id' ]
		);
		$pCounter = 0; // counter for pages in index
		$rCounter = 0; // counter for rows (titles)
		$index = [];
		$index[$pCounter] = [];
		$last = 0;
		while ( $row = $dbr->fetchObject( $sth ) ) {
			if ( empty( $index[$pCounter]['start'] ) ) {
				$index[$pCounter]['start'] = $row->page_id;
			}
			$rCounter++;
			if ( $rCounter >= $this->mLinkLimit ) {
				$index[$pCounter]['end'] = $row->page_id;
				$pCounter++;
				$rCounter = 0;
				$index[$pCounter] = [];
			}
			$last = $row->page_id;
		}
		if ( empty( $index[$pCounter]['end'] ) ) {
			$index[$pCounter]['end'] = $last;
		}

		return $index;
	}

	public function cacheSitemap( $namespace, $sitemapIndex ) {
		$this->initDb();

		$this->mTitle = Title::newFromText( 'Sitemap', NS_SPECIAL );
		foreach ( $sitemapIndex[$namespace] as $pageNo => $data ) {
			$this->mNamespace = $namespace;
			$this->mPage = $pageNo;

			echo " `--> caching sitemap page: $namespace-$pageNo\n";
			$this->storeNamespaceToDb( $this->generateNamespace( $sitemapIndex, true ) );
		}

		return false;
	}

	private function initDb() {
		$dbr = wfGetDb( DB_MASTER );

		if ( !$dbr->tableExists( self::BLOBS_TABLE_NAME ) ) {
			$dbr->sourceFile( dirname( __FILE__ ) . '/sitemap_blobs.patch.sql' );
		}
	}

	/**
	 * show 404
	 *
	 * @access private
	 */
	private function print404() {
		global $wgOut;

		$wgOut->disable();

		header( 'HTTP/1.0 404 Not Found' );
		echo '404: Page doesn\'t exist';
	}

	/**
	 * LoadExtensionSchemaUpdates handler; set up sitemap_blobs table on install/upgrade.
	 */
	public static function onLoadExtensionSchemaUpdates( $updater = null ) {
		if ( !empty( $updater ) ) {
			$map = [
				'mysql' => 'sitemap_blobs.patch.sql',
			];

			$type = $updater->getDB()->getType();
			if ( isset( $map[$type] ) ) {
				$sql = dirname( __FILE__ ) . '/' . $map[$type];
				$updater->addExtensionTable( SitemapPage::BLOBS_TABLE_NAME, $sql );
			} else {
				throw new MWException( "Sitemap extension does not currently support $type database." );
			}
		}

		return true;
	}

	/**
	 * Query Solr (once) to find out which NS=6 pages are indexed in Solr
	 *
	 * Later we use this information to only expect a snippet for pages that are indexed in Solr.
	 * This means no querying Solr for information it doesn't have and no falling back to parsing
	 * wikitext for mostly empty pages (if they weren't empty, they would be indexed).
	 *
	 * If more there are more than self::SOLR_LIMIT documents, we'll always return true.
	 *
	 * @param $pageId
	 * @return bool
	 */
	private function hasSnippet( $pageId ) {
		global $wgCityId;

		static $pageIdsWithSnippets = null;
		static $alwaysReturnTrue = false;

		if ( is_null( $pageIdsWithSnippets ) ) {
			$pageIdsWithSnippets = [];

			$luceneQuery = sprintf( 'wid:%d AND is_image:false AND ns:%d', $wgCityId, NS_FILE );

			$config = new Wikia\Search\Config();
			$config->setDirectLuceneQuery( true );
			$config->setLimit( self::SOLR_LIMIT );
			$config->setQuery( $luceneQuery );

			$queryServiceFactory = new Wikia\Search\QueryService\Factory();
			$response = $queryServiceFactory->getFromConfig( $config )->search();

			if ( $response->getResultsNum() >= self::SOLR_LIMIT ) {
				$alwaysReturnTrue = true;
			} else {
				$results = (array)$response->getResults();

				foreach ( $results as $result ) {
					$pageId = $result->getFields()['pageid'];
					$pageIdsWithSnippets[$pageId] = true;
				}
			}
		}

		if ( $alwaysReturnTrue ) {
			return true;
		}

		return isset( $pageIdsWithSnippets[$pageId] );
	}
}
