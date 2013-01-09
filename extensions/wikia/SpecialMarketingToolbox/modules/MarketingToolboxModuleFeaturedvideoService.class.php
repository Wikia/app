<?php
class MarketingToolboxModuleFeaturedvideoService extends MarketingToolboxModuleService {
	protected function getFormFields() {
		return array(
			'video' => array(
				'type' => 'hidden',
				'attributes' => array(
					'class' => 'wmu-file-name-input required'
				),
				'validator' => new WikiaValidatorFileTitle(
					array(
						'required' => true
					),
					array('wrong-file' => 'marketing-toolbox-validator-wrong-file')
				)
			),
			'header' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-featured-video-header'),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
				'attributes' => array(
					'class' => 'required'
				)
			),
			'articleUrl' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-featured-video-article-url'),
				'validator' => new WikiaValidatorToolboxUrl(
					array(
						'required' => true
					),
					array(
						'wrong' => 'marketing-toolbox-validator-wrong-url'
					)
				),
				'attributes' => array(
					'class' => 'required wikiaUrl'
				),
			),
			'description' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-featured-video-desc'),
				'validator' => new WikiaValidatorString(),
				'type' => 'textarea',
				'attributes' => array(
					'rows' => 3
				)
			),
		);
	}

	public function renderEditor($data) {
		if (!empty($data['values']['video'])) {
			$model = new MarketingToolboxModel();
			$videoDataHelper = new RelatedVideosData();
			$data['videoData'] = $videoDataHelper->getVideoData($data['values']['video'], $model->getThumbnailSize());
		}

		return parent::renderEditor($data);
	}

	public function filterData($data) {
		if( !empty($data['description']) ) {
			$model = new MarketingToolboxModel();
			$data['description'] = strip_tags($data['description'], $model->getAllowedTags());
		}

		if (!empty($data['articleUrl'])) {
			$data['articleUrl'] = $this->addProtocolToLink($data['articleUrl']);
		}

		return parent::filterData($data);
	}
}
