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
				'validator' => new WikiaValidatorDependent(
					array(
						'required' => false,
						'ownValidator' => new WikiaValidatorFileTitle(
							array(
								'required' => true
							),
							array('wrong-file' => 'marketing-toolbox-validator-wrong-file')
						),
						'dependentFields' => $this->getDependentFields($i, 'photo')
					)
				),
				'attributes' => array(
					'class' => "{required: {$this->getJsRequiredValidator($i, 'photo')}} wmu-file-name-input"
				),
				'class' => 'hidden'
			);

			$fields['title' . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-from-the-community-title'),
				'validator' => new WikiaValidatorDependent(
					array(
						'required' => false,
						'ownValidator' => new WikiaValidatorString(
							array(
								'required' => true,
								'min' => 1
							),
							array('too_short' => 'marketing-toolbox-validator-string-short')
						),
						'dependentFields' => $this->getDependentFields($i, 'title')
					)
				),
				'attributes' => array(
					'class' => "{required: {$this->getJsRequiredValidator($i, 'title')}}"
				)
			);

			$fields['usersUrl' . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-from-the-community-users-url'),
				'validator' => new WikiaValidatorDependent(
					array(
						'required' => false,
						'ownValidator' => new WikiaValidatorToolboxUrl(
							array(
								'required' => true
							),
							array(
								'wrong' => 'marketing-toolbox-validator-wrong-url'
							)
						),
						'dependentFields' => $this->getDependentFields($i, 'usersUrl')
					)
				),
				'attributes' => array(
					'class' => "{required: {$this->getJsRequiredValidator($i, 'usersUrl')}, wikiaUrl: true}"
				)
			);

			$fields['quote' . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-from-the-community-long-quote'),
				'validator' => new WikiaValidatorDependent(
					array(
						'required' => false,
						'ownValidator' => new WikiaValidatorString(
							array(
								'required' => true,
								'min' => 1
							),
							array('too_short' => 'marketing-toolbox-validator-string-short')
						),
						'dependentFields' => $this->getDependentFields($i, 'quote')
					)
				),
				'attributes' => array(
					'class' => "{required: {$this->getJsRequiredValidator($i, 'quote')}}"
				)
			);

			$fields['url' . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-from-the-community-url'),
				'validator' => new WikiaValidatorDependent(
					array(
						'required' => false,
						'ownValidator' => new WikiaValidatorToolboxUrl(
							array(
								'required' => true
							),
							array(
								'wrong' => 'marketing-toolbox-validator-wrong-url'
							)
						),
						'dependentFields' => $this->getDependentFields($i, 'url')
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

	protected function getDependentFields($i, $actualFieldName) {
		$out = array();
		foreach (self::$fieldNames as $fieldName) {
			if ($actualFieldName != $fieldName) {
				$out[$fieldName . $i] = new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					)
				);
			}
		}
		return $out;
	}

	protected function getJsRequiredValidator($i, $actualFieldName) {
		$dependentRules = array();
		foreach (self::$fieldNames as $fieldName) {
			if ($actualFieldName != $fieldName) {
				$dependentRules[] = '#' . MarketingToolboxModel::FORM_FIELD_PREFIX . $fieldName . ':filled';
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

	public function filterData($data) {
		$data = parent::filterData($data);

		$model = new MarketingToolboxFromthecommunityModel();
		$boxesCount = $model->getBoxesCount();

		for ($i = 1; $i <= $boxesCount; $i++) {
			if (!empty($data['url' . $i])) {
				$data['url' . $i] = $this->addProtocolToLink($data['url' . $i]);
			}


			if (!empty($data['usersUrl' . $i])) {
				$data['usersUrl' . $i] = $this->addProtocolToLink($data['usersUrl' . $i]);

				// get Wiki URL
				$parsedUrl = parse_url($data['usersUrl' . $i]);
				$data['wikiUrl' . $i] = $parsedUrl['host'];

				// get User Name
				$userUrlParted = explode(':', $data['usersUrl' . $i], 3);
				$user = User::newFromName($userUrlParted[2]);
				$data['UserName' . $i] = $user->getName();
			}
		}
		return $data;
	}
}