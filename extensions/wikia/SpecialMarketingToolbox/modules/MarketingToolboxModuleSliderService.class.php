<?
class MarketingToolboxModuleSliderService extends MarketingToolboxModuleService {
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
				'validator' => new WikiaValidatorUrl(
					array(
						'required' => true
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
}
