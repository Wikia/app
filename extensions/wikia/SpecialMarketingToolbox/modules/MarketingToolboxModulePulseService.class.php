<?
class MarketingToolboxModulePulseService extends MarketingToolboxModuleService {
	protected function getValidationRules() {
		return array(
			'boardTitle' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 10,
					'max' => 20
				)
			),
			'boardDescription' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 10,
					'max' => 20
				)
			),
			'stat1' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 10,
					'max' => 20
				)
			),
			'stat2' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 10,
					'max' => 20
				)
			),
			'stat3' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 10,
					'max' => 20
				)
			),
			'number1' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 10,
					'max' => 20
				)
			),
			'number2' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 10,
					'max' => 20
				)
			),
			'number3' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 10,
					'max' => 20
				)
			),
		);
	}

	protected function getFormFields() {
		return array(
			'boardTitle' => array(
				'label' => F::app()->wf->msg('marketing-toolbox-hub-module-pulse-wikiurl'),
				'isRequired' => true,
				'attributes' => array(
					'maxlength' => '40',
					// Placeholder can be put here
				),
			),
			'boardDescription' => array(
				'label' => F::app()->wf->msg('marketing-toolbox-hub-module-pulse-topic'),
				'isRequired' => true,
				'attributes' => array(
					'maxlength' => '255'
				),
			),
			'stat1' => array(
				'label' => F::app()->wf->msg('marketing-toolbox-hub-module-pulse-stat1'),
				'isRequired' => true,
				'attributes' => array(
					'maxlength' => '255'
				),
			),
			'stat2' => array(
				'label' => F::app()->wf->msg('marketing-toolbox-hub-module-pulse-stat2'),
				'isRequired' => true,
				'attributes' => array(
					'maxlength' => '255'
				),
			),
			'stat3' => array(
				'label' => F::app()->wf->msg('marketing-toolbox-hub-module-pulse-stat3'),
				'isRequired' => true,
				'attributes' => array(
					'maxlength' => '255'
				),
			),
			'number1' => array(
				'label' => F::app()->wf->msg('marketing-toolbox-hub-module-pulse-number1'),
				'isRequired' => true,
				'attributes' => array(
					'maxlength' => '40'
				),
			),
			'number2' => array(
				'label' => F::app()->wf->msg('marketing-toolbox-hub-module-pulse-number2'),
				'isRequired' => true,
				'attributes' => array(
					'maxlength' => '40'
				),
			),
			'number3' => array(
				'label' => F::app()->wf->msg('marketing-toolbox-hub-module-pulse-number3'),
				'isRequired' => true,
				'attributes' => array(
					'maxlength' => '40'
				),
			),

		);
	}

	public function renderEditor($data) {
		return parent::renderEditor($data);
	}
}
?>