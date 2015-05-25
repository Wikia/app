<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia.com> for Wikia.com
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

class WikiStatsPage extends IncludableSpecialPage
{
    var $mPosted;
    var $mStats;
    var $mSkinName;
    var $userIsSpecial;
    var $mFromDate;
    var $mToDate;
    var $mTitle;
    var $mTab;
    var $mUser;
    var $mSkin;
    var $mCityId;
    var $mCityDBName;
    var $mCityDomain;
    var $mLang;
    var $mHub;
    var $mNS;
    var $mNamespaces;
    var $mPredefinedNamespaces;
    var $mAction;
    var $mActiveTab;
    var $mXLS;
    var $mAllWikis;
    var $mMonth;
    var $mLimit;

	private $defaultAction = 'main';
    const USE_MEMC = 0;

    #--- constructor
    public function __construct() {
        parent::__construct( "WikiStats", "",  true/*class*/);
		SpecialPageFactory::setGroup( 'WikiStats', 'wiki' );
    }

    public function execute( $subpage ) {
        global $wgUser, $wgOut, $wgRequest, $wgCityId, $wgDBname, $wgLang, $wgStatsDBEnabled;

        if ( $wgUser->isBlocked() ) {
			throw new UserBlockedError( $this->getUser()->getBlock() );
        }

        if ( wfReadOnly() ) {
            $wgOut->readOnlyPage();
            return;
        }

		if ( !$wgStatsDBEnabled ) {
			throw new MWException( 'We have a problem connecting to our statistics database. We are very sorry for the inconvenience, please try again later.' );
		}

		// Set the current wiki ID, DB name and user from globals
		$this->mCityId     = $wgCityId;
		$this->mCityDBName = $wgDBname;
		$this->mUser       = $wgUser;

		// Check the current $wgUser against the set of groups WikiStats recognizes
		$this->userIsSpecial = WikiStats::isAllowed();

		$this->mFromDate 	= $wgRequest->getVal("wsfrom", WIKISTATS_MIN_STATS_YEAR.WIKISTATS_MIN_STATS_MONTH);
		$this->mToDate 		= $wgRequest->getVal("wsto", date("Ym"));
		$this->mTitle 		= Title::makeTitle( NS_SPECIAL, "WikiStats" );
		$this->mAction		= $wgRequest->getVal("action", "");
		$this->mXLS 		= $wgRequest->getVal("wsxls", false);
		$this->mMonth 		= $wgRequest->getVal("wsmonth", 0);
		$this->mLimit		= $wgRequest->getVal("wslimit", WIKISTATS_WIKIANS_RANK_NBR);
		$this->mAllWikis 	= 0;

		// Use the first part of the subpage as the action
		if ( $subpage ) {
			$path = explode("/", $subpage);
			$this->mAction = $path[0];
		}

		// Redirect to the default action if one hasn't been set
		if ( empty($this->mAction) ) {
			$wgOut->redirect( $this->mTitle->getFullURL("action={$this->defaultAction}") );
		}

		// Split out the the from and to month and year for convenience
		if ( preg_match("/^([0-9]{4})([0-9]{1,2})/", $this->mFromDate, $m) ) {
			list (, $this->fromYear, $this->fromMonth) = $m;
		} else {
			$wgOut->showErrorPage("Bad parameters", "wikistats_error_malformed_date");
			return;
		}

		if ( preg_match("/^([0-9]{4})([0-9]{1,2})/", $this->mToDate, $m) ) {
			list (, $this->toYear, $this->toMonth) = $m;
		} else {
			$wgOut->showErrorPage("Bad parameters", "wikistats_error_malformed_date");
			return;
		}

		$domain = $all = "";
		if ( $this->userIsSpecial ) {
			$this->mLang 		= $wgRequest->getVal("wslang", "");
			$this->mHub 		= $wgRequest->getVal("wscat", "");
			$this->mNS 			= $wgRequest->getIntArray("wsns", "");
			$domain 			= $wgRequest->getVal( "wswiki", "" );
			$all 				= $wgRequest->getVal( "wsall", 0 );
			$this->mNamespaces  = $wgLang->getNamespaces();
		}

		// Override some values if we're special and got a domain (or 'all')
		if ( $domain == 'all' || $all == 1 ) {
        	$this->mCityId = 0;
        	$this->mCityDBName = WIKISTATS_CENTRAL_ID;
        	$this->mCityDomain = 'all';
        	$this->mAllWikis = 1;
		} elseif ( !empty($domain) && $this->userIsSpecial == 1 ) {
        	$this->mCityId = WikiFactory::DomainToId($domain);
        	$this->mCityDBName = WikiFactory::IDToDB($this->mCityId);
        	$this->mCityDomain = $domain;
		} else {
        	$this->mCityDomain = WikiFactory::DBToDomain($this->mCityDBName);
		}

        $this->mStats = WikiStats::newFromId($this->mCityId);
		$this->mPredefinedNamespaces = $this->mStats->getPageNSList();

        $this->mStats->setStatsDate( array(
        	'fromMonth' => $this->fromMonth,
        	'fromYear' 	=> $this->fromYear,
        	'toMonth'	=> $this->toMonth,
        	'toYear'	=> $this->toYear
        ));

        $this->mStats->setHub($this->mHub);
        $this->mStats->setLang($this->mLang);

        #---
        $this->mSkin = RequestContext::getMain()->getSkin();
        if ( is_object ($this->mSkin) ) {
            $skinname = get_class( $this->mSkin );
            $skinname = strtolower(str_replace("Skin","", $skinname));
            $this->mSkinName = $skinname;
        }

		$this->showForm();

		if ( $this->mAction ) {
			$func = 'show'.ucfirst(strtolower($this->mAction));
			if ( method_exists($this, $func) ) {
				$this->$func($subpage);
			}
		}
    }

