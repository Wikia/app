<?php
class MarketingToolboxModuleWikiaspicksService extends MarketingToolboxModuleService {
	protected function getFormFields() {
		$fields = array(
			'sponsoredImage' => array(
				'type' => 'hidden',
				'attributes' => array(
					'class' => 'wmu-file-name-input'
				),
				'validator' => new WikiaValidatorImageSize(
					array(
						'maxWidth' => 85,
						'maxHeight' => 15,
					),
					array(
						'wrong-file' => 'marketing-toolbox-validator-wrong-file',
						'max-width' => 'marketing-toolbox-validator-wrong-file-size-width',
						'max-height' => 'marketing-toolbox-validator-wrong-file-size-height',
						'not-an-image' => 'marketing-toolbox-validator-wrong-file-not-an-image',
					)
				)
			),
			'fileName' => array(
				'type' => 'hidden',
				'attributes' => array(
					'class' => 'wmu-file-name-input'
				),
				'validator' => new WikiaValidatorFileTitle(
					array(),
					array('wrong-file' => 'marketing-toolbox-validator-wrong-file')
				)
			),
			'module-title' => array(
				'label' => $this->wf->Msg('marketing-toolbox-hub-module-wikiaspicks-title'),
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
			'text' => array(
				'label' => $this->wf->Msg('marketing-toolbox-hub-module-wikiaspicks-text'),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
				'type' => 'textarea',
				'attributes' => array(
					'class' => 'required',
					'rows' => 3
				)
			)
		);

		return $fields;
	}

	public function renderEditor($data) {
		$model = new MarketingToolboxModel();
		$imageModel = new MarketingToolboxImageModel($data['values']['fileName']);

		if( !empty($data['values']['fileName']) ) {
			$data['file'] = $imageModel->getImageThumbData($model->getThumbnailSize());
		}

		if( !empty($data['values']['sponsoredImage']) ) {
			$data['sponsoredImage'] = $imageModel->getImageThumbData();
		}
		
		return parent::renderEditor($data);
	}
	
	public function filterData($data) {
		if( !empty($data['text']) ) {
			$model = new MarketingToolboxModel();
			$data['text'] = strip_tags($data['text'], $model->getAllowedTags());
		}
		
		return parent::filterData($data);
	}
	
}
