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
    var $mTab;
    var $mUser;
    var $mUserRights;
    var $mSkin;
    var $mCityId;
    var $mCityDBName;
    var $mCityDomain;
    var $mLang;
    var $mHub;
    var $mAction;
    var $mActiveTab;
    var $mXLS;
    var $mAllWikis;
    var $mMonth;
    var $mLimit;
	   
	private $allowedGroups = array('staff', 'sysop', 'janitor', 'bureaucrat');
	private $TEST = 1;
	private $defaultAction = 'main';
    const USE_MEMC = 0;

    #--- constructor
    public function __construct() {
        parent::__construct( "WikiStats", "",  true/*class*/);
        if ( method_exists( 'SpecialPage', 'setGroup' ) ) { 
			parent::setGroup( 'WikiStats', 'wiki' );	
		}
    }

    public function execute( $subpage ) {
        global $wgUser, $wgOut, $wgRequest, $wgCityId, $wgDBname;

		wfLoadExtensionMessages("WikiStats");

        if ( $wgUser->isBlocked() ) {
            $wgOut->blockedPage();
            return;
        }
        
        if ( wfReadOnly() ) {
            $wgOut->readOnlyPage();
            return;
        }
        
        error_log ( print_r($wgRequest, true) );
        
		$this->mUser = $wgUser;
		$this->mUserRights 	= $this->mUser->getGroups(); 
		$this->mFromDate 	= intval($wgRequest->getVal( "wsfrom", sprintf("%d%d", WIKISTATS_MIN_STATS_YEAR, WIKISTATS_MIN_STATS_MONTH) ));
		$this->mToDate 		= intval($wgRequest->getVal( "wsto", sprintf("%d%d", date("Y"), date("m") ) ));
		$this->mTitle 		= Title::makeTitle( NS_SPECIAL, "WikiStats" );
		$this->mAction		= $wgRequest->getVal("action", "");
		$this->mLang 		= $wgRequest->getVal("wslang", "");
		$this->mHub 		= $wgRequest->getVal("wshub", "");
		$this->mXLS 		= $wgRequest->getVal("wsxls", false);
		$this->mCityId 		= ($this->TEST == 1 ) ? 177 : $wgCityId;
		$this->mCityDBName 	= ($this->TEST == 1 ) ? WikiFactory::IDtoDB($this->mCityId) : $wgDBname;
		$this->mMonth 		= $wgRequest->getVal("wsmonth", 0);
		$this->mLimit		= $wgRequest->getVal("wslimit", WIKISTATS_WIKIANS_RANK_NBR);		
		$this->mAllWikis 	= 0;
		
		#---
		if ( $subpage ) { 
			$path = explode("/", $subpage) ;
			$this->mAction = $path[0];
		}

		if ( empty($this->mAction) ) {
			$wgOut->redirect( $this->mTitle->getFullURL("action={$this->defaultAction}") );
		}
				
		$m = array();
		$this->toYear = date('Y');
		$this->toMonth = date('m');
		$this->fromYear = WIKISTATS_MIN_STATS_YEAR;
		$this->fromMonth = WIKISTATS_MIN_STATS_MONTH;
		
		if ( preg_match("/^([0-9]{4})([0-9]{1,2})/", $this->mFromDate, $m) ) {
			list (, $this->fromYear, $this->fromMonth) = $m; 
		}

		if ( preg_match("/^([0-9]{4})([0-9]{1,2})/", $this->mToDate, $m) ) {
			list (, $this->toYear, $this->toMonth) = $m; 
		}

       	$t = intval( $wgRequest->getVal("table") );
		$this->userIsSpecial = 0;
		foreach ( $this->mUserRights as $id => $right ) {
			if ( in_array( $right, $this->allowedGroups ) ) {
				$this->userIsSpecial = 1; 
				break;
			}
		}

		$domain = $wgRequest->getVal( "wiki", "" );
		$all = $wgRequest->getVal( "wsall", 0 );
		
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

        #--- WikiaGenericStats instance
        $this->mStats = WikiStats::newFromId($this->mCityId);
        $this->mStats->setStatsDate( array( 
        	'fromMonth' => $this->fromMonth,
        	'fromYear' 	=> $this->fromYear,
        	'toMonth'	=> $this->toMonth,
        	'toYear'	=> $this->toYear
        ));
        
        $this->mStats->setHub($this->mHub);
        $this->mStats->setLang($this->mLang);
        
        #---
        $this->mSkin = $wgUser->getSkin();
        if ( is_object ($this->mSkin) ) {
            $skinname = get_class( $this->mSkin );
            $skinname = strtolower(str_replace("Skin","", $skinname));
            $this->mSkinName = $skinname;
        }

		$ajax = $wgRequest->getVal( "ajax", 0 );

		$this->setHeaders();
		$this->showForm();	
		
		if ( $this->mAction ) {
			$func = sprintf("show%s", ucfirst(strtolower($this->mAction)));
			$this->$func();
		} 
    }
    
	function showForm ($error = "") {
		global $wgOut, $wgContLang, $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType, $wgStylePath ;
        wfProfileIn( __METHOD__ );

		# css
		#$wgOut->addScript("<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgExtensionsPath}/wikia/WikiStats/css/jquery.tabs.css?{$wgStyleVersion}\" />\n");
		#$wgOut->addScript("<!--[if lte IE 7]><link rel=\"stylesheet\" href=\"{$wgExtensionsPath}/wikia/WikiStats/css/jquery.tabs-ie.css?{$wgStyleVersion}\" type=\"text/css\"><![endif]-->");
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/WikiStats/css/wikistats.css?{$wgStyleVersion}");
		$wgOut->addExtensionStyle("{$wgStylePath}/common/wikia_ui/tabs.css?{$wgStyleVersion}");

		# script
		#$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiStats/js/visualize.jQuery.js?{$wgStyleVersion}\"></script>\n");
		#$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiStats/js/jquery.tabs.min.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiStats/js/wikistats.js?{$wgStyleVersion}\"></script>\n");

		# main page
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

		$wgOut->setSubtitle( $oTmpl->execute("subtitle") );

        $oTmpl->set_vars( array(
        	"mTitle"			=> $this->mTitle,
        	"wgContLang"		=> $wgContLang,
        	"wgExtensionsPath" 	=> $wgExtensionsPath, 
        	"wgStylePath"		=> $wgStylePath,
        	"wgCityId"			=> $this->mCityId,
        	"oUser"				=> $this->mUser,
        	"mAction"			=> $this->mAction,

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
        $wgOut->addHTML( $oTmpl->execute("main-form") );
        
        wfProfileOut( __METHOD__ );
        return 1;
	}
	
	private function showMenu() {
		global $wgOut;
        wfProfileIn( __METHOD__ );

		$aTopLanguages = explode(',', wfMsg('wikistats_language_toplist'));
		$aLanguages = wfGetFixedLanguageNames();
		asort($aLanguages);
		#-
		$hubs = WikiFactoryHub::getInstance();
		$_cats = $hubs->getCategories();
		$aCategories = array();
		if ( !empty($_cats) ) {
			foreach ( $_cats as $id => $cat ) {
				$aCategories[$id] = $cat['name'];
			}
		};

		# main page
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
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
        ));
        $res = $oTmpl->execute("select");

        wfProfileOut( __METHOD__ );
        return $res;
	}
	
	private function showMain() {
        global $wgUser, $wgContLang, $wgLang, $wgStatsExcludedNonSpecialGroup, $wgOut;
		#---
		if ( empty($this->mXLS) ) {
			wfProfileIn( __METHOD__ );
			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"data"			=> $this->mStats->loadStatsFromDB(),
				"today" 		=> date("Ym"),
				"today_day"     => time(),
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
			$wgOut->addHTML( $this->mStats->getBasicInformation() );
			$wgOut->addHTML( $oTmpl->execute("main-table-stats") ); 
			
			$oTmpl->set_vars( array(
				"columns" 		=> $this->mStats->getRangeColumns(),
				"userIsSpecial"	=> $this->userIsSpecial,
				"wgStatsExcludedNonSpecialGroup" => $wgStatsExcludedNonSpecialGroup
			));
			$wgOut->addHTML( $oTmpl->execute("main-stats-definitions") );
			wfProfileOut( __METHOD__ );
		} else {
			$data = $this->mStats->loadStatsFromDB();
			$columns = $this->mStats->getRangeColumns();
			$XLSObj = new WikiStatsXLS( $this->mStats, $data, wfMsg('wikistats_filename_mainstats', $this->mCityDBName));
			$XLSObj->makeMainStats($columns);
		}
        #---
        return 1; 
	}
	
	private function showBreakdown() {
		$this->__showBreakdown(0);
        return 1; 
	}
	
	private function showAnonbreakdown() {
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
			$wgOut->addHTML( $oTmpl->execute("activity") ); 
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
	
	private function showLatestview() {
		global $wgUser, $wgContLang, $wgLang, $wgOut;
		
		wfProfileIn( __METHOD__ );
		$rows = $this->mStats->latestViewPages();
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"user"			=> $wgUser,
			"cityId"		=> $this->mCityId,
			"wgContLang" 	=> $wgContLang,
			"wgLang"		=> $wgLang,
			"data"			=> $rows,
		) );
		$wgOut->addHTML( $oTmpl->execute("latestview") ); 
		wfProfileOut( __METHOD__ );
	}
	
	private function showUserview() {
		global $wgUser, $wgContLang, $wgLang, $wgOut;
		
		wfProfileIn( __METHOD__ );
		$rows = $this->mStats->userViewPages(1);
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"user"			=> $wgUser,
			"cityId"		=> $this->mCityId,
			"wgContLang" 	=> $wgContLang,
			"wgLang"		=> $wgLang,
			"data"			=> $rows,
		) );
		$wgOut->addHTML( $oTmpl->execute("user_activity") ); 
		wfProfileOut( __METHOD__ );
	}
		
	private function showMonth() {
        wfProfileIn( __METHOD__ );
        echo __METHOD__ ;
        wfProfileOut( __METHOD__ );
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

?>
