<?
class ExampleForm extends BaseForm {
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
	}
}