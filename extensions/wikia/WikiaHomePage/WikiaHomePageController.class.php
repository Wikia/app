<?php

/**
 * WikiaHomePage Controller
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Hyun Lim
 * @author Marcin Maciejewski
 * @author Saipetch Kongkatong
 * @author Sebastian Marzjan
 *
 */
class WikiaHomePageController extends WikiaController {
	static $mwMsgWikiList = 'VisualizationWikisList';
	static $verticalIndicator = '*';
	static $wikiIndicator = '**';
	static $dataSeparator = '|';
	/**
	 * How many wiki data we want for SEO?
	 * @var int
	 */
	static $seoSamplesNo = 17;
	static $seoMemcKeyVer = '1.35';

	//images sizes
	const REMIX_IMG_SMALL_WIDTH = 155;
	const REMIX_IMG_SMALL_HEIGHT = 100;
	const REMIX_IMG_MEDIUM_WIDTH = 320;
	const REMIX_IMG_MEDIUM_HEIGHT = 210;
	const REMIX_IMG_BIG_WIDTH = 320;
	const REMIX_IMG_BIG_HEIGHT = 320;

	// wiki batches
	const WIKI_BATCH_SIZE = 10;

	const hubsImgWidth = 320;
	const hubsImgHeight = 160;

	// values for oasis skin width change to 1030px
	const REMIX_GRID_IMG_SMALL_WIDTH = 160;
	const REMIX_GRID_IMG_SMALL_HEIGHT = 100;
	const REMIX_GRID_IMG_MEDIUM_WIDTH = 330;
	const REMIX_GRID_IMG_MEDIUM_HEIGHT = 210;
	const REMIX_GRID_IMG_BIG_WIDTH = 330;
	const REMIX_GRID_IMG_BIG_HEIGHT = 320;
	const hubsGridImgWidth = 330;
	const hubsGridImgHeight = 160;
	// skin change values end

	const INITIAL_BATCHES_NUMBER = 3;

	//failsafe
	const FAILSAFE_ARTICLE_TITLE = 'Failsafe';

	const DEFAULT_CONTENT_LANG = 'en';

	/**
	 * @var WikiaHomePageHelper
	 */
	protected $helper;
	protected $source = null;
	protected $verticalsSlots = array();
	protected $verticalsWikis = array();

	protected static $collectionsList;

	/**
	 * @var CityVisualization
	 */
	protected $visualization;

	public function __construct() {
		parent::__construct();
		$this->helper = new WikiaHomePageHelper();
	}


