<?php
/**
 * Dumps the Forum data for the site selected by setting the SERVER_ID variable
 *
 * Run like maintenance script on docker image without xdebug enabled:
 * php extensions/wikia/Discussions/maintenance/dumpForumData.php --out importData.sql
 *
 * @ingroup Maintenance
 */

error_reporting(E_ALL);

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );
include_once( __DIR__ . '/DumpUtils.php' );
include_once( __DIR__ . '/ForumDumper.php' );
include_once( __DIR__ . '/FollowsFinder.php' );
include_once( __DIR__ . '/WallHistoryFinder.php' );


class DumpForumData extends Maintenance {
	/** @var  \Discussions\ForumDumper */
	private $dumper;
	private $fh;
	private $outputName;
	private $bulk;
	private $debug;

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Dumps a set of INSERT statements suitable for importing into Discussion "import" tables';
		$this->addArg( 'out', "Output file for SQL statements", $required = false );
		$this->addOption( 'bulk', "Bulk inserts", $required = false );
		$this->addOption( 'debug', "Debug logs", $required = false );
	}

	public function execute() {
		$this->outputName = $this->hasOption( 'out' ) ? $this->getArg() : "php://stdout";
		$this->bulk = $this->hasOption( 'bulk' );
		$this->debug = $this->hasOption( 'debug' );

		$this->fh = fopen( $this->outputName, 'w' );
		if ( $this->fh === false ) {
			$this->error( "Unable to open file " . $this->outputName, 1 );
		}

		global $wgForumMigration;
		$wgForumMigration = true;

		$this->dumper = new Discussions\ForumDumper( $this->bulk, $this->debug );

		$this->setConnectinoEncoding();
		$this->clearImportTables();
		fclose( $this->fh );

		$this->dumpPages();
		$this->output("Pages dumped!");

		$this->dumpRevisions();
		$this->output("Revisions dumped!");

		$this->dumpVotes();
		$this->output("Votes dumped!");

		$this->dumpFollows();
		$this->output("Follows dumped!");

		$this->dumpWallHistory();
		$this->output("History dumped!");

		$this->dumpTopics();
		$this->output("Topics dumped!");
	}

	private function setConnectinoEncoding() {
		fwrite( $this->fh, "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;" );
	}

	private function clearImportTables() {
		fwrite( $this->fh, "DELETE FROM import_page;\n" );
		fwrite( $this->fh, "DELETE FROM import_revision;\n" );
		fwrite( $this->fh, "DELETE FROM import_vote;\n" );
		fwrite( $this->fh, "DELETE FROM import_follows;\n" );
		fwrite( $this->fh, "DELETE FROM import_history;\n" );
		fwrite( $this->fh, "DELETE FROM import_topics;\n" );
	}

	private function dumpPages() {

		$this->fh = fopen( $this->outputName, 'a' );
		$this->dumper->getPages( $this->fh, [], -1 );
		fclose( $this->fh );
	}

	private function dumpRevisions() {

		$this->fh = fopen( $this->outputName, 'a' );
		$this->dumper->getRevisions( $this->fh );
		fclose( $this->fh );
	}

	private function dumpVotes() {

		$this->fh = fopen( $this->outputName, 'a' );
		$this->dumper->getVotes( $this->fh );
		fclose( $this->fh );
	}

	private function dumpFollows() {

		$this->fh = fopen( $this->outputName, 'a' );
		$this->dumper->getFollows( $this->fh );
		fclose( $this->fh );
	}

	private function dumpWallHistory() {

		$this->fh = fopen( $this->outputName, 'a' );
		$this->dumper->getWallHistory( $this->fh );
		fclose( $this->fh );
	}

	private function dumpTopics() {

		$this->fh = fopen( $this->outputName, 'a' );
		$this->dumper->getTopics( $this->fh );
		fclose( $this->fh );
	}
}

$maintClass = DumpForumData::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
