<?php
class MarketingToolboxModulePopularvideosService extends MarketingToolboxModuleService {
	const MODULE_ID = 9;

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
		
		if( !empty($data['values']['video']) ) {
			$videoDataHelper = new RelatedVideosData();
			
			foreach($data['values']['video'] as $i => $video) {
				$data['videos'][$i] = $model->getVideoData($video, $model->getThumbnailSize());
				$data['videos'][$i]['title'] = $video;

				//we enabled curators to edit a video url so if they've changed it we change it here
				$data['videos'][$i]['fullUrl'] = ( !empty($data['values']['videoUrl'][$i]) ) ? $data['values']['videoUrl'][$i] : $data['videos'][$i]['fullUrl'];
				//numbers next to section starts with 2
				$data['videos'][$i]['section-no'] = $i + 2;
			}
		}

		return parent::renderEditor($data);
	}
	
	public function render($data) {
		//mocked data TODO: remove once #fb98656 is done
		$model = new MarketingToolboxModel();
		$video = $model->getVideoData('LEGO The Lord of the Rings - Demo - E3 2012');
		$data = array(
			'headline' => 'Popular Videos (mocked data)',
			'videos' => array(
				array(
					'title' => 'LEGO The Lord of the Rings - Demo - E3 2012',
					'fileUrl' => '',
					'thumbMarkup' => $video['videoThumb'],
					'thumbUrl' => '',
					'duration' => '',
					'wikiUrl' => ''
				),
				array(
					'title' => 'LEGO The Lord of the Rings - Demo - E3 2012',
					'fileUrl' => '',
					'thumbMarkup' => $video['videoThumb'],
					'thumbUrl' => '',
					'duration' => '',
					'wikiUrl' => ''
				),
				array(
					'title' => 'LEGO The Lord of the Rings - Demo - E3 2012',
					'fileUrl' => '',
					'thumbMarkup' => $video['videoThumb'],
					'thumbUrl' => '',
					'duration' => '',
					'wikiUrl' => ''
				),
				array(
					'title' => 'LEGO The Lord of the Rings - Demo - E3 2012',
					'fileUrl' => '',
					'thumbMarkup' => $video['videoThumb'],
					'thumbUrl' => '',
					'duration' => '',
					'wikiUrl' => ''
				),
				array(
					'title' => 'LEGO The Lord of the Rings - Demo - E3 2012',
					'fileUrl' => '',
					'thumbMarkup' => $video['videoThumb'],
					'thumbUrl' => '',
					'duration' => '',
					'wikiUrl' => ''
				),
			)
		);
		//end of mocked data
		
		return parent::render($data);
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
			$toolboxModel = new MarketingToolboxModel();
			$moduleModel = new MarketingToolboxPopularvideosModel();

			$structuredData['header'] = $data['header'];

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
}
