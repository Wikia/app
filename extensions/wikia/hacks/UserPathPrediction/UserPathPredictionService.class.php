<?php
/**
 * User Path Prediction Service
 * @details This class is a singleton
 *
 * @author Jakub Olek <bukaj.kelo(at)gmail.com
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com
 */

class UserPathPredictionService extends WikiaService {
	
	const LOG_TYPE_INFO = 'INFO';
	const LOG_TYPE_WARNING = 'WARNING';
	const LOG_TYPE_ERROR = 'ERROR';
	private $model;
	private $logPath;
	private $initialized = false;
	
	public function init() {
		$this->model = F::build( 'UserPathPredictionModel' );
		if ( !$this->initialized ) {
			$this->logPath = "/tmp/UserPathPrediction_" . date( 'Ymd' ) . ".log";
			$this->initialized = true;
		}
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
	
	private function internalParseOneDotData( &$line ) {
		$this->app->wf->profileIn( __METHOD__ );
		
		if ( empty( $line ) ) {
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

				if ( !empty( $articleName ) ) {
					$data["r"] = $articleName;
					$result = $data;
				} else {
					$this->app->wf->profileOut( __METHOD__ );
					throw new UserPathPredictionNoDataToParseException( 'Missing referrer article name' );
				}
			}
		}
		
		$this->app->wf->profileOut( __METHOD__ );
		return $result;
	}
	
	public function analyzeParsedData() {
		$data = $this->getVal( 'data' );
		$output = array();
		$result = $this->internalAnalyzeParsedData( $data, $output );
		$this->setVal( 'data', $output );
	}
	
	private function internalAnalyzeParsedData( &$data, Array &$output ){
		$this->app->wf->profileIn( __METHOD__ );
		
		if ( empty( $data ) ) {
			$this->app->wf->profileOut( __METHOD__ );
			throw new UserPathPredictionNoDataToAnalyzeException();
		}

		if ( $title = SmarterGlobalTitle::smarterNewFromText( $data['r'], $data['c'], $data['x'] ) ) {
			if (
				$title instanceof Title &&
				$title->exists() &&
				$title->getArticleID() != $data[ 'a' ] &&
				!in_array( $title->getNamespace(), $this->wg->UserPathPredictionExludeNamespaces )
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
				throw new UserPathPredictionNoDataToAnalyzeException( 'Invalid title.' );
			}
		}
		
		$this->app->wf->profileOut( __METHOD__ );
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
			$this->log( $exception->getMessage(), self::LOG_TYPE_ERROR );
			
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
				$parseResult = "";
				$this->log( "Processing: {$src}..." );
				
				while( !feof( $fileHandle ) ) {
					$lineCount++;
					
					try {
						$parseResult = $this->internalParseOneDotData( fgets( $fileHandle ) );
					} catch ( UserPathPredictionNoDataToParseException $e ) {
						$this->log( "Parser error: {$e->getMessage()} ({$src} at line {$lineCount})", self::LOG_TYPE_WARNING );
						continue;
					}
					
					try{
						$this->internalAnalyzeParsedData( $parseResult, $segments );
					} catch ( UserPathPredictionNoDataToAnalyzeException $e ) {
						$this->log( "Analyzer error: {$e->getMessage()} ({$src} at line {$lineCount})", self::LOG_TYPE_WARNING );
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
			$this->log( "Failure: {$exception->getMessage()}", self::LOG_TYPE_ERROR );
			
			$this->app->wf->profileOut( __METHOD__ );
			
			throw $exception;
		}
		
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
	
	public  function log( $msg, $type = self::LOG_TYPE_INFO ) {
		
		$this->app->wf->profileIn( __METHOD__ );
		
		if ( $this->app->wg->DevelEnvironment ) {
			
			if ( isset( $msg ) ) {
				file_put_contents( $this->logPath, '[' . date("H:i:s") . "] {$type}: " . var_export( $msg, true ) . "\n", FILE_APPEND );
			}
		}
		
		$this->app->wf->profileOut( __METHOD__ );
	}
	
}

class UserPathPredictionNoDataToParseException extends WikiaException{
	function __construct( $msg = 'No data to parse.' ) {
		parent::__construct( $msg );
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
	function __construct( $msg = 'No data to Analyze.' ) {
		parent::__construct( $msg );
	}
}