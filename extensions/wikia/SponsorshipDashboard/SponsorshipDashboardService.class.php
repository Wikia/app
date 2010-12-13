<?php

/**
 * Category service
 * @author Jakub Kurcek
 */
class SponsorshipDashboardService extends Service {

	var $mStats;
	var $aCityHubs;

	public function loadRelatedWikiasData( $hubId = false ){

		global $wgCityId, $wgStatsDB;

		// loads current city id popular hubs
		$this->getPopularHubs();
		if ( empty( $this->aCityHubs ) ){
			return false;
		}

		// if no asked hub or asked for wrong hub, proceeds with first hub from the list
		if ( isset( $this->aCityHubs[$hubId['name']] ) ){
			$currentHub = $hubId['id'];
		} else {
			$aKeys = array_keys( $this->aCityHubs );
			$currentHub = $this->aCityHubs[ $aKeys[0] ];
		}

		// loads cache data
		$cachedData = $this->getFromCache( 'RelatedWikiaStats'.$currentHub );
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
			$cityUniqueUsers[ $row->pv_week ] = intval( $row->cityuniqueusers );
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
		while ($row = $res->fetchObject($res)) {
			if (	isset( $cityUniqueUsers[ $row->week ] ) &&
				!empty( $cityUniqueUsers[ $row->week ] ) &&
				( ( !isset( $all[ $row->week ] ) ) || ( count( $all[ $row->week ] ) <= 10 ) )
			){
				$familiarity = round( ( $row->citycommonusers / $cityUniqueUsers[ $row->week ] * 100 ) , 2 );
				if ( $familiarity > 5 ) {
					$all[ $row->week ]['date'] = $row->week;
					$all[ $row->week ][ $row->cityId ] = $familiarity;
					$titles[ $row->cityId ] = $row->city_title;
				}
			}
		}
		$returnData = $this->simplePrepareToDisplay( $all , $titles );

		$this->saveToCache( 'RelatedWikiaStats'.$currentHub , $returnData );

		return $returnData;

	}

	/**
	 * loadTop10CompetitionData
	 * @param $hub integer
	 *
	 * @return array
	 */

	public function loadTop10CompetitionData( $hub ){

		global $wgCityId, $wgStatsDB;

		if( empty( $hub )){
		 	return false;
		}

		// loads cache data
		$cachedData = $this->getFromCache( 'Top10CompetitionStats:Hub'.$hub['id'] );
		if ( !empty($cachedData) ){
			return $cachedData;
		}

		// loads current city id popular hubs
		$this->getPopularHubs();
		if ( empty( $this->aCityHubs ) ){
			return false;
		}

		// if no asked hub or asked for wrong hub, proceeds with first hub from the list
		if ( isset( $this->aCityHubs[$hub['name']] ) ){
			$currentHub = $hub['id'];
		} else {
			$aKeys = array_keys( $this->aCityHubs );
			$currentHub = $this->aCityHubs[ $aKeys[0] ];
		}

		// never use current data. use data from last week.
		$sWeek = ( (int)date('W') > 0 ) ? date('W') : '51';
		$sYear = ( (int)date('W') > 0 ) ? date('Y') : ((int)date('Y') - 1);

		$currentYearWeek = $sYear.$sWeek;
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

			// sets $cityUniqueUsers for current city_id
			if ( !isset( $cityUniqueUsers )){
				$cityUniqueUsers = $row->citycommonusers;
			}
			
			// calculate familiarity
			$familiarity = round( $row->citycommonusers / $cityUniqueUsers * 100 , 2);
			$titles[ 'c'.$row->cityId ] = $row->city_title.' - <i>'.$familiarity.'% user match</i>';
			$sortBy[] =  $row->cityId;

			$all = array_merge_recursive (
				$all,
				$this->getMonthlyCityPageviewsFromGA(
					$row->cityUrl,
					$row->cityId,
					'c',
					$hub['id']
				)
			);

		}
		
		$returnData = $this->simplePrepareToDisplay( $all, $titles , array( 'newVisits' ) );
		$this->saveToCache( 'Top10CompetitionStats:Hub'.$hub['id'] , $returnData );

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

	private function getMonthlyCityPageviewsFromGA( $cityUrl, $cityId, $prefix, $hubId ){

		// inner cache. Various city id can be asked from many places.
		$cachedData = $this->getFromCache( 'MonthlyCityPageviewsFromGA:Hub'.$hubId, $cityId );
		if ( !empty($cachedData) ){
			return $cachedData;
		}

		global $wgWikiaGALogin, $wgWikiaGAPassword, $wgHTTPProxy;

		$ga = new gapi( $wgWikiaGALogin, $wgWikiaGAPassword, null, 'curl', $wgHTTPProxy );
		$ga->requestReportData(
			31330353,
			array( 'month', 'year' ),
			array( 'pageviews' ),
			array( '-year', '-month' ),
			'hostname=~^'.$this->prepareGAUrl( $cityUrl ),
			'2010-04-01',
			date('Y-m-d'),
			1,
			360
		);

		$results = $ga->getResults();
		reset( $results );
		unset ( $results[ key( $results ) ] );

		foreach( $results as $obj ) {
			$date = $obj->getYear().'/'.$obj->getMonth();
			$all[ $date ][ 'date' ] = $date;
			$all[ $date ][ $prefix.$cityId ] = $obj->getPageviews();
		}

		$this->saveToCache( 'MonthlyCityPageviewsFromGA:Hub'.$hubId, $all, $cityId );

		return $all;

	}

