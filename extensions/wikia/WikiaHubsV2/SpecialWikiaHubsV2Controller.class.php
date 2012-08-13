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
	const PLAY_IN_LIGHTBOX = true;

	/**
	 * @var WikiaHubsV2Model
	 */
	protected $model;
	protected $format;

	public function __construct() {
		parent::__construct('WikiaHubsV2');
	}

	public function index() {
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

	public function slider() {
		$exploreData = $this->model->getDataForModuleSlider();
		$this->images = $exploreData['images'];
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
		$pulseData = $this->model->getDataForModulePulse();
		$this->title = $pulseData['title'];
		$this->socialmedia = $pulseData['socialmedia'];
		$this->boxes = $pulseData['boxes'];
	}

	public function featuredvideo() {
		$videoData = $this->model->getDataForModuleFeaturedVideo();
		$this->headline = $videoData['headline'];
		$this->sponsor = $videoData['sponsor'];
		$this->sponsorThumb = !empty($videoData['sponsorthumb'])?$this->model->generateImage($videoData['sponsorthumb']):null;
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
		$videoTitle = ($video) ? F::build('Title', array($video['title'], NS_FILE), 'newFromText') : false;
		$videoFile = ($videoTitle) ? wfFindFile($videoTitle) : false;

		if ($videoFile) {
			$thumbWidth = $video['thumbnailData']['width'];
			$thumbHeight = $video['thumbnailData']['height'];
			$videoThumbObj = $videoFile->transform(array('width' => $thumbWidth, 'height' => $thumbHeight));
			$this->extractDataForCaruselTemplate($video, $videoThumbObj);
		} else {
			Wikia::log(__METHOD__, false, 'A video file not found. ID: ' . $video['title']);
		}
	}

	protected function extractDataForCaruselTemplate($videoArr, $videoThumbObj) {
		$videoFile = $videoThumbObj->getFile();
		$videoTitle = $videoFile->getTitle();
		$wikiUrl = WikiFactory::getVarValueByName('wgServer', $videoArr['wikiId']);

		$this->duration = $videoFile->getHandler()->getFormattedDuration();
		$this->data = array(
			'wiki' => $wikiUrl,
			'video-name' => $videoArr['title'],
			'ref' => $videoTitle->getNsText() . ':' . $videoTitle->getDBkey(),
		);
		$this->href = $videoTitle->getFullUrl();
		$this->imgUrl = $videoThumbObj->getUrl();
		$this->description = $videoArr['headline'];
		if (empty($videoArr['profile'])) {
			$this->info = wfMsgExt('wikiahubs-popular-videos-suggested-by', array('parseinline'), array($videoArr['submitter']));
		} else {
			$this->info = wfMsgExt('wikiahubs-popular-videos-suggested-by-profile', array('parseinline'), array($videoArr['submitter'], $videoArr['profile']));
		}

		//todo: remove this hack described below once we finish research about customizing lightbox
		//do we want it in lightbox or modal
		//also quite important can be $this->wg->VideoHandlersVideosMigrated
		$this->videoPlay = self::PLAY_IN_LIGHTBOX ? 'lightbox' : 'video-play';
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
		$tabberSource = '{{#tag:tabber|';
		foreach ($tabData['tabs'] as $tab) {
			$tabberSource .= $tab['title'] . '=
				[[File:' . $tab['image'] . '|200px|right|link=' . $tab['imagelink'] . ']]
				' . $tab['content'] . '
			{{!}}-{{!}}';
		}
		$tabberSource .= '}}';
		$this->tabs = $tabberSource;
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
		$this->setCacheValidity();
		$this->initModel();
		$this->format = $this->request->getVal('format', 'html');
		$hubName = $this->model->getHubName($this->request->getVal('vertical'));
		$this->setHub($hubName);

		$this->response->addAsset('extensions/wikia/WikiaHubsV2/css/WikiaHubsV2.scss');
		$this->response->addAsset('extensions/wikia/WikiaHubsV2/js/WikiaHubsV2.js');
		if (!self::PLAY_IN_LIGHTBOX) {
			$this->response->addAsset('extensions/wikia/RelatedVideos/js/RelatedVideos.js');
		}
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
			$this->initModel();
		}
		return $this->model;
	}


	protected function initModel() {
		$this->model = F::build('WikiaHubsV2Model');
		$date = $this->getRequest()->getVal('date', date('Y-m-d'));
		$lang = $this->getRequest()->getVal('cityId', $this->wg->cityId);
		$vertical = $this->getRequest()->getVal('vertical', WikiFactoryHub::CATEGORY_ID_GAMING);
		$this->model->setDate($date);
		$this->model->setLang($lang);
		$this->model->setVertical($vertical);
	}

	/**
	 * @param $hubName string
	 */
	protected function setHub($hubName) {
		$this->wg->out->setPageTitle($hubName);
		$this->wgWikiaHubType = $hubName;
		RequestContext::getMain()->getRequest()->setVal('vertical', $hubName);
		OasisController::addBodyClass('WikiaHubs' . mb_ereg_replace(' ', '', $hubName));
	}
}
