<?php 

class WikiaValidatorCompareValue extends WikiaValidatorCompare {
	protected function configMsgs( array $msgs = array() ) {
		$this->setMsg( 'compare_fail', 'wikia-validator-compare-value-fail' );		
	}
	
	protected function config( array $options = array() ) {
		$this->setOption( 'expression', '==' );	
		$this->setOption( 'value', '' );	
	}
	
	public function isValidInternal($value = null) {
		$expression = $this->getOption( 'expression' );
		
		$value = array_values( $value );
		
		if (is_array( $value ) && count( $value ) != 2 ) {
			$this->throwException( 'WikiaValidatorCompare: value need to be array with two elements' );
		}

		$valid = $this->doCompare( $expression, $value, $this->getOption('value' ) );
		
		if(!$valid) {
			$this->createError( 'compare_fail' );
			return false;			
		}
		
		return true;
	}
}