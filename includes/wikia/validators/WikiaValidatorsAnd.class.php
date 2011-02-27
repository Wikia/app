<?php

class WikiaValidatorsAnd extends  WikiaValidator
{

	protected function config( array $options = array() ) {
		$this->setOption( 'validators' , array());
		$this->setOption( "required", true );
	}
	
	protected function configMsgs( array $msgs = array() ) {
		
	}

	public function isValidInternal($value = null) {
		$errors = array();
		foreach($this->getOption('validators') as $key => $validator) {
			if(!$this->isWikiaValidator( $validator ) ) {
				throw new Exception( 'WikiaValidatorsAnd: one of validators is not implements of WikiaValidator' );
			}
			
			if(!$validator->isValid( $value )) {
				if(is_array($validator->getError())) {
					$errors = $this->arrayMergeHelper($validator->getError(),  $errors );	
				} else {
					$errors[] = $validator->getError();
				}
			}
		}
		
		
		
		if( count($errors) > 0 ) {
			$this->setError( $errors );
			return false;			
		}
		
		return true;
	}
}