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

	const INITIAL_BATCHES_NUMBER = 5;

	//failsafe
	const FAILSAFE_ARTICLE_TITLE = 'Failsafe';

	const HUBS_IMAGES_MEMC_KEY_VER = '1.02';

	/**
	 * @var WikiaHomePageHelper
	 */
	protected $helper;
	protected $source = null;
	protected $verticalsSlots = array();
	protected $verticalsWikis = array();

	public function __construct() {
		parent::__construct();
		$this->helper = F::build('WikiaHomePageHelper');
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/WikiaHomePage/css/WikiaHomePage.scss'));
	}

	public function index() {
		//cache response on varnish for 1h to enable rolling of stats
		$this->response->setCacheValidity(3600, 3600, array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH));

		$this->response->addAsset('wikiahomepage_scss');
		$this->response->addAsset('wikiahomepage_js');

		$response = $this->app->sendRequest('WikiaHomePageController', 'getHubImages');
		$this->hubImages = $response->getVal('hubImages', '');
		$this->lang = $this->wg->contLang->getCode();
		F::build('JSMessages')->enqueuePackage('WikiaHomePage', JSMessages::EXTERNAL);
	}

	public function wikiaMobileIndex() {
		//$this->response->addAsset('extensions/wikia/WikiaHomePage/css/WikiaHomePageMobile.scss');
		$response = $this->app->sendRequest('WikiaHomePageController', 'getHubImages');
		$this->lang = $this->wg->contLang->getCode();
		$this->hubImages = $response->getVal('hubImages', '');
	}

	public function footer() {
		$this->response->addAsset('extensions/wikia/WikiaHomePage/js/CorporateFooterTracker.js');
		$this->interlang = HubService::isCorporatePage($this->wg->cityId);
	}

	/**
	 * get stats
	 * @responseParam integer visitors
	 * @responseParam integer edits
	 * @responseParam integer communities
	 * @responseParam integer totalPages
	 */
	public function getStats() {
		$this->wf->ProfileIn(__METHOD__);

		$memKey = $this->wf->SharedMemcKey('wikiahomepage', 'stats', $this->wg->contLang->getCode());
		$stats = $this->wg->Memc->get($memKey);
		if (empty($stats)) {
			$stats['visitors'] = $this->helper->getStatsFromArticle('StatsVisitors');

			$stats['edits'] = $this->helper->getEdits();
			if (empty($stats['edits'])) {
				$stats['editsDefault'] = $this->helper->getStatsFromArticle('StatsEdits');
			}

			$stats['communities'] = $this->helper->getStatsFromArticle('StatsCommunities');

			$defaultTotalPages = $this->helper->getStatsFromArticle('StatsTotalPages');
			$totalPages = intval(Wikia::get_content_pages());
			$stats['totalPages'] = ($totalPages > $defaultTotalPages) ? $totalPages : $defaultTotalPages;

			$this->wg->Memc->set($memKey, $stats, 60 * 60 * 1);
		}

		foreach ($stats as $key => $value) {
			$this->$key = $this->wg->Lang->formatNum($value);
		}

		$this->communities = $this->communities . '+';
		if (empty($stats['edits']) && in_array('editsDefault', $stats)) {
			$this->edits = $this->editsDefault . '+';
		}

		$this->wf->ProfileOut(__METHOD__);
	}

	/**
	 * get list of wikis
	 */
	public function getList() {
		$wikiBatches = $this->helper->getWikiBatches($this->wg->cityId, $this->wg->contLang->getCode(), self::INITIAL_BATCHES_NUMBER);
		if (!empty($wikiBatches)) {
			Wikia::log(__METHOD__, false, ' pulling visualization data from db');
			$status = 'true';
			$this->response->setVal('initialWikiBatchesForVisualization', json_encode($wikiBatches));
		} else {
			try {
				Wikia::log(__METHOD__, false, ' pulling failover visualization data from message');
				$status = 'false';
				$this->source = $this->getMediaWikiMessage();

				$failoverData = $this->parseSourceMessage();
				$visualization = F::build('CityVisualization');
				/** @var $visualization CityVisualization */
				$visualization->generateBatches($this->wg->cityId, $this->wg->contLang->getCode(), $failoverData, true);
				$failoverBatches = $this->helper->getWikiBatches($this->wg->cityId, $this->wg->contLang->getCode(), self::INITIAL_BATCHES_NUMBER);

				$this->response->setVal('initialWikiBatchesForVisualization', json_encode($failoverBatches));
			} catch (Exception $e) {
				Wikia::log(__METHOD__, false, ' pulling failover visualization data from file');
				$status = 'false';

				$failoverData = $this->getFailoverWikiList();
				$visualization = F::build('CityVisualization');
				$visualization->generateBatches($this->wg->cityId, $this->wg->contLang->getCode(), $failoverData, true);
				$failoverBatches = $this->helper->getWikiBatches($this->wg->cityId, $this->wg->contLang->getCode(), self::INITIAL_BATCHES_NUMBER);

				$this->response->setVal('initialWikiBatchesForVisualization', json_encode($failoverBatches));
				$this->response->setVal('exception', $e->getMessage());
			}
		}
		$this->response->setVal('wgWikiaBatchesStatus', $status);
	}

	public function getMediaWikiMessage() {
		return wfMsgForContent(self::$mwMsgWikiList);
	}

	/**
	 * @desc Gets a random list of wiki name and url for SEO (if the data is small for a vertical the amount of returned wikis here can be lower than self::$seoSamplesNo)
	 * @return array
	 */
	public function getSeoList() {
		$this->wf->ProfileIn(__METHOD__);

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

		$this->wf->ProfileOut(__METHOD__);
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
			$wikiImg = $this->wf->FindFile($wikiImgName);

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
		$memKey = $this->wf->SharedMemcKey('wikiahomepage', 'hubimages', $this->wg->contLang->getCode(), self::HUBS_IMAGES_MEMC_KEY_VER);
		$hubImages = $this->wg->Memc->get($memKey);

		if (empty($hubImages)) {
			$hubImages = $this->getHubImageUrls();
			$this->wg->Memc->set($memKey, $hubImages, 60 * 60 * 24);
		}

		$this->hubImages = $hubImages;
	}

	protected function getHubImageUrls() {
		$hubImages = array();

		foreach ($this->wg->wikiaHubsPages as $groupId => $hubGroup) {
			if (!empty($hubGroup[0])) {
				$hubName = $hubGroup[0];
				$hubEngName = $this->getEnglishHubName($groupId);
				$hubImages[$hubEngName] = $this->getImageUrlForHub($hubName);
			}
		}
		return $hubImages;
	}

	protected function getEnglishHubName($hubId) {
		switch ($hubId) {
			case 1:
				return 'Lifestyle';
				break;
			case 2:
				return 'Video_Games';
				break;
			case 3:
			default:
				return 'Entertainment';
				break;
		}
	}

	protected function getImageUrlForHub($hubName) {
		$hubImage = '';

		$lines = $this->getLinesFromHubGallerySlider($hubName);

		// either we have the gallery content in $lines or that an empty array
		foreach ($lines as $line) {
			$hubImage = $this->getHubImageFromGalleryTagLine($line);
			if (!empty($hubImage)) {
				break;
			}
		}
		return $hubImage;
	}

	protected function getLinesFromHubGallerySlider($hubName) {
		$content = $this->getRawArticleContent($hubName);
		$lines = $this->extractMosaicGalleryImages($content);

		if (empty($lines)) {
			// no gallery tag found directly in hub, so there is possibility of transclusion
			$transcludedContent = $this->getTranscludedArticleForTodaysHub($hubName);
			$lines = $this->extractMosaicGalleryImages($transcludedContent);
		}

		if (empty($lines)) {
			$failsafeTranscludedContent = $this->getFailsafeArticleForTodaysHub($hubName);
			$lines = $this->extractMosaicGalleryImages($failsafeTranscludedContent);
		}

		return $lines;
	}

	protected function getHubImageFromGalleryTagLine($line) {
		$hubImage = '';
		$imageName = $this->getImageNameFromGalleryTagLine($line);

		if (!empty($imageName)) {
			$hubImage = $this->getImageUrlFromString($imageName);
		}
		return $hubImage;
	}

	protected function getImageUrlFromString($imageName) {
		$imageUrl = $this->helper->getImageUrl($imageName, $this->getHubsImgWidth(), $this->getHubsImgHeight());
		return $imageUrl;
	}

	protected function getImageNameFromGalleryTagLine($line) {
		$line = trim($line);
		if ($line == '') {
			return false;
		}

		$parts = (array)StringUtils::explode('|', $line);
		$imageName = array_shift($parts);
		if (strpos($line, '%') !== false) {
			$imageName = urldecode($imageName);
			return $imageName;
		}
		return $imageName;
	}

	protected function getRawArticleContent($hubname) {
		$title = F::build('Title', array($hubname), 'newFromText');
		$article = F::build('Article', array($title));
		$content = $article->getRawText();
		return $content;
	}

	protected function getTranscludedArticleForTodaysHub($hubname) {
		$today = wfMsgExt('wikiahome-hub-current-day',array('parseinline'));
		$transcludedArticleName = $hubname . "/" . $today;
		return $this->getRawArticleContent($transcludedArticleName);
	}

	protected function getFailsafeArticleForTodaysHub($hubname) {
		$failsafe = self::FAILSAFE_ARTICLE_TITLE;
		$failsafeArticleName = $hubname . "/" . $failsafe;
		return $this->getRawArticleContent($failsafeArticleName);
	}

	/**
	 * draw visualization
	 */
	public function visualization() {
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
		$this->classname = $this->request->getVal('classname');
		$this->heading = $this->request->getVal('heading');
		$this->heroimageurl = $this->request->getVal('heroimageurl');
		$this->herourl = $this->request->getVal('herourl');
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
		$wikiId = $this->request->getVal('wikiId', 0);
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

		$this->imagesSlider = $this->sendRequest('WikiaMediaCarouselController', 'renderSlider', array('data' => $images));
	}

	/**
	 * Returns lines of text contained inside mosaic slider gallery tag
	 * @param $articleText
	 * @return array
	 */
	protected function extractMosaicGalleryImages($articleText) {
		$lines = array();

		if (preg_match('/\<gallery.+mosaic.+\>([\s\S]+)\<\/gallery\>/', $articleText, $matches)) {
			$lines = StringUtils::explode("\n", $matches[1]);
		}
		return $lines;
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

	public static function onWikiaMobileAssetsPackages(Array &$jsHeadPackages, Array &$jsBodyPackages, Array &$scssPackages) {
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
}
