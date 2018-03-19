<?php

ini_set( 'display_errors', 1 );

require __DIR__ . '/../../../maintenance/Maintenance.php';
require __DIR__ . '/CharacterConverter.php';

class ConvertWholeDatabase extends Maintenance {

	public function __construct() {
		parent::__construct();

		$this->mDescription = 'Convert a wiki database from latin1 to utf8mb4 tables';
		$this->addOption( 'column-config', 'Path to a JSON configuration file mapping a set of tables to columns which need to be checked for double-encoded data', true, true );
		$this->addOption( 'db-name', 'Which database to convert (default is the local wiki DB)' );
	}

	public function execute() {
		$dbName = $this->getOption( 'db-name' ) ?? $GLOBALS['wgDBname'];
		$configPath = $this->getOption( 'column-config' );

		$columnConfig = json_decode( file_get_contents( $configPath ), true );

		$characterConverter = CharacterConverter::newFromDatabase( $dbName );
		$characterConverter->registerPreConversionCallback( function ( $tableName ) {
			$this->output( "Converting $tableName...\n" );
		} );

		$characterConverter->convert( $columnConfig );
	}
}

$maintClass = ConvertWholeDatabase::class;
require RUN_MAINTENANCE_IF_MAIN;
