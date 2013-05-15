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
	 * @var int
	 */
	private $queryLimit;


	/**
	 * @param DatabaseBase $databaseConnection
	 * @param int $cacheTime
	 */
	function __construct( $databaseConnection = null, $cacheTime = 5 /* only micro caching to protect us form DoS */ ) {
		if( $databaseConnection == null ) {
			$databaseConnection = wfGetDB( DB_SLAVE );
		}
		$this->cacheTime = $cacheTime;
		$this->databaseConnection = $databaseConnection;
		$this->queryLimit = 200;
	}

	/**
	 * @param int $limit limit number of results.
	 * @param array $namespaces list of namespaces to filter by. No filter applied if null
	 * @param bool $allowDuplicates if false there will be at most one result per page
	 * @return array
	 */
	public function getLatestRevisions( $limit, $namespaces, $allowDuplicates ) {
		$key = self::createCacheKey( $this->queryLimit, $namespaces, $allowDuplicates );
		$listOfRevisions = WikiaDataAccess::cache( $key, $this->cacheTime, function() use( $namespaces, $allowDuplicates ) {
			return $this->getLatestRevisionsNoCacheAllowDuplicates( $this->queryLimit, $namespaces, $allowDuplicates );
		});
		if( !$allowDuplicates ) {
			$listOfRevisions = $this->filterDuplicates( $listOfRevisions );
		}
		$listOfRevisions = $this->limitCount( $listOfRevisions, $limit );
		return $listOfRevisions;
	}

	/**
	 * @param int $limit limit number of results.
	 * @param array $namespaces list of namespaces to filter by. No filter applied if null
	 * @return array
	 */
	public function getLatestRevisionsNoCacheAllowDuplicates( $limit, $namespaces ) {
		$limit = intval($limit);

		$result = $this->getLatestRevisionsQuery( $limit, $namespaces );

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
	 * @param int $limit limit number of results.
	 * @param array $namespaces list of namespaces to filter by. No filter applied if null
	 * @return ResultWrapper
	 */
	public function getLatestRevisionsQuery( $limit, $namespaces ) {
		$namespaces = $this->sqlSanitizeArray($namespaces);

		$tables = array('recentchanges');
		$joinConditions = array();
		$conditions = array();

		// clear out the bots
		$conditions[] = "rc_bot=0";

		// filter by namespaces if provided
		if ( $namespaces != null ) {
			$conditions[] = "page_namespace in (" . implode(",",$namespaces) . ")";
			$tables[] = 'page';
			$joinConditions['page'] = array( "JOIN", "rc_cur_id=page_id" );
		}
		$query = $this->databaseConnection->selectSQLText(
			$tables
			, 'rc_id as id, page_id as pageId, rc_timestamp as timestamp, rc_user as userId'
			, $conditions
			, __METHOD__
			, array( 'LIMIT' => $limit, 'ORDER BY' => 'rc_id DESC' )
			, $joinConditions );

		$result = $this->databaseConnection->query($query);
		return $result;
	}

	/**
	 * @param array $listOfRevisions
	 * @param int $count
	 * @return array
	 */
	public function limitCount( $listOfRevisions, $count ) {
		return array_slice( $listOfRevisions, 0, $count);
	}

	/**
	 * @param array $listOfRevisions list of revisions to remove duplicates from
	 * @return array
	 */
	public function filterDuplicates( $listOfRevisions ) {
		$prev = null;
		$resultArray = array();
		foreach( $listOfRevisions as $i => $revision ) {
			if( $prev == null
				|| $prev['article'] != $revision['article']
				|| $prev['user']    != $revision['user'] ) {
				$resultArray[] = $revision;
			}
			$prev = $revision;
		}
		return $resultArray;
	}

	/**
	 * @param array $array array to sanitize
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
	 * @param string|NULL $dbName
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

	/**
	 * @param int $cacheTime
	 */
	public function setCacheTime($cacheTime) {
		$this->cacheTime = $cacheTime;
	}

	/**
	 * @return int
	 */
	public function getCacheTime() {
		return $this->cacheTime;
	}

	/**
	 * @param \DatabaseBase $databaseConnection
	 */
	public function setDatabaseConnection($databaseConnection) {
		$this->databaseConnection = $databaseConnection;
	}

	/**
	 * @return \DatabaseBase
	 */
	public function getDatabaseConnection() {
		return $this->databaseConnection;
	}

	/**
	 * @param int $queryLimit
	 */
	public function setQueryLimit($queryLimit) {
		$this->queryLimit = $queryLimit;
	}

	/**
	 * @return int
	 */
	public function getQueryLimit() {
		return $this->queryLimit;
	}
}
