<?php
/**
 * Dumps the Forum data for the site selected by setting the SERVER_ID variable
 *
 * @ingroup Maintenance
 */

error_reporting(E_ALL);

require_once( __DIR__ . '/../../../../../maintenance/Maintenance.php' );

class DumpForumPageIds extends Maintenance {
	private $fh;
	private $outputName;

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Dumps forum page ids';
		$this->addArg( 'pageids', "Output file for page ids", $required = true );
		$this->addArg( 'out', "Output file for INSERTS", $required = true );
	}

	public function execute() {

		$pageIdsName = $this->hasOption( 'pageids' ) ? $this->getArg( 0 ) : "php://stdout";
		$pageIdsFh = fopen( $pageIdsName, 'w' );
		if ( $pageIdsFh === false ) {
			$this->error( "Unable to open file " . $pageIdsName, 1 );
		}

		$this->dumpPagesIds( $pageIdsFh );
		fclose( $pageIdsFh );
		$this->output( "Pages ids dumped!" );

		$this->outputName = $this->hasOption( 'out' ) ? $this->getArg( 1 ) : "php://stdout";
		$this->fh = fopen( $this->outputName, 'w' );
		if ( $this->fh === false ) {
			$this->error( "Unable to open file " . $this->outputName, 1 );
		}

		$this->setConnectinoEncoding();
		$this->clearImportTables();
		fclose( $this->fh );
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
}

$maintClass = DumpForumPageIds::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
