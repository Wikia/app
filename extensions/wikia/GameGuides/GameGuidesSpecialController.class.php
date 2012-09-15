<?php

class GameGuidesSpecialController extends WikiaSpecialPageController {
	public function __construct() {
		parent::__construct('GameGuidesPreview', '', false);
	}

	public function index() {
		if (!$this->wg->User->isAllowed('gameguidespreview')) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}

		$titleText = $this->getPar();

		$this->setVal( 'url', $this->wg->Server .'/wikia.php?allinone=1&controller=GameGuidesController&method=renderPage&title=' . $titleText );
	}

}
