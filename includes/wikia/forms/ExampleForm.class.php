<?
class ExampleForm extends BaseForm {
	public function __construct() {
		parent::__construct();

		$this->addField('fieldName', new FormTextField(), new WikiaValidatorString());
		$this->addField('fieldName2', new FormTextField(), new WikiaValidatorInteger());
		$this->addField('fieldName3', new FormTextField());
	}
}