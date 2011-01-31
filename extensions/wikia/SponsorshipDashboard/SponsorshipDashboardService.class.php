<?php

/**
 * Category service
 * @author Jakub Kurcek
 */
class SponsorshipDashboardService extends Service {

	const SD_RETURNPARAM_TICKS = 'ticks';
	const SD_RETURNPARAM_FULL_TICKS = 'fullTicks';
	const SD_RETURNPARAM_SERIE = 'serie';
	const SD_GAPI_RETRIES = 4;

	var $mStats;
	var $aCityHubs;
	var $iNumberOfXGuideLines = 7;
	var $fromYear = 2001;

	public function getFromYear(){
		return $this->fromYear;
	}

	public function loadInterestsData( $hubId = array() ){

		global $wgStatsDB;
		$wgCityId = WF::build( 'App' )->getGlobal( 'wgCityId' );

		$this->fromYear = 2001;

		// loads current city id popular hubs
		$this->getPopularHubs();
		if ( empty( $this->aCityHubs ) ){
			return false;
		}
		
		// if no asked hub or asked for wrong hub, proceeds with first hub from the list
		if ( isset( $hubId['name'] ) && isset( $this->aCityHubs[ $hubId[ 'name' ] ] ) ){
			$currentHub = $hubId[ 'id' ];
		} else {
			$aKeys = array_keys( $this->aCityHubs );
			$currentHub = $this->aCityHubs[ $aKeys[ 0 ] ];
		}

		// loads cache data
		$cachedData = $this->getFromCache( 'RelatedWikiaStats:'.$currentHub );
		if ( !empty($cachedData) ){
			return $cachedData;
		}
		
		$currentYearWeek = date('YW');
		
		// loads current city id current week unique users
		$dbr = wfGetDB( DB_SLAVE, array(), $wgStatsDB );
		$sql = "SELECT t1.pv_week, count(t1.pv_user_id) AS cityuniqueusers
			FROM page_views_weekly_user AS t1
			WHERE t1.pv_city_id = {$wgCityId}
			GROUP BY pv_week";
		$res = $dbr->query( $sql, __METHOD__ );
		
		while ( $row = $res->fetchObject( $res ) ) {
			$rowDate = date("Y-m-d", strtotime("1.1.".substr( $row->pv_week, 0, 4 )." + ".substr( $row->pv_week, 4, 2 )." weeks"));
			$cityUniqueUsers[ $rowDate ] = intval( $row->cityuniqueusers );
		}

		// loads top 10 related
		$dbr = wfGetDB( DB_SLAVE, array(), $wgStatsDB );
		$sql = "SELECT t2.pv_city_id as cityId, ctm.tag_id, cl.city_title, t1.pv_week as week, count(t2.pv_user_id) AS citycommonusers
			FROM page_views_weekly_user AS t1
			INNER JOIN page_views_weekly_user AS t2
				ON (t1.pv_user_id = t2.pv_user_id
				AND t2.pv_city_id != t1.pv_city_id)
				AND t1.pv_week = t2.pv_week
			JOIN wikicities.city_list AS cl
				ON t2.pv_city_id = cl.city_id
			INNER JOIN wikicities.city_tag_map AS ctm
				ON ctm.city_id = t2.pv_city_id AND ctm.tag_id = {$currentHub}
			WHERE t1.pv_city_id = {$wgCityId} AND t1.pv_week != {$currentYearWeek}
			GROUP BY t2.pv_city_id, t1.pv_week
			ORDER BY week DESC, citycommonusers DESC";

		$res = $dbr->query( $sql, __METHOD__ );
		$all = array();
		$titles = array();
		$heckValue = array();
		$weeks = array();

		while ($row = $res->fetchObject($res)) {
			
			$rowDate = date("Y-m-d", strtotime("1.1.".substr( $row->week, 0, 4 )." + ".substr( $row->week, 4, 2 )." weeks"));

			if ( ( count( $titles ) < 10 ) || ( in_array( $row->city_title, $titles ) ) ){
				if (	isset( $cityUniqueUsers[ $rowDate ] ) &&
					!empty( $cityUniqueUsers[ $rowDate ] ) &&
					( ( !isset( $all[ $rowDate ] ) ) || ( count( $all[ $rowDate ] ) <= 10 ) )
				){
					$familiarity = round( ( $row->citycommonusers / $cityUniqueUsers[ $rowDate ] * 100 ) , 2 );

					if ( !isset( $heckValue[ $row->cityId ] ) ) $heckValue[ $row->cityId ] = false;
					$heckValue[ $row->cityId ] = ( $heckValue[ $row->cityId ] || ( $familiarity > 5 ) );

					$all[ $rowDate ]['date'] = $rowDate;
					$all[ $rowDate ][ $row->cityId ] = $familiarity;
					$titles[ $row->cityId ] = $row->city_title;
					$weeks[] = $rowDate;
				}
			}
		}

		foreach ($heckValue as $key => $cleanup){
			if( !$cleanup ){
				foreach( $weeks as $week ){
					unset( $all[$week][$key] );
				}
			}
		}
		
		$returnData = $this->simplePrepareToDisplay( $all , $titles );
		$this->saveToCache( 'RelatedWikiaStats:'.$currentHub , $returnData );

		return $returnData;

	}

