<?php
class MarketingToolboxModuleWikiaspicksService extends MarketingToolboxModuleEditableService {
	const MODULE_ID = 3;

	public function getFormFields() {
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
				'label' => wfMsg('marketing-toolbox-hub-module-wikiaspicks-title'),
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
				'label' => wfMsg('marketing-toolbox-hub-module-wikiaspicks-text'),
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
			),
			'imageLink' => array(
				'label' => wfMsg('marketing-toolbox-hub-module-wikiaspicks-link-url'),
				'validator' => new WikiaValidatorToolboxUrl(
					array(),
					array(
						'wrong' => 'marketing-toolbox-validator-wrong-url'
					)
				),
				'attributes' => array(
					'class' => 'wikiaUrl'
				)
			),
		);

		return $fields;
	}
	
	public function renderEditor($data) {
		$model = new MarketingToolboxModel();

		$fileNameField = $data['form']->getField('fileName');
		if( !empty($fileNameField['value']) ) {
			$imageModel = new MarketingToolboxImageModel($fileNameField['value']);
			$data['file'] = $imageModel->getImageThumbData($model->getThumbnailSize());
		}

		$sponsoredImageField = $data['form']->getField('sponsoredImage');
		if( !empty($sponsoredImageField['value']) ) {
			$imageModel = new MarketingToolboxImageModel($sponsoredImageField['value']);
			$data['sponsoredImage'] = $imageModel->getImageThumbData();
		}
		
		return parent::renderEditor($data);
	}
	
	public function filterData($data) {
		if( !empty($data['text']) ) {
			$model = new MarketingToolboxModel();
			$data['text'] = strip_tags($data['text'], $model->getAllowedTags());
		}
		
		if( !empty($data['imageLink']) ) {
			$data['imageLink'] = $this->addProtocolToLink($data['imageLink']);
		}
		
		return parent::filterData($data);
	}
	
	public function render($data) {
		if( !empty($data['sponsoredImageAlt']) ) {
		//sponsoredImageAlt === image file title -> can be used in Title::newFromTitle() to create Title instance
			$data['sponsoredImageMarkup'] = $this->getSponsoredImageMarkup($data['sponsoredImageAlt']);
		}
		
		return parent::render($data);
	}

	public function getStructuredData($data) {
		$structuredData = array();
		
		if (!empty($data['sponsoredImage'])) {
			$sponsoredImageInfo = $this->getImageInfo($data['sponsoredImage']);
		}
		
		$structuredData['sponsoredImageUrl'] = (isset($sponsoredImageInfo)) ? $sponsoredImageInfo->url : null;
		$structuredData['sponsoredImageAlt'] = (isset($sponsoredImageInfo)) ? $sponsoredImageInfo->title : null;
		
		$structuredData['imageLink'] = (!empty($data['imageLink'])) ? $data['imageLink'] : null;

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
