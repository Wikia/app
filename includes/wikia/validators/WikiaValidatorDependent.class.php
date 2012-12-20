<?php

/**
 * @desc Validates a field only if other field in the form is/is not empty
 */
class WikiaValidatorDependent extends WikiaValidator {
	const CONDITION_EMPTY = 'empty';
	const CONDITION_NOT_EMPTY = 'not_empty';
	
	protected $formFields = array();
	protected $formData = array();

	protected function config( array $options = array() ) {
		$this->setOption('ownValidator', null);
		$this->setOption('dependentFieldCondition', self::CONDITION_EMPTY);
		$this->setOption('dependentField', null);
	}

	public function setFormData($data) {
		$this->formData = $data;
	}

	public function setFormFields($fields) {
		$this->formFields = $fields;
	}

	public function isValidInternal($value = null, $formData = null, $formFields = null) {
		$ownValidator = $this->getOption('ownValidator');
		$dependentField = $this->getOption('dependentField');

		if( is_null($dependentField) ) {
			throw new WikiaValidatorDependentFieldEmptyException('WikiaValidatorDepend: dependent field is empty');
		}

		if( is_null($ownValidator) || !($ownValidator instanceof WikiaValidator) ) {
			throw new WikiaValidatorGivenObjectIsNotWikiaValidator('WikiaValidatorDepend: own validator is not an instance of WikiaValidator');
		}

		$dependentFieldValue = (isset($this->formData[$dependentField]) ? $this->formData[$dependentField] : null);
		
		if( $this->isDependentFieldValid($dependentFieldValue) && !$ownValidator->isValid($value) ) {
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
	
	protected function isDependentFieldValid($dependentFieldValue) {
		$validationCondition = $this->getOption('dependentFieldCondition');
		switch($validationCondition) {
			case self::CONDITION_EMPTY:
				return empty($dependentFieldValue);
				break;
			case self::CONDITION_NOT_EMPTY:
				return !empty($dependentFieldValue);
				break;
		}
	}

}
