<?php
/**
 * Path Finder service
 *
 * @author Jakub Olek <bukaj.kelo(at)gmail.com
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com
 */

class PathFinderService extends WikiaService {
	private $model;
	private $logger;
	private $parser;
	
	public function init() {
		$this->model = (new PathFinderModel);
		$this->logger = (new PathFinderLogger);
		$this->parser = (new PathFinderParser);
	}
	
	/**
	 * @brief Downloads data for the requested date from OneDot archive and extracts the data for the wikis of interest
	 * @details Produces a series of intermediate files, one per each wiki, those need further processing
	 * 
	 * @requestParam string $date the target date for the data to be downloaded and extracted
	 * @requestParam array $backendParams any extra configuration to pass to the backend storage
	 */
	public function extractOneDotData() {
		wfProfileIn( __METHOD__ );
		$strDate = $this->getVal( 'date' );
		$backendParams = $this->getVal( 'backendParams', array() );
		
		if ( empty( $strDate ) ) {
			$exception = new PathFinderTargetDateMissingException();
			$this->logger->log( $exception->getMessage(), PathFinderLogger::LOG_TYPE_ERROR );
			
			wfProfileOut( __METHOD__ );
			throw $exception;
		}
		
		$this->logger->log( "Fetching OneDot data from archive for {$strDate}..." );
		
		if ( $this->model->retrieveDataFromArchive( $strDate, $backendParams ) ) {
			$wikis = $this->model->getWikis();
			
			while( ( $src = $this->model->fetchRawDataFilePath() ) !== false ) {
				$fileHandle = fopen( $src, "r" );
				$this->logger->log( "Processing: {$src}..." );
				$parseFailureCount = 0;
				$totalLinesCount = 0;
				
				while( !feof( $fileHandle ) ) {
					$totalLinesCount++;
					
					try {
						$parseResult = $this->parser->parseLine( fgets( $fileHandle ), $wikis );
					} catch ( PathFinderNoDataToParseException $e ) {
						$parseFailureCount++;
						continue;
					}
					
					/*try{
						$this->internalAnalyzeParsedData( $parseResult, $segments );
					} catch ( PathFinderNoDataToAnalyzeException $e ) {
						$this->logger->log( "Analyzer error: {$e->getMessage()} ({$src} at line {$lineCount})", PathFinderLogger::LOG_TYPE_WARNING );
						continue;
					}*/
				}
				
				fclose( $fileHandle );
				$this->logger->log( "Total lines parsed: {$totalLinesCount} of which {$parseFailureCount} with errors or missing data." );
				//$this->model->storeAnalyzedData( $segments );
			}
			
			$this->parser->saveHosts();
			$this->model->cleanRawDataFolder();
		} else {
			$exception = new PathFinderNoDataException();
			$this->logger->log( "Failure: {$exception->getMessage()}", PathFinderLogger::LOG_TYPE_ERROR );
			
			wfProfileOut( __METHOD__ );
			$this->model->cleanRawDataFolder();
			throw $exception;
		}
		
		wfProfileOut( __METHOD__ );
	}
}

class PathFinderTargetDateMissingException extends WikiaException {
	function __construct() {
		parent::__construct( 'Target date not specified.' );
	}
}

class PathFinderNoDataException extends WikiaException{
	function __construct() {
		parent::__construct( 'No data received from OneDot.' );
	}
}