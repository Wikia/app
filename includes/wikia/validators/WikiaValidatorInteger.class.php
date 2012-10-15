<?php 

class WikiaValidatorInteger extends WikiaValidatorNumeric {

	protected function configMsgs( array $msgs = array() ) {
		$this->setMsg( 'not_int', 'wikia-validator-integer-not_int' );		
		parent::configMsgs( $msgs );
	}
	
	public function isValidInternal($value = null) {	
		if(!is_numeric($value) || ((int) $value) != $value  ) {
			$this->createError( 'not_int' );
			return false;
		}
		return parent::isValidInternal($value);
	}
	
}