	function showForm ($error = "") {
		global $wgOut, $wgContLang, $wgExtensionsPath, $wgJsMimeType, $wgStylePath;
        wfProfileIn( __METHOD__ );

		$this->setHeaders();

		# css
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/WikiStats/css/wikistats.css");
		$wgOut->addExtensionStyle("{$wgStylePath}/common/wikia_ui/tabs.css");

		# script
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiStats/js/wikistats.js\"></script>\n");

		# main page
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

        $oTmpl->set_vars( array(
        	"mTitle"			=> $this->mTitle,
        	"wgContLang"		=> $wgContLang,
        	"wgExtensionsPath" 	=> $wgExtensionsPath,
        	"wgStylePath"		=> $wgStylePath,
        	"wgCityId"			=> $this->mCityId,
        	"oUser"				=> $this->mUser,
        	"mAction"			=> $this->mAction,
        	"userIsSpecial"		=> $this->userIsSpecial,
        	"domain"			=> $this->mCityDomain,
        	"dateRange"			=> $this->mStats->getRangeDate(),
        	"updateDate"		=> $this->mStats->getUpdateDate(),
        	"fromMonth"			=> $this->fromMonth,
        	"fromYear"			=> $this->fromYear,
        	"curMonth"			=> intval($this->toMonth),
        	"curYear"			=> intval($this->toYear),
			"mHub"				=> $this->mHub,
			"mLang"				=> $this->mLang,
			"mAllWikis"			=> $this->mAllWikis
        ));
        $wgOut->addHTML( $oTmpl->render("main-form") );

