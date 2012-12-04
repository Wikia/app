<?
class MarketingToolboxModulePulseService extends MarketingToolboxModuleService {
	protected function getFormFields() {
		return array(
			'boardTitle' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-wikiurl'),
				'isRequired' => true,
				'attributes' => array(
					'data-min' => 1,
					// Placeholder can be put here
				),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					)
				),
			),
			'boardDescription' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-topic'),
				'isRequired' => true,
				'attributes' => array(
				),
				'validator' => new WikiaValidatorString(),
			),
			'stat1' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-stat1'),
				'isRequired' => true,
				'attributes' => array(
					'data-min' => 1,
				),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					)
				),
			),
			'stat2' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-stat2'),
				'isRequired' => true,
				'attributes' => array(
					'data-min' => 1,
				),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					)
				),
			),
			'stat3' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-stat3'),
				'isRequired' => true,
				'attributes' => array(
					'data-min' => 1,
				),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					)
				),
			),
			'number1' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-number1'),
				'isRequired' => true,
				'attributes' => array(
					'data-min' => 1,
				),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					)
				),
			),
			'number2' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-number2'),
				'isRequired' => true,
				'attributes' => array(
					'data-min' => 1,
				),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					)
				),
			),
			'number3' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-number3'),
				'isRequired' => true,
				'attributes' => array(
					'data-min' => 1,
				),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					)
				),
			),

		);
	}

	public function renderEditor($data) {
		return parent::renderEditor($data);
	}
}
?>