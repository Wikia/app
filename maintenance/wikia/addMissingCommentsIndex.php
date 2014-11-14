<?php
/**
 * Script creates missing index on `comments_index` table
 *
 * @author Evgeniy Vasilev
 * @ingroup Maintenance
 */

$dir = dirname( __FILE__ );
require_once( $dir . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class AddMissingCommentsIndex extends Maintenance {

	const BATCH_LIMIT = 100;

	const TABLE_NAME = 'comments_index';
	const INDEX_NAME = 'last_touched';

	/* time counter */
	private $time = 0;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'wiki', 'Run script for Wikis (comma separated list of Wikis)' );
		$this->mDescription = 'Add missing `comments_index` table index';
	}

	private function addMissingIndex( $dbh ) {
		$sql = 'CREATE INDEX `last_touched`
				ON `comments_index`
				(`last_touched`,`archived`,`deleted`,`removed`,`parent_comment_id`,`parent_page_id`);';
		return $dbh->query($sql, __METHOD__);
	}

	public function execute() {
		global $wgExternalSharedDB;

		$this->output( 'Processing started... ' . PHP_EOL );
		$this->time = time();

		$wikiList = $this->getOption( 'wiki', '' );

		$db = $this->getDB( DB_SLAVE, [], $wgExternalSharedDB );
		$where = [];
		if ( !empty( $wikiList  ) ) {
			$where[ 'city_list.city_id' ] = explode( ',', $wikiList );
		}

		$res = $db->select(
			[ 'city_list'],
			[ 'city_list.city_id', 'city_list.city_dbname' ],
			$where,
			'AddMissingCommentsIndex',
			[ 'ORDER BY' => 'city_id', 'LIMIT' => self::BATCH_LIMIT ]
		);

		while ( $row = $res->fetchObject() ) {
			$dbname = $row->city_dbname;
			try {
				$dbh = $this->getDB( DB_MASTER, [], $dbname );
			} catch (DBConnectionError $e) {
				$this->output( $e->error . PHP_EOL);
				continue;
			}
			$this->output( "Checking \"{$dbname}\" ({$row->city_id})..." );
			if ( $dbh->tableExists( self::TABLE_NAME, __METHOD__ )
				&& !$dbh->indexExists( self::TABLE_NAME, self::INDEX_NAME ) ) {
				if ( $this->addMissingIndex( $dbh ) ) {
					$this->output( ' UPDATED' );
				}
			}
			$this->output( ' done ' .PHP_EOL );
		}
		$this->output( "Done in " . Wikia::timeDuration( time() - $this->time ) . PHP_EOL );
	}
}

$maintClass = "AddMissingCommentsIndex";
require_once( DO_MAINTENANCE );
