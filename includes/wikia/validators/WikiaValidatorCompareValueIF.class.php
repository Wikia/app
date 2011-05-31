<?php 
class WikiaValidatorCompareValueIF extends WikiaValidatorCompare {
	const NOT_EMPTY_VALUE = 'not_empty';
	const EMPTY_VALUE = 'empty';
	
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
		
		if( in_array($expression, array(self::NOT_EMPTY_VALUE, self::EMPTY_VALUE) )) {
			$valid = self::NOT_EMPTY_VALUE === $expression ? !empty($value[0]) : empty($value[0]);
		} else {
			$valid = $this->doCompare( $expression, $value[0],  $this->getOption( 'value' ) );
		}
		
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