	/**
	 * loadTop10CompetitionData
	 * @param $hub integer
	 *
	 * @return array
	 */

	public function loadCompetitorsData( $hubId = array() ){

		global $wgStatsDB;

		$wgCityId = WF::build( 'App' )->getGlobal( 'wgCityId' );

		$this->fromYear = 2010;
		
		// loads current city id popular hubs
		$this->getPopularHubs();
		if ( empty( $this->aCityHubs ) ){
			return false;
		}

		// if no asked hub or asked for wrong hub, proceeds with first hub from the list
		if ( isset( $hubId['name'] ) && isset( $this->aCityHubs[ $hubId['name']] ) ){
			$currentHub = $hubId['id'];
		} else {
			$aKeys = array_keys( $this->aCityHubs );
			$currentHub = $this->aCityHubs[ $aKeys[0] ];
		}

		// loads cache data
		$cachedData = $this->getFromCache( 'CompetitorsData:Hub'.$currentHub );
		if ( !empty($cachedData) ){
			return $cachedData;
		}

		// never use current data. use data from last week.
		$currentYearWeek = date('YW');
		if ( (int)date('W') > 0 ){
			$currentYearWeek = $currentYearWeek - 1;
		} else {
			$currentYearWeek = $currentYearWeek - 49;
		}
		
		$dbr = wfGetDB( DB_SLAVE, array(), $wgStatsDB );

		// get common users for current wikia and TOP 10 others + current
		$sql = "SELECT cl.city_url as cityUrl, t2.pv_city_id as cityId, t1.pv_week as week, cl.city_title, count(t1.pv_user_id) AS citycommonusers
			FROM page_views_weekly_user AS t1
			INNER JOIN page_views_weekly_user AS t2
				ON t1.pv_user_id = t2.pv_user_id
				AND t1.pv_week = t2.pv_week
			JOIN wikicities.city_list AS cl
				ON t2.pv_city_id = cl.city_id
			INNER JOIN wikicities.city_tag_map AS ctm
				ON ctm.city_id = t2.pv_city_id AND ctm.tag_id = {$currentHub}
			WHERE t1.pv_city_id = {$wgCityId} AND t1.pv_week = {$currentYearWeek}
			GROUP BY t2.pv_city_id, t1.pv_week
			ORDER BY citycommonusers DESC
			LIMIT 11";

		$all = array();
		$titles = array();
		$cityVisits = 1;

		$res = $dbr->query( $sql, __METHOD__ );
		$all = array();
		$titles = array();
		$sortBy = array();

		while ( $row = $res->fetchObject( $res ) ) {

			//// sets $cityUniqueUsers for current city_id
			if ( !isset( $cityUniqueUsers )){
				$cityUniqueUsers = $row->citycommonusers;
			}
			
			// calculate familiarity
			$familiarity = round( $row->citycommonusers / $cityUniqueUsers * 100 , 2);
			$titles[ 'c'.$row->cityId ] = wfMsg('sponsorship-dashboard-cityname-and-familiarity', $row->city_title, $familiarity);;
			$sortBy[] =  $row->cityId;

			$GAresult = $this->getDailyCityPageviewsFromGA (
				$row->cityUrl,
				$row->cityId,
				'c',
				$currentHub,
				( empty( $all ) )
			);

			if ( empty( $GAresult ) ) {
				return false;
			}

			$all = array_merge_recursive (
				$all,
				$GAresult
				
			);
		}

		if ( empty( $titles ) ){
			Wikia::log( __METHOD__, false, wfMsg( 'sponsorship-dashboard-error-nodataforcurrentweek' ) );
		}

		$returnData = $this->simplePrepareToDisplay( $all, $titles , array( 'newVisits' ) );
		
		$this->saveToCache( 'CompetitorsData:Hub'.$currentHub , $returnData );
		
		return $returnData;

	}

	/**
	 * getMonthlyCityPageviewsFromGA - returns array with pageviews from current host
	 * @param $cityUrl string
	 * @param $cityId integer
	 * @param $prefix string
	 * @param $hubId integer
	 *
	 * @return array
	 */

