<?php

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class ForumWikiIds extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->addArg( 'out', "Output file for wiki ids", $required = false );
	}

	/**
	 * Do the actual work. All child classes will need to implement this
	 */
	public function execute() {
		$outputName = $this->hasOption( 'out' ) ? $this->getArg() : "php://stdout";
		$fh = fopen( $outputName, 'w' );

		if ( $fh === false ) {
			$this->error( "Unable to open file " . $outputName, 1 );
		}

		global $wgExternalSharedDB;
			$db = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		( new \WikiaSQL() )->SELECT(
			"city_id, city_public, cv_value"
		)
			->FROM( "city_list" )
			->JOIN( "city_variables" )
			->ON( 'city_list.city_id', 'city_variables.cv_city_id' )
			->WHERE( 'cv_variable_id' )
			->IN( [1581] )
			->AND_( 'city_id' )
			->IN(
				( new \WikiaSQL() )->SELECT(
				"city_id" )
					->FROM( "city_list" )
					->JOIN( "city_variables" )
					->ON( 'city_list.city_id', 'city_variables.cv_city_id' )
					->WHERE( 'cv_variable_id' )
					->IN( [1195] )
					->AND_( "cv_value" )
					->EQUAL_TO( "b:1;" )
			)
			->runLoop(
				$db,
				function ( &$cities, $row ) use ( $fh ) {
					fwrite( $fh, $row->city_id . ';' . $row->city_public . ';' . $row->cv_value . "\n" );
				}
			);

		fclose( $fh );
	}
}

$maintClass = ForumWikiIds::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
