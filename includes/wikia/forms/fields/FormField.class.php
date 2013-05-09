<?
abstract class FormField {
	const ATTRIBUTE_NAME_VALUE = 'value';

	// TODO check if abstract is required or maybe we can create universal logic for all fields
	abstract public function render();

	public function setFieldProperty($propertyName, $propertyValue) {
		// TODO add logic
	}

	public function setFieldValue($value) {
		$this->setFieldProperty(self::ATTRIBUTE_NAME_VALUE, $value);
	}

	public function filterValue($value) {
		return $value;
	}

	public function validate($value) {
		// TODO add validation logic
	}

}