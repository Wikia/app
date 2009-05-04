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

class CreateWikiMetrics {
	/* private */
	private $mTitle;
	private $mPeriods;
	private $mDefPeriod;
	private $mSortList;
	private $mLanguages;
	private $mTopLanguages;
	private $mSort;
	private $mOrderDesc;
	private $mLimit;
	private $mOffset;
	/* const */
	const START_DATE = '2009-04-02';
	const LIMIT = 25;
	const ORDER = "created";
	const DESC = 1;
	/* ajax params */
	private $axAction;
    private $axCreated;
    private $axFrom;
    private $axTo;
    private $axLanguage;
    private $axDomain;
    private $axTitle;
    private $axFounder;
    private $axFounderEmail;
    private $axLimit;
    private $axOffset;
    private $axOrder;
    private $axDesc;
    private $axClosed;
    private $axRedir;
    private $axDaily;
	
	/**
	 * constructor
	 */
	function __construct() {
		$this->mTitle = Title::makeTitle( NS_SPECIAL, "CloseWiki" );
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
		$this->mDefPeriod = 2;
		$this->mSortList = array(
			"db"				=> "city_dbname",
			"created" 			=> "city_id",
			"title" 			=> "city_title",
			"lang"				=> "city_lang",
			"founderEmail"		=> "city_founding_email",
			"url"				=> "city_url",
			"title"				=> "city_title",
			"founder"			=> "city_founding_user"
		);
		$this->mOrder = array(
			1 => 'DESC',
			-1 => 'ASC',
		);
		wfLoadExtensionMessages("WikiFactory");
	}
	
	public function show( ) {
		global $wgUser, $wgOut, $wgRequest;

		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		
		if ( !in_array( 'staff', $wgUser->getGroups() ) ) {
			$wgOut->redirect( $this->mTitle->getLocalURL() );
			return;
		}
		
		/**
		 * initial output
		 */
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		/**
		 * show form
		 */
		$this->showForm();
	}

