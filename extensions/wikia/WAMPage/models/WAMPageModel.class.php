<?php
class WAMPageModel extends WikiaModel {
	const ITEMS_PER_PAGE = 20;
	const VISUALIZATION_ITEMS_COUNT = 4;
	const VISUALIZATION_ITEM_IMAGE_WIDTH = 150;
	const VISUALIZATION_ITEM_IMAGE_HEIGHT = 95;

	const SCORE_ROUND_PRECISION = 2;

	public function getItemsPerPage() {
		return self::ITEMS_PER_PAGE;
	}

	public function getVisualizationItemsCount() {
		return self::VISUALIZATION_ITEMS_COUNT;
	}

	public function getVisualizationWikis($lang, $verticalId = null) {
		if( !empty($this->app->wg->DevelEnvironment) ) {
			$WAMData = $this->getMockedDataForDev();
		} else {
			$lastDay = strtotime('00:00 -1 day');

			$params = [
				'wam_day' => $lastDay,
				'wam_previous_day' => strtotime('-1 day', $lastDay),
				'wiki_lang' => $lang,
				'vertical_id' => $verticalId,
				'limit' => $this->getVisualizationItemsCount(),
				'sort_column' => 'wam_index',
				'sort_direction' => 'DESC',
				'wiki_image_height' => self::VISUALIZATION_ITEM_IMAGE_HEIGHT,
				'wiki_image_width' => self::VISUALIZATION_ITEM_IMAGE_WIDTH,
				'fetch_wiki_images' => true,
			];

			$WAMData = $this->app->sendRequest('WAMApi', 'getWAMIndex', $params)->getData();
		}
		return $this->prepareIndex($WAMData['wam_index']);
	}

	protected function prepareIndex($wamWikis) {
		foreach ($wamWikis as &$wiki) {
			$wiki['wam'] = round($wiki['wam'], self::SCORE_ROUND_PRECISION);
			$wiki['hub_name'] = $this->getVerticalName($wiki['hub_id']);
		}

		return $wamWikis;
	}

	protected function getVerticalName($verticalId) {
		/** @var WikiFactoryHub $wikiFactoryHub */
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$wikiaHub = $wikiFactoryHub->getCategory($verticalId);
		return $this->wf->Message('wam-' . $wikiaHub['name'])->inContentLanguage()->text();
	}

	/**
	 * MOCKED data for devboxes for testing
	 * because we don't have wam data on devboxes
	 *
	 * @return array
	 */
	protected function getMockedDataForDev() {
		return ['wam_results_total' => 3147, 'wam_index' => [
			304 => [
				'wiki_id' => '304',
				'wam'=> '99.9554',
				'wam_rank' => '1',
				'peak_wam_rank' => '1',
				'peak_hub_wam_rank' => '1',
				'top_1k_days' => '431',
				'top_1k_weeks' => '62',
				'first_peak' => '2012-01-03',
				'last_peak' => '2013-03-06',
				'title' => 'RuneScape Wiki',
				'url' => 'runescape.wikia.com',
				'hub_id' => '2',
				'wam_change' => '0.0045',
				'admins' => [],
				'wiki_image' => 'http://images1.wikia.nocookie.net/__cb20121004184329/wikiaglobal/images/thumb/8/8b/Wikia-Visualization-Main%2Crunescape.png/150px-Wikia-Visualization-Main%2Crunescape.png',
			],
			14764 => [
				'wiki_id' => '14764',
				'wam'=> '99.8767',
				'wam_rank' => '2',
				'hub_wam_rank' => '2',
				'peak_wam_rank' => '1',
				'peak_hub_wam_rank' => '1',
				'top_1k_days' => '431',
				'top_1k_weeks' => '62',
				'first_peak' => '2012-04-21',
				'last_peak' => '2013-02-18',
				'title' => 'League of Legends Wiki',
				'url' => 'leagueoflegends.wikia.com',
				'hub_id' => '2',
				'wam_change' => '0.0039',
				'admins' => [],
				'wiki_image' => 'http://images4.wikia.nocookie.net/__cb20120828154214/wikiaglobal/images/thumb/e/ea/Wikia-Visualization-Main%2Cleagueoflegends.png/150px-Wikia-Visualization-Main%2Cleagueoflegends.png.jpeg',
			],
			1706 => [
				'wiki_id' => '1706',
				'wam'=> '99.7942',
				'wam_rank' => '4',
				'hub_wam_rank' => '3',
				'peak_wam_rank' => '1',
				'peak_hub_wam_rank' => '1',
				'top_1k_days' => '431',
				'top_1k_weeks' => '62',
				'first_peak' => '2012-01-01',
				'last_peak' => '2013-02-13',
				'title' => 'Elder Scrolls',
				'url' => 'elderscrolls.wikia.com',
				'hub_id' => '2',
				'wam_change' => '-0.0016',
				'admins' => [],
				'wiki_image' => 'http://images1.wikia.nocookie.net/__cb20121214183339/wikiaglobal/images/thumb/d/d4/Wikia-Visualization-Main%2Celderscrolls.png/150px-Wikia-Visualization-Main%2Celderscrolls.png',
			],
			3035 => [
				'wiki_id' => '3035',
				'wam'=> '99.6520',
				'wam_rank' => '9',
				'hub_wam_rank' => '4',
				'peak_wam_rank' => '4',
				'peak_hub_wam_rank' => '3',
				'top_1k_days' => '431',
				'top_1k_weeks' => '62',
				'first_peak' => '2012-01-02',
				'last_peak' => '2013-09-11',
				'title' => 'Fallout Wiki',
				'url' => 'fallout.wikia.com',
				'hub_id' => '2',
				'wam_change' => '0.0091',
				'admins' => [],
				'wiki_image' => null,
			],
		]];
	}
}
