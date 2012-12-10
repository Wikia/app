<?php
class MarketingToolboxModuleExploreService extends MarketingToolboxModuleService {
	protected function getFormFields() {
		return array(
			'exploreTitle' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-explore-title'),
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
}
?>