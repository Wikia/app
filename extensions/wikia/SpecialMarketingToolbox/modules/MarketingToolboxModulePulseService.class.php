<?
class MarketingToolboxModulePulseService extends MarketingToolboxModuleService {
	protected function getFormFields() {
		return array(
			'boardUrl' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-wikiurl'),
				'isRequired' => false,
				'validator' => new WikiaValidatorUrl(),
			),
			'boardTitle' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-topic'),
				'isRequired' => true,
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
			),
			'stat1' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-stat1'),
				'isRequired' => true,
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
			),
			'stat2' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-stat2'),
				'isRequired' => true,
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
			),
			'stat3' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-stat3'),
				'isRequired' => true,
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
			),
			'number1' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-number1'),
				'isRequired' => true,
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
			),
			'number2' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-number2'),
				'isRequired' => true,
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
			),
			'number3' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-number3'),
				'isRequired' => true,
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
			),

		);
	}

	public function renderEditor($data) {
		return parent::renderEditor($data);
	}

	public function filterData($data) {
		$data = parent::filterData($data);

		if (strpos($data['boardUrl'], 'http://') === false) {
			$data['boardUrl'] = 'http://' . $data['boardUrl'];
		}

		return $data;
	}
}
?>