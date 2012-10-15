<?php

require( "MetricsMaintenance.php" );

class ImportCSVFile extends MetricsMaintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Imports a generic MetricsReporting CSV file into its table";
		$this->addArg( 'table', 'Table to import file to' );
		$this->addArg( 'file', 'File to import' );
	}

	public function execute() {
		$table = $this->getArg( 0 );
		$fileName = $this->getArg( 1 );

		if ( !file_exists( $fileName ) ) {
			$this->error( 'Input file does not exist', true );
		}

		$db = $this->getDB();
		if ( !$db->tableExists( $table ) ) {
			$this->error( "Target table doesn't exist. Please create it" );
		}

		$file = fopen( $fileName, 'r' );
		if ( $file === false ) {
			$this->error( 'Unable to open input file', true );
		}

		$db->begin( __METHOD__ );

		feof( $file ); // Strip 1st/header line. Might need to be disableable

		while( !feof( $file ) ) {
			list( $date, $lang, $project, $country, $value ) = explode( ',', fgets( $file ) );
			$db->insert(
				$table,
				array(
					'date' => $date,
					'language_code' => $lang,
					'project_code' => $project,
					'country_code' => $country,
					'value' => $value,
				),
				__METHOD__,
				array( 'IGNORE' ) // If we're importing duplicates, just skip
			);
		}
		fclose( $file );
		$db->commit( __METHOD__ );
		$this->output( 'Complete!' );
	}
}

$maintClass = "ImportCSVFile";
require_once( DO_MAINTENANCE );