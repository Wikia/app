<?php

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

class PopulateAFStatistics extends Maintenance {
	/**
	 * The number of records to attempt to insert at any given time.
	 * @var int
	 */
	public $insert_batch_size = 100;

	/**
	 * The period (in seconds) before now for which to gather stats
	 * @var int
	 */
	public $polling_period = 86400;

	/**
	 * The formatted timestamp from which to determine stats
	 * @var int
	 */
	protected $lowerBoundTimestamp;

	/**
	 * DB slave
	 * @var object
	 */
	protected $dbr;

	/**
	 * DB master
	 * @var object
	 */
	protected $dbw;

	/**
	 * Valid operations and their execution methods for this script to perform
	 *
	 * Operations are passed in as options during run-time - only valid options,
	 * which are defined here, can be executed. Valid operations are mapped here
	 * to a corresponding method ( array( 'operation' => 'method' ))
	 * @var array
	 */
	protected $operation_map = array(
		'highslows' => 'populateHighsLows',
		'problems' => 'populateProblems',
	);

	/**
	 * Operations to execute
	 * @var array
	 */
	public $operations = array();

	/**
	 * The minimum number of rating sets required before taking some action
	 * @var int
	 */
	public $rating_set_threshold = 10;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Populates the article feedback stats tables";

		$this->addOption( 'op', 'The ArticleFeedback stats gathering operation to run (eg "highslows").  Can specify multiple operations, separated by comma.', true, true );
		$this->addOption( 'rating_sets', 'The minimum number of rating sets before taking an action.', false, true );
		$this->addOption( 'poll_period', 'The polling period for fetching data, in seconds.', false, true );
	}

	public function syncDBs() {
		// FIXME: Copied from populateAFRevisions.php, which coppied from updateCollation.php, should be centralized somewhere
		$lb = wfGetLB();
		// bug 27975 - Don't try to wait for slaves if there are none
		// Prevents permission error when getting master position
		if ( $lb->getServerCount() > 1 ) {
			$dbw = $lb->getConnection( DB_MASTER );
			$pos = $dbw->getMasterPos();
			$lb->waitForAll( $pos );
		}
	}

	/**
	 * Bootstrap this maintenance script
	 *
	 * Performs operations necessary for this maintenance script to run which
	 * cannot or do not make sense to run in the constructor.
	 */
	public function bootstrap() {
		/**
		 * Set user-specified operations to perform
		 */
		$operations = explode( ',', $this->getOption( 'op' ));
		// check sanity of specified operations
		if ( !$this->checkOperations( $operations )) {
			$this->error( 'Invalid operation specified.', true );
		} else {
			$this->operations = $operations;
		}

		/**
		 * Set user-specified rating set threshold
		 */
		$rating_set_threshold = $this->getOption( 'rating_sets', $this->rating_set_threshold );
		if ( !is_numeric( $rating_set_threshold )) {
			$this->error( 'Rating sets must be numeric.', true );
		} else {
			$this->rating_set_threshold = $rating_set_threshold;
		}

		/**
		 * Set user-specified polling period
		 */
		$polling_period = $this->getOption( 'poll_period', $this->polling_period );
		if ( !is_numeric( $polling_period )) {
			$this->error( 'Poll period must be numeric.', true );
		} else {
			$this->polling_period = $polling_period;
		}

		// set db objects
		$this->dbr = wfGetDB( DB_SLAVE );
		$this->dbw = wfGetDB( DB_MASTER );
	}

	/**
	 * Check whether or not specified operations are valid.
	 *
	 * A specified operation is considered valid if it exists
	 * as a key in the operation map.
	 *
	 * @param array $ops An array of operations to check
	 * @return bool
	 */
	public function checkOperations( array $ops ) {
		foreach ( $ops as $operation ) {
			if ( !isset( $this->operation_map[ $operation ] )) {
				return false;
			}
		}
		return true;
	}

	public function execute() {
		// finish bootstrapping the script
		$this->bootstrap();

		// execute requested operations
		foreach ( $this->operations as $operation ) {
			$method = $this->operation_map[ $operation ];
			$this->$method();
		}
	}

	public function populateProblems() {
		global $wgMemc;

		/**
		 * Chck to see if we already have a collection of pages to operate on.
		 * If not, generate the collection of pages and their associated ratings.
		 */
		if ( !isset( $this->pages )) {
			$ts = $this->getLowerBoundTimestamp();
			$this->pages = $this->populatePageRatingsSince( $ts );
		}
		$problems = array();
		// iterate through pages, look for pages that meet criteria for problem articles
		$this->output( "Finding problem articles ...\n" );
		foreach ( $this->pages as $page ) {
			// make sure that we have more rating sets than the req'd threshold for this page in order to qualify for calculating
			if ( $page->rating_set_count < $this->rating_set_threshold ) {
				continue;
			}

			if ( $page->isProblematic() ) {
				$problems[] = $page->page_id;
			}
		}

		// populate stats table with problem articles & associated data
		// fetch stats type id - add stat type if it's non-existent
		$stats_type_id = SpecialArticleFeedback::getStatsTypeId( 'problems' );
		if ( !$stats_type_id ) {
			$stats_type_id = $this->addStatType( 'problems' );
		}

		$rows = array();
		$cur_ts = $this->dbw->timestamp();
		$count = 0;
		foreach( $problems as $page_id ) {
			$page = $this->pages->getPage( $page_id );
			// calculate the rating averages if they haven't already been calculated
			if ( !count( $page->rating_averages )) {
				$page->calculateRatingAverages();
			}
			$rows[] = array(
				'afs_page_id' => $page_id,
				'afs_orderable_data' => $page->overall_average,
				'afs_data' => FormatJson::encode( $page->rating_averages ),
				'afs_ts' => $cur_ts,
				'afs_stats_type_id' => $stats_type_id,
			);

			$count++;
			if ( $count >= 50 ) {
				// No more than 50
				// TODO: Get the 50 most problematic articles rather than 50 random problematic ones
				break;
			}
		}
		$this->output( "Done.\n" );

		// Insert the problem rows into the database
		$this->output( "Writing data to article_feedback_stats ...\n" );
		$rowsInserted = 0;
		// $rows is gonna be modified by array_splice(), so make a copy for later use
		$rowsCopy = $rows;
		while( $rows ) {
			$batch = array_splice( $rows, 0, $this->insert_batch_size );
			$this->dbw->insert(
				'article_feedback_stats',
				$batch,
				__METHOD__
			);
			$rowsInserted += count( $batch );
			$this->syncDBs();
			$this->output( "Inserted " . $rowsInserted . " rows\n" );
		}
		$this->output( "Done.\n" );

		// populate cache with current problem articles
		$this->output( "Caching latest problems (if cache present).\n" );
		// grab the article feedback special page so we can reuse the data structure building code
		// FIXME this logic should not be in the special page class
		$problems = SpecialArticleFeedback::buildProblems( $rowsCopy );
		// stash the data structure in the cache
		$key = wfMemcKey( 'article_feedback_stats_problems' );
		$wgMemc->set( $key, $problems, 86400 );
		$this->output( "Done.\n" );
	}

	/**
	 * Populate stats about highest/lowest rated articles
	 */
	public function populateHighsLows() {
		global $wgMemc;

		$averages = array(); // store overall averages for a given page

		/**
		 * Chck to see if we already have a collection of pages to operate on.
		 * If not, generate the collection of pages and their associated ratings.
		 */
		if ( !isset( $this->pages )) {
			$ts = $this->getLowerBoundTimestamp();
			$this->pages = $this->populatePageRatingsSince( $ts );
		}

		// determine the average ratings for a given page
		$this->output( "Determining average ratings for articles ...\n" );
		foreach ( $this->pages as $page ) {
			// make sure that we have more rating sets than the req'd threshold for this page in order to qualify for ranking
			if ( $page->rating_set_count < $this->rating_set_threshold ) {
				continue;
			}

			// calculate the rating averages if they haven't already been calculated
			if ( !count( $page->rating_averages )) {
				$page->calculateRatingAverages();
			}

			// store overall average rating seperately so we can easily sort
			$averages[ $page->page_id ] = $page->overall_average;
		}
		$this->output( "Done.\n" );

		// determine highest 50 and lowest 50
		$this->output( "Determining 50 highest and 50 lowest rated articles...\n" );
		asort( $averages );
		// take lowest 50 and highest 50
		$highest_and_lowest_page_ids = array_slice( $averages, 0, 50, true );
		if ( count( $averages ) > 50 ) {
			// in the event that we have < 100 $averages total, this will still
			// work nicely - it will select duplicate averages, but the +=
			// will cause items with the same keys to essentially be ignored
			$highest_and_lowest_page_ids += array_slice( $averages, -50, 50, true );
		}
		$this->output( "Done\n" );

		// fetch stats type id - add stat type if it's non-existant
		$stats_type_id = SpecialArticleFeedback::getStatsTypeId( 'highs_and_lows' );
		if ( !$stats_type_id ) {
			$stats_type_id = $this->addStatType( 'highs_and_lows' );
		}

		// prepare data for insert into db
		$this->output( "Preparing data for db insertion ...\n");
		$cur_ts = $this->dbw->timestamp();
		$rows = array();
		foreach( $highest_and_lowest_page_ids as $page_id => $overall_average ) {
			$page = $this->pages->getPage( $page_id );
			$rows[] = array(
				'afs_page_id' => $page_id,
				'afs_orderable_data' => $page->overall_average,
				'afs_data' => FormatJson::encode( $page->rating_averages ),
				'afs_ts' => $cur_ts,
				'afs_stats_type_id' => $stats_type_id,
			);
		}
		$this->output( "Done.\n" );

		// insert data to db
		$this->output( "Writing data to article_feedback_stats ...\n" );
		$rowsInserted = 0;
		// $rows is gonna be modified by array_splice(), so make a copy for later use
		$rowsCopy = $rows;
		while( $rows ) {
			$batch = array_splice( $rows, 0, $this->insert_batch_size );
			$this->dbw->insert(
				'article_feedback_stats',
				$batch,
				__METHOD__
			);
			$rowsInserted += count( $batch );
			$this->syncDBs();
			$this->output( "Inserted " . $rowsInserted . " rows\n" );
		}
		$this->output( "Done.\n" );

		// loading data into cache
		$this->output( "Caching latest highs/lows (if cache present).\n" );
		$key = wfMemcKey( 'article_feedback_stats_highs_lows' );
		// grab the article feedback special page so we can reuse the data structure building code
		// FIXME this logic should not be in the special page class
		$highs_lows = SpecialArticleFeedback::buildHighsAndLows( $rowsCopy );
		// stash the data structure in the cache
		$wgMemc->set( $key, $highs_lows, 86400 );
		$this->output( "Done\n" );
	}

	/**
	 * Fetch ratings newer than a given time stamp.
	 *
	 * If no timestamp is provided, relies on $this->lowerBoundTimestamp
	 * @param numeric $ts
	 * @return database result object
	 */
	public function fetchRatingsNewerThanTs( $ts=null ) {
		if ( !$ts ) {
			$ts = $this->getLowerBoundTimestamp();
		}

		if ( !is_numeric( $ts )) {
			throw new InvalidArgumentException( 'Timestamp expected to be numeric.' );
		}

		$res = $this->dbr->select(
			'article_feedback',
			array(
				'aa_revision',
				'aa_user_text',
				'aa_rating_id',
				'aa_user_anon_token',
				'aa_page_id',
				'aa_rating_value',
			),
			array( 'aa_timestamp >= ' . $this->dbr->addQuotes( $this->dbr->timestamp( $ts ) ) ),
			__METHOD__,
			array()
		);

		return $res;
	}

	/**
	 * Construct collection of pages and their ratings since a given time stamp
	 * @param $ts
	 * @return object The colelction of pages
	 */
	public function populatePageRatingsSince( $ts ) {
		$pages = new AFPages();
		// fetch the ratings since the lower bound timestamp
		$this->output( 'Fetching page ratings between now and ' . date( 'Y-m-d H:i:s', strtotime( $ts )) . "...\n" );
		$res = $this->fetchRatingsNewerThanTs( $ts );
		$this->output( "Done.\n" );

		// assign the rating data to our data structure
		$this->output( "Assigning fetched ratings to internal data structure ...\n" );
		foreach ( $res as $row ) {
			// fetch the page from the page store referentially so we can
			// perform actions on it that will automagically be saved in the
			// object for easy access later

			$page =& $pages->getPage( $row->aa_page_id );

			// determine the unique hash for a given rating set (page rev + user identifying info)
			$rating_hash = $row->aa_revision . "|" . $row->aa_user_text . "|" . $row->aa_user_anon_token;

			// add rating data for this page
			$page->addRating( $row->aa_rating_id, $row->aa_rating_value, $rating_hash );
		}
		$this->output( "Done.\n" );
		return $pages;
	}

	/**
	 * Set $this->timestamp
	 * @param int $ts
	 */
	public function setLowerBoundTimestamp( $ts ) {
		if ( !is_numeric( $ts )) {
			throw new InvalidArgumentException( 'Timestamp must be numeric.' );
		}
		$this->lowerBoundTimestamp = $ts;
	}


	/**
	 * Get $this->lowerBoundTimestamp
	 *
	 * If it hasn't been set yet, set it based on the defined polling period.
	 *
	 * @return int
	 */
	public function getLowerBoundTimestamp() {
		if ( !$this->lowerBoundTimestamp ) {
			$timestamp = $this->dbw->timestamp( strtotime( $this->polling_period . ' seconds ago' ));
			$this->setLowerBoundTimestamp( $timestamp );
		}
		return $this->lowerBoundTimestamp;
	}

	/**
	 * Add stat type record to article_feedbak_stats_types
	 * @param string $stat_type The identifying name of the stat type (eg 'highs_lows')
	 */
	public function addStatType( $stat_type ) {
		$this->dbw->insert(
			'article_feedback_stats',
			array( 'afst_type' => $stat_type ),
			__METHOD__
		);
		return $this->dbw->insertId();
	}
}

