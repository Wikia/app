<?php

class WikiaValidatorListUnique extends  WikiaValidatorListBase
{
	protected function config( array $options = array() ) {
		$this->setOption( 'required', true );
	}

	protected function configMsgs( array $msgs = array() ) {

	}

	public function isValidInternal($value = null) {
		$this->error = array();

		if(!is_array($value)) {
			throw new Exception( 'WikiaValidatorsArray: value need to be array' );
		}

		$validator = $this->getOption( 'validator' );

		if(!$this->isWikiaValidator( $validator )) {
			throw new Exception( 'WikiaValidatorsArray: validator is not WikiaValidator' );
		}

		foreach($value as $key => $subvalue) {
			if(!$validator->isValid( $subvalue )){
				$this->addError($key, $validator->getError());
			}
		}

		return empty($this->error);
	}
}
