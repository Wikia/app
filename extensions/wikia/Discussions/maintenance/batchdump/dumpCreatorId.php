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

class DumpCreatorId extends Maintenance {
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

		$this->dumpCreatorId( $pageIds );
		$this->output("Dumped!");

		fclose( $this->fh );
	}

	private function dumpCreatorId( array $pageIds ) {
		$this->dumper->getCreationDateByPageId( $this->fh, $pageIds );
	}
}

$maintClass = DumpCreatorId::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
