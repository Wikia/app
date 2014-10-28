<?php

/**
* Maintenance script to clear varnish cache for article pages for the wiki
* @author Saipetch Kongkatong
*/

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Class purgeArticlePages
 */
class purgeArticlePages extends Maintenance {

	protected $dryRun  = false;
	protected $success = 0;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Set wiki factory variable";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'wikiId', 'Wiki Id', false, true, 'w' );
		$this->addOption( 'limit', 'Page limit. Set to -1 for all pages. Default: 20K pages', false, false, 'l' );
	}

	public function execute() {
		$this->dryRun = $this->hasOption( 'dry-run' );
		$this->verbose = $this->hasOption( 'verbose' );
		$wikiId = $this->getOption( 'wikiId', '' );

		if ( empty( $wikiId ) ) {
			die( "Error: Empty wiki id.\n" );
		}

		$dbname = WikiFactory::IDtoDB( $wikiId );
		if ( empty( $dbname ) ) {
			die( "Error: Cannot find dbname.\n" );
		}

		$pageLimit = 20000;
		$totalLimit = $this->getOption( 'limit', $pageLimit );
		if ( empty( $totalLimit ) || $totalLimit < -1 ) {
			die( "Error: invalid limit.\n" );
		}

		if ( $totalLimit == -1 ) {
			$totalLimit = $this->getTotalPages( $dbname );
		}

		$maxSet = ceil( $totalLimit / $pageLimit );
		$limit = ( $totalLimit > $pageLimit ) ? $pageLimit : $totalLimit;

		$totalPages = 0;
		for ( $set = 1; $set <= $maxSet; $set++ ) {
			$cnt = 0;
			if ( $set == $maxSet ) {
				$limit = $totalLimit - ( $pageLimit * ( $set - 1 ) );
			}
			$offset = ( $set - 1 ) * $pageLimit;
			$pages = $this->getAllPages( $dbname, $limit, $offset );
			$total = count( $pages );
			foreach ( $pages as $page ) {
				$cnt++;
				echo "Wiki $wikiId - Page $page[id] [$cnt of $total, set $set of $maxSet]: ";
				$title = GlobalTitle::newFromId( $page['id'], $wikiId );
				if ( $title instanceof GlobalTitle ) {
					$url = $title->getFullURL();
					echo "$url\n";
					if ( !$this->dryRun ) {
						SquidUpdate::purge( [$url] );
					}
					$this->success++;
				} else {
					echo "ERROR: Cannot find global title for $page[title]\n";
				}
			}

			$totalPages = $totalPages + $total;
		}

		echo "\nWiki $wikiId: Total pages: $totalPages, Success: {$this->success}, Failed: ".( $totalPages - $this->success )."\n\n";
	}

	/**
	 * Get all article page
	 * @param string $dbname
	 * @param integer $limit
	 * @param integer $offset
	 * @return array $pages - list of article pages
	 */
	protected function getAllPages( $dbname, $limit, $offset ) {
		$db = wfGetDB( DB_SLAVE, [], $dbname );
		$pages = ( new WikiaSQL() )
			->SELECT( '*' )
			->FROM( 'page' )
			->WHERE( 'page_namespace' )->EQUAL_TO( NS_MAIN )
			->ORDER_BY( 'page_id' )
			->LIMIT( $limit )
			->OFFSET( $offset )
			->runLoop( $db, function( &$pages, $row ) {
				$pages[] = [
					'id' => $row->page_id,
					'title' => $row->page_title
				];
			});

		return $pages;
	}

	/**
	 * Get the total number of article pages
	 * @param string $dbname
	 * @return integer $totalPages
	 */
	protected function getTotalPages( $dbname ) {
		$db = wfGetDB( DB_SLAVE, [], $dbname );
		$totalPages = ( new WikiaSQL() )
			->SELECT( 'count(*) cnt' )
			->FROM( 'page' )
			->WHERE( 'page_namespace' )->EQUAL_TO( NS_MAIN )
			->ORDER_BY( 'page_id' )
			->run( $db, function( $result ) {
				$row = $result->fetchObject();
				$cnt = empty( $row ) ? 0 : $row->cnt;
				return $cnt;
			});

		return $totalPages;
	}

}

$maintClass = "purgeArticlePages";
require_once( RUN_MAINTENANCE_IF_MAIN );
