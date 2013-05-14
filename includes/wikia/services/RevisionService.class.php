<?php
/**
 * Created by adam
 * Date: 10.05.13
 */

class RevisionService {
	private $databaseConnection;
	private $cacheTime;
	private $cacheKeyPrefix;

	function __construct( $databaseConnection = null, $cacheTime = 3600 ) {
		if( $databaseConnection == null ) {
			$databaseConnection = wfGetDB( DB_SLAVE );
		}
		$this->cacheKeyPrefix = "RevisionServiceCacheWrapper_" . F::app()->wg->DBname;
		$this->cacheTime = $cacheTime;
		$this->databaseConnection = $databaseConnection;
	}

	public function getLatestRevisions( $limit, $namespace, $category, $allowDuplicates ) {
		$key = $this->createCacheKey( $limit, $namespace, $category, $allowDuplicates );
		return WikiaDataAccess::cache( $key, $this->cacheTime, function() use( $limit, $namespace, $category, $allowDuplicates ) {
			return $this->getLatestRevisionsNoCache( $limit, $namespace, $category, $allowDuplicates );
		});
	}

	public function getLatestRevisionsNoCache( $limit, $namespaces, $categories, $allowDuplicates ) {
		$limit = intval($limit);
		$namespaces = $this->sqlSanitizeArray($namespaces);
		$categories = $this->sqlSanitizeArray($categories);

		$result = $this->getLatestRevisionsQuery( $limit, $namespaces, $categories, $allowDuplicates );

		$items = array();
		while( ( $row = $result->fetchObject() ) !== false ) {
			$dateTime = date_create_from_format( 'YmdHis', $row->timestamp );
			$items[  ] = array(
				'article' => $row->pageId,
				'user' => $row->userId,
				'timestamp' => $dateTime->getTimestamp()
			);
		}
		return $items;
	}

	public function getLatestRevisionsQuery( $limit, $namespaces, $categories, $allowDuplicates ) {
		$tables = array('revision', 'user_groups');
		$joinConditions = array();
		$conditions = array();

		$joinConditions['user_groups'] = array('LEFT JOIN', 'rev_user=ug_user');
		$conditions[] = "ug_group not in('bot')";

		if ( $namespaces != null ) {
			$conditions[] = "page_namespace in (" . implode(",",$namespaces) . ")";
			$tables[] = 'page';
			$joinConditions['page'] = array( "LEFT JOIN", "rev_page=page_id" );
		}
		if ( $categories != null ) {
			$conditions[] = 'cl_to in (' . implode(",",$categories) . ')';
			$tables[] = 'categorylinks';
			$joinConditions['categorylinks'] = array( "LEFT JOIN", "rev_page=cl_from" );
		}
		if( $allowDuplicates ) {
			$result = $this->databaseConnection->select(
				$tables
				, 'rev_id as id, rev_page as pageId, rev_timestamp as timestamp, rev_user as userId'
				, $conditions
				, __METHOD__
				, array( 'LIMIT' => $limit, 'ORDER BY' => 'rev_timestamp DESC' )
				, $joinConditions );
		} else {
			$result = $this->databaseConnection->select(
				$tables
				, 'max(rev_id) as id, rev_page as pageId, max(rev_timestamp) as timestamp, (SELECT rev_user FROM revision r where r.rev_id = max(revision.rev_id)) as userId'
				, $conditions
				, __METHOD__
				, array( 'LIMIT' => $limit, 'ORDER BY' => 'rev_timestamp DESC', "GROUP BY" => 'rev_page' )
				, $joinConditions );
		}
		return $result;
	}

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

	protected function createCacheKey( $limit, $namespace, $category, $allowDuplicates ) {
		$key = implode("|", array(
			$this->cacheKeyPrefix,
			strval($limit),
			implode(",",$namespace),
			implode(",",$category),
			strval($allowDuplicates)));
		return $key;
	}
}
