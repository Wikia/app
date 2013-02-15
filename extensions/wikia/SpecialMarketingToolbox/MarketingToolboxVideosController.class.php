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
			$this->videoFullUrl = $video['fullUrl'];
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
			
			$this->formFields = $this->app->renderView(
				'MarketingToolbox',
				'FormField',
				array(
					'inputData' => array_merge(
						$fields['videoUrl'],
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
		$this->removeMsg = $this->wf->msg('marketing-toolbox-edithub-remove');
		
		//blank image
		$this->blankImgUrl = $this->wg->BlankImgUrl;
		
		$this->response->setTemplateEngine(WikiaResponse::TEMPLATE_ENGINE_MUSTACHE);
	}
}
