<?php
class WikiaHubsModuleFeaturedvideoService extends WikiaHubsModuleEditableService {
	const MODULE_ID = 4;

	public function getFormFields() {
		return array(
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
			'video' => array(
				'type' => 'hidden',
				'attributes' => array(
					'class' => 'wmu-file-name-input required'
				),
				'validator' => new WikiaValidatorFileTitle(
					array(
						'required' => true
					),
					array('wrong-file' => 'wikia-hubs-validator-wrong-file')
				)
			),
			'header' => array(
				'label' => wfMessage('wikia-hubs-module-featured-video-header')->text(),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'wikia-hubs-string-short')
				),
				'attributes' => array(
					'class' => 'required'
				)
			),
			'articleUrl' => array(
				'label' => wfMessage('wikia-hubs-module-featured-video-article-url')->text(),
				'validator' => new WikiaValidatorRestrictiveUrl(
					array(
						'required' => true
					),
					array(
						'wrong' => 'wikia-hubs-validator-wrong-url'
					)
				),
				'attributes' => array(
					'class' => 'required wikiaUrl'
				),
			),
			'description' => array(
				'label' => wfMessage('wikia-hubs-module-featured-video-desc')->text(),
				'validator' => new WikiaValidatorString(),
				'type' => 'textarea',
				'attributes' => array(
					'rows' => 3
				)
			),
		);
	}

	public function renderEditor($data) {
		$model = new EditHubModel();

		$videoField = $data['form']->getField('video');
		if( !empty($videoField['value']) ) {
			$videoData = $model->getVideoData($videoField['value'], $model->getThumbnailSize());
			$data['videoThumb'] =  $videoData['videoThumb'];
		}

		$sponsoredImageField = $data['form']->getField('sponsoredImage');
		if( !empty($sponsoredImageField['value']) ) {
			$imageModel = new WikiaHubsImageModel($sponsoredImageField['value']);
			$data['sponsoredImage'] = $imageModel->getImageThumbData();
		}
		return parent::renderEditor($data);
	}

	public function filterData($data) {
		if( !empty($data['description']) ) {
			$model = new EditHubModel();
			$data['description'] = strip_tags($data['description'], $model->getAllowedTags());
		}

		if (!empty($data['articleUrl'])) {
			$data['articleUrl'] = $this->addProtocolToLink($data['articleUrl']);
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

		$structuredData['header'] = $data['header'];
		$structuredData['description'] = isset($data['description']) ? $data['description'] : '';
		$structuredData['articleUrl'] = $data['articleUrl'];

		if (!empty($data['sponsoredImage'])) {
			$sponsoredImageInfo = $this->getImageInfo($data['sponsoredImage']);

			$structuredData['sponsoredImageUrl'] = $sponsoredImageInfo->getUrlGenerator()->url();
			$structuredData['sponsoredImageAlt'] = $sponsoredImageInfo->getName();
		}



		$editHubModel = $this->getEditHubModel();
		$moduleModel = new WikiaHubsFeaturedvideoModel();
		$videoData = $editHubModel->getVideoData($data['video'], $moduleModel->getVideoThumbSize());

		$structuredData['video'] = array(
			'title' => isset($videoData['title']) ? $videoData['title'] : null,
			'fileUrl' => isset($videoData['fileUrl']) ? $videoData['fileUrl'] : null,
			'thumbUrl' => isset($videoData['thumbUrl']) ? $videoData['thumbUrl'] : null,
			'duration' => isset($videoData['duration']) ? $videoData['duration'] : null,
			'thumbMarkup' => isset($videoData['videoThumb']) ? $videoData['videoThumb'] : null,
		);

		return $structuredData;
	}

	protected function getEditHubModel() {
		return new EditHubModel();
	}

	/**
	 * check if it is video module
	 * @return boolean
	 */
	public function isVideoModule() {
		return true;
	}

	/**
	 * get list of video url
	 * @param array $data
	 * @return array $videoData
	 */
	public function getVideoData( $data ) {
		$structureData = $this->getStructuredData( $data );
		$videoData[] = $structureData['video']['fileUrl'];

		return $videoData;
	}

	/**
	 * Don't return any data for commercial usages
	 * @param $data
	 * @return mixed
	 */
	protected function filterCommercialData( $data ) {
		$data['video'] = null;
		$service = $this->getLicensedWikisService();
		if ( isset($data['articleUrl']) && !$service->isCommercialUseAllowedByUrl($data['articleUrl']) ) {
			$data = null;
		}
		return $data;
	}
}
