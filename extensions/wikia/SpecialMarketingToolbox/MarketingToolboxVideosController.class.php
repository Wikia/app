<?php

class MarketingToolboxVideosController extends WikiaController {
	public function index() {
		$this->elementHeight = MarketingToolboxModel::FORM_THUMBNAIL_SIZE;
		$this->video = $this->request->getVal('video');
	}
	
	public function popularVideoRow() {
		$video = $this->getVal('video');
		$this->errorMsg = $this->getVal('errorMsg');
		
		if( !empty($video) ) {
			$this->sectionNo = $video['section-no'];
			$this->videoName = $video['id'];
			$this->videoTitle = $video['title'];
			$this->videoFullUrl = $video['fullUrl'];
			$this->timestamp = wfTimeFormatAgo($video['timestamp']);
			
			$this->videoThumbnail = $this->app->renderView(
				'MarketingToolboxVideos',
				'index',
				array('video' => $video)
			);
		}
		
		//button messages
		$this->removeMsg = $this->wf->msg('marketing-toolbox-edithub-remove');
		
		//blank image
		$this->blankImgUrl = $this->wg->BlankImgUrl;
		
		$this->response->setTemplateEngine(WikiaResponse::TEMPLATE_ENGINE_MUSTACHE);
	}
}
