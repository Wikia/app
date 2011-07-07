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
		if (
			empty( $this->app->wg->UserPathPredictionDBserver ) ||
			empty( $this->app->wg->UserPathPredictionDBname ) ||
			empty( $this->app->wg->UserPathPredictionDBuser ) ||
			empty( $this->app->wg->UserPathPredictionDBpassword )
		) {
			throw new Exception( 'Missing settings for UserPathPrediction DB' );
		}
		
		return Database::newFromParams(
			$this->app->wg->UserPathPredictionDBserver,
			$this->app->wg->UserPathPredictionDBuser,
			$this->app->wg->UserPathPredictionDBpassword,
			$this->app->wg->UserPathPredictionDBname
		);
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
	
	public function retrieveDataFromArchive( $timestr, $extraParams = array(), &$commandOutput = null ) {
		$params = '';
		$s3directory = self::S3_ARCHIVE . "{$timestr}/";
		
		if ( empty( $extraParams['s3ConfigFile'] ) ) {
			$params += " -c {$extraParams['s3ConfigFile']}";
		}
		
		$cmd = "s3cmd get{$params} --recursive {$s3directory} " . self::RAW_DATA_PATH;
		
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
		$dbw = $this->getDBConnection( DB_MASTER );
		
		foreach ( $data as $segment ) {
			$sql = 'INSERT INTO `path_segments_archive` ' .
				'(`city_id`, `referrer_id`, `target_id`, `count`, `updated`) ' .
				'values (' . $dbw->addQuotes( $this->app->wg->CityId ) .
				', ' . $dbw->addQuotes( $segment->referrerID ) .
				', ' . $dbw->addQuotes( $segment->targetID ) .
				', ' . $dbw->addQuotes( $segment->counter ) . 
				', CURDATE() ) ON DUPLICATE KEY UPDATE count = (count + ' . $dbw->addQuotes( $segment->counter ) . '); ';
				
			$this->log("Running SQL query: " . substr( $sql, 0, 350 ) . " [...]");
			
			$result = $dbw->query( $sql, __METHOD__ );
			
			if ( $result === false ) {
				$error = 'DB error: ' . $dbw->lastError();
				
				$this->log( $error );
				throw new WikiaException( $error );
			}
		}
		
		$this->log("Committing DB transaction...");
		$dbw->commit();
		$dbw->close();
		$this->log("Done.");
		
		$this->log("Cleaning up...");
		$this->cleanParsedDataFolder();
		$this->log("Done.");
	}
	
	public function getWikis() {
		//TODO: get data from WF
		
		//TODO: IMPORTANT, remember to strtolower the db name otherwise it won't always match onedot records!!!
		return array(
			array(
				"citi_id" => "490",
				"db_name" => "wowwiki",
				"domain_name" => "wowwiki.com"
			),
			array(
				"citi_id" => "10150",
				"db_name" => "dragonage",
				"domain_name" => "dragonage.wikia.com"
			),
			array(
				"citi_id" => "3125",
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
	
	public function getNodes( $citiId, $articleId, $nodeCount = 10 ) {
				
		$resultArray = array();
		
			
		$dbr =$this->getDBConnection();
		
		
		for( $i = 0; $i++; $i < $nodeCount ) {
				
			$res = $dbr->select( 'path_segments_archive', 'citi_id, referrer_id, target_id, count, updated', array( 'city_id' => $citiId, 'referrer_id' => $articleId ), __METHOD__);
		return $dbr->lastQuery();
			while( $row = $dbr->fetchObject( $res ) ) {
				$result = array (
						'citi_id' => $row->citi_id,
						'referrer_id' => $row->referrer_id,
						'target_id' => $row->target_id,
						'count' => $row->count,
						'updated' => $row->updated
					);
			}
			$resultArray[] = $result;

		}  
		
		
	}
	
}
