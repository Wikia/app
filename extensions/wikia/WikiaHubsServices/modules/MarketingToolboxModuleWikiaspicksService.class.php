<?php
class MarketingToolboxModuleWikiaspicksService extends MarketingToolboxModuleService {
	const MODULE_ID = 3;

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
						'wrong-size' => 'marketing-toolbox-validator-wrong-file-size',
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
			'moduleTitle' => array(
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

	public function getStructuredData($data) {
		return $data;
	}
	
	public function renderEditor($data) {
		$model = new MarketingToolboxModel();

		if( !empty($data['values']['fileName']) ) {
			$imageModel = new MarketingToolboxImageModel($data['values']['fileName']);
			$data['file'] = $imageModel->getImageThumbData($model->getThumbnailSize());
		}

		if( !empty($data['values']['sponsoredImage']) ) {
			$imageModel = new MarketingToolboxImageModel($data['values']['sponsoredImage']);
			$data['sponsoredImage'] = $imageModel->getImageThumbData();
		}
		
		return parent::renderEditor($data);
	}
	
	public function render($data) {
		//mocked data TODO: remove it once FB#98045 is done
		$data = array(
			'headline' => "Wikia's Picks",
			'imageUrl' => 'http://images.nandy.wikia-dev.com/central/images/1/16/252_85x15.jpg',
			'imageAlt' => '252 85x15.jpg',
			'text' => 'Test: <a href="http://www.wikia.com" target="_blank">Wikia!</a>. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
		);
		
		return parent::render($data);
	}
	
	public function filterData($data) {
		if( !empty($data['text']) ) {
			$model = new MarketingToolboxModel();
			$data['text'] = strip_tags($data['text'], $model->getAllowedTags());
		}
		
		return parent::filterData($data);
	}

	public function getStructuredData($data) {
		$structuredData = array();

		if (!empty($data['sponsoredImage'])) {
			$sponsoredImageInfo = $this->getImageInfo($data['sponsoredImage']);
		}
		$structuredData['sponsoredImageUrl'] = (isset($sponsoredImageInfo)) ? $sponsoredImageInfo->url : null;
		$structuredData['sponsoredImageAlt'] = (isset($sponsoredImageInfo)) ? $sponsoredImageInfo->title : null;

		if (!empty($data['fileName'])) {
			$imageInfo = $this->getImageInfo($data['fileName']);
		}
		$structuredData['imageUrl'] = (isset($imageInfo)) ? $imageInfo->url : null;
		$structuredData['imageAlt'] = (isset($imageInfo)) ? $imageInfo->title : null;

		$structuredData['title'] = $data['moduleTitle'];
		$structuredData['text'] = $data['text'];

		return $structuredData;
	}
}
