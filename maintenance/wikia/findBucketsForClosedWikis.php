<?php

require_once( __DIR__ . '/../Maintenance.php' );

class FindBuckets extends Maintenance {

	private $centralDbr;


	public function __construct() {
		parent::__construct();
		$this->mDescription =
			"Find buckets for closed wikis. `Usage SERVER_DBNAME=muppet php -d display_errors=1 ./wikia/findBucketsForClosedWikis.php`";
	}

	public function execute() {
		try {
			$this->findAllBucketsForClosedWikis();
		}
		catch ( Exception $e ) {
			$this->error( "Failure to migrate" . json_encode( $e ) );
		}

		return 0;
	}

	private function findAllBucketsForClosedWikis() {
		( new \WikiaSQL() )->SELECT( "wikicities.city_list.city_id, wikicities.city_list.city_url , wikicities.city_variables.cv_value" )
			->FROM( 'wikicities.city_list' )
			->JOIN( 'wikicities.city_variables' )
			->ON( 'wikicities.city_list.city_id = wikicities.city_variables.cv_city_id' )
			->JOIN( 'wikicities.city_variables_pool' )
			->ON( 'wikicities.city_variables.cv_variable_id = wikicities.city_variables_pool.cv_id' )
			->WHERE( 'wikicities.city_list.city_public' )
			->EQUAL_TO( 0 )
			->AND_( 'wikicities.city_variables_pool.cv_name' )
			->EQUAL_TO( 'wgUploadPath' )
			->runLoop( $this->getCentralDbr(), function ( &$pages, $row ) {
				$uploadPath = $row->cv_value;
				$path = trim( parse_url( $uploadPath, PHP_URL_PATH ), '/' );
				$bucket = substr( $path, 0, - 7 );
				$this->output( $bucket );
			} );
	}


	private function getCentralDbr() {
		if ( empty( $this->centralDbr ) ) {
			$this->centralDbr = wfGetDB( DB_SLAVE, null, 'wikicities' );
		}

		return $this->centralDbr;
	}
}

$maintClass = "FindBuckets";
require_once( RUN_MAINTENANCE_IF_MAIN );