	public function getDailyCityPageviewsFromGA( $cityUrl, $cityId, $prefix, $hubId, $generateDate ){

		// inner cache. Various city id can be asked from many places.
		$cachedData = $this->getFromCache( 'DailyCityPageviewsFromGA:Hub'.$hubId, $cityId );
		if ( !empty( $cachedData ) ){
			return $cachedData;
		}

		$this->fromYear = 2001;

		global $wgWikiaGALogin, $wgWikiaGAPassword, $wgHTTPProxy;

		$return = array();
		
		// #FB:1823 Retry Google API calls when quota is reached;
		$retries = self::SD_GAPI_RETRIES;
		$results = array();
				
		$ga = WF::build('gapi', array( $wgWikiaGALogin, $wgWikiaGAPassword, null, 'curl', $wgHTTPProxy ) );

		while ( ( $retries > 0 ) && empty( $results ) ){

			try {
				$ga->requestReportData(
					31330353,
					array( 'day', 'month', 'year' ),
					array( 'pageviews' ),
					array( '-year', '-month', '-day' ),
					'hostname=~^'.$this->prepareGAUrl( $cityUrl ),
					'2010-04-01',
					date( 'Y-m-d' ),
					1,
					360
				);
				$results = $ga->getResults();
				break;

			} catch ( Exception $e ) {

				$retries--;
				sleep( 1 );
				Wikia::log( __METHOD__, false, $e->getMessage() );
				
			}
		}

		if ( empty( $results ) ) {
			return false;
		}
		
		reset( $results );

		unset ( $results[ key( $results ) ] );

		$all = array();

		foreach( $results as $obj ) {
			$date = $obj->getYear().'-'.$obj->getMonth().'-'.$obj->getDay();
			if ( $generateDate ){
				$all[ $date ][ 'date' ] = $date;
			}
			$all[ $date ][ $prefix.$cityId ] = $obj->getPageviews();
		}

		$this->saveToCache( 'DailyCityPageviewsFromGA:Hub'.$hubId, $all, $cityId );

		return $all;

	}

	/**
	 * prepareGAUrl - converts URL to GA host filter
	 * @param $url string
	 *
	 * @return string
	 */

	protected function prepareGAUrl( $url ){

		global $wgDevEnvironment;

		$hostname = str_replace( 'http://', '', $url );
		$hostname = str_replace( '/', '', $hostname );
		$hostname = str_replace( '.', '\\.', $hostname );
		if ( $wgDevEnvironment ){
			$hostname = explode('\\', $hostname);
			$hostname = $hostname[0].'.wikia.com';
		}

		return $hostname;
	}
	
	public function loadTrafficData(){

		global $wgStatsDB, $wgWikiaGALogin, $wgWikiaGAPassword, $wgHTTPProxy, $wgDevEnvironment;

		$wgServer = WF::build('App')->getGlobal('wgServer');

		$this->fromYear = 2010;

		// Cache check
		$cachedData = $this->getFromCache( 'TrafficData' );
		if ( !empty($cachedData) ){
		 	return $cachedData;
		}

		$hostname = $this->prepareGAUrl( $wgServer );

		try {
			$ga = new gapi($wgWikiaGALogin, $wgWikiaGAPassword, null, 'curl', $wgHTTPProxy);

			$ga->requestReportData(
				31330353,
				array('day', 'month', 'year'),
				array('pageviews'),
				array('-year', '-month', '-day'),
				'hostname=~^'.$hostname,
				'2010-04-01',
				date('Y-m-d'),
				1,
				360
			);
		} catch ( Exception $e ) {

			Wikia::log(__METHOD__, false, $e->getMessage());
			return false;
		}

		$results = $ga->getResults();

		$all = array();
		$titles = array();
		reset( $results );
		unset ( $results[ key( $results ) ] );

		foreach( $results as $res ) {
			$date = $res->getYear().'-'.$res->getMonth().'-'.$res->getDay();
			$all[ $date ][ 'pageviews' ] = $res->getPageviews();
			$all[ $date ][ 'date' ] = $date;
		}

		$titles[ 'pageviews' ] = wfMsg('sponsorship-dashboard-serie-pageviews');

		$returnData = $this->simplePrepareToDisplay( $all , $titles , array( 'newVisits' ));

		$this->saveToCache( 'TrafficData' , $returnData );

		return $returnData;
	}
		
	/**
	 * simplePrepareToDisplay - prepares data to be easily printed in chart
	 * @param $data data array
	 * @param $labels labels array
	 * @param $aSecondYAxis array of series keys that will be conected with right Y-axis (%)
	 *
	 * @return array
	 */

