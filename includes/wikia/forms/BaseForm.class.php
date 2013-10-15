<?php
abstract class BaseForm extends FormElement {

	/**
	 * @var array of fields (BaseField)
	 */
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
	 * Validate if data passes all fields validation and sets error messages for fields
	 *
	 * @param array $data
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
		return $this->renderView(__CLASS__, 'fields', ['fields' => $this->getFields()]);
	}

	/**
	 * Render selected field inside div and with label
	 *
	 * @param string $fieldName
	 * @param array $attributes html attributes for field tag,
	 * 		in 'label' key you can set attributes for label tag
	 * @param int $index index of field (only for CollectionField)
	 *
	 * @return string
	 */
	public function renderFieldRow($fieldName, $attributes = [], $index = null) {
		return $this->getField($fieldName)->renderRow($attributes, $index);
	}

	/**
	 * Render selected field
	 *
	 * @param string $fieldName
	 * @param array $attributes html attributes for field tag,
	 * @param int $index index of field (only for CollectionField)
	 *
	 * @return string
	 */
	public function renderField($fieldName, $attributes = [], $index = null) {
		return $this->getField($fieldName)->render($attributes, $index);
	}

	/**
	 * render Label for field
	 *
	 * @param string $fieldName
	 * @param array $attributes html attributes for label tag,
	 * @param null $index index of field (only for CollectionField)
	 * @return string
	 */
	public function renderFieldLabel($fieldName, $attributes = [], $index = null) {
		return $this->getField($fieldName)->renderLabel($attributes, $index);
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
	 * @return BaseForm form instance
	 */
	public function setFieldsValues($values = []) {
		foreach ( $this->fields as $fieldName => $field ) {
			if (array_key_exists($fieldName, $values)) {
				$field->setValue($values[$fieldName]);
			}
		}
		return $this;
	}

	/**
	 * Setter for field value
	 *
	 * @param string $fieldName
	 * @param mixed $fieldValue
	 * @return BaseForm form instance
	 */
	public function setFieldValue($fieldName, $fieldValue) {
		$this->getField($fieldName)->setValue($fieldValue);
		return $this;
	}

	/**
	 * Get field value
	 *
	 * @param $fieldName
	 * @return mixed
	 */
	public function getFieldValue($fieldName) {
		return $this->getField($fieldName)->getValue();
	}

	/**
	 * @desc Magic method to return whole form rendered
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->render();
	}

	/**
	 * @see FormElement
	 */
	protected function getDirectory() {
		return dirname(__FILE__);
	}

	/**
	 * Add field to form
	 *
	 * @param string $fieldName
	 * @param BaseField $field (optional) at default it creates TextField object
	 * @return BaseForm form instance
	 */
	protected function addField($fieldName, BaseField $field = null) {
		if (is_null($field)) {
			$field = new InputField();
		}
		$field->setName($fieldName);
		$field->setId($fieldName);
		$this->fields[$fieldName] = $field;
		return $this;
	}

	/**
	 * Get method how form should be sent 'get' or 'post'
	 *
	 * @return string
	 */
	protected function getMethod() {
		return $this->method;
	}

	/**
	 * Get form action
	 *
	 * @return string
	 */
	protected function getAction() {
		return $this->action;
	}

	/**
	 * Get all fields
	 *
	 * @return array
	 */
	protected function getFields() {
		return $this->fields;
	}

	/**
	 * Get form field by name
	 *
	 * @param string $fieldName
	 * @return BaseField
	 */
	protected function getField($fieldName) {
		return $this->fields[$fieldName];
	}

	/**
	 * Get form Id
	 *
	 * @return string
	 */
	protected function getId() {
		if (!empty($this->id)) {
			return $this->id;
		} else {
			return get_class($this);
		}
	}
}