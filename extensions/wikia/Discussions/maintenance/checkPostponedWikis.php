<?php

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class CheckPostponedWikis extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->addArg( 'out', "Output file for wiki ids", $required = true );
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

		$forumWikis = [];

		( new \WikiaSQL() )->SELECT(
			"city_id"
		)
			->FROM( "city_list" )
			->WHERE( 'city_id' )
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
				function ( &$data, $row ) use ( $fh, &$forumWikis ) {
					$forumWikis[] = $row->city_id;
				}
			);

		$disabledMigrationBannerWikis = [];

		( new \WikiaSQL() )->SELECT(
			"city_id"
		)
			->FROM( "city_list" )
			->WHERE( 'city_id' )
			->IN(
				( new \WikiaSQL() )->SELECT(
					"city_id" )
					->FROM( "city_list" )
					->JOIN( "city_variables" )
					->ON( 'city_list.city_id', 'city_variables.cv_city_id' )
					->WHERE( 'cv_variable_id' )
					->IN( [2016] )
					->AND_( "cv_value" )
					->EQUAL_TO( "b:0;" )
			)
			->runLoop(
				$db,
				function ( &$data, $row ) use ( $fh, &$disabledMigrationBannerWikis ) {
					$disabledMigrationBannerWikis[] = $row->city_id;
				}
			);


		foreach ( $forumWikis as $id ) {
			if ( !in_array( $id, $disabledMigrationBannerWikis ) ) {
				fwrite( $fh, $id . "\n");
			}
		}

		fclose( $fh );
	}
}

$maintClass = CheckPostponedWikis::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
