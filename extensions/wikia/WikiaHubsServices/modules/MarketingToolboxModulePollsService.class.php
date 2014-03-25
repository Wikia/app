<?php
class MarketingToolboxModulePollsService extends MarketingToolboxModuleEditableService {

	const MODULE_ID = 7;

	public function getFormFields() {
		$fields = array(
			'pollsTitle' => array(
				'label' => wfMessage('wikia-hubs-module-polls-title')->text(),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'wikia-hubs-validator-string-short')
				),
				'attributes' => array(
					'class' => 'required'
				)
			),
			'pollsQuestion' => array(
				'label' => wfMessage('wikia-hubs-module-polls-question')->text(),
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
				'label' => wfMessage('wikia-hubs-module-polls-option-mandatory',$i)->text(),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'wikia-hubs-validator-string-short')
				),
				'attributes' => array(
					'class' => 'required'
				)
			);
		}

		for ($j = $i; $j < $i+$voluntaryOptionsLimit; $j++) {
			$fields['pollsOption' . $j] = array(
				'label' => wfMessage('wikia-hubs-module-polls-option-voluntary',$j)->text(),
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


			$structuredData['headline'] = $data['pollsTitle'];
			$structuredData['pollsQuestion'] = $data['pollsQuestion'];
			$structuredData['hubUrl'] = $this->getHubUrl();

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

	protected function getHubUrl() {
		switch($this->getHubsVersion()) {
			case 3:
				global $wgCityId;
				$url = (new MarketingToolboxV3Model())->getHubUrl( $wgCityId );
				break;
			case 2:
			default:
				$url = (new MarketingToolboxModel())->getHubUrl( $this->langCode, $this->verticalId );
		}

		return $url;
	}
}
