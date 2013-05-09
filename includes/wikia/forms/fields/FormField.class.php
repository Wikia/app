<?
abstract class FormField {
	const ATTRIBUTE_NAME_VALUE = 'value';

	protected $properties;

	// TODO check if abstract is required or maybe we can create universal logic for all fields
	abstract public function render();

	public function setProperty($propertyName, $propertyValue) {
		$this->properties[$propertyName] = $propertyValue;
	}

	public function setValue($value) {
		$this->setProperty(self::ATTRIBUTE_NAME_VALUE, $value);
	}

	public function getProperty($propertyName) {
		return $this->properties[$propertyName];
	}

	public function getValue() {
		return $this->properties[self::ATTRIBUTE_NAME_VALUE];
	}

	public function filterValue($value) {
		return $value;
	}

	public function validate($value) {
		// TODO add validation logic
	}

}