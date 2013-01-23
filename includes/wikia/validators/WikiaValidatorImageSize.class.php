<?php
class WikiaValidatorImageSize extends WikiaValidatorFileTitle {
	
	protected function configMsgs( array $msgs = array() ) {
		parent::configMsgs($msgs);
		$this->setMsg( 'wrong-width', 'wrong-height' );
	}
	
	public function isValidInternal($value = null) {
		if( !parent::isValidInternal($value) ) {
			return false;
		}
		
		return true;
	}
	
}
