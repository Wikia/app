<?php

class RelatedVideosController extends WikiaController {


	const MAX_RELATEDVIDEOS = 25;
	const SURVEY_URL = 'http://www.surveymonkey.com/s/RelatedVideosExperience';
	public function __construct( WikiaApp $app ) {
		$this->app = $app;
	}

	public function getCarusel(){

		if( Wikia::isMainPage() ) {
			return false;
		}
		$relatedVideos = RelatedVideos::getInstance();
		$videos = $relatedVideos->get(
			$this->app->wg->title->getArticleId(),
			RelatedVideosController::MAX_RELATEDVIDEOS
		);

		$this->setVal( 'videos', $videos );
	}

	public function getVideo(){

		$title = urldecode($this->getVal( 'title' ));
		$external = $this->getVal( 'external', '' );
		$title = urldecode( $title );
		$external = empty( $external ) ? null : $this->app->wg->wikiaVideoRepoDBName;

		$oRelatedVideosService = F::build('RelatedVideosService');
		$result = $oRelatedVideosService->getRelatedVideoDataFromTitle( $title, $external );
		
		$this->setVal( 'width', intval( $result['thumbnailData']['width'] ) );
		$this->setVal( 'height', intval( $result['thumbnailData']['height'] ) );
		$this->setVal( 'json', $result['embedJSON'] );
		if ( !empty( $result['embedJSON'] ) && isset( $result['embedJSON']['id'] ) ){
			$videoHtml = '<div id="'.$result['embedJSON']['id'].'"></div>';
		} else {
			$videoHtml = $result['embedCode'];
		}
		$this->setVal( 'html',
			 $this->app->renderView(
				'RelatedVideos',
				'getVideoHtml',
				array(
					 'videoHtml' => $videoHtml,
					 'embedUrl' => empty( $result['external'] ) ? '' : $result['fullUrl']
				)
			)
		 );
		$this->setVal( 'title', $result['title'] );
		if ( !empty( $result['external'] ) ){
			$this->setVal( 'embedUrl', $result['fullUrl'] );
		}
	}

	public function getVideoHtml(){
		$videoHtml = $this->getVal( 'videoHtml' );
		$embedUrl = $this->getVal( 'embedUrl' );

		$this->setVal( 'videoHtml', $videoHtml );
		$this->setVal( 'embedUrl', $embedUrl );
	}
	
	/*
	 * get data for an article stored in NS_RELATED_VIDEOS 
	 */
	public function getLists() {

		$titleStr = $this->request->getVal('title', null);
		$title = Title::newFromText($titleStr, NS_RELATED_VIDEOS);
		$relatedVideosNSData = RelatedVideosNamespaceData::newFromTitle($title);
		$this->setVal('data', $relatedVideosNSData->getData());
	}

	/*
	 * for getting videos localy and cross wiki
	 */

	public function getVideoData() {
		
		$videoArticleId = $this->getVal('articleId', 0);
		$videoName = urldecode($this->getVal( 'title', '' ));
		$width = $this->getVal( 'width', 0 );
		$videoWidth = $this->getVal( 'videoWidth', VideoPage::DEFAULT_OASIS_VIDEO_WIDTH );
		if ($videoArticleId) {
			$videoTitle = Title::newFromID($videoArticleId, GAID_FOR_UPDATE);
			$useMaster = true;
		}
		else {
			$videoTitle = Title::newFromText( $videoName, NS_VIDEO );
			$useMaster = false;
		}

		$rvd = new RelatedVideosData();
		$videoData = $rvd->getVideoData( $videoTitle, $width, $videoWidth, true, $useMaster );
		$this->setVal( 'data', $videoData );
	}

	public function getCaruselElement(){

		$video = $this->getVal( 'video' );
		$preloaded = $this->getVal( 'preloaded' );
		
		$this->setVal( 'video', $video );
		$this->setVal( 'preloaded', $preloaded );
	}

	public function getAddVideoModal(){
		
		$this->setVal( 'html', $this->app->renderView( 'RelatedVideos', 'addVideoModalText' ) );
		$this->setVal( 'title',	wfMsg('related-videos-add-video-to-this-page') );
	}

	public function addVideoModalText(){
		
	}
	
	public function addVideo() {

		$url = urldecode($this->getVal('url', ''));
		$articleId = $this->getVal('articleId', '');
		$rvd = F::build('RelatedVideosData');
		$retval = $rvd->addVideo($articleId, $url);
		if (is_array($retval)) {
			$rvs = F::build('RelatedVideosService');
			$data = $rvs->getRelatedVideoData( $retval['articleId'], $retval['title'], $retval['external']);
			$this->setVal('html', $this->app->renderView( 'RelatedVideos', 'getCaruselElement', array('video'=>$data, 'preloaded'=>1) ));
			$this->setVal('error', null);
		}
		else {
			$this->setVal('data', null);
			$this->setVal('error', $retval);
		}

	}
	
	public function removeVideo() {
		
		$articleId = $this->getVal('articleId', '');
		$title = urldecode($this->getVal('title', ''));
		$external = $this->getVal('external', 0);
		$rvd = F::build('RelatedVideosData');
		$retval = $rvd->removeVideo($articleId, $title, $external);
		if (is_string($retval)) {
			$this->setVal('error', $retval);
		}
		else {
			$this->setVal('error', null);
		}
		
	}
}
