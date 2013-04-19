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

	public function __construct() {
		$this->formFields = $this->getMockedData();
	}

	public function setFields($formFields) {
		$this->formFields = $formFields;
	}

	public function getFields() {
		return $this->formFields;
	}

	public function getField($fieldName) {
		return $this->formFields[$fieldName];
	}

	protected function setFieldError($fieldName, $errorMessage) {
		$this->formFields[$fieldName]['errorMessage'] = $errorMessage;
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
					$this->setFieldError($fieldName, $out[$fieldName]);
				}
			}
		}

		return $out;
	}

	public function setFieldsValues($values) {
		foreach ( $this->formFields as $name => &$field ) {
			$field['value'] = (isset($values[$name])) ? $values[$name] : '';
		}
	}

	/**
	 * Render form fields set by setFormFields
	 *
	 * @return form string
	 */
	public function renderFormFields() {
		$form = '';

		if( !empty( $this->formFields ) ) {
			foreach ( $this->formFields as $name => $field ) {
				$form .= $this->renderField($name);
			}
		}

		return $form;
	}

	/**
	 * Render form field
	 *
	 * @param $field Array Field array with parameters
	 *
	 * @requestParam type string				[REQUIRED] field type (text, textarea etc.)
	 * @requestParam name string				[REQUIRED] field name
	 * @requestParam label array				[OPTIONAL] array('class' => 'labelClass', 'text' => 'labelText')
	 * @requestParam attributes array			[OPTIONAL] array with attributes ('class' => 'fieldClass', 'id' => 'fieldId') etc.
	 * @requestParam validator WikiaValidator 	[OPTIONAL]
	 * @requestParam icon boolean				[OPTIONAL]
	 *
	 * @return WikiaView
	 */
	public function renderField( $fieldName ) {
		$field = $this->getField($fieldName);

		// TODO: set default values or throw exception ?
		if ( empty($field['type']) ) {
			$field['type'] = 'text';
		}
		$field['name'] = $fieldName;

		$field['attributes'] = isset($field['attributes']) ? $this->prepareFieldAttributes($field['attributes']) : '';

		$field['value'] = isset($field['value']) ? $field['value'] : '';

		// TODO handle isArray type fields
		return F::app()->getView(__CLASS__, 'renderField', $field);
	}

	protected function prepareFieldAttributes($attributes) {
		$out = '';

		foreach ($attributes as $name => $value) {
			$out .= $name . '="' . $value . '" ';
		}

		return $out;
	}

	private function getMockedData() {
		return $formFields = array(
			array(
				'type' => 'text',
				'name' => 'exploreTitle',
				'label' => '',//$this->wf->Msg('marketing-toolbox-hub-module-explore-title'),
				'validator' => new WikiaValidatorString(
					array(
						'required' => true,
						'min' => 1
					),
					array('too_short' => 'marketing-toolbox-validator-string-short')
				),
				'attributes' => array(
					'class' => 'required explore-mainbox-input'
				)
			),
			array(
				'name' => 'fileName',
				'type' => 'hidden',
				'attributes' => array(
					'class' => 'wmu-file-name-input'
				),
				'validator' => new WikiaValidatorFileTitle(
					array(),
					array('wrong-file' => 'marketing-toolbox-validator-wrong-file')
				)
			),
			array(
				'type' => 'text',
				'name' => 'imageLink',
				'label' => '',//$this->wf->Msg('marketing-toolbox-hub-module-explore-link-url'),
				'validator' => new WikiaValidatorToolboxUrl(
					array(),
					array(
						'wrong' => 'marketing-toolbox-validator-wrong-url'
					)
				),
				'icon' => true,
				'attributes' => array(
					'class' => 'wikiaUrl explore-mainbox-input'
				)
			),
		);
	}

}