	public function index() {
		//cache response on varnish for 1h to enable rolling of stats
		$this->response->setCacheValidity(3600);

		$this->response->addAsset('wikiahomepage_scss');
		$this->response->addAsset('wikiahomepage_js');

		$response = $this->app->sendRequest('WikiaHomePageController', 'getHubImages');
		$this->hubImages = $response->getVal('hubImages', '');

		$this->hubsSlots = $this->prepareHubsSectionSlots();

		JSMessages::enqueuePackage('WikiaHomePage', JSMessages::EXTERNAL);

		$batches = $this->getList();
		$this->wg->Out->addJsConfigVars([
			'wgCollectionsBatches' => $this->getCollectionsWikiList(),
			'wgWikiaBatchesStatus' => $batches['status'],
			'wgInitialWikiBatchesForVisualization' => $batches['batches']
		]);

		$this->lang = self::getContentLang();

		OasisController::addBodyClass('WikiaHome');
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL(
			'extensions/wikia/WikiaHomePage/css/WikiaHomePage.scss'
		));
	}

	/**
	 * Prepare data about hubs to display on Wikia homepage in hubs section
	 *
	 * @return Mixed|null
	 */
	public function prepareHubsSectionSlots() {
		global $wgContLang;
		$langCode = $wgContLang->getCode();

		$hubSlot = WikiaDataAccess::cache(
			WikiaHomePageHelper::getHubSlotsMemcacheKey( $langCode ),
			WikiaDataAccess::CACHE_STANDARD /* 24 hours */,
			function() use( $langCode ) {
				$hubSlot = [];
				$hubsSlots = $this->getHubsSectionSlots();
				$hubsV3List = $this->getHubsV3List( $langCode );

				$hubsSlots = $this->fillEmptyHubSlots( $hubsSlots );

				foreach( $hubsSlots as $slot => &$hub ) {
					$hubId = $hub['hub_slot'];
					if( is_numeric( $hubId ) && isset( $hubsV3List[ $hubId ] ) ) {
						$hubSlot[ $slot ] = $this->prepareHubV3Slot( $hub, $hubsV3List, $slot );
					} else {
						$hubSlot[ $slot ] = $this->prepareHubV2Slot( $hub );
					}
				}

				return $hubSlot;
			}
		);

		return $hubSlot;
	}

	/**
	 * If hub slots are not set, they are filled with hubs v2 data
	 *
	 * @param $hubsSlots
	 * @return mixed
	 */
	private function fillEmptyHubSlots( $hubsSlots ) {
		$verticals = $this->helper->getWikiVerticals();

		$index = 0;
		foreach($verticals as $vertical) {
			if ( !isset( $hubsSlots[ $index ] ) ) {
				$hubsSlots[ $index ] = [
					'hub_slot' => $vertical
				];
			}
			$index++;
		}

		return $hubsSlots;
	}

	/**
	 * Prepare data to display hub v3 slot in hubs section on Wikia homepage
	 *
	 * @param $hub
	 * @param $hubsV3List
	 * @param $slot
	 * @return array
	 */
	private function prepareHubV3Slot( $hub, $hubsV3List, $slot ) {
		$hubId = $hub['hub_slot'];
		$hub = array_merge($hub, $hubsV3List[ $hubId ]);
		$hub['hubImage'] = $this->getHubV3Images( $hubId );

		return $this->prepareRenderParams( $slot, $hub );
	}

	/**
	 * Prepare data to display hub v2 slot in hubs section on Wikia homepage
	 *
	 * @param $hub
	 * @return array|null
	 */
	private function prepareHubV2Slot( $hub ) {
		$hubSlot = null;

		switch( $hub['hub_slot'] ) {
			case 'Video Games':
				$categoryId = WikiFactoryHub::CATEGORY_ID_GAMING;
				$hubSlot = $this->prepareHubsV2Params( 'videogames', $categoryId, $hub );
				break;
			case 'Entertainment':
				$categoryId = WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT;
				$hubSlot = $this->prepareHubsV2Params( 'entertainment', $categoryId, $hub );
				break;
			case 'Lifestyle':
				$categoryId = WikiFactoryHub::CATEGORY_ID_LIFESTYLE;
				$hubSlot = $this->prepareHubsV2Params( 'lifestyle', $categoryId, $hub );
				break;
		}

		return $hubSlot;
	}

	/**
	 * Prepare parameters needed to display data about hub v3 in hub slot on Wikia homepage
	 *
	 * @param $slot slot in hubs section
	 * @param $hub data about hub
	 * @return array
	 */
	private function prepareRenderParams( $slot, $hub ) {
		global $wgParser, $wgTitle, $wgOut;
		return [
			'classname' =>		'hub-slot-' . ($slot + 1),
			'heading' => 		$hub['name'],
			'heroimageurl' => 	$hub['hubImage'],
			'herourl' => 		$hub['url'],
			'creative' => 		$hub['hub_slot_desc'],
			'moreheading' => 	wfMessage('wikiahome-hubs-slot-more-in-heading', $hub['name'])->escaped(),
			'morelist' => 		$wgParser->parse(
							$hub['hub_slot_more_links'],
							$wgTitle,
							$wgOut->parserOptions()
						)->getText(),
		];
	}

	/**
	 * Prepare parameters needed to display data about hub v2 in hub slot on Wikia homepage
	 *
	 * @param $vertical vertical name
	 * @param $categoryId category id
	 * @param $hub data about hub
	 * @return array
	 */
	private function prepareHubsV2Params( $vertical, $categoryId, $hub ) {
		global $wgParser, $wgTitle, $wgOut;
		return [
			'classname' => 		$vertical,
			'heading' => 		WfMessage("wikiahome-hubs-$vertical-heading")->text(),
			'heroimageurl' => 	isset($this->hubImages[$categoryId]) ? $this->hubImages[$categoryId] : null,
			'herourl' => 		WfMessage("wikiahome-hubs-$vertical-url")->text(),
			'creative' => 		!empty( $hub['hub_slot_desc'] )
						? $hub['hub_slot_desc']
						: WfMessage("wikiahome-hubs-$vertical-creative")->text(),
			'moreheading' => 	WfMessage("wikiahome-hubs-$vertical-more-heading")->text(),
			'morelist' => 		!empty( $hub['hub_slot_more_links'] )
						? $wgParser->parse(
							$hub['hub_slot_more_links'],
							$wgTitle, $wgOut->parserOptions())->getText()
						: WfMessage("wikiahome-hubs-$vertical-more-list")->parse()
		];
	}

	public function wikiaMobileIndex() {
		//$this->response->addAsset('extensions/wikia/WikiaHomePage/css/WikiaHomePageMobile.scss');
		$response = $this->app->sendRequest('WikiaHomePageController', 'getHubImages');
		$this->lang = $this->wg->contLang->getCode();
		$this->hubImages = $response->getVal('hubImages', '');
	}

	public function footer() {
		$this->response->addAsset('extensions/wikia/WikiaHomePage/js/CorporateFooterTracker.js');
		$this->interlang = WikiaPageType::isCorporatePage();

		$corporateWikis = $this->helper->getVisualizationWikisData();
		$this->selectedLang = $this->wg->ContLang->getCode();
		$this->dropDownItems = $this->prepareDropdownItems($corporateWikis, $this->selectedLang);

		if ($this->app->wg->EnableWAMPageExt) {
			$wamModel = new WAMPageModel();
			$this->wamPageUrl = $wamModel->getWAMMainPageUrl();
		}
	}

	protected function prepareDropdownItems($corpWikis, $selectedLang) {
		$results = array();

		foreach($corpWikis as $lang => $wiki) {
			if( $lang !== $selectedLang ) {
				$results[] = array(
					'class' => $lang,
					'href' => $wiki['url'],
					'text' => '',
					'title' => $wiki['wikiTitle']
				);
			}
		}

		return $results;
	}

	/**
	 * get stats
	 * @responseParam integer visitors
	 * @responseParam integer edits
	 * @responseParam integer communities
	 * @responseParam integer totalPages
	 */
	public function getStats() {
		wfProfileIn(__METHOD__);

		$memKey = $this->helper->getStatsMemcacheKey();
		$stats = $this->wg->Memc->get($memKey);
		if (empty($stats)) {
			$stats = $this->helper->getStatsIncludingFallbacks();
			$this->wg->Memc->set($memKey, $stats, 60 * 60 * 1);
		}

		foreach ($stats as $key => $value) {
			$this->$key = $this->wg->Lang->formatNum($value);
		}

		if (empty($stats['edits']) && in_array('editsDefault', $stats)) {
			$this->edits = $this->editsDefault . '+';
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * get list of wikis
	 */
	protected function getList() {
		$wikiBatches = $this->helper->getWikiBatches($this->wg->cityId, $this->wg->contLang->getCode(), self::INITIAL_BATCHES_NUMBER);

		if (!empty($wikiBatches)) {
			Wikia::log(__METHOD__, false, ' pulling visualization data from db');
			$status = 'true';
		} else {
			try {
				Wikia::log(__METHOD__, false, ' pulling failover visualization data from message');

				$status = 'false';
				$this->source = $this->getMediaWikiMessage();

				$failoverData = $this->parseSourceMessage();
				$visualization = $this->getVisualization();
				$visualization->generateBatches($this->wg->cityId, $failoverData);
				$wikiBatches = $this->helper->getWikiBatches($this->wg->cityId, $this->wg->contLang->getCode(), self::INITIAL_BATCHES_NUMBER);
			} catch (Exception $e) {
				Wikia::log(__METHOD__, false, ' pulling failover visualization data from file');

				$status = 'false';

				$failoverData = $this->getFailoverWikiList();
				$visualization = $this->getVisualization();
				$visualization->generateBatches($this->wg->cityId, $failoverData);
				$wikiBatches = $this->helper->getWikiBatches($this->wg->cityId, $this->wg->contLang->getCode(), self::INITIAL_BATCHES_NUMBER);
			}
		}
		return ['status' => $status, 'batches' => $wikiBatches];
	}

	/**
	 * Get collections batches
	 *
	 * @return array
	 * $key = collection id
	 * $val = visualization wiki batches
	 */
	protected function getCollectionsWikiList() {
		if (!isset(self::$collectionsList)) {
			$collectionsBatches = [];
			if( $this->wg->EnableWikiaHomePageCollections ) {
				$visualization = $this->getVisualization();

				$collections = new WikiaCollectionsModel();
				$collectionsList = $collections->getListForVisualization($this->wg->ContLang->getCode());

				foreach ($collectionsList as $collection) {
					if (count($collection['wikis']) == WikiaHomePageHelper::SLOTS_IN_TOTAL) {
						$processedCollection = $visualization->getCollectionsWikisData([$collection['id'] => $collection['wikis']])[0];
						$processedCollection['name'] = $collection['name'];
						$processedCollection['id'] = $collection['id'];

						if (!empty($collection['sponsor_hero_image'])) {
							$processedCollection['sponsor_hero_image'] = $collection['sponsor_hero_image'];
						}

						if (!empty($collection['sponsor_image'])) {
							$processedCollection['sponsor_image'] = $collection['sponsor_image'];
						}

						if (!empty($collection['sponsor_url'])) {
							$processedCollection['sponsor_url'] = $collection['sponsor_url'];
						}
						$collectionsBatches[] = $processedCollection;
					}
				}
			}
			self::$collectionsList = $collectionsBatches;
		}

		return self::$collectionsList;
	}

	public function getMediaWikiMessage() {
		$failoverArticle = Title::newFromText(self::$mwMsgWikiList, NS_MEDIAWIKI);

		if( !$failoverArticle->exists() ) {
			throw new Exception('MediaWiki failover message does NOT exist');
		}

		return wfMsgForContent(self::$mwMsgWikiList);
	}

	/**
	 * @desc Gets a random list of wiki name and url for SEO (if the data is small for a vertical the amount of returned wikis here can be lower than self::$seoSamplesNo)
	 * @return array
	 */
	public function getSeoList() {
		wfProfileIn(__METHOD__);

		$list = $this->wg->Memc->get('wikia-home-page-seo-samples' . self::$seoMemcKeyVer);

		if (!is_array($list)) {
			$list = array();

			// get 1 batch for SEO
			$wikiId = $this->wg->cityId;
			$langCode = $this->wg->contLang->getCode();
			$seoBatches = $this->helper->getWikiBatches($wikiId, $langCode, 1);

			// $wikiList is max 17 elements
			if (!empty($seoBatches)) {
				$seoBatch = array_pop($seoBatches);
			}

			if (!empty($seoBatch)) {
				foreach ($seoBatch as $wikiList) {
					foreach ($wikiList as $wiki) {
						if (!empty($wiki['wikiurl'])) {
							$list[] = array(
								'title' => $wiki['wikiname'],
								'url' => $wiki['wikiurl'],
								'wikiid' => $wiki['wikiid'],
							);
						} else {
							$list[] = array(
								'title' => $wiki['wikiname'],
								'url' => '#',
								'wiki-id' => 0,
							);
						}
					}
				}
			} else {
				for ($i = 0; $i < 17; $i++) {
					$list[] = array(
						'title' => '',
						'url' => '#',
						'wiki-id' => 0,
					);
				}
			}

			if (!empty($list)) {
				$this->wg->Memc->set('wikia-home-page-seo-samples' . self::$seoMemcKeyVer, $list, 48 * 60 * 60);
			}
		}

		wfProfileOut(__METHOD__);
		return $list;
	}

	public function getVerticalSlotsForWiki($verticalName) {
		return $this->verticalsSlots[$verticalName];
	}

	public function getWikisInVertical($verticalName) {
		return $this->verticalsWikis[$verticalName];
	}

	/**
	 * @desc Explodes source per line and delegate parsing verticals/wikis data, validates and at the end returns final array
	 *
	 * @throws Exception
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function parseSourceMessage() {
		if (!empty($this->source)) {
			$lines = explode("\n", $this->source);
			$currentVertical = null;
			$data = array();
			foreach ($lines as $line) {
				$line = trim($line);
				if (strpos($line, self::$wikiIndicator) === 0) {
					$wikiData = $this->parseWikiData($line);
					if ($wikiData !== false) {
						$this->verticalsWikis[$currentVertical][] = $wikiData;
					}
				} else {
					$currentVertical = $this->parseVerticalData($line);
				}
			}

			foreach ($this->verticalsWikis as $verticalName => $wikis) {
				$data[$verticalName] = $this->getWikisInVertical($verticalName);
			}

			return $data;
		} else {
			throw new Exception(wfMsg('wikia-home-parse-source-empty-exception'));
		}
	}

	/**
	 * @desc Parses vertical data increments/decrements percentages and returns vertical's name
	 * @param String $data line from the media wiki message
	 * @throws Exception
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function parseVerticalData($data) {
		$data = explode(self::$dataSeparator, $data);

		if (!empty($data[0])) {
			$verticalName = trim(strtolower(str_replace(self::$verticalIndicator, '', $data[0])));

			return $verticalName;
		} else {
			throw new Exception(wfMsg('wikia-home-parse-vertical-invalid-data'));
		}
	}

	/**
	 * @desc Parses wiki data validate and returns an array
	 *
	 * @param String $data line from the media wiki message
	 *
	 * @throws Exception
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function parseWikiData($data) {
		$data = explode(self::$dataSeparator, $data);

		if (count($data) >= 3) {
			$wikiName = trim(str_replace(self::$wikiIndicator, '', $data[0]));
			$wikiUrl = trim($data[1]);
			$wikiDesc = !empty($data[3]) ? trim($data[3]) : '';
			$wikiHot = !empty($data[4]) ? trim($data[4]) : false;
			$wikiNew = !empty($data[5]) ? trim($data[5]) : false;

			$wikiImgName = trim($data[2]);
			$wikiImg = wfFindFile($wikiImgName);

			$wikiId = WikiFactory::UrlToID(trim($wikiUrl));
			if (!$wikiId) {
				$wikiId = 0;
			}

			return array(
				'wikiid' => $wikiId,
				'wikiname' => $wikiName,
				'wikiurl' => $wikiUrl,
				'wikidesc' => $wikiDesc,
				'image' => $wikiImgName,
				'wikinew' => $wikiNew,
				'wikihot' => $wikiHot,
				'wikipromoted' => false,
				'wikiblocked' => false

			);
		} else {
			throw new Exception(wfMsg('wikia-home-parse-wiki-too-few-parameters'));
		}
	}

	/**
	 * get list of images for Hub
	 * @responseParam array hubImages
	 */
	public function getHubImages() {
		$lang = $this->wg->contLang->getCode();

		$hubImages = [];
		if ($this->app->wg->EnableWikiaHubsV2Ext) {
			$hubImages = WikiaDataAccess::cache(
				WikiaHubsServicesHelper::getWikiaHomepageHubsMemcacheKey($lang),
				24 * 60 * 60,
				function () use ($lang) {
					$hubImages = [];

					foreach ($this->app->wg->WikiaHubsV2Pages as $hubId => $hubName) {
						$params = [
							'vertical' => $hubId,
							'lang' => $lang
						];
						$sliderData = $this->getHubSliderData($params);

						$hubImages[$hubId] = isset($sliderData['data']['slides'][0]['photoUrl'])
							? $sliderData['data']['slides'][0]['photoUrl']
							: null;
					}
					return $hubImages;
				}
			);
		}

		$this->hubImages = $hubImages;
	}

	/**
	 * Get first image from slider from selected hub v3
	 *
	 * @param $cityId hub wiki id
	 * @return null|string
	 */
	public function getHubV3Images( $cityId ) {
		$imageUrl = null;

		$sliderData = $this->getHubSliderData( [ 'city' => $cityId ] );

		if ( isset( $sliderData['data']['slides'][0]['photoName'] ) ) {
			$imgName = $sliderData['data']['slides'][0]['photoName'];

			$title = GlobalTitle::newFromText( $imgName, NS_FILE, $cityId );
			if ( $title !== null ) {
				$file = new GlobalFile( $title );
				if ( $file !== null ) {
					$imageUrl = $file->getUrl();
				}
			}
		}

		return $imageUrl;

	}

	protected function getHubSliderData($params) {
		$sliderParams = [
			'module' => MarketingToolboxModuleSliderService::MODULE_ID
		];

		$sliderParams = array_merge( $sliderParams, $params );
		return $this->app->sendRequest(
			'WikiaHubsApi',
			'getModuleData',
			$sliderParams
		)->getData();
	}

	/**
	 * Get list of hubs v3 in selected language
	 *
	 * @param $langCode
	 * @return null
	 */
	private function getHubsV3List( $langCode ) {
		$response = $this->app->sendRequest(
			'WikiaHubsApiController',
			'getHubsV3List',
			[ 'lang' => $langCode ]
		);

		return $response->getVal('list', []);
	}

	private function getHubsSectionSlots() {
		global $wgCityId;
		return $this->helper->getHubSlotsFromWF( $wgCityId );
	}

	/**
	 * Add additional parameter to css url to pass them to scss file
	 *
	 * @param $oasisSettings
	 * @return bool
	 */
	public static function onAfterOasisSettingsInitialized( &$oasisSettings ) {
		global $wgContLang, $wgCityId;

		$settings = [];
		$helper = new WikiaHomePageHelper();

		$response = F::app()->sendRequest(
			'WikiaHubsApiController',
			'getHubsV3List',
			[ 'lang' => $wgContLang->getCode() ]
		);
		$hubsV3List = $response->getVal('list', []);

		$hubsSlots = $helper->getHubSlotsFromWF( $wgCityId );

		foreach( $hubsSlots as $slot => $hub ) {
			$hubId = $hub['hub_slot'];
			if( is_numeric( $hubId ) && isset( $hubsV3List[ $hubId ] ) ) {
				$hubSettings = WikiFactory::getVarValueByName('wgOasisThemeSettings', $hubId);
				$settings['hub-color-slot-' . ($slot+1)] = isset( $hubSettings['color-buttons'] )
					? $hubSettings['color-buttons']
					: null;
			}
		}

		$oasisSettings = array_merge( $oasisSettings, $settings );
		return true;
	}

	/**
	 * draw visualization
	 */
	public function visualization() {
		$this->response->setVal( 'collectionsList', $this->getCollectionsWikiList() );

		$this->response->setVal(
			'seoSample',
			$this->getSeoList()
		);
	}

	/**
	 * renders a single hub section
	 */
	public function renderHubSection() {
		// biz logic here
		$heroUrl = $this->request->getVal('herourl');
		$heroImageUrl = $this->request->getVal('heroimageurl');

		// Don't show HUB if we don't have data ~ we don't have image URL and/or HUB URL
		if ( empty( $heroImageUrl ) || empty( $heroUrl ) ) {
			return false;
		}

		$this->classname = $this->request->getVal('classname');
		$this->heading = $this->request->getVal('heading');
		$this->heroimageurl = $heroImageUrl;
		$this->herourl = $heroUrl;
		$this->creative = $this->request->getVal('creative');
		$this->moreheading = $this->request->getVal('moreheading');
		$this->morelist = $this->request->getVal('morelist');
	}

	/**
	 * @desc get failover data from file
	 * get real file paths
	 * @return String
	 */
	final private function getFailoverWikiList() {
		$this->source = file_get_contents(
			dirname(__FILE__) .
				'/text_files/FailOverWikiList_' .
				strtolower($this->wg->contLang->getCode()) .
				'.txt'
		);

		return $this->parseSourceMessage();
	}

	/**
	 * Get interstitial data.  If format is json, returns data only.  Has template.
	 * @requestParam integer wikiId
	 * @responseParam array wikiAdminAvatars
	 * @responseParam array wikiTopEditorAvatars
	 * @responseParam array wikiStats
	 * @responseParam array wikiInfo
	 */
	public function getInterstitial() {
		$this->response->setCacheValidity( WikiaResponse::CACHE_SHORT );
		$wikiId = $this->request->getVal('wikiId', 0);
		$domain = $this->request->getVal('domain', null);

		if ($wikiId == 0 && $domain != null) {
			// This is not guaranteed valid for all domains, but the custom domains in use have aliases set up
			$domain = "$domain.wikia.com";
			$wikiId = WikiFactory::DomainToId($domain);
			if ($wikiId == 0) {
				throw new InvalidParameterApiException("domain");
			}
		}

		if ($wikiId == 0) {
			throw new MissingParameterApiException("wikiId or domain");
		}

		$this->wikiAdminAvatars = $this->helper->getWikiAdminAvatars($wikiId);
		$this->wikiTopEditorAvatars = $this->helper->getWikiTopEditorAvatars($wikiId);
		$tempArray = array();
		foreach ($this->helper->getWikiStats($wikiId) as $key => $value) {
			$tempArray[$key] = $this->wg->Lang->formatNum($value);
		}
		$this->wikiStats = $tempArray;
		$this->wikiInfo = $this->helper->getWikiInfoForVisualization($wikiId, $this->wg->contLang->getCode());
		$images = array();

		foreach ($this->wikiInfo['images'] as $image) {
			$images[] = $this->helper->getImageDataForSlider($wikiId, $image);
		}

		if (!empty($images[0])) {
			$this->wikiMainImageUrl = $images[0]['image_url'];
		} else {
			$this->wikiMainImageUrl = $this->wg->blankImgUrl;
		}

		if (!empty($this->app->wg->EnableWAMPageExt)) {
			$wamModel = new WAMPageModel();
			$this->wamUrl = $wamModel->getWAMMainPageUrl();

			$this->wikiWamScore = $this->helper->getWamScore($wikiId);
		}

		$this->imagesSlider = $this->sendRequest('WikiaMediaCarouselController', 'renderSlider', array('data' => $images));

		$wordmarkUrl = '';
		try {
			$title = GlobalTitle::newFromText('Wiki-wordmark.png', NS_FILE, $wikiId);
			if ( $title !== null ) {
				$file = new GlobalFile($title);
				if ( $file !== null ) {
					$wordmarkUrl = $file->getUrl();
				}
			}
		} catch ( Exception $e ) { }

		$this->wordmark = $wordmarkUrl;

	}

	public static function onGetHTMLAfterBody($skin, &$html) {
		$app = F::app();

		if ($app->checkSkin('wikiamobile') && $app->wg->EnableWikiaHomePageExt && WikiaPageType::isMainPage()) {
			$html .= $app->sendRequest('WikiaHomePage', 'wikiaMobileIndex')->toString();
		}
		return true;
	}

	public static function onOutputPageBeforeHTML(OutputPage &$out, &$text) {
		if (WikiaPageType::isMainPage() && !(F::app()->checkSkin('wikiamobile'))) {
			$text = '';
			$out->clearHTML();
			$out->addHTML(F::app()->sendRequest('WikiaHomePageController', 'index')->toString());
		}
		return $out;
	}

	public static function onArticleCommentCheck($title) {
		if (WikiaPageType::isMainPage()) {
			return false;
		}
		return true;
	}

	public static function onWikiaMobileAssetsPackages(Array &$jsStaticPackages, Array &$jsExtensionPackages, Array &$scssPackages) {
		//this hook is fired only by the WikiaMobile skin, no need to check for what skin is being used
		if (F::app()->wg->EnableWikiaHomePageExt && WikiaPageType::isMainPage()) {
			$scssPackages[] = 'wikiahomepage_scss_wikiamobile';
		}

		return true;
	}

	public static function onAfterGlobalHeader(&$menuNodes, $category, $messageName) {
		if (!empty($menuNodes) && isset($category->cat_id) && $category->cat_id == WikiFactoryHub::CATEGORY_ID_CORPORATE) {
			foreach ($menuNodes as $key => $node) {
				if (!empty($node['specialAttr'])) {
					$menuNodes[$key]['class'] = $node['specialAttr'];
				}
			}
		}

		return true;
	}

	public static function onGetRailModuleList(&$railModuleList) {
		$railModuleList = [
			1500 => ['Search', 'Index', null],
		];

		return true;
	}

	public function getWikiBatchesForVisualization() {
		$numberOfBatches = $this->request->getVal('numberOfBatches', self::WIKI_BATCH_SIZE);
		$wikiId = $this->wg->cityId;
		$langCode = $this->wg->contLang->getCode();

		$this->wikis = $this->helper->getWikiBatches($wikiId, $langCode, $numberOfBatches);
	}

	public function getHubsImgWidth() {
		if (!empty($this->wg->OasisGrid)) {
			return self::hubsGridImgWidth;
		} else {
			return self::hubsImgWidth;
		}
	}

	public function getHubsImgHeight() {
		if (!empty($this->wg->OasisGrid)) {
			return self::hubsGridImgHeight;
		} else {
			return self::hubsImgHeight;
		}

	}

	private function getVisualization() {
		if( is_null($this->visualization) ) {
			$this->visualization = new CityVisualization();
		}

		return $this->visualization;
	}

	public static function onBeforePageDisplay( OutputPage &$out, &$skin ) {

		OasisController::addBodyClass( 'wikia-contentlang-' . self::getContentLang() );

		return true;
	}

	/**
	 * Gets language variable to get proper sprite image.
	 * If corporate page exists for passed language code this code is returned
	 * otherwise default language is returned.
	 *
	 *
	 * @returns string User language code
	 */
	private static function getContentLang() {
		global $wgLang;
		$lang = $wgLang->getCode();

		$corpLangsList = ( new CityVisualization() )->getVisualizationWikisData();
		if ( !array_key_exists($lang, $corpLangsList) ) {
			$lang = self::DEFAULT_CONTENT_LANG;
		}
		return $lang;
	}
}