	/* draws the form itself  */
	function showForm ($error = "") {
		global $wgOut, $wgContLang;
		global $wgExtensionsPath;
        wfProfileIn( __METHOD__ );
		#---
		$this->getLangs();
		#---
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
        ));
        $wgOut->addHTML( $oTmpl->execute("metrics-main-form") );
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
		$res = array();
		wfProfileIn( __METHOD__ );
		#---
		list ($AWCCities, $AWCCitiesCount) = $this->getWikis();
		if ( !empty( $AWCCities ) ) {
			$dbs = wfGetDBExt(DB_SLAVE);
			$wikiList = implode( ",", array_keys( $AWCCities ) );

			#--- stats 				
			$table = "`dbstats`.`city_stats_full`";
			$db_fields[] = "round(avg(cw_users_all_reg_main_ns), 1) as users_edits";
			$db_fields[] = "max(cw_users_all_reg) as users_reg";
			$db_fields[] = "max(cw_images_uploaded) as images";
			$db_fields[] = "max(cw_db_size) as db_size";
			$db_fields[] = "round(avg(cw_db_edits), 1) as edits";
			$db_fields[] = "round(avg(cw_article_mean_size),1) as mean_size";
			$db_fields[] = "round(avg(cw_article_mean_nbr_revision),1) as mean_nbr_revision";
			$db_fields[] = "round(avg(cw_article_new_per_day),1) as articles_per_day";
			$db_fields[] = "max(cw_article_count_link) as articles";
			$db_fields[] = "max(cw_wikians_total) as wikians";

			$oRes = $dbs->select( 
				$table, 
				array( 'cw_city_id,' . implode( ",", $db_fields ) ),
				array( 'cw_city_id in (' . $wikiList . ')' ),
				__METHOD__,
				array( 'GROUP BY' => 'cw_city_id' )
			);
			while ( $oRow = $dbs->fetchObject( $oRes ) ) {
				$db_size = array_reduce (
					array (" B", " KB", " MB", " GB"), create_function (
						'$a,$b', 'return is_numeric($a)?($a>=1024?$a/1024:number_format($a,1).$b):$a;'
					), $oRow->db_size
				);
				
				$art_size = array_reduce (
					array (" B", " KB", " MB", " GB"), create_function (
						'$a,$b', 'return is_numeric($a)?($a>=1024?$a/1024:number_format($a,1).$b):$a;'
					), $oRow->mean_size
				);
				
				$_tmp = array(
					'wikians' 			=> $oRow->wikians,
					'articles' 			=> $oRow->articles,
					'articles_per_day'	=> sprintf("%0.1f", $oRow->articles_per_day),
					'mean_nbr_revision'	=> sprintf("%0.1f", $oRow->mean_nbr_revision),
					'mean_size_txt'		=> $art_size,
					'mean_size'			=> $oRow->mean_size,
					'edits'				=> $oRow->edits,
					'db_size_txt'		=> $db_size,
					'db_size'			=> $oRow->db_size,
					'images'			=> $oRow->images,
					'users_reg'			=> $oRow->users_reg,
					'users_edits'		=> $oRow->users_edits,
					'pageviews'			=> 0,
					'pageviews_txt'		=> "",
				);
				$AWCCities[ $oRow->cw_city_id ] = array_merge( $AWCCities[ $oRow->cw_city_id ], $_tmp );
			}
			$dbs->freeResult( $oRes );
			
			#--- page views 
			$table = "`dbstats`.`city_page_views`";
			$oRes = $dbs->select( 
				$table, 
				array( 'pv_city_id, sum(pv_views) as cnt' ),
				array( 'pv_city_id in (' . $wikiList . ')' ),
				__METHOD__,
				array( 'GROUP BY' => 'pv_city_id' )
			);
			while ( $oRow = $dbs->fetchObject( $oRes ) ) {
				$page_views = array_reduce (
					array (" ", " K", " M", " G"), create_function (
						'$a,$b', 'return is_numeric($a)?($a>=1000?$a/1000:number_format($a,1).$b):$a;'
					), $oRow->cnt
				);
				$AWCCities[ $oRow->pv_city_id ][ "pageviews" ] = $oRow->cnt;
				$AWCCities[ $oRow->pv_city_id ][ "pageviews_txt" ] = $page_views;
			}
			$dbs->freeResult( $oRes );
			
			#--- order data
			if ( !in_array( $this->mSort, array_keys($this->mSortList)) && !in_array( $this->mSort, array_values($this->mSortList)) ) {
				#--- sort manually
				$_tmp = array();
				foreach ($AWCCities as $iCity => $aRow) {
					$_tmp[ $iCity ] = ( isset( $aRow[$this->mSort] ) ) ? $aRow[$this->mSort] : 0;
				}
				if ( !empty( $_tmp ) ) {
					( $this->mOrderDesc == 'DESC' ) ? arsort($_tmp) : asort($_tmp);
					$AWCCitiesCount = count($_tmp);
					$_fixArray = array_slice( $_tmp, $this->mOffset, $this->mLimit, true );
					if ( !empty($_fixArray) ) {
						foreach ($_fixArray as $iCity => $sortValue) {
							$res[ $iCity ] = $AWCCities[ $iCity ];
						}			
					}
				}
			} else {
				$res = $AWCCities;
			}
		}
		#---
		wfProfileOut( __METHOD__ );
		return array($res, $AWCCitiesCount);
	}

	/*
	 * build proper options for SQL queries
	 *
	 * @author moli@wikia-inc.com
	 * @return array
	 *
	 */
	private function buildQueryOptions(&$dbr) {
		wfProfileIn( __METHOD__ );

		$where = array();

		if ( !empty($this->axCreated) && in_array( $this->axCreated, array_keys($this->mPeriods) ) ) {
			$sCreated = ($this->axCreated > 100) ? intval($this->axCreated - 100) . ' MONTH' : intval($this->axCreated) . ' WEEK';
			$where[] = 'city_created >= DATE_SUB(NOW(), INTERVAL ' . $sCreated . ')';
		}
		$m = array();
		if ( !empty($this->axFrom) && preg_match('/((19|20)[0-9]{2})\/(0[1-9]|1[012])\/(0[1-9]|[12][0-9]|3[01])/', $this->axFrom, $m) !== false ) {
			$where[] = 'DATE_FORMAT(city_created, \'%Y/%m/%d\') >= ' . $dbr->addQuotes($this->axFrom);
		}
		if ( !empty($this->axTo) && preg_match('/((19|20)[0-9]{2})\/(0[1-9]|1[012])\/(0[1-9]|[12][0-9]|3[01])/', $this->axTo, $m) !== false ) {
			$where[] = 'DATE_FORMAT(city_created, \'%Y/%m/%d\') <= ' . $dbr->addQuotes($this->axTo);
		}
		if ( !empty($this->axLanguage) ) {
			$countLangs = $this->getLangs();
			if ( !empty( $this->mLanguages ) && in_array( $this->axLanguage, array_keys($this->mLanguages) ) ) {
				$where[] = 'city_lang = ' . $dbr->addQuotes($this->axLanguage);
			}
		}
		if ( !empty($this->axDomain) ) {
			$where[] = 'city_dbname LIKE "%' . $dbr->escapeLike($this->axDomain) . '%"';
		}
		if ( !empty($this->axTitle) ) {
			$where[] = 'city_title >= ' . $dbr->addQuotes($this->axTitle);
		}
		if ( !empty($this->axFounder) ) {
			$oFounder = User::newFromName( $this->axFounder );
			if ( $oFounder instanceof User ) {
				$where[] = 'city_founding_user = ' . $oFounder->getId();
			}
		}
		if ( !empty($this->axFounderEmail) ) {
			$where[] = 'city_founding_email LIKE "%' . $dbr->escapeLike( str_replace(' ', '_', $this->axFounderEmail) ) . '%"';
		}
		$city_public = array( 0 => 1 );
		if ( !empty($this->axClosed) ) {
			$city_public[] = 0;
		}
		if ( !empty($this->axRedir) ) {
			$city_public[] = 2;
		}
		$where[] = 'city_public in (' . implode(",", $city_public) . ')';

		#----
		#- check order - if order is for city_list - we can use limit and order by in SQL query
		#----
		$this->mLimit = ( !empty($this->axLimit) ) ? intval($this->axLimit) : self::LIMIT;
		$this->mOffset = ( !empty($this->axOffset) ) ? intval($this->axOffset * $this->axLimit) : 0;
		$this->mSort = $this->mSortList[self::ORDER]; 
		if ( !empty($this->axOrder) && in_array( $this->axOrder, array_keys( $this->mSortList ) ) ) {
			$this->mSort = $this->mSortList[$this->axOrder];
		} else {
			$this->mSort = $this->axOrder;
		}
		#---
		$this->mOrderDesc = $this->mOrder[self::DESC]; 
		if ( !empty($this->axDesc) && in_array( $this->axDesc, array_keys($this->mOrder) ) ) {
			$this->mOrderDesc = $this->mOrder[$this->axDesc];
		}

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
	private function getWikis() {
		wfProfileIn( __METHOD__ );
		$res = array();

		/* db */
		$dbr = wfGetDB( DB_SLAVE );
		/* check params */
		$where = $this->buildQueryOptions($dbr);
		#----
		$options[] = 'SQL_CALC_FOUND_ROWS';
		if ( $this->mSort != $this->axOrder ) {
			$options['LIMIT'] = $this->mLimit;
			$options['OFFSET'] = $this->mOffset;
			$options['ORDER BY'] = $this->mSort . " " . $this->mOrderDesc;
		}

		#----
		$oRes = $dbr->select( 
			"`wikicities`.`city_list`", 
			array( "city_id, city_dbname, city_url, city_created, city_founding_user, city_title, city_founding_email, city_lang, city_public" ),
			$where,
			__METHOD__,
			$options
		);
		
		$AWCCitiesCount = 0;
		if ( $this->mSort != $this->axOrder ) {
			$oResCnt = $dbr->query('SELECT FOUND_ROWS() as rowsCount');
			$oRowCnt = $dbr->fetchObject ( $oResCnt );
			$AWCCitiesCount = $oRowCnt->rowsCount;
			$dbr->freeResult( $oResCnt );
		}

		$AWCMetrics = array();
		while ( $oRow = $dbr->fetchObject( $oRes ) ) {
			$oFounder = User::newFromId($oRow->city_founding_user);
			$sFounderLink = $sFounderName = "";
			if ($oFounder instanceof User) {
				$sk = $oFounder->getSkin();
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
				'wikians' 			=> 0,
				'articles' 			=> 0,
				'articles_per_day'	=> 0,
				'mean_nbr_revision'	=> 0,
				'mean_size'			=> 0,
				'mean_size_txt'		=> "",
				'edits'				=> 0,
				'db_size'			=> 0,
				'db_size_txt'		=> "",
				'images'			=> 0,
				'users_reg'			=> 0,
				'users_edits'		=> 0,
				'pageviews'			=> 0,
				'pageviews_txt'		=> 0,
			);
		}
		$dbr->freeResult( $oRes );

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
		global $wgUser, $wgLang;
		/* db */
		$dbr = wfGetDB( DB_SLAVE, 'dpl' );
		/* check params */
		$where = $this->buildQueryOptions($dbr);
		#----
		if ( empty($where) ) {
			$where = array();
		}
		
		#----
		$where[] = "ccm.city_id = cl.city_id";
		$what = "IFNULL(date_format(cl.city_created, '%Y-%m'), '0000-00')";
		if ( !empty($this->axDaily) ) {
			$what = "IFNULL(date_format(cl.city_created, '%Y-%m-%d'), '0000-00-00')";
		}
			
		$oRes = $dbr->select( 
			"`wikicities`.`city_cat_mapping` as ccm, `wikicities`.`city_list` as cl", 
			array( "ccm.cat_id, $what as row_date, count(*) as cnt" ),
			$where,
			__METHOD__,
			array(
				'GROUP BY' => 'cat_id, row_date', 
				'ORDER BY' => 'row_date desc',
			)
		);

		$hubs = WikiFactoryHub::getInstance();
		$aCategories = $hubs->getCategories();

		$AWCMetrics = array(); $AWCCitiesCount = 0;
		while ( $oRow = $dbr->fetchObject( $oRes ) ) {
			if ( empty($this->axDaily) ) {
				$sDate = ($oRow->row_date == '0000-00') ? '1970-01' : $oRow->row_date;
				$dateArr = explode('-', $sDate);
				$stamp = mktime(23,59,59,$dateArr[1],1,$dateArr[0]);
				$out = $wgLang->sprintfDate("M Y", wfTimestamp(TS_MW, $stamp));
			} else {
				$sDate = ($oRow->row_date == '0000-00-00') ? '1970-01-01' : $oRow->row_date;
				$dateArr = explode('-', $sDate);
				$stamp = mktime(23,59,59,$dateArr[1],$dateArr[2],$dateArr[0]);
				$out = $wgLang->date( wfTimestamp( TS_MW, $stamp ), true );
			}

			$AWCMetrics[$out][$oRow->cat_id] = array(
				'month' 	=> $sDate,
				'monthTxt' 	=> $out,
				'catId' 	=> $oRow->cat_id,
				'catName' 	=> $aCategories[$oRow->cat_id],
				'count'		=> $oRow->cnt
			);
			$AWCCitiesCount += $oRow->cnt;
		}
		$dbr->freeResult( $oRes );

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
	
}
