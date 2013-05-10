<?php
class MarketingToolboxModuleFeaturedvideoService extends MarketingToolboxModuleEditableService {
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
						'wrong-file' => 'marketing-toolbox-validator-wrong-file',
						'wrong-size' => 'marketing-toolbox-validator-wrong-file-size',
						'max-width' => 'marketing-toolbox-validator-wrong-file-size-width',
						'max-height' => 'marketing-toolbox-validator-wrong-file-size-height',
						'not-an-image' => 'marketing-toolbox-validator-wrong-file-not-an-image',
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
		$model = new MarketingToolboxModel();

		$videoField = $data['form']->getField('video');
		if( !empty($videoField['value']) ) {
			$videoData = $model->getVideoData($videoField['value'], $model->getThumbnailSize());
			$data['videoThumb'] =  $videoData['videoThumb'];
		}

		$sponsoredImageField = $data['form']->getField('sponsoredImage');
		if( !empty($sponsoredImageField['value']) ) {
			$imageModel = new MarketingToolboxImageModel($sponsoredImageField['value']);
			$data['sponsoredImage'] = $imageModel->getImageThumbData();
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
		}

		$structuredData['sponsoredImageUrl'] = (isset($sponsoredImageInfo)) ? $sponsoredImageInfo->url : null;
		$structuredData['sponsoredImageAlt'] = (isset($sponsoredImageInfo)) ? $sponsoredImageInfo->title : null;


		$toolboxModel = $this->getToolboxModel();
		$moduleModel = new MarketingToolboxFeaturedvideoModel();
		$videoData = $toolboxModel->getVideoData($data['video'], $moduleModel->getVideoThumbSize());

		$structuredData['video'] = array(
			'title' => isset($videoData['title']) ? $videoData['title'] : null,
			'fileUrl' => isset($videoData['fileUrl']) ? $videoData['fileUrl'] : null,
			'thumbUrl' => isset($videoData['thumbUrl']) ? $videoData['thumbUrl'] : null,
			'duration' => isset($videoData['duration']) ? $videoData['duration'] : null,
			'thumbMarkup' => isset($videoData['videoThumb']) ? $videoData['videoThumb'] : null,
		);

		return $structuredData;
	}

	protected function getToolboxModel() {
		return new MarketingToolboxModel();
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

}
