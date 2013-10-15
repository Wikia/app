<?php
abstract class BaseField extends FormElement {

	/**
	 * properties constants
	 */
	const PROPERTY_VALUE = 'value';
	const PROPERTY_ERROR_MESSAGE = 'errorMessage';
	const PROPERTY_LABEL = 'label';
	const PROPERTY_NAME = 'name';
	const PROPERTY_ID = 'id';
	const PROPERTY_CHOICES = 'choices';

	/**
	 * field validator
	 * @var WikiaValidator
	 */
	protected $validator;

	/**
	 * array of field properties
	 * @var array
	 */
	protected $properties = [];

	/**
	 * constructor
	 * @param array $options
	 * 		'label' - label for field, instance of Label
	 * 		'validator' - validator for field, instance of WikiaValidator
	 */
	public function __construct($options = []) {
		if (isset($options['label'])) {
			$this->setProperty(self::PROPERTY_LABEL, $options['label']);
		}
		if (isset($options['validator'])) {
			$this->setValidator($options['validator']);
		}

		// mostly for submit, checkbox, radio button types
		// TODO: should we allow that?
		if( isset( $options['value'] ) ) {
			$this->setProperty( self::PROPERTY_VALUE, $options['value'] );
		}

		// mostly for checkbox and radio buttons
		if( isset( $options['choices'] ) ) {
			$this->setProperty( self::PROPERTY_CHOICES, $options['choices'] );
		}

		parent::__construct();
	}

	/**
	 * Render div with label and field
	 *
	 * @param array $htmlAttributes html attributes for field tag
	 * 		'label' - html attributes for label tag
	 * @param int $index index of a field (only for CollectionField)
	 * @return string
	 */
	public function renderRow($htmlAttributes = [], $index = null) {
		$labelAttributes = isset($htmlAttributes['label']) ? $htmlAttributes['label'] : [];
		unset($htmlAttributes['label']);
		$data = [
			'attributes' => $htmlAttributes,
			'labelAttributes' => $labelAttributes,
			'index' => $index
		];
		return $this->renderView(__CLASS__, 'renderRow', $data);
	}

	/**
	 * Render field
	 *
	 * @param array $htmlAttributes html attributes for field tag
	 * @param int $index index of a field (only for CollectionField)
	 *
	 * @return string
	 */
	public function render($htmlAttributes = [], $index = null) {
		return $this->renderInternal(get_class($this), $htmlAttributes, [], $index);
	}

	/**
	 * Render label for field
	 * @param array $attributes html attributes for label tag
	 * @param int $index index of a field (only for CollectionField)
	 * @return string
	 */
	public function renderLabel($attributes = [], $index = null) {
		$label = $this->getProperty(self::PROPERTY_LABEL);
		if ($label instanceof Label) {
			return $label->render( $this->getId($index), $attributes);
		}
	}

	// TODO rethink formValues - dependent fields
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
				if (!empty($validationError)) {
					$this->setProperty(self::PROPERTY_ERROR_MESSAGE,  $validationError->getMsg());
					$isValid = false;
				}
			}
		}
		return $isValid;
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

	/**
	 * Set field value property
	 *
	 * @param mixed $value
	 */
	public function setValue($value) {
		$this->setProperty(self::PROPERTY_VALUE, $value);
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
	 * Set field name
	 *
	 * @param $name
	 */
	public function setName($name) {
		$this->setProperty(self::PROPERTY_NAME, $name);
	}

	/**
	 * Get field name
	 *
	 * @return mixed
	 */
	public function getName() {
		return $this->getProperty(self::PROPERTY_NAME);
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

	/**
	 * Get field property
	 *
	 * @param string $propertyName
	 *
	 * @return mixed
	 */
	public function getProperty($propertyName) {
		return isset($this->properties[$propertyName]) ? $this->properties[$propertyName] : null;
	}

	/**
	 * Set field Id
	 *
	 * @param string $id
	 */
	public function setId($id) {
		return $this->setProperty(self::PROPERTY_ID, $id);
	}

	/**
	 * get field Id
	 *
	 * @return string
	 */
	public function getId() {
		return $this->getProperty(self::PROPERTY_ID);
	}

	/**
	 * Get field choices
	 *
	 * @return mixed
	 */
	public function getChoices() {
		return $this->getProperty(self::PROPERTY_CHOICES);
	}

	/**
	 * Set field validator
	 *
	 * @param WikiaValidator $validator
	 */
	protected function setValidator(WikiaValidator $validator) {
		$this->validator = $validator;
	}

	/**
	 * Get field validator
	 *
	 * @return mixed
	 */
	protected function getValidator() {
		return $this->validator;
	}

	/**
	 * @see FormElement
	 */
	protected function getDirectory() {
		return dirname(__FILE__);
	}

	/**
	 * Prepare field properties and render field with error message
	 *
	 * @param string $className template class name
	 * @param array $htmlAttributes html attributes for field tag
	 * @param array $data array of variables that should be passed into view
	 * @param int $index index of a field (only for CollectionField)
	 *
	 * @return string
	 */
	protected function renderInternal($className, $htmlAttributes = [], $data = [], $index = null) {
		$out = '';

		$data['name'] = $this->getName($index);
		$data['value'] = $this->getValue($index);
		$data['id'] = $this->getId($index);
		$data['attributes'] = $this->prepareHtmlAttributes($htmlAttributes);

		$out .= $this->renderView($className, 'render', $data);

		$out .= $this->renderErrorMessage($index);

		return $out;
	}

	/**
	 * Render error message for field
	 *
	 * @return string
	 */
	protected function renderErrorMessage() {
		$errorMessage = $this->getProperty(self::PROPERTY_ERROR_MESSAGE);
		if (!empty($errorMessage)) {
			return $this->renderView(__CLASS__, 'errorMessage', ['errorMessage' => $errorMessage]);
		}
	}
}