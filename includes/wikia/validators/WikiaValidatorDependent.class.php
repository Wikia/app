<?php

/**
 * @desc Validates a field only if other field in the form is/is not empty
 */
class WikiaValidatorDependent extends WikiaValidator {

	protected $formData = array();

	protected function config( array $options = array() ) {
		$this->setOption('ownValidator', null);
		$this->setOption('dependentFields', null);
	}

	public function setFormData($data) {
		$this->formData = $data;
	}

	public function isValidInternal($value = null, $formData = null, $formFields = null) {
		$ownValidator = $this->getOption('ownValidator');

		if( is_null($ownValidator) || !($ownValidator instanceof WikiaValidator) ) {
			throw new WikiaValidatorGivenObjectIsNotWikiaValidator('WikiaValidatorDepend: own validator is not an instance of WikiaValidator');
		}

		if (!is_array($this->getOption('dependentFields'))) {
			throw new WikiaValidatorDependentFieldEmptyException( 'WikiaValidatorDepend: dependent field is empty' );
		}

		if( $this->anyDependentFieldsValid() && !$ownValidator->isValid($value) ) {
			$this->setError( $ownValidator->getError() );
			return false;
		}
		
		return true;
	}

	public function isValid($value = null) {
	//skip here validation of $value because it should be validated only after the dependentField is valid
		$this->error = null;
		return $this->isValidInternal($value);
	}
	
	protected function anyDependentFieldsValid() {
		$validationConditions = $this->getOption('dependentFields');
		$anyFieldValid = false;
		foreach ($validationConditions as $fieldName => $validator) {
			if (!empty($validator)) {
				$fieldData = isset($this->formData[$fieldName]) ? $this->formData[$fieldName] : null;
				if ($validator->isValid($fieldData)) {
					$anyFieldValid = true;
					break;
				}
			}
		}

		return $anyFieldValid;
	}

}
