<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @version: 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension and cannot be used standalone.\n"; exit( 1 ) ;
}

class WikiMetrics {
	/* private */
	private $mTitle;
	private $mPeriods;
	private $mDefPeriod;
	private $mSortList;
	private $mLanguages;
	private $mTopLanguages;
	private $mSort;
	private $mLimit;
	private $mOffset;
	private $cityIds;
	private $mPageViews;
	/* const */
	const START_DATE 		= '2009-04-02';
	const DEF_DAYS_PVIEWS 	= 90;
	const DEF_MONTH_EDITS 	= 1;
	const LIMIT 			= 25;
	const ORDER 			= "created";
	const DESC 				= 'ASC';
	const TIME_DELTA		= 120;
	/* ajax params */
	private $axAction;
    private $axCreated;
    private $axFrom;
    private $axTo;
    private $axLanguage;
    private $axHub;
    private $axDbname;
    private $axDomain;
    private $axExactDomain;
    private $axTitle;
    private $axUser;
    private $axEmail;
    private $axLimit;
    private $axOffset;
    private $axOrder;
    private $axDesc;
    private $axActive;
    private $axClosed;
    private $axRedir;
    private $axRemoved;
    private $axDaily;

	/**
	 * constructor
	 */
	function __construct() {
		$this->mTitle = Title::makeTitle( NS_SPECIAL, "WikiFactory/metrics" );
		$this->mPeriods = array(
			0 => "all",
			1 => "one-week",
			2 => "two-weeks",
			3 => "three-weeks",
			101 => "one-months",
			102 => "two-months",
			103 => "three-months",
			106 => "half-year"
		);
		$this->mDefPeriod = 0;
		$this->mSortList = array(
			"db"				=> "city_dbname",
			"created" 			=> "city_id",
			"title" 			=> "city_title",
			"lang"				=> "city_lang",
			"url"				=> "city_url",
			"founder"			=> "city_founding_email",
			"users"				=> "all_users",
			"regusers"			=> "content_users",
			"articles"			=> "articles",
			"edits"				=> "edits",
			"images"			=> "images"
		);
	}

	public function show( $subtitle = "" ) {
		global $wgUser, $wgOut, $wgExtensionsPath, $wgJsMimeType, $wgResourceBasePath;

		if( $wgUser->isBlocked() ) {
			throw new UserBlockedError( $wgUser->mBlock );
		}

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		if ( !$wgUser->isAllowed('wikifactory') ) {
			$wgOut->redirect( $this->mTitle->getLocalURL() );
			return;
		}

		/**
		 * initial output
		 */
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/WikiFactory/Metrics/css/table.css");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgResourceBasePath}/resources/wikia/libraries/jquery/datatables/jquery.dataTables.min.js\"></script>\n");

		/**
		 * show form
		 */
		@list(, $this->mAction) = explode("/", $subtitle);

		$this->showForm();

		$this->mAction = empty($this->mAction) ? 'main' : $this->mAction;

