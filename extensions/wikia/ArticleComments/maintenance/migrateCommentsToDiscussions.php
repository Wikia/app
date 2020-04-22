<?php

/**
 * migrates article comments data to discussions service, see https://wikia-inc.atlassian.net/browse/IW-3046
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class MigrateCommentsToDiscussions extends Maintenance {
	/**
	 * @var DatabaseBase|null
	 */
	private $dbc;

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

//		$this->dbc = self::getDiscussionConnection();

		foreach ( $pagesWithComments as $p ) {
			$title = Title::newFromText( $p['db_key'], $p['ns'] );
			$commentsForPage = $this->getCommentsForPage( $p['db_key'], $p['ns'] );

		}
		$commentsForPage = $this->getCommentsForPage( 'Comments_test', 1);
		var_dump($commentsForPage);

		$this->output("\n\n");
	}

	/**
	 * @param Title $articleTitle
	 * @param array $comments
	 * [
	 *  560 => [
		 'level1' => "560",
		 'level2' => [
		   564 => "564",
		   563 => "563"
		 ]
		]
	 */
	private function migrateComments( Title $articleTitle, array $comments ) {
		// get data for comments based on provided page ids of comments on first and second level
		// transaction start
		// create thread
		// create replies
		// update first post id in thread
		// update post count in thread
		// transaction end
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
	 * based on ArticleCommentsList::getCommentList
	 *
	 * @param string $dbKey
	 * @param int $ns
	 * @return array
	 * @throws DBUnexpectedError
	 */
	private function getCommentsForPage( string $dbKey, int $ns ): array {
		global $wgMemc;

		$memckey = self::getCacheKey( $dbKey, $ns );

		$commentsAll = $wgMemc->get( $memckey );

		if ( empty( $commentsAll ) ) {
			$pages = [];
			$subpages = [];
			$dbr = wfGetDB( DB_SLAVE );

			$res = $dbr->select(
				'page',
				[ 'page_id', 'page_title' ],
				[
					"page_title" . $dbr->buildLike( sprintf( "%s/%s", $dbKey, ARTICLECOMMENT_PREFIX ), $dbr->anyString() ),
					$namspace = MWNamespace::getTalk( $ns )
				],
				__METHOD__,
				[ 'ORDER BY' => 'page_id' ]
			);

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

	private static function getCacheKey( string $dbKey, int $ns ) {
		return wfMemcKey( 'articlecomment', 'comm', md5( $dbKey . $ns . ArticleCommentList::CACHE_VERSION ) );
	}

	private function createThread( int $articleId, int $userId, string $createdAt ): int {
		global $wgCityId;

		// create new thread
		$this->dbc->insert(
			'thread',
			[
				'site_id' => $wgCityId,
				'created_by' => $userId,
				'created_at' => $createdAt,
				'container_type' => 'ARTICLE_COMMENT',
				'container_id' => $articleId,
				'first_post_id' => 0, // will be filled later
				'source' => 17, // hardcoded in discussions service as wall import
			],
			__METHOD__
		);

		// fetch threadId and return it
		return $this->dbc->insertId();
	}

	/**
	 * Create reply in `post` and` post_revision` and update `post.post_revision_id` accordingly
	 *
	 * @param string $threadId
	 * @param int $userId
	 * @param string $ipAddress
	 * @param string $createdAt
	 * @param string $html
	 * @param int position - index in thread
	 *
	 * @return string postId
	 */
	private function createReply( $threadId, $userId, $ipAddress, $createdAt, $html, $position ) {
		global $wgCityId;

		$storedIpAddress = empty( $ipAddress ) ? null : inet_pton( $ipAddress );
		if ( $storedIpAddress === false ) {
			// Store explicitly as NULL
			$storedIpAddress = null;
		}

		// create reply, cache the Id
		$this->dbc->insert(
			'post',
			[
				'site_id' => $wgCityId,
				'created_by' => $userId,
				'created_ip' => $storedIpAddress,
				'created_at' => $createdAt,
				'thread_id' => $threadId,
				'position' => $position,
			],
			__METHOD__
		);

		// fetch reply Id
		$replyId = $this->dbc->insertId();

		// create revision, fetch the Id
		$this->dbc->insert(
			'post_revision',
			[
				'created_by' => $userId,
				'created_at' => $createdAt,
				'created_ip' => $storedIpAddress,
				'post_id' => $replyId,
				'raw_content' => '',
				'rendered_content' => $html,
			],
			__METHOD__
		);

		// fetch reply Id
		$revisionId = $this->dbc->insertId();

		// update reply with revision Id
		$this->dbc->update(
			'post',
			[
				'revision_id' => $revisionId,
			],
			[
				'id' => $replyId,
			],
			__METHOD__
		);

		// return reply Id
		return $replyId;
	}

	/**
	 * Update `thread` with proper `first_post_id` for first reply
	 *
	 * @param string $threadId
	 * @param string $replyId
	 */
	private function updateFirstPostId( $threadId, $replyId ) {
		$this->dbc->update(
			'thread',
			[
				'first_post_id' => $replyId,
			],
			[
				'id' => $threadId,
			],
			__METHOD__
		);
	}

	/**
	 * Update the `thread` table with proper post counter
	 */
	private function updateThreadsWithReplyCount( $threadId ) {
		$postCount = $this->dbc->selectRowCount(
			'post',
			'1',
			[
				'thread_id' => $threadId,
				'deleted_ind' => 0,
			],
			__METHOD__
		);
		$this->dbc->update(
			'thread',
			[
				'post_count' => $postCount,
			],
			[
				'id' => $threadId,
			],
			__METHOD__
		);
	}

	/**
	 * Get discussions' connection
	 */
	private static function getDiscussionConnection( ) {
		return \DatabaseBase::factory('mysql', [
			'host' => $_ENV['MESSAGE_WALL_MIGRATION_HOST'],
			'user' => $_ENV['MESSAGE_WALL_MIGRATION_USER'],
			'password' => $_ENV['MESSAGE_WALL_MIGRATION_PASSWORD'],
			'dbname' => self::getDiscussionShard(),
		]);
	}

	/**
	 * Get the shard number (db name) for current wiki
	 */
	private static function getDiscussionShard() {
		global $wgCityId;
		$dbc = DatabaseBase::factory('mysql', [
			'host' => $_ENV['MESSAGE_WALL_MIGRATION_HOST'],
			'user' => $_ENV['MESSAGE_WALL_MIGRATION_USER'],
			'password' => $_ENV['MESSAGE_WALL_MIGRATION_PASSWORD'],
			'dbname' => 'discussion_config',
		]);
		$row = $dbc->selectRow(
			[
				'sh' => 'shard',
				'si' =>'site',
			],
			[ 'sh.schema_name' ],
			[
				'si.id' => $wgCityId,
			],
			__METHOD__,
			[],
			[
				'si' => [ 'LEFT JOIN', [ 'sh.id = si.shard_id' ] ],
			]
		);
		return $row->schema_name;
	}
}

$maintClass = MigrateCommentsToDiscussions::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
