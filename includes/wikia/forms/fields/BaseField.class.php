<?
abstract class BaseField {
	const PROPERTY_VALUE = 'value';
	const PROPERTY_ERROR_MESSAGE = 'errorMessage';

	protected $validator;
	protected $properties = [];

	// TODO decide what params are required here
	// TODO maybe array fields should be decorated
	public function __construct() {
	}

	// TODO check if abstract is required or maybe we can create universal logic for all fields
	/**
	 * Render field
	 *
	 * @return string
	 */
	abstract public function render();

	/**
	 * Set field property
	 *
	 * @param string $propertyName
	 * @param mixed $propertyValue
	 */
	public function setProperty($propertyName, $propertyValue) {
		$this->properties[$propertyName] = $propertyValue;
	}

	/**
	 * Set field value property
	 *
	 * @param mixed $value
	 */
	public function setValue($value) {
		$this->setProperty(self::PROPERTY_VALUE, $value);
	}

	/**
	 * Get field property
	 *
	 * @param string $propertyName
	 * @return mixed
	 */
	public function getProperty($propertyName) {
		return $this->properties[$propertyName];
	}

	/**
	 * Get value
	 *
	 * @return mixed
	 */
	public function getValue() {
		return $this->getProperty(self::PROPERTY_VALUE);
	}

	/**
	 * Set field validator
	 *
	 * @param WikiaValidator $validator
	 */
	public function setValidator(WikiaValidator $validator) {
		$this->validator = $validator;
	}

	/**
	 * Get field validator
	 *
	 * @return mixed
	 */
	public function getValidator() {
		return $this->validator;
	}

	/**
	 * Before validation data processing
	 * Filter value
	 *
	 * @param mixed $value
	 * @return mixed
	 */
	public function filterValue($value) {
		return $value;
	}

	// TODO rethink formValues
	/**
	 * Validate form value
	 *
	 * @param mixed $value
	 * @param array $formValues
	 * @return bool
	 */
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