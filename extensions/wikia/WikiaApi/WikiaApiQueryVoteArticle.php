<?php

/**
 * WikiaApiQueryVoteArticle - get list of top votes of articles
 *
 * @author Piotr Molski (moli) <moli@wikia.com>
 *
 * @todo
 *
 */

/*
DROP TABLE IF EXISTS `page_vote`;
CREATE TABLE `page_vote` (
  `article_id` int(8) unsigned NOT NULL,
  `user_id` int(5) unsigned NOT NULL,
  `vote` int(2) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `time` datetime NOT NULL,
  `unique_id` varchar(32) default NULL,
  KEY `user_id` (`user_id`,`article_id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
*/

class WikiaApiQueryVoteArticle extends WikiaApiQuery {
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
			case parent::INSERT : $this->addVoteArticle(); break;
			case parent::UPDATE : $this->changeVoteArticle(); break;
			case parent::DELETE : $this->removeVoteArticle(); break;
			default: $this->getVoteArticle(); break;
		}
	}

	/*
	 * Get votes of articles
	 */
	private function getVoteArticle () {
		global $wgTopVoted, $wgDBname;

        $topvoted = $page = $uservote = null;

        #--- initial parameters (dbname, limit, offset ...)
		extract($this->getInitialParams());

        #--- request parameters ()
		extract($this->extractRequestParams());

		$this->initCacheKey($lcache_key, __METHOD__);
        #--- blank variables

		#---
		$user_id = $this->getUser()->getId();
		$ip = wfGetIP();
		$browserId = $this->getBrowser();

		if ( !is_null($page) ) {
			# get votes for selected article
			try {
				$this->addTables( array("page_vote") );
				$add_fields = array('AVG(vote) as votesavg, max(time) as max_time');
				$this->addFields( $add_fields );
				if ( !$this->isInt($page) ) {
					throw new WikiaApiQueryError(1);
				}
				$this->setCacheKey ($lcache_key, 'P', $page);
				$this->addWhereFld( "article_id", $page );

				#---
				if ( !empty($ctime) ) {
					if ( !$this->isInt($ctime) ) {
						throw new WikiaApiQueryError(1);
					}
				}

				if ( !is_null($uservote) ) {
					if ( !empty($user_id) ) {
						$this->setCacheKey ($lcache_key, 'U', $user_id);
						$this->addWhereFld( "user_id", $user_id );
					} else {
						$this->setCacheKey ($lcache_key, 'UB', $browserId);
						$this->addWhereFld( "unique_id", $browserId );
					}
					$this->addFields ( array("max(vote) as uservote") );
				}

				$data = array();
				// check data from cache ...
				$cached = $this->getDataFromCache($lcache_key);
				if (empty($cached)) {
					#--- database instance - DB_SLAVE
					$db =& $this->getDB();
					$db->selectDB( (!defined(WIKIA_API_QUERY_DBNAME)) ? WIKIA_API_QUERY_DBNAME : $wgDBname );
					if ( is_null($db) ) throw new WikiaApiQueryError(0);
					$res = $this->select(__METHOD__);
					if ($row = $db->fetchObject($res)) {
						$oTitle = Title::newFromId($page);
						if ($oTitle instanceof Title) {
							$data[$page] = array(
								"id"			=> $page,
								"title"			=> $oTitle->getText(),
								"votesavg"		=> $row->votesavg,
							);
							if (isset($row->uservote)) {
								$data[$page]["uservote"] = $row->uservote;
							}
							ApiResult::setContent( $data[$page], $oTitle->getText() );
						}
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
		} else {
			# get list of votes
			try {
				$wgTopVoted = ( !empty($topvoted) ) ? true : false;

				$this->addTables( array("`page_vote` p1", "page") );
				$add_fields = array('page_id', 'page_title', 'AVG(vote) as votesavg, max(time) as max_time');
				$this->addFields( $add_fields );
				$this->addWhere ( "page_id = article_id" );

				#---
				if ( !empty($ctime) ) {
					if ( !$this->isInt($ctime) ) {
						throw new WikiaApiQueryError(1);
					}
				}

				$select_user_vote = "";
				if ( !is_null($uservote) ) {
					# isset user_id or ip ?
					if ( empty($user_id) && empty($ip) )  {
						throw new WikiaApiQueryError(2);
					}

					$select_user_vote = "select article_id as page_id, max(vote) as uservote from page_vote where IMPLODE and ";
					if ( !empty($user_id) ) {
						$this->setCacheKey ($lcache_key, 'U', $user_id);
						$select_user_vote .= " user_id = '$user_id' ";
					} else {
						$select_user_vote .= " unique_id = '$browserId' ";
						$this->setCacheKey ($lcache_key, 'UB', $browserId);
					}
					$select_user_vote .= " group by article_id";
				}

				if ( $wgTopVoted ) {
					// show most voted articles
					if (empty($uservote)) $this->setCacheKey ($lcache_key, 'O', "votesavg");
					$order = "votesavg DESC";
				} else {
					// show last voted articles
					if (empty($uservote)) $this->setCacheKey ($lcache_key, 'O', "time");
					$order = "max(time) DESC";
				}

				#--- order by
				$this->addOption( "ORDER BY", $order );
				#--- group by
				$this->addOption( "GROUP BY", "article_id" );

				#--- limit
				if ( !empty($limit)  ) {
					if ( !$this->isInt($limit) ) {
						throw new WikiaApiQueryError(1);
					}
					if (empty($uservote)) {
						$this->setCacheKey ($lcache_key, 'L', $limit);
					}
					$this->addOption( "LIMIT", $limit );
				}

				#--- offset
				if ( !empty($offset)  ) {
					if ( !$this->isInt($offset) ) {
						throw new WikiaApiQueryError(1);
					}
					if (empty($uservote)) {
						$this->setCacheKey ($lcache_key, 'OF', $offset);
					}
					$this->addOption( "OFFSET", $offset );
				}

				$data = array();
				// check data from cache ...
				$cached = $this->getDataFromCache($lcache_key);
				if (empty($cached)) {
					#--- database instance - DB_SLAVE
					$db =& $this->getDB();
					$db->selectDB( (!defined(WIKIA_API_QUERY_DBNAME)) ? WIKIA_API_QUERY_DBNAME : $wgDBname );

					if ( is_null($db) ) {
						throw new WikiaApiQueryError(0);
					}

					$res = $this->select(__METHOD__);
					while ($row = $db->fetchObject($res)) {
						$data[$row->page_id] = array(
							"id"			=> $row->page_id,
							"title"			=> $row->page_title,
							"votesavg"		=> $row->votesavg,
						);
						if ( isset($select_user_vote) && !empty($select_user_vote) ) {
							$data[$row->page_id]["uservote"] = 0;
						}
					}
					$db->freeResult($res);

					if ( !empty($data) && is_array($data) ) {
						if (!empty($select_user_vote)) {
							$dbr = wfGetDB( DB_SLAVE );

							$pages = implode( ",", array_keys($data) );
							$select_user_vote = str_replace("IMPLODE", " article_id in (".$pages.") ", $select_user_vote);
							$oRes = $dbr->query($select_user_vote, __METHOD__);

							while ( $oRow = $dbr->fetchObject( $oRes ) ) {
								$data[$oRow->page_id]["uservote"] = $oRow->uservote;
							}
							$dbr->freeResult( $oRes );
						}

						foreach ( $data as $page_id => $values ) {
							ApiResult::setContent( $data[$page_id], $values['title'] );
						}
					}

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

	#---
	private function addVoteArticle()
	{
		global $wgDBname;
        $page = $vote = null;

        #--- initial parameters (dbname, limit, offset ...)
		extract($this->getInitialParams());

        #--- request parameters ()
		extract($this->extractRequestParams());

		$ip = wfGetIP();
		$user_id = $this->getUser()->getId();
		$browserId = $this->getBrowser();

        #--- database instance - DB_MASTER
		$db =& $this->getDB();
        $db->selectDB( (!defined(WIKIA_API_QUERY_DBNAME))?WIKIA_API_QUERY_DBNAME:$wgDBname );

		try {
			if ( empty($page) || empty($vote) ) {
				throw new WikiaApiQueryError(1);
			}

			#--- page and vote must be int
			if ( !$this->isInt($page) && !$this->isInt($vote) ) {
				throw new WikiaApiQueryError(1);
			}

			if ( empty($user_id) && empty($browserId) ) {
				throw new WikiaApiQueryError(2);
			}

			#--- macbre: fixes #2456
			if ( $vote < 0 || $vote > 5 ) {
				throw new WikiaApiQueryError(3);
			}

			$cached = $this->isAddedVote($db, $page, $ip, $user_id, $browserId);
			if ( !empty($cached) ) {
				$data = $cached;
			} else {
				$data = array(
					'article_id'	=> $page,
					'user_id'		=> $user_id,
					'vote'			=> $vote,
					'ip'			=> $ip,
					'time'			=> wfTimestampNow(),
					'unique_id'		=> $browserId,
					);
				$this->setFields($data);
				$this->setTable('page_vote');
				if ( $this->insert(__METHOD__) ) {

					#--- remove cache votes from memcache
					$this->removeAllCacheVote(__METHOD__, $page, $user_id, $ip, $browserId);

					#--- get votes from db
					$voteAvg = $this->getAvgPageVoteFromDB($db, $page);
					$data['avgvote'] = $voteAvg;

					#--- add data to cache
					$cached = $this->cacheVote($data);

					#--- set api result
					$data = $this->setApiResult( $data );
				} else {
					throw new DBError($db, 'Database query failed');
				}
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
			$this->setIndexTagName('fault');
			$data = $e->getText();
		}

		$this->getResult()->setIndexedTagName($data, $this->getIndexTagName());
		$this->getResult()->addValue('item', $this->getModuleName(), $data);

		wfRunHooks( 'ArticleAfterVote', array( &$user_id, &$page, $vote ) );
	}

	#---
	private function changeVoteArticle() {
		global $wgDBname;
        $page = $vote = null;

        #--- initial parameters (dbname, limit, offset ...)
		extract($this->getInitialParams());

        #--- request parameters ()
		extract($this->extractRequestParams());

		#---
		$ip = wfGetIP();
		$user_id = $this->getUser()->getId();
		$browserId = $this->getBrowser();

        #--- database instance - DB_MASTER
		$db =& $this->getDB();
		$db->selectDB( (!defined(WIKIA_API_QUERY_DBNAME))?WIKIA_API_QUERY_DBNAME:$wgDBname );

		try {
			if ( empty($page) || empty($vote) ) {
				throw new WikiaApiQueryError(1);
			}

			#--- page and vote must be int
			if ( !$this->isInt($page) && !$this->isInt($vote) ) {
				throw new WikiaApiQueryError(1);
			}

			if ( empty($user_id) && empty($browserId) ) {
				throw new WikiaApiQueryError(2);
			}

			#--- macbre: fixes #2456
			if ( $vote < 0 || $vote > 5 ) {
				throw new WikiaApiQueryError(3);
			}

			#--- update
			$data = array(
				'vote' => $vote,
				'time' => wfTimestampNow(),
				'article_id' => $page,
				'user_id' => $user_id,
				'ip' => $ip,
				'unique_id' => $browserId,
				);

			if ( $this->isAddedVote($db, $page, 0, $user_id, $browserId) ) {

				$this->setFields($data);

				#---
				$this->addWhere("article_id = $page");
				if (!empty($user_id)) {
					$data['user_id'] = $user_id;
					$this->addWhere("user_id = ".$user_id);
				}
				elseif (!empty($browserId)) {
					$data['unique_id'] = $browserId;
					$this->addWhere("unique_id = ".$browserId);
				}


				/*if (!empty($ip)) {
					$data['ip'] = $ip;
					$this->addWhere("ip = '$ip'");
				}*/

				#---
				$this->setTable('page_vote');

				#---
				if ( $this->update(__METHOD__) ) {

					#--- remove cache votes from memcache
					$this->removeAllCacheVote(__METHOD__, $page, $user_id, $ip, $browserId);

					#--- get votes from db
					$voteAvg = $this->getAvgPageVoteFromDB($db, $page);
					$data['avgvote'] = $voteAvg;

					$cached = $this->cacheVote($data);
				} else {
					throw new DBError($db, 'Database query failed');
				}
			} else {
				throw new WikiaApiQueryError(3);
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
			$this->setIndexTagName('fault');
			$data = $e->getText();
		}
		
		$this->getResult()->setIndexedTagName($data, $this->getIndexTagName());
		$this->getResult()->addValue('item', $this->getModuleName(), $data);
		
		wfRunHooks( 'ArticleAfterVote', array( $user_id, &$page, $vote ) );
	}

	#---
	private function removeVoteArticle() {
		global $wgDBname;
        $page = $vote = null;

        #--- initial parameters (dbname, limit, offset ...)
		extract($this->getInitialParams());

        #--- request parameters ()
		extract($this->extractRequestParams());

		#---
		$ip = wfGetIP();
		$user_id = $this->getUser()->getId();
		$browserId = $this->getBrowser();

        #--- database instance - DB_MASTER
		$db =& $this->getDB();
		$db->selectDB( (!defined(WIKIA_API_QUERY_DBNAME))?WIKIA_API_QUERY_DBNAME:$wgDBname );

		try {
			if ( empty($page) /* || empty($vote) */ ) {
				throw new WikiaApiQueryError(1);
			}

			if ( empty($user_id) && empty($browserId) ) {
				throw new WikiaApiQueryError(2);
			} else {
				if (!empty($user_id)) {
					$this->addWhere("user_id = ".$user_id);
				}
				elseif (!empty($browserId)) {
					$this->addWhere("unique_id = '".$browserId."'");
				}
			}

			#--- must be int
			if ( !$this->isInt($page) && !$this->isInt($vote) ) {
				throw new WikiaApiQueryError(1);
			}

			#---
			$this->addWhere("article_id = $page");
			if ( !empty($vote) ) {
				$this->addWhere("vote = $vote");
			}

			#---
			$this->setTable('page_vote');

			#---
			if ( $this->delete(__METHOD__) ) {
				#--- remove cache votes from memcache
				$this->removeAllCacheVote(__METHOD__, $page, $user_id, $ip, $browserId);

				$voteAvg = $this->getAvgPageVoteFromDB($db, $page);

				#-- result
				$data = $this->setApiResult( array('remove' => 1, 'avgvote' => $voteAvg) );
			} else {
				throw new DBError($db, 'Database query failed');
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
			$this->setIndexTagName('fault');
			$data = $e->getText();
		}

		$this->getResult()->setIndexedTagName($data, $this->getIndexTagName());
		$this->getResult()->addValue('item', $this->getModuleName(), $data);
	}

	#---
	private function isAddedVote($db, $page, $ip, $user_id, $browserId) {
		global $wgDBname;

		#---
		$this->initCacheKey($lcache_key, __CLASS__ );
		$this->setCacheKey ($lcache_key, 'P', $page);
		$this->setCacheKey ($lcache_key, 'UB', $browserId);
		$this->setCacheKey ($lcache_key, 'U', $user_id);

		$cached = $this->getDataFromCache($lcache_key);
		if ( is_array($cached) ) {
			#--- from cache
			return $cached;
		}

        #--- database instance - DB_SLAVE
        if (!$db) {
			$db =& $this->getDB();
	        $db->selectDB( (!defined(WIKIA_API_QUERY_DBNAME))?WIKIA_API_QUERY_DBNAME:$wgDBname );
        }

		$this->addTables( "page_vote" );
		$this->addFields( array("vote", "time") );

		$this->addWhereFld( "article_id", $page );

		/*if ( !empty($ip) ) {
			$this->addWhereFld( "ip", $ip );
		}*/
		if ( !empty($browserId) ) {
			$this->addWhereFld( "unique_id", $browserId );
		}
		if (!empty($user_id)) {
			$this->addWhereFld( "user_id", $user_id );
		}

		$res = $this->select(__METHOD__);
		$row = $db->fetchObject($res);

		#---
		if (empty($row)) {
			return null;
		}

		#---
		$data = array(
			'article_id'	=> $page,
			'user_id'		=> $user_id,
			'vote'			=> $row->vote,
			'ip'			=> $ip,
			'time'			=> $row->time,
			'unique_id'		=> $row->unique_id
			);
		$db->freeResult($res);

		return $data;
	}

	#---
	private function cacheVote($data, $time = '') {
		global $wgArticleVoteCacheTime;
		if ( ! $this->isInt ( $wgArticleVoteCacheTime ) ) {
			$wgArticleVoteCacheTime = 604800; // default - one week
		}

		$this->initCacheKey($lcache_key, __CLASS__);
		$this->setCacheKey ($lcache_key, 'P', $data['article_id']);
		//$this->setCacheKey ($lcache_key, 'I', $data['ip']);
		$this->setCacheKey ($lcache_key, 'UB', $data['unique_id']);
		$this->setCacheKey ($lcache_key, 'U', $data['user_id']);

		$time = (!empty($time)) ? $time : $wgArticleVoteCacheTime;
		if ( $this->saveCacheData($lcache_key, $data, $time) ) {
			return $lcache_key;
		} else {
			return false;
		}
	}

	#---
	private function removeAllCacheVote($method, $page, $user_id, $ip, $browserId) {
		#--- init cache-key
		$this->initCacheKey( $lcache_key, $method );
		$this->deleteCacheData($lcache_key);

		$this->initCacheKey( $lcache_key, __CLASS__, ':getVoteArticle' );
		$this->deleteCacheData($lcache_key);

		$this->initCacheKey($lcache_key, __CLASS__);
		$this->setCacheKey ($lcache_key, 'P', $page);
		//$this->setCacheKey ($lcache_key, 'I', $ip);
		$this->setCacheKey ($lcache_key, 'UB', $browserId);
		$this->setCacheKey ($lcache_key, 'U', $user_id);
		$this->deleteCacheData($lcache_key);

		$this->initCacheKey( $lcache_key, __CLASS__, ':getVoteArticle' );
		$this->setCacheKey ($lcache_key, 'P', $page);
		$this->setCacheKey ($lcache_key, 'U', $user_id);
		$this->deleteCacheData($lcache_key);

		$this->initCacheKey( $lcache_key, __CLASS__, ':getVoteArticle' );
		$this->setCacheKey ($lcache_key, 'P', $page);
		$this->setCacheKey ($lcache_key, 'UB', $browserId);
		$this->deleteCacheData($lcache_key);

		$this->deleteCacheData($lcache_key);
	}

	#---
	private function getAvgPageVoteFromDB($db, $page) {
		global $wgDBname;
        #--- database instance - DB_SLAVE
        $this->initQueryParams();

		#---
        if (!$db) {
			$db =& $this->getDB();
	        $db->selectDB( (!defined(WIKIA_API_QUERY_DBNAME))?WIKIA_API_QUERY_DBNAME:$wgDBname );
        }

		$this->addTables( "page_vote" );
		$this->addFields( array("AVG(vote) as votesavg") );
		$this->addWhere( "article_id > 0");

		$this->addWhere( "article_id = $page" );

		$res = $this->select(__METHOD__);

		$row = $db->fetchObject($res);
		if (empty($row))
		{
			return 0;
		}
		$db->freeResult($res);
		return (empty($row->votesavg))?0:$row->votesavg;
	}

	/*
	 *
	 * Description's functions
	 *
	 */

	#---
	protected function getInsDescription() {
		return 'Add vote to article';
	}

	#---
	protected function getUpdDescription() {
		return 'Change rating of article';
	}

	#---
	protected function getDelDescription() {
		return 'Remove vote of article. User have to be logged to use this option.';
	}

	#---
	protected function getQueryDescription() {
		return 'Get most rating articles';
	}

	/*
	 *
	 * Description's parameters
	 *
	 */

	#---
	protected function getParamInsDescription() {
		return array (
			'page'		=> 'Identifier of page',
			'vote'		=> 'Article rating. '
		);
	}

	#---
	protected function getParamUpdDescription() {
		return $this->getParamInsDescription();
	}

	#---
	protected function getParamDelDescription() {
		return $this->getParamInsDescription();
	}

	#---
	protected function getParamQueryDescription() {
		return array (
			'page'		=> 'Identifier of page',
			'topvoted' 	=> 'It can be one of values: \'1\' - if user want to take the more rated article or \'0\' otherwise',
			'uservote' 	=> 'It can be one of values: \'1\' - if user want to take vote of article for selected user or \'0\' otherwise. User have to be logged to use this option.',
		);
	}

	/*
	 *
	 * Allowed parameters
	 *
	 */

	#---
	protected function getAllowedInsParams() {
		return array (
			"page" => array (
								ApiBase :: PARAM_TYPE => 'integer'
							),
			"vote" => array (
								ApiBase :: PARAM_TYPE => 'integer',
								ApiBase :: PARAM_DFLT => 0
							),
		);
	}

	#---
	protected function getAllowedUpdParams() {
		return $this->getAllowedInsParams();
	}

	#---
	protected function getAllowedDelParams() {
		return $this->getAllowedInsParams();
	}

	#---
	protected function getAllowedQueryParams() {
		return array (
			"page" => array (
								ApiBase :: PARAM_TYPE => 'integer'
							),
			"topvoted" => array (
								ApiBase :: PARAM_TYPE => 'integer',
								ApiBase :: PARAM_DFLT => 0,
							),
			"uservote" => array (
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
	protected function getInsExamples() {
		return array (
			'api.php?action=insert&list=wkvoteart&wkvote=5&wkpage=1750',
		);
	}

	#---
	protected function getUpdExamples() {
		return array (
			'api.php?action=update&list=wkvoteart&wkpage=1770&wkvote=2',
		);
	}

	#---
	protected function getDelExamples() {
		return array (
			'api.php?action=delete&list=wkvoteart&wkpage=1770',
		);
	}

	#---
	protected function getQueryExamples() {
		return array (
			'api.php?action=query&list=wkvoteart',
			'api.php?action=query&list=wkvoteart&wktopvoted=1&wklimit=25&wkctime=1800',
			'api.php?action=query&list=wkvoteart&wkpage=1778&wkuservote=2',
			'api.php?action=query&list=wkvoteart&wktopvoted=1&wklimit=10',
			'api.php?action=query&list=wkvoteart&wktopvoted=1&wklimit=10',
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
