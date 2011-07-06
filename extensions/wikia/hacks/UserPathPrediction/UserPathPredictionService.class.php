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
		$msg = $this->getVal( 'msg', $msg );
		
		if( $this->wg->DevelEnvironment ) {
			file_put_contents( $this->logPath, date("H:i:s") . " : " . var_export( $msg, true ) . "\n", FILE_APPEND );
		}
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
	 */
	function extractOneDotData() {
		$strDate = $this->getVal( 'date' );
		
		if ( empty( $strDate ) ) {
			throw new WikiaException( 'Target date not specified.' );
		}
		
		$this->model->cleanRawDataFolder();
		
		if ( empty ( $this->wikis ) ) {
			$this->wikis = $this->model->getWikis();
		}
		
		$this->log( "Fetching OneDot data from archive for {$strDate}..." );
		
		if( $this->model->retrieveDataFromArchive( $strDate ) ) {
			$this->log( "Done." );
			
			while( ( $src = $this->model->fetchRawDataFilePath() ) !== false ) {
				$fileHandle = fopen( $src , "r" );
				$skip = false;
				$result = array();
				
				$this->log( "Processing: {$src}..." );
				
				while( !feof( $fileHandle ) ) {
					$wholeLine = explode( "&", fgets( $fileHandle ));
					
					foreach( $wholeLine as $param ) {
						$parameters = explode( "=", $param );
						$value = $parameters[1];
						
						switch ( $parameters[0] ) {
							case "r" :
								$result["r"] = $value;
								break;
							case "a" :
								$result["a"] = $value;
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
						foreach ( $this->model->getWikis() as $wiki ) {
							$hasWikiPrefix = strpos( $wiki["domain_name"], '.wikia.com' );
							$mainURL = ( $hasWikiPrefix ) ? 
								$this->fixURL( "http://{$wiki['domain_name']}/" ) : 
								$this->fixURL( "http://www.{$wiki['domain_name']}/" );
							
							if ( strpos( $result["r"], $mainURL ) === 0 ) {
								$articleName = ( $hasWikiPrefix ) ?
									str_ireplace( $mainURL . 'wiki/', '', $result["r"] ) :
									$articleName = str_ireplace( $mainURL, '', $result["r"] );
								
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
}