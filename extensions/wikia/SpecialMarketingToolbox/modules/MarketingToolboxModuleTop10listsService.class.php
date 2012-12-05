<?
class MarketingToolboxModuleTop10listsService extends MarketingToolboxModuleService {
	protected function getFormFields() {
		return array(
			'boardTitle' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-top10lists-title'),
				'isRequired' => true,
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
			),
			'boardDescription' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-top10lists-desc'),
				'isRequired' => false,
				'validator' => new WikiaValidatorString(),
				'type' => 'textarea',
				'attributes' => array(
					'rows' => 4
				)
			),
		);
	}
}