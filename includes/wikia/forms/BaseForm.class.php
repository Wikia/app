<?

abstract class BaseForm extends FormElement {

	protected $fields = [];

	/**
	 * @var string form method
	 */
	protected $method = 'get';

	/**
	 * @var string form action
	 */
	protected $action = '';

	/**
	 * @var string form id
	 */
	protected $id;

	protected function getDirectory() {
		return dirname(__FILE__);
	}

	/**
	 * Add field to form
	 *
	 * @param string $fieldName
	 * @param BaseField $field
	 */
	protected function addField($fieldName, BaseField $field) {
		$field->setName($fieldName);
		$field->setId($fieldName);
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
			if (!$field->validate(isset($data[$fieldName]) ? $data[$fieldName] : null, $data)) {
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
		return $this->renderView(__CLASS__, 'full');
	}

	/**
	 * Render all fields defined in form
	 *
	 * @return string
	 */
	public function renderFields() {
		return $this->renderView(__CLASS__, 'fields');
	}

	/**
	 * Render selected field
	 *
	 * @param string $fieldName
	 */
	public function renderField($fieldName, $attributes = [], $index = null) {
		return $this->getField($fieldName)->render($attributes, $index);
	}

	/**
	 * Render opening tag for form
	 */
	public function renderStart($htmlAttributes = []) {
		return $this->renderView(__CLASS__, 'start', [
			'method' => $this->getMethod(),
			'action' => $this->getAction(),
			'id' => $this->getId(),
			'attributes' => $this->prepareHtmlAttributes($htmlAttributes)
		]);
	}

	/**
	 * Render closing tag for form
	 */
	public function renderEnd() {
		return $this->renderView(__CLASS__, 'end');
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

	protected function getMethod() {
		return $this->method;
	}

	protected function getAction() {
		return $this->action;
	}

	protected function getId() {
		if (!empty($this->id)) {
			return $this->id;
		} else {
			return get_class($this);
		}
	}
}