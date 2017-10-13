<?php

namespace Discussions;


class SiteStatus {

	const TIME_OUT = 5;

	const TABLE_STATUS = 'discussion_migration.site_status';
	const TABLE_CITY_LIST = 'wikicities.city_list';
	const TABLE_COMMENTS = 'comments_index';
	const TABLE_PAGE = 'page';

	const STATUS_COMPLETE = 'complete';
	const STATUS_RETRY = 'retry';
	const STATUS_FAILED = 'failed';
	const STATUS_NEW = 'new';

	// How log we consider records "fresh" and not in need of a test
	const CATALOG_TTL = 24*60*60;

	private $test;
	private $verbose;

	/** @var \DatabaseBase */
	private $localDbh;
	/** @var \DatabaseBase */
	private $centralDbr;
	/** @var \DatabaseBase */
	private $centralDbw;

	private $siteId;
	private $dbName;
	private $dbMissing;

	private $hasStatusRecord = false;

	/** @var \stdClass */
	private $cityInfo;

	private $status;
	private $siteAvailable = false;
	private $discussionsEnabled = false;
	private $navigationEnabled = false;
	private $forumsEnabled = false;
	private $numThreadedForumThreads = 0;
	private $numThreadedForumPosts = 0;
	private $numWikiForumPosts = 0;

	/** @var \DateTime */
	private $lastPageEdit;
	/** @var \DateTime */
	private $discussionsFound;
	/** @var \DateTime */
	private $firstPostFound;
	/** @var \DateTime */
	private $lastMigrated;
	/** @var \DateTime */
	private $lastUpdated;

	public static function run( \DatabaseBase $db, $test = false, $verbose = false, $params = [] ) {
		$status = new SiteStatus(
			$db,
			$verbose,
			$test,
			$params[\RunOnCluster::PARAM_SITE_ID],
			$params[\RunOnCluster::PARAM_DB_NAME],
			$params[\RunOnCluster::PARAM_DB_MISSING]
		);

		// Don't do anything if this has been recently updated by this script
		if ( $status->skipCataloging() ) {
			echo( "== Cataloged recently.  Skipping ..." );
			return;
		}

		$status->update();
		$status->writeBack();
	}

	public function __construct( $localDbh, $verbose, $test, $siteId, $dbName, $dbMissing ) {
		$this->localDbh = $localDbh;
		$this->verbose = $verbose;
		$this->test = $test;
		$this->siteId = $siteId;
		$this->dbName = $dbName;
		$this->dbMissing = $dbMissing;

		$this->debug("== Checking status for site $siteId / $dbName");

		$this->load();
	}

	public function debug( $msg ) {
		if ( empty( $this->verbose ) ) {
			return;
		}

		echo $msg."\n";
	}

	private function load() {
		( new \WikiaSQL() )
			->SELECT( "*" )
			->FROM( self::TABLE_STATUS )
			->WHERE( 'site_id' )->EQUAL_TO( $this->siteId )
			->run(
				$this->getCentralDbr(),
				function( $result ) {
					/** @var \ResultWrapper|bool $result */
					if ( !is_object( $result ) ) {
						return;
					}

					$row = $result->fetchObject();
					if ( empty( $row ) ) {
						return;
					}

					$this->loadRow( $row );
				}
			);

		$this->cityInfo = \WikiFactory::getWikiByDB( $this->dbName );
	}

	private function loadRow( $row ) {
		$this->hasStatusRecord = true;
		$this->status = $row->status;
		$this->siteAvailable = $row->site_available;
		$this->discussionsEnabled = $row->discussions_enabled;
		$this->navigationEnabled = $row->navigation_enabled;
		$this->forumsEnabled = $row->forums_enabled;
		$this->numThreadedForumThreads = $row->tf_threads;
		$this->numThreadedForumPosts = $row->tf_posts;
		$this->numWikiForumPosts = $row->wf_posts;

		if ( !empty( $row->discussion_found ) ) {
			$this->discussionsFound = new \DateTime( $row->discussions_found );
		}
		if ( !empty( $row->first_post_found ) ) {
			$this->firstPostFound = new \DateTime( $row->first_post_found );
		}
		if ( !empty( $row->last_migrated ) ) {
			$this->lastMigrated = new \DateTime( $row->last_migrated );
		}
		if ( !empty( $row->last_updated ) ) {
			$this->lastUpdated = new \DateTime( $row->last_updated );
		}
		if ( !empty( $row->last_edit ) ) {
			$this->lastPageEdit = new \DateTime( $row->last_edit );
		}
	}

