<?php
class MarketingToolboxModulePopularvideosService extends MarketingToolboxModuleEditableService {
	const MODULE_ID = 9;

	public function getFormFields() {
		return array(
			'header' => array(
				'label' => wfMsg('marketing-toolbox-hub-module-popular-videos-header'),
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
			'videoUrl' => array(
				'validator' => new WikiaValidatorListValue(
					array(
						'validator' => new WikiaValidatorToolboxUrl(
							array(
								'required' => true
							),
							array(
								'wrong' => 'marketing-toolbox-validator-wrong-url'
							)
						),
					)
				),
				'isArray' => true
			),
		);
	}

	public function renderEditor($data) {
		$model = new MarketingToolboxModel();

		$videoField = $data['form']->getField('video');
		$videoUrlField = $data['form']->getField('videoUrl');
		if( !empty($videoField['value']) ) {
			foreach($videoField['value'] as $i => $video) {
				$data['videos'][$i] = $model->getVideoData($video, $model->getThumbnailSize());
				$data['videos'][$i]['title'] = $video;

				//we enabled curators to edit a video url so if they've changed it we change it here
				$data['videos'][$i]['fullUrl'] = ( !empty($videoUrlField['value'][$i]) ) ? $videoUrlField['value'][$i] : $data['videos'][$i]['fileUrl'];
				//numbers next to section starts with 2
				$data['videos'][$i]['section-no'] = $i + 2;
			}
		}

		return parent::renderEditor($data);
	}

	public function filterData($data) {
		$data = parent::filterData($data);

		//for now we're allowing to save empty videos' list
		if( !isset($data['video']) ) {
			$data['video'] = array();
		}

		if( !isset($data['videoUrl']) ) {
			$data['videoUrl'] = array();
		}

		foreach ($data['videoUrl'] as &$url) {
			if (!empty($url)) {
				$url = $this->addProtocolToLink($url);
			}
		}

		return $data;
	}

	public function getStructuredData($data) {
		$structuredData = array();

		if(!empty($data)) {
			$toolboxModel = $this->getToolboxModel();
			$moduleModel = $this->getModuleModel();

			$structuredData['header'] = $data['header'];
			$structuredData['videos'] = null;
			foreach($data['video'] as $key => $video) {
				$videoData = $toolboxModel->getVideoData($video, $moduleModel->getVideoThumbSize());

				$structuredData['videos'][] = array(
					'title' => $videoData['title'],
					'fileUrl' => $videoData['fileUrl'],
					'duration' => $videoData['duration'],
					'thumbUrl' => $videoData['thumbUrl'],
					'thumbMarkup' => $videoData['videoThumb'],
					'wikiUrl' => $data['videoUrl'][$key]
				);
			}
		}

		return $structuredData;
	}

	public function getToolboxModel() {
		return new MarketingToolboxModel();
	}

	public function getModuleModel() {
		return new MarketingToolboxPopularvideosModel();
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
		$videoData = array();

		$structureData = $this->getStructuredData( $data );
		foreach( $structureData['videos'] as $video ) {
			$videoData[] = $video['fileUrl'];
		}

		return $videoData;
	}
}