	protected function simplePrepareToDisplay( $data, $labels, $aSecondYAxis = array() ){

		if ( empty( $data ) || empty( $labels ) ){
			return false;
		}

		$results = array();
		$i = 0;
		
		foreach( array_reverse( $data ) as $collumns ){
			foreach( $collumns as $key => $val ){
				if ( !in_array( $key, array('date') ) ){
					$results[$key][$i] = "[{$i}, {$val}]";
				}
			}
			if ( ( $i % ceil((count($data) / $this->iNumberOfXGuideLines )) ) == 0 ){
				$result['date'][$i] =
					"[{$i}, '{$collumns['date']}']";
			}
			$result['fullWikiaDate'][$collumns['date']] = "['{$collumns['date']}', {$i}]";
			$i++;
		};
		
		if ( empty( $results ) ){
			return false;
		}
		
		$aSerie = array();
		foreach ( $results as $key => $val ) {
			$aSerie[$key] =
				$this->createSerie(
					$labels[$key],
					$val,
					in_array( $key, $aSecondYAxis )
				);
		}

		$sSerie = $this->createJSobj( $aSerie );

		$ticks = "[".implode(', ',$result['date'])."]";
		$fullWikiaDate = "[".implode(', ',$result['fullWikiaDate'])."]";
		
		return array( 'serie' => $sSerie, self::SD_RETURNPARAM_TICKS => $ticks, self::SD_RETURNPARAM_FULL_TICKS => $fullWikiaDate );
	}

	/**
	 * loadDataFromWikiStats - loads data from WikiStats.
	 * @return array
	 */

