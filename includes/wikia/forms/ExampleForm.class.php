<?
class ExampleForm extends BaseForm {
	protected $action = 'test/action.php';
	protected $id = 'testId';
	protected $method = 'post';

	public function __construct() {
		parent::__construct();

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
		$this->addField('fieldName8', new RadioField(['label' => wfMessage('radio-button')]));
		$this->addField('fieldName9', new RadioField([
			'label' => new Label( wfMessage('radio-buttons') ),
			'choices' => [
				['label' => wfMessage('A'), 'value' => 'Option 1'],
				['label' => wfMessage('B'), 'value' => 'Option 2'],
				['value' => 'Option 3'],
			],
		]));
	}
}
