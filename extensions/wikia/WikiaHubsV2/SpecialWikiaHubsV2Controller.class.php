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
	protected $helper;

	public function __construct() {
		parent::__construct('WikiaHubsV2');
	}

	public function index() {
		$this->response->setCacheValidity(
			24 * 60 * 60,
			24 * 60 * 60,
			array(WikiaResponse::CACHE_TARGET_BROWSER, WikiaResponse::CACHE_TARGET_VARNISH)
		);

		$this->slider = $this->sendRequest('SpecialWikiaHubsV2Controller', 'slider')->getData();
		$this->explore = $this->sendRequest('SpecialWikiaHubsV2Controller', 'explore')->getData();
		$this->pulse = $this->sendRequest('SpecialWikiaHubsV2Controller', 'pulse')->getData();
		$this->featuredvideo = $this->sendRequest('SpecialWikiaHubsV2Controller', 'featuredvideo')->getData();
		$this->topwikis = $this->sendRequest('SpecialWikiaHubsV2Controller', 'topwikis')->getData();
		$this->tabber = $this->sendRequest('SpecialWikiaHubsV2Controller', 'tabber')->getData();

		$this->response->addAsset('extensions/wikia/WikiaHubsV2/css/WikiaHubsV2.scss');
	}

	public function slider() {
		$helper = $this->getHelper();
		$exploreData = $helper->getDataForModuleSlider();
		$this->images = $exploreData['images'];
	}

	public function explore() {
		$helper = $this->getHelper();
		$exploreData = $helper->getDataForModuleExplore();
		$this->headline = $exploreData['headline'];
		$this->article = $exploreData['article'];
		$this->image = $exploreData['image'];
		$this->linkgroups = $exploreData['linkgroups'];
		$this->link = $exploreData['link'];
	}

	public function pulse() {
		$helper = $this->getHelper();
		$pulseData = $helper->getDataForModulePulse();
		$this->title = $pulseData['title'];
		$this->socialmedia = $pulseData['socialmedia'];
		$this->boxes = $pulseData['boxes'];
	}

	public function featuredvideo() {
		$helper = $this->getHelper();
		$videoData = $helper->getDataForModuleFeaturedVideo();
		$this->headline = $videoData['headline'];
		$this->sponsor = $videoData['sponsor'];
		$this->video = $videoData['video'];
		$this->description = $videoData['description'];
	}

	public function topwikis() {
		$helper = $this->getHelper();
		$wikiData = $helper->getDataForModuleTopWikis();
		$this->headline = $wikiData['headline'];
		$this->wikis = $wikiData['wikis'];
	}

	public function tabber() {
		$helper = $this->getHelper();
		$tabData = $helper->getDataForModuleTabber();
		$this->headline = $tabData['headline'];
		$this->tabs = $tabData['tabs'];
	}

	/**
	 * @return WikiaHubsV2Model
	 */
	protected function getHelper() {
		if (!$this->helper) {
			$this->helper = F::build('WikiaHubsV2Model');
		}
		return $this->helper;
	}
}
