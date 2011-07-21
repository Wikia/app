<?php
/**
 * User Path Prediction Service
 * @details This class is a singleton
 *
 * @author Jakub Olek <bukaj.kelo(at)gmail.com
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com
 */

class UserPathPredictionService extends WikiaService {
	private $model;
	private $smarterGlobalTitle;
	
	public function init() {
		$this->model = F::build( 'UserPathPredictionModel' );
		$this->smarterGlobalTitle = F::build( 'SmarterGlobalTitle' );
	}
	
	public function getWikis() {
		$this->setVal( 'wikis', $this->model->getWikis() );
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
		$this->app->wf->profileIn( __METHOD__ );
		
		$line = $this->getVal( 'data' );
		$result = $this->internalParseOneDotData( $line );
		$this->setVal( 'data', $result );
		
		$this->app->wf->profileOut( __METHOD__ );
	}
	
	private function internalParseOneDotData( &$line ) {
		$this->app->wf->profileIn( __METHOD__ );
		
		if ( !$line ) {
			$this->app->wf->profileOut( __METHOD__ );
			throw new UserPathPredictionNoDataToParseException();
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
					
					if ( in_array( $namespace, $this->wg->UserPathPredictionExludeNamespaces ) ) {
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

				if( !empty( $articleName ) ) {
					$data["r"] = $articleName;
					$result = $data;
				}
			}
		}

		$this->app->wf->profileOut( __METHOD__ );
		return $result;
	}
	
	public function analyzeParsedData() {
		$this->app->wf->profileIn( __METHOD__ );
		
		$data = $this->getVal( 'data' );
		$result = $this->internalAnalyzeParsedData( $data );
		$this->setVal( 'data', $result );
		
		$this->app->wf->profileOut( __METHOD__ );
	}
	
	private function internalAnalyzeParsedData( $data ){
		$this->app->wf->profileIn( __METHOD__ );
		
		//$data = $this->getVal( 'data' );
		$result = false;
		
		if ( !$data ) {
			$this->app->wf->profileOut( __METHOD__ );
			throw new UserPathPredictionNoDataToAnalyzeException();
		}

		if ( $title = SmarterGlobalTitle::smarterNewFromText( $data ) ) {
		
			if (
				$title instanceof Title &&
				$title->exists() &&
				$title->getArticleID() != $data[ 'a' ] &&
				!in_array( $title->getNamespace(), $this->wg->UserPathPredictionExludeNamespaces )
			) {
				$referrerID = $title->getArticleID();
				$targetID = $data[ 'a' ];
				
				$result = new stdClass();
				$result->cityID = (int) $data[ 'c' ];
				$result->referrerID = (int) $referrerID;
				$result->targetID = (int) $targetID;
			}
		}

		//$this->setVal( 'data', $result );
		$this->app->wf->profileOut( __METHOD__ );
		return $result;
	}
	
	/**
	 * @brief Downloads data for the requested date from OneDot archive and extracts the data for the wikis of interest
	 * @details Produces a series of intermediate files, one per each wiki, those need further processing
	 * 
	 * @requestParam string $date the target date for the data to be downloaded and extracted
	 * @requestParam array $backendParams any extra configuration to pass to the backend storage
	 */
	function extractOneDotData() {
		$this->app->wf->profileIn( __METHOD__ );
		$strDate = $this->getVal( 'date' );
		$backendParams = $this->getVal( 'backendParams', array() );
		
		if ( empty( $strDate ) ) {
			$exception = new UserPathPredictionTargetDateMissingException();
			$this->log( $exception->getMessage(), UserPathPredictionLogService::LOG_TYPE_ERROR );
			
			$this->app->wf->profileOut( __METHOD__ );
			
			throw $exception;
		}
		
		$this->log( "Fetching OneDot data from archive for {$strDate}..." );
		
		if ( $this->model->retrieveDataFromArchive( $strDate, $backendParams ) ) {
			$this->log( "Done." );
			
			while( ( $src = $this->model->fetchRawDataFilePath() ) !== false ) {
				$fileHandle = fopen( $src, "r" );
				$segments = array();
				$lineCount = 0;
				
				$this->log( "Processing: {$src}..." );
				
				while( !feof( $fileHandle ) ) {
					$lineCount++;
					try {
						$response = $this->internalParseOneDotData( fgets( $fileHandle ) );

						if ( $response ) {
							
							$data = $this->internalAnalyzeParsedData( $response );
									
							if ( !empty( $data ) ) {
								$key = "{$data->referrerID}_{$data->targetID}";
								
								if ( key_exists( $key, $segments ) ) {
									$segments[$key]->counter += 1;
								} else {
									$data->counter = 1;
									$segments[$key] = $data;
								}
								$segments[$key]->cityId = $data->cityID;
							}
						}
					} catch ( UserPathPredictionNoDataToParseException $e ) {
						$this->log( "No data to parse in {$src} at line {$lineCount}", UserPathPredictionLogService::LOG_TYPE_WARNING );
						continue;
					}
					
				}
	
				fclose( $fileHandle );
				$this->log( 'Found ' . count( $segments ) . ' valid segments.' );
				$this->model->storeAnalyzedData( $segments );
				$this->log( "Processing done." );
			}
			$this->model->cleanRawDataFolder();
		} else {
			$exception = new UserPathPredictionNoDataException();
			$this->log( "Failure: {$exception->getMessage()}", UserPathPredictionLogService::LOG_TYPE_ERROR );
			
			$this->app->wf->profileOut( __METHOD__ );
			
			throw $exception;
		}
		
		$this->app->wf->profileOut( __METHOD__ );
	}
	
