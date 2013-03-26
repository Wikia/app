<?php

abstract class MarketingToolboxModuleEditableService extends MarketingToolboxModuleService
{
	abstract public function getStructuredData($data);
	abstract protected function getFormFields();

	public function renderEditor($data) {
		$data['fields'] = $this->prepareFieldsDefinition($data['values'], $data['validationErrors']);
		return $this->getView('editor', $data);
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

	public function filterData($data) {
		$filteredData = array_intersect_key($data, $this->getFormFields());
		$filteredData = array_filter($filteredData, function ($value) { return !empty($value); });
		return $filteredData;
	}

	protected function prepareFieldAttributes($attributes) {
		$out = '';

		foreach ($attributes as $name => $value) {
			$out .= $name . '="' . $value . '" ';
		}

		return $out;
	}
}
