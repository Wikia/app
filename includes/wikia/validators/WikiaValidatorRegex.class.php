<?php 

class WikiaValidatorRegex extends WikiaValidator {
	
	protected function config( array $options = array() ) {
		$this->setOption('pattern', '\s*');		
	}
	
	protected function configMsgs( array $msgs = array() ) {
		$this->setMsg( 'wrong', 'wikia-validator-regex-wrong' );		
	}
	
	public function isValidInternal($value = null) {
		$pattern = $this->getOption('pattern'); 
		 		
		if( !preg_match($pattern, $value) ) {
			$this->createError( 'wrong' );
			return false;
		}
		
		return true;
	}
}