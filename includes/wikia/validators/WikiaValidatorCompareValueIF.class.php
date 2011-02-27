<?php 

class WikiaValidatorCompareValueIF extends WikiaValidatorCompare {
	const EQUAL      = '==';
	const NOT_EQUAL  = '!=';
	const LESS_THAN  = '<';
	const LESS_THAN_EQUAL    = '<=';
	const GREATER_THAN       = '>';
	const GREATER_THAN_EQUAL = '>=';
	
	protected function config( array $options = array() ) {	
		$this->setOption( 'value', true );
		$this->setOption( 'validator', false );
		return parent::config();	
	}
	
	public function isValidInternal($value = null) {
		$expression = $this->getOption( 'expression' );
		$value = array_values( $value );
		
		if (is_array( $value ) && count( $value ) != 2 ) {
			$this->throwException( 'WikiaValidatorCompareValueIF: value need to be array with two elements' );
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

