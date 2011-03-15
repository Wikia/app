<?php

class WVE extends SpecialPage {
 	
	function __construct() {
		wfLoadExtensionMessages( 'WVE' );
		$this->app = WF::build( 'App' );

		$this->out = $this->app->getGlobal('wgOut');
		$this->request = $this->app->getGlobal('wgRequest');
		$this->title = $this->app->getGlobal('wgTitle');
		parent::__construct( 'WVE', '' );
	}
	
	
	function execute() {
		global $wgRequest;
		
		if( $wgRequest->getVal('action') == 'normal' ) {
			$this->executeNormal();
			return ;
		}
		
		if( $wgRequest->getVal('action') == 'simple' ) {
			$this->executeSimple();
			return ;
		}
		
		$this->executeHtmlForm();
	}
		
	function executeSimple() {
		
		$oTmpl = WF::build( 'EasyTemplate', array( dirname( __FILE__ ) . "/templates/" ) );
		$this->out->addHTML( $oTmpl->render("simple") );

		$vs = new WikiaValidatorsSet();
		$vs->addValidator( 'name', new WikiaValidatorString(
			array( 
				'min' => 5, 
				'max' => 10,
				'required' => true, 
			),
			array( 
				
			)
		));
		
		$vs->addValidator( 'age', new WikiaValidatorInteger(
			array( 
				'min' => 5, 
				'max' => 10,
				'required' => true, 
			) 
		));
		
		$vs->addValidator( 'mail', new WikiaValidatorsAnd(array(
			'validators' => array( 
					new WikiaValidatorMail( array( 'required' => true ) ), 
					new WikiaValidatorString( array( 'required' => true , 'min' => 5, 'max' => 100 ) ) 
			)
		)));

		if($this->request->wasPosted( )) {
			$form =	$this->request->getArray("form"); 
			$vs->isValid( $form );	
			
			var_dump($vs->getErrors());		
			var_dump($vs->getErrorsFlat());	
		}
	
	}
	
	function executeHtmlForm( ) {
		$languages = array('en' => 'en', 'pl' => 'pl');
		$fields = array(
			'text' => array(
				'class' => 'HTMLTextField',
				'label-message' => 'info-text',
				'validator' => new WikiaValidatorString( array( 
									'min' => 5, 
									'max' => 10,
									'required' => true ))
			),
			'age' => array(
				'class' => 'HTMLTextField',
				'label-message' => 'info-age',
				'validator' => new WikiaValidatorInteger( array( 
								'min' => 21, 
								'max' => 100,
								'required' => true, )) 
			),
			'lang' => array(
				'class' => 'HTMLSelectField',
				'label-message' => 'info-languages',
				'options' => $languages,
				'validator' => new WikiaValidatorSelect( array(
									'allowed' => array_keys($languages) ))
			),
		);
		
		$vs = new WikiaValidatorsSet();
		$vs->addValidatorsFromHTMLformFields($fields);
		
		$form = new HTMLForm($fields);
		$form->setTitle($this->title);
		$form->setSubmitText($this->app->runFunction('wfMsg', 'spellchecker-info-spellcheck-submit'));
		$form->loadData();
		$form->displayForm('htmlform');
		
		if($this->request->wasPosted( )) {
			$vs->isValid( $form );
			
			var_dump($vs->getErrors());		
			var_dump($vs->getErrorsFlat());		
		}
	}
	
	function executeNormal( ) {
		global $wgOut,$wgRequest, $firephp; 
		
		$firephp =& FirePHP::getInstance(true);
		
		$oTmpl = WF::build( 'EasyTemplate', array( dirname( __FILE__ ) . "/templates/" ) );
		$wgOut->addHTML( $oTmpl->render("test") );

		$vs = new WikiaValidatorsSet();
		
		$vs->addValidator('name', new WikiaValidatorString(
			array( 
				'min' => 5, 
				'max' => 10,
				'required' => true, 
			), array(
				'too_long' => 'msg-key' // $value to long must be $min
			);
		));
		
		
		
		$password = new WikiaValidatorsAnd(array(
			'validators' => array(
				new WikiaValidatorString( array( 'required' => true, 'min' => 5, 'max' => 10 ) ),
					new WikiaValidatorString( array( 'required' => true, 'min' => 5, 'max' => 10 ) )
		)));
		
		$vs->addValidator('password1', $password);
		$vs->addValidator('password2', $password);
		
		$comparePassword = new WikiaValidatorCompare( array('expression' => '==') );
		
		$vs->addValidator('password1', $comparePassword, array('password1', 'password2') );
		
		$mail = new WikiaValidatorListValue();
		
		$mail->setValidator( new WikiaValidatorsAnd( array(
			'validators' => array( new WikiaValidatorMail(), new WikiaValidatorString( array( 'required' => true, 'min' => 5, 'max' => 10 ) ) )
		)));
		
		$vs->addValidator( 'mail', $mail );
		
		$married = new WikiaValidatorSelect( array(
			'allowed' => array('yes', 'no')
		));
		
		$vs->addValidator('married', $married );
		
		$wife_name = new WikiaValidatorCompareValueIF( array( 
			'value' => "yes",
			'validator'  =>  new WikiaValidatorString( array( 
						'min' => 5, 
						'max' => 10,
						'required' => true, 
			))
		));
		
		$vs->addValidator('wife_name', $wife_name, array( 'married', 'wife_name' ) );
		
		$form =	$wgRequest->getArray("form"); 

		$vs->reAjax("hjhjdshjdshjsd");

		if($wgRequest->wasPosted( )) {
			$vs->isValid( $form );
			var_dump($vs->getErrors());		
			var_dump($vs->getErrorsFlat());			
		}
		
	}
	
}
