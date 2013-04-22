<?php
/**
 * Created by JetBrains PhpStorm.
 * User: lukasz
 * Date: 17.04.13
 * Time: 17:22
 * To change this template use File | Settings | File Templates.
 */
class FormBuilderService extends WikiaService
{
	public $formFields = [];
	private $prefix;

	public function __construct($prefix = '', $fields = []) {
		$this->prefix = $prefix;
		$this->setFields($fields);
	}

	public function setFields($formFields) {
		$this->formFields = $formFields;
	}

	public function getFields() {
		return $this->formFields;
	}

	public function setField($fieldName, $field) {
		$this->formFields[$fieldName] = $field;
	}

	public function setFieldProperty($fieldName, $propertyName, $propertyValue) {
		$this->formFields[$fieldName][$propertyName] = $propertyValue;
	}

	public function getField($fieldName) {
		return $this->formFields[$fieldName];
	}

	public function setFieldsValues($values = []) {
		$formFields = $this->getFields();

		foreach ( $formFields as $name => $field ) {
			$value = (isset($values[$name])) ? $values[$name] : '';
			$this->setFieldProperty($name, 'value', $value);
		}
	}

	// TODO rethink if this should be here
	public function filterData($data) {
		$filteredData = array_intersect_key($data, $this->getFields());
		$filteredData = array_filter($filteredData, function ($value) { return !empty($value); });
		return $filteredData;
	}

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
	 * @param $field Array Field array with parameters
	 *
	 * @requestParam type string				[OPTIONAL] field type (text, textarea etc.) | default text
	 * @requestParam label string				[OPTIONAL] label text
	 * @requestParam labelclass string			[OPTIONAL] label class
	 * @requestParam attributes array			[OPTIONAL] array with input attributes etc.
	 * @requestParam validator WikiaValidator	[OPTIONAL]
	 * @requestParam icon boolean				[OPTIONAL]
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

	protected function prepareFieldAttributes($attributes) {
		$out = '';

		foreach ($attributes as $name => $value) {
			$out .= $name . '="' . $value . '" ';
		}

		return $out;
	}
}
