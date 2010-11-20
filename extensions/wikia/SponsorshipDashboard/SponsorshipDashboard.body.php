<?php
/**
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Jakub Kurcek
 *
 */

class SponsorshipDashboard extends SpecialPage {

	var $mStats;
	var $mUser;
	var $mUserRights;
	var $mSkin;
	var $mCityId;
	var $mCityDBName;
	var $mCityDomain;
	var $mLang;
	var $mHub;
	var $mActiveTab;
	var $mXLS;
	var $mAllWikis;
	var $mMonth;
	var $mLimit;

	private $allowedSubpages = array('main', 'error');
	// private $allowedGroups = array('staff', 'sysop', 'janitor', 'bureaucrat');
	// private $TEST = 0;

	function  __construct() {


		global $wgUser;

		$listed = ( in_array('staff', $wgUser->getEffectiveGroups()) );

		parent::__construct( "SponsorshipDashboard" , '', $listed /*restriction*/);
		wfLoadExtensionMessages("SponsorshipDashboard");
	}

	function execute( $subpage = 'main' ) {

		global $wgSupressPageSubtitle, $wgUser;

		$wgSupressPageSubtitle = true;

		if ( in_array('staff', $wgUser->getEffectiveGroups()) ){
			if ( in_array( $subpage, $this->allowedSubpages ) ){
				$function = 'HTML'.$subpage;
				$this->$function();
			} else {
				$this->HTMLmain();
			}
		} else {
			$this->HTMLerror();
		}
	}

	/**
	 * HTMLgapi - displays Google Api subpage - not used.
	 */

	private function HTMLgapi(){

		global $wgHTTPProxy, $wgWikiaGAPassword, $wgWikiaGALogin;

		$ga = new gapi($wgWikiaGALogin, $wgWikiaGAPassword, null, 'curl', $wgHTTPProxy);
		$ga->requestAccountData();
		foreach($ga->getResults() as $result)
		{
			echo $result . ' (' . $result->getProfileId() . ")<br />";
		}
	}

	/**
	 * HTMLmain - displays main subpage.
	 */

