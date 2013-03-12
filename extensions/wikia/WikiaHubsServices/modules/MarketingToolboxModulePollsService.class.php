<?php
class MarketingToolboxModulePollsService extends MarketingToolboxModuleEditableService {

	const MODULE_ID = 7;

	protected function getFormFields() {
		$fields = array(
			'pollsTitle' => array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-polls-title'),
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
				'label' => $this->wf->msg('marketing-toolbox-hub-module-polls-question'),
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
				'label' => $this->wf->msg('marketing-toolbox-hub-module-polls-option-mandatory',$i),
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
				'label' => $this->wf->msg('marketing-toolbox-hub-module-polls-option-voluntary',$j),
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


	public function getHubUrl() {
		$visualizationData = $this->getVisualizationData();

		if (!isset($visualizationData[$this->langCode]['url'])) {
			throw new Exception('Corporate Wiki not defined for this lang');
		}

		$hubPages = F::app()->wg->WikiaHubsV2Pages;
		if (!isset($hubPages[$this->verticalId])) {
			throw new Exception('Hub page not defined for selected vertical');
		}

		$url = http_build_url(
			$visualizationData[$this->langCode]['url'],
			array(
				'path' => $hubPages[$this->verticalId]
			),
			HTTP_URL_JOIN_PATH
		);

		return $url;
	}

	protected function getVisualizationData() {
		$visualizationModel = new CityVisualization();
		return $visualizationModel->getVisualizationWikisData();
	}
}