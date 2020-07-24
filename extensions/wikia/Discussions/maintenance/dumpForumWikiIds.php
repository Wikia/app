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

		$cities = [];

		( new \WikiaSQL() )->SELECT(
			"city_id, city_public"
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
				function ( &$data, $row ) use ( $fh, &$cities ) {
					$cities[$row->city_id] = [
						"isPublic" => $row->city_public
					];
				}
			);

		$values = [];
		( new \WikiaSQL() )->SELECT(
			"city_id, cv_value"
		)
			->FROM( "city_list" )
			->JOIN( "city_variables" )
			->ON( 'city_list.city_id', 'city_variables.cv_city_id' )
			->WHERE( 'cv_variable_id' )
			->IN( [1581] )
			->AND_( 'city_id' )
			->IN( array_keys($cities) )
			->runLoop(
				$db,
				function ( &$data, $row ) use ( $fh, &$values ) {
					$values[$row->city_id] = [
						"discussionValue" => $row->cv_value
					];
				}
			);

		$meta = [];
		( new \WikiaSQL() )->SELECT(
			"city_id, city_url, city_lang, vertical_name"
		)
			->FROM( "city_list" )
			->JOIN( "city_verticals" )
			->ON( 'city_list.city_vertical', 'city_verticals.vertical_id' )
			->WHERE( 'city_id' )
			->IN( array_keys($cities) )
			->runLoop(
				$db,
				function ( &$data, $row ) use ( $fh, &$meta ) {
					$meta[$row->city_id] = [
						"url" => $row->city_url,
						"lang" => $row->city_lang,
						"vertical" => $row->vertical_name
					];
				}
			);

		foreach ( $cities as $id => $data ) {
			$discussionValue = array_key_exists($id, $values) ? $values[$id]['discussionValue'] : '';
			$discussionEnabled = empty($discussionValue) ? 'no' : (strcmp($discussionValue, 'b:1;') == 0 ? 'yes' : 'no');
			$url = array_key_exists($id, $meta) ? $meta[$id]['url'] : '';
			$lang = array_key_exists($id, $meta) ? $meta[$id]['lang'] : '';
			$vertical = array_key_exists($id, $meta) ? $meta[$id]['vertical'] : '';
			fwrite( $fh, $id . ';' . $data['isPublic'] . ';' . $discussionEnabled . ";"
			. $url . ";" . $lang . ";" . $vertical . ";\n");
		}

		fclose( $fh );
	}
}

$maintClass = ForumWikiIds::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
