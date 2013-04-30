<?php

class FormBuilderService extends WikiaService
{
	public $formFields = [];
	protected $prefix;

	/**
	 * Constructor
	 *
	 * @param string $prefix form name
	 * @param array $fields  array of form fields ( @see setFields )
	 */
	public function __construct($prefix = '', $fields = []) {
		parent::__construct();
		if (!empty($prefix)) {
			$this->prefix = $prefix;
		}
		if (!empty($fields)) {
			$this->setFields($fields);
		}
	}

	/**
	 * Set fields
	 *
	 * @requestParam string type				[OPTIONAL] field type ('text', 'textarea' etc.) | default 'text'
	 * @requestParam string value				[OPTIONAL] field value | default set to ''
	 * @requestParam array attributes			[OPTIONAL] array with input attributes
	 * @requestParam WikiaValidator validator 	[OPTIONAL] WikiaValidator object
	 * @requestParam string label				[OPTIONAL] label text
	 * @requestParam string labelclass			[OPTIONAL] label class
	 * @requestParam string class				[OPTIONAL] field wrapper class
	 * @requestParam boolean isArray			[OPTIONAL] if set to true, form input field is an array
	 * @requestParam boolean icon				[OPTIONAL] if set to true, <img/> tag with blank img is added to label
	 *
	 * @param $formFields
	 */
	// TODO change fields into Objects in near future
	public function setFields($formFields) {
		$this->formFields = $formFields;
	}

	/**
	 * Get defined fields
	 *
	 * @return array
	 */
	public function getFields() {
		return $this->formFields;
	}

	/**
	 * Set field
	 *
	 * @param $fieldName
	 * @param $field ( @see setFields )
	 */
	public function setField($fieldName, $field) {
		$this->formFields[$fieldName] = $field;
	}

	/**
	 * Set field Property
	 *
	 * @param $fieldName
	 * @param $propertyName
	 * @param $propertyValue
	 */
	public function setFieldProperty($fieldName, $propertyName, $propertyValue) {
		$this->formFields[$fieldName][$propertyName] = $propertyValue;
	}

	/**
	 * Get field
	 *
	 * @param $fieldName
	 * @return mixed
	 */
	public function getField($fieldName) {
		return $this->formFields[$fieldName];
	}

	/**
	 * Setter for fields values
	 *
	 * @param array $values
	 */
	public function setFieldsValues($values = []) {
		$formFields = $this->getFields();

		foreach ( $formFields as $name => $field ) {
			$value = (isset($values[$name])) ? $values[$name] : '';
			$this->setFieldProperty($name, 'value', $value);
		}
	}

	/**
	 * Remove all unnecessary data, that is note defined as field in form
	 *
	 * @param $data
	 * @return array
	 */
	public function filterData($data) {
		$filteredData = array_intersect_key($data, $this->getFields());
		$filteredData = array_filter($filteredData, function ($value) { return !empty($value); });
		return $filteredData;
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
			if (!empty($field['validator'])) {
				if (isset($data[$fieldName])) {
					$fieldData = $data[$fieldName];
				} else if (!empty($field['isArray'])) {
					$fieldData = [];
				} else {
					$fieldData = '';
				}

				if( $field['validator'] instanceof WikiaValidatorDependent ) {
					$field['validator']->setFormData($data);
				}

				if (!$field['validator']->isValid($fieldData)) {
					$validationError = $field['validator']->getError();
					if ( !empty($field['isArray']) ) {
						foreach ($validationError as $key => $error) {
							if (is_array($error)) {
								// maybe in future we should handle many errors from one validator,
								// but actually we don't need  this feature
								$error = array_shift(array_values($error));
							}
							if (!empty($error)) {
								$validationError[$key] = $error->getMsg();
								$isValid = false;
							}
						}
						$this->setFieldProperty($fieldName, 'errorMessage', $validationError);
					} else {
						if (!empty($validationError)) {
							$this->setFieldProperty($fieldName, 'errorMessage', $validationError->getMsg());
							$isValid = false;
						}
					}
				}
			}
		}
		return $isValid;
	}

	/**
	 * Render form fields set by setFormFields
	 *
	 * @return form string
	 */
	public function renderFormFields() {
		$form = '';
		$formFields = $this->getFields();

		foreach ( $formFields as $name => $field ) {
			$form .= $this->renderField($name);
		}

		return $form;
	}

	/**
	 * Render form field
	 *
	 * @param string $fieldName field name
	 * @param int    $index field index if isArray is set to true
	 *
	 * @return WikiaView
	 */
	public function renderField( $fieldName, $index = 0 ) {
		$field = $this->getField($fieldName);

		if ( empty($field['type']) ) {
			$field['type'] = 'text';
		}

		if ( !isset($field['value']) ) {
			$field['value'] = '';
		}

		$field['name'] = $fieldName;
		$field['id'] = $this->prefix . $fieldName;

		if (!empty($field['isArray'])) {
			$field['name'] .= '[]';
			$field['id'] .= $index;

			$field['value'] = isset($field['value'][$index]) ? $field['value'][$index] : '';
			$field['errorMessage'] = isset($field['errorMessage'][$index]) ? $field['errorMessage'][$index] : '';
		}

		$field['attributes'] = isset($field['attributes']) ? $this->prepareFieldAttributes($field['attributes']) : '';

		return F::app()->getView(__CLASS__, 'renderField', $field);
	}

	/**
	 * Convert HTML attributes array into HTML string
	 *
	 * @param $attributes
	 * @return string
	 */
	protected function prepareFieldAttributes($attributes) {
		$out = '';

		foreach ($attributes as $name => $value) {
			$out .= $name . '="' . $value . '" ';
		}

		return $out;
	}
}
