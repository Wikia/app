<?php

ini_set( 'display_errors', 1 );

require __DIR__ . '/../../../maintenance/Maintenance.php';
require __DIR__ . '/CharacterConverter.php';

class ConvertWholeDatabase extends Maintenance {

	public function __construct() {
		parent::__construct();

		$this->mDescription = 'Convert a wiki database from latin1 to utf8mb4 tables';
		$this->addOption( 'db-name', 'Which database to convert (default is the local wiki DB)' );
	}

	public function execute() {
		$dbName = $this->getOption( 'db-name' ) ?? $GLOBALS['wgDBname'];

		// TODO put wiki in read-only mode
		// TODO copy DB
		// TODO perform the migration on DB copy
		$characterConverter = CharacterConverter::newFromDatabase( $dbName );
		$characterConverter->registerPreConversionCallback( function ( $tableName, $textColumns ) {
			$this->output( "Converting $tableName... columns: [" . implode(', ', array_keys($textColumns)) . "]\n" );
		} );

		$characterConverter->convert();
		// TODO switch DBs
		$wiki = WikiFactory::getWikiByDB($dbName);
		WikiFactory::setVarByName('wgUTF8WikiDb', $wiki->city_id, true);

		// TODO enable read-write mode
	}
}

$maintClass = ConvertWholeDatabase::class;
require RUN_MAINTENANCE_IF_MAIN;
