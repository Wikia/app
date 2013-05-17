<?php
class MarketingToolboxModulePollsService extends MarketingToolboxModuleEditableService {

	const MODULE_ID = 7;

	public function getFormFields() {
		$fields = array(
			'pollsTitle' => array(
				'label' => wfMsg('marketing-toolbox-hub-module-polls-title'),
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
			'pollsQuestion' => array(
				'label' => wfMsg('marketing-toolbox-hub-module-polls-question'),
				'validator' => new WikiaValidatorString(),
				'attributes' => array(
					'class' => 'required'
				)
			)
		);

		$model = new MarketingToolboxPollsModel();
		$mandatoryOptionsLimit = $model->getMandatoryOptionsLimit();
		$voluntaryOptionsLimit = $model->getVoluntaryOptionsLimit();

		for ($i = 1; $i <= $mandatoryOptionsLimit; $i++) {
			$fields['pollsOption' . $i] = array(
				'label' => wfMsg('marketing-toolbox-hub-module-polls-option-mandatory',$i),
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
			);
		}

		for ($j = $i; $j < $i+$voluntaryOptionsLimit; $j++) {
			$fields['pollsOption' . $j] = array(
				'label' => wfMsg('marketing-toolbox-hub-module-polls-option-voluntary',$j),
			);
		}

		return $fields;
	}

	public function renderEditor($data) {
		$model = new MarketingToolboxPollsModel();
		$data['optionsLimit'] = $model->getTotalOptionsLimit();

		return parent::renderEditor($data);
	}

	public function getWikitext($data) {
		$wtPolls  = "<poll>\n";
		$wtPolls .= $data['pollsQuestion'] . "\n";
		foreach($data['pollsOptions'] as $option) {
			$wtPolls .= $option . "\n";
		}
		$wtPolls .= "</poll>";

		return $wtPolls;
	}

	public function getStructuredData($data) {
		$structuredData = array();

		if(!empty($data['pollsTitle'])) {
			$model = new MarketingToolboxPollsModel();
			$optionsLimit = $model->getTotalOptionsLimit();

			$toolBoxModel = $this->getToolboxModel();

			$structuredData['headline'] = $data['pollsTitle'];
			$structuredData['pollsQuestion'] = $data['pollsQuestion'];
			$structuredData['hubUrl'] = $toolBoxModel->getHubUrl($this->langCode, $this->verticalId);

			for ($i = 1; $i <= $optionsLimit; $i++) {
				if(isset($data['pollsOption' . $i])) {
					$structuredData['pollsOptions'][] = $data['pollsOption' . $i];
				}
			}
		}

		return $structuredData;
	}

	public function render($structureData) {
		$data['headline'] = $structureData['headline'];
		$data['wikitextpolls'] = $this->getWikitext($structureData);

		return parent::render($data);
	}

	protected function getToolboxModel() {
		return new MarketingToolboxModel();
	}
}