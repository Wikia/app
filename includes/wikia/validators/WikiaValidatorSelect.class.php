<?php 

class WikiaValidatorSelect extends  WikiaValidator {
	
	protected function config( array $options = array() ) {
		$this->setOption('allowed', array() );		
	}
	
	protected function configMsgs( array $msgs = array() ) {
		$this->setMsg( 'not_allowed_value', 'wikia-validator-not-allowed-value' );		
	}
	
	public function isValidInternal($value = null) {
		$this->error = array();
		if(!in_array ( $value , $this->getOption('allowed')) ) {
			$this->createError( 'not_allowed_value' );
			return false;
		}
		return true;
	}
}