	public function update() {
		$this->probeSiteAvailable();
		$this->updateWikiVariables();
		$this->findExistingPosts();
		$this->findLastEdit();
		$this->probeDiscussions();
	}

	public function writeBack() {
		$this->debug( "Writing content to " . self::TABLE_STATUS );

		$statement = new \WikiaSQL();
		if ( $this->hasStatusRecord ) {
			$statement
				->UPDATE( self::TABLE_STATUS )
				->WHERE( 'site_id' )->EQUAL_TO( $this->siteId );
		} else if ( $this->siteAvailable ) {
			// Only INSERT if the site is available.  We don't do this check with UPDATE
			// so that if a site is ingested and then gets closed, we can update existing
			// records to reflect the new status (rather than have it look like it was skipped)
			$statement
				->INSERT( self::TABLE_STATUS )
				->SET( 'site_id', $this->siteId );
		} else {
			// If we don't meet either above conditions, skip writing this record.
			return;
		}

		// Conditionally set these date columns only if we've found something
		if ( !empty( $this->discussionsFound ) ) {
			$statement->SET( 'discussions_found', $this->discussionsFoundString() );
		}

		if ( !empty( $this->firstPostFound ) ) {
			$statement->SET( 'first_post_found', $this->firstPostFoundString() );
		}

		if ( !empty( $this->lastPageEdit ) ) {
			$statement->SET( 'last_edit', $this->lastPageEditString() );
		}

		$now = (new \DateTime())->format('Y-m-d H:i:s');
		$statement->SET( 'site_available', $this->siteAvailable )
			->SET( 'discussions_enabled', $this->discussionsEnabled )
			->SET( 'navigation_enabled', $this->navigationEnabled )
			->SET( 'forums_enabled', $this->forumsEnabled )
			->SET( 'tf_threads', $this->numThreadedForumThreads )
			->SET( 'tf_posts', $this->numThreadedForumPosts )
			->SET( 'wf_posts', $this->numWikiForumPosts )
			->SET( 'last_updated', $now )
			->run( $this->getCentralDbw() );
	}

	public function discussionsFoundString() {
		if ( empty( $this->discussionsFound ) ) {
			return '';
		}

		return $this->discussionsFound->format('Y-m-d H:i:s');
	}

	public function firstPostFoundString() {
		if ( empty( $this->firstPostFound ) ) {
			return '';
		}
		return $this->firstPostFound->format('Y-m-d H:i:s');
	}

	public function lastPageEditString() {
		if ( empty( $this->lastPageEdit ) ) {
			return '';
		}
		return $this->lastPageEdit->format('Y-m-d H:i:s');
	}

	private function probeSiteAvailable() {
		$this->debug( "Probing wiki site" );

		$result = ( new \WikiaSQL() )
			->SELECT( "city_flags" )
			->FROM( self::TABLE_CITY_LIST )
			->WHERE( 'city_id' )->EQUAL_TO( $this->siteId )
				->AND_( 'city_public' )->EQUAL_TO( 1 )
			->run(
				$this->getCentralDbr(),
				function(  $result ) {
					/** @var \ResultWrapper|bool $result */
					if ( !is_object( $result ) ) {
						return false;
					}

					$row = $result->fetchObject();
					if ( empty( $row ) ) {
						return false;
					}

					// Flag zero means no problem
					if ( $row->city_flags == 0 ) {
						return true;
					}

					// If there are flags, make sure this wiki isn't marked as free
					return !( $row->city_flags & \WikiFactory::FLAG_FREE_WIKI_URL );
				},
				false
			);

		// Map this to an int
		$this->siteAvailable = $result ? 1 : 0;
	}

