<?php
class MarketingToolboxModuleFeaturedvideoService extends MarketingToolboxModuleService {
	protected function getFormFields() {
		return array(
			'video' => array(
				'type' => 'hidden',
				'attributes' => array(
					'class' => 'wmu-file-name-input required'
				),
				'validator' => new WikiaValidatorFileTitle(
					array(
						'required' => true
					),
					array('wrong-file' => 'marketing-toolbox-validator-wrong-file')
				)
			),
			'header' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-featured-video-header'),
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
			'description' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-featured-video-desc'),
				'validator' => new WikiaValidatorString(),
				'type' => 'textarea',
				'attributes' => array(
					'rows' => 3,
					'class' => 'required'
				)
			),
		);
	}
}