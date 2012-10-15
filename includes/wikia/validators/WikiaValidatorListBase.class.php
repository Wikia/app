<?php
abstract class WikiaValidatorListBase extends WikiaValidator
{
	protected function isValidListElement( $key, $value ) {
		return false;
	}

	public function isValidInternal($value = null) {
		$this->error = array();

		if(!is_array($value)) {
			throw new Exception( 'WikiaValidatorsListBase: value need to be array' );
		}

		foreach($value as $key => $subvalue) {
			$this->isValidListElement( $key, $subvalue );
		}

		return empty($this->error);
	}


	protected function addError($key, $error) {
		if(empty($this->error[$key]) || !is_array($this->error[$key])) {
			$this->error[$key] = array();
		}

		if(is_array($error)) {
			$this->error[$key] = $this->arrayMergeHelper($this->error[$key], $error);
			return ;
		}

		$this->error[$key][] = $error;
	}
}

