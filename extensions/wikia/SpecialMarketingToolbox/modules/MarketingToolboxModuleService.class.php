<?
abstract class MarketingToolboxModuleService extends WikiaService {
	const CLASS_NAME_PREFIX = 'MarketingToolboxModule';
	const CLASS_NAME_SUFFIX = 'Service';

	abstract protected function getValidationRules();
	abstract protected function getFormFields();

	static public function getModuleByName($name) {
		$moduleClassName = self::CLASS_NAME_PREFIX . $name . self::CLASS_NAME_SUFFIX;
		return new $moduleClassName();
	}

	public function renderEditor($data) {
		$data['fields'] = $this->prepareFieldsDefinition($data['values'], $data['validationErrors']);
		return $this->getView('editor', $data);
	}

	public function validate($data) {
		$out = array();

		$rules = $this->getValidationRules();

		foreach ($rules as $fieldName => $validator) {
			$fieldData = isset($data[$fieldName]) ? $data[$fieldName] : null;
			if (!$validator->isValid($fieldData)) {
				$out[$fieldName] = $validator->getError()->getMsg();
			}
		}

		return $out;
	}

	public function filterData($data) {
		return array_intersect_key($data, $this->getValidationRules());
	}

	protected function getView($viewName, $data, $viewType = WikiaResponse::FORMAT_HTML) {
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
				'isRequired' => isset($field['isRequired']) ? $field['isRequired'] : false,
				'attributes' => isset($field['attributes'])  ? $this->prepareFieldAttributes($field['attributes']) : '',
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

}
?>