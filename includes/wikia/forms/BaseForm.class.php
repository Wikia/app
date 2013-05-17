<?

abstract class BaseForm {

	public function __construct() {
		$this->templateEngine = new Wikia\Template\PHPEngine;
	}

	protected $fields = [];
	protected $templateEngine;

	/**
	 * Add field to form
	 *
	 * @param string $fieldName
	 * @param BaseField $field
	 * @param WikiaValidator $validator
	 */
	protected function addField($fieldName, BaseField $field) {
		$field->setName($fieldName);
		$this->fields[$fieldName] = $field;
	}

	/**
	 * Get form field by name
	 *
	 * @param string $fieldName
	 * @return BaseField
	 */
	public function getField($fieldName) {
		return $this->fields[$fieldName];
	}

	/**
	 * Before validate data processing
	 * Remove all unnecessary data, that is not defined as field in form
	 * and filter data by each field filter
	 *
	 * @param $data
	 * @return array
	 */
	public function filterData($data) {
		$filteredData = array_intersect_key($data, $this->getFields());
		$filteredData = array_filter($filteredData, function ($value) { return !empty($value); });

		foreach ($filteredData as $fieldName => &$fieldValue) {
			$fieldValue = $this->getField($fieldName)->filterData($fieldValue);
		}
		return $filteredData;
	}

	/**
	 * Get all fields
	 *
	 * @return array
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * Validate if data passes all fields validation
	 *
	 * @param $data
	 * @return bool
	 */
	public function validate($data) {
		$isValid = true;
		$fields = $this->getFields();

		foreach ($fields as $fieldName => $field) {
			// TODO rethink validating dependent fields
			if (!$field->validate($data[$fieldName], $data)) {
				$isValid = false;
			}
		}
		return $isValid;
	}

	/**
	 * Render whole form
	 * with opening tag, all fields submits and closing tag
	 *
	 * @return string
	 */
	public function render() {
		return $this->renderView('full');
	}

	/**
	 * Render all fields defined in form
	 *
	 * @return string
	 */
	public function renderFields() {
		return $this->renderView('fields');
	}

	/**
	 * Render selected field
	 *
	 * @param string $fieldName
	 */
	public function renderField($fieldName) {
		return $this->getField($fieldName)->render();
	}

	/**
	 * Render opening tag for form
	 */
	public function renderStart() {
		return $this->renderView('start');
	}

	/**
	 * Render closing tag for form
	 */
	public function renderEnd() {
		return $this->renderView('end');
	}


	/**
	 * Setter for fields values
	 *
	 * @param array $values
	 */
	public function setFieldsValues($values = []) {

		foreach ( $this->fields as $fieldName => $field ) {
			if (array_key_exists($fieldName, $values)) {
				$field->setValue($values[$fieldName]);
			}
		}
	}

	protected function renderView($name) {
		return $this->templateEngine
			->setData(['form' => $this])
			->render( dirname(__FILE__) . '/templates/' . $name . '.php');
	}

}