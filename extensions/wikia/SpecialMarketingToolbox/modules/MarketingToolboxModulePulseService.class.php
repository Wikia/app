<?
class MarketingToolboxModulePulseService extends MarketingToolboxModuleService {
	protected function getValidationRules() {
		return array(
			'test' => 1,
			'halo' => 2
		);
	}
	public function renderEditor($data) {
		$data['form'] = array(
			'inputs' => array(
				array(
					'type' => 'raw',
					'output' => '<div class="grid-4 alpha url-and-topic">',
				),
				array(
					'type' => 'text',
					'name' => 'boardTitle',
					'isRequired' => true,
					'label' => F::app()->wf->msg('marketing-toolbox-hub-module-pulse-wikiurl'),
					'attributes' => array(
						'maxlength' => '40'
					),
				),
				array(
					'type' => 'text',
					'name' => 'boardDescription',
					'isRequired' => true,
					'label' => F::app()->wf->msg('marketing-toolbox-hub-module-pulse-topic'),
					'attributes' => array(
						'maxlength' => '255'
					),
				),
				array(
					'type' => 'raw',
					'output' => '</div>',
				),
				array(
					'type' => 'raw',
					'output' => '<div class="grid-2 alpha">',
				),
				array(
					'type' => 'text',
					'name' => 'boardTitle',
					'isRequired' => true,
					'label' => F::app()->wf->msg('marketing-toolbox-hub-module-pulse-stat1'),
					'attributes' => array(
						'maxlength' => '40'
					),
				),
				array(
					'type' => 'text',
					'name' => 'boardDescription',
					'isRequired' => true,
					'label' => F::app()->wf->msg('marketing-toolbox-hub-module-pulse-stat2'),
					'attributes' => array(
						'maxlength' => '255'
					),
				),
				array(
					'type' => 'text',
					'name' => 'boardDescription',
					'isRequired' => true,
					'label' => F::app()->wf->msg('marketing-toolbox-hub-module-pulse-stat3'),
					'attributes' => array(
						'maxlength' => '255'
					),
				),
				array(
					'type' => 'raw',
					'output' => '</div><div class="grid-2 alpha">',
				),
				array(
					'type' => 'text',
					'name' => 'boardTitle',
					'isRequired' => true,
					'label' => F::app()->wf->msg('marketing-toolbox-hub-module-pulse-number1'),
					'attributes' => array(
						'maxlength' => '40'
					),
				),
				array(
					'type' => 'text',
					'name' => 'boardDescription',
					'isRequired' => true,
					'label' => F::app()->wf->msg('marketing-toolbox-hub-module-pulse-number2'),
					'attributes' => array(
						'maxlength' => '255'
					),
				),
				array(
					'type' => 'text',
					'name' => 'boardDescription',
					'isRequired' => true,
					'label' => F::app()->wf->msg('marketing-toolbox-hub-module-pulse-number3'),
					'attributes' => array(
						'maxlength' => '255'
					),
				),
				array(
					'type' => 'raw',
					'output' => '</div>',
				),
			),
			'submits' => array(
				array(
					'value' => F::app()->wf->msg('marketing-toolbox-edithub-save-button')
				)
			),
			'method' => 'post',
			'action' => '',
		);
		return parent::renderEditor($data);
	}
}
?>