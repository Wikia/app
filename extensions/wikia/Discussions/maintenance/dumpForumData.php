<?php
/**
 * Dumps the Forum data for the site selected by setting the SERVER_ID variable
 *
 * @ingroup Maintenance
 */

use Discussions\ForumDumper;

error_reporting(E_ALL);

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );
include_once( __DIR__ . '/ForumDumper.php' );

class DumpForumData extends Maintenance {
	/** @var  \Discussions\ForumDumper */
	private $dumper;
	private $fh;

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Dumps a set of INSERT statements suitable for importing into Discussion "import" tables';
		$this->addArg( 'out', "Output file for SQL statements", $required = false );
	}

	public function execute() {
		if ( $this->hasOption( 'out' ) ) {
			$this->fh = fopen( $this->getArg(), 'w' );
		} else {
			$this->fh = STDOUT;
		}
		$this->dumper = new Discussions\ForumDumper($this);

		$this->clearImportTables();
		$this->dumpPages();
		$this->dumper->saveRevisions();
		$this->dumper->saveVotes();
	}

	public function clearImportTables() {
		fwrite( $this->fh, "DELETE FROM import_page;\n" );
		fwrite( $this->fh, "DELETE FROM import_revision;\n" );
		fwrite( $this->fh, "DELETE FROM import_vote;\n" );
	}

	public function dumpPages() {
		$pages = $this->dumper->getPages();

		foreach ( $pages as $id => $data ) {
			$insert = $this->createInsert( 'import_page', ForumDumper::COLUMNS_PAGE, $data );
			fwrite( $this->fh, $insert . "\n" );
		}
	}

	public function dumpRevision( $data ) {
		$insert = $this->createInsert( 'import_revision', ForumDumper::COLUMNS_REVISION, $data );
		fwrite( $this->fh, $insert . "\n" );
	}

	public function dumpVote( $data ) {
		$insert = $this->createInsert( 'import_vote', ForumDumper::COLUMNS_VOTE, $data );
		fwrite( $this->fh, $insert . "\n" );
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
