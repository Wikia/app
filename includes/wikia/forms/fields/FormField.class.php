<?
abstract class FormField {
	const PROPERTY_VALUE = 'value';
	const PROPERTY_ERROR_MESSAGE = 'errorMessage';

	protected $validator;
	protected $properties = [];

	// TODO decide what params are required here
	// TODO maybe array fields should be decorated
	public function __construct() {
	}

	// TODO check if abstract is required or maybe we can create universal logic for all fields
	abstract public function render();

	public function setProperty($propertyName, $propertyValue) {
		$this->properties[$propertyName] = $propertyValue;
	}

	public function setValue($value) {
		$this->setProperty(self::PROPERTY_VALUE, $value);
	}

	public function getProperty($propertyName) {
		return $this->properties[$propertyName];
	}

	public function getValue() {
		return $this->getProperty(self::ATTRIBUTE_NAME_VALUE);
	}

	public function setValidator(WikiaValidator $validator) {
		$this->validator = $validator;
	}

	public function getValidator() {
		return $this->validator;
	}

	public function filterValue($value) {
		return $value;
	}

	// TODO rethink formValues
	public function validate($value, $formValues) {
		$isValid = true;

		if (isset($this->validator)){
			if( $this->validator instanceof WikiaValidatorDependent ) {
				$this->validator->setFormData($formValues);
			}

			if (!$this->validator->isValid($value)) {
				$validationError = $this->validator->getError();
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
				$this->setProperty(self::PROPERTY_ERROR_MESSAGE, $validationError);
				} else {
					if (!empty($validationError)) {
						$this->setProperty(self::PROPERTY_ERROR_MESSAGE,  $validationError->getMsg());
						$isValid = false;
					}
				}
			}
		}
		return $isValid;
	}

}