	private function updateWikiVariables() {
		$this->debug( "Updating wiki variables." );

		// IRIS-4904 WF default is true, that's why we explicitly specify default = true
		$this->forumsEnabled = $this->getVariableValue( 'wgEnableForumExt', true );
		$this->discussionsEnabled = $this->getVariableValue( 'wgEnableDiscussions' );
		$this->navigationEnabled = $this->getVariableValue( 'wgEnableDiscussionsNavigation' );
	}

	private function findLastEdit() {
		if ( $this->dbMissing ) {
			return;
		}

		$date = ( new \WikiaSQL() )
			->SELECT( "MAX(page_touched)" )->AS_( "last_edit_date" )
			->FROM( self::TABLE_PAGE )
			->run(
				$this->localDbh,
				function ( $result ) {
					/** @var \ResultWrapper|bool $result */
					if ( !is_object( $result ) ) {
						return 0;
					}

					$row = $result->fetchObject();

					return $row ? $row->last_edit_date : '';
				},
				''
			);

		if ( empty( $date ) ) {
			$this->debug("\tCould not determine date of most recent edit" );
		} else {
			$this->debug("\tfound $date as most recent edit" );
			$this->lastPageEdit = new \DateTime( $date );
		}
	}

	private function findExistingPosts() {
		$this->debug( "Finding existing posts" );

		try {
			$this->numThreadedForumThreads = $this->findExistingThreadedForumThreads();
			$this->numThreadedForumPosts = $this->findExistingThreadedForumPosts();
			$this->numWikiForumPosts = $this->findExistingWikiForumPosts();
		} catch(\Exception $e) {
			$this->debug("\tError finding existing posts: " . $e->getMessage() );
		}
	}

	private function findExistingThreadedForumThreads() {
		if ( $this->dbMissing ) {
			return 0;
		}

		$num = ( new \WikiaSQL() )
			->SELECT( "count(*)" )->AS_( "num_posts" )
			->FROM( self::TABLE_COMMENTS )
			->LEFT_JOIN( self::TABLE_PAGE )
			->ON( 'page_id', 'comment_id' )
			->WHERE( 'parent_comment_id' )->EQUAL_TO( 0 )
			->AND_( 'archived' )->EQUAL_TO( 0 )
			->AND_( 'deleted' )->EQUAL_TO( 0 )
			->AND_( 'removed' )->EQUAL_TO( 0 )
			->AND_( 'page_namespace' )->EQUAL_TO( NS_WIKIA_FORUM_BOARD_THREAD )
			->run(
				$this->localDbh,
				function ( $result ) {
					/** @var \ResultWrapper|bool $result */
					if ( !is_object( $result ) ) {
						return 0;
					}

					$row = $result->fetchObject();
					return $row ? $row->num_posts : 0;
				},
				0
			);

		$this->debug("\tfound $num threaded forum threads" );
		return $num;
	}

	private function findExistingThreadedForumPosts() {
		if ( $this->dbMissing ) {
			return 0;
		}

		$num =
			( new \WikiaSQL() )->SELECT( "count(*)" )
				->AS_( "num_posts" )
				->FROM( self::TABLE_PAGE )
				->JOIN( self::TABLE_COMMENTS )
				->ON( 'page_id', 'comment_id' )
				->WHERE( 'page_namespace' )
				->IN( NS_WIKIA_FORUM_BOARD, NS_WIKIA_FORUM_BOARD_THREAD )
				->run( $this->localDbh, function ( $result ) {
					/** @var \ResultWrapper|bool $result */
					if ( !is_object( $result ) ) {
						return 0;
					}

					$row = $result->fetchObject();

					return $row ? $row->num_posts : 0;
				}, 0 );

		$this->debug( "\tfound $num threaded forum posts" );
		return $num;
	}

