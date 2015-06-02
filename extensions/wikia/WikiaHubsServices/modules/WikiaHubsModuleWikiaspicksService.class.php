<?php
class WikiaHubsModuleWikiaspicksService extends WikiaHubsModuleEditableService {
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
						'wrong-file' => 'wikia-hubs-validator-wrong-file',
						'wrong-size' => 'wikia-hubs-validator-wrong-file-size',
						'max-width' => 'wikia-hubs-validator-wrong-file-size-width',
						'max-height' => 'wikia-hubs-validator-wrong-file-size-height',
						'not-an-image' => 'wikia-hubs-validator-wrong-file-not-an-image',
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
					array('wrong-file' => 'wikia-hubs-validator-wrong-file')
				)
			),
			'moduleTitle' => array(
				'label' => wfMessage('wikia-hubs-module-wikiaspicks-title')->text(),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'wikia-hubs-validator-string-short')
				),
				'attributes' => array(
					'class' => 'required'
				)
			),
			'text' => array(
				'label' => wfMessage('wikia-hubs-module-wikiaspicks-text')->text(),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'wikia-hubs-validator-string-short')
				),
				'type' => 'textarea',
				'attributes' => array(
					'class' => 'required',
					'rows' => 3
				)
			),
			'imageLink' => array(
				'label' => wfMessage('wikia-hubs-module-wikiaspicks-link-url')->text(),
				'validator' => new WikiaValidatorRestrictiveUrl(
					array(),
					array(
						'wrong' => 'wikia-hubs-validator-wrong-url'
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
		$model = new EditHubModel();

		$fileNameField = $data['form']->getField('fileName');
		if( !empty($fileNameField['value']) ) {
			$imageModel = new WikiaHubsImageModel($fileNameField['value']);
			$data['file'] = $imageModel->getImageThumbData($model->getThumbnailSize());
		}

		$sponsoredImageField = $data['form']->getField('sponsoredImage');
		if( !empty($sponsoredImageField['value']) ) {
			$imageModel = new WikiaHubsImageModel($sponsoredImageField['value']);
			$data['sponsoredImage'] = $imageModel->getImageThumbData();
		}
		
		return parent::renderEditor($data);
	}
	
	public function filterData($data) {
		if( !empty($data['text']) ) {
			$model = new EditHubModel();
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

			$structuredData['sponsoredImageUrl'] = $sponsoredImageInfo->getUrlGenerator()->url();
			$structuredData['sponsoredImageAlt'] = $sponsoredImageInfo->getName();
		}

		$structuredData['imageLink'] = (!empty($data['imageLink'])) ? $data['imageLink'] : null;

		if (!empty($data['fileName'])) {
			$imageInfo = $this->getImageInfo($data['fileName']);
		}

		$structuredData['imageUrl'] = (isset($imageInfo)) ? $imageInfo->getUrlGenerator()->url() : null;
		$structuredData['imageAlt'] = (isset($imageInfo)) ? $imageInfo->getName() : null;
		
		$structuredData['title'] = $data['moduleTitle'];
		$structuredData['text'] = $data['text'];
		$structuredData['photoName'] = isset($data['fileName']) ? $data['fileName'] : '';
		
		return $structuredData;
	}

	/**
	 * Returns null if imageLink is from restricted wiki.
	 * @param $data
	 * @return mixed
	 */
	protected function filterCommercialData( $data ) {
		$service = $this->getLicensedWikisService();
		if ( isset($data['imageLink']) && !$service->isCommercialUseAllowedByUrl($data['imageLink']) ) {
			$data = null;
		}
		return $data;
	}
}
