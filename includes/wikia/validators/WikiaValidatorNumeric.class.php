<?php 

class WikiaValidatorNumeric extends WikiaValidator {
	
	protected function config( array $options = array() ) {
		$this->setOption('min', null);
		$this->setOption('max', null);
	}
	
	protected function configMsgs( array $msgs = array() ) {
		$this->setMsg( 'too_small', 'wikia-validator-numeric-too-small' );
		$this->setMsg( 'too_big', 'wikia-validator-numeric-too-big' );
		$this->setMsg( 'not_numeric', 'wikia-validator-numeric-not-numeric' );		
	}
	
	public function isValidInternal($value = null) {	
		
		if( !is_numeric($value) ) {
			$this->createError( 'not_numeric' );
			return false;
		}
		
		if($this->getOption('min') !== null && $value < $this->getOption('min')) {
			$this->createError( 'too_small' );
			return false;
		}
		
		if($this->getOption('max') !== null && $value > $this->getOption('max')) {
			$this->createError( 'too_big' );
			return false;
		}
		return true;
	}
}
