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

	public function setFields($formFields) {
		$this->formFields = $formFields;
	}

	public function getFields() {
		return $this->formFields;
	}

	public function getField($fieldName) {
		return $this->formFields[$fieldName];
	}


	// TODO rethink if this should be here
	public function filterData($data) {
		$filteredData = array_intersect_key($data, $this->getFields());
		$filteredData = array_filter($filteredData, function ($value) { return !empty($value); });
		return $filteredData;
	}

	public function validate($data) {
		$out = array();
		$fields = $this->getFields();

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

	protected function prepareFieldsDefinition($values, $errorMessages) {
		$out = array();
		$fields = $this->getFields();
		// TODO: check field structure
		foreach ($fields as $fieldName => $field) {
			$out[$fieldName] = array(
				'name' => $fieldName,
				'value' => isset($values[$fieldName]) ? $values[$fieldName] : '',
				'attributes' => isset($field['attributes']) ? $this->prepareFieldAttributes($field['attributes']) : '',
				'errorMessage' => isset($errorMessages[$fieldName]) ? $errorMessages[$fieldName] : ''
			);

			$out[$fieldName] = array_merge($out[$fieldName], $this->prepareFieldOptions($field['options']));
		}

		return $out;
	}

	protected function prepareFieldOptions($options) {
		$out = [];

		if( is_array($options) ) {
			foreach($options as $name => $option) {
				$out[$name] = $option;
			}
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

	public function renderField($fieldName) {
		//TODO do something with field data
		$field = $this->getField($fieldName);

		return F::app()->getView(__CLASS__, 'renderField', $field);
	}
}
