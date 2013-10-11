<?php
class ExampleForm2 extends BaseForm {
	protected $id = 'testId2';
	protected $method = 'post';

	public function __construct() {
		parent::__construct();

		// subject input field with label and validation
		$this->addField( 'contactFormSubject', new InputField(
			[
				'label' => new Label( wfMessage( 'example-form-subject' ) ),
				'validator' => new WikiaValidatorString()
			]
		) );
	}

}
