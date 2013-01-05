<?php
class MarketingToolboxModuleWikiaspicksService extends MarketingToolboxModuleService {
	
	protected function getFormFields() {
		$fields = array(
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
			'header' => array(
				'label' => $this->wf->Msg('marketing-toolbox-hub-module-wikiaspicks-header'),
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
		if( !empty($data['values']['fileName']) ) {
			$model = new MarketingToolboxModel();
			$imageData = ImagesService::getLocalFileThumbUrlAndSizes($data['values']['fileName'], $model->getThumbnailSize());
			$data['fileUrl'] = $imageData->url;
			$data['imageWidth'] = $imageData->width;
			$data['imageHeight'] = $imageData->height;
		}
		
		return parent::renderEditor($data);
	}
	
	public function filterData($data) {
		if( !empty($data['text']) ) {
			$model = new MarketingToolboxWikiaspicksModel();
			$data['text'] = strip_tags($data['text'], $model->getAllowedTags());
		}
		
		return parent::filterData($data);
	}
	
}
