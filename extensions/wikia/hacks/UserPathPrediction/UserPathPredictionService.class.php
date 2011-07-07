<?php
/**
 * User Path Prediction Service
 * @details This class is a singleton
 *
 * @author Jakub Olek <bukaj.kelo(at)gmail.com
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com
 */

class UserPathPredictionService extends WikiaService {
	private $wikis;
	private $model;
	private $logPath;
	private $initialized = false;

	public function init() {
		if ( !$this->initialized ) {
			$this->model = F::build( 'UserPathPredictionModel' );
			$this->logPath = "/tmp/UserPathPrediction_" . date( 'Ymd' ) . ".log";
			F::setInstance( __CLASS__, $this );
			$this->initialized = true;
		}
	}

	public function log( $msg = null ) {
		$msg = ( !empty( $msg ) ) ? $msg : $this->getVal( 'msg' );
		
		if( $this->wg->DevelEnvironment ) {
			file_put_contents( $this->logPath, date("H:i:s") . " : " . var_export( $msg, true ) . "\n", FILE_APPEND );
		}
		
		//reset the parameter value to avoid re-printing the same on internal calls, this class is a singleton
		$this->request->setVal( 'msg', null );
	}

	//change colons to %3A in URL
	private function fixURL( $url ) {
		return str_replace( ":", "%3A", $url );
	}

	/**
	 * @brief Downloads data for the requested date from OneDot S3 Archive and extracts the data for the wikis of interest
	 * @details Produces a series of intermediate files, one per each wiki, those will need further processing
	 * 
	 * @requestParam string $date the target date for the data to be downloaded and extracted
	 * @requestParam array $backendParams any extra configuration to pass to the backend storage
	 */
	function extractOneDotData() {
		$strDate = $this->getVal( 'date' );
		$backendParams = $this->getVal( 'backendParams', array() );
		
		if ( empty( $strDate ) ) {
			throw new WikiaException( 'Target date not specified.' );
		}
		
		$this->model->cleanRawDataFolder();
		
		$this->log( "Fetching OneDot data from archive for {$strDate}..." );
		
		if( $this->model->retrieveDataFromArchive( $strDate, $backendParams ) ) {
			$this->log( "Done." );
			
			while( ( $src = $this->model->fetchRawDataFilePath() ) !== false ) {
				$fileHandle = fopen( $src , "r" );
				$result = array();
				
				$this->log( "Processing: {$src}..." );
				
				while( !feof( $fileHandle ) ) {
					$skip = false;
					$wholeLine = explode( "&", fgets( $fileHandle ));
					
					foreach( $wholeLine as $param ) {
						$parameters = explode( "=", $param );
						$value = $parameters[1];
						
						switch ( $parameters[0] ) {
							case "r" :
								$result["r"] = $value;
								break;
							case "a" :
								$result["a"] = (int) $value;
								break;
							case "lv" :
								$result["lv"] = $value;
								break;
							case "event":
								//we take into consideration only pure pageviews, no events tracking requests
								//this avoids duplicated data popping up and screw the stats
								$skip = true;
								break;
						}
						
						if ( $skip == true ) {
							break;
						}
					}
					
					if ($skip == true ) {
						continue;
					}
					
					if ( !empty( $result["r"] ) ) {
						foreach ( $this->getWikis() as $wiki ) {
							$hasWikiPrefix = strpos( $wiki["domain_name"], '.wikia.com' );
							$mainURL = ( $hasWikiPrefix ) ? 
								$this->fixURL( "http://{$wiki['domain_name']}/" ) : 
								$this->fixURL( "http://www.{$wiki['domain_name']}/" );
							
							if ( strpos( $result["r"], $mainURL ) === 0 ) {
								$articleName = ( $hasWikiPrefix ) ?
									str_ireplace( $mainURL . 'wiki/', '', $result["r"] ) :
									str_ireplace( $mainURL, '', $result["r"] );
								
								if( !empty( $articleName ) ) {
									$result["r"] = $articleName;
									$this->model->saveParsedData( $wiki["db_name"], $result );	
								}
							}
						}
					}
				}
				
				fclose( $fileHandle );
				$this->log( "Done." );
			}
			
			$this->log( "Cleaning up..." );
			$this->model->cleanRawDataFolder();
			$this->log( "Done." );
		} else {
			$this->log( "Failure." );
			throw new WikiaException( "Cannot fetch data from OneDot archive." );
		}
	}
	
	/**
	 * Analyzes the data extracted from OneDot archive for the local (current) wiki
	 * and store the results in DB
	 * 
	 * @see UserPathPredictionService::extractOneDotData
	 */
	public function analyzeLocalData(){
		$wikiID = $this->wg->CityId;
		$dbName = strtolower( $this->wg->DBname );//need to make it small letters to match onedot records
		$filePath = $this->model->getWikiParsedDataPath( $dbName );
		
		if ( file_exists( $filePath ) ) {
			$fileHandle = fopen( $filePath , "r" );
			$segments = array();
			
			$this->log( "Processing: {$filePath}..." );
			
			while( !feof( $fileHandle ) ) {
				$data = unserialize( fgets( $fileHandle ) );
				
				$referrer = $data[ 'r' ];
				$title = F::build( 'Title', array( $referrer ), 'newFromText' );
				
				if ( $title instanceof Title && $title->exists() && $title->getArticleID() != $data[ 'a' ] ) {
					$referrerID = $title->getArticleID();
					$targetID = $data[ 'a' ];
					$key = "{$referrerID}_{$targetID}";
					
					if ( key_exists( $key, $segments ) ) {
						$segments[$key]->counter += 1;
					} else {
						$obj = new stdClass();
						
						$obj->counter = 1;
						$obj->referrerID = (int) $referrerID;
						$obj->targetID = (int) $targetID;
						
						$segments[$key] = $obj;
					}
				}
			}
			
			fclose( $fileHandle );
			$this->log( 'Found ' . count( $segments ) . ' valid segments.' );
			$this->model->storeAnalyzedData( $segments );
		} else {
			$this->log( 'No data found.' );
		}
	}
	
	public function getWikis() {
		if ( empty( $this->wikis ) ) {
			$this->wikis = $this->model->getWikis();
		}
		
		$this->setVal( 'wikis', $this->wikis );
		return $this->wikis;
	}
}