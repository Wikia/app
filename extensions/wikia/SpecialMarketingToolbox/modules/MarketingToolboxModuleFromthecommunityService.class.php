<?php
class MarketingToolboxModuleFromthecommunityService extends MarketingToolboxModuleService {
	const FIRST_SECTION_INDEX = 1;

	const FIELD_NAME_PHOTO = 'photo';
	const FIELD_NAME_TITLE = 'title';
	const FIELD_NAME_USERSURL = 'usersUrl';
	const FIELD_NAME_QUOTE = 'quote';
	const FIELD_NAME_URL = 'url';

	static $fieldNames = array('photo', 'title', 'usersUrl', 'quote', 'url');

	protected function getFormFields() {

		$fields = array();

		$model = new MarketingToolboxFromthecommunityModel();
		$boxesCount = $model->getBoxesCount();

		for ($i = self::FIRST_SECTION_INDEX; $i <= $boxesCount; $i++) {
			$fields[self::FIELD_NAME_PHOTO . $i] = array(
				'type' => 'hidden',
				'validator' => $this->getValidator($i, self::FIELD_NAME_PHOTO),
				'attributes' => array(
					'class' => $this->getJsValidator($i, self::FIELD_NAME_PHOTO) . ' wmu-file-name-input'
				),
				'class' => 'hidden'
			);

			$fields[self::FIELD_NAME_TITLE . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-from-the-community-title'),
				'validator' => $this->getValidator($i, self::FIELD_NAME_TITLE),
				'attributes' => array(
					'class' => $this->getJsValidator($i, self::FIELD_NAME_TITLE)
				)
			);

			$fields[self::FIELD_NAME_USERSURL . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-from-the-community-users-url'),
				'validator' => $this->getValidator($i, self::FIELD_NAME_USERSURL),
				'attributes' => array(
					'class' => $this->getJsValidator($i, self::FIELD_NAME_USERSURL)
				)
			);

			$fields[self::FIELD_NAME_QUOTE . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-from-the-community-long-quote'),
				'validator' => $this->getValidator($i, self::FIELD_NAME_QUOTE),
				'attributes' => array(
					'class' => $this->getJsValidator($i, self::FIELD_NAME_QUOTE)
				)
			);

			$fields[self::FIELD_NAME_URL . $i] = array(
				'label' => $this->wf->msg('marketing-toolbox-hub-module-from-the-community-url'),
				'validator' => $this->getValidator($i, self::FIELD_NAME_URL),
				'attributes' => array(
					'class' => $this->getJsValidator($i, self::FIELD_NAME_URL)
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

	protected function getValidator($index, $fieldName) {
		$validator = null;
		
		switch ($fieldName) {
			case self::FIELD_NAME_PHOTO:
				$validator = new WikiaValidatorFileTitle(
					array(
						'required' => true
					),
					array('wrong-file' => 'marketing-toolbox-validator-wrong-file')
				);
				break;
			case self::FIELD_NAME_TITLE:
			case self::FIELD_NAME_QUOTE:
				$validator = new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				);
				break;
			case self::FIELD_NAME_URL:
			case self::FIELD_NAME_USERSURL:
				$validator = new WikiaValidatorUrl(
					array(
						'required' => true
					),
					array(
						'wrong' => 'marketing-toolbox-validator-wrong-url'
					)
				);
				break;
		}

		if ($index != self::FIRST_SECTION_INDEX) {
			$validator = new WikiaValidatorDependent(
				array(
					'required' => false,
					'ownValidator' => $validator,
					'dependentFields' => $this->getDependentFields($index, $fieldName)
				)
			);
		}

		return $validator;
	}

	protected function getJsValidator($index, $fieldName) {
		$out = '';
		if ($index == self::FIRST_SECTION_INDEX) {
			$out .= 'required';
		} else {
			$out .= "{required: {$this->getJsRequiredValidator($index, $fieldName)}}";
		}

		if (in_array($fieldName, array('url', 'usersUrl'))) {
			$out .= ' wikiaUrl';
		}

		return $out;
	}

	protected function getJsRequiredValidator($i, $actualFieldName) {
		$dependentRules = array();
		foreach (self::$fieldNames as $fieldName) {
			if ($actualFieldName != $fieldName) {
				$dependentRules[] = '#' . MarketingToolboxModel::FORM_FIELD_PREFIX . $fieldName .$i . ':filled';
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
