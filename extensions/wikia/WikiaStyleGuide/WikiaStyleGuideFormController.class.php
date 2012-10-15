<?php
class WikiaStyleGuideFormController extends WikiaController {

	/**
	 * $form: An array containing the structure for the form.
	 */
	public function index() {
		$this->form = $this->request->getVal( 'form', array() );
	}
}