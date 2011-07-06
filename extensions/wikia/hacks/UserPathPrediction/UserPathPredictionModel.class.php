<?php
/**
 * A Model for User Path Prediction data
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class UserPathPredictionModel {
	const S3_ARCHIVE = "s3://one_dot_archive/";
	const RAW_DATA_PATH = "/tmp/UserPathPredictionRawData/";
	const PARSED_DATA_PATH = "/tmp/UserPathPredictionParsedData/";
	
	private $files;
	private $app;
	private $excludePaths = array( ".", ".." );
	
	function __construct() {
		$this->app = F::app();
	}

	private function createDir( $folder ) {
		if( !is_dir( $folder )) {
			return mkdir( $folder, 0777, true );
		}
	}
	
	private function log ( $msg ) {
		$this->app->sendRequest( 'UserPathPredictionService', 'log', array( 'msg' => $msg ) );
	}
	
	private function getDBConnection( $mode = DB_SLAVE ) {
		//TODO: replace with wfGetDB as soon as we stop using local DB for devboxes and get production storage
		return Database::newFromParams( 'localhost', $this->app->wg->DBadminuser, $this->app->wg->DBadminpassword, 'user_path_prediction' );
	}
	
	private function removePath( $path ) {
		if ( is_dir( $path ) ) {
			$objects = scandir( $path );
			
			foreach ( $objects as $object ) {
				if ( !in_array( $object, $this->excludePaths ) ) {
					$fullPath = "{$path}/{$object}";
					
					if ( filetype( $fullPath ) == 'dir' ) {
						$this->removePath( $fullPath );
					} else {
						unlink( $fullPath );
					}
				}
			}
			
			reset( $objects );
			return rmdir( $path );
		} elseif ( is_file( $path ) ) {
			return unlink ( $path );
		}
		
		return false;
	} 
	
	public function retrieveDataFromArchive( $timestr, &$commandOutput = null ) {
		$s3directory = self::S3_ARCHIVE . "{$timestr}/";
		$cmd = "s3cmd get --recursive {$s3directory} " . self::RAW_DATA_PATH;
		
		$this->cleanRawDataFolder();
		$this->createDir( self::RAW_DATA_PATH );
		
		$this->log( "Running \"{$cmd}\" ..." );
		$commandOutput = shell_exec( $cmd );
		$this->log( "Done, command output: {$commandOutput}." );
		
		$tmpFiles = scandir( self::RAW_DATA_PATH );
		
		if ( is_array( $tmpFiles ) && count( $tmpFiles )  > 2 ) {
			$this->files = array_slice( $tmpFiles, 2 );
			return true;
		}
		
		return false;
	}
	
	public function fetchRawDataFilePath() {
		$ret = next( $this->files );

		if ( $ret === false ) {
			reset( $this->files );
			return false;
		} 
		
		return self::RAW_DATA_PATH . $ret;
	}
	
	public function saveParsedData( $dbName, $data ) {
		$this->createDir( self::PARSED_DATA_PATH );
		file_put_contents( $this->getWikiParsedDataPath( $dbName ) , serialize( $data ) . "\n", FILE_APPEND );
	}
	
	public function storeAnalyzedData( $data ) {
		global $wgAllDBsAreLocalhost;
		$origValue = $wgAllDBsAreLocalhost;
		$wgAllDBsAreLocalhost = true;
		
		$dbw = $this->wf->getDB( DB_MASTER, null, self::DB_NAME );
		
		$this->cleanParsedDataFolder();
	}
	
	public function getWikis() {
		//TODO: get data from WF
		
		//TODO: IMPORTANT, remember to strtolower the db name otherwise it won't always match onedot records!!!
		return array(
			"490" => array(
				"db_name" => "wowwiki",
				"domain_name" => "wowwiki.com"
			),
			"10150" => array(
				"db_name" => "dragonage",
				"domain_name" => "dragonage.wikia.com"
			),
			"3125" => array(
				"db_name" => "callofduty",
				"domain_name" => "callofduty.wikia.com"
			)
		);
	}
	
	function getWikiParsedDataPath( $dbName ) {
		return self::PARSED_DATA_PATH . $dbName;
	}
	
	public function cleanParsedDataFolder() {
		$this->removePath( self::PARSED_DATA_PATH );
	}
	
	public function cleanRawDataFolder() {
		$this->removePath( self::RAW_DATA_PATH );
	}
}
