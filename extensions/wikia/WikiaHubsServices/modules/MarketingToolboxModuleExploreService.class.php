<?php
class MarketingToolboxModuleExploreService extends MarketingToolboxModuleEditableService {
	const SECTION_FIELD_PREFIX = 'exploreSectionHeader';
	const LINK_TEXT = 'exploreLinkText';
	const LINK_URL = 'exploreLinkUrl';

	const MODULE_ID = 5;

	protected $lettersMap = array('a', 'b', 'c', 'd', 'e');

	/**
	 * @var MarketingToolboxExploreModel|null
	 */
	protected $model;
	protected $sectionsLimit;
	protected $linksLimit;

	public function __construct($langCode, $sectionId, $verticalId) {
		parent::__construct($langCode, $sectionId, $verticalId);

		$this->model = new MarketingToolboxExploreModel();
		$this->sectionsLimit = $this->model->getFormSectionsLimit();
		$this->linksLimit = $this->model->getLinksLimit();
	}

	public function getFormFields() {
		$formFields = array(
			'exploreTitle' => array(
				'label' => $this->wf->Msg('marketing-toolbox-hub-module-explore-title'),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
				'attributes' => array(
					'class' => 'required explore-mainbox-input'
				)
			),
			'fileName' => array(
				'type' => 'hidden',
				'attributes' => array(
					'class' => 'wmu-file-name-input'
				),
				'validator' => new WikiaValidatorFileTitle(
					array(),
					array('wrong-file' => 'marketing-toolbox-validator-wrong-file')
				)
			),
			'imageLink' => array(
				'label' => $this->wf->Msg('marketing-toolbox-hub-module-explore-link-url'),
				'validator' => new WikiaValidatorToolboxUrl(
					array(),
					array(
						'wrong' => 'marketing-toolbox-validator-wrong-url'
					)
				),
				'icon' => true,
				'attributes' => array(
					'class' => 'wikiaUrl explore-mainbox-input'
				)
			),
		);

		for($sectionIdx = 1; $sectionIdx <= $this->sectionsLimit; $sectionIdx++) {
			$formFields = $formFields + $this->generateSectionHeaderField($sectionIdx);

			for($linkIdx = 0; $linkIdx < $this->linksLimit; $linkIdx++) {
				$formFields = $formFields + $this->generateSectionLinkFields($sectionIdx, $linkIdx);
			}
		}

		return $formFields;
	}

	protected function generateSectionHeaderField($sectionIdx) {
		$fieldName = self::SECTION_FIELD_PREFIX . $sectionIdx;
		return array(
			$fieldName => array(
				'label' => $this->wf->MsgExt('marketing-toolbox-hub-module-explore-header', array('parseinline'), $sectionIdx),
				'validator' => new WikiaValidatorDependent(
					array(
						'required' => false,
						'ownValidator' => new WikiaValidatorString(
							array(
								'required' => true,
								'min' => 1
							),
							array(
								'too_short' => 'marketing-toolbox-validator-string-short'
							)
						),
						'dependentFields' => $this->getDependentFields($sectionIdx)
					)
				),
				'attributes' => array(
					'class' => "{required: {$this->getJsRequiredValidator($sectionIdx)}}"
				)
			)
		);
	}

	protected function generateSectionLinkFields($sectionIdx, $linkIdx) {
		$linkUrlFieldName = $this->generateUrlFieldName($sectionIdx, $linkIdx);

		$linkUrlField = array(
			'label' => $this->wf->Msg('marketing-toolbox-hub-module-explore-link-url'),
			'labelclass' => "wikiaUrlLabel",
			'validator' => new WikiaValidatorToolboxUrl(
				array(),
				array(
					'wrong' => 'marketing-toolbox-validator-wrong-url'
				)
			),
			'attributes' => array(
				'class' => "wikiaUrl",
			),
			'icon' => true
		);

		$linkHeaderFieldName = $this->generateHeaderFieldName($sectionIdx, $linkIdx);
		$linkHeaderField = array(
			'label' => $this->wf->MsgExt('marketing-toolbox-hub-module-explore-header', array('parseinline'), $this->lettersMap[$linkIdx]),
			'validator' => new WikiaValidatorDependent(
				array(
					'required' => false,
					'ownValidator' => new WikiaValidatorString(
						array(
							'required' => true,
							'min' => 1
						),
						array(
							'too_short' => 'marketing-toolbox-hub-module-explore-link-text-too-short-error'
						)
					),
					'dependentFields' => array(
						$linkUrlFieldName => new WikiaValidatorString(
							array(
								'required' => true,
								'min' => 1
							)
						)
					)
				)
			),
			'attributes' => array(
				'class' => "{required: '#" . MarketingToolboxModel::FORM_FIELD_PREFIX . $linkUrlFieldName . ":filled'}"
			)
		);

		return array(
			$linkHeaderFieldName => $linkHeaderField,
			$linkUrlFieldName => $linkUrlField,
		);
	}

