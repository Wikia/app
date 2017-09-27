<?php
class WikiaStatsModel extends WikiaModel {

	const EDITS_DEFAULT_FALLBACK = 400000;
	const TOTAL_COMMUNITIES_FALLBACK = 300000;
	const LAST_DAYS_NEW_COMMUNITIES_FALLBACK = 400;
	const TOTAL_PAGES_FALLBACK = 32000000;
	const MOBILE_PERCENTAGE_FALLBACK = 25;
	const VISITORS_FALLBACK = 100000000;


	private $editsDefaultFallback;
	private $totalCommunitiesFallback;
	private $totalPagesFallback;
	private $lastDaysCommunitiesFallback;
	private $mobilePercentage;
	private $visitors;

	public function getWikiaStatsIncludingFallbacks($statsFromWF) {
		$this->setFallbacks($statsFromWF);
		$stats = [
			'edits' => $this->getEdits(),
			'communities' => $this->getTotalCommunities(),
			'newCommunities' => $this->getLastDaysNewCommunities(),
			'totalPages' => $this->getTotalPages(),
			'mobilePercentage' => $this->getMobilePercentage(),
			'visitors' => $this->getVisitors()
		];

		return $stats;
	}

	private function getEdits() {
		$edits = $this->getEditsFromDB();
		$edits = $edits ? $edits : $this->editsDefaultFallback;

		return $edits;
	}

	private function getTotalCommunities() {
		$totalCommunities = $this->getTotalCommunitiesFromDB();
		$totalCommunities = $totalCommunities ? $totalCommunities : $this->totalCommunitiesFallback;

		return $totalCommunities;
	}

	private function getLastDaysNewCommunities() {
		$lastDaysNewCommunities = $this->getLastDaysNewCommunitiesFromDB();
		$lastDaysNewCommunities = $lastDaysNewCommunities ? $lastDaysNewCommunities : $this->lastDaysCommunitiesFallback;

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

	private function getEditsFromDB() {
		wfProfileIn(__METHOD__);

		global $wgStatsDBEnabled;
		global $wgStatsDB;

		$edits = 0;
		if (!empty($wgStatsDBEnabled)) {
			$db = wfGetDB(DB_SLAVE, [], $wgStatsDB);

			$row = $db->selectRow(
				['events'],
				['count(*) cnt'],
				['event_date between curdate() - interval 2 day and curdate() - interval 1 day'],
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

		global $wgExternalSharedDB;

		$communities = 0;
		$db = wfGetDB(DB_SLAVE, [], $wgExternalSharedDB);
		$row = $db->selectRow(
			['city_list'],
			['count(1) cnt'],
			['city_public = 1 AND city_created < DATE(NOW())'],
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

	private function getNewCommunitiesInRangeFromDB($startTimestamp, $endTimestamp) {
		wfProfileIn(__METHOD__);

		global $wgExternalSharedDB;

		$db = wfGetDB(DB_SLAVE, [], $wgExternalSharedDB);
		$row = $db->selectRow(
			['city_list'],
			['count(1) cnt'],
			[
				'city_public' => 1,
				'city_created >= FROM_UNIXTIME(' . $startTimestamp . ')',
				'city_created < FROM_UNIXTIME(' . $endTimestamp . ')'
			],
			__METHOD__
		);
		$newCommunities = 0;
		if ($row) {
			$newCommunities = intval($row->cnt);
		}

		wfProfileOut(__METHOD__);

		return $newCommunities;
	}

	public static function getWikiaStatsFromWF() {
		return WikiFactory::getVarValueByName('wgCorpMainPageStats', Wikia::COMMUNITY_WIKI_ID);
	}

	private function setFallbacks($statsFromWF) {
		$this->editsDefaultFallback = self::EDITS_DEFAULT_FALLBACK < $statsFromWF['editsDefault'] ?
			$statsFromWF['editsDefault'] : self::EDITS_DEFAULT_FALLBACK;

		$this->totalPagesFallback = self::TOTAL_PAGES_FALLBACK < $statsFromWF['totalPages'] ?
			$statsFromWF['totalPages'] : self::TOTAL_PAGES_FALLBACK;

		$this->totalCommunitiesFallback = self::TOTAL_COMMUNITIES_FALLBACK;

		$this->lastDaysCommunitiesFallback = self::LAST_DAYS_NEW_COMMUNITIES_FALLBACK;

		//Mobile percentage value is set via WF so WF value is not a fallback
		$this->mobilePercentage = self::MOBILE_PERCENTAGE_FALLBACK < $statsFromWF['mobilePercentage'] ?
			$statsFromWF['mobilePercentage'] : self::MOBILE_PERCENTAGE_FALLBACK;

		//Visitors value is set via WF so WF value is not a fallback
		$this->visitors = self::VISITORS_FALLBACK < $statsFromWF['visitors'] ?
			$statsFromWF['visitors'] : self::VISITORS_FALLBACK;
	}
}
