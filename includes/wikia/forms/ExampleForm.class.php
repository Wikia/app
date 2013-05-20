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
	}
}