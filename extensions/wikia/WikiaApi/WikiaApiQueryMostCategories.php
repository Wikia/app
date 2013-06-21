<?php

/**
 * WikiaApiQueryMostCategories - get list of the categories with the most pages
 *
 * @author David Pean <david.pean@wikia.com>
 *
 * @todo
 *
 */

class WikiaApiQueryMostCategories extends WikiaApiQuery {
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
									$this->getPagesByCategory ();
									break;
								}
		}
	}

	#---
	private function getPagesByCategory() {
		global $wgDBname;

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

			$this->addTables( array ("categorylinks" ) );
			$this->addFields( array(
				'cl_to',
				'count(*) as cnt'
				));

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
			$this->addOption( "ORDER BY", "cnt desc" );
			#--- group by
			$this->addOption( "GROUP BY", "cl_to" );

			$data = array();
			// check data from cache ...
			$cached = $this->getDataFromCache($lcache_key);
			if (!is_array($cached)) {
				$res = $this->select(__METHOD__);
				while ($row = $db->fetchObject($res)) {
					$data[$row->cl_to] = array(
						"count"			=> $row->cnt,
						"url"			=> htmlspecialchars(Title::makeTitle( NS_CATEGORY, $row->cl_to)->getFullURL())
					);
					ApiResult :: setContent( $data[$row->cl_to], $row->cl_to);
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
		return 'Get Wikia pages by category';
	}

	/*
	 *
	 * Description's parameters
	 *
	 */
	#---
	protected function getParamQueryDescription() {
		return 	array (
			'category' => 'category to get pages for',
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
			'api.php?action=query&list=wkmostcat',
			'api.php?action=query&list=wkmostcat&wklimit=5',
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

