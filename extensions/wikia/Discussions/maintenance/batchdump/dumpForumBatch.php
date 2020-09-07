<?php
/**
 * Dumps the Forum data for the site selected by setting the SERVER_ID variable
 *
 * @ingroup Maintenance
 */

error_reporting(E_ALL);

require_once( __DIR__ . '/../../../../../maintenance/Maintenance.php' );
include_once( __DIR__ . '/../DumpUtils.php' );
include_once( __DIR__ . '/../ForumDumper.php' );
include_once( __DIR__ . '/../FollowsFinder.php' );
include_once( __DIR__ . '/../WallHistoryFinder.php' );

class DumpForumBatch extends Maintenance {
	private $dumper;
	private $fh;
	private $outputName;

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Dumps forum in batches';
		$this->addArg( 'pageids', "Output file for page ids", $required = true );
		$this->addArg( 'out', "Output file for INSERTS", $required = true );
		$this->addArg( 'minIndex', "Min index", $required = true );
		$this->addArg( 'maxIndex', "Max index", $required = true );
	}

	public function execute() {

		$pageIdsName = $this->hasOption( 'pageids' ) ? $this->getArg( 0 ) : "php://stdout";
		$this->outputName = $this->hasOption( 'out' ) ? $this->getArg( 1 ) : "php://stdout";
		$minIndex = $this->hasOption( 'minIndex' ) ? $this->getArg( 2 ) : -1;
		$maxIndex = $this->hasOption( 'maxIndex' ) ? $this->getArg( 3 ) : -1;

		$pageIds = [];

		$spl = new SplFileObject( $pageIdsName );
		$spl->seek( $minIndex );
		for ($x = $minIndex; $x <= $maxIndex; $x++) {
			$pageIds[] = trim( $spl->current() );
			$spl->next();
		}

		$this->fh = fopen( $this->outputName, 'a' );
		$this->dumper = new Discussions\ForumDumper();

		$this->dumpPages( $pageIds, $minIndex );
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

		fclose( $this->fh );
	}

	private function dumpPages( array $pageIds, int $minIndex ) {
		$this->dumper->getPages( $this->fh, $pageIds, $minIndex );
	}

	private function dumpRevisions() {
		$this->dumper->getRevisions( $this->fh );
	}

	private function dumpVotes() {
		$this->dumper->getVotes( $this->fh );
	}

	private function dumpFollows() {
		$this->dumper->getFollows( $this->fh );
	}

	private function dumpWallHistory() {
		$this->dumper->getWallHistory( $this->fh );
	}

	private function dumpTopics() {
		$this->dumper->getTopics( $this->fh );
	}
}

$maintClass = DumpForumBatch::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
