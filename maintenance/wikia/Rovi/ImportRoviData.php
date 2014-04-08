<?php
require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );
require_once( "RoviTableImporter.php" );
require_once( "RoviTableSeriesImporter.php" );
require_once( "RoviTableEpisodeSeriesImporter.php" );


class ImportRoviData extends Maintenance {
	const CSV_SEPARATOR = '|';
	const CSV_MAX_LINE = 2048;
	const SHARED_DB = "wikicities";
	protected $filesOptions = [
		'seriesFile' => 'A csv file from Rovi containing series data (mostly Series.txt)',
		'episodesFile' => 'A csv file from Rovi containing episodes data (mostly Episode_Sequence.txt)'
	];
	protected $files;


	public function __construct() {
		parent::__construct();
		foreach ( $this->filesOptions as $option => $desc ) {
			$this->addOption( $option, $desc );
		}
		$this->addOption( 'skip', 'skip N rows' );
		$this->setBatchSize( 200 );

	}

	public function execute() {
		$this->checkFiles();
		$this->loadData( new RoviTableSeriesImporter(), 'seriesFile' );
		$this->loadData( new RoviTableEpisodeSeriesImporter, 'episodesFile' );
	}

	protected function loadData( RoviTableImporter $importer, $optionName ) {
		$csv = $this->openCsvFile( $optionName );
		if ( !$csv ) {
			return;
		}
		$row = fgetcsv( $csv, self::CSV_MAX_LINE, self::CSV_SEPARATOR ); //header
		if ( !$importer->checkFileHeader( $row ) ) {
			$this->error( "Header's length for --$optionName is different than defined", true );
		}

		$batchSize = $this->getOption( 'batch-size' );
		$batchCounter = $batchSize;
		$skip = (int)$this->getOption( 'skip', 0 );

		$db = wfGetDb( DB_MASTER, array(), self::SHARED_DB );
		$db->begin();
		$row = 0;
		while ( ( $data = fgetcsv( $csv, self::CSV_MAX_LINE, self::CSV_SEPARATOR ) ) !== FALSE ) {
			$row++;
			if ( $skip != 0 && $row < $skip ) {
				continue;
			}
			$this->output( "[$row] " . $importer->processRow( $data, $db ) . "\n" );
			$batchCounter--;
			if ( $batchCounter == 0 ) {
				$db->commit();
				$db->begin();
				$batchCounter = $batchSize;
			}
		}
		$db->commit();

	}

	protected function openCsvFile( $optionName ) {
		if ( empty( $this->files[ $optionName ] ) ) {
			return false;
		}
		$fileName = $this->files[ $optionName ];
		$csv = fopen( $fileName, 'r' );
		if ( !$csv ) {
			$this->error( "Unable to load file for --$optionName ($fileName)" );
			return false;
		}
		return $csv;
	}

	protected function checkFiles() {
		foreach ( array_keys( $this->filesOptions ) as $optionName ) {
			if ( $this->hasOption( $optionName ) ) {
				$fileName = $this->getOption( $optionName );
				if ( !file_exists( $fileName ) || !is_readable( $fileName ) ) {
					$this->error( "Unable to load file for --$optionName ($fileName)", true );
				}
				$this->files[ $optionName ] = $fileName;
			}

		}
		if ( empty( $this->files ) ) {
			$this->error( "No input files", true );
		}

	}

}


$maintClass = 'ImportRoviData';
require( RUN_MAINTENANCE_IF_MAIN );
