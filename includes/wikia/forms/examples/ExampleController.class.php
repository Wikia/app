<?
class ExampleController extends WikiaSpecialPageController {
	public function index() {
		// create form instance and pass it into view
		$this->form = new ExampleForm();

		$vals = [
			'fieldName' => 'a',
			'fieldName2' => 'b',
			'collectionField' => [1, 2, 3],
			'fieldName9' => 'Option 2',
			'fieldName10' => 2
		];

		// validate form values (they can be taken from $_POST or $_GET or other source)
		$this->form->validate($vals);

		// set fields values that should be displayed in form
		$this->form->setFieldsValues($vals);
	}
}