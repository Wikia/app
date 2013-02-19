<?php

class MarketingToolboxVideosController extends WikiaController {

	public function popularVideoRow() {
		$video = $this->getVal('video');
		$this->errorMsg = $this->getVal('errorMsg');
		
		if( !empty($video) ) {
			$this->sectionNo = $video['section-no'];
			$this->videoTitle = $video['title'];
			$this->videoFullUrl = $video['fullUrl'];
			$this->timestamp = $this->wf->TimeFormatAgo($video['videoTimestamp']);
			$this->videoThumbnail = $video['videoThumb'];
		}
		
		//button messages
		$this->removeMsg = $this->wf->msg('marketing-toolbox-edithub-remove');
		
		//blank image
		$this->blankImgUrl = $this->wg->BlankImgUrl;
		
		$this->response->setTemplateEngine(WikiaResponse::TEMPLATE_ENGINE_MUSTACHE);
	}
}
