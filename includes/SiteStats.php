<?php

/**
 * Static accessor class for site_stats and related things
 */
class SiteStats {
	static $row, $loaded = false;
	static $jobs;
	static $pageCount = array();
	static $groupMemberCounts = array();

	/**
	 * @return String
	 */
	private static function getMemcKey() {
		return wfMemcKey( __CLASS__, 'row' );
	}

	static function recache() {
		self::load( true );
	}

	/**
	 * @param $recache bool
	 */
	static function load( $recache = false ) {
		if ( self::$loaded && !$recache ) {
			return;
		}

		self::$row = self::loadAndLazyInit();

		# This code is somewhat schema-agnostic, because I'm changing it in a minor release -- TS
		if ( !isset( self::$row->ss_total_pages ) && self::$row->ss_total_pages == -1 ) {
			# Update schema
			$u = new SiteStatsUpdate( 0, 0, 0 );
			$u->doUpdate();
			$dbr = wfGetDB( DB_SLAVE, 'vslow' );
			self::$row = self::doLoad( $dbr );
		}

		self::$loaded = true;
	}

	/**
	 * @return Bool|ResultWrapper
	 */
	static function loadAndLazyInit() {
		# Wikia change
		return WikiaDataAccess::cache(
			self::getMemcKey(),
			WikiaResponse::CACHE_STANDARD,
			function() {
				wfDebug( __METHOD__ . ": reading site_stats from slave\n" );
				return self::doLoad( wfGetDB( DB_SLAVE, 'vslow' ) );
			}
		);
	}

	/**
	 * Wikia change: invalidate cache used by SiteStats::load()
	 */
	public static function invalidateCache() {
		WikiaDataAccess::cachePurge( self::getMemcKey() );
	}

	/**
	 * @param $db DatabaseBase
	 * @return Bool|ResultWrapper
	 */
	private static function doLoad( $db ) {
		return $db->selectRow( 'site_stats', '*', false, __METHOD__ );
	}

	/**
	 * @return int
	 */
	static function views() {
		self::load();
		return self::$row->ss_total_views;
	}

	/**
	 * @return int
	 */
	static function edits() {
		self::load();
		return self::$row->ss_total_edits;
	}

	/**
	 * @return int
	 */
	static function articles() {
		self::load();
		return self::$row->ss_good_articles;
	}

	/**
	 * @return int
	 */
	static function pages() {
		self::load();
		return self::$row->ss_total_pages;
	}

	/**
	 * @return int
	 */
	static function users() {
		self::load();
		return self::$row->ss_users;
	}

	/**
	 * @return int
	 */
	static function activeUsers() {
		self::load();
		return self::$row->ss_active_users;
	}

	/**
	 * @return int
	 */
	static function images() {
		self::load();
		return self::$row->ss_images;
	}

	/**
	 * Find the number of users in a given user group.
	 * @param $group String: name of group
	 * @return Integer
	 */
	static function numberingroup( $group ) {
		if ( !isset( self::$groupMemberCounts[$group] ) ) {
			global $wgMemc;
			$key = wfMemcKey( 'SiteStats', 'groupcounts', $group );
			$hit = $wgMemc->get( $key );
			if ( !$hit ) {
				$dbr = wfGetDB( DB_SLAVE, 'vslow' );
				$hit = $dbr->selectField(
					'user_groups',
					'COUNT(*)',
					array( 'ug_group' => $group ),
					__METHOD__
				);
				$wgMemc->set( $key, $hit, 3600 );
			}
			self::$groupMemberCounts[$group] = $hit;
		}
		return self::$groupMemberCounts[$group];
	}

	/**
	 * @return int
	 */
	static function jobs() {
		if ( !isset( self::$jobs ) ) {
			// wikia change start, eloy
			global $wgMemc;
			$key = wfMemcKey( 'SiteStats', 'jobs' );
			self::$jobs = $wgMemc->get( $key );
			if ( !self::$jobs ) {
			// wikia change end
				$dbr = wfGetDB( DB_SLAVE );
				self::$jobs = $dbr->estimateRowCount( 'job' );
				/* Zero rows still do single row read for row that doesn't exist, but people are annoyed by that */
				if ( self::$jobs == 1 ) {
					self::$jobs = 0;
				}
				$wgMemc->set( $key, self::$jobs, 3600 );
			}
		}
		return self::$jobs;
	}

	/**
	 * @param $ns int
	 *
	 * @return int
	 */
	static function pagesInNs( $ns ) {
		wfProfileIn( __METHOD__ );
		if( !isset( self::$pageCount[$ns] ) ) {
			$dbr = wfGetDB( DB_SLAVE, 'vslow' );
			self::$pageCount[$ns] = (int)$dbr->selectField(
				'page',
				'COUNT(*)',
				array( 'page_namespace' => $ns ),
				__METHOD__
			);
		}
		wfProfileOut( __METHOD__ );
		return self::$pageCount[$ns];
	}

	/**
	 * Is the provided row of site stats sane, or should it be regenerated?
	 *
	 * @param $row
	 *
	 * @return bool
	 */
	private static function isSane( $row ) {
		if(
			$row === false
			|| $row->ss_total_pages < $row->ss_good_articles
			|| $row->ss_total_edits < $row->ss_total_pages
		) {
			return false;
		}
		// Now check for underflow/overflow
		foreach( array( 'total_views', 'total_edits', 'good_articles',
		'total_pages', 'users', 'images' ) as $member ) {
			if(
				$row->{"ss_$member"} > 2000000000
				|| $row->{"ss_$member"} < 0
			) {
				return false;
			}
		}
		return true;
	}
}

/**
 * Class designed for counting of stats.
 */
