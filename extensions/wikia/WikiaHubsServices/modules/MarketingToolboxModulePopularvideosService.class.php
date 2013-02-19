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
			foreach($data['values']['video'] as $i => $video) {
				$data['videos'][$i]['title'] = $video;
				$videoData = $model->getVideoData($video);
				$data['videos'][$i]['videoThumb'] = $videoData['videoThumb'];
				$data['videos'][$i]['videoTimestamp'] = $videoData['videoTimestamp'];
				//we enabled curators to edit a video url so if they've changed it we change it here
				$data['videos'][$i]['fullUrl'] = ( !empty($data['values']['videoUrl'][$i]) ) ? $data['values']['videoUrl'][$i] : $data['videos'][$i]['fullUrl'];
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
}