	private function HTMLmain(){

		global $wgOut, $wgJsMimeType, $wgStyleVersion, $wgHTTPProxy;

		wfProfileIn( __METHOD__ );

		$fromWikiStats = $this->loadDataFromWikiStats();
		$tagPosition = $this->loadTagPosition();

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(
			array(
				"datasets"		=> $fromWikiStats['serie'],
				"ticks"			=> $fromWikiStats['ticks'],
				"tagPosition"		=> $tagPosition
			)
		);

		$wgOut->addStyle( wfGetSassUrl( 'extensions/wikia/SponsorshipDashboard/css/SponsorshipDashboard.scss' ) );
		$wgOut->addScript("<!--[if IE]><script type=\"{$wgJsMimeType}\" src=\"/skins/common/jquery/excanvas.min.js?{$wgStyleVersion}\"></script><![endif]-->\n");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"/skins/common/jquery/jquery.flot.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"/skins/common/jquery/jquery.flot.selection.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addHTML( $oTmpl->execute( "chart" ) );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * HTMLerror - displays error subpage.
	 */

	private function HTMLerror(){

		global $wgOut;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$wgOut->addHTML( $oTmpl->execute( "error" ) );

	}

	/**
	 * loadTagPosition - loads data from WikiFactory.
	 * @return array
	 */

	private function loadTagPosition(){

		global $wgTitle, $wgCityId, $wgHubsPages, $wgStatsDB;

		// Cache check
		$cachedData = $this->getFromCache( 'rankingByHub' );
		if ( !empty($cachedData) ){
			return $cachedData;
		}

		$popularCityHubs = $this->getPopularHubs();
		if ( empty( $popularCityHubs ) ){
			return false;
		}

		// checkes for number of views of current cityId
		$dbr = wfGetDB( DB_SLAVE, array(), $wgStatsDB );
		$oRes = $dbr->select(
			array( 'page_views_tags' ),
			array( 'pv_views' ),
			array(
			    'city_id' => $wgCityId,
			    'use_date' => date( "Ymd", time()-86400 ),
			    'namespace' => NS_MAIN
			),
			__METHOD__,
			array()
		);
		$currentCityViews = 0;
		while( $oRow = $dbr->fetchObject( $oRes ) ) {
			$currentCityViews = $oRow->pv_views;
		}

		// gathers all cities with higher pageview and in current city hubs
		// using yesterdays data to be sure we have complete daily view

		$tmpArray = $this->getDailyHigherPageViewsForHubs( $currentCityViews, date( "Ymd", time()-86400 ), $popularCityHubs );

		// sorts data into hub lists
		if ( empty( $tmpArray ) ){
			return false;
		}

		$aPosition = array();
		foreach( $tmpArray as $key=>$val ){
			$aPosition[$key]['position'] = count( $tmpArray[$key] ) + 1;
			$aPosition[$key]['name'] = $cityTags[$key];
		}
		if ( !empty( $aPosition ) ){
			$this->saveToCache( 'rankingByHub', $aPosition );
		}
		return $aPosition;
	}

	/**
	 * getDailyHigherPageViewsForHubs - returns an array with current wikia position in specific hubs ( by page views ).
	 * @param $currentCityViews int
	 * @param $date string date in Ymd format
	 * @param $popularCityHubs array
	 * @return array
	 */

	private function getDailyHigherPageViewsForHubs( $currentCityViews, $date, $popularCityHubs ){

		if ( empty( $popularCityHubs ) || empty( $currentCityViews ) ){
			return array();
		}

		global $wgStatsDB;
		$dbr = wfGetDB( DB_SLAVE, array(), $wgStatsDB );
		$oRes = $dbr->select(
			array( 'page_views_tags' ),
			array( 'city_id, tag_id' ),
			array(
			    'use_date' => $date,
			    'pv_views > '.$currentCityViews,
			    'namespace' => NS_MAIN,
			    "tag_id IN (".implode(',', $popularCityHubs).")"
			),
			__METHOD__,
			array()
		);

		$tmpArray = array();
		while( $oRow = $dbr->fetchObject( $oRes ) ) {
			$tmpArray[$oRow->tag_id][] = $oRow->city_id;
		}

		return $tmpArray;
	}

	/**
	 * getPopularHubs - gets cityId tags and compares them with HubsPages.
	 * @return array
	 */

	private function getPopularHubs(){

		global $wgHubsPages, $wgCityId;

		$wikiFactoryTags = new WikiFactoryTags($wgCityId);
		$cityTags = $wikiFactoryTags->getTags();
		if ( empty($cityTags) ){
			return array();
		}
		$popularCityHubs = array();
		foreach( $wgHubsPages['en'] as $hubs_key=>$hubsPages ){
			foreach( $cityTags as $key => $val ){
				if ( $hubsPages == $val ){
					$popularCityHubs[$val] = $key;
				}
			}
		}

		return $popularCityHubs;
	}

	/**
	 * loadDataFromWikiStats - loads data from WikiFactory.
	 * @return array
	 */

	private function loadDataFromWikiStats(){

		global $wgUser, $wgLang, $wgOut, $wgEnableBlogArticles, $wgJsMimeType, $wgExtensionsPath, $wgHubsPages, $wgStyleVersion, $wgRequest, $wgAllowRealName;
		global $wgCityId, $wgDBname;

		// Cache check
		// Cache disabled for this element for now
		//
		// $cachedData = $this->getFromCache( 'WikiStats' );
		// if ( !empty($cachedData) ){
		// 	return $cachedData;
		// }

		$this->mUser = $wgUser;
		$this->mUserRights = $this->mUser->getEffectiveGroups();
		$this->userIsSpecial = 0;

		$date = $this->get_previous_month();

		$this->mTitle 		= Title::makeTitle( NS_SPECIAL, "WikiStats" );
		$this->mCityId 		= $wgCityId;
		$this->mCityDBName 	= $wgDBname;

		$this->toYear = date('Y', $date);
		$this->toMonth = date('m', $date);
		$this->fromYear = WIKISTATS_MIN_STATS_YEAR;
		$this->fromMonth = WIKISTATS_MIN_STATS_MONTH;

		$this->mCityDomain = WikiFactory::DBToDomain($this->mCityDBName);

		#--- WikiaGenericStats instance
		$this->mStats = WikiStats::newFromId($this->mCityId);

		$this->mStats->setStatsDate( array(
			'fromMonth'	=> $this->fromMonth,
			'fromYear' 	=> $this->fromYear,
			'toMonth'	=> $this->toMonth,
			'toYear'	=> $this->toYear
		));

		$this->mStats->setHub("");
		$this->mStats->setLang("");

		// returns data from the point it begun
		$aData = $this->mStats->loadStatsFromDB();
		$outData = $aData;
		foreach( $aData as $key=>$row ){
			$terminate = true;
			foreach( $row as $key2=>$val ){
				if ( $key2 != 'date' ){
					$terminate = ( empty( $val ) && $terminate );
				}
			}
			if ( !$terminate ){
				break;
			} else {
				unset($outData[$key]);
			}
		}

		$outData = $this->prepareToDisplay( $outData );

		// $this->saveToCache( 'WikiStats', $outData );
		return $outData;
	}

	/**
	 * createJSobj - creates JS object on array basis.
	 * @param $aArray array
	 * @return string
	 */

	private function createJSobj( $aArray ){

		$result = '{ ';
		$first = true;
		foreach( $aArray as $key=>$val ){
			if ( $first ){
				$first = false;
			} else {
				$result = $result.', ';
			}
			$result = $result." ".$key.": ".$val;
		}
		$result = $result.'}';
		return $result;
	}

	/**
	 * createSerie - loads data from WikiFactory.
	 * @param $sLabel string
	 * @param $aData array
	 * @return string
	 */

	private function createSerie( $sLabel, $aData ){

		return "{label:'".$sLabel."', data: [".implode( ', ',array_filter( $aData, array("self", "filter") ) )."]}";
	}

	/**
	 * prepareToDisplay - returns data ready to be displayed in template
	 * @param $data array
	 * @return array
	 */

	private function prepareToDisplay( $data ){

		$i = 0;
		foreach(array_reverse($data) as $collumns){
			$result['data'][$i] = "[{$i}, {$collumns['A']}]";
			$result1['data'][$i] = "[{$i}, {$collumns['B']}]";
			$result2['data'][$i] = "[{$i}, ".($collumns['B'] - $collumns['C'] - $collumns['D'])."]";
			$result3['data'][$i] = "[{$i}, {$collumns['C']}]";
			$result4['data'][$i] = "[{$i}, {$collumns['D']}]";
			$result5['data'][$i] = "[{$i}, {$collumns['E']}]";
			$result6['data'][$i] = "[{$i}, {$collumns['F']}]";
			$result7['data'][$i] = "[{$i}, {$collumns['G']}]";
			$result8['data'][$i] = "[{$i}, {$collumns['H']}]";
			$result9['data'][$i] = "[{$i}, {$collumns['I']}]";
			$result10['data'][$i] = "[{$i}, {$collumns['J']}]";
			$result11['data'][$i] = "[{$i}, {$collumns['K']}]";
			if ( ( $i % ceil((count($data) / 11)) ) == 0 ){
				$result['date'][$i] = "[{$i}, '{$collumns['date']}']";
			}
			$i++;
		};

		$aSerie = array(
			'A' => $this->createSerie( wfMsg('serie-1'), $result['data']),
			'B' => $this->createSerie( wfMsg('serie-2'), $result1['data']),
			'C' => $this->createSerie( wfMsg('serie-3'), $result2['data']),
			'D' => $this->createSerie( wfMsg('serie-4'), $result3['data']),
			'E' => $this->createSerie( wfMsg('serie-5'), $result4['data']),
			'F' => $this->createSerie( wfMsg('serie-6'), $result5['data']),
			'G' => $this->createSerie( wfMsg('serie-7'), $result6['data']),
			'H' => $this->createSerie( wfMsg('serie-8'), $result7['data']),
			'I' => $this->createSerie( wfMsg('serie-9'), $result8['data']),
			'J' => $this->createSerie( wfMsg('serie-10'), $result9['data']),
			'K' => $this->createSerie( wfMsg('serie-11'), $result10['data']),
			'L' => $this->createSerie( wfMsg('serie-12'), $result11['data'])
		);
		$sSerie = $this->createJSobj($aSerie);

		$ticks = "[".implode(', ',$result['date'])."]";
		return array( 'serie' => $sSerie, 'ticks' => $ticks );
	}

	/**
	 * @author Jakub Kurcek
	 * @param hubId integer
	 * @param content array
	 *
	 * Caching functions.
	 */
	private function getKey( $prefix ) {

		global $wgCityId;
		return wfSharedMemcKey( 'SponsoredDashboard', $prefix, $wgCityId );
	}

	private function saveToCache( $prefix, $content ) {

		global $wgMemc;
		$memcData = $this->getFromCache( $prefix );
		if ( $memcData == null ){
			$wgMemc->set( $this->getKey( $prefix ), $content, 60*60*12);
			return false;
		}
		return true;
	}

	private function getFromCache ( $prefix ){

		global $wgMemc;
		return $wgMemc->get( $this->getKey( $prefix ) );
	}

	private function clearCache ( $prefix ){

		global $wgMemc;
		return $wgMemc->delete( $this->getKey( $prefix ) );
	}


	// other methods

	private function get_previous_month( $date = false ) {

		if ( empty( $date ) ){
			$date = time();
		}
		$year = date( "Y", time() );
		$month = date( "n", time() ) - 1;
		if ( $month == 0) {
			$month = 12;
			$year = $year - 1;
		}
		return mktime( 0, 0, 0, $month, 1, $year );
	}

	private function filter( $var ){
		return(( $var%5 ) == 0);
	}


}



