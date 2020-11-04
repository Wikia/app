<?php

// make Wikia\Logger\Loggable trait available at a run-time
require_once( __DIR__ . '/../../../../lib/composer/autoload.php' );
require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );
require_once __DIR__ . '/gcs_bucket_remover.php';

class RemoveWithEmptyDB extends Maintenance {

	use Wikia\Logger\Loggable;

	// delete wikis after X days when we marked them to be deleted
	const CLOSE_WIKI_DELAY = 30;

	const IMAGE_ARCHIVE_SIZE_LIMIT_BYTES = 50 * 1024 * 1024 * 1024;

	public function __construct() {
		parent::__construct();
		$this->addOption( 'first', 'Run only once for first wiki in queue' );
		$this->addOption( 'from', 'Starting offset for wiki to be closed' );
		$this->addOption( 'dry-run', 'List wikis that will be removed and quit' );
		$this->addOption( 'limit', 'Limit how many wikis will be processed', false, true );
		$this->addOption( 'sleep', 'How long to wait before processing the next wiki', false, true );
		$this->addOption( 'cluster', 'Run for a given cluster only', false, true );
	}

	/**
	 * 1. go through all wikis which are marked for closing and check which one
	 *    want to have images packed.
	 *
	 * 2. pack images, send them via rsync to  target server,
	 *
	 * 3. mark in city_list.city_flags that images are sent,
	 *
	 * 4. remove images
	 *
	 * @access public
	 * @throws DBUnexpectedError
	 */
	public function execute() {

		// process script command line arguments
		$first = $this->hasOption( 'first' );
		$sleep = $this->getOption( 'sleep', 15 );
		$cluster = $this->getOption( 'cluster', false ); // eg. c6

		$this->info( 'start', [
			'cluster' => $cluster,
			'first' => $first,
		] );

		// build database query
		$opts = [
			"ORDER BY" => "city_id",
		];

		$where = [
			"city_public" => [ WikiFactory::CLOSE_ACTION, WikiFactory::HIDE_ACTION ],
			"city_flags <> 0",
			sprintf( "city_flags <> %d", WikiFactory::FLAG_REDIRECT ),
		];

		if ( $cluster !== false ) {
			$where["city_cluster"] = $cluster;
		}

		$dbr = WikiFactory::db( DB_SLAVE );
		$sth = $dbr->select( [ "city_list" ], [
			"city_id",
			"city_flags",
			"city_dbname",
			"city_cluster",
			"city_url",
			"city_public",
			"city_last_timestamp",
			"city_additional",
		], $where, __METHOD__, $opts );

		$this->info( 'wikis to check', [
			'wikis' => $sth->numRows(),
			'query' => $dbr->lastQuery(),
		] );
		$fp = fopen('/tmp/broken.csv', 'w');

		while ( $row = $dbr->fetchObject( $sth ) ) {
			/**
			 * reasonable defaults for wikis and some presets
			 */
			$dbname = $row->city_dbname;
			$cityid = intval( $row->city_id );
			$cluster = $row->city_cluster;

			$this->debug( "city_id={$row->city_id} city_cluster={$cluster} city_url={$row->city_url} city_dbname={$dbname} city_flags={$row->city_flags} city_public={$row->city_public} city_last_timestamp={$row->city_last_timestamp}" );

			if ( $row->city_flags & WikiFactory::FLAG_DELETE_DB_IMAGES ||
				 $row->city_flags & WikiFactory::FLAG_FREE_WIKI_URL ) {
				$db = WikiFactory::IDtoDB($cityid);
				try {
					$dbr = wfGetDB(DB_REPLICA, [], $db);
				} catch ( Exception $e ) {
					fputcsv($fp, [$db, $cityid, WikiFactory::isInArchive($cityid)]);
				}
			}
			/**
			 * just one?
			 */
			if ( $first ) {
				break;
			}
			sleep( $sleep );
		}
		fclose($fp);

		$this->info( 'Done' );
	}
}

$maintClass = RemoveWithEmptyDB::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
