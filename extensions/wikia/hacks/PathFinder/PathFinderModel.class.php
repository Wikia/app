<?php
/**
 * A Model for User Path Prediction data
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class PathFinderModel {
	const S3_ARCHIVE = "s3://one_dot_archive/";
	const RAW_DATA_PATH = "/tmp/PathFinderRawData/";
	const SEGMENTS_TABLE = 'path_segments_count';
	const DOORWAYS_TABLE = 'path_external_keywords_count';
	
	private $files;
	private $wikis;
	private $app;
	private $logger;
	private $excludePaths = array( ".", ".." );
	
	function __construct() {
		$this->app = F::app();
		$this->logger = (new PathFinderLogger);
		
		//singleton
		F::setInstance( __CLASS__, $this );
	}
	
	public function retrieveDataFromArchive( $timestr, $extraParams = array(), &$commandOutput = null ) {
		wfProfileIn( __METHOD__ );
		
		$params = '';
		$s3directory = self::S3_ARCHIVE . "{$timestr}/";
		
		if ( !empty( $extraParams['s3ConfigFile'] ) ) {
			$params .= " -c {$extraParams['s3ConfigFile']}";
		}
		
		$cmd = "s3cmd get{$params} --recursive --skip-existing {$s3directory} " . self::RAW_DATA_PATH;
		
		$this->createDir( self::RAW_DATA_PATH );
		
		$this->logger->log( "Running \"{$cmd}\" ..." );
		$commandOutput = shell_exec( $cmd );
		$this->logger->log( "Done, command output: {$commandOutput}." );
		
		$tmpFiles = scandir( self::RAW_DATA_PATH );
		
		if ( is_array( $tmpFiles ) && count( $tmpFiles )  > 2 ) {
			//skip . and ..
			$this->files = array_slice( $tmpFiles, 2 );
			
			wfProfileOut( __METHOD__ );
			return true;
		}
		
		wfProfileOut( __METHOD__ );
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
	
	public function storeAnalyzedData( &$data ) {
		wfProfileIn( __METHOD__ );
		$dbw = $this->getDBConnection( DB_MASTER );
		$logSQL = true;
		$this->logger->log("Running SQL queries...");
		
		foreach ( $data as $segment ) {
			$sql = 'INSERT INTO `' . self::SEGMENTS_TABLE . '` ' .
				'(`city_id`, `referrer_id`, `target_id`, `count`, `updated`) ' .
				'values (' . $dbw->addQuotes( $segment->cityID ) .
				', ' . $dbw->addQuotes( $segment->referrerID ) .
				', ' . $dbw->addQuotes( $segment->targetID ) .
				', ' . $dbw->addQuotes( $segment->counter ) . 
				', CURDATE() ) ON DUPLICATE KEY UPDATE ' .
				'`count` = (`count` + ' . $dbw->addQuotes( $segment->counter ) . '), ' . 
				'`updated` = CURDATE();';
			
			if ( $logSQL ) {
				$this->logger->log( "Example query: {$sql}" );
				$logSQL = false;
			}
			
			$result = $dbw->query( $sql, __METHOD__ );
			
			if ( $result === false ) {
				$exception = new PathFinderDBException( $dbw->lastError() );
				$this->logger->log( $exception->getMessage(), PathFinderLogger::LOG_TYPE_ERROR );
				
				wfProfileOut( __METHOD__ );
				
				throw new $exception;
			}
		}
		
		$this->logger->log( "Committing DB transaction..." );
		$dbw->commit();
		$dbw->close();
		$this->logger->log( "Committing done." );
		
		wfProfileOut( __METHOD__ );
	}
	
	public function getWikis() {
		wfProfileIn( __METHOD__ );
		
		if ( empty( $this->wikis ) ) {
			$this->wikis = array();

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
				$this->wikis[$item['city_id']] = $obj;
			}
		}
		
		wfProfileOut( __METHOD__ );
		return $this->wikis;
	}
	
	public function cleanRawDataFolder() {
		$this->removePath( self::RAW_DATA_PATH );
		$this->files = null;
	}
	
	public function getPath( $cityId, $articleId, $dateSpan = 30, $maxNodesCount = 10 , $count = 1, $minVisitsCount = 1) {
		wfProfileIn( __METHOD__ );
		
		$resultArray = array();
		
		//no memcache for the time being, it will come when this will be ready for production
		$entryPoints = $this->getEntryPoints( $cityId, $articleId, $count, $dateSpan, $minVisitsCount );
		
		foreach ( $entryPoints as $firstNode ) {
			$path = array( $firstNode );
			$articleId = $firstNode->target_id;
			$prevTargetIds = array( $articleId );
			
			for ( $i = 0; $i < ( $maxNodesCount - 1 ); $i++ ) {
				//no memcache for the time being, it will come when this will be ready for production
				$nextNode = $this->getEntryPoints( $cityId, $articleId, 1, $dateSpan, $minVisitsCount, array( 'target_id NOT IN (' . implode( ',', $prevTargetIds ) . ')' ) );
				
				if ( !empty( $nextNode[0] ) > 0 ) {
					$node = $nextNode[0];
					$articleId = $node->target_id;
					$prevTargetIds[] = $node->referrer_id;
					$path[] = $node;
				}
			}
			
			$resultArray[] = $path;
		}
		
		wfProfileOut( __METHOD__ );
		return $resultArray;
	}
	
	public function getRelated( $cityId, $articleId, $dateSpan = 30 ,$count = 3 , $minVisitsCount = 1 ) {
		wfProfileIn( __METHOD__ );
		
		//no memcache for the time being, it will come when this will be ready for production
		$entryPoints = $this->getEntryPoints( $cityId, $articleId, $count, $dateSpan, $minVisitsCount );
		
		wfProfileOut( __METHOD__ );
		return $entryPoints;
	}
	
	private function getEntryPoints( $cityId, $articleId, $count, $dateSpan, $minVisitsCount, $whereParams = null ){
		wfProfileIn( __METHOD__ );
		$dateString = "-" . $dateSpan . " day";
		$date = date( "Ymd", strtotime( $dateString ) );
		$dbr =$this->getDBConnection();
		$result = array();
		$where = array(
			"LIMIT" => $count,
			"ORDER BY" => "count DESC"
		);
		
		if ( !empty( $whereParams ) ) {
			$where = array_merge( $where, $whereParams );
		}
		
		//no memcache for the time being, it will come when this will be ready for production
		$entryPoints = $dbr->select(
			self::SEGMENTS_TABLE,
			array( 'city_id', 'referrer_id', 'target_id', 'count' ),
			array(
				'city_id' => $cityId,
				'referrer_id' => $articleId,
				'updated >= ' . $date,
				'count >= ' . $minVisitsCount
			),
			__METHOD__,
			$where
		);
		
		while ( $row = $dbr->fetchObject( $entryPoints ) ) {
			$result[] = $row;
		}
		
		$dbr->freeResult( $entryPoints );
		
		wfProfileOut( __METHOD__ );
		return $result;
	}
	
	private function getDBConnection( $mode = DB_SLAVE ) {
		wfProfileIn( __METHOD__ );
		
		//TODO: replace with wfGetDB as soon as we stop using local DB for devboxes and get production storage
		$dbServer = $this->app->wg->PathFinderDBserver;
		$dbName = $this->app->wg->PathFinderDBname;
		$dbUser = $this->app->wg->PathFinderDBuser;
		$dbPassword = $this->app->wg->PathFinderDBpassword;
		
		if (
			empty( $dbServer ) ||
			empty( $dbName ) ||
			empty( $dbUser ) ||
			empty( $dbPassword )
		) {
			$exception = new PathFinderMissingDBSettingsException();
			$this->logger->log( $exception->getMessage(), PathFinderLogger::LOG_TYPE_ERROR );
			
			wfProfileOut( __METHOD__ );
			
			throw $exception;
		}
		
		$db = Database::newFromParams(
				$dbServer,
				$dbUser,
				$dbPassword,
				$dbName
			);
		
		wfProfileOut( __METHOD__ );
		return $db;
	}
	
	private function createDir( $folder ) {
		wfProfileIn( __METHOD__ );
		
		if ( !is_dir( $folder ) ) {
			$this->logger->log( "Creating {$folder} ...");
			return mkdir( $folder, 0777, true );
		}
		
		wfProfileOut( __METHOD__ );
	}
	
	private function removePath( $path ) {
		wfProfileIn( __METHOD__ );
		
		/*if ( is_dir( $path ) ) {
			$this->logger->log( "Removing {$path} ...");
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
			wfProfileOut( __METHOD__ );
			return rmdir( $path );
		} elseif ( is_file( $path ) ) {
			wfProfileOut( __METHOD__ );
			return unlink ( $path );
		}*/
		
		return true;
	}
}

class PathFinderMissingDBSettingsException extends WikiaException {
	function __construct(){
		parent::__construct( 'Missing settings for PathFinder DB' );
	}
}

class PathFinderDBException extends WikiaException {
	function __construct( $msg ){
		parent::__construct( "DB error: {$msg}." );
	}
}