	private function findExistingWikiForumPosts() {
		if ( $this->dbMissing ) {
			return 0;
		}

		$num = ( new \WikiaSQL() )
			->SELECT( "count(comment_id)" )->AS_( "num_posts" )
			->FROM( self::TABLE_PAGE )
			->LEFT_JOIN( self::TABLE_COMMENTS )->ON( 'page_id', 'comment_id' )
			->WHERE( 'page_namespace' )->EQUAL_TO( NS_FORUM )
			->run(
				$this->localDbh,
				function ( $result ) {
					/** @var \ResultWrapper|bool $result */
					if ( !is_object( $result ) ) {
						return 0;
					}

					$row = $result->fetchObject();

					return $row ? $row->num_posts : 0;
				},
				0
			);

		$this->debug("\tfound $num wiki forum posts" );
		return $num;
	}

	private function probeDiscussions() {
		$this->debug( "Probing discussions" );

		// Assume that discussion sites don't revert back
		if ( !empty( $this->discussionsFound ) ) {
			$this->debug(
				"\tAlready found discussions on " .
				$this->discussionsFound->format('Y-m-d H:i:s')
			);
			return;
		}

		$url = $this->getDiscussionsUrl();
		$response = \Http::get( $url, self::TIME_OUT,
			[
				'returnInstance' => true,
			    'followRedirects' => true,
			]
		);

		if ( $response->getStatus() != 200 ) {
			$this->debug( "\tDid not get 200 response back from discussion site: $url" );
			return;
		}

		$content = $response->getContent();
		if ( empty( $content ) ) {
			$this->debug( "\tGot no content back from discussion site: $url" );
			return;
		}

		$data = json_decode( $content );
		if ( empty( $data ) ) {
			$this->debug( "\tGot no data when parsing JSON from discussion site: $url" );
			return;
		}

		if ( empty( $data->_embedded->forums ) ) {
			$this->debug( "Found no forums at discussion site: $url" );
			return;
		}

		$this->debug( "\tFound forums" );
		$this->discussionsFound = new \DateTime();

		if ( empty( $data->_embedded->threads ) ) {
			$this->debug( "Found no threads at discussion site: $url" );
			return;
		}

		$this->debug( "\tFound threads" );

		// This assumes that any post is the first post (where first post here means the
		// automatic post that is created on migrated wikis, but its entirely possible that the
		// automatic first post never succeeded but subsequent users posts have been added.  Also
		// discussions created via createNewWiki don't get this post, so this field is really
		// only useful to check on wikis known to have just been migrated.
		$this->firstPostFound = new \DateTime();
	}

	private function getDiscussionsUrl() {
		global $wgDiscussionsApiUrl;

		return "$wgDiscussionsApiUrl/$this->siteId/threads";
	}

	private function getVariableValue( $name, $default = false ) {
		return \WikiFactory::getVarValueByName( $name, $this->siteId , false, $default );
	}

	public function statusIsComplete() {
		return $this->status == self::STATUS_COMPLETE;
	}

	public function statusIsRetry() {
		return $this->status == self::STATUS_RETRY;
	}

	public function statusIsFailed() {
		return $this->status == self::STATUS_FAILED;
	}

	public function statusIsNew() {
		return $this->status == self::STATUS_NEW;
	}

	private function getCentralDbr() {
		if ( empty( $this->centralDbr ) ) {
			$this->centralDbr = wfGetDB( DB_SLAVE, null, 'wikicities');
		}
		return $this->centralDbr;
	}

	private function getCentralDbw() {
		if ( empty( $this->centralDbw ) ) {
			$this->centralDbw = wfGetDB( DB_MASTER, null, 'wikicities' );
		}
		return $this->centralDbw;
	}

	/**
	 * Returns whether we've checked the current site recently or not, where recently is anytime
	 * between now and self::CATALOG_TTL seconds ago
	 *
	 * @return bool|mixed
	 */
	public function skipCataloging () {
		$this->debug("Checking for existing catalog ...");

		if ( $this->statusIsComplete() || $this->statusIsFailed() ) {
			$this->debug("\tStatus is complete or failed.  Skipping ...");
			return true;
		}

		$ttl = new \DateTime("now");
		$ttl->sub( new \DateInterval( 'PT' . self::CATALOG_TTL . 'S' ) );

		if ( $this->lastUpdated > $ttl ) {
			$this->debug("\tLast update is recent.  Skipping ...");
			return true;
		}

		$this->debug("\tNo recent update.  Cataloging ...");
		return false;
	}
}