class SiteStatsInit {

	// Database connection
	private $db, $dbshared;

	// Various stats
	private $mEdits, $mArticles, $mPages, $mUsers, $mViews, $mFiles = 0;

	/**
	 * Constructor
	 * @param $database Boolean or DatabaseBase:
	 * - Boolean: whether to use the master DB
	 * - DatabaseBase: database connection to use
	 */
	public function __construct( $database = false ) {
		if ( $database instanceof DatabaseBase ) {
			$this->db = $database;
		} else {
			$this->db = wfGetDB( $database ? DB_MASTER : DB_SLAVE, 'vslow' );
		}
		global $wgExternalSharedDB;
		$this->dbshared = wfGetDB( $database ? DB_MASTER : DB_SLAVE, 'stats', $wgExternalSharedDB );
	}

	/**
	 * Count the total number of edits
	 * @return Integer
	 */
	public function edits() {
		$this->mEdits = $this->db->selectField( 'revision', 'COUNT(*)', '', __METHOD__ );
		$this->mEdits += $this->db->selectField( 'archive', 'COUNT(*)', '', __METHOD__ );
		return $this->mEdits;
	}

	/**
	 * Count pages in article space(s)
	 * @return Integer
	 */
	public function articles() {
		global $wgArticleCountMethod;

		$tables = array( 'page' );
		$conds = array(
			'page_namespace' => MWNamespace::getContentNamespaces(),
			'page_is_redirect' => 0,
		);

		if ( $wgArticleCountMethod == 'link' ) {
			$tables[] = 'pagelinks';
			$conds[] = 'pl_from=page_id';
		} elseif ( $wgArticleCountMethod == 'comma' ) {
			// To make a correct check for this, we would need, for each page,
			// to load the text, maybe uncompress it, maybe decode it and then
			// check if there's one comma.
			// But one thing we are sure is that if the page is empty, it can't
			// contain a comma :)
			$conds[] = 'page_len > 0';
		}

		$this->mArticles = $this->db->selectField( $tables, 'COUNT(DISTINCT page_id)',
			$conds, __METHOD__ );
		return $this->mArticles;
	}

	/**
	 * Count total pages
	 * @return Integer
	 */
	public function pages() {
		$this->mPages = $this->db->selectField( 'page', 'COUNT(*)', '', __METHOD__ );
		return $this->mPages;
	}

	/**
	 * Count total users
	 * @return Integer
	 */
	public function users() {
		$fname = __METHOD__;

		# Wikia change
		return $this->mUsers = WikiaDataAccess::cache(
			wfSharedMemcKey( __METHOD__ ),
			WikiaResponse::CACHE_STANDARD,
			function() use ($fname) {
				return $this->dbshared->estimateRowCount( '`user`', '*', '', $fname );
			}
		);
	}

	/**
	 * Count views
	 * @return Integer
	 */
	public function views() {
		$this->mViews = $this->db->selectField( 'page', 'SUM(page_counter)', '', __METHOD__ );
		return $this->mViews;
	}

	/**
	 * Count total files
	 * @return Integer
	 */
	public function files() {
		$this->mFiles = $this->db->selectField( 'image', 'COUNT(*)', '', __METHOD__ );
		return $this->mFiles;
	}

	/**
	 * Do all updates and commit them. More or less a replacement
	 * for the original initStats, but without output.
	 *
	 * @param $database DatabaseBase|bool
	 * - Boolean: whether to use the master DB
	 * - DatabaseBase: database connection to use
	 * @param $options Array of options, may contain the following values
	 * - update Boolean: whether to update the current stats (true) or write fresh (false) (default: false)
	 * - views Boolean: when true, do not update the number of page views (default: true)
	 * - activeUsers Boolean: whether to update the number of active users (default: false)
	 */
	public static function doAllAndCommit( $database = false, array $options = array() ) {
		$options += array( 'update' => false, 'views' => true, 'activeUsers' => false );

		// Grab the object and count everything
		$counter = new SiteStatsInit( $database );

		$counter->edits();
		$counter->articles();
		$counter->pages();
		$counter->users();
		$counter->files();

		// Only do views if we don't want to not count them
		if( $options['views'] ) {
			$counter->views();
		}

		// Update/refresh
		if( $options['update'] ) {
			$counter->update();
		} else {
			$counter->refresh();
		}

		// Count active users if need be
		if( $options['activeUsers'] ) {
			SiteStatsUpdate::cacheUpdate( wfGetDB( DB_MASTER ) );
		}
	}

	/**
	 * Update the current row with the selected values
	 */
	public function update() {
		list( $values, $conds ) = $this->getDbParams();
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update( 'site_stats', $values, $conds, __METHOD__ );

		SiteStats::invalidateCache(); // Wikia change
	}

	/**
	 * Refresh site_stats. Erase the current record and save all
	 * the new values.
	 */
	public function refresh() {
		list( $values, $conds, $views ) = $this->getDbParams();
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'site_stats', $conds, __METHOD__ );
		$dbw->insert( 'site_stats', array_merge( $values, $conds, $views ), __METHOD__ );

		SiteStats::invalidateCache(); // Wikia change
	}

	/**
	 * Return three arrays of params for the db queries
	 * @return Array
	 */
	private function getDbParams() {
		$values = array(
			'ss_total_edits' => $this->mEdits,
			'ss_good_articles' => $this->mArticles,
			'ss_total_pages' => $this->mPages,
			'ss_users' => $this->mUsers,
			'ss_images' => $this->mFiles
		);
		$conds = array( 'ss_row_id' => 1 );
		$views = array( 'ss_total_views' => $this->mViews );
		return array( $values, $conds, $views );
	}
}
