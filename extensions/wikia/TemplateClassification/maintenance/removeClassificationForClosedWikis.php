<?php

ini_set( 'display_errors', 1 );

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

class RemoveClassificationForClosedWikis extends Maintenance {
	/** @var DatabaseBase $readConnection */
	private $readConnection;

	/** @var TemplateClassificationService $tcs */
	private $tcs;

	/** @var int $staleIdsCount */
	private $staleIdsCount = 0;

	public function __construct() {
		parent::__construct();

		$this->mDescription = 'Removes template classification data for closed wikis';
		$this->addOption( 'wiki-ids', 'Path to a file containing wiki IDs to process delimited by newline', true, true );
		$this->addOption( 'stale-ids', 'File to log stale IDs to', true, true );
		$this->addOption( 'dry-run', 'Dry-run mode, do not actually remove any data' );
	}

	public function execute() {
		$fileName = $this->getOption( 'wiki-ids' );
		$logName = $this->getOption( 'stale-ids' );

		if ( $this->hasOption( 'dry-run' ) ) {
			$this->output( "Dry-run mode, no changes will be made!\n" );
		}

		$inputFile = fopen( $fileName, 'r' );
		$logFile = fopen( $logName, 'w' );

		$batch = [];
		$count = 0;

		while ( ( $line = fgets( $inputFile ) ) != false ) {
			$batch[] = trim( $line );
			$count++;

			if ( $count % 500 === 0 ) {
				$this->bulkProcessCurrentBatch( $logFile, $batch );

				$batch = [];
			}
		}

		fclose( $inputFile );
		fclose( $logFile );

		$this->output( "Deleted classification data for {$this->staleIdsCount} wikis out of $count total.\n" );
	}

	private function bulkProcessCurrentBatch( &$logFile, array &$wikiIds ) {
		$dryRunMode = $this->hasOption( 'dry-run' );
		$validIds = $this->readConnection()->selectFieldValues( 'city_list', 'city_id', [ 'city_id' => $wikiIds ], __METHOD__ );

		foreach ( array_diff( $wikiIds, $validIds ) as $staleId ) {
			if ( !$dryRunMode ) {
				$this->getClassificationService()->deleteTemplateInformationForWiki( $staleId );
			}

			fwrite( $logFile, "$staleId\n" );

			$this->staleIdsCount++;
		}
	}

	private function readConnection(): DatabaseBase {
		if ( $this->readConnection === null ) {
			$this->readConnection = WikiFactory::db( DB_SLAVE );
		}

		return $this->readConnection;
	}

	private function getClassificationService(): TemplateClassificationService {
		if ( $this->tcs === null ) {
			$this->tcs = new TemplateClassificationService();
		}

		return $this->tcs;
	}
}

$maintClass = RemoveClassificationForClosedWikis::class;
require_once RUN_MAINTENANCE_IF_MAIN;
