<?php
/**
 * @author Jakub Olek <bukaj.kelo(at)gmail.com
 *
 *
 */

class UserPathPredictionService extends WikiaService {

	//VARS
	private $wikis, $yesterday, $model;

	public function init() {
		$this->logPath = "/tmp/" . __CLASS__;
		//$yesterday = date("Ymd", strtotime("-1 day"));
		$this->yesterday = "20110504";	
		$this->model = new UserPathPredictionModel();
	}

	private function log( $msg ) {
		if( $this->wg->DevelEnvironment ) {
			file_put_contents($this->logPath, var_export( $msg, true ) . "\n", FILE_APPEND);
		}
	}

	//change colons to %3A in URL
	private function fixURL( $url ) {
		return str_replace( ":", "%3A", $url );
	} //end of colons to %3A

	//Parse - extracts needed data from downloaded onedot files
	function processOneDotData() {
		//TODO: move to model
		$this->wikis = $this->model->getWikis();
		$this->model->gets3Data($this->yesterday);		
		$this->model->resetParsedData();
		
		$this->log( "Starting parsing part\n" );

		while( ( $src = $this->model->getContent() ) === false ) {

			$fileHandle = fopen( $src );
			while( !feof( $fileHandle ) ) {
				$wholeLine = explode( "&", fgets( $fileHandle ));
				$result = array();
				foreach( $wholeLine as $param ) {
					$parameters = explode( "=", $param );
					$value = $parameters[1];
					switch( $parameters[0] ) {
						case "c" :
							$result["c"] = $value;
							break;
						case "r" :
							$result["r"] = $value;
							break;
						case "a" :
							$result["a"] = $value;
							break;
						case "lv" :
							$result["lv"] = $value;
							break;
					}
				}
				if( !empty( $result["r"] ) ) {
					foreach( $this->model->getWikis() as $wiki ) {
						$hasWikiPrefix = strpos( $wiki["domain_name"], '.wikia.com' );
						$mainURL = ( $hasWikiPrefix ? 
							$this->fixURL('http://' . $wiki["domain_name"] . '/') : 
							$this->fixURL('http://www.' . $wiki["domain_name"] . '/') );
							
						if( strpos( $result["r"], $mainURL ) === 0 ) {
							if( $hasWikiPrefix) {
								$articleName = str_ireplace( $mainURL . 'wiki/', '', $result["r"] );
							} else {
								$articleName = str_ireplace( $mainURL, '', $result["r"] );
							}

							$title = Title::newFromText( rawurlencode($articleName) );
							
							if( $title->exists() ) {
								$result["r"] = $title->getArticleID();
								$this->model->saveParsedData( $wikis["db_name"], $result );	
							}
						}
					}
				}
			}
			fclose( $fileHandle );
			$this->log( "File " . $src . " has been processed\n" );
		}
		$this->model->cleanSourceFolder();
	}
}