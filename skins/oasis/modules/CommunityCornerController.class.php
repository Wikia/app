<?php

class CommunityCornerController extends WikiaController {

	public function executeIndex() {
		wfProfileIn(__METHOD__);

		// add CSS for this module
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL("skins/oasis/css/modules/CommunityCorner.scss"));

		$this->isAdmin = $this->wg->User->isAllowed('editinterface');

		wfProfileOut(__METHOD__);
	}

}