<?php
/**
 * Script creates missing index on `comments_index` table
 *
 * @author Evgeniy Vasilev
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class AddMissingCommentsIndex extends Maintenance {

	const TABLE_NAME = 'comments_index';
	const INDEX_NAME = 'last_touched';

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Add missing `comments_index` table index';
	}

	private function addMissingIndex( $dbh ) {
		$sql = 'CREATE INDEX `last_touched`
				ON `comments_index`
				(`last_touched`,`archived`,`deleted`,`removed`,`parent_comment_id`,`parent_page_id`);';
		return $dbh->query($sql, __METHOD__);
	}

	public function execute() {
		$dbh = $this->getDB( DB_MASTER );
		$this->output( 'Checking "' . $dbh->getDBname() . '" ...' );
		if ( !$dbh->indexExists( self::TABLE_NAME, self::INDEX_NAME ) ) {
			if ( $this->addMissingIndex( $dbh ) ) {
				$this->output( ' UPDATED' );
			}
		}
		$dbh->close();
		$this->output( ' done ' .PHP_EOL );
	}
}

$maintClass = "AddMissingCommentsIndex";
require_once( DO_MAINTENANCE );
