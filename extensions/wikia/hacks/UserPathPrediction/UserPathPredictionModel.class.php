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
	private $wikis;
	private $app;
	private $excludePaths = array( ".", ".." );
	
	function __construct() {
		$this->app = F::app();
		//singleton
		F::setInstance( __CLASS__, $this );
	}
	
	public function retrieveDataFromArchive( $timestr, $extraParams = array(), &$commandOutput = null ) {
		$this->app->wf->profileIn(__METHOD__);
		
		$params = '';
		$s3directory = self::S3_ARCHIVE . "{$timestr}/";
		
		if ( !empty( $extraParams['s3ConfigFile'] ) ) {
			$params .= " -c {$extraParams['s3ConfigFile']}";
		}
		
		$cmd = "s3cmd get{$params} --recursive --skip-existing {$s3directory} " . self::RAW_DATA_PATH;
		
		$this->createDir( self::RAW_DATA_PATH );
		
		$this->log( "Running \"{$cmd}\" ..." );
		$commandOutput = shell_exec( $cmd );
		$this->log( "Done, command output: {$commandOutput}." );
		
		$tmpFiles = scandir( self::RAW_DATA_PATH );
		
		if ( is_array( $tmpFiles ) && count( $tmpFiles )  > 2 ) {
			$this->files = array_slice( $tmpFiles, 2 );
			$this->app->wf->profileOut(__METHOD__);
			return true;
		}
		
		$this->app->wf->profileOut(__METHOD__);
		return false;
	}
	
	public function fetchRawDataFilePath() {
		if ( is_array( $this->files ) ) {
			$ret = next( $this->files );
	
			if ( $ret === false ) {
				reset( $this->files );
				return false;
			} 
			
			return self::RAW_DATA_PATH . $ret;
		}
		
		return false;
	}
	
	public function saveParsedData( $dbName, $data ) {
		$this->app->wf->profileIn(__METHOD__);
		
		$this->createDir( self::PARSED_DATA_PATH );
		file_put_contents( $this->getWikiParsedDataPath( $dbName ) , serialize( $data ) . "\n", FILE_APPEND );
		
		$this->app->wf->profileOut(__METHOD__);
	}
	
	public function storeAnalyzedData( $data ) {
		$this->app->wf->profileIn(__METHOD__);
		
		$dbw = $this->getDBConnection( DB_MASTER );
		
		foreach ( $data as $segment ) {
			$sql = 'INSERT INTO `path_segments_archive` ' .
				'(`city_id`, `referrer_id`, `target_id`, `count`, `updated`) ' .
				'values (' . $dbw->addQuotes( $this->app->wg->CityId ) .
				', ' . $dbw->addQuotes( $segment->referrerID ) .
				', ' . $dbw->addQuotes( $segment->targetID ) .
				', ' . $dbw->addQuotes( $segment->counter ) . 
				', CURDATE() ) ON DUPLICATE KEY UPDATE ' .
				'`count` = (`count` + ' . $dbw->addQuotes( $segment->counter ) . '), ' . 
				'`updated` = CURDATE();';
				
			$this->log("Running SQL query: {$sql} ...");
			
			$result = $dbw->query( $sql, __METHOD__ );
			
			if ( $result === false ) {
				$exception = new UserPathPredictionDBException( $dbw->lastError() );
				$this->log( $exception->getMessage(), UserPathPredictionLogService::LOG_TYPE_ERROR );
				
				$this->app->wf->profileOut(__METHOD__);
				
				throw new $exception;
			}
		}
		
		$this->log( "Committing DB transaction..." );
		$dbw->commit();
		$dbw->close();
		$this->log( "Done." );
		
		$this->app->wf->profileOut(__METHOD__);
	}
	
	public function getWikis() {
		$this->app->wf->profileIn(__METHOD__);
		
		if ( empty( $this->wikis ) ) {
			$this->wikis = array();
			$data;
			
			if ( $this->app->wg->DevelEnvironment ) {
				$data = array(
					array( 'city_id' => '490', 'domain_name' => 'www.wowwiki.com' ),
					array( 'city_id' => '10150', 'domain_name' => 'dragonage.wikia.com' ),
					array( 'city_id' => '3125', 'domain_name' => 'callofduty.wikia.com' ),
					array( 'city_id' => '509', 'domain_name' => 'harrypotter.wikia.com'),
					array( 'city_id' => '26337', 'domain_name' => 'glee.wikia.com'),
					array( 'city_id' => '831', 'domain_name' => 'muppet.wikia.com'),
					array( 'city_id' => '1221', 'domain_name' => 'es.pokemon.wikia.com'),
				);
			} else {
				//TODO: get data from WF before reaching production, this is just a stub/mock
				$data = array();
			}
			
			foreach ( $data as $item ) {
				$obj = new stdClass();
				
				$obj->domain = $item['domain_name'];
				$obj->hasPrefix = ( strpos( $item['domain_name'], '.wikia.com' ) !== false );
				
				$this->wikis[$item['city_id']] = $obj;
			}
		}
		
		$this->app->wf->profileOut(__METHOD__);
		return $this->wikis;
	}
	
	function getWikiParsedDataPath( $dbName ) {
		return self::PARSED_DATA_PATH . $dbName;
	}
	
	public function cleanParsedDataFolder() {
		$this->removePath( self::PARSED_DATA_PATH );
	}
	
	public function cleanRawDataFolder() {
		$this->removePath( self::RAW_DATA_PATH );
		$this->files = null;
	}
	
	public function getNodes( $cityId, $articleId, $dateSpan = 30, $nodeCount = 10 ,$pathsNumber = 3) {
		$this->app->wf->profileIn(__METHOD__);
		
		$resultArray = array();
		$onePath = array();
		$dateString = "-" . $dateSpan . " day";
		$date = date( "Ymd", strtotime( $dateString ) );
		$dbr =$this->getDBConnection();
		$prevTargetId;
		$firstTargetId;
		$where = array( 'city_id' => $cityId, 'referrer_id' => $articleId, 'updated > ' . $date);
		
		$related = $dbr->select( 'path_segments_archive', '*', $where , __METHOD__, array( "LIMIT" => $pathsNumber, "ORDER BY" => "count DESC" ));
		
		while ( $next = $dbr->fetchObject( $related ) ) {
		
			$onePath[] = $next;
			$articleId = $next->target_id;
			$prevTargetId = $next->referrer_id;
			
			for ( $i = 0; $i < $nodeCount; $i++ ) {
	
				$where = array( 'city_id' => $cityId, 'referrer_id' => $articleId, 'updated > ' . $date);
				
				if ( $i > 0 && !empty( $prevTargetId ) ) {
					$where[] = 'target_id != ' . $prevTargetId ;
				}
				
				$res = $dbr->select( 'path_segments_archive', '*', $where , __METHOD__, array( "LIMIT" => 1, "ORDER BY" => "count DESC" ));
	
				if ( $row = $dbr->fetchObject( $res ) ) {
		
					$articleId = $row->target_id;
					$prevTargetId = $row->referrer_id;
					
					if ( $i == 0 ) {
						
						$firstTargetId = $prevTargetId;
						$onePath[] = $row;
						
					} else {
						
						if ( $articleId == $firstTargetId  ) {
							
							break;
							
						} else {
							
							$onePath[] = $row;	
							
						}
						
					}
					
				}
			}
			
			$resultArray[] = $onePath;
			$onePath = array();
		
		}
		
		$this->app->wf->profileOut(__METHOD__);
		return $resultArray;
	}
	
	public function getRelated( $cityId, $articleId, $dateSpan = 30 ) {
		$this->app->wf->profileIn(__METHOD__);
		$resultArray = array();
		$dbr =$this->getDBConnection();
		
		$where = array( 'city_id' => $cityId, 'referrer_id' => $articleId );	
		
		$res = $dbr->select( 'path_segments_archive', '*', $where , __METHOD__, array( "LIMIT" => 10, "ORDER BY" => "count DESC" ));

		while ( $row = $dbr->fetchObject( $res ) ) {
			$resultArray[] = $row;
		}
		$this->app->wf->profileOut(__METHOD__);
		return $resultArray;
	}
	
	private function log( $msg, $type = UserPathPredictionLogService::LOG_TYPE_INFO ) {
		$this->app->sendRequest( 'UserPathPredictionLogService', 'log', array( 'msg' => $msg, 'type' => $type ) );
	}
	
	private function getDBConnection( $mode = DB_SLAVE ) {
		$this->app->wf->profileIn(__METHOD__);
		//TODO: replace with wfGetDB as soon as we stop using local DB for devboxes and get production storage
		if (
			empty( $this->app->wg->UserPathPredictionDBserver ) ||
			empty( $this->app->wg->UserPathPredictionDBname ) ||
			empty( $this->app->wg->UserPathPredictionDBuser ) ||
			empty( $this->app->wg->UserPathPredictionDBpassword )
		) {
			$exception = new UserPathPredictionMissingDBSettingsException();
			$this->log( $exception->getMessage(), UserPathPredictionLogService::LOG_TYPE_ERROR );
			
			$this->app->wf->profileOut(__METHOD__);
			
			throw $exception;
		}
		
		$this->app->wf->profileOut(__METHOD__);
		return Database::newFromParams(
			$this->app->wg->UserPathPredictionDBserver,
			$this->app->wg->UserPathPredictionDBuser,
			$this->app->wg->UserPathPredictionDBpassword,
			$this->app->wg->UserPathPredictionDBname
		);
	}
	
	private function createDir( $folder ) {
		$this->app->wf->profileIn(__METHOD__);
		
		if ( !is_dir( $folder ) ) {
			$this->log( "Creating {$folder} ...");
			return mkdir( $folder, 0777, true );
		}
		
		$this->app->wf->profileOut(__METHOD__);
	}
	
	private function removePath( $path ) {
		$this->app->wf->profileIn(__METHOD__);
		
		if ( is_dir( $path ) ) {
			$this->log( "Removing {$path} ...");	
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
			$this->app->wf->profileOut(__METHOD__);
			return rmdir( $path );
		} elseif ( is_file( $path ) ) {
			$this->app->wf->profileOut(__METHOD__);
			return unlink ( $path );
		}
		
		return true;
	}
}

//the following exception classes extend Exception since MWException triggers blank pages when raised from a WikiaSpecialPageController subclass
//TODO: convert to MWException as the Nirvana bug gets fixed

class UserPathPredictionMissingDBSettingsException extends Exception {
	function __construct(){
		parent::__construct( 'Missing settings for UserPathPrediction DB' );
	}
}

class UserPathPredictionDBException extends Exception {
	function __construct( $msg ){
		parent::__construct( "DB error: {$msg}." );
	}
}
