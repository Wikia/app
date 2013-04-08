<?
class MarketingToolboxModuleSliderService extends MarketingToolboxModuleEditableService {
	const MODULE_ID = 1;

	protected function getFormFields() {
		$fields = array();

		$model = new MarketingToolboxSliderModel();
		$slidesCount = $model->getSlidesCount();

		for ($i = 1; $i <= $slidesCount; $i++) {
			$fields['photo' . $i] = array(
				'type' => 'hidden',
				'validator' => new WikiaValidatorFileTitle(
					array(
						'required' => true
					),
					array('wrong-file' => 'marketing-toolbox-validator-wrong-file')
				),
				'attributes' => array(
					'class' => 'required wmu-file-name-input'
				),
				'class' => 'hidden'
			);

			$fields['shortDesc' . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-slider-short-description'),
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
			);

			$fields['longDesc' . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-slider-long-description'),
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
			);

			$fields['url' . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-slider-url'),
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
				'class' => 'borderNone'
			);
		}

		return $fields;
	}

	public function renderEditor($data) {
		$sliderModel = new MarketingToolboxSliderModel();
		$data['slidesCount'] = $sliderModel->getSlidesCount();
		$data['photos'] = array();

		$model = new MarketingToolboxModel();
		$imageSize = $model->getThumbnailSize();
		for ($i = 1; $i <= $data['slidesCount']; $i++) {
			if (!empty($data['values']['photo' . $i])) {
				$imageData = ImagesService::getLocalFileThumbUrlAndSizes($data['values']['photo' . $i], $imageSize);
				$data['photos'][$i]['url'] = $imageData->url;
				$data['photos'][$i]['imageWidth'] = $imageData->width;
				$data['photos'][$i]['imageHeight'] = $imageData->height;
			}
		}

		return parent::renderEditor($data);
	}

	public function filterData($data) {
		$data = parent::filterData($data);

		$model = new MarketingToolboxSliderModel();
		$slidesCount = $model->getSlidesCount();

		for ($i = 1; $i <= $slidesCount; $i++) {
			if (!empty($data['url' . $i])) {
				$data['url' . $i] = $this->addProtocolToLink($data['url' . $i]);
			}
		}

		return $data;
	}

	public function getStructuredData($data) {
		$model = new MarketingToolboxSliderModel();
		$slidesCount =  $model->getSlidesCount();
		$structuredData = array();

		if( !empty( $data ) ) {
			for( $i = 1; $i <= $slidesCount; $i++ ) {
				$imageData = ImagesService::getLocalFileThumbUrlAndSizes($data['photo'.$i]);
				$structuredData['slides'][] = array(
										'photoUrl' => $imageData->url,
										'shortDesc' => $data['shortDesc'.$i],
										'longDesc' => $data['longDesc'.$i],
										'url' => $data['url'.$i],
										'photoAlt' => $imageData->title

				);
			}
		}

		return $structuredData;
	}
}
