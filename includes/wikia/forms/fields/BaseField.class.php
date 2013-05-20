<?
abstract class BaseField extends FormElement {
	const PROPERTY_VALUE = 'value';
	const PROPERTY_ERROR_MESSAGE = 'errorMessage';
	const PROPERTY_LABEL = 'label';
	const PROPERTY_NAME = 'name';
	const PROPERTY_ID = 'id';

	protected $validator;
	protected $properties = [];

	// TODO decide what params are required here
	// TODO maybe array fields should be decorated
	// TODO think about div
	public function __construct($options = []) {
		if (isset($options['label'])) {
			$this->setProperty(self::PROPERTY_LABEL, $options['label']);
		}
		if (isset($options['validator'])) {
			$this->setValidator($options['validator']);
		}

		parent::__construct();
	}

	protected function getDirectory() {
		return dirname(__FILE__);
	}

	/**
	 * Render field
	 *
	 * @param array $htmlAttributes html field attributes
	 *
	 * @return string
	 */
	public function render($htmlAttributes = []) {
		return $this->renderInternal(get_class($this), $htmlAttributes = []);
	}

	protected function renderInternal($className, $htmlAttributes = [], $data = []) {
		$out = '';

		$data['name'] = $this->getName();
		$data['value'] = $this->getValue();
		$data['id'] = $this->getId();
		$data['attributes'] = $this->prepareHtmlAttributes($htmlAttributes);

		$data['errorMessage'] = $this->getProperty(self::PROPERTY_ERROR_MESSAGE);
		if(!empty($data['errorMessage'])) {
			$out .= $this->renderView(__CLASS__, 'errorMessage', $data);
		}
		$out .= $this->renderView($className, 'render', $data);

		return $out;
	}

	public function renderLabel($attributes = []) {
		$label = $this->getProperty(self::PROPERTY_LABEL);
		if ($label instanceof Label) {
			return $label->render($attributes);
		}
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
	 * Set field name
	 *
	 * @param $name
	 */
	public function setName($name) {
		$this->setProperty(self::PROPERTY_NAME, $name);
	}

	/**
	 * Get field name
	 * @return mixed
	 */
	public function getName() {
		return $this->getProperty(self::PROPERTY_NAME);
	}

	/**
	 * Get field property
	 *
	 * @param string $propertyName
	 * @return mixed
	 */
	public function getProperty($propertyName) {
		return isset($this->properties[$propertyName]) ? $this->properties[$propertyName] : null;
	}

	/**
	 * Get value
	 *
	 * @return mixed
	 */
	public function getValue() {
		return $this->getProperty(self::PROPERTY_VALUE);
	}

	public function setId($id) {
		return $this->setProperty(self::PROPERTY_ID, $id);
	}

	public function getId() {
		return $this->getProperty(self::PROPERTY_ID);
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

	/**
	 * Set field property
	 *
	 * @param string $propertyName
	 * @param mixed $propertyValue
	 */
	protected function setProperty($propertyName, $propertyValue) {
		$this->properties[$propertyName] = $propertyValue;
	}
}