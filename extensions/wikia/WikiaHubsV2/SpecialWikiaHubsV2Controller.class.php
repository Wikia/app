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

	public function __construct() {
		parent::__construct('WikiaHubsV2');
	}

	public function index() {
		$this->setCacheValidity();
		$this->slider = $this->sendRequest('SpecialWikiaHubsV2Controller', 'slider')->getData();
		$this->pulse = $this->sendRequest('SpecialWikiaHubsV2Controller', 'pulse')->getData();
		$this->tabber = $this->sendRequest('SpecialWikiaHubsV2Controller', 'tabber')->getData();
		$this->explore = $this->sendRequest('SpecialWikiaHubsV2Controller', 'explore')->getData();
		$this->featuredvideo = $this->sendRequest('SpecialWikiaHubsV2Controller', 'featuredvideo')->getData();
		$this->wikitextmoduledata = $this->sendRequest('SpecialWikiaHubsV2Controller', 'wikitextmodule')->getData();
		$this->topwikis = $this->sendRequest('SpecialWikiaHubsV2Controller', 'topwikis')->getData();
		$this->popularvideos = $this->sendRequest('SpecialWikiaHubsV2Controller', 'popularvideos')->getData();
		$this->fromthecommunity = $this->sendRequest('SpecialWikiaHubsV2Controller', 'fromthecommunity')->getData();

		$this->response->addAsset('extensions/wikia/WikiaHubsV2/css/WikiaHubsV2.scss');
		$this->response->addAsset('extensions/wikia/WikiaHubsV2/js/WikiaHubsV2.js');
	}

	public function slider() {
		$this->setCacheValidity();
		$model = $this->getModel();
		$exploreData = $model->getDataForModuleSlider();
		$this->images = $exploreData['images'];
	}

	public function explore() {
		$this->setCacheValidity();
		$model = $this->getModel();
		$exploreData = $model->getDataForModuleExplore();
		$this->headline = $exploreData['headline'];
		$this->article = $exploreData['article'];
		$this->image = $exploreData['image'];
		$this->linkgroups = $exploreData['linkgroups'];
		$this->link = $exploreData['link'];
	}

	public function pulse() {
		$this->setCacheValidity();
		$model = $this->getModel();
		$pulseData = $model->getDataForModulePulse();
		$this->title = $pulseData['title'];
		$this->socialmedia = $pulseData['socialmedia'];
		$this->boxes = $pulseData['boxes'];
	}

	public function featuredvideo() {
		$this->setCacheValidity();
		$model = $this->getModel();
		$videoData = $model->getDataForModuleFeaturedVideo();
		$this->headline = $videoData['headline'];
		$this->sponsor = $videoData['sponsor'];
		$this->video = $videoData['video'];
		$this->description = $videoData['description'];
	}

	public function popularvideos() {
		$this->setCacheValidity();
		$model = $this->getModel();
		$videosData = $model->getDataForModulePopularVideos();
		$this->headline = $videosData ['headline'];
		$this->videos = $videosData['videos'];
	}

	public function topwikis() {
		$this->setCacheValidity();
		$model = $this->getModel();
		$wikiData = $model->getDataForModuleTopWikis();
		$this->headline = $wikiData['headline'];
		$this->wikis = $wikiData['wikis'];
	}

	public function tabber() {
		$this->setCacheValidity();
		$model = $this->getModel();
		$tabData = $model->getDataForModuleTabber();
		$this->headline = $tabData['headline'];
		$this->tabs = $tabData['tabs'];
	}

	public function wikitextmodule() {
		$this->setCacheValidity();
		$model = $this->getModel();
		$this->wikitextmoduledata = $model->getDataForModuleWikitext();
	}

	public function popularvideos() {
		//this method returns a template
	}

	public function fromthecommunity() {
		$this->setCacheValidity();
		$model = $this->getModel();
		$fromTheCommunityData = $model->getDataForModuleFromTheCommunity();
		$this->headline = $fromTheCommunityData['headline'];
		$this->entries = $fromTheCommunityData['entries'];
	}

	protected function setCacheValidity() {
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
			$this->model = F::build('WikiaHubsV2Model');
			$date = $this->getRequest()->getVal('date', date('Y-m-d'));
			$lang = $this->getRequest()->getVal('cityId', $this->wg->cityId);
			$vertical = $this->getRequest()->getVal('vertical', WikiFactoryHub::CATEGORY_ID_GAMING);
			$this->model->setDate($date);
			$this->model->setLang($lang);
			$this->model->setVertical($vertical);
		}
		return $this->model;
	}
}
