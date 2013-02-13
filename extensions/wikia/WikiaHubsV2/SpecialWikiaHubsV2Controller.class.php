<?php

/**
 * Hubs V2 Controller
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

class SpecialWikiaHubsV2Controller extends WikiaSpecialPageController {
	const CACHE_VALIDITY_BROWSER = 86400;
	const CACHE_VALIDITY_VARNISH = 86400;

	/**
	 * @var WikiaHubsV2Model
	 */
	protected $model;

	protected $format;
	protected $verticalId;
	protected $verticalName;

	public function __construct() {
		parent::__construct('WikiaHubsV2','',false);
	}

	public function index() {
		if($this->format == 'json') {
			$this->slider = $this->model->getDataForModuleSlider();
			$this->pulse = $this->model->getDataForModulePulse();
			$this->tabber = $this->model->getDataForModuleTabber();
			$this->explore = $this->model->getDataForModuleExplore();
			$this->featuredvideo = $this->model->getDataForModuleFeaturedVideo();
			$this->wikitextmoduledata = $this->model->getDataForModuleWikitext();
			$this->topwikis = $this->model->getDataForModuleTopWikis();
			$this->popularvideos = $this->model->getDataForModulePopularVideos();
			$this->fromthecommunity = $this->model->getDataForModuleFromTheCommunity();
		}
		$this->response->addAsset('wikiahubs_v2');
		$this->response->addAsset('wikiahubs_v2_modal');
		$this->response->addAsset('wikiahubs_v2_scss');
		$this->response->addAsset('wikiahubs_v2_scss_mobile');
		if (F::app()->checkSkin('wikiamobile')) {
			$this->overrideTemplate('wikiamobileindex');
		}
	}

	public function slider() {
		/** @var $sliderModule WikiaHubsV2SliderModule */
		$sliderModule = F::build('WikiaHubsV2SliderModule');
		$this->initModule($sliderModule);
		$sliderData = $sliderModule->loadData();

		if($this->format == 'json') {
			$this->images = $sliderData['images'];
		} else {
			$this->slider = $this->model->generateSliderWikiText($sliderData['images']);
		}
	}

	public function explore() {
		$exploreData = $this->model->getDataForModuleExplore();
		$this->headline = $exploreData['headline'];
		$this->article = $exploreData['article'];
		$this->image = $exploreData['imagelink'];
		$this->linkgroups = $exploreData['linkgroups'];
		$this->link = $exploreData['link'];
	}

	public function pulse() {
		/** @var $pulseModule WikiaHubsV2PulseModule */
		$pulseModule = F::build('WikiaHubsV2PulseModule');
		$this->initModule($pulseModule);
		$pulseData = $pulseModule->loadData();

		$this->title = !empty($pulseData['title'])?$pulseData['title']:null;
		$this->socialmedia = !empty($pulseData['socialmedia'])?$pulseData['socialmedia']:null;
		$this->boxes = !empty($pulseData['boxes'])?$pulseData['boxes']:null;
	}

	public function featuredvideo() {
		$videoData = $this->model->getDataForModuleFeaturedVideo();
		$this->headline = $videoData['headline'];
		$this->sponsor = $videoData['sponsor'];
		$this->sponsorThumb = !empty($videoData['sponsorthumb'])?$this->model->generateImageXml($videoData['sponsorthumb']):null;
		$this->description = $videoData['description'];
		$this->video = $this->model->parseVideoData($videoData);
	}

	public function popularvideos() {
		$videosData = $this->model->getDataForModulePopularVideos();
		$this->headline = $videosData['headline'];
		$this->videos = $videosData['videos'];
	}

	/**
	 * @requestParam Array $video
	 */
	public function renderCaruselElement() {
		$video = $this->request->getVal('video', false);
		$this->video = $this->model->getVideoElementData($video);
	}

	public function topwikis() {
		$wikiData = $this->model->getDataForModuleTopWikis();
		$this->headline = $wikiData['headline'];
		$this->description = $wikiData['description'];
		$this->wikis = $wikiData['wikis'];
	}

	public function tabber() {
		$tabData = $this->model->getDataForModuleTabber();
		$this->headline = $tabData['headline'];
		if($this->format == 'json') {
			$this->tabdata = $tabData;
		} else {
			$this->tabs = $this->model->generateTabberWikiText($tabData);
		}
	}

	public function wikitextmodule() {
		$this->wikitextmoduledata = $this->model->getDataForModuleWikitext();
	}

	public function fromthecommunity() {
		$fromTheCommunityData = $this->model->getDataForModuleFromTheCommunity();
		$this->headline = $fromTheCommunityData['headline'];
		$this->entries = $fromTheCommunityData['entries'];
	}

	public function init() {
		parent::init();
		$this->initCacheValidityTimes();
		$this->initFormat();
		$this->initModel();
		$this->initVertical();
		$this->initVerticalSettings();
	}

	protected function initCacheValidityTimes() {
		$this->response->setCacheValidity(
			self::CACHE_VALIDITY_BROWSER,
			self::CACHE_VALIDITY_VARNISH,
			array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH)
		);
	}

	/**
	 * @return WikiaHubsV2Model
	 */
	protected function getModel() {
		if (!$this->model) {
			$this->initModel();
		}
		return $this->model;
	}

	protected function initFormat() {
		$this->format = $this->request->getVal('format', 'html');
	}

	protected function initVertical() {
		$this->verticalId = $this->getRequest()->getVal('verticalid', WikiFactoryHub::CATEGORY_ID_GAMING);
		$this->verticalName = $this->model->getVerticalName($this->verticalId);
	}

	protected function initModel() {
		$this->model = F::build('WikiaHubsV2Model');
		$date = $this->getRequest()->getVal('date', date('Y-m-d'));
		$lang = $this->getRequest()->getVal('cityId', $this->wg->cityId);
		$this->model->setDate($date);
		$this->model->setLang($lang);
		$this->model->setVertical($this->verticalId);
	}

	protected function initModule(WikiaHubsV2Module $module) {
		$date = $this->getRequest()->getVal('date', date('Y-m-d'));
		$lang = $this->getRequest()->getVal('cityId', $this->wg->cityId);
		$module->setDate($date);
		$module->setLang($lang);
		$module->setVertical($this->verticalId);
	}

	/**
	 * @desc Sets hubs specific settings: page title, hub type, vertical body class
	 */
	protected function initVerticalSettings() {
		$this->wg->out->setPageTitle($this->verticalName);
		if($this->format != 'json') {
			$this->wgWikiaHubType = $this->verticalName;
		}
		RequestContext::getMain()->getRequest()->setVal('vertical', $this->verticalName);
		OasisController::addBodyClass('WikiaHubs' . mb_ereg_replace(' ', '', $this->verticalName));
	}
}
