<?
class ExampleFormController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct( 'ExampleForm', '', false );
	}

	public function index() {
		// create form instance and pass it into view
		$this->form = new ExampleForm();

		$this->form2 = new ExampleForm2();

		$vals = [
			'contactFormSubject' => 'Example subject',
			'contactFormMessage' => 'Example message',
			'contactFormSendCopy' => 1,
			'contactFormSessionId' => md5( 'random-session-key' ),
		];

		// validate form values (they can be taken from $_POST or $_GET or other source)
		if ($this->request->wasPosted() && $this->form->validate($vals)) {
			//save data && redirect
		}
		// else render form with error messages

		// set fields values that should be displayed in form
		$this->form->setFieldsValues($vals);
	}
}