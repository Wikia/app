<?php

class MarketingToolboxVideosController extends WikiaController {
	public function index() {
		$this->elementHeight = MarketingToolboxModel::FORM_THUMBNAIL_SIZE;
		$this->video = $this->request->getVal('video');
	}
	
	public function popularVideoRow() {
		$idx = $this->getVal('idx');
		$video = $this->getVal('video');
		$fields = $this->getVal('fields');
		
		if( !empty($video) ) {
			$this->sectionNo = $video['section-no'];
			$this->videoTitle = $video['title'];
			$this->timestamp = wfTimeFormatAgo($video['timestamp']);
			
			$this->hiddenFormFields = $this->app->renderView(
				'MarketingToolbox',
				'FormField',
				array(
					'inputData' => array_merge(
						$fields['video'],
						array('index' => $idx)
					)
				)
			);
			
			$this->videoThumbnail = $this->app->renderView(
				'MarketingToolboxVideos',
				'index',
				array('video' => $video)
			);

			$this->hiddenFormFields = $this->app->renderView(
				'MarketingToolbox',
				'FormField',
				array(
					'inputData' => array_merge(
						$fields['video'],
						array('index' => $idx)
					)
				)
			);
		}
		
		//button messages
		$this->deleteMsg = $this->wf->msg('marketing-toolbox-edithub-delete-button');
		$this->clearMsg = $this->wf->msg('marketing-toolbox-edithub-clear-button');
		
		//blank image
		$this->blankImgUrl = $this->wg->BlankImgUrl;
		
		$this->response->setTemplateEngine(WikiaResponse::TEMPLATE_ENGINE_MUSTACHE);
	}
}
