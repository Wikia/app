<?php
class MarketingToolboxModulePopularvideosService extends MarketingToolboxModuleService {
	protected function getFormFields() {
		return array(
			'header' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-popular-videos-header'),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
				'attributes' => array(
					'class' => 'required'
				),
				'class' => 'borderNone'
			),
			'video' => array(
				'type' => 'hidden',
				'attributes' => array(
					'class' => 'wmu-file-name-input required'
				),
				'validator' => new WikiaValidatorListValue(
					array(
						'validator' => new WikiaValidatorFileTitle(
							array(
								'required' => true
							),
							array('wrong-file' => 'marketing-toolbox-validator-wrong-file')
						)
					)
				),
				'isArray' => true
			),
		);
	}

	public function renderEditor($data) {
		$model = new MarketingToolboxModel();
		
		if( !empty($data['values']['video']) ) {
			$videoDataHelper = new RelatedVideosData();
			
			foreach($data['values']['video'] as $i => $video) {
				$data['videos'][$i] = $videoDataHelper->getVideoData($video, $model->getThumbnailSize());
				$data['videos'][$i]['section-no'] = $i + 2; //numbers next to section starts with 2
			}
		}

		return parent::renderEditor($data);
	}
}
