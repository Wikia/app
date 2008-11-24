<?php

/**
 * WikiaApiQueryReferers - get list of top votes of articles
 *
 * @author Piotr Molski (moli) <moli@wikia.com>
 *
 */

class WikiaApiQueryReferers extends WikiaApiQuery {

	public function __construct($query, $moduleName) { parent :: __construct($query, $moduleName); }

	public function execute() {
		global $wgUser;

		switch ($this->getActionName()) {
			case parent::INSERT : break;
			case parent::UPDATE : break;
			case parent::DELETE : break;
			default: $this->getWikiReferers(); break;
		}
	}

	protected function getDB() { return wfGetDBExt(DB_SLAVE); }

	private function getWikiReferers () {
		global $wgDBStats, $wgCityId;
		global $wgServerName, $wgDBname;
		
		#--- initial parameters (dbname, limit, offset ...)
		extract($this->getInitialParams());
		
		#--- request parameters ()
		extract($this->extractRequestParams());
		
		$this->initCacheKey($lcache_key, __METHOD__);
		
		#---
		$user_id = $this->getUser()->getId();
		$ip = wfGetIP();
		$browserId = $this->getBrowser();
		
		#---
		$aTmp = $aData = array();
		$where_derived = " ref_domain != '' and ref_domain != '".$wgServerName."' and ref_domain not like '%$wgDBname.wikia%' and ref_domain not like '%wikia-inc.com%'";
		try {
			#--- database instance - DB_SLAVE
			$dbs = $this->getDB();
			
			if ( is_null($dbs) ) throw new WikiaApiQueryError(0); 

			#--- identifier of wikia
			$city = ( !is_null($city) ) ? intval($city) : intval($wgCityId);
			if ( !is_null($city) ) {
				$where_derived .= " and ref_city_id = '".intval($city)."' ";
				$this->setCacheKey( $lcache_key, 'C', $city );
			}

			#--- number of months 
			$fromdate = intval($fromdate);
			switch ($fromdate) { 
				// last month 
				case "1" : $where_derived .= " and ref_type = 2 "; break;
				// last 3 months 
				case "3" : $where_derived .= " and ref_type = 3 "; break;
				// last 6 months 
				case "6" : $where_derived .= " and ref_type = 4 "; break;
				// default (all referrers)
				default  : $where_derived .= " and ref_type = 1 "; break;
			}
			$this->setCacheKey( $lcache_key, 'FM', $fromdate );

			#--- use full name of domain
			$define_table = "city_wikireferer_domain_views";
			if ( !empty($usefulldomain) ) {
				$this->setCacheKey ($lcache_key, 'FD', $usefulldomain);
				$define_table = "city_wikireferer_views";
			}
			#--- name of domain
			if ( !empty($domain) ) {
				$this->setCacheKey ($lcache_key, 'D', $domain);
				$where_derived .= " and ref_domain = '{$domain}' ";

				#--- check domain
				$part_domain = explode(".",$domain);
				if (count($part_domain) == 1) {
                    $this->setCacheKey ($lcache_key, 'WCD', 1);
					$define_table = "city_wikireferer_domain_views";
				} else {
                    $this->setCacheKey ($lcache_key, 'WC', 1);
					$define_table = "city_wikireferer_views";
				}
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

			$table = "`{$wgDBStats}`.`{$define_table}`";
			$select = " ref_domain, ref_count ";
			$order = ""; #"ORDER BY ref_count DESC";

			#---
			if ( !empty($ctime) ) {
				if ( !$this->isInt($ctime) ) throw new WikiaApiQueryError(1);
			}

			// check data from cache ...
			$cached = $this->getDataFromCache($lcache_key);
			if (!is_array($cached)) {
				$res = $dbs->query("select {$select} from {$table} where {$where_derived} {$order} ");
				$loop = 0;
				while ($row = $dbs->fetchObject($res)) {
					$aTmp[$row->ref_count] = array (
						"domain"	=> $row->ref_domain,
						"count"		=> $row->ref_count,
					);
					$loop++;
				}
				$dbs->freeResult($res);
				$this->saveCacheData($lcache_key, $aTmp, $ctime);
			} else {
				$aTmp = $cached;
			}
			
			$iLimit = $iOffset = 0;
			#--- limit
			if ( !empty($limit)  ) {
				if ( !$this->isInt($limit) ) {
					throw new WikiaApiQueryError(1);
				}
				$iLimit = $limit;
			} 
			
			#--- offset
			if ( !empty($offset)  ) {
				if ( !$this->isInt($offset) ) {
					throw new WikiaApiQueryError(1);
				}
				$iOffset = $offset;
			} 
			
			if (!empty($aTmp)) {
				krsort($aTmp);
				$aData = array_slice($aTmp, $iOffset, $iLimit);
				foreach ($aData as $i => $aDomain) {
					ApiResult::setContent( $aData[$i], $aDomain['domain'] );
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
			$sData = $e->getText();
			$this->getResult()->setIndexedTagName($sData, 'fault');
		} else { 
			$this->getResult()->setIndexedTagName($aData, 'item');
		}
		$this->getResult()->addValue('query', $this->getModuleName(), $aData);
	}

	private function getWhereInternalDomains( $table ) {
		$where = "";
		$city_domains = WikiFactory::getDomains();
		if (!empty($city_domains) && is_array($city_domains)) {
			$domain_cond = array();
			foreach ( $city_domains as $domain ) {
				$domain = WikiFactory::getDomainHash($domain);
				$_ = explode(".", $domain);
				$domain_where = "";
				switch ($table) {
					case "city_wikireferer_domain_views":
						if (count($_) > 1 && !empty($_[count($_)-2])) $domain_where = $_[count($_)-2]; #i.e. wikia, wikicites etc ..
						break;
					case "city_wikireferer_views" 		:
						if (count($_) > 1 && !empty($_[count($_)-2])) $domain_where = $_[count($_)-2].".".$_[count($_)-1];
						break;
				}
				if (!empty($domain_where)) 
					if (empty($domain_cond["(ref_domain not like '%".$domain_where."%')"]))
						$domain_cond["(ref_domain not like '%".$domain_where."%')"] = 1;
			}

			#---
			$where = implode (" and ", array_keys($domain_cond));
		}
		return $where;
	}

	private function getNotAllowedDomains($pagename) {
		$where = "";
		$domain_cond = array();
		$templateTitle = Title::newFromText ($pagename, NS_MEDIAWIKI);
		if ( $templateTitle->exists() ) {
			$templateArticle = new Article ($templateTitle);
			$templateContent = $templateArticle->getContent();
			$lines = explode( "\n", $templateContent );
			foreach( $lines as $line ) {
				$line = trim($line);
				$domain_cond["(ref_domain not like '%".$line."%')"] = 1;
			}
			$where = implode (" and ", array_keys($domain_cond));
		}
		return $where;
	}

	protected function getQueryDescription() {
		return 'Get counting of HTTP referers for Wiki';
	}

	protected function getParamQueryDescription() {
		return array (
			'city'			=> 'Identifier of Wiki page',
			'fromdate' 		=> 'last 1, 3 or 6 months. Default value: 0 (all referrers)',
			'domain'		=> 'Domain name. It can be one of following values: "domain.com" (i.e. google.com), "domain.com.jp" (i.e. google.com.pl) or "domain" (i.e. google)',
			'usefulldomain' => 'Use full name of domains (i.e. www.google.com (not "google"))',
			'useext'		=> 'Show only external referrers',
			'notdomain'     => 'List of domains which should not be visible in result'
		);
	}

	protected function getAllowedQueryParams() {
		return array (
			"city" 			=> array ( ApiBase :: PARAM_TYPE => 'integer' ),
			"fromdate" 		=> array ( ApiBase :: PARAM_TYPE => 'integer', ApiBase :: PARAM_DFLT => 0 ),
			"domain" 		=> array ( ApiBase :: PARAM_TYPE => 'string' ),
			"usefulldomain" => array ( ApiBase :: PARAM_TYPE => 'integer', ApiBase :: PARAM_DFLT => 0 ),
			"useext" 		=> array ( ApiBase :: PARAM_TYPE => 'integer', ApiBase :: PARAM_DFLT => 0 ),
			"notdomain" 	=> array ( ApiBase :: PARAM_TYPE => 'string' ),
		);
	}

	protected function getQueryExamples() {
		return array (
			'api.php?action=query&list=wkreferer',
			'api.php?action=query&list=wkreferer&wkdomain=google',
			'api.php?action=query&list=wkreferer&wkfromdate=1&wkdomain=wikia',
			'api.php?action=query&list=wkreferer&wkfromdate=3&wkdomain=yahoo',
			'api.php?action=query&list=wkreferer&wkfromdate=6&wkdomain=wikia&wkuseurl=0',
			'api.php?action=query&list=wkreferer&wkfromdate=0&wkdomain=wikia&wkusefulldomain=1',
			'api.php?action=query&list=wkreferer&wkuseurl=0&wkuseext=1',
			'api.php?action=query&list=wkreferer&wknotdomain=Not_allowed_urls',
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: '.__CLASS__.'.php '.filesize(dirname(__FILE__)."/".__CLASS__.".php").' '.strftime("%Y-%m-%d %H:%M:%S", time()).'Z wikia $';
	}
};
