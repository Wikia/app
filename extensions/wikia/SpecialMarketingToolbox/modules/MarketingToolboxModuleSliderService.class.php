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
					)
				),
				'attributes' => array(
					'class' => 'required'
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
		$model = new MarketingToolboxSliderModel();
		$data['slidesCount'] = $model->getSlidesCount();

		return parent::renderEditor($data);
	}
}
