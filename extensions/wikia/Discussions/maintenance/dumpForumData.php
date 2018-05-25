<?php
/**
 * Dumps the Forum data for the site selected by setting the SERVER_ID variable
 *
 * @ingroup Maintenance
 */

error_reporting(E_ALL);

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );
include_once( __DIR__ . '/ForumDumper.php' );
include_once( __DIR__ . '/FollowsFinder.php' );
include_once( __DIR__ . '/WallHistoryFinder.php' );


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
		$outputName = $this->hasOption( 'out' ) ? $this->getArg() : "php://stdout";
		$this->fh = fopen( $outputName, 'w' );
		if ( $this->fh === false ) {
			$this->error( "Unable to open file " . $outputName, 1 );
		}

		$this->dumper = new Discussions\ForumDumper();

		$this->dumpRevisions();
	}

	private function dumpRevisions() {
		$revisions = $this->dumper->getRevisions();

		$insert = '';

		foreach ( Discussions\ForumDumper::COLUMNS_REVISION as $col ) {
			$insert .= $col . ' ';
		}

		$insert .= "\n";

		foreach ( $revisions as $data ) {
			$insert .= $this->createInsert(
				'import_revision',
				Discussions\ForumDumper::COLUMNS_REVISION,
				$data
			);
			fwrite( $this->fh, $insert . "\n" );
		}
	}

	private function createInsert( $table, $cols, $data ) {
		$db = wfGetDB( DB_SLAVE );

		$insert = '';

		foreach ( $cols as $col ) {
			// Truncate long titles if necessary
			if ( $col == "title" ) {
				$value = mb_substr( $data[$col], 0, 512 );
			} else {
				$value = $data[$col];
			}

			$insert .= $db->addQuotes( $value ) . ' ';
		}

		return $insert;
	}
}

$maintClass = DumpForumData::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
