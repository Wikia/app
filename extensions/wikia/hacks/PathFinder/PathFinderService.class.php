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
	
	public function init() {
		$this->model = F::build( 'PathFinderModel' );
		$this->logger = F::build( 'PathFinderLogger' );
	}
	
	/**
	 * @brief parse OneDot archive entries
	 * 
	 * @requestParam string $data the OneDot archive raw entry
	 * 
	 * @responseParam string $dbName the wiki DB name from the entry
	 * @responseParam array $parsedData the parsed data
	 */
	public function parseOneDotData() {
		$line = $this->getVal( 'data' );
		$result = $this->internalParseOneDotData( $line );
		$this->setVal( 'data', $result );
	}
	
	public function analyzeParsedData() {
		$data = $this->getVal( 'data' );
		$output = array();
		$result = $this->internalAnalyzeParsedData( $data, $output );
		$this->setVal( 'data', $output );
	}
	
	/**
	 * @brief Downloads data for the requested date from OneDot archive and extracts the data for the wikis of interest
	 * @details Produces a series of intermediate files, one per each wiki, those need further processing
	 * 
	 * @requestParam string $date the target date for the data to be downloaded and extracted
	 * @requestParam array $backendParams any extra configuration to pass to the backend storage
	 */
	public function extractOneDotData() {
		$this->app->wf->profileIn( __METHOD__ );
		$strDate = $this->getVal( 'date' );
		$backendParams = $this->getVal( 'backendParams', array() );
		
		if ( empty( $strDate ) ) {
			$exception = new PathFinderTargetDateMissingException();
			$this->logger->log( $exception->getMessage(), PathFinderLogger::LOG_TYPE_ERROR );
			
			$this->app->wf->profileOut( __METHOD__ );
			throw $exception;
		}
		
		$this->logger->log( "Fetching OneDot data from archive for {$strDate}..." );
		
		if ( $this->model->retrieveDataFromArchive( $strDate, $backendParams ) ) {
			$this->logger->log( "Done." );
			
			while( ( $src = $this->model->fetchRawDataFilePath() ) !== false ) {
				$fileHandle = fopen( $src, "r" );
				$segments = array();
				$lineCount = 0;
				$parseResult = "";
				$this->logger->log( "Processing: {$src}..." );
				
				while( !feof( $fileHandle ) ) {
					$lineCount++;
					
					try {
						$parseResult = $this->internalParseOneDotData( fgets( $fileHandle ) );
					} catch ( PathFinderNoDataToParseException $e ) {
						$this->logger->log( "Parser error: {$e->getMessage()} ({$src} at line {$lineCount})", PathFinderLogger::LOG_TYPE_WARNING );
						continue;
					}
					
					try{
						$this->internalAnalyzeParsedData( $parseResult, $segments );
					} catch ( PathFinderNoDataToAnalyzeException $e ) {
						$this->logger->log( "Analyzer error: {$e->getMessage()} ({$src} at line {$lineCount})", PathFinderLogger::LOG_TYPE_WARNING );
						continue;
					}
				}
				
				fclose( $fileHandle );
				$this->logger->log( 'Found ' . count( $segments ) . ' valid segments.' );
				$this->model->storeAnalyzedData( $segments );
				$this->logger->log( "Processing done." );
			}
			
			$this->model->cleanRawDataFolder();
		} else {
			$exception = new PathFinderNoDataException();
			$this->logger->log( "Failure: {$exception->getMessage()}", PathFinderLogger::LOG_TYPE_ERROR );
			
			$this->app->wf->profileOut( __METHOD__ );
			throw $exception;
		}
		
		$this->model->cleanRawDataFolder();
		$this->app->wf->profileOut( __METHOD__ );
	}
	
	/**
	 * @brief change colons to %3A in URL to match OneDot escaping
	 * @param string $url the URL to escape
	 */
	private function escapeURL( $url ) {
		return str_replace( ":", "%3A", $url );
	}
	
	private function internalParseOneDotData( &$line ) {
		$this->app->wf->profileIn( __METHOD__ );
		
		if ( empty( $line ) ) {
			$this->app->wf->profileOut( __METHOD__ );
			throw new PathFinderNoDataToParseException();
		}
		
		$skip = false;
		$wholeLine = explode( "&", $line );
		$wikis = $this->model->getWikis();
		$result = false;
		$data = array();
		
		/**
		 * @see extensions/wikia/WikiaStats/WikiaWebStats.php for OneDot data definition
		 */
		foreach( $wholeLine as $param ) {
			$parameters = explode( '=', $param );
			$value = $parameters[1];
			
			switch ( $parameters[0] ) {
				//cityId
				case "c":
				//article ID
				case "a" :
				//User ID (if logged in)
				case "u":
					$data[$parameters[0]] = (int) $value;
					break;
				//Wiki DB name
				case "x":
				//referrer URL
				case "r" :
					$data[$parameters[0]] = $value;
					break;
				//event name from tracking
				case "event":
					//we take into consideration only pure pageviews, no events tracking requests
					//this avoids duplicated data popping up and screw the stats
					$skip = true;
					break;
				//article namespace
				case "n":
					//in OneDot NS_MAIN is "n=" (empty)
					$namespace = (int) $value;
					
					if ( in_array( $namespace, $this->wg->PathFinderExcludeNamespaces ) ) {
						$skip = true;
					} else {
						$data[$parameters[0]] = (int) $value;
					}
					
					break;
			}
			
			if ( $skip == true ) {
				break;
			}
		}

		if (
			!$skip &&
			!empty( $data['x'] ) &&
			!empty( $data['a'] ) &&
			!empty( $data['r'] ) &&
			!empty( $data['c'] ) &&
			array_key_exists( $data['c'], $wikis )
		) {
			$wiki = $wikis[$data['c']];
			$mainURL = $this->escapeURL( "http://{$wiki->domain}/" );
			
			if( $wiki->hasPrefix ) {
				$mainURL = "{$mainURL}wiki/";
			}

			if ( strpos( $data["r"], $mainURL ) === 0 ) {
				$articleName = str_ireplace( $mainURL, '', $data["r"] );

				if ( !empty( $articleName ) ) {
					$data["r"] = $articleName;
					$result = $data;
				} else {
					$this->app->wf->profileOut( __METHOD__ );
					throw new PathFinderNoDataToParseException( 'Missing referrer article name' );
				}
			}
		}
		
		$this->app->wf->profileOut( __METHOD__ );
		return $result;
	}
	
	private function internalAnalyzeParsedData( &$data, Array &$output ){
		$this->app->wf->profileIn( __METHOD__ );
		
		if ( empty( $data ) ) {
			$this->app->wf->profileOut( __METHOD__ );
			throw new PathFinderNoDataToAnalyzeException();
		}
		
		$title = F::Build(
			'BetterGlobalTitle',
			array( $data['r'], $data['c'], $data['x'] ),
			'newFromText'
		);
		
		if (
			$title instanceof Title &&
			$title->exists() &&
			$title->getArticleID() != $data[ 'a' ] &&
			!in_array( $title->getNamespace(), $this->wg->PathFinderExcludeNamespaces )
		) {
			$referrerID = $title->getArticleID();
			$targetID = $data[ 'a' ];
			
			$key = "{$referrerID}_{$targetID}";
			
			if ( !key_exists( $key, $output ) ) {
				$obj = new stdClass();
				$obj->cityID = (int) $data[ 'c' ];
				$obj->referrerID = (int) $referrerID;
				$obj->targetID = (int) $targetID;
				$obj->counter = 1;
				
				$output[$key] = $obj;
			} else {
				$output[$key]->counter++;
			}
		} else {
			$this->app->wf->profileOut( __METHOD__ );
			throw new PathFinderNoDataToAnalyzeException( 'Invalid title.' );
		}
		
		$this->app->wf->profileOut( __METHOD__ );
	}
}

class PathFinderNoDataToParseException extends WikiaException{
	function __construct( $msg = 'No data to parse.' ) {
		parent::__construct( $msg );
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

class PathFinderNoDataToAnalyzeException extends WikiaException{
	function __construct( $msg = 'No data to Analyze.' ) {
		parent::__construct( $msg );
	}
}