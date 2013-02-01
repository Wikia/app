<?php
abstract class MarketingToolboxModuleService extends WikiaService {
	const CLASS_NAME_PREFIX = 'MarketingToolboxModule';
	const CLASS_NAME_SUFFIX = 'Service';

	protected $langCode;
	protected $sectionId;
	protected $verticalId;

	abstract protected function getFormFields();

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

				if (!$field['validator']->isValid($fieldData) && (($validationError = $field['validator']->getError()) instanceof WikiaValidationError)) {
					$out[$fieldName] = $validationError->getMsg();
				}
			}
		}

		return $out;
	}

	public function filterData($data) {
		$filteredData = array_intersect_key($data, $this->getFormFields());
		$filteredData = array_filter($filteredData, function ($value) { return !empty($value); });
		return $filteredData;
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
		if (strpos($link, 'http://') === false) {
			$link = 'http://' . $link;
		}

		return $link;
	}

}