	/**
	 * prepareGAUrl - converts URL to GA host filter
	 * @param $url string
	 *
	 * @return string
	 */

	private function prepareGAUrl( $url ){

		global $wgDevEnvironment;

		$hostname = str_replace( 'http://', '', $url );
		$hostname = str_replace( '/', '', $hostname );
		$hostname = str_replace( '.', '\\.', $hostname );

		if ( $wgDevEnvironment ){
			$hostname = explode('\\', $hostname);
			$hostname = $hostname[0].'\\.wikia\\.com';
		}

		return $hostname;
		
	}

	/**
	 * loadGAData - loads data from GA for current cityId
	 * @return array
	 */

	public function loadGAData(){

		global $wgCityId, $wgStatsDB, $wgServer, $wgWikiaGALogin, $wgWikiaGAPassword, $wgHTTPProxy, $wgDevEnvironment;

		// Cache check
		$cachedData = $this->getFromCache( 'GAStats' );
		if ( !empty($cachedData) ){
		 	return $cachedData;
		}

		$hostname = $this->prepareGAUrl( $wgServer );
		
		$ga = new gapi($wgWikiaGALogin, $wgWikiaGAPassword, null, 'curl', $wgHTTPProxy);

		$ga->requestReportData(
			31330353,
			array('day', 'month', 'year'),
			array('timeOnSite', 'visits', 'pageviews', 'bounces', 'newVisits'),
			array('-year', '-month', '-day'),
			'hostname=~^'.$hostname,
			'2010-04-01',
			date('Y-m-d'),
			1,
			360
		);
		
		$results = $ga->getResults();
		
		$all = array();
		$titles = array();
		reset( $results );
		unset ( $results[ key( $results ) ] );
		
		foreach( $results as $res ) {
			$date = $res->getYear().'/'.$res->getMonth().'/'.$res->getDay();
			$all[ $date ][ 'date' ] = $date;
			$all[ $date ][ 'pageviews' ] = $res->getPageviews();
			$all[ $date ][ 'clicks' ] = $all[ $date ][ 'pageviews' ] - $res->getBounces();
			$all[ $date ][ 'timeOnSite' ] = round( $res->getTimeOnSite()/60/60 );
			$all[ $date ][ 'visits' ] = $res->getVisits();
			$all[ $date ][ 'newVisits' ] = ( !empty( $all[ $date ][ 'visits' ] ) ) ? round( $res->getNewVisits() / $all[ $date ][ 'visits' ] * 100 ) : 0;
			$all[ $date ][ 'newVisitsTimeOnSite' ] = ( !empty( $all[ $date ][ 'visits' ] ) ) ? round( $all[ $date ][ 'timeOnSite' ] * $res->getNewVisits() / $all[ $date ][ 'visits' ]  ) : 0;
		}

		$titles[ 'pageviews' ] = wfMsg('pageviews');
		$titles[ 'clicks' ] = wfMsg('clicks');
		$titles[ 'visits' ] = wfMsg('visits');
		$titles[ 'timeOnSite' ] = wfMsg('timeOnSite');
		$titles[ 'newVisits' ] = wfMsg('newVisits');
		$titles[ 'newVisitsTimeOnSite' ] = wfMsg('newVisitsTimeOnSite');

		$returnData = $this->simplePrepareToDisplay( $all , $titles , array( 'newVisits' ));
		
		$this->saveToCache( 'GAStats' , $returnData );
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

	private function simplePrepareToDisplay( $data, $labels, $aSecondYAxis = array() ){

		if ( empty( $data ) || empty( $labels ) ){
			return false;
		}
		$i = 0;
		foreach( array_reverse($data) as $collumns ){
			foreach( $collumns as $key => $val ){
				if ( !in_array( $key, array('date') ) ){
					$results[$key][$i] = "[{$i}, {$val}]";
				}
			}
			if ( ( $i % ceil((count($data) / 11)) ) == 0 ){
				$result['date'][$i] = "[{$i}, '{$collumns['date']}']";
			}
			$i++;
		};

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
		return array( 'serie' => $sSerie, 'ticks' => $ticks );
	}

	/**
	 * loadDataFromWikiStats - loads data from WikiStats.
	 * @return array
	 */

	public function loadDataFromWikiStats(){

		global $wgUser, $wgLang, $wgOut, $wgEnableBlogArticles, $wgJsMimeType, $wgExtensionsPath, $wgHubsPages, $wgStyleVersion, $wgRequest, $wgAllowRealName;
		global $wgCityId, $wgDBname;

		// Cache check
		$cachedData = $this->getFromCache( 'WikiStats' );
		if ( !empty($cachedData) ){
			return $cachedData;
		}

		// WikiaGenericStats instance
		$date = $this->get_previous_month();
		$this->mStats = WikiStats::newFromId($wgCityId);
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

		$outData = $this->prepareToDisplay( $outData );

		$this->saveToCache( 'WikiStats', $outData );
		return $outData;
	}

	/**
	 * pushArticleNumbersFromNamespace - adds namespace articles to array.
	 * @param $aData	base data		array
	 * @param $iNamespace	namespace id		int
	 * @param $sKey		new key for data	string
	 * @return array
	 */

	private function pushArticleNumbersFromNamespace( $aData, $iNamespace, $sKey){

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

	private function createSerie( $sLabel, $aData, $bSecondAxis = false ){

		return "{label:'".addslashes($sLabel)."', data: [".implode( ', ',array_filter( $aData, array("self", "filter") ) )."], yaxis: ".( ( $bSecondAxis ) ? 2 : 1 )." }";
	}

	/**
	 * prepareToDisplay - returns data ready to be displayed in template
	 * @param	$data	array
	 * @return	array
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
			if ( isset($collumns['X']) ) $result12['data'][$i] = "[{$i}, {$collumns['X']}]";
			if ( isset($collumns['Y']) ) $result13['data'][$i] = "[{$i}, {$collumns['Y']}]";
			if ( ( $i % ceil((count($data) / 11)) ) == 0 ){
				$result['date'][$i] = "[{$i}, '{$collumns['date']}']";
			}
			$i++;
		};

		$aSerie = array(
			'A' => $this->createSerie( wfMsg('serie-1'), $result['data'] ),
			'B' => $this->createSerie( wfMsg('serie-2'), $result1['data'] ),
			'C' => $this->createSerie( wfMsg('serie-3'), $result2['data'] ),
			'D' => $this->createSerie( wfMsg('serie-4'), $result3['data'] ),
			'E' => $this->createSerie( wfMsg('serie-5'), $result4['data'] ),
			'F' => $this->createSerie( wfMsg('serie-6'), $result5['data'] ),
			'G' => $this->createSerie( wfMsg('serie-7'), $result6['data'] ),
			'H' => $this->createSerie( wfMsg('serie-8'), $result7['data'] ),
			'I' => $this->createSerie( wfMsg('serie-9'), $result8['data'] ),
			'J' => $this->createSerie( wfMsg('serie-10'), $result9['data'] ),
			'K' => $this->createSerie( wfMsg('serie-11'), $result10['data'] ),
			'L' => $this->createSerie( wfMsg('serie-12'), $result11['data'] )
		);
		if ( isset($result12) ) $aSerie['X'] = $this->createSerie( wfMsg('serie-13'), $result12['data'] );
		if ( isset($result13) ) $aSerie['Y'] = $this->createSerie( wfMsg('serie-14'), $result13['data'] );

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
	
	private function getKey( $prefix, $cityId = false ) {

		if ( empty( $cityId ) ){
			global $wgCityId;
			$cityId = $wgCityId;
		}
		return wfSharedMemcKey( 'SponsoredDashboard', $prefix, $cityId );
	}

	private function saveToCache( $prefix, $content, $cityId = false ) {

		global $wgMemc;
		$memcData = $this->getFromCache( $prefix, $cityId );
		if ( $memcData == null ){
			$wgMemc->set( $this->getKey( $prefix, $cityId ), $content, 60*60*24);
			return false;
		}
		return true;
	}

	private function getFromCache ( $prefix, $cityId = false ){

		global $wgMemc;
		return $wgMemc->get( $this->getKey( $prefix, $cityId ) );
	}

	private function clearCache ( $prefix, $cityId = false ){

		global $wgMemc;
		return $wgMemc->delete( $this->getKey( $prefix, $cityId ) );
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


	/**
	 * loadTagPosition - loads data from WikiFactory.
	 * @return array
	 */

	public function loadTagPosition(){

		// 2DO: fix - too slow.

		global $wgTitle, $wgCityId, $wgHubsPages, $wgStatsDB;

		// Cache check
		$cachedData = $this->getFromCache( 'rankingByHub' );
		if ( !empty( $cachedData ) ){
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
		
		$wikiFactoryTags = new WikiFactoryTags($wgCityId);
		$cityTags = $wikiFactoryTags->getTags();

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

	public function getPopularHubs(){

		global $wgHubsPages, $wgCityId;

		if ( !empty($this->aCityHubs) ){
			return $this->aCityHubs;
		}

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
		$this->aCityHubs = $popularCityHubs;
		return $popularCityHubs;
	}
}