/**
 * A class to represent a page and data about its ratings
 */
class AFPage {
	public $page_id;

	/**
	 * The number of rating sets recorded for this page
	 * @var int
	 */
	public $rating_set_count = 0;

	/**
	 * An array of ratings for this page
	 * @var array
	 */
	public $ratings = array();

	/**
	 * An array to hold mean ratings by rating type id
	 * @var array
	 */
	public $rating_averages = array();

	/**
	 * Mean of all ratings for this page
	 * @var float
	 */
	public $overall_average;

	/**
	 * An array of rating set hashes, which are used to identify unique sets of
	 * ratings
	 * @var array
	 */
	protected $rating_set_hashes = array();

	public function __construct( $page_id ) {
		if ( !is_numeric( $page_id )) {
			throw new Exception( 'Page id must be numeric.' );
		}
		$this->page_id = $page_id;
	}

	/**
	 * Add a new rating for this particular page
	 * @param int $rating_id
	 * @param int $rating_value
	 * @param string $rating_set_hash
	 */
	public function addRating( $rating_id, $rating_value, $rating_set_hash = null ) {
		if ( intval( $rating_value ) == 0 ) {
			// Ignore zero ratings
			return;
		}
		
		$this->ratings[ $rating_id ][] = $rating_value;

		if ( $rating_set_hash ) {
			$this->trackRatingSet( $rating_set_hash );
		}
	}

