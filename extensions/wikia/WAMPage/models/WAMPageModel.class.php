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

	static protected $verticalIds = [
		WikiFactoryHub::VERTICAL_ID_OTHER,
		WikiFactoryHub::VERTICAL_ID_COMICS,
		WikiFactoryHub::VERTICAL_ID_TV,
		WikiFactoryHub::VERTICAL_ID_MOVIES,
		WikiFactoryHub::VERTICAL_ID_MUSIC,
		WikiFactoryHub::VERTICAL_ID_BOOKS,
		WikiFactoryHub::VERTICAL_ID_VIDEO_GAMES,
		WikiFactoryHub::VERTICAL_ID_LIFESTYLE,
	];

	public function __construct() {
		parent::__construct();

		if ( is_null( $this->config ) ) {
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
	public function getVisualizationWikis( $iVerticalId ) {
		$aParams = $this->getVisualizationParams( $iVerticalId );
		$WAMData = $this->app->sendRequest( 'WAMApi', 'getWAMIndex', $aParams )->getData();

		return $this->prepareIndex( $WAMData[ 'wam_index' ], self::TAB_INDEX_BIGGEST_GAINERS );
	}


	protected function getVisualizationParams( $iVerticalId = 0 ) {
		$aParams = [
			'vertical_id' => intval( $iVerticalId ),
			'sort_column' => 'wam_change',
			'limit' => $this->getVisualizationItemsCount(),
			'sort_direction' => 'DESC',
			'wiki_image_height' => self::VISUALIZATION_ITEM_IMAGE_HEIGHT,
			'wiki_image_width' => self::VISUALIZATION_ITEM_IMAGE_WIDTH,
			'fetch_wiki_images' => true,
		];

		return $aParams;
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
	public function getIndexWikis( Array $aParams ) {
		$aParams = $this->getIndexParams( $aParams );
		$WAMData = $this->app->sendRequest( 'WAMApi', 'getWAMIndex', $aParams )->getData();
		$WAMData['wam_index'] = $this->prepareIndex( $WAMData['wam_index'], self::TAB_INDEX_TOP_WIKIS );

		return $WAMData;
	}

	public function getMinMaxIndexDate() {
		$aDates = $this->app->sendRequest( 'WAMApi', 'getMinMaxWamIndexDate' )->getData();
		if ( isset( $aDates['min_max_dates'] ) ) {
			$aDates = $aDates['min_max_dates'];

			// Set max date as previous day, because we don't have previous data
			if ( !empty( $aDates['max_date'] ) ) {
				$aDates['max_date'] -= 60 * 60 * 24;
			}
		} else {
			$aDates = [
				'min_date' => null,
				'max_date' => null,
			];
		}
		return $aDates;
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

	public function getWamPagesDbKeysMap() {
		if( is_null( $this->pagesMap ) ) {
			$this->pagesMap = [];
			$pageName = $this->getWAMMainPageName();
			$this->pagesMap[mb_strtolower( $pageName )] = $pageName;
			$this->pagesMap[mb_strtolower( $this->getWAMFAQPageName() )] = $this->getWAMFAQPageName();
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

	/**
	 * Get verticals' machine-friendly names
	 * @return array  An [ id => short ] array
	 */
	public function getVerticalsShorts() {
		$aVerticalsShorts = [
			WikiFactoryHub::VERTICAL_ID_OTHER => 'all',
		];
		$oWikiFactoryHub = WikiFactoryHub::getInstance();
		$aVerticals = $oWikiFactoryHub->getAllVerticals();
		foreach ( $aVerticals as $iVerticalId => $aVerticalData ) {
			if ( $iVerticalId !== WikiFactoryHub::VERTICAL_ID_OTHER ) {
				$aVerticalsShorts[$iVerticalId] = $aVerticalData['short'];
			}
		}
		return $aVerticalsShorts;
	}

	/**
	 * Generate message keys from verticals' short names:
	 * wam-all, wam-tv, wam-games, wam-books, wam-comics, wam-lifestyle,
	 * wam-music, wam-movies (see WAMPage.i18n.php)
	 * @param  Array  $aShorts An array of verticals' short names
	 * @return Array           An array of message keys
	 */
	public function generateVerticalsNamesMsgKeys( $aShortNames ) {
		$aMsgKeys = [];
		foreach ( $aShortNames as $iCityId => $sShortName ) {
			$aMsgKeys[$iCityId] = "wam-{$sShortName}";
		}
		return $aMsgKeys;
	}

	protected function prepareIndex( $aWamWikis, $iTabIndex ) {
		$sWamScoreName = ( $iTabIndex != self::TAB_INDEX_BIGGEST_GAINERS ) ? 'wam' : 'wam_change';
		foreach ( $aWamWikis as &$aWiki ) {
			$fWamScore = $aWiki[ $sWamScoreName ];
			$aWiki['change'] = $this->getScoreChangeName( $aWiki['wam'], $aWiki['wam_change'] );
			$aWiki['wam'] = round( $fWamScore, self::SCORE_ROUND_PRECISION );
			$aWiki['verticalId'] = $this->getVerticalName( $aWiki['vertical_id'] );
		}

		return $aWamWikis;
	}

	protected function getScoreChangeName($fScore, $fChange) {
		$fPrevScore = $fScore - $fChange;
		$fScore = round( $fScore, self::SCORE_ROUND_PRECISION );
		$fPrevScore = round( $fPrevScore, self::SCORE_ROUND_PRECISION );
		$fWamChange = $fScore - $fPrevScore;

		if( $fWamChange > 0 ) {
			$sOut = 'up';
		} elseif( $fWamChange < 0 ) {
			$sOut = 'down';
		} else {
			$sOut = 'eq';
		}

		return $sOut;
	}

	protected function getVerticalName( $iVerticalId ) {
		$oWikiFactoryHub = WikiFactoryHub::getInstance();
		$aAllVerticals = $oWikiFactoryHub->getAllVerticals();
		if ( isset( $aAllVerticals[ $iVerticalId ] ) ) {
			$aVertical = $aAllVerticals[ $iVerticalId ];
			return wfMessage( 'wam-' . $aVertical['short'] )->inContentLanguage()->escaped();
		} else {
			return false;
		}
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
	protected function getIndexParams( Array $aParams ) {
		$iItemsPerPage = $this->getItemsPerPage();
		$iFirstPageNo = $this->getFirstPage();
		$iPage = !empty( $aParams['page'] ) ? intval( $aParams['page'] ) : $iFirstPageNo;
		$iOffset = ( $iPage > $iFirstPageNo ) ? ( ($iPage - 1) * $iItemsPerPage ) : 0;

		$aApiParams = [
			'avatar_size' => 21,
			'fetch_admins' => true,
			'limit' => $iItemsPerPage,
			'offset' => $iOffset,
			'sort_column' => 'wam_index',
			'sort_direction' => 'DESC',
			'wiki_word' => isset( $aParams['searchPhrase'] ) ? $aParams['searchPhrase'] : null,
			'vertical_id' => isset( $aParams['verticalId'] ) ? $aParams['verticalId'] : null,
			'wiki_lang' =>  isset( $aParams['langCode'] ) ? $aParams['langCode'] : null,
			'wam_day' => isset( $aParams['date'] ) ? $aParams['date'] : null,
		];

		return $aApiParams;
	}

	/**
	 * Convert filter params to query params ready to be concatenated.
	 *
	 * @param $filterParams - filter params passed from controller
	 *
	 * @return string
	 */
	private function getParamsAsQuery( $filterParams ) {
		$sQueryParams = [];

		foreach ( $filterParams as $key => $value ) {
			if ( !empty( $value ) ) {
				$sQueryParams[ $key ] = $value;
			}
		}

		return count( $sQueryParams ) ? '?' . http_build_query( $sQueryParams ) : '';
	}

	/**
	 * Check if title is WAM page or subPage
	 *
	 * @param $oTitle
	 * @return bool
	 */
	public function isWAMPage( $oTitle ) {
		wfProfileIn( __METHOD__ );
		$dbKey = null;

		if( $oTitle instanceof Title ) {
			$dbKey = mb_strtolower( $oTitle->getDBKey() );
		}

		wfProfileOut( __METHOD__ );
		return in_array( $dbKey, array_keys($this->getWamPagesDbKeysMap() ) );
	}

	protected function getTitleFromText( $text ) {
		return Title::newFromText( $text );
	}
}
