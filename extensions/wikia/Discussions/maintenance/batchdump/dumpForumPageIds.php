<?php
/**
 * Dumps the Forum data for the site selected by setting the SERVER_ID variable
 *
 * @ingroup Maintenance
 */

error_reporting(E_ALL);

require_once( __DIR__ . '/../../../../../maintenance/Maintenance.php' );

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

		$this->dumpPagesIds( $this->fh );
		fclose( $this->fh );

		$this->output( "Pages ids dumped!" );
	}

	public function dumpPagesIds( $fh = null ) {

		$dbh = wfGetDB( DB_SLAVE );
		( new \WikiaSQL() )->SELECT( "page.page_id, IF(pp.props is NULL,concat('i:', page.page_id, ';'), pp.props) as idx" )
			->FROM( "page" )
			->LEFT_JOIN( "page_wikia_props" )
			->AS_( 'pp' )
			->ON( 'page.page_id', 'pp.page_id' )
			->AND_( 'propname', WPP_WALL_ORDER_INDEX )
			->WHERE( 'page_namespace' )
			->IN( 2000, 2001 )
			->ORDER_BY( 'idx' )
			->runLoop( $dbh, function ( &$pages, $row ) use ( $fh ) {
				fwrite( $fh, $row->page_id . "\n" );
			} );

		$dbh->closeConnection();
		wfGetLB( false )->closeConnection( $dbh );
	}
}

$maintClass = DumpForumPageIds::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
