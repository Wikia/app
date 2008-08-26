<?php

/**
 * WikiaApiQueryReferers - get list of top votes of articles
 *
 * @author Piotr Molski (moli) <moli@wikia.com>
 *
 * @todo
 *
 */

/** !!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 *
 * PLEASE SET UP GLOBALS :
 *
 * $wgDBuser,
 * $wgDBpassword,
 * $wgDBStatsServer,
 * $wgDBStats;
 *
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 */

class WikiaApiQueryReferers extends WikiaApiQuery {
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
									// needed?
									break;
								}
			case parent::UPDATE :
								{
									// needed?
									break;
								}
			case parent::DELETE :
								{
									// needed?
									break;
								}
			default:
								{
									$this->getWikiReferers();
									break;
								}
		}
	}

	protected function getDB() {
		$db = "";
		if (class_exists("ExternalStoreDB")) {
			$external = new ExternalStoreDB();
			$db = $external->getSlave( "archive1" );
		} else {
			$db = wfGetDBStats();
		}
		return $db;
	}

	/*
	 * Get votes of articles
	 */
	private function getWikiReferers ()
	{
		global $wgDBStats, $wikiaCityId;
	    global $wgServerName, $wgDBname;

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

		#---
		$where_derived = " and ref_domain != '".$wgServerName."' and ref_domain not like '%$wgDBname.wikia%' and ref_domain not like '%wikia-inc.com%'";
		try {
			#--- database instance - DB_SLAVE
			$dbs = $this->getDB();

			if ( is_null($dbs) ) {
				throw new WikiaApiQueryError(0);
				//throw new DBConnectionError($db, 'Connection error');
			}

			#--- identifier of city
			if ( !is_null($city) ) {
				$where_derived .= " and ref_city_id = '".intval($city)."' ";
				$this->setCacheKey ($lcache_key, 'C', $city);
			}

			#--- identifier of date
			if ( !empty($fromdate) ) {
				if ( !$this->isCorrectDate($fromdate) ) {
					throw new WikiaApiQueryError(1);
				}
				$this->setCacheKey ($lcache_key, 'F', $fromdate);
				$where_derived .= " and date_format(ref_timestamp, '%Y-%m-%d') > '{$fromdate}' ";
			} else {
                $ts = wfTimestamp( TS_MW, strtotime( "-1 months") );
                $where_derived .= " and ref_timestamp >= '$ts' ";
            }

			#--- identifier of date
			if ( !empty($todate) ) {
				if ( !$this->isCorrectDate($todate) ) {
					throw new WikiaApiQueryError(1);
				}
				$this->setCacheKey ($lcache_key, 'T', $todate);
				$where_derived .= " and date_format(ref_timestamp, '%Y-%m-%d') < '{$todate}' ";
			}

			#--- identifier of domain
			$define_table = "city_wikireferer_domains";
			if ( !empty($usefulldomain) ) {
				$this->setCacheKey ($lcache_key, 'FD', $usefulldomain);
				$define_table = "city_wikireferer";
			}
			#---
			if ( !empty($domain) ) {
				$this->setCacheKey ($lcache_key, 'D', $domain);
				$where_derived .= " and ref_domain = '{$domain}' ";

				#--- check domain
				$part_domain = explode(".",$domain);
				if (count($part_domain) == 1) {
                    $this->setCacheKey ($lcache_key, 'WCD', 1);
					$define_table = "city_wikireferer_domains";
				} else {
                    $this->setCacheKey ($lcache_key, 'WC', 1);
					$define_table = "city_wikireferer";
				}
				$db_where = "";
			}

			#--- useext
			if ( !empty($useext) ) {
				$this->setCacheKey ($lcache_key, 'UE', '1');
				$useext_where = $this->getWhereInternalDomains($define_table);
				if (!empty($useext_where)) {
					$where_derived .= " and {$useext_where} ";
				}
			}

			#--- use notdomain
			if ( !empty($notdomain) ) {
                $this->setCacheKey ($lcache_key, 'NAD', str_replace(" ", "_", $notdomain));
                $notdomain_where = $this->getNotAllowedDomains($notdomain);
				if (!empty($notdomain_where)) {
					$where_derived .= " and {$notdomain_where} ";
				}
            }

			$table = "(select ref_domain, sum(ref_count) as ref_count ";
			$table .= "from `{$wgDBStats}`.`{$define_table}` ";
			$table .= "where ref_domain != '' {$where_derived} ";
			$table .= "GROUP BY ref_domain) as ref";

			#--- useurl option
			if ( !empty($useurl) ) {
				$table = "`{$wgDBStats}`.`city_wikireferer_urls_top`";
				$db_where = " where ref_domain != '' {$where_derived} ";
				if (is_null($city)) {
					$db_where .= " and ref_city_id = '".$wikiaCityId."' ";
				}
				$this->setCacheKey ($lcache_key, 'UU', '1');
			}
			else {
			    $db_where = '';
			}

			$select = " ref_domain, ref_count ";
			$order = "ORDER BY ref_count DESC";

			#---
			if ( !empty($ctime) ) {
				if ( !$this->isInt($ctime) ) {
					throw new WikiaApiQueryError(1);
				}
			}

			#--- limit
			if ( !empty($limit)  ) {
				if ( !$this->isInt($limit) ) {
					throw new WikiaApiQueryError(1);
				}
				if (empty($uservote)) {
					$this->setCacheKey ($lcache_key, 'L', $limit);
				}
				$db_limit = "LIMIT {$limit}";
			}
			else {
			    $db_limit = '';
			}

			#--- offset
			if ( !empty($offset)  ) {
				if ( !$this->isInt($offset) ) {
					throw new WikiaApiQueryError(1);
				}
				if (empty($uservote)) {
					$this->setCacheKey ($lcache_key, 'OF', $offset);
				}
				$db_offset = "OFFSET {$offset}";
			}
			else {
			    $db_offset = '';
			}

			$data = array();
			// check data from cache ...
			$cached = $this->getDataFromCache($lcache_key);
			if (!is_array($cached)) {
				#$res = $this->select(__METHOD__);
				$res = $dbs->query("select {$select} from {$table} {$db_where} {$order} {$db_limit} {$db_offset}");
				$loop = 0;
				while ($row = $dbs->fetchObject($res)) {
					$data[$loop] = array(
						"domain"	=> $row->ref_domain,
						"count"		=> $row->ref_count,
					);
					ApiResult :: setContent( $data[$loop], $row->ref_domain );
					$loop++;
				}
				$dbs->freeResult($res);
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

	#
	#
	function getWhereInternalDomains( $table ) {
		$where = "";
	    $city_domains = WikiFactory::getDomains();

		if (!empty($city_domains) && is_array($city_domains)) {
			$domain_cond = array();
			foreach ( $city_domains as $domain ) {
			    $domain = WikiFactory::getDomainHash($domain);
				$_ = explode(".", $domain);
				$domain_where = "";
				switch ($table) {
					case "city_wikireferer_domains" :
						if (count($_) > 1 && !empty($_[count($_)-2])) {
							$domain_where = $_[count($_)-2]; #i.e. wikia, wikicites etc ..
						}
						break;

					case "city_wikireferer" :
					case "city_wikireferer_urls" :
						if (count($_) > 1 && !empty($_[count($_)-2])) {
							$domain_where = $_[count($_)-2].".".$_[count($_)-1];
						}
						break;
				}
				if (!empty($domain_where))
				{
					if (empty($domain_cond["(ref_domain not like '%".$domain_where."%')"]))
					{
						$domain_cond["(ref_domain not like '%".$domain_where."%')"] = 1;
					}
				}
			}

			#---
			$where = implode (" and ", array_keys($domain_cond));
		}

		return $where;
	}

    #
    #
    private function getNotAllowedDomains($pagename)
    {
        $where = "";
        $domain_cond = array();
        $templateTitle = Title::newFromText ($pagename, NS_MEDIAWIKI);
        if( $templateTitle->exists() )
        {
            $templateArticle = new Article ($templateTitle);
            $templateContent = $templateArticle->getContent();
            $lines = explode( "\n", $templateContent );
            foreach( $lines as $line )
            {
                $line = trim($line);
                $domain_cond["(ref_domain not like '%".$line."%')"] = 1;
            }
			$where = implode (" and ", array_keys($domain_cond));
        }

        return $where;
    }

	/**
	 *
	 * Description functions
	 *
	 */
	protected function getQueryDescription() {
		return 'Get counting of HTTP referers for Wiki';
	}

	/**
	 *
	 * Description parameters
	 *
	 */
	protected function getParamQueryDescription() {
		return array (
			'city'			=> 'Identifier of Wiki page',
			'fromdate' 		=> 'Start date period that user want to generate statistics. Format: YYYY-MM-DD',
			'todate' 		=> 'End of date period that user want to generate statistics. Format: YYYY-MM-DD',
			'domain'		=> 'Domain name. It can be one of following values: "domain.com" (i.e. google.com), "domain.com.jp" (i.e. google.com.pl) or "domain" (i.e. google)',
			'useurl'		=> 'Get statistics for domains with full urls (i.e. google.com?search=wikia)',
			'usefulldomain' => 'Use full name of domains (i.e. www.google.com (not "google"))',
			'useext'		=> 'Use external referrers',
			'notdomain'     => 'Mediawiki article with list of urls which should not visible in result'
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
			"city" => array ( ApiBase :: PARAM_TYPE => 'integer' ),
			"fromdate" => array ( ApiBase :: PARAM_TYPE => 'string', ApiBase :: PARAM_DFLT => 0 ),
			"todate" => array ( ApiBase :: PARAM_TYPE => 'string' ),
			"domain" => array ( ApiBase :: PARAM_TYPE => 'string' ),
			"useurl" => array ( ApiBase :: PARAM_TYPE => 'integer', ApiBase :: PARAM_DFLT => 0 ),
			"usefulldomain" => array ( ApiBase :: PARAM_TYPE => 'integer', ApiBase :: PARAM_DFLT => 0 ),
			"useext" => array ( ApiBase :: PARAM_TYPE => 'integer', ApiBase :: PARAM_DFLT => 0 ),
			"notdomain" => array ( ApiBase :: PARAM_TYPE => 'string' ),
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
			'api.php?action=query&list=wkreferer',
			'api.php?action=query&list=wkreferer&wkdomain=google',
			'api.php?action=query&list=wkreferer&wkfromdate=2007-07-01&wkdomain=wikia',
			'api.php?action=query&list=wkreferer&wkfromdate=2007-07-01&wkdomain=yahoo&wktodate=2007-08-01',
			'api.php?action=query&list=wkreferer&wkfromdate=2007-07-01&wkdomain=wikia&wkuseurl=0',
			'api.php?action=query&list=wkreferer&wkfromdate=2007-07-01&wkdomain=wikia&wkusefulldomain=1',
			'api.php?action=query&list=wkreferer&wkuseurl=0&wkuseext=1',
			'api.php?action=query&list=wkreferer&wknotdomain=Not_allowed_urls',
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
