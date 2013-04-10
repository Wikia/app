<?php
class WAMPageModel extends WikiaModel {
	const FIRST_PAGE = 1;
	const ITEMS_PER_PAGE = 20;
	const VISUALIZATION_ITEMS_COUNT = 4;
	const VISUALIZATION_ITEM_IMAGE_WIDTH = 144;
	const VISUALIZATION_ITEM_IMAGE_HEIGHT = 94;
	const SCORE_ROUND_PRECISION = 2;

	const TAB_INDEX_TOP_WIKIS = 0;
	const TAB_INDEX_BIGGEST_GAINERS = 1;
	const TAB_INDEX_GAMING = 2;
	const TAB_INDEX_ENTERTAINMENT = 3;
	const TAB_INDEX_LIFESTYLE = 4;
	
	protected $config = null;
	
	static protected $failoverTabsNames = [
		self::TAB_INDEX_TOP_WIKIS => 'Top wikis',
		self::TAB_INDEX_BIGGEST_GAINERS => 'The biggest gainers',
		self::TAB_INDEX_GAMING => 'Top video games wikis',
		self::TAB_INDEX_ENTERTAINMENT => 'Top entertainment wikis',
		self::TAB_INDEX_LIFESTYLE => 'Top lifestyle wikis'
	];

	static protected $verticalIds = [
		WikiFactoryHub::CATEGORY_ID_GAMING,
		WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT,
		WikiFactoryHub::CATEGORY_ID_LIFESTYLE
	];
	
	public function __construct() {
		parent::__construct();

		if( is_null($this->config) ) {
			$this->config = $this->app->wg->WAMPageConfig;
		}
	}
	
	public function getConfig() {
		return $this->config;
	}

	public function getItemsPerPage() {
		return self::ITEMS_PER_PAGE;
	}

	public function getVisualizationItemsCount() {
		return self::VISUALIZATION_ITEMS_COUNT;
	}
	
	public function getFirstPage() {
		return self::FIRST_PAGE;
	}

	/**
	 * Get wikis for visualization
	 *
	 * @param int $tabIndex
	 * @return mixed
	 */
	public function getVisualizationWikis($tabIndex) {
		if( !empty($this->app->wg->DevelEnvironment) ) {
			$WAMData = $this->getMockedDataForDev();
		} else {
			switch($tabIndex) {
				case self::TAB_INDEX_BIGGEST_GAINERS: $params = $this->getVisualizationParams( null, 'wam_change' ); break;
				case self::TAB_INDEX_GAMING: $params = $this->getVisualizationParams( WikiFactoryHub::CATEGORY_ID_GAMING ); break;
				case self::TAB_INDEX_ENTERTAINMENT: $params = $this->getVisualizationParams( WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT ); break;
				case self::TAB_INDEX_LIFESTYLE: $params = $this->getVisualizationParams( WikiFactoryHub::CATEGORY_ID_LIFESTYLE ); break;
				default: $params = $this->getVisualizationParams(); break;
			}

			$WAMData = $this->app->sendRequest('WAMApi', 'getWAMIndex', $params)->getData();
		}
		return $this->prepareIndex($WAMData['wam_index'], $tabIndex);
	}

	/**
	 * Get wam index
	 *
	 * @param array $params - available keys:
	 * 		searchPhrase
	 * 		verticalId
	 * 		langCode
	 * 		date
	 *
	 * @return array
	 */
	public function getIndexWikis($params) {
		if( !empty($this->app->wg->DevelEnvironment) ) {
			$WAMData = $this->getMockedDataForDev();
		} else {
			$params = $this->getIndexParams($params);
			$WAMData = $this->app->sendRequest('WAMApi', 'getWAMIndex', $params)->getData();
		}

		$WAMData['wam_index'] = $this->prepareIndex($WAMData['wam_index'], self::TAB_INDEX_TOP_WIKIS);
		return $WAMData;
	}

	public function getMinMaxIndexDate() {
		$dates = $this->app->sendRequest('WAMApi', 'getMinMaxWamIndexDate')->getData();
		if (isset($dates['min_max_dates'])) {
			$dates = $dates['min_max_dates'];
		} else {
			$dates = [
				'min_date' => null,
				'max_date' => null
			];
		}
		return $dates;
	}
	
	public function getWAMMainPageName() {
		$config = $this->getConfig();
		return $config['pageName'];
	}
	
	public function getWAMMainPageUrl() {
		$title = Title::newFromText($this->getWAMMainPageName());
		
		return ($title instanceof Title) ? $title->getFullUrl() : null;
	}

	public function getWAMFAQPageName() {
		$config = $this->getConfig();
		return $config['faqPageName'];
	}
	
	public function isWAMFAQPage(Title $title) {
		return mb_strtolower($title->getText()) === mb_strtolower($this->getWAMFAQPageName());
	}
	
	public function getTabsNamesArray() {
		$config = $this->getConfig();
		return !empty($config['tabsNames']) ? $config['tabsNames'] : $this->getDefaultTabsNames();
	}
	
	public function getTabIndexBySubpageText($subpageText) {
		return array_search($subpageText, $this->getTabsNamesArray());
	}