	protected function getDependentFields($sectionIdx) {
		$fields = array();

		for($linkIdx = 0; $linkIdx < $this->linksLimit; $linkIdx++) {
			$urlFieldName = $this->generateUrlFieldName($sectionIdx, $linkIdx);
			$headerFieldName = $this->generateHeaderFieldName($sectionIdx, $linkIdx);

			$fields[$urlFieldName] = new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 1
				)
			);

			$fields[$headerFieldName] = new WikiaValidatorString(
				array(
					'required' => true,
					'min' => 1
				)
			);
		}

		return $fields;
	}

	protected function getJsRequiredValidator($sectionIdx) {
		$dependentRules = array();

		for($linkIdx = 0; $linkIdx < $this->linksLimit; $linkIdx++) {
			$urlFieldName = $this->generateUrlFieldName($sectionIdx, $linkIdx);
			$headerFieldName = $this->generateHeaderFieldName($sectionIdx, $linkIdx);

			$dependentRules[] = '#' . MarketingToolboxModel::FORM_FIELD_PREFIX . $urlFieldName . ':filled';
			$dependentRules[] = '#' . MarketingToolboxModel::FORM_FIELD_PREFIX . $headerFieldName . ':filled';
		}

		return "'" . implode(',', $dependentRules) . "'";
	}

	protected function generateUrlFieldName($sectionIdx, $linkIdx) {
		return  $this->generateFieldName(self::LINK_URL, $sectionIdx, $linkIdx);
	}

	protected function generateHeaderFieldName($sectionIdx, $linkIdx) {
		return  $this->generateFieldName(self::LINK_TEXT, $sectionIdx, $linkIdx);
	}

	protected function generateFieldName($fieldType, $sectionIdx, $linkIdx) {
		return  $fieldType . $sectionIdx . $this->lettersMap[$linkIdx];
	}

	public function renderEditor($data) {
		$data['sectionLimit'] = $this->sectionsLimit;

		$fileNameField = $data['form']->getField('fileName');
		if( !empty($fileNameField['value']) ) {
			$model = new MarketingToolboxModel();
			$imageData = $this->getImageInfo($fileNameField['value'], $model->getThumbnailSize());
			$data['fileUrl'] = $imageData->url;
			$data['imageWidth'] = $imageData->width;
			$data['imageHeight'] = $imageData->height;
		}
		
		return parent::renderEditor($data);
	}

	public function filterData($data) {
		$data = parent::filterData($data);

		for($sectionIdx = 1; $sectionIdx <= $this->sectionsLimit; $sectionIdx++) {
			for($linkIdx = 0; $linkIdx < $this->linksLimit; $linkIdx++) {
				$urlFieldName = $this->generateUrlFieldName($sectionIdx, $linkIdx);
				if (!empty($data[$urlFieldName])) {
					$data[$urlFieldName] = $this->addProtocolToLink($data[$urlFieldName]);
				}
			}
		}
		if (!empty($data['imageLink'])) {
			$data['imageLink'] = $this->addProtocolToLink($data['imageLink']);
		}

		return $data;
	}

	public function getStructuredData($data) {
		$structuredData = array();
		
		if( !empty($data['exploreTitle']) ) {
			$structuredData['headline'] = $data['exploreTitle'];
			$structuredData['linkgroups'] = $this->getLinkGroupsFromApiResponse($data);
			
			if( !empty($data['fileName']) ) {
				$imageData = $this->getImageInfo($data['fileName']);
				$structuredData['imageUrl'] = $imageData->url;
				$structuredData['imageAlt'] = $imageData->title;
			} else {
				$structuredData['imageUrl'] = null;
			}
			$structuredData['imageLink'] = !empty($data['imageLink']) ? $data['imageLink'] : null;
			
		}
		
		return $structuredData;
	}

	protected function getLinkGroupsFromApiResponse($responseData) {
		$linkgroups = array();

		for ($sectionIdx = 1; $sectionIdx <= $this->sectionsLimit; $sectionIdx++) {
			$headerIdx = self::SECTION_FIELD_PREFIX . $sectionIdx;
			if( !empty($responseData[$headerIdx]) ) {
				$linkgroups[$sectionIdx]['headline'] = $responseData[$headerIdx];

				for ($linkIdx = 0; $linkIdx < $this->linksLimit; $linkIdx++) {
					$linkTextIdx = $this->generateHeaderFieldName($sectionIdx, $linkIdx);

					if( !empty($responseData[$linkTextIdx]) ) {
						$linkgroups[$sectionIdx]['links'][$linkIdx]['anchor'] = $responseData[$linkTextIdx];
						$linkUrlIdx = $this->generateUrlFieldName($sectionIdx, $linkIdx);

						if( !empty($responseData[$linkUrlIdx]) ) {
							$linkgroups[$sectionIdx]['links'][$linkIdx]['href'] = $responseData[$linkUrlIdx];
						}
					}
				}
			}
		}

		return $linkgroups;
	}
}
