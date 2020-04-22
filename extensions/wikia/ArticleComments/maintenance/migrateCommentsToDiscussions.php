<?php
// 0. Enable ReadOnly mode
// 1. Get pages with comments
// 1.1 select DISTINCT SUBSTRING_INDEX(page_title, "/@comment-", 1) as db_key, page_namespace from
//     page where page_namespace in (${commentsNamespaces}) and page_title like '%@comment-%'
// 1.2 map namespace from talk to page namespace MWNamespaces::getSubject
// 1.3 map page name to parent page id (db query)
// 1.4 create Title objects from page ids
// 1.5 get deleted comments for last 3 months from archive table?
// 2 Get comments for titles (ArticleCommentList class?)
// 3 Save it to discussions

/**
 * migrates article comments data to discussions service, see https://wikia-inc.atlassian.net/browse/IW-3046
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class MigrateCommentsToDiscussions extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "migrates article comments data to discussions service";
	}

	public function execute() {
		global $wgEnableArticleCommentsExt, $wgSitename;

		if ( empty( $wgEnableArticleCommentsExt ) ) {
			$this->output( "\nArticleComments not enabled for $wgSitename" );
			return;
		}

		// TODO: switch comments to read-only state

		$pagesWithComments = $this->getPagesWithComments();

		if ( empty( $pagesWithComments ) ) {
			$this->output( "\nNo pages with comments for $wgSitename" );
			return;
		}

		$commentsForPage = $this->getCommentsForPage( 'Comments_test', 1);
		var_dump($commentsForPage);

		$this->output("\n\n");
	}

	/**
	 * Gets pages that have comments
	 * @return array of arrays [ 'db_key' => string, 'ns' => int ]
	 * @throws DBUnexpectedError
	 */
	private function getPagesWithComments(): array {
		global $wgArticleCommentsNamespaces, $wgContentNamespaces;

		$namespaces = array_map(function($ns) {
			return MWNamespace::getTalk($ns);
		}, empty($wgArticleCommentsNamespaces) ? $wgContentNamespaces : $wgArticleCommentsNamespaces);

		$dbr = wfGetDB( DB_SLAVE );
		// extract titles of pages with comments from comment page titles of such structure
		// <page-title>/@comment-<user-id>-<timestamp>
		// or in case of reply
		// <page-title>/@comment-<user-id>-<timestamp>/@comment-<user-id>-<timestamp>
		$res = $dbr->select(
			'page',
			['SUBSTRING_INDEX(page_title, "/@comment-", 1) as db_key', 'page_namespace as ns'],
			[
				'page_namespace' => $namespaces,
				"page_title like '%@comment-%'",
			],
			__METHOD__,
			[ 'DISTINCT' ]
		);

		$result = [];
		while ( $row = $res->fetchRow() ) {
			$result[] = [
				'db_key' => $row['db_key'],
				'ns' => MWNamespace::getSubject( $row['ns'] ),
			];
		}
		$res->free();

		return $result;
	}

	/**
	 * @param string $dbKey
	 * @param int $ns
	 * @return array|bool|Object
	 * @throws DBUnexpectedError
	 */
	private function getCommentsForPage( string $dbKey, int $ns ) {
		global $wgMemc;

		$memckey = self::getCacheKey( $dbKey, $ns );

		$commentsAll = $wgMemc->get( $memckey );

		if ( empty( $commentsAll ) ) {
			$pages = [ ];
			$subpages = [ ];
			$dbr = wfGetDB( DB_SLAVE );

			$table = [ 'page' ];
			$vars = [ 'page_id', 'page_title' ];
			$conds = [
				"page_title" . $dbr->buildLike( sprintf( "%s/%s", $dbKey, ARTICLECOMMENT_PREFIX ), $dbr->anyString() ),
				$namspace = MWNamespace::getTalk( $ns )
			];
			$options = [ 'ORDER BY' => 'page_id' ];

			$res = $dbr->select( $table, $vars, $conds, __METHOD__, $options );

			$helperArray = [];
			while ( $row = $dbr->fetchObject( $res ) ) {
				$parts = ArticleComment::explode( $row->page_title );
				$p0 = $parts['partsStripped'][0];

				if ( count( $parts['partsStripped'] ) == 2 ) {
					// push comment replies aside, we'll merge them later
					$subpages[$p0][$row->page_id] = $row->page_id;
				} else {
					// map title to page_id
					$helperArray[$p0] = $row->page_id;

					$pages[$row->page_id]['level1'] = $row->page_id;
				}
			}
			// attach replies to comments
			foreach ( $subpages as $p0 => $level2 ) {
				if ( !empty( $helperArray[$p0] ) ) {
					$idx = $helperArray[$p0];
					$pages[$idx]['level2'] = array_reverse( $level2, true );
				} else {
					// if its empty it's an error in our database
					// someone removed a parent and left its children
					// or someone removed parent and children and
					// restored children or a child without restoring parent
					// --nAndy
				}
			}

			$dbr->freeResult( $res );
			$commentsAll = $pages;
		}

		return $commentsAll;
	}

	static private function getCacheKey( string $dbKey, int $ns ) {
		return wfMemcKey( 'articlecomment', 'comm', md5( $dbKey . $ns . ArticleCommentList::CACHE_VERSION ) );
	}
}

$maintClass = MigrateCommentsToDiscussions::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
