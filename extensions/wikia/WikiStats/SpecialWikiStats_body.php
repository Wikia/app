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
    var $mXLS;
    var $mAllWikis;
	   
	private $allowedGroups = array('staff', 'sysop', 'janitor', 'bureaucrat');
	private $TEST = 1;
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
        
		$this->mUser = $wgUser;
		$this->mUserRights 	= $this->mUser->getGroups(); 
		$this->mFromDate 	= intval($wgRequest->getVal( "from", sprintf("%d%d", WIKISTATS_MIN_STATS_YEAR, WIKISTATS_MIN_STATS_MONTH) ));
		$this->mToDate 		= intval($wgRequest->getVal( "to", sprintf("%d%d", date("Y"), date("m") ) ));
		$this->mTitle 		= Title::makeTitle( NS_SPECIAL, "WikiStats" );
		$this->mAction		= $wgRequest->getVal("action", "");
		$this->mLang 		= $wgRequest->getVal("lang", "");
		$this->mHub 		= $wgRequest->getVal("hub", "");
		$this->mXLS 		= $wgRequest->getVal("css", false);
		$this->mCityId 		= ($this->TEST == 1 ) ? 177 : $wgCityId;
		$this->mCityDBName 	= ($this->TEST == 1 ) ? WikiFactory::IDtoDB($this->mCityId) : $wgDBname;
		$this->mAllWikis 	= 0;
		
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

		$domain = $wgRequest->getVal( "ws-domain", "" );
		if ( $domain == 'all' ) {
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
		#---
		if ( $subpage ) { 
			$path = explode("/", $subpage) ;
			$cnt = count($path);
			if ( $cnt > 1 && $this->userIsSpecial && is_numeric($path[0]) ) {
				$this->mCityId = $path[0];
			} 
			$this->mAction = $path[1];
		} 
		
		if ( $this->mAction ) {
			$wgOut->setArticleBodyOnly(true);
			$func = sprintf("show%s", ucfirst(strtolower($this->mAction)));
			$this->$func();
		} else {
			$this->setHeaders();
			$this->showForm();
		}
    }
    
	function showForm ($error = "") {
		global $wgOut, $wgContLang, $wgExtensionsPath, $wgStyleVersion, $wgJsMimeType, $wgStylePath ;
        wfProfileIn( __METHOD__ );

		# css
		$wgOut->addScript("<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgExtensionsPath}/wikia/WikiStats/css/jquery.tabs.css?{$wgStyleVersion}\" />\n");
		$wgOut->addScript("<!--[if lte IE 7]><link rel=\"stylesheet\" href=\"{$wgExtensionsPath}/wikia/WikiStats/css/jquery.tabs-ie.css?{$wgStyleVersion}\" type=\"text/css\"><![endif]-->");
		$wgOut->addScript("<link rel=\"stylesheet\" type=\"text/css\" href=\"{$wgExtensionsPath}/wikia/WikiStats/css/wikistats.css?{$wgStyleVersion}\" />\n");

		# script
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiStats/js/visualize.jQuery.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/WikiStats/js/jquery.tabs.min.js?{$wgStyleVersion}\"></script>\n");
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
        	"oUser"				=> $this->mUser
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
		$aCategories = $hubs->getCategories();

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
			"mAllWikis"			=> $this->mAllWikis
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
