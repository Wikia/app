<?php

class NewWikis {

	const MAX_PAGES = 10;
	const MAX_EDITS = 50;
	const MAX_PV = 1000;
	const MAX_WEEKS = 2;
	const MAX_WIKIS = 100;
	const MAX_WIKIS_PER_PAGE = 2;

	protected $app = null;

	public function __construct(WikiaApp $app) {
		$this->app = $app;
	}

	/**
	 * get db handler
	 * @return DatabaseBase
	 */
	protected function getDb( $type = DB_SLAVE ) {
		return $this->app->runFunction( 'wfGetDB', $type, array(), $this->app->getGlobal( 'wgStatsDB' ) );
	}

	public function getAll() {
		// TODO: re-use or re-implement old code from SpecialNewWikis
		return array();
	}

	public function getActive( $pageNo = 1 ) {
		$db = $this->getDb();
		$activeWikis = array();

		$is_enabled = $this->app->getGlobal( 'wgStatsDBEnabled' );
		if ( empty( $is_enabled ) ) {
			return array( 'wikisNum' => 0, 'pageNo' => $pageNo, 'wikis' => array() );
		}

		$row = $db->selectRow(
			array( 'wikia_monthly_stats' ),
			array( 'unix_timestamp(ts) as lastdate' ),
			array( 'wiki_id' => $this->app->getGlobal( 'wgCityId' ) ),
			__METHOD__,
			array('ORDER BY' => 'ts DESC')
		);

		$statsDate = date('Ym', $row->lastdate );

		//select group_concat(wiki_id) from wikia_monthly_stats where stats_date = 201104 and articles > 10 and articles_edits > 50 and wiki_id in ( select city_id from wikicities.city_list where city_created > now() - interval 2 week );
		$res = $db->query("
		  SELECT group_concat(wiki_id) AS wikis
		  FROM wikia_monthly_stats
		  WHERE
		   stats_date='" . $statsDate ."' AND
		   articles>'" . self::MAX_PAGES . "' AND
		   articles_edits>'" . self::MAX_EDITS . "' AND
		   wiki_id IN ( SELECT city_id FROM wikicities.city_list WHERE city_created>NOW() - INTERVAL " . self::MAX_WEEKS . " WEEK )"
		);

		$row = $db->fetchObject( $res );

		$wikis = explode(',', $row->wikis);
		if ( !empty( $wikis ) ) {
			$startDate = date( 'Y-m-01', strtotime('-1 month') );
			$endDate = date( 'Y-m-01', strtotime('now') );
			$pageviews = DataMartService::getPageviewsMonthly( $startDate, $endDate, $wikis );
			
			if ( empty( $pageviews ) ) {
				foreach ( $pageviews as $wiki_id => $wiki_data ) {
					$activeWikis[] = array(
						'wikiId'	=> $wiki_id,
						'wikiName'	=> WikiFactory::getVarValueByName( 'wgSitename', $wiki_id ),
						'wikiUrl'	=> WikiFactory::getVarValueByName( 'wgServer', $wiki_id ),
						'pv'		=> intval( $wiki_data[ 'SUM' ] )
					);
				}
			}
		}
		
		$result = array(
		  'wikisNum' => count( $activeWikis ),
		  'pageNo' => $pageNo,
		  'wikis' => array_slice( $activeWikis, ($pageNo * self::MAX_WIKIS_PER_PAGE)-1, self::MAX_WIKIS_PER_PAGE )
		);

		return $result;
	}

}
