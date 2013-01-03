<?php
class MarketingToolboxModuleWikiaspicksService extends MarketingToolboxModuleService {
	protected function getFormFields() {
		$fields = array(
			'fileName' => array(
				'type' => 'hidden',
				'attributes' => array(
					'class' => 'wmu-file-name-input'
				),
				'validator' => new WikiaValidatorFileTitle(
					array(),
					array('wrong-file' => 'marketing-toolbox-validator-wrong-file')
				)
			),
			'header' => array(
				'label' => $this->wf->Msg('marketing-toolbox-hub-module-wikiaspicks-header'),
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
			'text' => array(
				'validator' => new WikiaValidatorFileTitle(
					array(),
					array('wrong-file' => 'marketing-toolbox-validator-wrong-file')
				),
				'type' => 'textarea',
				'attributes' => array(
					'class' => 'required',
					'rows' => 4
				)
			)
		);

		return $fields;
	}
}