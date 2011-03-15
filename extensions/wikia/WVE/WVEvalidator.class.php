<?php

class MyFormValidatorExample extends  WikiaValidatorsSet
{
	protected function config( array $options = array() ) {
		parent::config( $options );
		
		$this->addValidator('name', new WikiaValidatorString(
			array( 
				'min' => 5, 
				'max' => 10,
				'required' => true, 
			) 
		));
		
		$password = new WikiaValidatorsAnd(array(
			'validators' => array(
				new WikiaValidatorString( array( 'required' => true, 'min' => 5, 'max' => 10 ) )
		)));
		
		$this->addValidator('password1', $password);
		$this->addValidator('password2', $password);
		
		$comparePassword = new WikiaValidatorCompare( array('expression' => '==') );
		
		$this->addValidator('password1', $comparePassword, array('password1', 'password2') );
		
		$mail = new WikiaValidatorListValue();
		$mail->setValidator( new WikiaValidatorsAnd(array(
			'validators' => array( new WikiaValidatorMail(), new WikiaValidatorString( array( 'required' => true, 'min' => 5, 'max' => 10 ) ) )
		)));
		
		$this->addValidator( 'mail', $mail );

		
		$married = new WikiaValidatorSelect( array(
			'allowed' => array('yes', 'no')
		));
		
		$this->addValidator('married', $married );
		
		$wife_name = new WikiaValidatorCompareValueIF( array( 
			'value' => "yes",
			'validator'  =>  new WikiaValidatorString( array( 
						'min' => 5, 
						'max' => 10,
						'required' => true, 
			))
		));
		
		$this->addValidator('wife_name', $wife_name, array( 'married', 'wife_name' ) );
	}
}