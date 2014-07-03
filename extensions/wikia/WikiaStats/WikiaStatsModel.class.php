<?php
class WikiaStatsModel extends WikiaModel {

	const EDITS_DEFAULT_FALLBACK = 400000;
	const TOTAL_COMMUNITIES_FALLBACK = 300000;
	const LAST_DAYS_NEW_COMMUNITIES_FALLBACK = 400;
	const TOTAL_PAGES_FALLBACK = 32000000;
	const MOBILE_PERCENTAGE_FALLBACK = 25;
	const VISITORS_FALLBACK = 100000000;

	public function __construct() {
		parent::__construct();

		$statsFromWF = $this->getStatsFromWF();

		$this->editsDefaultFallback = self::EDITS_DEFAULT_FALLBACK < $statsFromWF['editsDefault'] ?
			$statsFromWF['editsDefault'] : self::EDITS_DEFAULT_FALLBACK;

		$this->totalCommunitiesFallback = self::TOTAL_COMMUNITIES_FALLBACK < $statsFromWF['totalCommunities'] ?
			$statsFromWF['totalCommunities'] : self::TOTAL_COMMUNITIES_FALLBACK;

		$this->totalPagesFallback = self::TOTAL_PAGES_FALLBACK < $statsFromWF['totalPages'] ?
			$statsFromWF['totalPages'] : self::TOTAL_PAGES_FALLBACK;

		$this->lastDaysCommunitiesFallback = self::LAST_DAYS_NEW_COMMUNITIES_FALLBACK < $statsFromWF['lastDaysCommunities'] ?
			$statsFromWF['lastDaysCommunities'] : self::LAST_DAYS_NEW_COMMUNITIES_FALLBACK;

		//Mobile percentage value is set via WF so WF value is not a fallback
		$this->mobilePercentage = self::MOBILE_PERCENTAGE_FALLBACK < $statsFromWF['mobilePercentage'] ?
			$statsFromWF['mobilePercentage'] : self::MOBILE_PERCENTAGE_FALLBACK;

		//Visitors value is set via WF so WF value is not a fallback
		$this->visitors = self::VISITORS_FALLBACK < $statsFromWF['visitors'] ?
			$statsFromWF['visitors'] : self::VISITORS_FALLBACK;
	}

	public function getWikiaStatsIncludingFallbacks() {
		$stats['edits'] = $this->getEdits();
		$stats['totalCommunities'] = $this->getTotalCommunities();
		$stats['newCommunities'] = $this->getLastDaysNewCommunities();
		$stats['totalPages'] = $this->getTotalPages();
		$stats['mobilePercentage'] = $this->getMobilePercentage();
		$stats['visitors'] = $this->getVisitors();
	}

	private function getEdits() {
		$edits = $this->getEditsFromDB();
		$edits = $edits ? $edits : $this->editsDefaultFallback;

		return $edits;
	}

	private function getTotalCommunities() {
		$totalCommunitiesFromDB = $this->getTotalCommunitiesFromDB();
		$totalCommunities = $totalCommunitiesFromDB ? $totalCommunitiesFromDB : $this->totalCommunitiesFallback;

		return $totalCommunities;
	}

	private function getLastDaysNewCommunities() {
		$lastDaysNewCommunitiesFromDB = $this->getLastDaysNewCommunitiesFromDB();
		$lastDaysNewCommunities = $lastDaysNewCommunitiesFromDB ? $lastDaysNewCommunitiesFromDB : $this->lastDaysCommunitiesFallback;

		return $lastDaysNewCommunities;
	}

	private function getTotalPages() {
		$totalPages = intval(Wikia::get_content_pages());
		$totalPages = $this->totalPagesFallback < $totalPages ?
			$totalPages : $this->totalPagesFallback;

		return $totalPages;
	}

	private function getMobilePercentage() {
		return $this->mobilePercentage;
	}

	private function getVisitors() {
		return $this->visitors;
	}

	private function getStatsFromWF() {
		return WikiFactory::getVarValueByName('wgCorpMainPageStats', Wikia::COMMUNITY_WIKI_ID);
	}

	private function getEditsFromDB() {
		wfProfileIn(__METHOD__);

		$edits = 0;
		if (!empty($this->wg->StatsDBEnabled)) {
			$db = wfGetDB(DB_SLAVE, array(), $this->wg->StatsDB);

			$row = $db->selectRow(
				array('events'),
				array('count(*) cnt'),
				array('event_date between curdate() - interval 2 day and curdate() - interval 1 day'),
				__METHOD__
			);

			if ($row) {
				$edits = intval($row->cnt);
			}
		}

		wfProfileOut(__METHOD__);

		return $edits;
	}

	private function getTotalCommunitiesFromDB() {
		wfProfileIn(__METHOD__);

		$communities = 0;
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->externalSharedDB);
		$row = $db->selectRow(
			array('city_list'),
			array('count(1) cnt'),
			array('city_public = 1 AND city_created < DATE(NOW())'),
			__METHOD__
		);

		if ($row) {
			$communities = intval($row->cnt);
		}

		wfProfileOut(__METHOD__);

		return $communities;
	}

	private function getLastDaysNewCommunitiesFromDB() {
		$today = strtotime('00:00:00');
		$yesterday = strtotime('-1 day', $today);
		return $this->getNewCommunitiesInRangeFromDB($yesterday, $today);
	}

	private function getNewCommunitiesInRangeFromDB($starttimestamp, $endtimestamp) {
		wfProfileIn(__METHOD__);

		$db = wfGetDB(DB_SLAVE, array(), $this->wg->externalSharedDB);
		$row = $db->selectRow(
			array('city_list'),
			array('count(1) cnt'),
			array(
				'city_public' => 1,
				'city_created >= FROM_UNIXTIME(' . $starttimestamp . ')',
				'city_created < FROM_UNIXTIME(' . $endtimestamp . ')'
			),
			__METHOD__
		);
		$newCommunities = 0;
		if ($row) {
			$newCommunities = intval($row->cnt);
		}

		wfProfileOut(__METHOD__);

		return $newCommunities;
	}

	public function setWikiaStatsInWF($statsMemcacheKey, $statsValues) {
		WikiFactory::setVarByName('wgCorpMainPageStats', Wikia::COMMUNITY_WIKI_ID, $statsValues);
		WikiaDataAccess::cachePurge($statsMemcacheKey);
		$corpWikisLangs = array_keys( ( new CityVisualization() )->getVisualizationWikisData() );
		$wikiaHubsHelper = new WikiaHubsServicesHelper();
		foreach ($corpWikisLangs as $lang) {
			$wikiaHubsHelper->purgeHomePageVarnish($lang);
		}
	}
}