	/**
	 * Analyzes the data extracted from OneDot archive for the local (current) wiki
	 * and store the results in DB
	 * 
	 * @see UserPathPredictionService::extractOneDotData
	 */
	public function analyzeLocalData(){
		$this->app->wf->profileIn( __METHOD__ );
		$wikiID = $this->wg->CityId;
		$dbName = strtolower( $this->wg->DBname );//need to make it small letters to match onedot records
		$filePath = $this->model->getWikiParsedDataPath( $dbName );
		
		if ( file_exists( $filePath ) ) {
			$fileHandle = fopen( $filePath , "r" );
			$segments = array();
			$lineCount = 0;
			
			$this->log( "Processing: {$filePath}..." );
			
			while( !feof( $fileHandle ) ) {
				$lineCount++;
				
				try {
					$data = $this->sendSelfRequest( 'analyzeParsedData', array( 'data' => unserialize( fgets( $fileHandle ) ) ) )->getVal( 'data' );
				} catch ( UserPathPredictionNoDataToAnalyzeException $e ) {
					$this->log( "No data to analyze in {$filePath} at line {$lineCount}", UserPathPredictionLogService::LOG_TYPE_WARNING );
					continue;
				}
				
				if ( !empty( $data ) ) {
					$key = "{$data->referrerID}_{$data->targetID}";
					
					if ( key_exists( $key, $segments ) ) {
						$segments[$key]->counter += 1;
					} else {
						$data->counter = 1;
						$segments[$key] = $data;
					}
				}
			}
			
			fclose( $fileHandle );
			$this->log( 'Found ' . count( $segments ) . ' valid segments.' );
			$this->model->storeAnalyzedData( $segments );
		} else {
			$this->log( 'No data found.', UserPathPredictionLogService::LOG_TYPE_WARNING );
		}
		
		$this->app->wf->profileOut( __METHOD__ );
	}
	
	public function cleanup(){
		$this->app->wf->profileIn( __METHOD__ );
		
		$this->model->cleanParsedDataFolder();
		$this->model->cleanRawDataFolder();
		
		$this->app->wf->profileOut( __METHOD__ );
	}
	
	public function getThumbnails( $articleIds = null, $width = null ) {
		$this->app->wf->profileIn( __METHOD__ );
		
		$articleIds = ( !empty( $articleIds ) ) ? $articleIds : $this->getVal( 'articleIds' );
		$width = ( !empty( $width ) ) ? $width : $this->getVal( 'width' );
		
		$source = new ImageServing(
			$articleIds,
			$width,
			array(
				"w" => 3,
				"h" => 2
			)
		);
		$result = $source->getImages( 1 );
		$this->setVal( 'thumbnails', $result );
		$this->app->wf->profileOut( __METHOD__ );
		return $result;	
	}
	
	/**
	 * @brief change colons to %3A in URL to match OneDot escaping
	 * 
	 * @param string $url the URL to escape
	 */
	private function escapeURL( $url ) {
		return str_replace( ":", "%3A", $url );
	}
	
	private function log( $msg, $type = UserPathPredictionLogService::LOG_TYPE_INFO ) {
		$this->sendRequest( 'UserPathPredictionLogService', 'log', array( 'msg' => $msg, 'type' => $type ) );
	}
}

class UserPathPredictionNoDataToParseException extends WikiaException{
	function __construct() {
		parent::__construct( 'No data to parse.' );
	}
}

class UserPathPredictionTargetDateMissingException extends WikiaException {
	function __construct() {
		parent::__construct( 'Target date not specified.' );
	}
}

class UserPathPredictionNoDataException extends WikiaException{
	function __construct() {
		parent::__construct( 'No data received from OneDot.' );
	}
}

class UserPathPredictionNoDataToAnalyzeException extends WikiaException{
	function __construct() {
		parent::__construct( 'No data to Analyze.' );
	}
}