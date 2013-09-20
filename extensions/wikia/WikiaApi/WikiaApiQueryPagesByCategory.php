<?php

/**
 * WikiaApiQueryPagesyByCategory - get list of popular pages for selected namespace
 *
 * @author David Pean <david.pean@wikia.com>
 *
 * @todo
 *
 */

class WikiaApiQueryPagesyByCategory extends WikiaApiQuery {
	public function __construct($query, $moduleName) { parent :: __construct($query, $moduleName); }
	public function execute() {
		global $wgUser;
		switch ($this->getActionName()) {
			case parent::INSERT : break;
			case parent::UPDATE : break;
			case parent::DELETE : break;
			default: $this->getPagesByCategory(); break;
		}
	}

	protected function getDB() {
		global $wgDBname;
		return wfGetDB(DB_SLAVE, array(), $wgDBname);
	}

	#---
	# if someone want to use it
	#---
	private function getPagesByCategoryWithOffset() {
        #--- blank variables
        $category = $order = null;
        #--- initial parameters (dbname, limit, offset ...)
		extract($this->getInitialParams());
        #--- request parameters ()
		extract($this->extractRequestParams());
		#---
		$this->initCacheKey($lcache_key, __METHOD__);

		try {
			#--- database instance
			$db = $this->getDB();
			if ( is_null($db) ) {
				throw new WikiaApiQueryError(0);
			}

			#--- check categories
			$cats = explode('|', $category);
			$encodedCats = array();
			$memcKeyCats = "";
			foreach ($cats as $cat) {
				$categoryTitle = Title::newFromText( $cat );
				if (is_object($categoryTitle)){
					$encodedCats[] = $db->strencode($categoryTitle->getDbKey());
					$memcKeyCats .= str_replace(" ", "_", $categoryTitle->getDbKey());
				}
			}

			if (empty($encodedCats)){
				throw new WikiaApiQueryError(1, "Missing category");
			}
			$this->setCacheKey ($lcache_key, 'CCX', $memcKeyCats);

			# check order by to use proper table from DB
			$orderCache = 0;
			if ( !empty($order)  ) {
				switch ( $order ) {
					case "edit":
						$order_field = "page.page_touched DESC";
						$orderCache = 1;
						break;
					case "random":
						$orderCache = wfRandom();
						$this->addWhere ( "page_random >= " . $orderCache );
						$order_field = "page.page_random";
						break;
					default :
						$order_field = "page.page_id DESC";
						break;
				}
			} else if (count($encodedCats) > 1) {
				$order_field = "categorylinks.cl_to, categorylinks.cl_from DESC";
				$orderCache = 3;
			} else {
				$order_field = "page.page_id DESC";
				$orderCache = 4;
			}
			$this->setCacheKey($lcache_key, 'ORD', $orderCache);

			# if user categorylinks in query
			$useCategoryLinks = 0;
			if ( strpos($order_field, "categorylinks") !== false ) {
				$useCategoryLinks = 1;
			}

			if ( !empty($useCategoryLinks) ) {
				# build main query on categorylinks table
				$this->addTables( array( "categorylinks" ) );
				$this->addFields( array(
					'cl_from as page_id',
					'cl_to'
				));
				$this->addWhere ( "cl_to IN ('". implode("','", $encodedCats) . "')" );
			} else {
				# build main query on page table
				$this->addTables( array( "page" ) );
				$this->addFields( array(
					'page_id',
					'page_namespace',
					'page_title',
					'page_touched',
					'page_random'
				));
				$this->addWhere ( "page_id in (select distinct(cl_from) from `categorylinks` where cl_to IN ('". implode("','", $encodedCats) . "'))" );
				$this->addWhere ( "page_is_redirect = 0" );
			}

			$this->addOption( "ORDER BY", "{$order_field}" );

			#--- limit
			if ( !empty($limit) ) {
				if ( !$this->isInt($limit) ) {
					throw new WikiaApiQueryError(1);
				}
				$this->addOption( "LIMIT", $limit );
				$this->setCacheKey ($lcache_key, 'L', $limit);
			}

			if ( !empty($offset)  ) {
				if ( !$this->isInt($offset) ) {
					throw new WikiaApiQueryError(1);
				}
				$this->addOption( "OFFSET", $offset );
				$this->setCacheKey ($lcache_key, 'LO', $limit);
			}

			$data = array();
			// check data from cache ...
			$cached = ""; #$this->getDataFromCache($lcache_key);
			if (!is_array($cached)) {
				$res = $this->select(__METHOD__);
				while ($row = $db->fetchObject($res)) {
					if ( !empty($useCategoryLinks) ) {
						#--- for categorylinks table
						$oTitle = Title::newFromID($row->page_id);
						if ( $oTitle instanceof Title) {
							$data[$row->page_id] = array(
								"id"			=> $row->page_id,
								"category"		=> $row->cl_to,
								"namespace" 	=> $oTitle->getNamespace(),
								"title" 		=> $oTitle->getText(),
								"url" 			=> htmlspecialchars($oTitle->getFullURL())
							);
						}
					} else {
						#--- for page table
						$data[$row->page_id] = array(
							"id"			=> $row->page_id,
							"namespace"		=> $row->page_namespace,
							"title"			=> $row->page_title,
							"url"			=> htmlspecialchars(Title::makeTitle( $row->page_namespace, $row->page_title)->getFullURL())
						);
					}
				}
				$db->freeResult($res);

				#--- get rest values
				if ( !empty($data) ) {
					$aPages = implode( ",", array_keys($data) );
					#---
					$this->resetQueryParams();
					#---
					if ( empty($useCategoryLinks) ) {
						$this->addTables( array( "categorylinks" ) );
						$this->addFields( array(
							'cl_from as page_id',
							'cl_to'
						));
						$this->addWhere ( "cl_from IN (" . $aPages . ")" );
						$this->addWhere ( "cl_to IN ('". implode("','", $encodedCats) . "')" );

						$res = $this->select(__METHOD__);
						while ($row = $db->fetchObject($res)) {
							$data[$row->page_id]["category"] = $row->cl_to;
						}
						$db->freeResult($res);
					}

					#--- set content
					foreach ($data as $page_id => $values) {
						ApiResult :: setContent( $values, $values['title'] );
					}
					#--- set in memc
					$this->saveCacheData($lcache_key, $data, $ctime);
				}
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
		} else {
			$this->getResult()->setIndexedTagName($data, 'item');
		}

		$this->getResult()->addValue('query', $this->getModuleName(), $data);
	}

	#---
	private function getPagesByCategory() {
		global $wgDBname;
        #--- blank variables
        $category = $order = null;
        #--- initial parameters (dbname, limit, offset ...)
		extract($this->getInitialParams());
        #--- request parameters ()
		extract($this->extractRequestParams());
		#---
		$this->initCacheKey($lcache_key, __METHOD__);

		try {
			#--- database instance
			$db =& $this->getDB();
			$db->selectDB( (!defined(WIKIA_API_QUERY_DBNAME)) ? WIKIA_API_QUERY_DBNAME : $wgDBname );
			if ( is_null($db) ) {
				throw new WikiaApiQueryError(0);
			}

			#--- check categories
			$cats = explode('|', $category);
			$encodedCats = array();
			$memcKeyCats = "";
			foreach ($cats as $cat) {
				$categoryTitle = Title::newFromText( $cat );
				if (is_object($categoryTitle)){
					$encodedCats[] = $db->strencode($categoryTitle->getDbKey());
					$memcKeyCats .= str_replace(" ", "_", $categoryTitle->getDbKey());
				}
			}

			if (empty($encodedCats)){
				throw new WikiaApiQueryError(1, "Missing category");
			}
			$this->setCacheKey ($lcache_key, 'CCX', $memcKeyCats);

			# check order by to use proper table from DB
			$orderCache = 0;
			if ( !empty($order)  ) {
				switch ( $order ) {
					case "edit":
						$order_field = "page.page_touched DESC";
						$orderCache = 1;
						break;
					case "random":
						$orderCache = wfRandom();
						$this->addWhere ( "page_random >= " . $orderCache );
						$order_field = "page.page_random";
						break;
					default :
						$order_field = "page.page_id DESC";
						break;
				}
			} else if (count($encodedCats) > 1) {
				$order_field = "page.page_id DESC"; #"categorylinks.cl_to, categorylinks.cl_from DESC";
				$orderCache = 3;
			} else {
				$order_field = "page.page_id DESC";
				$orderCache = 4;
			}
			$this->setCacheKey($lcache_key, 'ORD', $orderCache);

			#--- limit
			if ( !empty($limit) ) {
				if ( !$this->isInt($limit) ) {
					throw new WikiaApiQueryError(1);
				}
				$this->setCacheKey ($lcache_key, 'L', $limit);
			}

			if ( !empty($offset)  ) {
				if ( !$this->isInt($offset) ) {
					throw new WikiaApiQueryError(1);
				}
				$this->setCacheKey ($lcache_key, 'LO', $offset);
			}

			# if user categorylinks in query
			sort($encodedCats);
			$data = array();
			// check data from cache ...
			$cached = ""; #$this->getDataFromCache($lcache_key);
			if (!is_array($cached)) {
				foreach ($encodedCats as $id => $category) {
					#---
					$pages = $this->getCategoryPages($db, $category, $limit);
					#--- no pages
					if ( empty($pages) ) continue;

					$this->resetQueryParams();
					# build main query on page table
					$this->addTables( array( "page" ) );
					$this->addFields( array(
						'page_id',
						'page_namespace',
						'page_title',
						'page_touched',
						'page_random'
					));
					$this->addWhere ( "page_id in ('" . implode("','", $pages) . "')" );
					$this->addWhere ( "page_is_redirect = 0" );
					#-- limit;
					$this->addOption( "LIMIT", $limit );
					$this->addOption( "OFFSET", $offset );
					$this->addOption( "ORDER BY", "{$order_field}" );
					#---
					$res = $this->select(__METHOD__);
					#---
					while ($row = $db->fetchObject($res)) {
						$data[$row->page_id] = array(
							"id"			=> $row->page_id,
							"namespace"		=> $row->page_namespace,
							"title"			=> $row->page_title,
							"url"			=> htmlspecialchars(Title::makeTitle( $row->page_namespace, $row->page_title)->getFullURL()),
							"category"		=> $category
						);
						ApiResult :: setContent( $data[$row->page_id], $row->page_title );
					}
					$db->freeResult($res);

					if ( count($data) >= $limit ) break;
				}
				#--- set in memc
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
		} else {
			$this->getResult()->setIndexedTagName($data, 'item');
		}

		$this->getResult()->addValue('query', $this->getModuleName(), $data);
	}

	private function getCategoryPages($db, $category, $limit) {
		#---
		$this->resetQueryParams();
		# build main query on page table
		$this->addTables( array( 'categorylinks' ) );
		$this->addFields( array( 'cl_from as page_id' ) );
		$this->addWhere ( array('cl_to' => $category) );
		$this->addOption( "ORDER BY", "rand()" );
		$this->addOption( "LIMIT", $limit * 2 );
		#---
		$res = $this->select(__METHOD__);
		#---
		$pages = array();
		while ($row = $db->fetchObject($res)) {
			$pages[] = $row->page_id;
		}
		$db->freeResult($res);
		return $pages;
	}


	protected function getQueryDescription() { return 'Get Wikia pages by category'; }
	protected function getParamQueryDescription() { return 	array ( 'category' => 'category to get pages for' ); }
	protected function getAllowedQueryParams() { return array ( "category" => array ( ApiBase :: PARAM_TYPE => 'string' ), "order" => array ( ApiBase :: PARAM_TYPE => 'string' ) ); }
	protected function getQueryExamples() { return array ( 'api.php?action=query&list=wkpagesincat', 'api.php?action=query&list=wkpagesincat&wkcategory=fun' ); }
	public function getVersion() { return __CLASS__ . ': $Id: '.__CLASS__.'.php '.filesize(dirname(__FILE__)."/".__CLASS__.".php").' '.strftime("%Y-%m-%d %H:%M:%S", time()).'Z wikia $'; }
};

