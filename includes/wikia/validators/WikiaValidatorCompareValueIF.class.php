<?php
class WikiaValidatorCompareValueIF extends WikiaValidatorCompare {

	protected function config( array $options = array() ) {
		$this->setOption( 'value', true );
		$this->setOption( 'validator', false );
		return parent::config();
	}

	protected function configMsgs( array $msgs = array() ) {
		$this->setMsg( 'compare_fail', 'wikia-validator-compare-value-if-fail' );
	}

	public function isValidInternal($value = null) {
		$expression = $this->getOption( 'expression' );
		$value = array_values( $value );

		if (is_array( $value ) && count( $value ) != 2 ) {
			$this->throwException( 'WikiaValidatorCompareValueIF: passed value need to be an array with two elements' );
		}

		$valid = $this->doCompare( $expression, $value[0],  $this->getOption( 'value' ) );

		$validator =  $this->getOption( 'validator' );

		if( ($valid) && $validator != false ) {
			if( !$validator->isValid($value[1]) ) {
				$this->setError( $validator->getError() ); //$this->createError( 'compare_fail' );
				return false;
			}
		}

		return true;
	}

}

