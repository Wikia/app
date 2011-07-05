<?php
/**
 * @author Jakub Olek <bukaj.kelo(at)gmail.com
 *
 *
 */

class UserPathPredictionService extends WikiaService {
	private $wikis;
	private $model;

	public function init() {
		$this->model = new UserPathPredictionModel();
		$this->logPath = "/tmp/" . __CLASS__;
		
		unlink( $this->logPath );
	}

	private function log( $msg ) {
		if( $this->wg->DevelEnvironment ) {
			file_put_contents($this->logPath, var_export( date("Y-m-d H:i:s")." : ".$msg, true ) . "\n", FILE_APPEND);
		}
	}

	//change colons to %3A in URL
	private function fixURL( $url ) {
		return str_replace( ":", "%3A", $url );
	}

	//Parse - extracts needed data from downloaded onedot files
	function processOneDotData() {
		$this->model->cleanSourceFolder();
		
		if ( empty ( $this->wikis ) ) {
			$this->wikis = $this->model->getWikis();
		}
		
		$strDate = date( "Ymd", strtotime( "-1 day" ) );//"20110504";
		
		$this->log( "Fetching OneDot data for {$strDate}...\n" );
		
		if( $this->model->gets3Data( $strDate ) ) {
			$this->log( "Done.\n" );
			
			$this->model->cleanParsedDataFolder();
			
			while( ( $src = $this->model->getDataFilePath() ) !== false ) {
				$fileHandle = fopen( $src , "r" );
				$skip = false;
				$result = array();
				
				$this->log( "Processing: {$src}...\n" );
				
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
								$this->fixURL( "http://www{$wiki['domain_name']}/" );
							
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
				
				$this->log( "Done.\n" );
			}
			
			$this->log( "Cleaning up...\n" );
			$this->model->cleanSourceFolder();
		}
	}
}