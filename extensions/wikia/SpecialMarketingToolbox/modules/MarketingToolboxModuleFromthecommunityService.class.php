<?php
class MarketingToolboxModuleFromthecommunityService extends MarketingToolboxModuleService {
	static $fieldNames = array('photo', 'title', 'usersUrl', 'quote', 'url');

	protected function getFormFields() {

		$fields = array();

		$model = new MarketingToolboxFromthecommunityModel();
		$boxesCount = $model->getBoxesCount();

		for ($i = 1; $i <= $boxesCount; $i++) {
			$fields['photo' . $i] = array(
				'type' => 'hidden',
				'validator' => new WikiaValidatorFileTitle(
					array(
						'required' => true
					),
					array('wrong-file' => 'marketing-toolbox-validator-wrong-file')
				),
				'attributes' => array(
					'class' => "{required: {$this->getJsRequiredValidator($i, 'photo')}} wmu-file-name-input"
				),
				'class' => 'hidden'
			);

			$fields['title' . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-from-the-community-title'),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
				'attributes' => array(
					'class' => "{required: {$this->getJsRequiredValidator($i, 'title')}}"
				)
			);

			$fields['usersUrl' . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-from-the-community-users-url'),
				'validator' => new WikiaValidatorUrl(
					array(
						'required' => true
					)
				),
				'attributes' => array(
					'class' => "{required: {$this->getJsRequiredValidator($i, 'usersUrl')}, wikiaUrl: true}"
				),
				'class' => 'borderNone'
			);

			$fields['quote' . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-from-the-community-long-quote'),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
				'attributes' => array(
					'class' => "{required: {$this->getJsRequiredValidator($i, 'quote')}}"
				)
			);

			$fields['url' . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-from-the-community-url'),
				'validator' => new WikiaValidatorUrl(
					array(
						'required' => true
					)
				),
				'attributes' => array(
					'class' => "{required: {$this->getJsRequiredValidator($i, 'url')}, wikiaUrl: true}"
				),
				'class' => 'borderNone'
			);
		}

		return $fields;
	}

	protected function getJsRequiredValidator($i, $selectedField) {
		$dependentRules = array();
		foreach (self::$fieldNames as $fieldName) {
			if ($selectedField != $fieldName) {
				$dependentRules[] = "#MarketingToolbox$fieldName$i:filled";
			}
		}

		return "'" . implode(',', $dependentRules) . "'";
	}

	public function renderEditor($data) {
		$FTCModel = new MarketingToolboxFromthecommunityModel();
		$data['boxesCount'] = $FTCModel->getBoxesCount();
		$data['photos'] = array();

		$model = new MarketingToolboxModel();
		$imageSize = $model->getThumbnailSize();
		for ($i = 1; $i <= $data['boxesCount']; $i++) {
			if (!empty($data['values']['photo' . $i])) {
				$imageData = ImagesService::getLocalFileThumbUrlAndSizes($data['values']['photo' . $i], $imageSize);
				$data['photos'][$i]['url'] = $imageData->url;
				$data['photos'][$i]['imageWidth'] = $imageData->width;
				$data['photos'][$i]['imageHeight'] = $imageData->height;
			}
		}

		return parent::renderEditor($data);
	}
}