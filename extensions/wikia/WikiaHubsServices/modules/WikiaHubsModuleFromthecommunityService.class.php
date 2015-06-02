<?php
class WikiaHubsModuleFromthecommunityService extends WikiaHubsModuleEditableService {
	const FIRST_SECTION_INDEX = 1;

	const FIELD_NAME_PHOTO = 'photo';
	const FIELD_NAME_TITLE = 'title';
	const FIELD_NAME_USERSURL = 'usersUrl';
	const FIELD_NAME_QUOTE = 'quote';
	const FIELD_NAME_URL = 'url';
	const FIELD_NAME_MODULE_TITLE = 'headline';
	const FIELD_NAME_SUGGEST_ARTICLE = 'suggest';

	const MODULE_ID = 6;

	static $fieldNames = array('photo', 'title', 'usersUrl', 'quote', 'url');
	
	/**
	 * @var $model WikiaHubsFromthecommunityModel
	 */
	protected $model = null;

	public function getFormFields() {
		$fields = array();
		$boxesCount = $this->getModel()->getBoxesCount();

		$fields[self::FIELD_NAME_MODULE_TITLE] = array(
			'type' => 'text',
			'label' => wfMsg('wikia-hubs-module-from-the-community-title'),
			'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array(
						'too_short' => 'wikia-hubs-string-short'
					)
				),
			'attributes' => array(
				'class' => 'required'
			)
		);

		$fields[self::FIELD_NAME_SUGGEST_ARTICLE] = array(
			'type' => 'text',
			'label' => wfMsg('wikia-hubs-module-from-the-community-suggest'),
			'validator' => new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 1
				),
				array(
					'too_short' => 'wikia-hubs-string-short'
				)
			),
			'attributes' => array(
				'class' => 'required'
			)
		);

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
				'label' => wfMessage('wikia-hubs-module-from-the-community-title')->text(),
				'validator' => $this->getValidator($i, self::FIELD_NAME_TITLE),
				'attributes' => array(
					'class' => $this->getJsValidator($i, self::FIELD_NAME_TITLE)
				)
			);

			$fields[self::FIELD_NAME_USERSURL . $i] = array(
				'label' => wfMessage('wikia-hubs-module-from-the-community-users-url')->text(),
				'validator' => $this->getValidator($i, self::FIELD_NAME_USERSURL),
				'attributes' => array(
					'class' => $this->getJsValidator($i, self::FIELD_NAME_USERSURL)
				)
			);

			$fields[self::FIELD_NAME_QUOTE . $i] = array(
				'type' => 'textarea',
				'label' => wfMessage('wikia-hubs-module-from-the-community-long-quote')->text(),
				'validator' => $this->getValidator($i, self::FIELD_NAME_QUOTE),
				'attributes' => array(
					'class' => $this->getJsValidator($i, self::FIELD_NAME_QUOTE),
					'rows' => 3
				)
			);

			$fields[self::FIELD_NAME_URL . $i] = array(
				'label' => wfMessage('wikia-hubs-module-from-the-community-url')->text(),
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
					array('wrong-file' => 'wikia-hubs-validator-wrong-file')
				);
				break;
			case self::FIELD_NAME_TITLE:
			case self::FIELD_NAME_QUOTE:
				$validator = new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'wikia-hubs-validator-string-short')
				);
				break;
			case self::FIELD_NAME_URL:
				$validator = new WikiaValidatorUrl(
					array(
						'required' => true
					),
					array(
						'wrong' => 'wikia-hubs-validator-wrong-url'
					)
				);
				break;
			case self::FIELD_NAME_USERSURL:
				$validator = new WikiaValidatorUsersUrl(
					array(
						'required' => true
					),
					array(
						'wrong' => 'wikia-hubs-validator-wrong-url',
						'wrong-users-url' => 'wikia-hubs-validator-wrong-users-url'
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
				$dependentRules[] = '#' . EditHubModel::FORM_FIELD_PREFIX . $fieldName .$i . ':filled';
			}
		}

		return "'" . implode(',', $dependentRules) . "'";
	}

	public function renderEditor($data) {
		$data['boxesCount'] = $this->getModel()->getBoxesCount();
		$data['photos'] = array();

		$model = new EditHubModel();
		$imageSize = $model->getThumbnailSize();
		for ($i = 1; $i <= $data['boxesCount']; $i++) {
			$photoField = $data['form']->getField('photo' . $i);
			if (!empty($photoField['value'])) {
				$imageData = $this->getImageInfo($photoField['value']);

				$data['photos'][$i]['url'] = $imageData->getUrlGenerator()->width($imageSize)->url();
				$data['photos'][$i]['imageWidth'] = $imageData->getWidth();
				$data['photos'][$i]['imageHeight'] = $imageData->getHeight();
			}
		}

		return parent::renderEditor($data);
	}

	public function filterData($data) {
		$data = parent::filterData($data);
		$boxesCount = $this->getModel()->getBoxesCount();

		for ($i = 1; $i <= $boxesCount; $i++) {
			if (!empty($data[self::FIELD_NAME_URL  . $i])) {
				$data[self::FIELD_NAME_URL  . $i] = $this->addProtocolToLink($data[self::FIELD_NAME_URL . $i]);
			}

			if (!empty($data[self::FIELD_NAME_USERSURL . $i])) {
				$data['usersUrl' . $i] = $this->addProtocolToLink($data[self::FIELD_NAME_USERSURL . $i]);

				// get Wiki URL
				$parsedUrl = parse_url($data[self::FIELD_NAME_USERSURL . $i]);
				$data['wikiUrl' . $i] = $parsedUrl['host'];

				$userName = UserService::getNameFromUrl($data[self::FIELD_NAME_USERSURL . $i]);
				if ($userName !== false) {
					$data['UserName' . $i] = $userName;
				}
			}
			if( !empty($data[self::FIELD_NAME_QUOTE . $i]) ) {
				$model = new EditHubModel();
				$data[self::FIELD_NAME_QUOTE . $i] = strip_tags($data[self::FIELD_NAME_QUOTE . $i], $model->getAllowedTags());
			}
		}
		return $data;
	}

	public function getStructuredData($data) {
		$boxesCount = $this->getModel()->getBoxesCount();
		
		$entries = array();
		for($i = 1; $i <= $boxesCount; $i++) {
			if( $this->isEntryFilledIn($i, $data) ) {
				$entries[] = array(
					'articleTitle' => $data['title' . $i],
					'articleUrl' => str_replace(' ', '_', $data['url' . $i]),
					'userName' => $data['UserName' . $i],
					'userUrl' => str_replace(' ', '_', $data['usersUrl' . $i]),
					'wikiUrl' => $data['wikiUrl' . $i],
					'quote' => $data['quote' . $i],
					'photoName' => isset($data['photo'.$i]) ? $data['photo'.$i] : ''
				);

				if( !empty($data['photo' . $i]) ) {
					$imageData = $this->getImageInfo($data['photo' . $i]);

					if ($imageData) {
						$entries['imageAlt'] = $imageData->getName();
						$entries['imageUrl'] = $imageData->getUrl();
					}
				}
			}
		}
		
		return array(
			'headline' => isset($data[self::FIELD_NAME_MODULE_TITLE]) ? $data[self::FIELD_NAME_MODULE_TITLE] : '',
			'button' => isset($data[self::FIELD_NAME_SUGGEST_ARTICLE]) ? $data[self::FIELD_NAME_SUGGEST_ARTICLE] : '',
			'entries' => $entries
		);
	}
	
	protected function isEntryFilledIn($entryId, $data) {
		//photo is optional but the rest shouldn't be empty
		return (
			!empty($data['title' . $entryId]) &&
			!empty($data['url' . $entryId]) &&
			!empty($data['UserName' . $entryId]) &&
			!empty($data['usersUrl' . $entryId]) &&
			!empty($data['wikiUrl' . $entryId]) &&
			!empty($data['quote' . $entryId])
		);
	}
	
	public function getModel() {
		if( is_null($this->model) ) {
			$this->model = new WikiaHubsFromthecommunityModel();
		}
		
		return $this->model;
	}

	/**
	 * Remove entries from NC licensed wikis.
	 * @param $data
	 * @return mixed
	 */
	protected function filterCommercialData( $data ) {
		$service = $this->getLicensedWikisService();
		$data['entries'] = array_values( array_filter( $data['entries'], function( $element ) use($service) {
			return $service->isCommercialUseAllowedByUrl($element['articleUrl']);
		} ) );
		return $data;
	}
}
