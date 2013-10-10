<?php
class ExampleForm extends BaseForm {
	// define form attributes
	protected $action = 'test/action.php';
	protected $id = 'testId';
	protected $method = 'post';

	public function __construct() {
		parent::__construct();

		//////////////////////////////
		// An example of contact form
		//////////////////////////////

		// subject input field with label and validation
		$this->addField( 'contactFormSubject', new TextField(
			[
				'label' => new Label( wfMessage( 'example-form-subject' ) ),
				'validator' => new WikiaValidatorString()
			]
		) );

		// message textarea with label and validation
		$this->addField( 'contactFormMessage', new TextareaField(
			[
				'label' => new Label( wfMessage( 'example-form-message' ) ),
				'validator' => new WikiaValidatorString(),
			]
		) );

		// format of e-mail body
		$this->addField( 'contactFormMailFormat', new SelectField( [
			'label' => new Label( wfMessage('example-form-mail-format') ),
			'choices' => [
				[ 'value' => '1', 'option' => wfMessage( 'example-form-plain-text' ) ],
				[ 'value' => '2', 'option' => wfMessage( 'example-form-html' ) ]
			]
		] ) );

		// radio button input field with a label (if read terms of use)
		$this->addField( 'contactFormTermsOfUse', new RadioField(
			[
				'type' => 'radio',
				'label' => new Label( wfMessage( 'example-form-did-read-terms' ) ),
				'choices' => [
					[ 'label' => new Label( wfMessage('example-form-yes') ), 'value' => '1' ],
					[ 'label' => new Label( wfMessage('example-form-no') ), 'value' => '0' ],
				]
			]
		) );

		// checkbox input field with a label (if send a copy)
		$this->addField( 'contactFormSendCopy', new InputField(
			[
				'type' => 'checkbox',
				'checked' => 'checked',
				'label' => new Label( wfMessage( 'example-form-send-me-a-copy' ) )
			]
		) );

		// password input field with a label (if send a copy)
		$this->addField( 'contactFormPassword', new InputField(
			[
				'type' => 'password',
				'label' => new Label( wfMessage( 'example-form-password' ) )
			]
		) );

		// hidden input field
		$this->addField( 'contactFormSessionId', new InputField( [ 'type' => 'hidden' ] ) );

		$this->addField( 'contactFormSubmit', new InputField(
			[
				'type' => 'submit',
				'value' => wfMessage( 'example-form-submit' )->text()
			]
		) );

		//////////////////
		// OTHER EXAMPLES
		//////////////////

		// Add default field - it's TextField
		$this->addField( 'defaultField' );

		$this->addField( 'fieldName7', new RadioField() );
		$this->addField( 'fieldName8', new RadioField( ['label' => new Label( wfMessage( 'example-form-radio-button' ) ) ] ) );
		$this->addField( 'fieldName9', new RadioField( [
			'label' => new Label( wfMessage('example-forms-radio-buttons') ),
			'choices' => [
				[ 'label' => new Label( wfMessage('example-form-A') ), 'value' => 'Option 1' ],
				[ 'label' => new Label( wfMessage('example-form-B') ), 'value' => 'Option 2' ],
				[ 'value' => 'Option 3' ],
			],
		] ) );

		// add collection type field with validators
		$this->addField( 'collectionField', new CollectionTextField( [
			'label' => new Label( wfMessage( 'example-form-collection' ) ),
			'validator' => new WikiaValidatorListValue( [
				'validator' => new WikiaValidatorInteger(
					[ 'required' => true ],
					[ 'not_int' => 'example-form-not-an-integer' ]
				)
			] )
		] ) );

	}
}
