<?
class ExampleForm extends BaseForm {
	// define form attributes
	protected $action = 'test/action.php';
	protected $id = 'testId';
	protected $method = 'post';

	public function __construct() {
		parent::__construct();

		// Add default field - it's TextField
		$this->addField('defaultField');

		// add field with validation and label
		$this->addField('fieldName', new TextField(
			[
				'label' => new Label(wfMessage('aaa')),
				'validator' => new WikiaValidatorString()
			]
		));
		// add another field
		$this->addField('fieldName2', new TextField(
			[
				'label' => new Label(wfMessage('bbb')),
				'validator' => new WikiaValidatorInteger()
			]
		));
		// other type of fields
		$this->addField('fieldName3', new PasswordField());
		$this->addField('fieldName4', new CheckboxField());
		$this->addField('fieldName5', new HiddenField());
		$this->addField('fieldName6', new TextareaField());

		$this->addField('fieldName7', new RadioField());
		$this->addField('fieldName8', new RadioField(['label' => new Label(wfMessage('radio-button'))]));
		$this->addField('fieldName9', new RadioField([
			'label' => new Label( wfMessage('radio-buttons') ),
			'choices' => [
				['label' => new Label(wfMessage('A')), 'value' => 'Option 1'],
				['label' => new Label(wfMessage('B')), 'value' => 'Option 2'],
				['value' => 'Option 3'],
			],
		]));

		$this->addField('fieldName10', new SelectField([
			'label' => new Label(wfMessage('select-field')),
			'choices' => [
				['value' => '1', 'option' => 'value 1'],
				['value' => '2', 'option' => 'value 2']
			]
		]));

		// add collection type field with validators
		$this->addField('collectionField', new CollectionTextField(
			[
				'label' => new Label(wfMessage('aaa')),
				'validator' => new WikiaValidatorListValue(
					array(
						'validator' => new WikiaValidatorInteger(
							array(
								'required' => true
							),
							array('not_int' => 'message key here')
						)
					)
				)
			]
		));

		// add submit
		$this->addField('submitButton', new SubmitButton([
			'value' => wfMessage('some-key-here')->text()
		]));
	}
}
