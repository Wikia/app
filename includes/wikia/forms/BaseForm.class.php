<?

abstract class BaseForm {

	protected $fields = [];

	protected function addField($fieldName, FormField $field, WikiaValidator $validator = null) {
		if (isset($validator)) {
			$field->setValidator($validator);
		}
		$this->fields[$fieldName] = $field;
	}

	public function getField($fieldName) {
		return $this->fields[$fieldName];
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

		foreach ($filteredData as $fieldName => &$fieldValue) {
			$fieldValue = $this->getField($fieldName)->filterData($fieldValue);
		}
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
			// TODO rethink validating dependent fields
			if (!$field->validate($data[$fieldName], $data)) {
				$isValid = false;
			}
		}
		return $isValid;
	}

	public function render() {
		$out = '';
		$out .= $this->renderStart();
		$out .= $this->renderFields();
		$out .= $this->renderEnd();
		return $out;
	}

	public function renderFields() {
		$out = '';
		foreach ($this->fields as $fieldName => $field) {
			$out .= $field->render();
		}
		return $out;
	}

	public function renderField($fieldName) {
		$this->getField($fieldName)->render();
	}

	public function renderStart() {
		// TODO
	}

	public function renderEnd() {
		// TODO
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

}