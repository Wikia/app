<?php

class GameGuidesSpecialController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct('GameGuidesPreview', '', false /* $listed */);
	}

	public function index() {
		$titleText = $this->getPar();

		$this->setVal( 'url', $this->wg->Server .'/wikia.php?allinone=1&controller=GameGuidesController&method=renderPage&title=' . $titleText );
	}

}
