<?
class ExampleForm extends BaseForm {
	protected $action = 'test/action.php';
	protected $id = 'testId';
	protected $method = 'post';

	public function __construct() {
		parent::__construct();

		$this->addField('defaultField');

		$this->addField('fieldName', new TextField(
			[
				'label' => new Label(wfMessage('aaa')),
				'validator' => new WikiaValidatorString()
			]
		));
		$this->addField('fieldName2', new TextField(
			[
				'label' => new Label(wfMessage('bbb')),
				'validator' => new WikiaValidatorInteger()
			]
		));
		$this->addField('fieldName3', new PasswordField());
		$this->addField('fieldName4', new CheckboxField());
		$this->addField('fieldName5', new HiddenField());
		$this->addField('fieldName6', new TextareaField());
		$this->addField('collectionField', new CollectionTextField(
			[
				'label' => new Label(wfMessage('aaa')),
				'validator' => new WikiaValidatorListValue(
					array(
						'validator' => new WikiaValidatorFileTitle(
							array(
								'required' => true
							),
							array('wrong-file' => 'marketing-toolbox-validator-wrong-file')
						)
					)
				)
			]
		));
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
		$this->getField('fieldName10')->setValue('2');
		$this->addField('submitButton', new SubmitButton());
	}
}