	/**
	 * Keep track of rating sets
	 *
	 * Record when we see a new rating set and increment the set count
	 * @param string $rating_set_hash
	 */
	protected function trackRatingSet( $rating_set_hash ) {
		if ( isset( $this->rating_set_hashes[ $rating_set_hash ] )) {
			return;
		}

		$this->rating_set_hashes[ $rating_set_hash ] = 1;
		$this->rating_set_count += 1;
	}

	public function calculateRatingAverages() {
		// determine averages for each rating type
		foreach( $this->ratings as $rating_id => $rating ) {
			$rating_sum = array_sum( $rating );
			$rating_avg = $rating_sum / count( $rating );
			$this->rating_averages[ $rating_id ] = $rating_avg;
		}

		// determine overall rating average for this page
		if ( count( $this->rating_averages )) {
			$overall_rating_sum = array_sum( $this->rating_averages );
			$overall_rating_average = $overall_rating_sum / count( $this->rating_averages );
		} else {
			$overall_rating_average = 0;
		}
		$this->overall_average = $overall_rating_average;
	}

	/**
	 * Returns whether or not this page is considered problematic
	 * @return bool
	 */
	public function isProblematic() {
		if ( !isset( $this->problematic )) {
			$this->determineProblematicStatus();
		}
		return $this->problematic;
	}

