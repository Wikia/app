<?php
require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );
require_once( "RoviTableImporter.php" );
require_once( "RoviTableSeriesImporter.php" );
require_once( "RoviTableEpisodeSeriesImporter.php" );


class ImportRoviData extends Maintenance {
	const CSV_SEPARATOR = '|';
	const CSV_MAX_LINE = 2048;
	const DEFAULT_BATCH_SIZE = 200;
	const UTF16_TAG = "\xFF\xFE";
	const UTF16_TAG_LEN = 2;
	const TMP_DIR = '/tmp';
	protected $filesOptions = [
		'seriesFile' => 'A csv file from Rovi containing series data (mostly Series.txt)',
		'episodesFile' => 'A csv file from Rovi containing episodes data (mostly Episode_Sequence.txt)'
	];
	protected $files;
	protected $db;
	protected $verbose;
	protected $batchSize;
	protected $skip;


	public function __construct() {
		parent::__construct();
		foreach ( $this->filesOptions as $option => $desc ) {
			$this->addOption( $option, $desc );
		}
		$this->addOption( 'skip', 'Skip N rows' );
		$this->addOption( 'verbose', 'Show info for each row' );
		$this->setBatchSize( self::DEFAULT_BATCH_SIZE );
	}

	protected function init(){
		global $wgExternalDatawareDB;
		$this->db =  wfGetDb( DB_MASTER, array(), $wgExternalDatawareDB );
		$this->batchSize = $this->getOption( 'batch-size' );
		$this->verbose = (bool)$this->getOption( 'verbose', '0' );
		$this->skip = (int)$this->getOption( 'skip', 0 );
	}

	public function execute() {
		$this->init();
		$this->checkFiles();
		$this->loadData( new RoviTableSeriesImporter(), 'seriesFile' );
		$this->loadData( new RoviTableEpisodeSeriesImporter(), 'episodesFile' );
	}


	protected function loadData( RoviTableImporter $importer, $optionName ) {
		$this->output("Processing: $optionName \n");
		$csv = $this->openCsvFile( $optionName );
		if ( !$csv ) {
			return;
		}
		$row = fgetcsv( $csv, self::CSV_MAX_LINE, self::CSV_SEPARATOR ); //header
		if ( !$importer->checkFileHeader( $row ) ) {
			$this->error( "Header's length for --$optionName is different than defined", true );
		}

		$batchCounter = $this->batchSize;
		$this->db->begin();
		$row = 0;
		while ( ( $line = fgets( $csv, self::CSV_MAX_LINE ) ) !== FALSE ) {
			$row++;
			if ( $this->skip != 0 && $row <= $this->skip ) {
				continue;
			}
			$data = explode( self::CSV_SEPARATOR, $line );
			foreach ( $data as $k => &$v ) {
				$data[ $k ] = trim( $v );
			}
			$message = $importer->processRow( $data, $this->db );

			if ( $this->verbose ) {
				$this->output( "[$row] " . $message . "\n" );
			}
			$batchCounter--;
			if ( $batchCounter == 0 ) {
				$this->db->commit();
				$this->db->begin();
				$batchCounter = $this->batchSize;
			}
		}
		$this->db->commit();
		$this->output( $importer->getSummary() );
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

	protected function isFileUTF16( $filename ) {
		$f = fopen( $filename, 'r' );
		if ( !$f ) {
			$this->error( "Unable to open file: $filename", true );
		}
		$data = fread( $f, self::UTF16_TAG_LEN );
		$test = ( $data === self::UTF16_TAG );
		fclose( $f );
		return $test;
	}


	protected function checkFiles() {
		foreach ( array_keys( $this->filesOptions ) as $optionName ) {
			if ( $this->hasOption( $optionName ) ) {
				$fileName = $this->getOption( $optionName );
				if ( !file_exists( $fileName ) || !is_readable( $fileName ) ) {
					$this->error( "Unable to load file for --$optionName ($fileName)\n", true );
				}
				if ( $this->isFileUTF16( $fileName ) ) {
					$this->error("Unable to process UTF-16 file. Convert to UTF-8\n", true);
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
