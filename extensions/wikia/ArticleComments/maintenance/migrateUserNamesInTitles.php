<?php
/**
 * Removes user name component of article comment titles and replaces it with user ID
 *
 * @see SUS-4766
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class MigrateUserNamesInTitles extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Removes user name component of article comment titles and replaces it with user ID";
		$this->addOption( 'do-migrate', 'Perform the migration', false, false );
	}

	public function execute() {

		/**
		 * SELECT  page_id,page_title  FROM `page`  WHERE page_namespace IN ('1','1201','2001')
		 * AND (page_title LIKE '%/@comment-%' )
		 */
		$dbr = $this->getDB( DB_SLAVE );
		$rows = $dbr->select(
			'page',
			['page_id', 'page_title'],
			[
				'page_namespace' => [
					NS_TALK, // comments
					1201, // Wall
					2001, // Forum
				],
				'page_title' . $dbr->buildLike(
					$dbr->anyString(), '/' . ARTICLECOMMENT_PREFIX, $dbr->anyString()
				)
			]
		);
		$count = $dbr->affectedRows();
		$this->output($dbr->lastQuery() . "\n\n");

		// process each title
		foreach($rows as $row) {
			$this->output( "{$row->page_title}\n" );
		}

		$this->output( "Done! $count rows processed.\n" );
	}
}

$maintClass = MigrateUserNamesInTitles::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
