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

		//http://fallout.jolek.wikia-dev.com/wikia.php?controller=AssetsManager&method=getMultiTypePackage&scripts=gameguides_js&styles=//extensions/wikia/GameGuides/css/GameGuides.scss

		$this->setVal( 'url', $this->wg->Server .'/wikia.php?allinone=1&controller=GameGuidesController&method=renderFullPage&title=' . $titleText );
		return true;
	}

}
