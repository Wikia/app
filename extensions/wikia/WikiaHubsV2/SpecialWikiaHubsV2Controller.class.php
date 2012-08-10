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

	public function __construct() {
		parent::__construct('WikiaHubsV2');
	}

	public function index() {
		$this->setCacheValidity();
		$model = $this->getModel();

		$this->slider = $model->getDataForModuleSlider();
		$this->pulse = $model->getDataForModulePulse();
		$this->tabber = $model->getDataForModuleTabber();
		$this->explore = $model->getDataForModuleExplore();
		$this->featuredvideo = $model->getDataForModuleFeaturedVideo();
		$this->wikitextmoduledata = $model->getDataForModuleWikitext();
		$this->topwikis = $model->getDataForModuleTopWikis();
		$this->popularvideos = $model->getDataForModulePopularVideos();
		$this->fromthecommunity = $model->getDataForModuleFromTheCommunity();

		$this->response->addAsset('extensions/wikia/WikiaHubsV2/css/WikiaHubsV2.scss');
		$this->response->addAsset('extensions/wikia/WikiaHubsV2/js/WikiaHubsV2.js');

		if( !self::PLAY_IN_LIGHTBOX ) {
			$this->response->addAsset('extensions/wikia/RelatedVideos/js/RelatedVideos.js');
		}

		$hubName = $model->getHubName($this->request->getVal('vertical'));
		$this->setHub($hubName);
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
		$this->sponsorThumb = $videoData['sponsorthumb'];
		$this->video = $videoData['video'];
		$this->description = $videoData['description'];
	}

	public function popularvideos() {
		$this->setCacheValidity();
		$model = $this->getModel();
		$videosData = $model->getDataForModulePopularVideos();
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

		if( $videoFile ) {
			$thumbWidth = $video['thumbnailData']['width'];
			$thumbHeight = $video['thumbnailData']['height'];
			$videoThumbObj = $videoFile->transform( array('width'=> $thumbWidth, 'height' => $thumbHeight) );
			$this->extractDataForCaruselTemplate($video, $videoThumbObj);
		} else {
			Wikia::log(__METHOD__, false, 'A video file not found. ID: '.$video['title']);
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
		if( empty($videoArr['profile']) ) {
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
		$this->setCacheValidity();
		$model = $this->getModel();
		$wikiData = $model->getDataForModuleTopWikis();
		$this->headline = $wikiData['headline'];
		$this->description = $wikiData['description'];
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

	/**
	 * @param $hubName string
	 */
	protected function setHub($hubName) {
		$this->wg->out->setPageTitle($hubName);
		$this->wgWikiaHubType = $hubName;
		RequestContext::getMain()->getRequest()->setVal('vertical',$hubName);
		OasisController::addBodyClass('WikiaHubs' . mb_ereg_replace(' ','',$hubName));
	}
}
