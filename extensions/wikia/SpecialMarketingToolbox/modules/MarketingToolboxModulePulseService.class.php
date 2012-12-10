<?
class MarketingToolboxModulePulseService extends MarketingToolboxModuleService {
	protected function getFormFields() {
		return array(
			'boardUrl' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-wikiurl'),
				'isRequired' => false,
				'validator' => new WikiaValidatorUrl(),
				'attributes' => array(
					'class' => 'wikiaUrl'
				)
			),
			'boardTitle' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-topic'),
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
			'stat1' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-stat1'),
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
			'stat2' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-stat2'),
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
			'stat3' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-stat3'),
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
			'number1' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-number1'),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
				'attributes' => array(
					'class' => 'required'
					//'{required: \'#MarketingToolboxstat1:filled\'}'
				)
			),
			'number2' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-number2'),
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
			'number3' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-pulse-number3'),
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

		);
	}

	public function renderEditor($data) {
		return parent::renderEditor($data);
	}

	public function filterData($data) {
		$data = parent::filterData($data);

		if (!empty($data['boardUrl']) && strpos($data['boardUrl'], 'http://') === false) {
			$data['boardUrl'] = 'http://' . $data['boardUrl'];
		}

		return $data;
	}
}
?>