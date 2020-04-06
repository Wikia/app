<?php
/**
 * Dumps the Forum data for the site selected by setting the SERVER_ID variable
 *
 * @ingroup Maintenance
 */

error_reporting(E_ALL);

require_once( __DIR__ . '/../../../../../maintenance/Maintenance.php' );
include_once( __DIR__ . '/../ForumDumper.php' );
include_once( __DIR__ . '/../FollowsFinder.php' );
include_once( __DIR__ . '/../WallHistoryFinder.php' );


class DumpForumPageIds extends Maintenance {
	/** @var  \Discussions\ForumDumper */
	private $dumper;
	private $fh;
	private $outputName;

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Dumps forum page ids';
		$this->addArg( 'out', "Output file for page ids", $required = true );
	}

	public function execute() {
		$this->outputName = $this->hasOption( 'out' ) ? $this->getArg() : "php://stdout";
		$this->fh = fopen( $this->outputName, 'w' );
		if ( $this->fh === false ) {
			$this->error( "Unable to open file " . $this->outputName, 1 );
		}

		$this->dumper = new Discussions\ForumDumper();
		$this->dumper->dumpPagesIds( $this->fh );
		fclose( $this->fh );

		$this->output( "Pages ids dumped!" );
	}
}

$maintClass = DumpForumPageIds::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
