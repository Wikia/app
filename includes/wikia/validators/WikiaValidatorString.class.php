<?php 

class WikiaValidatorString extends WikiaValidator {
	
	protected function config( array $options = array() ) {
		$this->setOption('min', 0);
		$this->setOption('max', 0);			
	}
	
	protected function configMsgs( array $msgs = array() ) {
		$this->setMsg( 'too_short', 'wikia-validator-string-short' );
		$this->setMsg( 'too_long', 'wikia-validator-string-long' );		
	}
	
	public function isValidInternal($value = null) {		
		if(strlen($value) < $this->getOption('min') ) {
			$this->createError( 'too_short' );
			return false;
		}
		
		if(( $this->getOption('max') != 0 ) && (strlen($value) >  $this->getOption('max') )) {
			$this->createError( 'too_long' );
			return false;
		}
		return true;
	}
}
