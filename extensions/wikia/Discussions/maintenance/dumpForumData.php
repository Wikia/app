<?php
/**
 * Dumps the Forum data for the site selected by setting the SERVER_ID variable
 *
 * @ingroup Maintenance
 */

error_reporting(E_ALL);

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );
require_once( __DIR__ . '/ForumDumper.php' );

class DumpForumData extends Maintenance {
	private $dumper;

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Dumps a set of INSERT statements suitable for importing into Discussion "import" tables';

		$this->dumper = new Discussions\ForumDumper();
	}

	public function execute() {

		$this->clearImportTables();
		$this->dumpPages();
		$this->dumpRevisions();
		$this->dumpVotes();
	}

	public function clearImportTables() {
		echo "DELETE FROM import_page;\n";
		echo "DELETE FROM import_revision;\n";
		echo "DELETE FROM import_vote;\n";
	}

	public function dumpPages() {
		$pages = $this->dumper->getPages();
		
		foreach ( $pages as $id => $data ) {
			$insert = $this->createInsert(
				'import_page',
				Discussions\ForumDumper::COLUMNS_PAGE,
				$data
			);
			echo $insert . "\n";
		}
	}

	public function dumpRevisions() {
		$revisions = $this->dumper->getRevisions();

		foreach ( $revisions as $data ) {
			$insert = $this->createInsert(
				'import_revision',
				Discussions\ForumDumper::COLUMNS_REVISION,
				$data
			);
			echo $insert . "\n";
		}
	}

	public function dumpVotes() {
		$votes = $this->dumper->getVotes();

		foreach ( $votes as $data ) {
			$insert = $this->createInsert(
				'import_vote',
				Discussions\ForumDumper::COLUMNS_VOTE,
				$data
			);
			echo $insert . "\n";
		}
	}

	private function createInsert( $table, $cols, $data ) {
		$db = wfGetDB( DB_SLAVE );

		$insert = "INSERT INTO $table (site_id, " .
		          implode( ",", array_map( function ( $c ) use ( $db ) {
			          return 	$db->addIdentifierQuotes( $c );
		          }, $cols ) ) .
		          ")" .
		          " VALUES (" . \F::app()->wg->CityId;

		foreach ( $cols as $col ) {
			$insert .= ', ' . $db->addQuotes( $data[$col] );
		}

		$insert .= ');';

		return $insert;
	}
}

$maintClass = DumpForumData::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
