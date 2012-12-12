<?php

class WikiaValidatorDepend extends WikiaValidator {
	protected $formFields = array();
	protected $formData = array();

	protected function config( array $options = array() ) {
		$this->setOption('ownValidator', 0);
		$this->setOption('dependencyField', 0);
	}

	public function setFormData($data) {
		$this->formData = $data;
	}

	public function setFormFields($fields) {
		$this->formFields = $fields;
	}

	public function isValidInternal($value = null, $formData = null, $formFields = null) {
		$ownValidator = $this->getOption('ownValidator');
		$dependencyField = $this->getOption('dependencyField');

		if( $dependencyField === 0 ) {
			throw new Exception( 'WikiaValidatorDepend: $dependencyField is empty' );
		}

		if( $ownValidator === 0 || !($ownValidator instanceof WikiaValidator) ) {
			throw new Exception( 'WikiaValidatorDepend: $ownValidator is not an instance of WikiaValidator' );
		}

		$dependencyFieldValue = (isset($this->formData[$dependencyField]) ? $this->formData[$dependencyField] : null);

		if( !empty($dependencyFieldValue) && !$ownValidator->isValid($value) ) {
			$this->setError( $ownValidator->getError() );
			return false;
		}

		return true;
	}

	public function isValid($value) {
	//skip here validation of $value because it should be validated only after the dependencyField is valid
		$this->error = null;
		return $this->isValidInternal($value);
	}

}
