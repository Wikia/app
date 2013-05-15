<?php
/**
 * Created by adam
 * Date: 10.05.13
 */

class RevisionService {
	/**
	 * @var DatabaseBase
	 */
	private $databaseConnection;
	/**
	 * @var int
	 */
	private $cacheTime;

	/**
	 * @param DatabaseBase $databaseConnection
	 * @param int $cacheTime
	 */
	function __construct( $databaseConnection = null, $cacheTime = 3600 ) {
		if( $databaseConnection == null ) {
			$databaseConnection = wfGetDB( DB_SLAVE );
		}
		$this->cacheTime = $cacheTime;
		$this->databaseConnection = $databaseConnection;
	}

	/**
	 * @param $limit int limit number of results.
	 * @param $namespaces array list of namespaces to filter by. No filter applied if null
	 * @param $allowDuplicates bool if false there will be at most one result per page
	 * @return array
	 */
	public function getLatestRevisions( $limit, $namespaces, $allowDuplicates ) {
		$key = $this->createCacheKey( $limit, $namespaces, $allowDuplicates );
		return WikiaDataAccess::cache( $key, $this->cacheTime, function() use( $limit, $namespaces, $allowDuplicates ) {
			return $this->getLatestRevisionsNoCache( $limit, $namespaces, $allowDuplicates );
		});
	}

	/**
	 * @param $limit int limit number of results.
	 * @param $namespaces array list of namespaces to filter by. No filter applied if null
	 * @param $allowDuplicates bool if false there will be at most one result per page
	 * @return array
	 */
	public function getLatestRevisionsNoCache( $limit, $namespaces, $allowDuplicates ) {
		$limit = intval($limit);

		$result = $this->getLatestRevisionsQuery( $limit, $namespaces, $allowDuplicates );

		$items = array();
		while( ( $row = $result->fetchObject() ) !== false ) {
			$dateTime = date_create_from_format( 'YmdHis', $row->timestamp );
			$items[  ] = array(
				'article'    => intval($row->pageId),
				'user'       => intval($row->userId),
				'revisionId' => intval($row->id),
				'timestamp'  => $dateTime->getTimestamp()
			);
		}
		return $items;
	}

	/**
	 * @param $limit int limit number of results.
	 * @param $namespaces array list of namespaces to filter by. No filter applied if null
	 * @param $allowDuplicates bool if false there will be at most one result per page
	 * @return ResultWrapper
	 */
	public function getLatestRevisionsQuery( $limit, $namespaces, $allowDuplicates ) {
		$namespaces = $this->sqlSanitizeArray($namespaces);

		$tables = array('revision');
		$joinConditions = array();
		$conditions = array();

		//// clear out the bots
		//$joinConditions['user_groups'] = array('JOIN', 'rev_user=ug_user');
		//$conditions[] = "ug_group != 'bot'";

		// filter by namespaces if provided
		if ( $namespaces != null ) {
			$conditions[] = "page_namespace in (" . implode(",",$namespaces) . ")";
			$tables[] = 'page';
			if( $allowDuplicates ) {
				$joinConditions['page'] = array( "JOIN", "rev_page=page_id" );
			} else {
				$joinConditions['page'] = array( "JOIN", "rev_id=page_latest" );
			}
		}

		if( $allowDuplicates ) {
			$query = $this->databaseConnection->selectSQLText(
				$tables
				, 'rev_id as id, page_id as pageId, rev_timestamp as timestamp, rev_user as userId'
				, $conditions
				, __METHOD__
				, array( 'LIMIT' => $limit, 'ORDER BY' => 'rev_id DESC' )
				, $joinConditions );
		} else {
			// use group by to filter out bad results
			$query = $this->databaseConnection->selectSQLText(
				$tables
				, 'page_latest as id, page_id as pageId, rev_timestamp as timestamp, rev_user as userId'
				, $conditions
				, __METHOD__
				, array( 'LIMIT' => $limit, 'ORDER BY' => 'rev_id DESC' )
				, $joinConditions );

		}
		// die($query);
		$result = $this->databaseConnection->query($query);
		return $result;
	}

	/**
	 * @param $array
	 * @return array
	 */
	protected function sqlSanitizeArray( $array ) {
		if( $array == null ) {
			return null;
		}
		$resultArray = array();
		foreach( $array as $i => $v ) {
			$resultArray[] = $this->databaseConnection->addQuotes($v);
		}
		return $resultArray;
	}

	/**
	 * @param $limit int limit number of results.
	 * @param $namespaces array list of namespaces to filter by. No filter applied if null
	 * @param $allowDuplicates bool if false there will be at most one result per page
	 * @return string
	 */
	protected static function createCacheKey( $limit, $namespaces, $allowDuplicates, $dbName = null ) {
		if( $dbName == null ) {
			$dbName = F::app()->wg->DBname;
		}
		$key = implode("_", array(
			"RevisionService",
			$dbName,
			strval($limit),
			implode(",",$namespaces),
			strval($allowDuplicates)));
		return $key;
	}

	public static function on
}