		if ( $this->mAction == 'main' ) {
			$this->showMainForm();
		} elseif ( $this->mAction == 'monthly' ) {
			$this->showMonthlyForm();
		} elseif ( $this->mAction == 'daily' ) {
			$this->showDailyForm();
		}
	}

	/* draws the form itself  */
	function showForm ($error = "") {
		global $wgOut, $wgContLang, $wgStylePath;
        wfProfileIn( __METHOD__ );

		$wgOut->addExtensionStyle("{$wgStylePath}/common/wikia_ui/tabs.css");

        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
			"error"				=> $error,
			"mAction"			=> $this->mAction,
            "mTitle"			=> $this->mTitle,
        ));
        $wgOut->addHTML( $oTmpl->render("tabs") );
        wfProfileOut( __METHOD__ );
	}

	/* draws the form itself  */
	function showMainForm ($error = "") {
		global $wgOut, $wgContLang;
		global $wgExtensionsPath, $wgRequest;
        wfProfileIn( __METHOD__ );
		#---
		$this->getLangs();
		#---
		$hubs = WikiFactoryHub::getInstance();
		$aCategories = $hubs->getCategories();

		$params = $wgRequest->getValues();
		if ( empty($params['from']) ) {
			$params['from'] = date('Y/m/d', time() - WikiMetrics::TIME_DELTA * 60 * 60 * 24 );
		}
		$oCloseWikiTitle = Title::makeTitle( NS_SPECIAL, "CloseWiki" );
		$action = $oCloseWikiTitle->getFullURL();
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
			"error"				=> $error,
            "action"			=> $action,
            "mPeriods"			=> $this->mPeriods,
            "mDefPeriod"		=> $this->mDefPeriod,
            "wgContLang"		=> $wgContLang,
            "wgExtensionsPath" 	=> $wgExtensionsPath,
            "oCloseWikiTitle"	=> $oCloseWikiTitle,
            "aLanguages" 		=> $this->mLanguages,
			"aTopLanguages" 	=> $this->mTopLanguages,
			"aCategories"		=> $aCategories,
			"params"			=> $params,
			"obj"				=> $this,
        ));
        $wgOut->addHTML( $oTmpl->render("metrics-main-form") );
        wfProfileOut( __METHOD__ );
	}

	/* draws the form itself  */
	function showMonthlyForm ($error = "") {
		global $wgOut, $wgContLang;
		global $wgExtensionsPath, $wgRequest;
        wfProfileIn( __METHOD__ );
		#---
		$hubs = WikiFactoryHub::getInstance();
		$aCategories = $hubs->getCategories();
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
			"error"				=> $error,
            "wgContLang"		=> $wgContLang,
            "wgExtensionsPath" 	=> $wgExtensionsPath,
			"aCategories"		=> $aCategories,
			"obj"				=> $this,
        ));
        $wgOut->addHTML( $oTmpl->render("metrics-monthly-form") );
        wfProfileOut( __METHOD__ );
	}

	/* draws the form itself  */
	function showDailyForm ($error = "") {
		global $wgOut, $wgContLang;
		global $wgExtensionsPath, $wgRequest;
        wfProfileIn( __METHOD__ );
		#---
		$hubs = WikiFactoryHub::getInstance();
		$aCategories = $hubs->getCategories();
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
			"error"				=> $error,
            "wgContLang"		=> $wgContLang,
            "wgExtensionsPath" 	=> $wgExtensionsPath,
			"aCategories"		=> $aCategories,
			"obj"				=> $this,
        ));
        $wgOut->addHTML( $oTmpl->render("metrics-daily-form") );
        wfProfileOut( __METHOD__ );
	}

	/* get languages */
	private function getLangs() {
		$this->mTopLanguages = explode(',', wfMsg('awc-metrics-language-top-list'));
		$this->mLanguages = self::getFixedLanguageNames();
		asort($this->mLanguages);
		return count($this->mLanguages);
	}

	/* make values of request params */
	public function getRequestParams() {
		global $wgRequest;
		wfProfileIn( __METHOD__ );
		$aValues = $wgRequest->getValues();
		if ( !empty($aValues) && is_array($aValues) ) {
			foreach ($aValues as $key => $value) {
				$k = trim($key);
				if ( strpos($key, "awc-") !== false ) {
					$_SESSION[$key] = $value;
					$mKey = str_replace("awc-", "", $key);
					$mKey = str_replace("-", "_", "ax".ucfirst($mKey));
					$this->$mKey = strip_tags($value);
				}
			}
		}
		wfProfileOut( __METHOD__ );
	}

	/* check session params */
	public function getRequestParamsFromSession() {
		wfProfileIn( __METHOD__ );
		if ( !empty($_SESSION) && is_array($_SESSION) ) {
			foreach ($_SESSION as $key => $value) {
				if ( strpos($key, "awc-") !== false ) {
					$mKey = str_replace("awc-", "", $key);
					$mKey = str_replace("-", "_", "ax".ucfirst($mKey));
					$this->$mKey = strip_tags($value);
				}
			}
		}
		wfProfileOut( __METHOD__ );
	}

	/*
	 * build stats records
	 *
	 * @author moli@wikia-inc.com
	 * @return array
	 *
	 */
	public function getMainStatsRecords() {
		global $wgStatsDB, $wgStatsDBEnabled;

		$res = array();
		wfProfileIn( __METHOD__ );

		#---
		list ($AWCCities, $AWCCitiesCount) = $this->getNewWikis();
		
		if ( !empty( $AWCCities ) ) {
			#--- page views 
			$wikiList = array_keys( $AWCCities );
			
			$startDate = date( 'Y-m-01', strtotime('-3 month') );
			$endDate = date( 'Y-m-01', strtotime('now') );
			$pageviews = DataMartService::getPageviewsMonthly( $startDate, $endDate, $wikiList );
			if ( empty( $pageviews ) ) {
				foreach ( $pageviews as $wiki_id => $wiki_data ) {
					#---
					$pviews = array_reduce (
						array (" ", " K", " M", " G"), create_function (
							'$a,$b', 'return is_numeric($a)?($a>=1000?$a/1000:number_format($a,1).$b):$a;'
						), $wiki_data[ 'SUM' ]
					);
					$AWCCities[ $wiki_id ][ "pageviews" ] = $wiki_data[ 'SUM' ];
					$AWCCities[ $wiki_id ][ "pageviews_txt" ] = $pviews;
				}
			}
		}

		#---
		wfProfileOut( __METHOD__ );
		return array($AWCCities, $AWCCitiesCount);
	}

	/*
	 * get list of filtered Wikis
	 *
	 * @author moli@wikia-inc.com
	 * @return array
	 *
	 */
	public function getFilteredWikis() {
		$showAll = true;
		$this->getRequestParamsFromSession();

		list ($AWCCities, $AWCCitiesCount) = $this->getWikis( $showAll );
		return $AWCCities;
	}

	/*
	 * build proper options for SQL queries
	 *
	 * @author moli@wikia-inc.com
	 * @return array
	 *
	 */
	private function buildQueryOptions(&$dbr, $prefix = "") {
		wfProfileIn( __METHOD__ );

		$where = array();
		$city_id = ( !empty($prefix) ) ? "{$prefix}.city_id" : "city_id";

		if ( !empty($this->axCreated) && in_array( $this->axCreated, array_keys($this->mPeriods) ) ) {
			$sCreated = ($this->axCreated > 100) ? intval($this->axCreated - 100) . ' months' : intval($this->axCreated) . ' weeks';
			$date_diff = date( 'Y-m-d 00:00:00', strtotime('-' . $sCreated) ) . "\n";
			$where[] = 'city_created >= ' . $dbr->addQuotes($date_diff);
		}
		$m = array();
		if ( !empty($this->axFrom) && preg_match('/((19|20)[0-9]{2})\/(0[1-9]|1[012])\/(0[1-9]|[12][0-9]|3[01])/', $this->axFrom, $m) !== false ) {
			$from = sprintf( "%s 00:00:00", str_replace('/', '-', $this->axFrom) );
			$where[] = 'city_created >= ' . $dbr->addQuotes($from);
		}
		if ( !empty($this->axTo) && preg_match('/((19|20)[0-9]{2})\/(0[1-9]|1[012])\/(0[1-9]|[12][0-9]|3[01])/', $this->axTo, $m) !== false ) {
			$to = sprintf( "%s 23:59:59", str_replace('/', '-', $this->axTo) );
			$where[] = 'city_created <= ' . $dbr->addQuotes($to);
		}
		if ( !empty($this->axLanguage) ) {
			$countLangs = $this->getLangs();
			if ( !empty( $this->mLanguages ) && in_array( $this->axLanguage, array_keys($this->mLanguages) ) ) {
				$where[] = 'city_lang = ' . $dbr->addQuotes($this->axLanguage);
			}
		}
		if ( !empty($this->axHub) ) {
			$where[] = $city_id . ' in (select ccm1.city_id from wikicities.city_cat_mapping ccm1 where cat_id = '.intval($this->axHub).')';
		}
		if ( !empty($this->axDbname) ) {
			$where[] = 'city_dbname' . $dbr->buildLike( $dbr->anyString(), $this->axDbname, $dbr->anyString() );
		}
		if ( !empty($this->axTitle) ) {
			$where[] = 'city_title >= ' . $dbr->addQuotes($this->axTitle);
		}
		if ( !empty($this->axDomain) ) {
			$wikisIds = $this->getWikisByDomain();
			if (!empty($wikisIds) ) {
				$where[] = "{$city_id} in (" . implode(",", $wikisIds) . ")";
			} else {
				$where[] = "{$city_id} = 0";
			}
		}
		if ( !empty($this->axUser) ) {
			$oFounder = User::newFromName( $this->axUser );
			if ( $oFounder instanceof User ) {
				$where[] = 'city_founding_user = ' . $oFounder->getId();
			}
		}
		if ( !empty($this->axEmail) ) {
			$where[] = 'city_founding_email' . $dbr->buildLike( $dbr->anyString(), str_replace(' ', '_', $this->axEmail), $dbr->anyString() );
		}
		$city_public = array( );
		if ( !empty($this->axActive) ) {
			$city_public[] = 1;
		}
		if ( !empty($this->axClosed) ) {
			$city_public[] = 0;
		}
		if ( !empty($city_public) ) {
			$where[] = 'city_public in (' . implode(",", $city_public) . ')';
		} else {
			$where[] = "{$city_id} = 0";
		}

		if ( !empty($this->cityIds) ) {
			$where[] = 'city_id in (' . implode(",", $this->cityIds) . ')';
		}

		#----
		#- check order - if order is for city_list - we can use limit and order by in SQL query
		#----
		$this->mLimit = ( !empty($this->axLimit) ) ? intval($this->axLimit) : self::LIMIT;
		$this->mOffset = ( !empty($this->axOffset) ) ? intval($this->axOffset) : 0;

		$order = array();
		if ( !empty($this->axOrder) ) {
			$list = explode("|", $this->axOrder);
			if ( !empty($list) ) {
				foreach ( $list as $sort ) {
					list ( $o, $d ) = explode(":", $sort);
					$order[] = $this->mSortList[$o] . " " . $d;
				}
			}
		} else {
			$order = array( $this->mSortList[WikiMetrics::ORDER] . " " . WikiMetrics::DESC );
		}

		$this->mSort = implode(", ", $order);

		wfProfileOut( __METHOD__ );
		return $where;
	}

	/*
	 * get list of Wikis for some params
	 *
	 * @author moli@wikia-inc.com
	 * @return array
	 *
	 */
	private function getNewWikis( $all = false ) {
		global $wgStatsDB, $wgStatsDBEnabled;
		wfProfileIn( __METHOD__ );
		$res = array();

		#- find Wikis with nbr pageviews fewer than X
		$this->cityIds = array();
		if ( !empty($this->axNbrEdits) ) {
			$this->cityIds = $this->getWikisByNbrEdits();
			if ( empty($this->cityIds) ) {
				$this->cityIds = array(0);
			}
		}
		if ( !empty($this->axNbrArticles) ) {
			$this->cityIds = $this->getWikisByNbrArticles();
			if ( empty($this->cityIds) ) {
				$this->cityIds = array(0);
			}
		}
		if ( !empty($this->axNbrPageviews) ) {
			$this->cityIds = $this->getWikisByNbrPageviews();
			if ( empty($this->cityIds) ) {
				$this->cityIds = array(0);
			}
		}

		$AWCMetrics = array();
		$AWCCitiesCount = 0;
		if ( !empty( $wgStatsDBEnabled ) ) {
			/* db */
			$dbr = wfGetDB( DB_SLAVE, "stats", $wgStatsDB );
			/* check params */
			$where = $this->buildQueryOptions($dbr);

			/* number records */
			$options = array();

			$tables = array("wikicities.city_list", "stats.wikia_monthly_stats"); 
			$fields = array(
				"city_id",
				"city_dbname",
				"city_url",
				"city_created",
				"city_founding_user",
				"city_title",
				"city_founding_email",
				"city_lang",
				"city_public",
				"ifnull(round(avg(users_all), 1), 0) as all_users",
				"ifnull(round(avg(users_content_ns), 1),0) as content_users",
				"ifnull(round(avg(articles_edits), 1), 0) as edits",
				"ifnull(max(articles),0) as articles",
				"ifnull(max(images_uploaded),0) as images",
				//"ifnull(avg(pv_views),0) as pviews"
			);

			$join = array(
				'stats.wikia_monthly_stats' => array( 'LEFT JOIN', 'wiki_id = city_id'),
			);

			if ( $all == false ) {
				$oRow = $dbr->selectRow( "wikicities.city_list", "COUNT(*) as cnt", $where, __METHOD__ );
				if ( is_object($oRow) ) {
					$AWCCitiesCount = $oRow->cnt;
				}
				#if ( $this->mSort != $this->axOrder ) {
				$options['LIMIT'] = $this->mLimit;
				$options['OFFSET'] = $this->mOffset;
				$options['GROUP BY'] = 'city_id';
				$options['ORDER BY'] = $this->mSort;
				#}
			} else {
				$options['GROUP BY'] = 'city_id';
				$options['ORDER BY'] = $this->mSort;
				$AWCCitiesCount = 0;
			}

			#----
			$oRes = $dbr->select(
				$tables,
				$fields,
				$where,
				__METHOD__,
				$options,
				$join
			);

			while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				if ( $all === false ) {
					$oFounder = User::newFromId($oRow->city_founding_user);
					$sFounderLink = $sFounderName = "";
					if ($oFounder instanceof User) {
						$sk = RequestContext::getMain()->getSkin();
						$sFounderLink = $sk->makeLinkObj( Title::newFromText($oFounder->getName(), NS_USER), $oFounder->getName());
						$sFounderName = $oFounder->getName();
					}
					$AWCMetrics[ $oRow->city_id ] = array(
						'id' 				=> $oRow->city_id,
						'db' 				=> $oRow->city_dbname,
						'url' 				=> $oRow->city_url,
						'lang'				=> $oRow->city_lang,
						'title'				=> $oRow->city_title,
						'created' 			=> $oRow->city_created,
						'founder'			=> $oRow->city_founding_user,
						'founderUrl'		=> $sFounderLink,
						'founderName'		=> $sFounderName,
						'founderEmail'		=> $oRow->city_founding_email,
						'public'			=> $oRow->city_public,
						#-- stats
						'articles' 			=> $oRow->articles,
						'edits'				=> $oRow->edits,
						'images'			=> $oRow->images,
						'all_users'			=> $oRow->all_users,
						'content_users'		=> $oRow->content_users,
						//'avg_pviews'		=> $oRow->pviews,
						'pageviews'			=> 0,
						'pageviews_txt'		=> 0,
					);
				} else {
					$AWCMetrics[ $oRow->city_id ] = $oRow->city_dbname;
					$AWCCitiesCount++;
				}
			}
			$dbr->freeResult( $oRes );
		}

		wfProfileOut( __METHOD__ );
		return array($AWCMetrics, $AWCCitiesCount);
	}

	/*
	 * get # wikis per hubs per month
	 *
	 * @author moli@wikia-inc.com
	 * @return array
	 *
	 */
	public function getCategoriesRecords() {
		global $wgUser, $wgLang, $wgExternalSharedDB;
		wfProfileIn( __METHOD__ );
		/* db */
		$dbr = wfGetDB( DB_SLAVE, "stats", $wgExternalSharedDB );
		/* check params */
		$this->mLimit = ( !empty($this->axLimit) ) ? intval($this->axLimit) : self::LIMIT;
		$this->mOffset = ( !empty($this->axOffset) ) ? intval($this->axOffset) : 0;
		#----
		$where = array("ccm.city_id = cl.city_id");
		$what = "IFNULL(date_format(cl.city_created, '%Y-%m'), '0000-00')";
		if ( !empty($this->axDaily) ) {
			$what = "IFNULL(date_format(cl.city_created, '%Y-%m-%d'), '0000-00-00')";
		}

		$hubs = WikiFactoryHub::getInstance();
		$aCategories = $hubs->getCategories();

		$AWCMetrics = array();
		$AWCCitiesCount = 0;
		$oRow = $dbr->selectRow(
			"( select distinct($what) from city_list cl ) as c",
			array( " count(*) as cnt " ),
			array(),
			__METHOD__
		);
		if ( $oRow ) {
			$AWCCitiesCount = $oRow->cnt;
		}

		if ( $AWCCitiesCount > 0 ) {

			$oRes = $dbr->select(
				"city_cat_mapping as ccm, city_list as cl",
				array( "$what as row_date, count(*) as cnt" ),
				$where,
				__METHOD__,
				array(
					'GROUP BY' => 'row_date',
					'ORDER BY' => 'row_date DESC',
					'LIMIT' => $this->mLimit,
					'OFFSET' => $this->mOffset
				)
			);
			while ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$firstDate = $lastDate = '';
				if ( empty($this->axDaily) ) {
					$sDate = ($oRow->row_date == '0000-00') ? '1970-01' : $oRow->row_date;
					$dateArr = explode('-', $sDate);
					$stamp = mktime(23,59,59,$dateArr[1],1,$dateArr[0]);
					$out = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
					$firstDate = sprintf("%s-01 00:00:00", $sDate);
					$lastDate = sprintf("%s 23:59:59 \n\n", date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($dateArr[0].'-'.$dateArr[1].'-01 00:00:00')))));
				} else {
					$sDate = ($oRow->row_date == '0000-00-00') ? '1970-01-01' : $oRow->row_date;
					$dateArr = explode('-', $sDate);
					$stamp = mktime(23,59,59,$dateArr[1],$dateArr[2],$dateArr[0]);
					$out = $wgLang->date( wfTimestamp( TS_MW, $stamp ), true );
					$firstDate = sprintf("%s 00:00:00", $sDate);
					$lastDate = sprintf("%s 23:59:59", $sDate);
				}

				$AWCMetrics[$out] = array('count' => $oRow->cnt, 'hubs' => array(), 'start' => $firstDate, 'end' => $lastDate );
			}
			$dbr->freeResult( $oRes );

			if ( !empty($AWCMetrics) ) {
				foreach ( $AWCMetrics as $date => $records ) {
					$where = array(
						"ccm.city_id = cl.city_id",
						"cl.city_created between '". $records['start'] . "' and '" . $records['end'] . "'"
					);

					$oRes = $dbr->select(
						"city_cat_mapping as ccm, city_list as cl",
						array( "ccm.cat_id, count(*) as cnt" ),
						$where,
						__METHOD__,
						array(
							'GROUP BY' => 'cat_id',
						)
					);
					while ( $oRow = $dbr->fetchObject( $oRes ) ) {
						$AWCMetrics[$date]['hubs'][$oRow->cat_id] = array(
							'catName' 	=> (isset($aCategories[$oRow->cat_id])) ? $aCategories[$oRow->cat_id]['name'] : "Undefined",
							'count'		=> $oRow->cnt
						);
					}
					$dbr->freeResult( $oRes );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return array($AWCMetrics, $AWCCitiesCount, $aCategories);
	}

	/*
	 * get a list of language names available for wiki request
	 * (possibly filter some)
	 *
	 * @author nef@wikia-inc.com
	 * @return array
	 *
	 * @see Language::getLanguageNames()
	 * @see RT#11870
	 */
	public static function getFixedLanguageNames() {
		$languages = Language::getLanguageNames();

		$filter_languages = explode(',', wfMsg('requestwiki-filter-language'));
		foreach ($filter_languages as $key) {
			unset($languages[$key]);
		}
		return $languages;
	}

	/*
	 * get a list Wikis where domain contain fragment of string
	 *
	 * @author moli@wikia-inc.com
	 * @return array
	 */
	private function getWikisByDomain() {
		global $wgExternalSharedDB;

		wfProfileIn( __METHOD__ );
		$aCityIds = array();

		$dbr = wfGetDB( DB_SLAVE, "stats", $wgExternalSharedDB );
		$domain = strtolower( $this->axDomain );

		$where = ( isset($this->axExactDomain) && ($this->axExactDomain == 1) )
				? array( "city_domain = 'www.{$domain}.wikia.com'" )
				: array( "city_domain" .  $dbr->buildLike( $dbr->anyString(), $domain, $dbr->anyString() ) );

		$oRes = $dbr->select(
			"city_domains",
			array( 'city_id' ),
			$where,
			__METHOD__,
			array( 'ORDER BY' => 'city_id' )
		);
		while ( $oRow = $dbr->fetchObject( $oRes ) ) {
			if ( !isset($aCityIds[$oRow->city_id]) ) {
				$aCityIds[$oRow->city_id] = $oRow->city_id;
			}
		}
		$dbr->freeResult( $oRes );

		wfProfileOut( __METHOD__ );
		return $aCityIds;
	}

	/*
	 * get a list of Wikis that have nbr of pageviews fewer than X
	 *
	 * @author moli@wikia-inc.com
	 * @return array
	 */
	private function getWikisByNbrPageviews() {
		global $wgMemc, $wgStatsDB, $wgStatsDBEnabled;

		$pageViews = $this->axNbrPageviews;
		$pageViewsDays = $this->axNbrPageviewsDays;
		if ( empty($pageViewsDays) ) {
			$pageViewsDays = self::DEF_DAYS_PVIEWS;
		}

		$memkey = __METHOD__ . "v:" . $pageViews . "vd:" . $pageViewsDays . "vc:" . md5($cityList);
		$cities = $wgMemc->get( $memkey );
		if ( empty( $cities ) && !empty( $wgStatsDBEnabled ) ) {
			$startDate = date( 'Y-m-01', strtotime('-3 month') );
			$endDate = date( 'Y-m-01', strtotime('now') );
			$pageviews = DataMartService::getPageviewsMonthly( $startDate, $endDate, $this->cityIds );
		
			if ( empty( $pageviews ) ) {
				foreach ( $pageviews as $wiki_id => $wiki_data ) {
					#---
					if ( $wiki_data['SUM'] > intval($pageViews) ) continue; 
					$this->mPageViews[ $wiki_id ] = $wiki_data[ 'SUM' ];
					$cities[] = $wiki_id;
				}
			}
			$wgMemc->set( $memkey, $cities, 3600 );
		}

		return $cities;
	}

	/*
	 * get a list of Wikis that have nbr of edits fewer than X
	 *
	 * @author moli@wikia-inc.com
	 * @return array
	 */
	private function getWikisByNbrEdits( ) {
		global $wgStatsDB, $wgMemc, $wgStatsDBEnabled;

		$nbrEdits = $this->axNbrEdits;
		$nbrEditsDays = $this->axNbrEditsDays;
		if ( empty($nbrEditsDays) ) {
			$nbrEditsDays = self::DEF_MONTH_EDITS;
		}

		$date_sub = date('Ym', strtotime('-'.intval($nbrEditsDays).' months'));

		$where = array( 'stats_date >= ' . $date_sub );
		$cityList = "";
		if ( !empty($this->cityIds) ) {
			$cityList = implode(",", $this->cityIds);
			$where[] = " wiki_id in (" . $cityList . ") ";
		}

		$memkey = __METHOD__ . "e:" . $nbrEdits . "ed:" . $nbrEditsDays . "ids:" . md5($cityList);
		$cities = $wgMemc->get( $memkey );
		if ( empty($cities) && !empty( $wgStatsDBEnabled ) ) {
			$dbs = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			$oRes = $dbs->select(
				"wikia_monthly_stats",
				array( 'wiki_id', 'sum(articles_edits) as cnt' ),
				$where,
				__METHOD__,
				array( 'GROUP BY' => 'wiki_id', 'HAVING' => 'cnt < '. intval($nbrEdits) )
			);
			$cities = array();
			while ( $oRow = $dbs->fetchObject( $oRes ) ) {
				$cities[] = $oRow->wiki_id;
			}
			$dbs->freeResult( $oRes );
			$wgMemc->set( $memkey, $cities, 3600 );
		}
		#---
		return $cities;
	}

	/*
	 * get a list of Wikis that have nbr of articles fewer than X
	 *
	 * @author moli@wikia-inc.com
	 * @return array
	 */
	private function getWikisByNbrArticles() {
		global $wgStatsDB, $wgMemc, $wgStatsDBEnabled;

		$nbrArticles = $this->axNbrArticles;
		#----
		$where = array();
		$cityList = "";
		if ( !empty($this->cityIds) ) {
			$cityList = implode(",", $this->cityIds);
			$where[] = " wiki_id in (" . $cityList . ") ";
		}
		$options = array(
			'GROUP BY' => 'wiki_id',
			'HAVING' => '(select c1.articles from wikia_monthly_stats c1 where c1.stats_date = max(c2.stats_date) and c1.wiki_id = c2.wiki_id) <= ' . intval($nbrArticles)
		);

		$memkey = __METHOD__ . "a:" . $nbrArticles . "ids:" . md5($cityList);
		$cities = $wgMemc->get( $memkey );
		if ( empty( $cities ) && !empty( $wgStatsDBEnabled ) ) {
			$dbs = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			$oRes = $dbs->select(
				"wikia_monthly_stats as c2",
				array( 'c2.wiki_id', 'max(c2.stats_date) as m' ),
				$where,
				__METHOD__,
				$options
			);
			$cities = array();
			while ( $oRow = $dbs->fetchObject( $oRes ) ) {
				$cities[] = $oRow->cw_city_id;
			}
			$dbs->freeResult( $oRes );
			$wgMemc->set( $memkey, $cities, 3600 );
		}
		#---
		return $cities;
	}

	/*
	 * get  params
	 *
	 * @author moli@wikia-inc.com
	 * @return array
	 */
	public function setDefaultOption( $params, $field, $default, $value ) {
		$selected = "";
		if ( isset($params[$field]) && ($params[$field] == $value) ) {
			$selected = " selected=\"selected\" ";
		} elseif ( !isset($params[$field]) && ($default == $value) ) {
			$selected = " selected=\"selected\" ";
		} else {
			$selected = "";
		}
		return $selected;
	}

	public function getFrom() { return $this->axFrom; }
	public function setFrom( $value ) { $this->axFrom = $value; }

}
