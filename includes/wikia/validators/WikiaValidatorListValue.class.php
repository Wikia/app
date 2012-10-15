<?php

class WikiaValidatorListValue extends  WikiaValidatorListBase
{
	protected function config( array $options = array() ) {
		$this->setOption( 'validator' , null);
		$this->setOption( 'required', true );
	}
	
	protected function configMsgs( array $msgs = array() ) {
		
	}
	
	protected function isValidListElement( $key, $value ) {
		$validator = $this->getOption( 'validator' );
		
		if(!$this->isWikiaValidator( $validator )) {
			throw new Exception( 'WikiaValidatorsList: validator is not WikiaValidator' );
		}

		if(!$validator->isValid( $value )){
			$this->addError($key, $validator->getError());
			//$this->error[] =  ;
		}

		return ;
	}

	public function setValidator( WikiaValidator $validator ) {
		$this->setOption( 'validator' , $validator); 
	}
	
}