	public function loadContentData(){

		global $wgUser, $wgLang, $wgOut, $wgEnableBlogArticles, $wgJsMimeType, $wgExtensionsPath, $wgHubsPages, $wgStyleVersion, $wgRequest, $wgAllowRealName;
		global $wgDBname;

		$wgCityId = WF::build( 'App' )->getGlobal( 'wgCityId' );

		// Cache check
		$cachedData = $this->getFromCache( 'ContentData' );
		if ( !empty($cachedData) ){
			return $cachedData;
		}

		$this->fromYear = 2001;

		// WikiaGenericStats instance
		$date = $this->get_previous_month();
		$this->mStats = WikiStats::newFromId( $wgCityId );
		$this->mStats->setStatsDate(
			array(
				'fromMonth'	=> WIKISTATS_MIN_STATS_MONTH,
				'fromYear' 	=> WIKISTATS_MIN_STATS_YEAR,
				'toMonth'	=> date('m', $date),
				'toYear'	=> date('Y', $date)
			)
		);

		$this->mStats->setHub("");
		$this->mStats->setLang("");
		
		// returns data from the point it begun
		$aData = $this->mStats->loadStatsFromDB();
		$aData = $this->pushArticleNumbersFromNamespace( $aData, 501, 'X' );
		$aData = $this->pushArticleNumbersFromNamespace( $aData, 700, 'Y' );
		
		$outData = $aData;
		foreach( $aData as $key => $row ){
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

		// ==
		$i = 0;
		
		foreach( array_reverse( $outData ) as $collumns ){

			$collumns['date'] = date("Y-m-d", strtotime("1.1.".substr( $collumns['date'], 0, 4 )." + ".substr( $collumns['date'], 4, 2 )." weeks"));

			$result1['data'][$i] = "[{$i}, {$collumns['C']}]";
			$result2['data'][$i] = "[{$i}, {$collumns['H']}]";
			$result3['data'][$i] = "[{$i}, {$collumns['I']}]";
			$result4['data'][$i] = "[{$i}, {$collumns['J']}]";
			$result5['data'][$i] = "[{$i}, {$collumns['K']}]";
			if ( isset($collumns['X']) ) $result12['data'][$i] = "[{$i}, {$collumns['X']}]";
			if ( isset($collumns['Y']) ) $result13['data'][$i] = "[{$i}, {$collumns['Y']}]";
			if ( ( $i % ceil((count($outData) / $this->iNumberOfXGuideLines )) ) == 0 ){
				$result['date'][$i] = "[{$i}, '{$collumns['date']}']";
			}
			$result['fullWikiaDate'][$collumns['date']] = "['{$collumns['date']}', {$i}]";
			$i++;
		};

		if (	!isset( $result1['data'] ) ||
			!isset( $result2['data'] ) || 
			!isset( $result3['data'] ) || 
			!isset( $result4['data'] ) ||
			!isset( $result5['data'] )
		){
			return false;
		}

		$aSerie = array(
			'A' => $this->createSerie( wfMsg('sponsorship-dashboard-serie-content-article'), $result1['data'] ),
			'B' => $this->createSerie( wfMsg('sponsorship-dashboard-serie-image-linked'), $result2['data'] ),
			'C' => $this->createSerie( wfMsg('sponsorship-dashboard-serie-image-uploaded'), $result3['data'] ),
			'D' => $this->createSerie( wfMsg('sponsorship-dashboard-serie-video-embeded'), $result4['data'] ),
			'E' => $this->createSerie( wfMsg('sponsorship-dashboard-serie-video-uploaded'), $result5['data'] )
		);
		if ( isset( $result12 ) ) $aSerie['X'] = $this->createSerie( wfMsg('sponsorship-dashboard-serie-toplists'), $result12['data'] );
		if ( isset( $result13 ) ) $aSerie['Y'] = $this->createSerie( wfMsg('sponsorship-dashboard-serie-blog-comments'), $result13['data'] );

		$sSerie = $this->createJSobj($aSerie);

		$ticks = "[".implode(', ',$result['date'])."]";
		$fullWikiaDate = "[".implode(', ',$result['fullWikiaDate'])."]";
		$outData = array( 'serie' => $sSerie, self::SD_RETURNPARAM_TICKS => $ticks, self::SD_RETURNPARAM_FULL_TICKS => $fullWikiaDate );

		// ==

		$this->saveToCache( 'ContentData', $outData );
		return $outData;
	}

	/**
	 * pushArticleNumbersFromNamespace - adds namespace articles to array.
	 * @param $aData	base data		array
	 * @param $iNamespace	namespace id		int
	 * @param $sKey		new key for data	string
	 * @return array
	 */

	protected function pushArticleNumbersFromNamespace( $aData, $iNamespace, $sKey){

		$this->mStats->mPageNS = array( $iNamespace );
		$this->mStats->mPageNSList = array( $iNamespace );

		$aDataNS = $this->mStats->namespaceStatsFromDB();
		if( !empty($aDataNS)){
			foreach( $aDataNS as $key => $val){
				if ( !isset( $aData[$key] ) ) $aData[$key] = array();
				$aData[$key][$sKey] =
					$val[$iNamespace]['A'];
			}
		}

		return $aData;
	}


	/**
	 * createJSobj - creates JS object on array basis.
	 * @param $aArray array
	 * @return string
	 */

	protected function createJSobj( $aArray ){

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

	protected function createSerie( $sLabel, $aData, $bSecondAxis = false ){

		return "{label:'".addslashes($sLabel)."', data: [".implode( ', ',array_filter( $aData, array("self", "filter") ) )."], yaxis: ".( ( $bSecondAxis ) ? 2 : 1 )." }";
	}

	/**
	 * @author Jakub Kurcek
	 *
	 * Caching functions.
	 */
	
	protected function getKey( $prefix, $cityId = false ) {

		if ( empty( $cityId ) ){
			$cityId = WF::build( 'App' )->getGlobal( 'wgCityId' );
		}
		return wfSharedMemcKey( 'SponsoredDashboard', $prefix, $cityId );
	}

	protected function saveToCache( $prefix, $content, $cityId = false ) {

		global $wgMemc;
		$memcData = $this->getFromCache( $prefix, $cityId );
		if ( empty( $memcDat ) ){
			$wgMemc->set( $this->getKey( $prefix, $cityId ), $content, 60*60*24);
			return false;
		}
		return true;
	}

	protected function getFromCache ( $prefix, $cityId = false ){

		global $wgMemc;
		return $wgMemc->get( $this->getKey( $prefix, $cityId ) );
	}

//	private function clearCache ( $prefix, $cityId = false ){
//
//		global $wgMemc;
//		return $wgMemc->delete( $this->getKey( $prefix, $cityId ) );
//	}

	// other methods

	protected function get_previous_month( $date = false ) {

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

	protected function filter( $var ){
		return( ( $var%5 ) == 0 );
	}

	/**
	 * getPopularHubs - gets cityId tags and compares them with HubsPages.
	 * @return array
	 */

	public function getPopularHubs(){

		global $wgHubsPages;

		$wgCityId = WF::build( 'App' )->getGlobal( 'wgCityId' );

		if ( !empty( $this->aCityHubs ) ){
			return $this->aCityHubs;
		}

		$wikiFactoryTags = new WikiFactoryTags( $wgCityId );
		$cityTags = $wikiFactoryTags->getTags();

		if ( empty( $cityTags ) ){
			Wikia::log( __METHOD__ , false, "City [{$wgCityId}] has no tags" );
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
		$this->aCityHubs = $popularCityHubs;
		return $popularCityHubs;
	}


// =============================

	public function loadParticipationData(){

		global $wgUser, $wgLang, $wgOut, $wgEnableBlogArticles, $wgJsMimeType, $wgExtensionsPath, $wgHubsPages, $wgStyleVersion, $wgRequest, $wgAllowRealName;
		global $wgCityId, $wgDBname;

		// Cache check
		$cachedData = $this->getFromCache( 'ParticipationData' );
		if ( !empty($cachedData) ){
			return $cachedData;
		}

		$this->fromYear = 2001;

		$aData = $this->loadWikiaGenericStats();
		$outData = $this->prepareWikiaGenericStats( $aData );
		
		// ===
		
		$i = 0;
		foreach( array_reverse($outData) as $collumns ){
			$collumns['date'] = substr($collumns['date'], 0,4).'-'.substr($collumns['date'], 4,2);
			$result['data'][$i] = "[{$i}, {$collumns['A']}]";
			$result1['data'][$i] = "[{$i}, {$collumns['B']}]";
			$result3['data'][$i] = "[{$i}, {$collumns['C']}]";
			$result4['data'][$i] = "[{$i}, {$collumns['D']}]";
			if ( ( $i % ceil((count($outData) / $this->iNumberOfXGuideLines )) ) == 0 ){
				$result['date'][$i] = "[{$i}, '{$collumns['date']}']";
			}
			$result['fullWikiaDate'][$collumns['date']] = "['{$collumns['date']}', {$i}]";
			$i++;
		};
		
		if (	!isset( $result['data'] ) ||
			!isset( $result1['data'] ) ||
			!isset( $result3['data'] ) ||
			!isset( $result4['data'] ) ) {
			return false;
		}


		$aSerie = array(
			'A' => $this->createSerie( wfMsg('sponsorship-dashboard-serie-general-edits'), $result['data'] ),
			'B' => $this->createSerie( wfMsg('sponsorship-dashboard-serie-article-edits-1'), $result1['data'] ),
			'C' => $this->createSerie( wfMsg('sponsorship-dashboard-serie-article-edits-5'), $result3['data'] ),
			'D' => $this->createSerie( wfMsg('sponsorship-dashboard-serie-article-edits-10'), $result4['data'] ),
			
		);
		
		$sSerie = $this->createJSobj($aSerie);

		$ticks = "[".implode(', ',$result['date'])."]";
		$fullWikiaDate = "[".implode(', ',$result['fullWikiaDate'])."]";

		$outData = array( 'serie' => $sSerie, self::SD_RETURNPARAM_TICKS => $ticks, self::SD_RETURNPARAM_FULL_TICKS => $fullWikiaDate );

		// ==

		$this->saveToCache( 'ParticipationData', $outData );
		return $outData;
	
	}

	public function loadEngagementData(){

		global $wgStatsDB, $wgWikiaGALogin, $wgWikiaGAPassword, $wgHTTPProxy, $wgDevEnvironment;

		$this->fromYear = 2010;
		$wgServer = WF::build('App')->getGlobal('wgServer');

		//// Cache check
		$cachedData = $this->getFromCache( 'EngagementData' );
		if ( !empty($cachedData) ){
		 	return $cachedData;
		}

		$hostname = $this->prepareGAUrl( $wgServer );

		$ga = new gapi($wgWikiaGALogin, $wgWikiaGAPassword, null, 'curl', $wgHTTPProxy);

		try {
			$ga->requestReportData(
				31330353,
				array('month', 'year'),
				array('timeOnSite', 'newVisits', 'visits'),
				array('-year', '-month'),
				'hostname=~^'.$hostname,
				'2010-04-01',
				date('Y-m-d'),
				1,
				360
			);
		} catch ( Exception $e ) {

			Wikia::log(__METHOD__, false, $e->getMessage());
			return false;
		}

		$results = $ga->getResults();

		$all = array();
		$titles = array();
		reset( $results );
		unset ( $results[ key( $results ) ] );

		foreach( $results as $res ) {
			$date = $res->getYear().'-'.$res->getMonth();
			$all[ $date ][ 'date' ] = $date;
			$visits = $res->getVisits();
			$all[ $date ][ 'timeOnSite' ] = round( $res->getTimeOnSite()/60/60 );
			$all[ $date ][ 'newVisitsTimeOnSite' ] = ( !empty( $visits ) ) ? round( $all[ $date ][ 'timeOnSite' ] * $res->getNewVisits() / $visits  ) : 0;
		}

		$titles[ 'timeOnSite' ] = wfMsg('timeOnSite');
		$titles[ 'newVisitsTimeOnSite' ] = wfMsg('newVisitsTimeOnSite');

		$returnData = $this->simplePrepareToDisplay( $all , $titles , array());

		$this->saveToCache( 'EngagementData' , $returnData );
		return $returnData;

	}

	public function loadVisitorsData(){

		global $wgStatsDB, $wgWikiaGALogin, $wgWikiaGAPassword, $wgHTTPProxy, $wgDevEnvironment;

		$this->fromYear = 2010;
		$wgServer = WF::build('App')->getGlobal('wgServer');

		// Cache check
		$cachedData = $this->getFromCache( 'VisitorsData' );
		if ( !empty($cachedData) ){
		 	return $cachedData;
		}

		$hostname = $this->prepareGAUrl( $wgServer );

		$ga = new gapi($wgWikiaGALogin, $wgWikiaGAPassword, null, 'curl', $wgHTTPProxy);

		try {
			$ga->requestReportData(
				31330353,
				array('month', 'year'),
				array('newVisits', 'visits'),
				array('-year', '-month'),
				'hostname=~^'.$hostname,
				'2010-04-01',
				date('Y-m-d'),
				1,
				360
			);
		} catch ( Exception $e ) {

			Wikia::log(__METHOD__, false, $e->getMessage());
			return false;
		}

		$results = $ga->getResults();

		$all = array();
		$titles = array();
		reset( $results );
		unset ( $results[ key( $results ) ] );

		foreach( $results as $res ) {
			$date = $res->getYear().'-'.$res->getMonth();
			$all[ $date ][ 'date' ] = $date;
			$all[ $date ][ 'visits' ] = $res->getVisits();
			$all[ $date ][ 'newVisits' ] = $res->getNewVisits();
		}

		$titles[ 'visits' ] = wfMsg('visits');
		$titles[ 'newVisits' ] = wfMsg('newVisits');

		$returnData = $this->simplePrepareToDisplay( $all , $titles , array());

		$this->saveToCache( 'VisitorsData' , $returnData );
		return $returnData;

	}

	public function loadActivityData(){

		global $wgUser, $wgLang, $wgOut, $wgEnableBlogArticles, $wgJsMimeType, $wgExtensionsPath, $wgHubsPages, $wgStyleVersion, $wgRequest, $wgAllowRealName;
		global $wgDBname;

		// Cache check
		$cachedData = $this->getFromCache( 'ActivityData' );
		if ( !empty($cachedData) ){
			return $cachedData;
		}

		$this->fromYear = 2001;

		$aData = $this->loadWikiaGenericStats();
		$outData = $this->prepareWikiaGenericStats( $aData );

		// ===

		$i = 0;
		$oldE = 0;
		$result = array();
		foreach( array_reverse($outData) as $collumns ){

			$collumns['date'] = substr( $collumns['date'], 0, 4 ).'-'.substr( $collumns['date'], 4, 2 );
			$newE = $collumns['E'] - $oldE;
			$result['data'][$i] = "[{$i}, {$newE}]";
			$oldE = $collumns['E'];
			$result1['data'][$i] = "[{$i}, {$collumns['G']}]";
			if ( ( $i % ceil((count($outData) / $this->iNumberOfXGuideLines )) ) == 0 ){
				$result['date'][$i] = "[{$i}, '{$collumns['date']}']";
			}
			$result['fullWikiaDate'][$collumns['date']] = "['{$collumns['date']}', {$i}]";
			$i++;
		
		};

		if ( !isset( $result['data'] ) || !isset( $result1['data'] ) ) {
			return false;
		}

		$aSerie = array(
			'A' => $this->createSerie( wfMsg('serie-8'), $result['data'] ),
			'B' => $this->createSerie( wfMsg('sponsorship-dashboard-serie-new-articles-content-namespace'), $result1['data'] ),
		);


		$sSerie = $this->createJSobj($aSerie);

		$ticks = "[".implode(', ',$result['date'])."]";
		$fullTicks = "[".implode(', ',$result['fullWikiaDate'])."]";

		$outData = array( 'serie' => $sSerie, self::SD_RETURNPARAM_TICKS => $ticks, self::SD_RETURNPARAM_FULL_TICKS => $fullTicks );

		// ==

		$this->saveToCache( 'ActivityData', $outData );
		return $outData;

	}

	public function loadSourceData(){

		global $wgStatsDB, $wgWikiaGALogin, $wgWikiaGAPassword, $wgHTTPProxy, $wgDevEnvironment;
		
		$this->fromYear = 2010;
		$wgServer = WF::build('App')->getGlobal('wgServer');

		// Cache check
		$cachedData = $this->getFromCache( 'SourceData' );
		if ( !empty($cachedData) ){
		 	return $cachedData;
		}

		$hostname = $this->prepareGAUrl( $wgServer );

		$ga = new gapi( $wgWikiaGALogin, $wgWikiaGAPassword, null, 'curl', $wgHTTPProxy);

		try {
			$ga->requestReportData(
				31330353,
				array('day', 'month', 'year', 'medium'),
				array('visits'),
				array('-year', '-month', '-day', 'medium'),
				'hostname=~^'.$hostname,
				'2010-04-01',
				date('Y-m-d'),
				1,
				360
			);
		} catch ( Exception $e ) {

			Wikia::log(__METHOD__, false, $e->getMessage());
			return false;
		}

		$results = $ga->getResults();

		$all = array();
		$titles = array();
//		reset( $results );
//		unset ( $results[ key( $results ) ] );

		foreach( $results as $res ) {
			$medium = $res->getMedium();
			if ( $medium != 'referral' && $medium != 'organic' ){
				$medium = 'direct';
			}
			$date = $res->getYear().'-'.$res->getMonth().'-'.$res->getDay();
			$all[ $date ][ $medium ] = $res->getVisits();
			$titles[ $medium ] = wfMsg( 'sponsorship-dashboard-serie-'.$medium );
			$all[ $date ][ 'date' ] = $date;
		}

		
		
		$returnData = $this->simplePrepareToDisplay( $all , $titles , array());

		$this->saveToCache( 'SourceData' , $returnData );
		return $returnData;

	}

	public function loadKeywordsData(){

		global $wgStatsDB, $wgWikiaGALogin, $wgWikiaGAPassword, $wgHTTPProxy, $wgDevEnvironment;

		$this->fromYear = 2010;
		$wgServer = WF::build('App')->getGlobal('wgServer');

		// Cache check
		$cachedData = $this->getFromCache( 'KeywordData' );
		if ( !empty($cachedData) ){
			return $cachedData;
		}

		$hostname = $this->prepareGAUrl( $wgServer );

		$ga = new gapi($wgWikiaGALogin, $wgWikiaGAPassword, null, 'curl', $wgHTTPProxy);

		try {
			$ga->requestReportData(
				31330353,
				array('keyword', 'day', 'month', 'year', ),
				array('visits'),
				array('-year', '-month', '-day', '-visits'),
				'hostname=~^'.$hostname,
				'2010-04-01',
				date('Y-m-d'),
				1,
				360
			);
		} catch ( Exception $e ) {

			Wikia::log(__METHOD__, false, $e->getMessage());
			return false;
		}

		$results = $ga->getResults();
		
		$all = array();
		$titles = array();
		
		$controlArray = array();
		$sortArray = array();
		$dateArray = array();
		foreach( $results as $res ) {

			$keywords = $res->getKeyword();
			if ( $keywords != '(not set)' ){
				$visits = $res->getVisits();
				$key = 'a'.md5( $keywords );
				if( !isset( $sortArray[ $key ] ) ){
					$sortArray[ $key ] = $visits;
				}
				$sortArray[ $key ] += $visits;
			}
			$date = $res->getYear().'-'.$res->getMonth().'-'.$res->getDay();
			$dateArray[ $date ] = $date;
		}

		asort( $sortArray );
		$sortArray = array_reverse( $sortArray );
		reset( $sortArray );
		$finalArray = array();

		while ( ( count( $finalArray ) < 10 ) || ( count( $finalArray ) == count( $sortArray ) ) ) {
			$finalArray[] = key( $sortArray );
			next( $sortArray );
		}

		foreach ( $dateArray as $date){
			foreach( $finalArray as $value ){
				$all[ $date ][ $value ] = 0;
			}
			$all[ $date ][ 'date' ] = $date;
		}

		foreach( $results as $res ) {

			$keywords = $res->getKeyword();
			$key = 'a'.md5( $keywords );
			$date = $res->getYear().'-'.$res->getMonth().'-'.$res->getDay();

			if ( in_array( $key, $finalArray ) ){
				$titles[ $key ] = htmlspecialchars( $keywords );
				$all[ $date ][ $key ] = $res->getVisits();
			}
		}
		ksort( $all );
		
		$returnData = $this->simplePrepareToDisplay( array_reverse( $all ) , $titles , array());
		$this->saveToCache( 'KeywordData' , $returnData );
		return $returnData;

	}


	protected function loadWikiaGenericStats(){

		$wgCityId = WF::build( 'App' )->getGlobal( 'wgCityId' );

		// WikiaGenericStats instance
		$date = $this->get_previous_month();
		$this->mStats = WikiStats::newFromId( $wgCityId );
		$this->mStats->setStatsDate(
			array(
				'fromMonth'	=> WIKISTATS_MIN_STATS_MONTH,
				'fromYear' 	=> WIKISTATS_MIN_STATS_YEAR,
				'toMonth'	=> date('m', $date),
				'toYear'	=> date('Y', $date)
			)
		);

		$this->mStats->setHub("");
		$this->mStats->setLang("");
		return $this->mStats->loadStatsFromDB();
	}

	protected function prepareWikiaGenericStats( $aData ){

		$outData = $aData;
		foreach( $aData as $key => $row ){
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

		return $outData;
	}
}
