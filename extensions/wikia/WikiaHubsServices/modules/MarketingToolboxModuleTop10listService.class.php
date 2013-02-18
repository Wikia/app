<?
class MarketingToolboxModuleTop10listService extends MarketingToolboxModuleService {
	const MODULE_ID = 8;

	protected function getFormFields() {
		return array(
			'boardTitle' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-top10list-title'),
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
			'boardDescription' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-top10list-desc'),
				'validator' => new WikiaValidatorString(),
				'type' => 'textarea',
				'attributes' => array(
					'rows' => 4
				)
			),
		);
	}

	public function renderEditor($data) {
		$model = new MarketingToolboxTop10listModel();
		$data['list'] = $model->getWikiListByCategoryId($this->langCode, $this->verticalId);

		return parent::renderEditor($data);
	}
}