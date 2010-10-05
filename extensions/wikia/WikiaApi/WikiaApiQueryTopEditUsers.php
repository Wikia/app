<?php

/**
 * WikiaApiQueryPopularPages - get list of most frequently accessed pages for selected namespace
 *
 * @author Piotr Molski (moli) <moli@wikia.com>
 *
 * @todo
 *
 */

class WikiaApiQueryTopEditUsers extends WikiaApiQuery {
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
									$this->getTopEditUsers();
									break;
								}
		}
	}

	protected function getDB() {
		global $wgStatsDB;
		return wfGetDB(DB_SLAVE, array(), $wgStatsDB);
	}

	#---
	private function getTopEditUsers() {
		global $wgDBname, $wgCityId;

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

			if ( is_null($db) ) {
				throw new WikiaApiQueryError(0);
			}

			$cid = (empty($wgCityId)) ? WikiFactory::DBtoID($wgDBname) : $wgCityId;

			$this->addTables( array( "`specials`.`events_local_users`" ) );
			$this->addFields( array('user_id', 'user_name', 'edits'));
			$this->addWhere ( "user_id > 0 and user_is_blocked = 0 and user_is_closed = 0" );
			if ( !empty($cid) ) {
				$this->addWhere ( "wiki_id = {$cid}" );
			}

			#--- user
			if ( !is_null($user) ) {
				if ( !$this->isInt($user) ) {
					throw new WikiaApiQueryError(1);
				}
				$this->setCacheKey ($lcache_key, 'U', $user);
				$this->addWhere ( "user_id = '" . intval($user) . "'" );
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
			$this->addOption( "ORDER BY", "edits DESC" );

			$data = array();
			// check data from cache ...
			$cached = $this->getDataFromCache($lcache_key);
			if (!is_array($cached)) {
				$res = $this->select(__METHOD__);
				while ($row = $db->fetchObject($res)) {
					$data[$row->user_id] = array(
						"user_id"		=> $row->user_id,
						"cnt"			=> $row->edits,
						"user_name"		=> $row->user_name
					);
					ApiResult :: setContent( $data[$row->user_id], $row->user_name);
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
		return 'Get list of users with most edited pages';
	}

	/*
	 *
	 * Description's parameters
	 *
	 */
	#---
	protected function getParamQueryDescription() {
		return 	array (
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
			"user" => array (
				ApiBase :: PARAM_TYPE => 'integer'
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
			'api.php?action=query&list=wkedituser',
			'api.php?action=query&list=wkedituser&wklimit=10',
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
