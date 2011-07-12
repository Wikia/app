
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
		$this->app->wf->profileIn( __METHOD__ );
		if ( !$this->initialized ) {
			$this->model = F::build( 'UserPathPredictionModel' );
			$this->logPath = "/tmp/UserPathPrediction_" . date( 'Ymd' ) . ".log";
			F::setInstance( __CLASS__, $this );
			$this->initialized = true;
		}
		$this->app->wf->profileOut( __METHOD__ );
	}

	public function log( $msg = null ) {
		$this->app->wf->profileIn(__METHOD__);
		$msg = ( !empty( $msg ) ) ? $msg : $this->getVal( 'msg' );
		
		if( $this->wg->DevelEnvironment ) {
			file_put_contents( $this->logPath, date("H:i:s") . " : " . var_export( $msg, true ) . "\n", FILE_APPEND );
		}
		
		//reset the parameter value to avoid re-printing the same on internal calls, this class is a singleton
		$this->request->setVal( 'msg', null );
		$this->app->wf->profileOut(__METHOD__);
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
		$this->app->wf->profileIn(__METHOD__);
		$strDate = $this->getVal( 'date' );
		$backendParams = $this->getVal( 'backendParams', array() );
		
		if ( empty( $strDate ) ) {
			$this->app->wf->profileOut( __METHOD__ );
			throw new WikiaException( 'Target date not specified.' );
		}
		
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
							//cityId
							case "c":
							//article ID
							case "a" :
							//article namespace
							case "n":
							//User ID (if logged in)
							case "u":
								$result[$parameters[0]] = (int) $value;
								break;
							//referrer
							case "r" :
								$result["r"] = $value;
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
					
					if ( $skip == true || empty( $result['a'] ) || empty( $result['r'] ) || empty( $result['c'] ) ) {
						continue;
					}
					
					if ( array_key_exists( $result['c'], $this->getWikis() ) ) {
						$wiki = $this->wikis[$result['c']];
						$hasWikiPrefix = strpos( $wiki["domain_name"], '.wikia.com' );
						$mainURL = $this->fixURL( "http://{$wiki['domain_name']}/" );
						
						if( $hasWikiPrefix ) {
							$mainURL = "{$mainURL}wiki/";
						}
						
						if ( strpos( $result["r"], $mainURL ) === 0 ) {
							$articleName = str_ireplace( $mainURL, '', $result["r"] );
							
							if( !empty( $articleName ) ) {
								$result["r"] = $articleName;
								$this->model->saveParsedData( $wiki["db_name"], $result );
							}
						}
					}
				}
				
				fclose( $fileHandle );
				$this->log( "Done." );
			}
			
			$this->model->cleanRawDataFolder();
		} else {
			$this->log( "Failure." );
			$this->app->wf->profileOut( __METHOD__ );
			throw new WikiaException( "Cannot fetch data from OneDot archive." );
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
			
			$this->log( "Processing: {$filePath}..." );
			
			while( !feof( $fileHandle ) ) {
				$data = unserialize( fgets( $fileHandle ) );
				$title = F::build( 'Title', array( $data[ 'r' ] ), 'newFromText' );
				
				if ( !( $title instanceof Title && $title->exists() && $title->getArticleID() != $data[ 'a' ] ) ) {
					continue;
				}
				
				$referrerID = $title->getArticleID();
				$title = F::build( 'Title', array( $data[ 'a' ] ), 'newFromID' );
				
				if ( !( $title instanceof Title && $title->exists() ) ) {
					continue;
				}
				
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
			
			fclose( $fileHandle );
			$this->log( 'Found ' . count( $segments ) . ' valid segments.' );
			$this->model->storeAnalyzedData( $segments );
		} else {
			$this->log( 'No data found.' );
		}
		$this->app->wf->profileOut( __METHOD__ );
	}
	
	public function getWikis() {
		$this->app->wf->profileIn(__METHOD__);
		if ( empty( $this->wikis ) ) {
			$this->wikis = $this->model->getWikis();
		}
		
		$this->setVal( 'wikis', $this->wikis );
		$this->app->wf->profileOut( __METHOD__ );
		return $this->wikis;
	}
	
	public function cleanup(){
		$this->app->wf->profileIn(__METHOD__);
		$this->model->cleanParsedDataFolder();
		$this->model->cleanRawDataFolder();
		$this->app->wf->profileOut( __METHOD__ );
	}
	
	public function getThumbnails( $articleIds = null, $width = null ) {
		$this->app->wf->profileIn(__METHOD__);
		
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
}