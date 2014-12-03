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

	/**
	 * @desc Cache for config array from WikiFactory
	 *
	 * @var mixed|null
	 */
	protected $config = null;

	/**
	 * @desc Cache for db key maps where the key is lower-case dbkey and value is just dbkey
	 *
	 * @var null
	 */
	protected $pagesMap = null;

	static protected $failoverTabsNames = [
		self::TAB_INDEX_TOP_WIKIS => 'Top wikias',
		self::TAB_INDEX_BIGGEST_GAINERS => 'The biggest gainers',
		self::TAB_INDEX_GAMING => 'Top video games wikias',
		self::TAB_INDEX_ENTERTAINMENT => 'Top entertainment wikias',
		self::TAB_INDEX_LIFESTYLE => 'Top lifestyle wikias'
	];

	static protected $verticalIds = [
		// WikiFactoryHub::CATEGORY_ID_GAMING,
		// WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT,
		// WikiFactoryHub::CATEGORY_ID_LIFESTYLE
		WikiFactoryHub::HUB_ID_OTHER,
		WikiFactoryHub::HUB_ID_TV,
		WikiFactoryHub::HUB_ID_VIDEO_GAMES,
		WikiFactoryHub::HUB_ID_BOOKS,
		WikiFactoryHub::HUB_ID_COMICS,
		WikiFactoryHub::HUB_ID_LIFESTYLE,
		WikiFactoryHub::HUB_ID_MUSIC,
		WikiFactoryHub::HUB_ID_MOVIES,
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
	public function getVisualizationWikis( $tabIndex ) {
		switch( $tabIndex ) {
			case self::TAB_INDEX_BIGGEST_GAINERS: $params = $this->getVisualizationParams( null, 'wam_change' ); break;
			case self::TAB_INDEX_GAMING: $params = $this->getVisualizationParams( WikiFactoryHub::CATEGORY_ID_GAMING ); break;
			case self::TAB_INDEX_ENTERTAINMENT: $params = $this->getVisualizationParams( WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT ); break;
			case self::TAB_INDEX_LIFESTYLE: $params = $this->getVisualizationParams( WikiFactoryHub::CATEGORY_ID_LIFESTYLE ); break;
			default: $params = $this->getVisualizationParams(); break;
		}

		$WAMData = $this->app->sendRequest( 'WAMApi', 'getWAMIndex', $params )->getData();

		return $this->prepareIndex( $WAMData[ 'wam_index' ], $tabIndex );
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
	public function getIndexWikis( $params ) {
		$params = $this->getIndexParams( $params );
		$WAMData = $this->app->sendRequest( 'WAMApi', 'getWAMIndex', $params )->getData();
		$WAMData['wam_index'] = $this->prepareIndex( $WAMData['wam_index'], self::TAB_INDEX_TOP_WIKIS );

		return $WAMData;
	}

	public function getMinMaxIndexDate() {
		$dates = $this->app->sendRequest('WAMApi', 'getMinMaxWamIndexDate')->getData();
		if (isset($dates['min_max_dates'])) {
			$dates = $dates['min_max_dates'];

			// Set min date as next day, because we don't have previous data
			if (!empty($dates['min_date'])) {
				$dates['min_date'] += 60 * 60 * 24;
			}
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

	public function getWAMMainPageUrl($filterParams = array()) {
		$title = $this->getTitleFromText($this->getWAMMainPageName());

		return ($title instanceof Title) ? $title->getFullUrl().$this->getParamsAsQuery($filterParams) : null;
	}

	/**
	 * @desc Checks if given title is a WAM page/subpage and if it is returns its url
	 *
	 * @param Title $title instance of class Title
	 * @param bool $fullUrl flag which informs method to return full url by default or local url when false passed
	 *
	 * @return string
	 */
	public function getWAMSubpageUrl(Title $title, $fullUrl = true) {
		if( $this->isWAMPage($title) ) {
			$dbkeysMap = $this->getWamPagesDbKeysMap();
			$dbkeyLower = mb_strtolower($title->getDBKey());
			$wamPageDbkey = isset($dbkeysMap[$dbkeyLower]) ? $dbkeysMap[$dbkeyLower] : false;

			if( $wamPageDbkey ) {
				$title = $this->getTitleFromText($wamPageDbkey);
			}
		}

		$url = ($fullUrl) ? $title->getFullUrl() : $title->getLocalURL();

		return $url;
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
	 * @desc Return proper string for subtitleText - it's same as in tabs.
	 *
	 * @param int $tabIndex tab index
	 * @param string $defaultTitle fallback title
	 *
	 * @return string
	 */
	public function getSubpageTextByIndex($tabIndex, $defaultTitle) {
		$tabs = $this->getTabs();
		$tabIndex = (int)$tabIndex; // first tab has 'false' as tabIndex

		// we don't have that index - return default title
		return isset($tabs[$tabIndex]['name']) ? $tabs[$tabIndex]['name'] : $defaultTitle;
	}

	/**
	 * @desc Returns array with tab names and urls by default it's in English taken from global variable $wgWAMPageConfig['tabsNames']
	 *
	 * @param int $selectedIdx array index of selected tab
	 * @params array $filterParams filter params
	 */
	public function getTabs($selectedIdx = 0, $filterParams = array()) {
		$tabs = [];
		$pageName = $this->getWAMMainPageName();
		$tabsNames = $this->getTabsNamesArray();
		$filterParamsQueryString = $this->getParamsAsQuery($filterParams);

		foreach($tabsNames as $tabName) {
			$tabTitle = $this->getTitleFromText($pageName . '/'. $tabName);
			$tabUrl = $tabTitle->getLocalURL() . $filterParamsQueryString;
			$tabs[] = ['name' => $tabName, 'url' => $tabUrl];
		}

		if( !empty($tabs[$selectedIdx]) ) {
			$tabs[$selectedIdx]['selected'] = true;
		}

		return $tabs;
	}

	public function getWamPagesDbKeysMap() {
		if( is_null($this->pagesMap) ) {
			$this->pagesMap = [];
			$pageName = $this->getWAMMainPageName();

			foreach($this->getTabsNamesArray() as $tabName) {
				$tabTitle = $this->getTitleFromText($pageName . '/'. $tabName);
				$this->pagesMap[mb_strtolower($tabTitle->getDBKey())] = $tabTitle->getDBKey();
			}

			$this->pagesMap[mb_strtolower($pageName)] = $pageName;
			$this->pagesMap[mb_strtolower($this->getWAMFAQPageName())] = $this->getWAMFAQPageName();
		}

		return $this->pagesMap;
	}

	/**
	 * Get all WAM languages for a specified day for filters
	 *
	 * @return array
	 */
	public function getWAMLanguages( $date ) {
		$result = $this->app->sendRequest( 'WAMApi', 'getWAMLanguages', [ 'wam_day' => $date ] )->getData();
		return $result[ 'languages' ];
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
			$wiki['verticalId'] = $this->getVerticalName( $wiki['vertical_id'] );
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

	protected function getVerticalName( $verticalId ) {
		/** @var WikiFactoryHub $wikiFactoryHub */
		$oWikiFactoryHub = WikiFactoryHub::getInstance();
		// $wikiaHub = $wikiFactoryHub->getCategory($verticalId);
		$aAllVerticals = $oWikiFactoryHub->getAllVerticals();
		if ( isset( $aAllVerticals[ $verticalId ] ) ) {
			$aVertical = $aAllVerticals[ $verticalId ];
			return wfMessage( 'wam-' . $aVertical['short'] )->inContentLanguage()->text();
		} else {
			return false;
		}
	}

	protected function getVisualizationParams($verticalId = null, $sortColumn = 'wam_index') {
		$params = [
			'vertical_id' => $verticalId,
			'sort_column' => $sortColumn,
			'limit' => $this->getVisualizationItemsCount(),
			'sort_direction' => 'DESC',
			'wiki_image_height' => self::VISUALIZATION_ITEM_IMAGE_HEIGHT,
			'wiki_image_width' => self::VISUALIZATION_ITEM_IMAGE_WIDTH,
			'fetch_wiki_images' => true,
		];

		return $params;
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
			'verticalId' => isset($params['verticalId']) ? $params['verticalId'] : null,
			'wiki_lang' =>  isset($params['langCode']) ? $params['langCode'] : null,
			'wam_day' => isset($params['date']) ? $params['date'] : null,
		];

		return $apiParams;
	}

	/**
	 * Convert filter params to query params ready to be concatenated.
	 *
	 * @param $filterParams - filter params passed from controller
	 *
	 * @return string
	 */
	private function getParamsAsQuery($filterParams) {
		$queryParams = array();

		foreach ( $filterParams as $key => $value ) {
			if ( !empty($value) ) {
				$queryParams[$key] = $value;
			}
		}

		return count($queryParams) ? '?'.http_build_query($queryParams) : '';
	}

	/**
	 * Check if title is WAM page or subPage
	 *
	 * @param $title
	 * @return bool
	 */
	public function isWAMPage($title) {
		wfProfileIn(__METHOD__);
		$dbKey = null;

		if( $title instanceof Title ) {
			$dbKey = mb_strtolower( $title->getDBKey() );
		}

		wfProfileOut(__METHOD__);
		return in_array($dbKey, array_keys($this->getWamPagesDbKeysMap()));
	}

	protected function getTitleFromText($text) {
		return Title::newFromText($text);
	}
}
