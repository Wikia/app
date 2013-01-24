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
						'compare-way' => WikiaValidatorImageSize::COMPARE_LTE,
						'width' => 85,
						'height' => 15,
					),
					array(
						'wrong-file' => 'marketing-toolbox-validator-wrong-file',
						'wrong-size' => 'marketing-toolbox-validator-wrong-file-size',
						'wrong-width' => 'marketing-toolbox-validator-wrong-file-size-width',
						'wrong-height' => 'marketing-toolbox-validator-wrong-file-size-height',
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
		if( !empty($data['values']['fileName']) ) {
			$model = new MarketingToolboxModel();
			$imageData = ImagesService::getLocalFileThumbUrlAndSizes($data['values']['fileName'], $model->getThumbnailSize());
			$data['fileUrl'] = $imageData->url;
			$data['imageWidth'] = $imageData->width;
			$data['imageHeight'] = $imageData->height;
		}

		if( !empty($data['values']['sponsoredImage']) ) {
			$model = new MarketingToolboxModel();
			//TODO: ImagesService::getLocalFileThumbUrlAndSizes isn't good here because it takes only destination width in consideration
			$imageData = ImagesService::getLocalFileThumbUrlAndSizes($data['values']['sponsoredImage'], $model->getSponsoredImageWidth());
			$data['sponsoredImageUrl'] = $imageData->url;
			$data['sponsoredImageWidth'] = $imageData->width;
			$data['sponsoredImageHeight'] = $imageData->height;
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
