<?php

class WikiaValidatorDepend extends WikiaValidator {

	protected function config( array $options = array() ) {
		$this->setOption('ownValidator', 0);
		$this->setOption('dependencyField', 0);
	}

	public function isValidInternal($value = null, $formFields = null) {
		$ownValidator = $this->getOption('ownValidator');
		$dependencyField = $this->getOption('dependencyField');

		if( $dependencyField === 0 ) {
			throw new Exception( 'WikiaValidatorDepend: $dependencyField is empty' );
		}

		if( $ownValidator === 0 || !($ownValidator instanceof WikiaValidator) ) {
			throw new Exception( 'WikiaValidatorDepend: $ownValidator is not an instance of WikiaValidator' );
		}

		if( isset($formFields[$dependencyField]['validator']) &&
			$formFields[$dependencyField]['validator'] instanceof WikiaValidator &&
			!$formFields[$dependencyField]['validator']->isValid($formFields[$dependencyField]['formValue'])
		) {
			$this->setError( $formFields[$dependencyField]['validator']->getError() );
			return false;

			if( !$ownValidator->isValid($value) ) {
				$this->setError( $ownValidator->getError() );
				return false;
			}
		}

		return true;
	}

	public function isValid($value = null, $formFields = null) {
	//we skip here validation of $value because it should be validated only after the dependencyField is valid
		$this->error = null;
		return $this->isValidInternal($value, $formFields);
	}

}
