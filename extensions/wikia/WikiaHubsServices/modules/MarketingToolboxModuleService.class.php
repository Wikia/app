<?php
abstract class MarketingToolboxModuleService extends WikiaService {
	const CLASS_NAME_PREFIX = 'MarketingToolboxModule';
	const CLASS_NAME_SUFFIX = 'Service';

	protected $langCode;
	protected $sectionId;
	protected $verticalId;

	abstract protected function getFormFields();
	abstract public function getStructuredData($data);

	public function __construct($langCode, $sectionId, $verticalId) {
		parent::__construct();

		$this->langCode = $langCode;
		$this->sectionId = $sectionId;
		$this->verticalId = $verticalId;
	}

	static public function getModuleByName($name, $langCode, $sectionId, $verticalId) {
		$moduleClassName = self::CLASS_NAME_PREFIX . $name . self::CLASS_NAME_SUFFIX;
		return new $moduleClassName($langCode, $sectionId, $verticalId);
	}

	public function renderEditor($data) {
		$data['fields'] = $this->prepareFieldsDefinition($data['values'], $data['validationErrors']);
		return $this->getView('editor', $data);
	}

	public function render($data) {
		return $this->getView('index', $data);
	}

	public function validate($data) {
		$out = array();
		$fields = $this->getFormFields();

		foreach ($fields as $fieldName => $field) {
			if (!empty($field['validator'])) {
				$fieldData = isset($data[$fieldName]) ? $data[$fieldName] : null;

				if( $field['validator'] instanceof WikiaValidatorDependent ) {
					$field['validator']->setFormData($data);
				}

				if (!$field['validator']->isValid($fieldData)) {
					$validationError = $field['validator']->getError();

					if( !empty($field['isArray']) ) {
						$out[$fieldName] = array();

						foreach ($validationError as $key => $error) {
							if (is_array($error)) {
								// maybe in future we should handle many errors from one validator,
								// but actually we don't need  this feature
								$error = array_shift(array_values($error));
							}
							$out[$fieldName][$key] = $error->getMsg();
						}
					} else {
						$out[$fieldName] = $validationError->getMsg();
					}
				}
			}
		}

		return $out;
	}

	public function loadData($model, $timestamp) {
		$moduleId = $this->getModuleId();

		$moduleData = $model->getPublishedData($this->langCode, MarketingToolboxModel::SECTION_HUBS, $this->verticalId, $timestamp, $moduleId);

		if( empty($moduleData[$moduleId]['data']) ) {
			$moduleData = array();
		} else {
			$moduleData = $moduleData[$moduleId]['data'];
		}

		return $this->getStructuredData($moduleData);
	}

	public function filterData($data) {
		$filteredData = array_intersect_key($data, $this->getFormFields());
		$filteredData = array_filter($filteredData, function ($value) { return !empty($value); });
		return $filteredData;
	}

	protected function getModuleId() {
		return static::MODULE_ID;
	}

	protected function getView($viewName, $data) {
		return $this->app->getView(get_class($this), $viewName, $data);
	}

	protected function prepareFieldsDefinition($values, $errorMessages) {
		$out = array();
		$fields = $this->getFormFields();

		foreach ($fields as $fieldName => $field) {
			$out[$fieldName] = array(
				'name' => $fieldName,
				'value' => isset($values[$fieldName]) ? $values[$fieldName] : '',
				'errorMessage' => isset($errorMessages[$fieldName]) ? $errorMessages[$fieldName] : '',
				'label' => isset($field['label']) ? $field['label'] : null,
				'labelclass' => isset($field['labelclass']) ? $field['labelclass'] : null,
				'attributes' => isset($field['attributes']) ? $this->prepareFieldAttributes($field['attributes']) : '',
				'type' => isset($field['type']) ? $field['type'] : 'text',
				'class' => isset($field['class']) ? $field['class'] : '',
				'icon' => isset($field['icon']) ? $field['icon'] : '',
				'isArray' => isset($field['isArray']) ? $field['isArray'] : false,
				'id' => MarketingToolboxModel::FORM_FIELD_PREFIX . $fieldName
			);
		}

		return $out;
	}

	protected function prepareFieldAttributes($attributes) {
		$out = '';

		foreach ($attributes as $name => $value) {
			$out .= $name . '="' . $value . '" ';
		}

		return $out;
	}

	protected function addProtocolToLink($link) {
		if (strpos($link, 'http://') === false && strpos($link, 'https://') === false) {
			$link = 'http://' . $link;
		}

		return $link;
	}

	protected function getImageInfo($fileName, $destSize = 0) {
		return ImagesService::getLocalFileThumbUrlAndSizes($fileName, $destSize);
	}

	/**
	 * @desc Creates sponsored image markup which is then passed to wfMessage()
	 * 
	 * @param $imageTitleText
	 * @return string
	 */
	protected function getSponsoredImageMarkup($imageTitleText) {
		$sponsoredImageInfo = $this->getImageInfo($imageTitleText);
		return Xml::element('img', array(
			'src' => $sponsoredImageInfo->url,
			'alt' => $sponsoredImageInfo->title,
			'width' => $sponsoredImageInfo->width,
			'height' => $sponsoredImageInfo->height,
		), '', true);
	}
}