	public function getTabNameByIndex($tabIndex) {
		$tabNames = $this->getTabsNamesArray();
		return array_key_exists($tabIndex, $tabNames) ? $tabNames[$tabIndex] : false;
	}

	/**
	 * @desc Returns array with tab names and urls by default it's in English taken from global variable $wgWAMPageConfig['tabsNames']
	 *
	 * @param int $selectedIdx array index of selected tab
	 */
	public function getTabs($selectedIdx = 0) {
		$tabs = [];
		$pageName = $this->getWAMMainPageName();
		$tabsNames = $this->getTabsNamesArray();
		
		foreach($tabsNames as $tabName) {
			$tabTitle = Title::newFromText($pageName . '/'. $tabName);
			$tabUrl = $tabTitle->getLocalURL();
			$tabs[] = ['name' => $tabName, 'url' => $tabUrl];
		}

		if( !empty($tabs[$selectedIdx]) ) {
			$tabs[$selectedIdx]['selected'] = true;
		}

		return $tabs;
	}
	
	public function getWamPagesDbKeysLower() {
		$pagesLowerCase = [];
		$pageName = mb_strtolower($this->getWAMMainPageName());
		
		foreach($this->getTabsNamesArray() as $tabName) {
			$tabTitle = Title::newFromText($pageName . '/'. $tabName);
			$pagesLowerCase[] = mb_strtolower($tabTitle->getDBKey());
		}
		
		$pagesLowerCase[] = $pageName;
		$pagesLowerCase[] = mb_strtolower($this->getWAMFAQPageName());
		
		return $pagesLowerCase;
	}

	/**
	 * Get corporate wikis languages for filters
	 *
	 * @return array
	 */
	public function getCorporateWikisLanguages() {
		$visualizationModel = new CityVisualization();
		$wikisData = $visualizationModel->getVisualizationWikisData();

		$langs = array();

		foreach ($wikisData as $wikiData) {
			$langs[] = $wikiData['lang'];
		}
		return $langs;
	}

	/**
	 * Get verticals for filters
	 * @return array
	 */
	public function getVerticals() {
		$verticals = [];

		foreach (self::$verticalIds as $id) {
			$verticals[$id] = $this->getVerticalName($id);
		}
		return $verticals;
	}
	
	protected function getDefaultTabsNames() {
		return self::$failoverTabsNames;
	}

	protected function prepareIndex($wamWikis, $tabIndex) {
		$wamScoreName = ($tabIndex != self::TAB_INDEX_BIGGEST_GAINERS) ? 'wam' : 'wam_change';
		foreach ($wamWikis as &$wiki) {
			$wamScore = $wiki[$wamScoreName];
			$wiki['change'] = $this->getScoreChangeName($wiki['wam'], $wiki['wam_change']);
			$wiki['wam'] = round($wamScore, self::SCORE_ROUND_PRECISION);
			$wiki['hub_name'] = $this->getVerticalName($wiki['hub_id']);
		}

		return $wamWikis;
	}

	protected function getScoreChangeName($score, $change) {
		$prevScore = $score - $change;
		$score = round($score, self::SCORE_ROUND_PRECISION);
		$prevScore = round($prevScore, self::SCORE_ROUND_PRECISION);
		$wamChange = $score - $prevScore;

		if($wamChange > 0) {
			$out = 'up';
		} elseif($wamChange < 0) {
			$out = 'down';
		} else {
			$out = 'eq';
		}

		return $out;
	}

	protected function getVerticalName($verticalId) {
		/** @var WikiFactoryHub $wikiFactoryHub */
		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$wikiaHub = $wikiFactoryHub->getCategory($verticalId);
		return $this->wf->Message('wam-' . $wikiaHub['name'])->inContentLanguage()->text();
	}

	protected function getVisualizationParams($verticalId = null, $sortColumn = 'wam_index') {
		$params = [
			'vertical_id' => $verticalId,
			'sort_column' => $sortColumn
		];

		return array_merge($params, $this->getDefaultParams());
	}

	protected function getDefaultParams() {
		$lastDay = strtotime('00:00');

		return [
			'wam_day' => $lastDay,
			'wam_previous_day' => strtotime('-1 day', $lastDay),
			'limit' => $this->getVisualizationItemsCount(),
			'sort_direction' => 'DESC',
			'wiki_image_height' => self::VISUALIZATION_ITEM_IMAGE_HEIGHT,
			'wiki_image_width' => self::VISUALIZATION_ITEM_IMAGE_WIDTH,
			'fetch_wiki_images' => true,
		];
	}