        wfProfileOut( __METHOD__ );
        return 1;
	}

	private function showMenu($subpage = '', $namespaces = false) {
		global $wgDBname;
        wfProfileIn( __METHOD__ );

		$aTopLanguages = explode(',', wfMsg('wikistats_language_toplist'));
		$aLanguages = wfGetFixedLanguageNames();
		asort($aLanguages);
		#-
		$hubs = WikiFactoryHub::getInstance();
		$_cats = $hubs->getAllCategories();
		$aCategories = array();
		if ( !empty($_cats) ) {
			foreach ( $_cats as $id => $cat ) {
				if ( !isset($aCategories[$id]) ) {
					$aCategories[$id] = $cat['name'];
				}
			}
		};

		# main page
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $params = array(
        	"mTitle"			=> $this->mTitle,
        	"wgCityId"			=> $this->mCityId,
        	"domain"			=> $this->mCityDomain,
        	"dateRange"			=> $this->mStats->getRangeDate(),
        	"updateDate"		=> $this->mStats->getUpdateDate(),
        	"fromMonth"			=> $this->fromMonth,
        	"fromYear"			=> $this->fromYear,
        	"curMonth"			=> intval($this->toMonth),
        	"topLanguages"		=> $aTopLanguages,
        	"aLanguages"		=> $aLanguages,
        	"categories"		=> $aCategories,
        	"curYear"			=> intval($this->toYear),
			"mHub"				=> $this->mHub,
			"mLang"				=> $this->mLang,
			"mAllWikis"			=> $this->mAllWikis,
			"mAction"			=> $this->mAction
        );

		#- additional menu for namespaces;
		if ( $namespaces ) {
			$params['namespaces'] = $this->mNamespaces;
			$params['definedNamespaces'] = $this->mPredefinedNamespaces;
			$params['mNS'] = $this->mNS;
		}

        $oTmpl->set_vars( $params );

        if ( $this->userIsSpecial == 1 && $wgDBname == WIKISTATS_CENTRAL_ID ) {
			$res = $oTmpl->render("select");
		} else {
			$res = $oTmpl->render("select_user");
		}

        wfProfileOut( __METHOD__ );
        return $res;
	}

	private function showMain($subpage = '') {
        global $wgUser, $wgContLang, $wgLang, $wgStatsExcludedNonSpecialGroup, $wgOut;
		#---
		if ( empty($this->mXLS) ) {
			wfProfileIn( __METHOD__ );
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"data"			=> $this->mStats->loadStatsFromDB(),
				"ns_data"		=> $this->mStats->loadMonthlyNSActions(),
				"today" 		=> date("Ym"),
				"today_day"     => $this->mStats->getLatestStats(),
				"user"			=> $wgUser,
				"diffData"		=> $this->mStats->loadMonthlyDiffs(),
				"cityId"		=> $this->mCityId,
				"wgContLang" 	=> $wgContLang,
				"wgLang"		=> $wgLang,
				"mStats"		=> $this->mStats,
				"userIsSpecial" => $this->userIsSpecial,
				"wgStatsExcludedNonSpecialGroup" => $wgStatsExcludedNonSpecialGroup
			) );
			$wgOut->addHTML( $this->showMenu() );
			if  ( $this->mFromDate <= $this->mToDate ) {
				$wgOut->addHTML( $this->mStats->getBasicInformation() );
				$wgOut->addHTML( $oTmpl->render("main-table-stats") );

				$oTmpl->set_vars( array(
					"columns" 		=> $this->mStats->getRangeColumns(),
					"userIsSpecial"	=> $this->userIsSpecial,
					"wgStatsExcludedNonSpecialGroup" => $wgStatsExcludedNonSpecialGroup
				));
				$wgOut->addHTML( $oTmpl->render("main-stats-definitions") );
			}
			wfProfileOut( __METHOD__ );
		} else {
			// These are sorted by default in descending order; reverse it.
			$count_data = array_reverse($this->mStats->loadStatsFromDB(), true);
			$diffs_data = array_reverse($this->mStats->loadMonthlyDiffs(), true);

			$XLSObj = new WikiStatsXLS( $this->mStats,
									    array_merge($count_data,
													array('X' => array('label' => '')),
													$diffs_data),
										wfMsg('wikistats_filename_mainstats', $this->mCityDBName));
			$XLSObj->makeMainStats();
		}
        #---
        return 1;
	}

	private function showRollup($subpage = '') {
		global $wgOut, $wgCityId, $wgDBname, $wgRequest;

		$period = $wgRequest->getVal("wsperiod", "monthly");
		$wiki_id = $this->mCityId ? $this->mCityId : $wgCityId;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			'data' => $this->mStats->rollupStats($wiki_id, $period == "monthly", $period != "monthly"),
			'wiki_name'	  => $this->mCityDomain,
			'wiki_select' => ( $this->userIsSpecial == 1 && $wgDBname == WIKISTATS_CENTRAL_ID ),
			'mTitle'	  => $this->mTitle,
			'mAction'	  => $this->mAction,
			'wsperiod'    => $period
		) );

		$wgOut->addHTML( $oTmpl->render("rollup") );
		return 1;
	}

	private function showBreakdown($subpage = '') {
		$this->__showBreakdown(0);
        return 1;
	}

	private function showAnonbreakdown($subpage = '') {
		$this->__showBreakdown(1);
        return 1;
	}

	private function __showBreakdown($anons = 0) {
        global $wgUser, $wgContLang, $wgLang, $wgOut;
		#---
		$out = $this->mStats->userBreakdown($this->mMonth, $this->mLimit, $anons);

		if ( empty($this->mXLS) ) {
			wfProfileIn( __METHOD__ );
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"mTitle"		=> $this->mTitle,
				"mMonth"		=> $this->mMonth,
				"mLimit"		=> $this->mLimit,
				"user"			=> $wgUser,
				"cityId"		=> $this->mCityId,
				"wgContLang" 	=> $wgContLang,
				"mAction"		=> $this->mAction,
				"wgLang"		=> $wgLang,
				"anons"			=> $anons,
				"data"			=> $out
			) );
			$wgOut->addHTML( $oTmpl->render("activity") );
			wfProfileOut( __METHOD__ );
		} else {
/*			$data = $this->mStats->loadStatsFromDB();
			$columns = $this->mStats->getRangeColumns();
			$XLSObj = new WikiStatsXLS( $this->mStats, $data, wfMsg('wikistats_filename_mainstats', $this->mCityDBName));
			$XLSObj->makeMainStats($columns);
*/
		}
		#---
		return 1;
	}

	private function showActivity($subpage = '') {
		global $wgUser, $wgContLang, $wgLang, $wgOut, $wgJsMimeType, $wgResourceBasePath;
		wfProfileIn( __METHOD__ );

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgResourceBasePath}/resources/wikia/libraries/jquery/datatables/jquery.dataTables.min.js\"></script>\n");

		@list (, $pyear, $pmonth, $plang, $pcat) = explode("/", $subpage);

		$aTopLanguages = explode(',', wfMsg('wikistats_language_toplist'));
		$aLanguages = wfGetFixedLanguageNames();
		asort($aLanguages);
		#-
		$hubs = WikiFactoryHub::getInstance();
		$_cats = $hubs->getAllCategories();
		$aCategories = array();
		if ( !empty($_cats) ) {
			foreach ( $_cats as $id => $cat ) {
				if ( !isset($aCategories[$id]) ) {
					$aCategories[$id] = $cat['name'];
					if ( $pcat == $cat['name'] ) {
						$pcat = intval($id);
					}
				}
			}
		};

		if ( !is_numeric($pcat) ) {
			$pcat = 0;
		}

		if ( empty($pyear) ) {
			$pyear = date('Y');
		}

		if ( empty($pmonth) ) {
			$pmonth = date('m');
		}

		#$rows = $this->mStats->userEdits(1);
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"user"			=> $wgUser,
			"cityId"		=> $this->mCityId,
			"wgContLang" 	=> $wgContLang,
			"wgLang"		=> $wgLang,
        	"topLanguages"	=> $aTopLanguages,
        	"aLanguages"	=> $aLanguages,
        	"categories"	=> $aCategories,
        	"pyear"			=> $pyear,
        	"pmonth"		=> $pmonth,
        	"plang"			=> ( !empty($plang) ) ? $plang : $wgLang->getCode(),
        	"pcat"			=> $pcat
		) );
		$wgOut->addHTML( $oTmpl->render("wiki_activity") );
		wfProfileOut( __METHOD__ );
	}

	private function showNamespaces() {
        global $wgUser, $wgContLang, $wgLang, $wgOut;
		#---
		$selectedNamespace = array();
		if ( isset($this->mNS) && isset($this->mNamespaces) && isset($this->mPredefinedNamespaces) ) {
			foreach ( $this->mNS as $ns ) {
				$selectedNamespace[$ns] = @$this->mNamespaces[$ns];
				if ( empty($selectedNamespace[$ns]) ) {
					$selectedNamespace[$ns] = @$this->mPredefinedNamespaces[$ns]['name'];
				}
			}
		}

		$this->mStats->setPageNS($this->mNS);

		if ( empty($this->mXLS) ) {
			wfProfileIn( __METHOD__ );
			$menu = $this->showMenu('', 1);
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"data"			=> $this->mStats->namespaceStatsFromDB(),
				"today" 		=> date("Ym"),
				"today_day"     => $this->mStats->getLatestNSStats(),
				"user"			=> $wgUser,
				"cityId"		=> $this->mCityId,
				"wgContLang" 	=> $wgContLang,
				"wgLang"		=> $wgLang,
				"mStats"		=> $this->mStats,
				"userIsSpecial" => $this->userIsSpecial,
				"tableTitle"	=> $selectedNamespace
			) );
			$wgOut->addHTML( $menu );
			if  ( $this->mFromDate <= $this->mToDate ) {
				$wgOut->addHTML( $oTmpl->render("ns-table-stats") );
			}
			wfProfileOut( __METHOD__ );
		} else {
			$data = $this->mStats->namespaceStatsFromDB();
			$XLSObj = new WikiStatsXLS( $this->mStats, $data, wfMsg('wikistats_ns_statistics_legend'));
			$XLSObj->makeNamespaceStats($selectedNamespace);
		}
        #---
        return 1;
	}

	private function showCurrent() {
        wfProfileIn( __METHOD__ );
        echo __METHOD__ ;
        wfProfileOut( __METHOD__ );
	}

	private function showCompare() {
        wfProfileIn( __METHOD__ );
        echo __METHOD__ ;
        wfProfileOut( __METHOD__ );
	}
}
