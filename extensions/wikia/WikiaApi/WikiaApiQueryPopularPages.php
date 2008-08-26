<?php

/**
 * WikiaApiQueryPopularPages - get list of popular pages for selected namespace
 *
 * @author Piotr Molski (moli) <moli@wikia.com>
 *
 * @todo 
 *
 */

class WikiaApiQueryPopularPages extends WikiaApiQuery {
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
									// to do
									break;
								}
			case parent::UPDATE :
								{
									// to do
									break;
								}
			case parent::DELETE :
								{
									// to do
									break;
								}
			default: // query
								{
									$this->getPopularPages ();
									break;
								}
		}
	}

	#---
	private function getPopularPages() {
		global $wgDBname;
		
        #--- blank variables
        $page = $date = null;

        #--- initial parameters (dbname, limit, offset ...)
		extract($this->getInitialParams());

        #--- request parameters ()
		extract($this->extractRequestParams());

		$this->initCacheKey($lcache_key, __METHOD__);
	
		try {
			#--- database instance
			$db =& $this->getDB();
			$db->selectDB( (!defined(WIKIA_API_QUERY_DBNAME)) ? WIKIA_API_QUERY_DBNAME : $wgDBname );

			if ( is_null($db) ) {
				//throw new DBConnectionError($db, 'Connection error');
				throw new WikiaApiQueryError(0);
			}

			/* revision was added for Gamespot project - they need last_edit timestamp */
			/* its a hack, a better way would be to make wkpoppages an API generator */
			/* Nef @ 20071026 */
			$this->addTables( array( "page_visited", "page", "revision" ) );
			$this->addFields( array(
				'article_id',
				'page_title', 
				'rev_timestamp AS last_edit',
				'count as sum_cnt'
				));
			$this->addWhere ( " page_id = article_id " );
			$this->addWhere ( " rev_id  = page_latest " );
		
			#--- identifier of page
			if ( !is_null($page) ) { 
				if ( !$this->isInt($page) ) {
					throw new WikiaApiQueryError(1);
				}
				$this->setCacheKey ($lcache_key, 'P', $page);
				$this->addWhereFld ( "page_id", $page );						
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
			
			#--- order by
			$this->addOption( "ORDER BY", "sum_cnt desc" );
			#--- group by
			#$this->addOption( "GROUP BY", "article_id" );

			$data = array();
			// check data from cache ...
			$cached = $this->getDataFromCache($lcache_key);
			if (!is_array($cached)) {
				$res = $this->select(__METHOD__);
				while ($row = $db->fetchObject($res)) {
					$data[$row->article_id] = array(
						"id"			=> $row->article_id,
						"title"			=> $row->page_title,
						"last_edit"		=> wfTimestamp(TS_ISO_8601, $row->last_edit),
						"counter"		=> $row->sum_cnt,
					);
					ApiResult :: setContent( $data[$row->article_id], $row->page_title);
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
		return 'Get Wikia most "Popular pages"';
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
			)
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
			'api.php?action=query&list=wkpoppages',
			'api.php?action=query&list=wkpoppages&wkpage=11&wkctime=60',
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
