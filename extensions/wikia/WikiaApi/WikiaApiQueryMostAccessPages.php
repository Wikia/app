<?php

/**
 * WikiaApiQueryPopularPages - get list of most frequently accessed pages for selected namespace
 *
 * @author Piotr Molski (moli) <moli@wikia.com>
 *
 * @todo 
 *
 */

class WikiaApiQueryMostAccessPages extends WikiaApiQuery {
    /**
     * constructor
     */

	public function __construct($query, $moduleName) {
		parent :: __construct($query, $moduleName);
	}

    /**
     * main function
     */
	public function execute() {
		global $wgUser;

		switch ($this->getActionName()) {
			case parent::INSERT :
								{
									// to do - needed?
									break;
								}
			case parent::UPDATE :
								{
									// to do - needed?
									break;
								}
			case parent::DELETE :
								{
									// to do - needed?
									break;
								}
			default: // query
								{
									$this->getMostAccessPages ();
									break;
								}
		}
	}

	#---
	private function getMostAccessPages() {
		global $wgDBname;
		
        #--- blank variables
        $nspace = $user = null;

        #--- initial parameters (dbname, limit, offset ...)
		extract($this->getInitialParams());

        #--- request parameters ()
		extract($this->extractRequestParams());

		$this->initCacheKey($lcache_key, __METHOD__);
	
		try {
			#--- database instance
			$db =& $this->getDB();
			#$db->selectDB( (!defined(WIKIA_API_QUERY_DBNAME)) ? WIKIA_API_QUERY_DBNAME : $wgDBname );
			$db->selectDB( $wgDBname );

			if ( is_null($db) ) {
				//throw new DBConnectionError($db, 'Connection error');
				throw new WikiaApiQueryError(0);
			}

			$this->addTables( array( "recentchanges" ) );
			$this->addFields( array(
				'rc_id',
				'rc_title', 
				'rc_namespace',
				'rc_timestamp'
				));
		
			#--- identifier of namespace
			if ( !is_null($nspace) ) { 
				//error_log("nspace=".urldecode($nspace)."\n");
				$namespace_keys = preg_split( "/\,+/", urldecode($nspace) );
				if ( empty($namespace_keys) ) {
					throw new WikiaApiQueryError(1);
				}
				$this->setCacheKey ($lcache_key, 'N', $nspace);
				$this->addWhere ( "rc_namespace in ('".implode("','", $namespace_keys)."')" );
			}
			
			#---
			if ( !empty($ctime) ) {
				if ( !$this->isInt($ctime) ) {
					throw new WikiaApiQueryError(1);
				}
			}
			
			#--- limit
			if ( !empty($limit)  ) { //WikiaApiQuery::DEF_LIMIT
				if ( !$this->isInt($limit) ) {
					throw new WikiaApiQueryError(1);
				}
				$this->addOption( "LIMIT", $limit );
				$this->setCacheKey ($lcache_key, 'L', $limit);
			}

			#--- offset
			if ( !empty($offset)  ) { //WikiaApiQuery::DEF_LIMIT_COUNT
				if ( !$this->isInt($offset) ) {
					throw new WikiaApiQueryError(1);
				}
				$this->addOption( "OFFSET", $offset );
				$this->setCacheKey ($lcache_key, 'LO', $limit);
			}

			#--- user
			if ( !is_null($user) ) { 
				if ( !$this->isInt($user) ) {
					throw new WikiaApiQueryError(1);
				}
				$this->setCacheKey ($lcache_key, 'U', $user);
				$this->addWhereFld ( "rc_user", $user );						
			}
			
			#--- order by
			$this->addOption( "ORDER BY", "rc_timestamp desc" );

			$data = array();
			// check data from cache ...
			$cached = $this->getDataFromCache($lcache_key);
			if (!is_array($cached)) {
				$res = $this->select(__METHOD__);
				while ($row = $db->fetchObject($res)) {
					$data[$row->rc_id] = array(
						"id"			=> $row->rc_id,	
						"namespace"		=> $row->rc_namespace,
						"title"			=> $row->rc_title,
					);
					ApiResult :: setContent( $data[$row->rc_id], $row->rc_title);
				}
				$db->freeResult($res);
				$this->saveCacheData($lcache_key, $data, $ctime);
			} else {
				// ... cached
				$data = $cached;
			}		
		} catch (WikiaApiQueryError $e) {
			// getText();
		} catch (DBQueryError $e) {
			$e = new WikiaApiQueryError(0, 'Query error: '.$e->getText());
		} catch (DBConnectionError $e) {
			$e = new WikiaApiQueryError(0, 'DB connection error: '.$e->getText());
		} catch (DBError $e) {
			$e = new WikiaApiQueryError(0, 'Error in database: '.$e->getLogMessage());
		}

		// is exception
		if ( isset($e) ) {
			$data = $e->getText();
			$this->getResult()->setIndexedTagName($data, 'fault');
		}
		else
		{
			$this->getResult()->setIndexedTagName($data, 'item');
		}

		$this->getResult()->addValue('query', $this->getModuleName(), $data);
	}

	/*
	 * 
	 * Description's functions
	 * 
	 */ 
	#---
	protected function getQueryDescription() {
		return 'Get most changes pages';
	}

	/*
	 * 
	 * Description's parameters
	 * 
	 */ 
	#---
	protected function getParamQueryDescription() {
		return 	array (
			'page' => 'Identifier of page',
			'nspace' => 'List of identifiers of namespace. Every element of this list is separated by "," (urlencode(n1,n2,n3,n4...))',
			'user' => 'Identifier of user',
		);
	}

	/*
	 * 
	 * Allowed parameters
	 * 
	 */ 
	
	#---
	protected function getAllowedQueryParams() {
		return array (
			"page" => array (
				ApiBase :: PARAM_TYPE => 'integer'
			),
			"nspace" => array (
				ApiBase :: PARAM_TYPE => 'string'
			),
			"user" => array (
				ApiBase :: PARAM_TYPE => 'integer'
			),
			"date" => array (
				ApiBase :: PARAM_TYPE => 'string',
			),
		);
	} 

	/*
	 * 
	 * Examples
	 * 
	 */ 
	#---
	protected function getQueryExamples() {
		return array (
			'api.php?action=query&list=wkaccessart&wknspace=0',
			'api.php?action=query&list=wkaccessart&wkdate=2007-03-21',
			'api.php?action=query&list=wkaccessart&wknspace='.urlencode('0,2,4').'&wkdate=2007-03-21',
			'api.php?action=query&list=wkaccessart&wknspace='.urlencode('1,3,5').'&wkdate=2007-03-21',
		);
	}

	/*
	 * 
	 * Version
	 * 
	 */ 
	#---
	public function getVersion() {
		return __CLASS__ . ': $Id: '.__CLASS__.'.php '.filesize(dirname(__FILE__)."/".__CLASS__.".php").' '.strftime("%Y-%m-%d %H:%M:%S", time()).'Z wikia $';
	}
};

?>