	/**
	 * Get wam index parameters
	 *
	 * @param array $params - available keys:
	 * 		searchPhrase
	 * 		verticalId
	 * 		langCode
	 * 		date
	 *
	 * @return array
	 */
	protected function getIndexParams($params) {
		$itemsPerPage = $this->getItemsPerPage();
		$firstPageNo = $this->getFirstPage();
		$page = !empty($params['page']) ? intval($params['page']) : $firstPageNo;
		$offset = ($page > $firstPageNo) ? (($page - 1) * $itemsPerPage) : 0;
		
		$apiParams = [
			'avatar_size' => 21,
			'fetch_admins' => true,
			'limit' => $itemsPerPage,
			'offset' => $offset,
			'sort_column' => 'wam_index',
			'sort_direction' => 'DESC',
			'wiki_word' => isset($params['searchPhrase']) ? $params['searchPhrase'] : null,
			'vertical_id' => isset($params['verticalId']) ? $params['verticalId'] : null,
			'wiki_lang' =>  isset($params['langCode']) ? $params['langCode'] : null,
			'wam_day' => isset($params['date']) ? $params['date'] : null,
		];

		return $apiParams;
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
				'wam'=> '98.499',
				'wam_rank' => '1',
				'hub_wam_rank' => '1',
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
				'admins' => [
						0 => [
							'avatarUrl' => 'http://images4.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/28px-Avatar.jpg',
							'edits' => 0,
							'name' => 'Merovingian',
							'userPageUrl' => 'http://runescape.wikia.com/wiki/User:Merovingian',
							'userContributionsUrl' => 'http://runescape.wikia.com/wiki/Special:Contributions/Merovingian',
							'since' => 'Apr 2005'
						],
						2 => [
							'avatarUrl' => 'http://images4.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/28px-Avatar.jpg',
							'edits' => 0,
							'name' => 'Oddlyoko',
							'userPageUrl' => 'http://runescape.wikia.com/wiki/User:Oddlyoko',
							'userContributionsUrl' => 'http://runescape.wikia.com/wiki/Special:Contributions/Oddlyoko',
							'since' => 'Oct 2005'
						],
						3 => [
							'avatarUrl' => 'http://images3.wikia.nocookie.net/__cb2/common/avatars/thumb/c/c8/15809.png/28px-15809.png',
							'edits' => 0,
							'name' => 'Vimescarrot',
							'userPageUrl' => 'http://runescape.wikia.com/wiki/User:Vimescarrot',
							'userContributionsUrl' => 'http://runescape.wikia.com/wiki/Special:Contributions/Vimescarrot',
							'since' => 'Feb 2006'
						],
						4 => [
							'avatarUrl' => 'http://images4.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/28px-Avatar.jpg',
							'edits' => 0,
							'name' => 'Eucarya',
							'userPageUrl' => 'http://runescape.wikia.com/wiki/User:Eucarya',
							'userContributionsUrl' => 'http://runescape.wikia.com/wiki/Special:Contributions/Eucarya',
							'since' => 'May 2006'
						],
						5 => [
							'avatarUrl' => 'http://images4.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/28px-Avatar.jpg',
							'edits' => 0,
							'name' => 'Hyenaste',
							'userPageUrl' => 'http://runescape.wikia.com/wiki/User:Hyenaste',
							'userContributionsUrl' => 'http://runescape.wikia.com/wiki/Special:Contributions/Hyenaste',
							'since' => 'Jul 2006'
						]
				],
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
				'hub_id' => '3',
				'wam_change' => '0.0039',
				'admins' => [
					2 => [
						'avatarUrl' => 'http://images4.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/28px-Avatar.jpg',
						'edits' => 0,
						'name' => 'Oddlyoko',
						'userPageUrl' => 'http://runescape.wikia.com/wiki/User:Oddlyoko',
						'userContributionsUrl' => 'http://runescape.wikia.com/wiki/Special:Contributions/Oddlyoko',
						'since' => 'Oct 2005'
					],
					3 => [
						'avatarUrl' => 'http://images3.wikia.nocookie.net/__cb2/common/avatars/thumb/c/c8/15809.png/28px-15809.png',
						'edits' => 0,
						'name' => 'Vimescarrot',
						'userPageUrl' => 'http://runescape.wikia.com/wiki/User:Vimescarrot',
						'userContributionsUrl' => 'http://runescape.wikia.com/wiki/Special:Contributions/Vimescarrot',
						'since' => 'Feb 2006'
					],
					4 => [
						'avatarUrl' => 'http://images4.wikia.nocookie.net/__cb2/messaging/images/thumb/1/19/Avatar.jpg/28px-Avatar.jpg',
						'edits' => 0,
						'name' => 'Eucarya',
						'userPageUrl' => 'http://runescape.wikia.com/wiki/User:Eucarya',
						'userContributionsUrl' => 'http://runescape.wikia.com/wiki/Special:Contributions/Eucarya',
						'since' => 'May 2006'
					]
				],
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
				'admins' => [
					3 => [
						'avatarUrl' => 'http://images3.wikia.nocookie.net/__cb2/common/avatars/thumb/c/c8/15809.png/28px-15809.png',
						'edits' => 0,
						'name' => 'Vimescarrot',
						'userPageUrl' => 'http://runescape.wikia.com/wiki/User:Vimescarrot',
						'userContributionsUrl' => 'http://runescape.wikia.com/wiki/Special:Contributions/Vimescarrot',
						'since' => 'Feb 2006'
					]
				],
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
				'hub_id' => '9',
				'wam_change' => '0.0001',
				'admins' => [],
				'wiki_image' => null,
			],
		]];
	}
}
