<?php

class MigrateImagesForWikis {

	public static function run( \DatabaseBase $db, $test = false, $verbose = false, $params = [] ) {
		( new MigrateImagesForWikis() )->execute( '' );
	}

	public function execute( $wikiPrefix ) {
		( new \WikiaSQL() )->SELECT( "city_list.city_id, wikicities.city_variables.cv_value" )
			->FROM( 'wikicities.city_list' )
			->JOIN( 'wikicities.city_variables' )
			->ON( 'wikicities.city_variables.cv_city_id = wikicities.city_list.city_id' )
			->JOIN( 'wikicities.city_variables_pool' )
			->ON( 'wikicities.city_variables.cv_variable_id = wikicities.city_variables_pool.cv_id' )
			->WHERE( 'wikicities.city_variables.cv_value' )
			->LIKE( '%muppet%' )
			->AND_( 'wikicities.city_variables_pool.cv_name' )
			->EQUAL_TO( 'wgUploadPath' )
			->LIKE( $wikiPrefix . '%' )
			->AND_( 'city_public' )
			->EQUAL_TO( 1 )
			->runLoop( $this->getCentralDbr(), function ( &$pages, $row ) {
				$this->runMigrateImagesToGcs( $row );
			} );
	}

	private function getCentralDbr() {
		if ( empty( $this->centralDbr ) ) {
			$this->centralDbr = wfGetDB( DB_SLAVE, null, 'wikicities' );
		}

		return $this->centralDbr;
	}

	private function runMigrateImagesToGcs( $row ) {
		echo 'ROW' . json_encode( $row ) . "\n\n";
	}
}