	/**
	 * Determine whether this article is  'problematic'
	 *
	 * If a page has one or more rating categories where 70% of the ratings are
	 * <= 2, it is considered problematic.
	 */
	public function determineProblematicStatus() {
		foreach( $this->ratings as $rating_id => $ratings ) {
			$count = 0;
			foreach ( $ratings as $rating ) {
				if ( $rating <= 2 ) {
					$count += 1;
				}
			}

			$threshold = round( 0.7 * count( $ratings ));
			if ( $count >= $threshold ) {
				$this->problematic = true;
				return;
			}
		}

		$this->problematic = false;
		return;
	}
}

/**
 * A storage class to keep track of PageRatings object by page
 *
 * Iterable on array of pages.
 */
class AFPages implements IteratorAggregate {
	/**
	 * An array of page rating objects
	 * @var array
	 */
	public $pages = array();

	public function &getPage( $page_id ) {
		if ( !isset( $this->pages[ $page_id ] )) {
			$this->addPage( $page_id );
		}
		return $this->pages[ $page_id ];
	}

	public function addPage( $page_id ) {
		$this->pages[ $page_id ] = new AFPage( $page_id );
	}

	public function getIterator() {
		return new ArrayIterator( $this->pages );
	}
}

$maintClass = "PopulateAFStatistics";
require_once( DO_MAINTENANCE );
